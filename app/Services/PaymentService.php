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
     */
    public function generateReceipt(Payment $payment): Receipt
    {
        // Check if receipt already exists for this payment
        $existingReceipt = Receipt::where('payment_id', $payment->id)->first();
        if ($existingReceipt) {
            \Log::info('Receipt already exists for payment: ' . $payment->id . ' - ' . $existingReceipt->receipt_number);
            return $existingReceipt;
        }

        // 1. Generate receipt number
        $receiptNumber = $this->generateReceiptNumber();

        // 2. Create receipt record
        $receipt = Receipt::create([
            'payment_id' => $payment->id,
            'receipt_number' => $receiptNumber,
            'amount' => $payment->amount,
            'issued_date' => now(),
            'pdf_path' => null,
            'remarks' => $this->generateReceiptRemarks($payment),
        ]);

        // 3. Generate PDF
        $html = view('admin.receipts.pdf', compact('receipt', 'payment'))->render();

        $tempDir = storage_path('app/mpdf');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'default_font_size' => 12,
            'default_font' => 'notosansdevanagari',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'tempDir' => $tempDir,
        ]);

        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
            $mpdf->showWatermarkImage = true;
        }

        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        // Ensure receipts directory exists
        if (!Storage::disk('public')->exists('receipts')) {
            Storage::disk('public')->makeDirectory('receipts', 0755, true);
        }

        // 4. Save PDF
        $path = 'receipts/receipt_' . uniqid() . '.pdf';
        Storage::disk('public')->put($path, $pdfContent);

        // 5. Update receipt with PDF path
        $receipt->update(['pdf_path' => $path]);

        \Log::info('Receipt generated: ' . $receipt->receipt_number);
        return $receipt;
    }

    /**
     * Generate meaningful remarks for receipt.
     */
    protected function generateReceiptRemarks(Payment $payment): string
    {
        $remarks = [];
        if ($payment->invoice) {
            $invoice = $payment->invoice;
            $invoiceType = $invoice->invoice_type ?? 'unknown';
            $invoiceTypeLabel = __('messages.invoice_type_' . $invoiceType) ?? ucfirst(str_replace('_', ' ', $invoiceType));
            $remarks[] = 'Payment for Invoice ' . $invoice->invoice_number . ' (' . $invoiceTypeLabel . ')';
        }
        if (!empty($payment->remarks)) {
            $remarks[] = $payment->remarks;
        }
        return implode(' | ', $remarks);
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
        if ($invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid') {
            $invoice->status = 'overdue';
        }
        $invoice->save();
    }
}