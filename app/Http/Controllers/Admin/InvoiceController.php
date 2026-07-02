<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class InvoiceController extends Controller
{
    /**
     * Generate an invoice for a registration.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date|after:today',
            'invoice_type' => 'nullable|string|max:50',
        ]);

        $registration = Registration::findOrFail($request->registration_id);

        // Check for existing pending/partial invoice
        $existingInvoice = Invoice::where('registration_id', $registration->id)
            ->whereIn('status', ['pending', 'partial'])
            ->first();

        if ($existingInvoice) {
            return back()->with('error', 'An unpaid invoice already exists. Invoice #: ' . $existingInvoice->invoice_number);
        }

        // Generate invoice number
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $nextId = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -6)) + 1 : 1;
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        // ===== CREATE INVOICE RECORD FIRST =====
        $invoice = Invoice::create([
            'registration_id' => $registration->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $request->amount,
            'issued_date' => now(),
            'due_date' => $request->due_date ?? now()->addDays(30),
            'status' => 'pending',
            'invoice_type' => $request->invoice_type ?? 'new_registration',
            'pdf_path' => null,
        ]);

        try {
            // ===== GENERATE PDF =====
            $html = view('pdf.invoice', compact('registration', 'invoiceNumber', 'request'))->render();

            $tempDir = storage_path('app/mpdf');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // ===== MPDF CONFIG (Same as Certificate) =====
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'default_font_size' => 12,
                'default_font' => 'dejavusans',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
                'tempDir' => $tempDir,
            ]);

            // ===== WATERMARK IMAGE (ADDED - exactly like Certificate) =====
            $logoPath = public_path('images/logo.png');
            if (file_exists($logoPath)) {
                $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
                $mpdf->showWatermarkImage = true;
            }

            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', 'S');

            // ===== SAVE PDF =====
            $path = 'invoices/invoice_' . uniqid() . '.pdf';
            Storage::disk('public')->put($path, $pdfContent);

            $invoice->update(['pdf_path' => $path]);

            // Mark registration as awaiting payment
            $registration->markAwaitingPayment();

            return back()->with('success', 'Invoice generated successfully!');

        } catch (MpdfException $e) {
            Log::error('Invoice PDF Generation Error: ' . $e->getMessage());
            $invoice->delete();
            return back()->with('error', 'Invoice generation failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Invoice Generation Error: ' . $e->getMessage());
            $invoice->delete();
            return back()->with('error', 'Invoice generation failed. Please try again.');
        }
    }

    /**
     * Download an invoice PDF.
     */
    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (!Storage::disk('public')->exists($invoice->pdf_path)) {
            abort(404, 'Invoice PDF not found.');
        }

        return response()->download(
            storage_path('app/public/' . $invoice->pdf_path),
            'invoice_' . $invoice->invoice_number . '.pdf'
        );
    }

    /**
     * View invoice details.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('registration');
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * List all invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('registration')->latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Mark invoice as paid.
     */
    public function markPaid(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Invoice already paid.');
        }

        $invoice->update(['status' => 'paid']);
        return back()->with('success', 'Invoice marked as paid.');
    }
}