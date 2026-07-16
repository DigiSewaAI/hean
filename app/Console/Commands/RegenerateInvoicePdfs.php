<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class RegenerateInvoicePdfs extends Command
{
    protected $signature = 'regenerate:invoices';
    protected $description = 'Regenerate PDFs for ALL invoices (including those with null pdf_path)';

    public function handle()
    {
        // ✅ ALL invoices लिने (pdf_path NULL भएको पनि)
        $invoices = Invoice::all();
        
        if ($invoices->isEmpty()) {
            $this->error('No invoices found.');
            return 1;
        }

        $this->info("Found {$invoices->count()} invoices. Processing...");
        $count = 0;

        foreach ($invoices as $invoice) {
            $this->line("Processing Invoice #{$invoice->invoice_number}...");

            try {
                $registration = $invoice->registration;
                if (!$registration) {
                    $this->error("  ❌ Registration not found for invoice #{$invoice->id}");
                    continue;
                }

                // ✅ PDF generate गर्ने
                $html = view('pdf.invoice', [
                    'registration' => $registration,
                    'invoiceNumber' => $invoice->invoice_number,
                    'request' => (object) [
                        'amount' => $invoice->amount,
                        'due_date' => $invoice->due_date
                    ],
                    'invoice_type' => $invoice->invoice_type ?? 'new_registration', // ✅ यो line important छ
                ])->render();

                // ✅ mPDF Config (production मा काम गर्ने गरी)
                $tempDir = storage_path('app/mpdf');
                if (!file_exists($tempDir)) {
                    mkdir($tempDir, 0755, true);
                }

                $mpdf = new Mpdf([
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'orientation' => 'P',
                    'default_font_size' => 12,
                    'default_font' => 'helvetica', // ✅ सुरक्षित fallback (production मा काम गर्छ)
                    'autoScriptToLang' => true,
                    'autoLangToFont' => true,
                    'margin_top' => 10,
                    'margin_bottom' => 10,
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'tempDir' => $tempDir,
                ]);

                // Watermark (यदि logo छ भने)
                $logoPath = public_path('images/logo.png');
                if (file_exists($logoPath)) {
                    $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
                    $mpdf->showWatermarkImage = true;
                }

                $mpdf->WriteHTML($html);
                $pdfContent = $mpdf->Output('', 'S');

                // ✅ PDF path generate गर्ने
                if ($invoice->pdf_path) {
                    // पुरानो path प्रयोग गर्ने
                    $path = $invoice->pdf_path;
                } else {
                    // नयाँ path बनाउने
                    $path = 'invoices/invoice_' . uniqid() . '.pdf';
                }

                Storage::disk('public')->put($path, $pdfContent);
                
                // ✅ यदि pdf_path NULL थियो भने update गर्ने
                if (!$invoice->pdf_path) {
                    $invoice->update(['pdf_path' => $path]);
                }

                $this->info("  ✅ Generated: {$path}");
                $count++;

            } catch (\Exception $e) {
                $this->error("  ❌ Failed: " . $e->getMessage());
                // Error log मा save गर्ने
                \Log::error('PDF Regeneration failed for invoice ' . $invoice->id . ': ' . $e->getMessage());
            }
        }

        $this->info("✅ Done! Regenerated {$count} PDFs.");
        return 0;
    }
}