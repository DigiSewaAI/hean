<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Services\PaymentService;
use App\Events\PaymentVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
 * Display a listing of payments with advanced search/filter.
 */
public function index(Request $request)
{
    $query = Payment::with(['registration', 'invoice']);

    // ===== 1. BASIC SEARCH (Multiple Fields) =====
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('transaction_id', 'LIKE', "%{$search}%")
              ->orWhere('method', 'LIKE', "%{$search}%")
              ->orWhere('bank_name', 'LIKE', "%{$search}%")
              ->orWhere('bank_account', 'LIKE', "%{$search}%")
              ->orWhereHas('registration', function ($r) use ($search) {
                  $r->where('hostel_name', 'LIKE', "%{$search}%")
                    ->orWhere('hostel_name_english', 'LIKE', "%{$search}%")
                    ->orWhere('registration_number', 'LIKE', "%{$search}%")
                    ->orWhere('local_registration_number', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('invoice', function ($i) use ($search) {
                  $i->where('invoice_number', 'LIKE', "%{$search}%");
              });
        });
    }

    // ===== 2. FILTER: Status =====
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // ===== 3. FILTER: Payment Method =====
    if ($request->filled('method')) {
        $query->where('method', $request->method);
    }

    // ===== 4. FILTER: Amount Range =====
    if ($request->filled('amount_min')) {
        $query->where('amount', '>=', $request->amount_min);
    }
    if ($request->filled('amount_max')) {
        $query->where('amount', '<=', $request->amount_max);
    }

    // ===== 5. FILTER: Date Range (Payment Date) =====
    if ($request->filled('date_from')) {
        $query->whereDate('payment_date', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('payment_date', '<=', $request->date_to);
    }

    // ===== 6. FILTER: Registration (Specific) =====
    if ($request->filled('registration_id')) {
        $query->where('registration_id', $request->registration_id);
    }

    // ===== 7. SORTING =====
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
        case 'date_asc':
            $query->orderBy('payment_date', 'asc');
            break;
        default:
            $query->latest();
            break;
    }

    // ===== PAGINATE =====
    $payments = $query->paginate(15)->appends($request->query());

    // ===== STATS =====
    $totalPayments = Payment::sum('amount');
    $pendingCount = Payment::where('status', 'pending')->count();
    $verifiedCount = Payment::where('status', 'verified')->count();
    $rejectedCount = Payment::where('status', 'rejected')->count();
    $refundedCount = Payment::where('status', 'refunded')->count();

    // ===== DISTINCT METHODS FOR DROPDOWN =====
    $methods = Payment::select('method')->distinct()->pluck('method');

    // ===== REGISTRATIONS FOR DROPDOWN =====
    $registrations = Registration::select('id', 'hostel_name', 'registration_number')
        ->orderBy('hostel_name')
        ->get();

    return view('admin.payments.index', compact(
        'payments',
        'totalPayments',
        'pendingCount',
        'verifiedCount',
        'rejectedCount',
        'refundedCount',
        'methods',
        'registrations'
    ));
}

    /**
     * Show form to create a new payment.
     * ✅ FIXED: Preloads invoice when invoice_id is passed.
     * ✅ Redirects if no invoice_id is provided.
     */
    public function create(Request $request)
{
    $invoiceId = $request->query('invoice_id');
    $registrationId = $request->query('registration_id');

    // If invoice_id is provided, use it
    if ($invoiceId) {
        $invoice = Invoice::with('registration')->findOrFail($invoiceId);
        $selectedInvoice = $invoice;
        $selectedRegistration = $invoice->registration;

        // ✅ FIX: Only block if invoice is already paid
        if ($invoice->status === 'paid') {
            return redirect()->route('admin.invoices.show', $invoice)
                ->with('error', 'This invoice is already fully paid.');
        }

        // Get the invoice's registration
        $registration = $invoice->registration;
        if (!$registration) {
            abort(404, 'Registration not found for this invoice.');
        }

        return view('admin.payments.create', compact(
            'selectedInvoice',
            'selectedRegistration',
            'invoice',
            'registration'
        ));
    }

    // If registration_id is provided, use it
    if ($registrationId) {
        $registration = Registration::with('invoices')->findOrFail($registrationId);
        $selectedRegistration = $registration;
        $pendingInvoices = $registration->invoices()
            ->whereIn('status', ['pending', 'partial', 'overdue']) // ✅ Include overdue
            ->get();

        if ($pendingInvoices->isEmpty()) {
            return redirect()->route('admin.registrations.show', $registration)
                ->with('error', 'No pending or partial invoices found for this registration.');
        }

        $selectedInvoice = $pendingInvoices->first();

        return view('admin.payments.create', compact(
            'selectedInvoice',
            'selectedRegistration',
            'registration'
        ));
    }

    // No context provided - redirect to invoice list
    return redirect()->route('admin.invoices.index')
        ->with('error', 'Please select an invoice first.');
}

    /**
     * Store a new payment.
     * ✅ FIXED: Validates invoice_id and registration_id match.
     * ✅ Updates invoice status.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id',
            'registration_id' => 'required|exists:registrations,id',
            'method' => 'required|string|in:bank,esewa,khalti,cash,qr',
            'amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ✅ Validate that registration_id matches the invoice's registration
        $invoice = Invoice::with('registration')->find($request->invoice_id);
        if (!$invoice) {
            return back()->withErrors(['invoice_id' => 'Invoice not found.'])->withInput();
        }

        if ($invoice->registration_id != $request->registration_id) {
            return back()->withErrors(['registration_id' => 'Registration does not match this invoice.'])->withInput();
        }

        // Check if invoice is already fully paid
        $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
        if ($totalPaid >= $invoice->amount) {
            return back()->with('error', 'This invoice is already fully paid.')->withInput();
        }

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'registration_id' => $request->registration_id,
                'invoice_id' => $request->invoice_id,
                'method' => $request->method,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_date' => $request->payment_date,
                'bank_name' => $request->bank_name,
                'bank_account' => $request->bank_account,
                'status' => 'pending', // Always pending on creation
                'remarks' => $request->remarks,
            ]);

            // ✅ Update invoice status after adding payment
            app(PaymentService::class)->updateInvoiceStatus($invoice);

            DB::commit();

            return redirect()->route('admin.payments.show', $payment)
                ->with('success', 'Payment created successfully. Please verify the payment to continue.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment creation failed: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show a single payment.
     */
    public function show(Payment $payment)
    {
        $payment->load(['registration', 'invoice', 'receipts']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show form to edit payment.
     */
    public function edit(Payment $payment)
    {
        if ($payment->status === 'verified') {
            return redirect()->route('admin.payments.show', $payment)
                ->with('error', 'Verified payments cannot be edited.');
        }

        $registrations = Registration::with('hostel')->get();
        $invoices = Invoice::where('status', 'pending')
            ->orWhere('id', $payment->invoice_id)
            ->get();

        return view('admin.payments.edit', compact('payment', 'registrations', 'invoices'));
    }

    /**
     * Update payment.
     */
    public function update(Request $request, Payment $payment)
    {
        if ($payment->status === 'verified') {
            return redirect()->route('admin.payments.show', $payment)
                ->with('error', 'Verified payments cannot be edited.');
        }

        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id',
            'registration_id' => 'required|exists:registrations,id',
            'method' => 'required|string|in:bank,esewa,khalti,cash,qr',
            'amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'status' => 'required|in:pending,verified,rejected,refunded',
            'remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $oldInvoiceId = $payment->invoice_id;

            $payment->update([
                'registration_id' => $request->registration_id,
                'invoice_id' => $request->invoice_id,
                'method' => $request->method,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_date' => $request->payment_date,
                'bank_name' => $request->bank_name,
                'bank_account' => $request->bank_account,
                'status' => $request->status,
                'remarks' => $request->remarks,
            ]);

            // Update invoice statuses for both old and new invoice
            if ($oldInvoiceId && $oldInvoiceId != $payment->invoice_id) {
                $oldInvoice = Invoice::find($oldInvoiceId);
                if ($oldInvoice) {
                    app(PaymentService::class)->updateInvoiceStatus($oldInvoice);
                }
            }
            if ($payment->invoice_id) {
                app(PaymentService::class)->updateInvoiceStatus($payment->invoice);
            }

            DB::commit();

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment update failed: ' . $e->getMessage());
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Delete payment.
     */
    public function destroy(Payment $payment)
    {
        if ($payment->status === 'verified') {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Verified payments cannot be deleted.');
        }

        DB::beginTransaction();
        try {
            $invoiceId = $payment->invoice_id;
            $payment->delete();

            if ($invoiceId) {
                $invoice = Invoice::find($invoiceId);
                if ($invoice) {
                    app(PaymentService::class)->updateInvoiceStatus($invoice);
                }
            }

            DB::commit();
            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment deletion failed: ' . $e->getMessage());
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    /**
     * Verify a payment.
     * ✅ Triggers PaymentVerified event → Receipt generation + Activation.
     */
    /**
 * Verify a payment.
 */
public function verify(Payment $payment)
{
    if ($payment->status === 'verified') {
        return back()->with('error', 'Payment already verified.');
    }

    if ($payment->status !== 'pending') {
        return back()->with('error', 'Only pending payments can be verified.');
    }

    DB::beginTransaction();
    try {
        $payment->status = 'verified';
        $payment->verified_at = now();
        $payment->verified_by = auth()->id();
        $payment->save();

        if ($payment->invoice) {
            app(PaymentService::class)->updateInvoiceStatus($payment->invoice);
        }

        // ✅ Dispatch event
        event(new PaymentVerified($payment, auth()->id()));

        DB::commit();

        return back()->with('success', 'Payment verified successfully. Receipt and activation triggered.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Payment verification failed: ' . $e->getMessage());
        return back()->with('error', 'Verification failed: ' . $e->getMessage());
    }
}

    /**
     * Reject a payment.
     */
    public function reject(Payment $payment)
    {
        if ($payment->status === 'verified') {
            return back()->with('error', 'Cannot reject a verified payment.');
        }

        $payment->update(['status' => 'rejected']);
        if ($payment->invoice_id) {
            app(PaymentService::class)->updateInvoiceStatus($payment->invoice);
        }
        return back()->with('success', 'Payment rejected successfully.');
    }

    /**
     * Refund a payment.
     */
    public function refund(Request $request, Payment $payment)
    {
        if ($payment->status !== 'verified') {
            return back()->with('error', 'Cannot refund unverified payment.');
        }

        $request->validate([
            'refund_reason' => 'nullable|string|max:500',
        ]);

        $payment->update([
            'status' => 'refunded',
            'refunded_at' => now(),
            'refunded_by' => auth()->id(),
            'refund_reason' => $request->refund_reason,
        ]);

        if ($payment->invoice_id) {
            app(PaymentService::class)->updateInvoiceStatus($payment->invoice);
        }

        return back()->with('success', 'Payment refunded successfully.');
    }
}