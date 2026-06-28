<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
        ]);

        $registration = Registration::findOrFail($request->registration_id);

        // Generate unique invoice number
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('pdf.invoice', compact('registration', 'invoiceNumber', 'request'));
        $path = 'invoices/invoice_' . uniqid() . '.pdf';
        \Storage::disk('public')->put($path, $pdf->output());

        $invoice = Invoice::create([
            'registration_id' => $registration->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $request->amount,
            'issued_date' => now(),
            'due_date' => $request->due_date,
            'status' => 'pending',
            'pdf_path' => $path,
        ]);

        return back()->with('success', 'Invoice generated!');
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->download(storage_path('app/public/' . $invoice->pdf_path));
    }
}