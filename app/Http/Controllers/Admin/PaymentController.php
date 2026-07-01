<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments with filters.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['registration', 'invoice']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                  ->orWhere('method', 'LIKE', "%{$search}%")
                  ->orWhereHas('registration', function($r) use ($search) {
                      $r->where('hostel_name', 'LIKE', "%{$search}%")
                        ->orWhere('registration_number', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }
        if ($request->filled('registration_id')) {
            $query->where('registration_id', $request->registration_id);
        }

        // Sorting
        $sort = $request->sort ?? 'latest';
        if ($sort === 'latest') {
            $query->latest();
        } elseif ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'amount_asc') {
            $query->orderBy('amount', 'asc');
        } elseif ($sort === 'amount_desc') {
            $query->orderBy('amount', 'desc');
        } else {
            $query->latest();
        }

        $payments = $query->paginate(15)->appends($request->query());

        // Stats for summary
        $totalPayments = Payment::sum('amount');
        $pendingCount = Payment::where('status', 'pending')->count();
        $verifiedCount = Payment::where('status', 'verified')->count();

        // Get registration list for filter dropdown
        $registrations = Registration::select('id', 'hostel_name', 'registration_number')
            ->orderBy('hostel_name')
            ->get();

        return view('admin.payments.index', compact('payments', 'totalPayments', 'pendingCount', 'verifiedCount', 'registrations'));
    }

    /**
     * Show form to create a new payment.
     */
    public function create()
    {
        $registrations = Registration::with('hostel')
            ->whereIn('status', ['approved', 'pending']) // Only active or pending registrations
            ->get();
        // For invoice linking, we need pending invoices for each registration
        // We'll handle selection dynamically via AJAX or we can load all invoices
        $invoices = Invoice::where('status', 'pending')->get(); // only pending invoices can be paid

        return view('admin.payments.create', compact('registrations', 'invoices'));
    }

    /**
     * Store a new payment.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_id' => 'required|exists:registrations,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'method' => 'required|string|in:bank,esewa,khalti,cash',
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
            $payment = Payment::create([
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

            // If linked to invoice, update invoice status based on total payments
            if ($payment->invoice_id) {
                $this->updateInvoicePaymentStatus($payment->invoice);
            }

            DB::commit();

            return redirect()->route('admin.payments.index')
                ->with('success', __('messages.payment_created_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment creation failed: ' . $e->getMessage());
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
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
    $registrations = Registration::with('hostel')->get();
    
    // बाँकी (pending) invoices र हालको payment को invoice (यदि छ भने) ल्याउने
    $invoices = Invoice::where('status', 'pending')
        ->when($payment->invoice_id, function ($query) use ($payment) {
            // यदि payment कुनै invoice सँग linked छ भने त्यो पनि ल्याउने (चाहे त्यो pending नभए पनि)
            return $query->orWhere('id', $payment->invoice_id);
        })
        ->get();

    return view('admin.payments.edit', compact('payment', 'registrations', 'invoices'));
}

    /**
     * Update payment.
     */
    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(), [
            'registration_id' => 'required|exists:registrations,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'method' => 'required|string|in:bank,esewa,khalti,cash',
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
                    $this->updateInvoicePaymentStatus($oldInvoice);
                }
            }
            if ($payment->invoice_id) {
                $this->updateInvoicePaymentStatus($payment->invoice);
            }

            DB::commit();

            return redirect()->route('admin.payments.index')
                ->with('success', __('messages.payment_updated_successfully'));

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
        DB::beginTransaction();
        try {
            $invoiceId = $payment->invoice_id;
            $payment->delete();

            if ($invoiceId) {
                $invoice = Invoice::find($invoiceId);
                if ($invoice) {
                    $this->updateInvoicePaymentStatus($invoice);
                }
            }

            DB::commit();
            return redirect()->route('admin.payments.index')
                ->with('success', __('messages.payment_deleted_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment deletion failed: ' . $e->getMessage());
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    /**
     * Verify a payment (change status to verified).
     */
    public function verify(Payment $payment)
    {
        if ($payment->status === 'verified') {
            return back()->with('error', __('messages.payment_already_verified'));
        }

        DB::beginTransaction();
        try {
            $payment->update(['status' => 'verified']);
            if ($payment->invoice_id) {
                $this->updateInvoicePaymentStatus($payment->invoice);
            }
            DB::commit();
            return back()->with('success', __('messages.payment_verified_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reject a payment.
     */
    public function reject(Payment $payment)
    {
        if ($payment->status === 'verified') {
            return back()->with('error', __('messages.cannot_reject_verified_payment'));
        }
        $payment->update(['status' => 'rejected']);
        if ($payment->invoice_id) {
            $this->updateInvoicePaymentStatus($payment->invoice);
        }
        return back()->with('success', __('messages.payment_rejected_successfully'));
    }

    /**
     * Refund a payment.
     */
    public function refund(Payment $payment)
    {
        if ($payment->status !== 'verified') {
            return back()->with('error', __('messages.cannot_refund_unverified_payment'));
        }
        $payment->update(['status' => 'refunded']);
        if ($payment->invoice_id) {
            $this->updateInvoicePaymentStatus($payment->invoice);
        }
        return back()->with('success', __('messages.payment_refunded_successfully'));
    }

    /**
     * Helper: Update invoice payment status based on total paid vs amount.
     */
    private function updateInvoicePaymentStatus(Invoice $invoice)
    {
        $totalPaid = $invoice->payments()
            ->where('status', 'verified')
            ->sum('amount');

        if ($totalPaid >= $invoice->amount) {
            $invoice->status = 'paid';
        } elseif ($totalPaid > 0) {
            $invoice->status = 'partial';
        } else {
            $invoice->status = 'pending';
        }

        // Check due date for overdue
        if ($invoice->due_date && $invoice->due_date < now() && $invoice->status !== 'paid') {
            $invoice->status = 'overdue';
        }

        $invoice->save();
    }
}