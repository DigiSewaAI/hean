<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    /**
     * Display a listing of receipts.
     */
    public function index(Request $request)
    {
        $query = Receipt::with(['registration', 'payment', 'invoice']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('receipt_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('registration', function($r) use ($search) {
                      $r->where('hostel_name', 'LIKE', "%{$search}%")
                        ->orWhere('registration_number', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by registration
        if ($request->filled('registration_id')) {
            $query->where('registration_id', $request->registration_id);
        }

        $receipts = $query->latest()->paginate(15)->appends($request->query());

        $registrations = Registration::select('id', 'hostel_name')->get();

        return view('admin.receipts.index', compact('receipts', 'registrations'));
    }

    /**
     * Show a single receipt.
     */
    public function show(Receipt $receipt)
    {
        $receipt->load(['registration', 'payment', 'invoice']);
        return view('admin.receipts.show', compact('receipt'));
    }

    /**
     * Generate a receipt for a verified payment.
     */
    public function generate(Payment $payment)
    {
        if ($payment->status !== 'verified') {
            return back()->with('error', __('messages.receipt_only_for_verified_payments'));
        }

        // Check if receipt already exists
        if ($payment->receipts()->exists()) {
            return back()->with('error', __('messages.receipt_already_generated'));
        }

        DB::beginTransaction();
        try {
            $receiptNumber = $this->generateReceiptNumber();

            $receipt = Receipt::create([
                'registration_id' => $payment->registration_id,
                'payment_id' => $payment->id,
                'invoice_id' => $payment->invoice_id,
                'receipt_number' => $receiptNumber,
                'amount' => $payment->amount,
                'issued_date' => now(),
                'remarks' => $payment->remarks ?? null,
            ]);

            // Generate PDF
            $pdf = Pdf::loadView('admin.receipts.pdf', compact('receipt', 'payment'));
            $path = 'receipts/receipt_' . uniqid() . '.pdf';
            Storage::disk('public')->put($path, $pdf->output());

            $receipt->update(['pdf_path' => $path]);

            DB::commit();

            return redirect()->route('admin.receipts.show', $receipt)
                ->with('success', __('messages.receipt_generated_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Receipt generation failed: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Download receipt PDF.
     */
    public function download(Receipt $receipt)
    {
        if (!$receipt->pdf_path || !Storage::disk('public')->exists($receipt->pdf_path)) {
            abort(404, 'Receipt file not found.');
        }

        return response()->download(
            storage_path('app/public/' . $receipt->pdf_path),
            'receipt_' . $receipt->receipt_number . '.pdf'
        );
    }

    /**
     * Generate unique receipt number: RCP-YYYY-XXXXXX
     */
    private function generateReceiptNumber()
    {
        $year = date('Y');
        $lastReceipt = Receipt::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        if ($lastReceipt) {
            $lastNumber = (int) substr($lastReceipt->receipt_number, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }
        return 'RCP-' . $year . '-' . $newNumber;
    }
}