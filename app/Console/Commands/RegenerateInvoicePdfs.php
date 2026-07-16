<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class RegenerateInvoicePdfs extends Command
{
    protected $signature = 'regenerate:invoices {--id= : Regenerate specific invoice by ID} {--force : Regenerate all invoices even if PDF exists}';
    protected $description = 'Regenerate PDFs for invoices (only those missing the actual file, or specified by ID)';

    public function handle()
    {
        $query = Invoice::query();

        // यदि --id दिइएको छ भने, त्यो एउटा मात्र लिने
        if ($id = $this->option('id')) {
            $query->where('id', $id);
        } else {
            // --force नभए, pdf_path NULL भएको मात्र लिने (file missing हुनेछ)
            if (!$this->option('force')) {
                $query->whereNull('pdf_path');
            }
            // यदि --force छ भने सबै लिने (तर chunk मा प्रशोधन हुन्छ)
        }

        // ✅ Memory बचाउन chunk मा प्रशोधन गर्ने (५०–५० गरी)
        $query->chunk(50, function ($invoices) {
            foreach ($invoices as $invoice) {
                $this->processInvoice($invoice);
            }
        });

        $this->info('✅ Done.');
        return 0;
    }

    /**
     * एउटा invoice को PDF generate गर्ने (यदि आवश्यक छ भने मात्र)
     */
    protected function processInvoice($invoice)
    {
        // यदि --force छैन र pdf_path छ र file पहिले नै अवस्थित छ भने skip गर्ने
        if (!$this->option('force') && $invoice->pdf_path && Storage::disk('public')->exists($invoice->pdf_path)) {
            $this->line("⏭️ Skipping Invoice #{$invoice->invoice_number} (PDF already exists)");
            return;
        }

        $this->line("🔄 Processing Invoice #{$invoice->invoice_number}...");

        try {
            $registration = $invoice->registration;
            if (!$registration) {
                $this->error("  ❌ Registration not found for invoice #{$invoice->id}");
                return;
            }

            // PDF को लागि data prepare
            $html = view('pdf.invoice', [
                'registration' => $registration,
                'invoiceNumber' => $invoice->invoice_number,
                'request' => (object) [
                    'amount' => $invoice->amount,
                    'due_date' => $invoice->due_date,
                ],
                'invoice_type' => $invoice->invoice_type ?? 'new_registration',
            ])->render();

            // mPDF config (production-friendly)
            $tempDir = storage_path('app/mpdf');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'default_font_size' => 12,
                'default_font' => 'helvetica', // ✅ सुरक्षित fallback
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
                'tempDir' => $tempDir,
            ]);

            // Watermark
            $logoPath = public_path('images/logo.png');
            if (file_exists($logoPath)) {
                $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
                $mpdf->showWatermarkImage = true;
            }

            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', 'S');

            // Path
            if ($invoice->pdf_path) {
                $path = $invoice->pdf_path;
            } else {
                $path = 'invoices/invoice_' . uniqid() . '.pdf';
            }

            Storage::disk('public')->put($path, $pdfContent);

            if (!$invoice->pdf_path) {
                $invoice->update(['pdf_path' => $path]);
            }

            $this->info("  ✅ Generated: {$path}");

        } catch (\Exception $e) {
            $this->error("  ❌ Failed: " . $e->getMessage());
            \Log::error('PDF Regeneration failed for invoice ' . $invoice->id . ': ' . $e->getMessage());
        }
    }
}