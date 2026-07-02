<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixNullInvoicePayments extends Command
{
    protected $signature = 'hean:fix-null-invoice-payments';
    protected $description = 'Link payments without invoice_id to an existing or new invoice';

    public function handle()
    {
        $payments = Payment::whereNull('invoice_id')->get();

        if ($payments->isEmpty()) {
            $this->info('No payments with null invoice_id found.');
            return;
        }

        $this->info("Found {$payments->count()} payments with null invoice_id.");

        DB::transaction(function () use ($payments) {
            foreach ($payments as $payment) {
                $registration = Registration::find($payment->registration_id);
                if (!$registration) {
                    $this->warn("Payment ID {$payment->id} has invalid registration_id, skipping.");
                    continue;
                }

                // पहिले सोही registration को कुनै invoice छ कि?
                $invoice = Invoice::where('registration_id', $registration->id)->first();

                if (!$invoice) {
                    // नयाँ invoice बनाउने
                    $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT);
                    $invoice = Invoice::create([
                        'registration_id' => $registration->id,
                        'invoice_number' => $invoiceNumber,
                        'amount' => $payment->amount,
                        'issued_date' => $payment->payment_date ?? now(),
                        'due_date' => ($payment->payment_date ? $payment->payment_date->addDays(30) : now()->addDays(30)),
                        'status' => ($payment->status === 'verified') ? 'paid' : 'pending',
                        'invoice_type' => 'manual_migration',
                        'pdf_path' => null,
                    ]);
                    $this->info("Created new invoice {$invoice->id} for registration {$registration->id}");
                }

                // Payment लाई invoice मा link गर्ने
                $payment->invoice_id = $invoice->id;
                $payment->save();
                $this->info("Linked payment {$payment->id} to invoice {$invoice->id}");
            }
        });

        $this->info('All payments fixed. Now you can run the migration to make invoice_id NOT NULL.');
    }
}