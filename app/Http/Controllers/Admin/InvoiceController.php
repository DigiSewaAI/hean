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
use App\Http\Requests\StoreInvoiceRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
 * Generate a multi-line invoice for a registration.
 */
public function generate(StoreInvoiceRequest $request)
{
    $validated = $request->validated();

    // 1. Registration फेला पार्नुहोस्
    $registration = Registration::findOrFail($validated['registration_id']);

    // 2. Check for existing pending/partial invoice (पुरानै logic)
    $existingInvoice = Invoice::where('registration_id', $registration->id)
        ->whereIn('status', ['pending', 'partial'])
        ->first();

    if ($existingInvoice) {
        return back()->with('error', 'An unpaid invoice already exists. Invoice #: ' . $existingInvoice->invoice_number);
    }

    // 3. Items प्रशोधन गर्ने
    $items = $validated['items'];
    $subtotal = 0;
    $calculatedItems = [];
    foreach ($items as $item) {
        $amount = $item['quantity'] * $item['unit_price'];
        $calculatedItems[] = [
            'description' => $item['description'],
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'amount' => $amount,
            'remarks' => $item['remarks'] ?? null,
            'sort_order' => 0,
        ];
        $subtotal += $amount;
    }

    $discount = 0;  // अहिलेलाई 0
    $tax = 0;       // अहिलेलाई 0
    $grandTotal = $subtotal - $discount + $tax;

    // 4. Invoice number generate गर्ने (helper method call)
    $invoiceNumber = $this->generateInvoiceNumber();

    // 5. Transaction सुरु गर्ने
    DB::beginTransaction();
    try {
        // Invoice सिर्जना
        $invoice = Invoice::create([
            'registration_id' => $registration->id,
            'invoice_number' => $invoiceNumber,
            'issued_date' => now(),
            'due_date' => $validated['due_date'] ?? now()->addDays(30),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'amount' => $grandTotal,
            'status' => 'pending',
            'invoice_type' => 'multi',  // अथवा null
            'pdf_path' => null,
        ]);

        // Invoice items थप्ने
        foreach ($calculatedItems as &$item) {
            $item['invoice_id'] = $invoice->id;
        }
        $invoice->items()->createMany($calculatedItems);

        // PDF generate गर्ने (पुरानै method, तर $invoice पठाउने)
        try {
            // पुरानो view लाई पनि support गर्नको लागि $request object बनाउने (तर items पनि पठाउने)
            $requestForView = (object) [
                'amount' => $grandTotal,
                'due_date' => $invoice->due_date,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'items' => $calculatedItems,
            ];

            $html = view('pdf.invoice', [
                'registration' => $registration,
                'invoiceNumber' => $invoiceNumber,
                'request' => $requestForView,
                'invoice_type' => 'multi',
                'invoice' => $invoice,  // पछि view upgrade गर्न
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

            // Ensure directory exists
            if (!Storage::disk('public')->exists('invoices')) {
                Storage::disk('public')->makeDirectory('invoices', 0755, true);
            }

            $path = 'invoices/invoice_' . uniqid() . '.pdf';
            Storage::disk('public')->put($path, $pdfContent);
            
            if (Storage::disk('public')->exists($path)) {
                Log::info('✅ Invoice PDF saved successfully: ' . $path);
            } else {
                Log::error('❌ Invoice PDF FAILED to save: ' . $path);
            }

            $invoice->update(['pdf_path' => $path]);

        } catch (MpdfException $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            $invoice->delete();
            DB::rollBack();
            return back()->with('error', 'PDF generation failed: ' . $e->getMessage());
        }

        // Registration status update
        $registration->markAwaitingPayment();

        DB::commit();

        return redirect()->route('admin.invoices.show', $invoice->id)
                         ->with('success', 'Invoice generated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Invoice Generation Error: ' . $e->getMessage());
        return back()->with('error', 'Invoice generation failed. Please try again.');
    }
}

    /**
 * Download an invoice PDF – सिधै जेनरेट गरी डाउनलोड (सेभ नगरी)
 */
public function download($id)
{
    try {
        $invoice = Invoice::with('items')->findOrFail($id);
        $registration = $invoice->registration;
        if (!$registration) {
            abort(404, 'Registration not found for this invoice.');
        }

        // ===== PDF View को लागि request object =====
        $requestForView = (object) [
            'amount' => $invoice->amount,
            'due_date' => $invoice->due_date,
            'subtotal' => $invoice->subtotal ?? $invoice->amount,
            'discount' => $invoice->discount ?? 0,
            'tax' => $invoice->tax ?? 0,
            'items' => $invoice->items ?? [],
        ];

        $html = view('pdf.invoice', [
            'registration' => $registration,
            'invoiceNumber' => $invoice->invoice_number,
            'request' => $requestForView,
            'invoice_type' => $invoice->invoice_type ?? 'multi',
            'invoice' => $invoice, // पछि view upgrade गर्न
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

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice_' . $invoice->invoice_number . '.pdf"');

    } catch (\Exception $e) {
        \Log::error('Invoice download failed for ID ' . $id . ': ' . $e->getMessage());
        return back()->with('error', 'Failed to generate invoice PDF: ' . $e->getMessage());
    }
}

    /**
     * View invoice details.
     */
    public function show(Invoice $invoice)
{
    $invoice->load(['registration', 'items']);
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
    /**
 * Generate a unique invoice number.
 */
private function generateInvoiceNumber()
{
    $year = date('Y');
    $lastInvoice = Invoice::whereYear('created_at', $year)
                          ->orderBy('id', 'desc')
                          ->first();
    if ($lastInvoice) {
        $lastNumber = intval(substr($lastInvoice->invoice_number, -6));
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }
    return 'INV-' . $year . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
}
}