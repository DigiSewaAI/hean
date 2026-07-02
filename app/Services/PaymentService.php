<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class PaymentService
{
    /**
     * Payment verify गर्ने, र Receipt generate गर्ने
     */
    public function verifyPayment(Payment $payment, int $verifiedByUserId): void
    {
        DB::transaction(function () use ($payment, $verifiedByUserId) {
            // 1. Payment mark verified
            $payment->markVerified($verifiedByUserId);

            // 2. Receipt generate (sync वा queue मा)
            $this->generateReceipt($payment);

            // 3. Invoice status update
            $invoice = $payment->invoice;
            $this->updateInvoiceStatus($invoice);

            // 4. यदि Invoice पूर्ण भुक्तान भयो भने Registration activate
            if ($invoice->status === 'paid') {
                app(RegistrationService::class)->activateFromInvoice($invoice);
            }
        });
    }

    /**
     * Receipt generate गर्ने (queue वा sync)
     */
    public function generateReceipt(Payment $payment): Receipt
    {
        // Receipt number generate
        $receiptNumber = $this->generateReceiptNumber();

        // PDF बनाउने
        $html = view('admin.receipts.pdf', compact('payment', 'receiptNumber'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        // PDF सेभ
        $path = 'receipts/receipt_' . uniqid() . '.pdf';
        Storage::disk('public')->put($path, $pdfContent);

        // Receipt record
        $receipt = Receipt::create([
            'payment_id' => $payment->id,
            'receipt_number' => $receiptNumber,
            'amount' => $payment->amount,
            'issued_date' => now(),
            'pdf_path' => $path,
            'remarks' => $payment->remarks ?? null,
        ]);

        // (optional) पुराना कलमहरू पनि भर्न सकिन्छ तर अब डिप्रिकेटेड
        // यदि चाहियो भने registration_id र invoice_id पनि सेट गर्न सकिन्छ, तर अब आवश्यक छैन
        // हामीले ती कलमलाई nullable राखेका छौं, त्यसैले खाली छोड्न सकिन्छ

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
     * Invoice को status recalc गर्ने
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