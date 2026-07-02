<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class RegenerateInvoicePdfs extends Command
{
    protected $signature = 'regenerate:invoices';
    protected $description = 'Regenerate PDFs for all invoices that are missing their PDF file';

    public function handle()
    {
        $invoices = Invoice::whereNotNull('pdf_path')->get();
        $count = 0;

        foreach ($invoices as $invoice) {
            // Check if PDF exists
            if (Storage::disk('public')->exists($invoice->pdf_path)) {
                continue; // Already exists, skip
            }

            $this->info("Regenerating PDF for invoice {$invoice->id}...");

            $registration = $invoice->registration;
            if (!$registration) {
                $this->warn("Invoice {$invoice->id} has no registration, skipping.");
                continue;
            }

            $data = [
                'registration' => $registration,
                'invoiceNumber' => $invoice->invoice_number,
                'request' => (object) [
                    'amount' => $invoice->amount,
                    'due_date' => $invoice->due_date,
                ]
            ];

            $html = view('pdf.invoice', $data)->render();
            $mpdf = new Mpdf();
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', 'S');

            Storage::disk('public')->put($invoice->pdf_path, $pdfContent);
            $count++;
        }

        $this->info("Done! Regenerated {$count} PDFs.");
    }
}