<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReceiptController extends Controller
{
    /**
     * List all receipts with filters.
     */
    public function index(Request $request)
    {
        $query = Receipt::with(['payment', 'payment.registration']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('receipt_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('payment.registration', function($r) use ($search) {
                      $r->where('hostel_name', 'LIKE', "%{$search}%")
                        ->orWhere('registration_number', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('registration_id')) {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('registration_id', $request->registration_id);
            });
        }

        $receipts = $query->latest()->paginate(15)->appends($request->query());
        $registrations = Registration::select('id', 'hostel_name')->get();

        return view('admin.receipts.index', compact('receipts', 'registrations'));
    }

    /**
     * Show a single receipt.
     * ✅ Load payment and registration via payment relationship.
     */
    public function show(Receipt $receipt)
    {
        $receipt->load(['payment', 'payment.registration', 'payment.invoice']);
        return view('admin.receipts.show', compact('receipt'));
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
}