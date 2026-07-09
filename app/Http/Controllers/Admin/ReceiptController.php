<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class ReceiptController extends Controller
{
    /**
 * List all receipts with advanced search/filter.
 */
public function index(Request $request)
{
    $query = Receipt::with(['payment', 'payment.registration', 'payment.invoice']);

    // ===== 1. BASIC SEARCH (Multiple Fields) =====
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('receipt_number', 'LIKE', "%{$search}%")
              ->orWhere('amount', 'LIKE', "%{$search}%")
              ->orWhereHas('payment.registration', function ($r) use ($search) {
                  $r->where('hostel_name', 'LIKE', "%{$search}%")
                    ->orWhere('hostel_name_english', 'LIKE', "%{$search}%")
                    ->orWhere('registration_number', 'LIKE', "%{$search}%")
                    ->orWhere('local_registration_number', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('payment.invoice', function ($i) use ($search) {
                  $i->where('invoice_number', 'LIKE', "%{$search}%");
              });
        });
    }

    // ===== 2. FILTER: Registration =====
    if ($request->filled('registration_id')) {
        $query->whereHas('payment', function ($q) use ($request) {
            $q->where('registration_id', $request->registration_id);
        });
    }

    // ===== 3. FILTER: Amount Range =====
    if ($request->filled('amount_min')) {
        $query->where('amount', '>=', $request->amount_min);
    }
    if ($request->filled('amount_max')) {
        $query->where('amount', '<=', $request->amount_max);
    }

    // ===== 4. FILTER: Date Range (Issued Date) =====
    if ($request->filled('date_from')) {
        $query->whereDate('issued_date', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('issued_date', '<=', $request->date_to);
    }

    // ===== 5. SORTING =====
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
        default:
            $query->latest();
            break;
    }

    // ===== PAGINATE =====
    $receipts = $query->paginate(15)->appends($request->query());

    // ===== STATS =====
    $totalReceipts = Receipt::count();
    $totalAmount = Receipt::sum('amount');

    // ===== REGISTRATIONS FOR DROPDOWN =====
    $registrations = Registration::select('id', 'hostel_name', 'registration_number')
        ->orderBy('hostel_name')
        ->get();

    return view('admin.receipts.index', compact(
        'receipts',
        'totalReceipts',
        'totalAmount',
        'registrations'
    ));
}

    /**
     * Show a single receipt.
     */
    public function show(Receipt $receipt)
    {
        $receipt->load(['payment', 'payment.registration', 'payment.invoice']);
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
            'pdf_path' => null,
        ]);

        // ===== GENERATE PDF =====
        $html = view('admin.receipts.pdf', compact('receipt', 'payment'))->render();

        $tempDir = storage_path('app/mpdf');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // ✅ MPDF CONFIG – EXACTLY SAME AS INVOICE (तर default_font notosansdevanagari)
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'default_font_size' => 12,
            'default_font' => 'notosansdevanagari', // ✅ यो मुख्य परिवर्तन
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'tempDir' => $tempDir,
        ]);

        // ✅ WATERMARK – EXACTLY SAME AS INVOICE
        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            $mpdf->SetWatermarkImage($logoPath, 0.08, 'F', 'P');
            $mpdf->showWatermarkImage = true;
        }

        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        // ===== SAVE PDF =====
        $path = 'receipts/receipt_' . uniqid() . '.pdf';
        Storage::disk('public')->put($path, $pdfContent);

        $receipt->update(['pdf_path' => $path]);

        DB::commit();

        return redirect()->route('admin.receipts.show', $receipt)
            ->with('success', __('messages.receipt_generated_successfully'));

    } catch (MpdfException $e) {
        DB::rollBack();
        Log::error('Receipt PDF Generation Error: ' . $e->getMessage());
        return back()->with('error', 'Receipt generation failed: ' . $e->getMessage());
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Receipt Generation Error: ' . $e->getMessage());
        return back()->with('error', 'Receipt generation failed. Please try again.');
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