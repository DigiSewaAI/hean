<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class RegenerateInvoicePdfs extends Command
{
    protected $signature = 'regenerate:invoices {--id= : Regenerate specific invoice by ID}';
    protected $description = 'Regenerate PDFs for invoices (only those with amount > 0 or missing PDF)';

    public function handle()
    {
        $query = Invoice::query();

        if ($id = $this->option('id')) {
            $query->where('id', $id);
        } else {
            // ✅ केवल amount > 0 भएका वा pdf_path NULL भएका मात्र लिने
            $query->where(function($q) {
                $q->where('amount', '>', 0)
                  ->orWhereNull('pdf_path');
            });
        }

        $invoices = $query->get();
        
        if ($invoices->isEmpty()) {
            $this->error('No invoices found to process.');
            return 1;
        }

        $this->info("Found {$invoices->count()} invoices to process...");
        $count = 0;

        foreach ($invoices as $invoice) {
            $this->line("Processing Invoice #{$invoice->invoice_number}...");

            try {
                $registration = $invoice->registration;
                if (!$registration) {
                    $this->error("  ❌ Registration not found");
                    continue;
                }

                // Prepare PDF data
                $html = view('pdf.invoice', [
                    'registration' => $registration,
                    'invoiceNumber' => $invoice->invoice_number,
                    'request' => (object) [
                        'amount' => $invoice->amount,
                        'due_date' => $invoice->due_date
                    ],
                    'invoice_type' => $invoice->invoice_type ?? 'new_registration',
                ])->render();

                // mPDF config
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
                $count++;

            } catch (\Exception $e) {
                $this->error("  ❌ Failed: " . $e->getMessage());
                \Log::error('PDF Regeneration failed for invoice ' . $invoice->id . ': ' . $e->getMessage());
            }
        }

        $this->info("✅ Done! Regenerated {$count} PDFs.");
        return 0;
    }
}