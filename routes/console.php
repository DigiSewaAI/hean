<?php

use App\Models\Receipt;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

Artisan::command('regenerate:receipts-all', function () {
    // ✅ सबै Receipt लिने (पुरानो pdf_path NULL चेक नगर्ने)
    $receipts = Receipt::all();

    if ($receipts->isEmpty()) {
        $this->info('No receipts found.');
        return;
    }

    $this->info("Found {$receipts->count()} receipts. Regenerating all PDFs...");

    foreach ($receipts as $receipt) {
        $this->line("Processing receipt #{$receipt->id} ({$receipt->receipt_number})...");

        try {
            $payment = $receipt->payment;
            if (!$payment) {
                $this->error("  Payment not found for receipt #{$receipt->id}");
                continue;
            }

            $registration = $payment->registration;
            if (!$registration) {
                $this->error("  Registration not found for receipt #{$receipt->id}");
                continue;
            }

            $invoice = $payment->invoice;

            // ✅ सही view लोकेशन: admin.receipts.pdf
            $html = view('admin.receipts.pdf', compact('receipt', 'payment', 'registration', 'invoice'))->render();
            $mpdf = new Mpdf();
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', 'S');

            // ✅ Path generate गर्नुहोस्
            $path = 'receipts/receipt_' . uniqid() . '.pdf';
            Storage::disk('public')->put($path, $pdfContent);

            // ✅ Update गर्नुहोस्
            $receipt->update(['pdf_path' => $path]);
            $this->info("  ✅ PDF generated: {$path}");

        } catch (\Exception $e) {
            $this->error("  ❌ Failed: " . $e->getMessage());
        }
    }

    $this->info('Done.');
})->purpose('Regenerate ALL receipt PDFs (even if pdf_path already set)');