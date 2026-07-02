<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class InvoiceController extends Controller
{
    /**
     * Generate an invoice for a registration.
     * ✅ Checks for existing pending/partial invoice.
     * ✅ Sets registration status to 'awaiting_payment'.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date|after:today',
            'invoice_type' => 'nullable|string|max:50', // optional
        ]);

        $registration = Registration::findOrFail($request->registration_id);

        // 🔥 1. Check if there is any pending or partial invoice for this registration
        $existingInvoice = Invoice::where('registration_id', $registration->id)
            ->whereIn('status', ['pending', 'partial'])
            ->first();

        if ($existingInvoice) {
            return back()->with('error', 'An unpaid invoice already exists for this registration. Invoice #: ' . $existingInvoice->invoice_number);
        }

        // 🔥 2. Generate invoice number safely
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $nextId = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -6)) + 1 : 1;
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        // 🔥 3. Prepare PDF
        $html = view('pdf.invoice', compact('registration', 'invoiceNumber', 'request'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        // 🔥 4. Save PDF
        $path = 'invoices/invoice_' . uniqid() . '.pdf';
        Storage::disk('public')->put($path, $pdfContent);

        // 🔥 5. Create invoice record
        $invoice = Invoice::create([
            'registration_id' => $registration->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $request->amount,
            'issued_date' => now(),
            'due_date' => $request->due_date ?? now()->addDays(30),
            'status' => 'pending',
            'invoice_type' => $request->invoice_type ?? 'new_registration',
            'pdf_path' => $path,
        ]);

        // 🔥 6. Mark registration as awaiting payment
        $registration->markAwaitingPayment();

        return back()->with('success', 'Invoice generated successfully. Registration is now awaiting payment.');
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
     * (Optional) View invoice details in admin panel.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('registration');
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * (Optional) List all invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('registration')->latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * (Optional) Mark invoice as paid manually (if needed).
     */
    public function markPaid(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Invoice already paid.');
        }

        $invoice->update(['status' => 'paid']);
        // Optionally, activate registration if fully paid
        // (but usually payment verification does this)

        return back()->with('success', 'Invoice marked as paid.');
    }
}