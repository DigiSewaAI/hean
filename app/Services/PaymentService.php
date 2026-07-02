<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Verify a payment, generate receipt, update invoice, activate registration.
     */
    public function verifyPayment(Payment $payment, int $verifiedByUserId): void
    {
        DB::transaction(function () use ($payment, $verifiedByUserId) {
            $payment->markVerified($verifiedByUserId);
            $this->generateReceipt($payment);
            $invoice = $payment->invoice;
            $this->updateInvoiceStatus($invoice);
            if ($invoice->status === 'paid') {
                app(RegistrationService::class)->activateFromInvoice($invoice);
            }
        });
    }

    /**
     * Generate receipt for a verified payment.
     * ✅ FIXED: Pass $receipt object to view.
     */
    public function generateReceipt(Payment $payment): Receipt
    {
        // 1. Generate receipt number
        $receiptNumber = $this->generateReceiptNumber();

        // 2. Create receipt record first (so we have an ID and dates)
        $receipt = Receipt::create([
            'payment_id' => $payment->id,
            'receipt_number' => $receiptNumber,
            'amount' => $payment->amount,
            'issued_date' => now(),
            'pdf_path' => null,
            'remarks' => $payment->remarks ?? null,
        ]);

        // 3. Generate PDF using the receipt object
        $html = view('admin.receipts.pdf', compact('receipt', 'payment'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        // 4. Save PDF
        $path = 'receipts/receipt_' . uniqid() . '.pdf';
        Storage::disk('public')->put($path, $pdfContent);

        // 5. Update receipt with PDF path
        $receipt->update(['pdf_path' => $path]);

        Log::info('Receipt generated: ' . $receipt->receipt_number);
        return $receipt;
    }

    protected function generateReceiptNumber(): string
    {
        $year = date('Y');
        $last = Receipt::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $num = $last ? (int)substr($last->receipt_number, -6) + 1 : 1;
        return 'RCP-' . $year . '-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Update invoice status based on total verified payments.
     */
    public function updateInvoiceStatus(Invoice $invoice): void
    {
        $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
        if ($totalPaid >= $invoice->amount) {
            $invoice->status = 'paid';
        } elseif ($totalPaid > 0) {
            $invoice->status = 'partial';
        } else {
            $invoice->status = 'pending';
        }
        // overdue check
        if ($invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid') {
            $invoice->status = 'overdue';
        }
        $invoice->save();
    }
}