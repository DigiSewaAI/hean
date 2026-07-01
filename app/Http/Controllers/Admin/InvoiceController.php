<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * नयाँ इनभ्वाइस उत्पन्न गर्नुहोस्।
     */
    public function generate(Request $request)
    {
        // १. प्रमाणीकरण (Validation)
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'invoice_type' => 'required|in:new_registration,renewal,membership_fee,inspection_fee,certificate_fee,penalty,other',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
        ]);

        $registration = Registration::findOrFail($request->registration_id);

        // २. डुप्लिकेट बाँकी इनभ्वाइस रोक्नुहोस्
        $existingPending = Invoice::where('registration_id', $request->registration_id)
            ->whereIn('status', ['pending', 'partial'])
            ->exists();

        if ($existingPending) {
            return back()->with('error', __('messages.duplicate_pending_invoice'));
        }

        // ३. अद्वितीय इनभ्वाइस नम्बर उत्पन्न गर्नुहोस्
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT);

        // ४. PDF उत्पन्न र भण्डारण
        $pdf = Pdf::loadView('pdf.invoice', compact('registration', 'invoiceNumber', 'request'));
        $path = 'invoices/invoice_' . uniqid() . '.pdf';
        \Storage::disk('public')->put($path, $pdf->output());

        // ५. इनभ्वाइस डाटाबेसमा सिर्जना गर्नुहोस्
        $invoice = Invoice::create([
            'registration_id' => $registration->id,
            'invoice_number' => $invoiceNumber,
            'invoice_type' => $request->invoice_type, // नयाँ फिल्ड
            'amount' => $request->amount,
            'issued_date' => now(),
            'due_date' => $request->due_date,
            'status' => 'pending',
            'pdf_path' => $path,
        ]);

        return back()->with('success', 'Invoice generated!');
    }

    /**
     * इनभ्वाइस PDF डाउनलोड गर्नुहोस्।
     */
    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->download(storage_path('app/public/' . $invoice->pdf_path));
    }
}