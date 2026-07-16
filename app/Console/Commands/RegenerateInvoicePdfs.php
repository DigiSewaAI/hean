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

        if ($id = $this->option('id')) {
            $query->where('id', $id);
        } else {
            if (!$this->option('force')) {
                // pdf_path NULL भएको वा file physically नभएको मात्र
                $allInvoices = Invoice::all();
                $missingIds = [];
                
                foreach ($allInvoices as $inv) {
                    if (!$inv->pdf_path || !Storage::disk('public')->exists($inv->pdf_path)) {
                        $missingIds[] = $inv->id;
                    }
                }
                
                if (empty($missingIds)) {
                    $this->info('No missing PDFs found.');
                    return 0;
                }
                
                $query->whereIn('id', $missingIds);
            }
        }

        $invoices = $query->get();
        
        if ($invoices->isEmpty()) {
            $this->error('No invoices found to process.');
            return 1;
        }

        $this->info("Found {$invoices->count()} invoices to process...");
        
        // ✅ Memory बचाउन chunk मा प्रशोधन
        $query->chunk(50, function ($chunk) {
            foreach ($chunk as $invoice) {
                $this->processInvoice($invoice);
            }
        });

        $this->info('✅ Done.');
        return 0;
    }

    protected function processInvoice($invoice)
    {
        // ✅ file physically check गर्ने
        $fileExists = $invoice->pdf_path && Storage::disk('public')->exists($invoice->pdf_path);
        
        if (!$this->option('force') && $fileExists) {
            $this->line("⏭️ Skipping Invoice #{$invoice->invoice_number} (PDF already exists)");
            return;
        }

        $this->line("🔄 Processing Invoice #{$invoice->invoice_number}...");

        try {
            $registration = $invoice->registration;
            if (!$registration) {
                $this->error("  ❌ Registration not found");
                return;
            }

            $html = view('pdf.invoice', [
                'registration' => $registration,
                'invoiceNumber' => $invoice->invoice_number,
                'request' => (object) [
                    'amount' => $invoice->amount,
                    'due_date' => $invoice->due_date,
                ],
                'invoice_type' => $invoice->invoice_type ?? 'new_registration',
            ])->render();

            $tempDir = storage_path('app/mpdf');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'default_font_size' => 12,
                'default_font' => 'helvetica',
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

            // ✅ पुरानो path हटाउने (यदि छ भने)
            if ($invoice->pdf_path && Storage::disk('public')->exists($invoice->pdf_path)) {
                Storage::disk('public')->delete($invoice->pdf_path);
            }

            // नयाँ path
            $path = 'invoices/invoice_' . uniqid() . '.pdf';
            Storage::disk('public')->put($path, $pdfContent);
            
            $invoice->update(['pdf_path' => $path]);

            $this->info("  ✅ Generated: {$path}");

        } catch (\Exception $e) {
            $this->error("  ❌ Failed: " . $e->getMessage());
            \Log::error('PDF Regeneration failed for invoice ' . $invoice->id . ': ' . $e->getMessage());
        }
    }
}