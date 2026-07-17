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
            $html = view('pdf.invoice', [
                'registration' => $registration,
                'invoiceNumber' => $invoiceNumber,
                'request' => $request,
                'invoice_type' => $request->invoice_type ?? 'new_registration',
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

            // ===== Ensure invoices directory exists =====
            if (!Storage::disk('public')->exists('invoices')) {
                Storage::disk('public')->makeDirectory('invoices', 0755, true);
            }

            // ===== SAVE PDF =====
            $path = 'invoices/invoice_' . uniqid() . '.pdf';
            Storage::disk('public')->put($path, $pdfContent);
            if (Storage::disk('public')->exists($path)) {
    Log::info('✅ Invoice PDF saved successfully: ' . $path);
} else {
    Log::error('❌ Invoice PDF FAILED to save: ' . $path);
    if (Storage::disk('public')->exists('invoices')) {
        Log::info('Invoices directory exists.');
    } else {
        Log::error('Invoices directory does NOT exist.');
    }
}

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
        try {
            $invoice = Invoice::findOrFail($id);

            if (!$invoice->pdf_path) {
                return back()->with('error', 'Invoice PDF not found. Please regenerate the invoice.');
            }

            if (!Storage::disk('public')->exists($invoice->pdf_path)) {
                // Try to regenerate PDF
                try {
                    $registration = $invoice->registration;
                    if (!$registration) {
                        return back()->with('error', 'Registration not found for this invoice.');
                    }

                    $html = view('pdf.invoice', [
                        'registration' => $registration,
                        'invoiceNumber' => $invoice->invoice_number,
                        'request' => (object) [
                            'amount' => $invoice->amount,
                            'due_date' => $invoice->due_date
                        ],
                        'invoice_type' => $invoice->invoice_type ?? 'new_registration',
                    ])->render();

                    $tempDir = storage_path('app/mpdf');
                    if (!file_exists($tempDir)) {
                        mkdir($tempDir, 0755, true);
                    }

                    $mpdf = new \Mpdf\Mpdf([
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

                    $logoPath = public_path('images/logo.png');
                    if (file_exists($logoPath)) {
                        $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
                        $mpdf->showWatermarkImage = true;
                    }

                    $mpdf->WriteHTML($html);
                    $pdfContent = $mpdf->Output('', 'S');

                    // Ensure invoices directory exists
                    if (!Storage::disk('public')->exists('invoices')) {
                        Storage::disk('public')->makeDirectory('invoices', 0755, true);
                    }

                    // Save regenerated PDF
                    $path = 'invoices/invoice_' . uniqid() . '.pdf';
                    Storage::disk('public')->put($path, $pdfContent);

                    // Update invoice record
                    $invoice->pdf_path = $path;
                    $invoice->save();

                    // Download the regenerated PDF
                    return response()->download(
                        storage_path('app/public/' . $path),
                        'invoice_' . $invoice->invoice_number . '.pdf'
                    );

                } catch (\Exception $e) {
                    \Log::error('PDF Regeneration failed for invoice ID ' . $invoice->id . ': ' . $e->getMessage());
                    return back()->with('error', 'Failed to regenerate PDF: ' . $e->getMessage());
                }
            }

            // File exists – download it
            return response()->download(
                storage_path('app/public/' . $invoice->pdf_path),
                'invoice_' . $invoice->invoice_number . '.pdf'
            );

        } catch (\Exception $e) {
            \Log::error('Invoice download failed for ID ' . $id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to download invoice: ' . $e->getMessage());
        }
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
     * List all invoices with advanced search/filter.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('registration');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('registration', function ($r) use ($search) {
                      $r->where('hostel_name', 'LIKE', "%{$search}%")
                        ->orWhere('hostel_name_english', 'LIKE', "%{$search}%")
                        ->orWhere('registration_number', 'LIKE', "%{$search}%")
                        ->orWhere('local_registration_number', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('invoice_type')) {
            $query->where('invoice_type', $request->invoice_type);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('issued_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('issued_date', '<=', $request->date_to);
        }

        switch ($request->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'amount_asc':
                $query->orderBy('amount', 'asc');
                break;
            case 'amount_desc':
                $query->orderBy('amount', 'desc');
                break;
            case 'status_asc':
                $query->orderBy('status', 'asc');
                break;
            case 'status_desc':
                $query->orderBy('status', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $invoices = $query->paginate(15)->appends($request->query());

        $totalInvoices = Invoice::count();
        $paidCount = Invoice::where('status', 'paid')->count();
        $pendingCount = Invoice::where('status', 'pending')->count();
        $overdueCount = Invoice::where('status', 'overdue')->count();
        $partialCount = Invoice::where('status', 'partial')->count();

        $invoiceTypes = Invoice::select('invoice_type')
            ->distinct()
            ->orderBy('invoice_type')
            ->pluck('invoice_type');

        return view('admin.invoices.index', compact(
            'invoices',
            'totalInvoices',
            'paidCount',
            'pendingCount',
            'overdueCount',
            'partialCount',
            'invoiceTypes'
        ));
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