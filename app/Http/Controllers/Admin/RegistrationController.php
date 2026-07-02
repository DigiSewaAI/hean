<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\Registration;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Inspection;
use App\Models\DuplicateReview;
use App\Models\User;
use App\Services\DuplicateDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    /**
     * List all registrations.
     */
    public function index()
    {
        $registrations = Registration::with('owner', 'hostel')
            ->latest()
            ->paginate(15);

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Show a single registration with all related data.
     * ✅ FIXED: Loads all necessary relationships for clean UI.
     */
    public function show(Registration $registration)
    {
        $registration->load([
            'owner',
            'hostel',
            'documents',
            'payments' => function($q) {
                $q->latest();
            },
            'invoices' => function($q) {
                $q->latest();
            },
            'certificates',
            'inspections' => function($q) {
                $q->latest();
            },
            'duplicateReviews' => function($q) {
                $q->latest();
            },
            'receipts' => function($q) {
                $q->latest();
            }
        ]);

        // Get inspectors for assignment
        $inspectors = User::where('role', 'inspector')->get();

        // Calculate financial summary
        $totalInvoiced = $registration->invoices->sum('amount');
        $totalPaid = $registration->payments->where('status', 'verified')->sum('amount');
        $outstanding = max(0, $totalInvoiced - $totalPaid);
        $latestInvoice = $registration->invoices->sortByDesc('id')->first();
        $latestPayment = $registration->payments->sortByDesc('id')->first();
        $latestReceipt = $registration->receipts->sortByDesc('id')->first();

        return view('admin.registrations.show', compact(
            'registration',
            'inspectors',
            'totalInvoiced',
            'totalPaid',
            'outstanding',
            'latestInvoice',
            'latestPayment',
            'latestReceipt'
        ));
    }

    /**
     * Show form to create a new registration (admin manual).
     */
    public function create()
    {
        return view('admin.registrations.create');
    }

    /**
     * Store a new registration (admin manual).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hostel_name' => 'required|string|max:255',
            'hostel_name_english' => 'nullable|string|max:255',
            'hostel_type' => 'required|in:boys,girls,co-ed',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'pan' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1',
            'rooms' => 'nullable|integer|min:0',
            'operator_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'province' => 'required|exists:provinces,id',
            'district' => 'required|exists:districts,id',
            'municipality' => 'required|exists:municipalities,id',
            'ward' => 'required|integer|min:1|max:32',
            'street' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'source' => 'sometimes|in:public,admin,import,renewal',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $provinceName = \App\Models\Province::find($request->province)?->name;
            $districtName = \App\Models\District::find($request->district)?->name;
            $municipalityName = \App\Models\Municipality::find($request->municipality)?->name;

            $registration = Registration::create([
                'source' => $request->source ?? 'admin',
                'submitted_at' => now(),
                'status' => 'pending',
                'hostel_name' => $request->hostel_name,
                'hostel_name_english' => $request->hostel_name_english,
                'hostel_type' => $request->hostel_type,
                'established_year' => $request->established_year,
                'pan' => $request->pan,
                'capacity' => $request->capacity,
                'rooms' => $request->rooms,
                'operator_name' => $request->operator_name,
                'contact' => $request->contact,
                'email' => $request->email,
                'website' => $request->website,
                'description' => $request->description,
                'province' => $provinceName,
                'district' => $districtName,
                'municipality' => $municipalityName,
                'ward' => $request->ward,
                'street' => $request->street,
                'landmark' => $request->landmark,
            ]);

            // Upload documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $type => $file) {
                    $path = $file->store('public/documents/' . $registration->id, 'public');
                    Document::create([
                        'registration_id' => $registration->id,
                        'type' => $type,
                        'file_path' => $path,
                        'uploaded_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.registrations.index')
                ->with('success', 'Registration created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Admin registration failed: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show edit form.
     */
    public function edit(Registration $registration)
    {
        return view('admin.registrations.edit', compact('registration'));
    }

    /**
     * Update registration.
     */
    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate([
            'hostel_name' => 'required|string|max:255',
            'hostel_name_english' => 'nullable|string|max:255',
            'hostel_type' => 'required|in:boys,girls,co-ed',
            'capacity' => 'required|integer|min:1',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'municipality' => 'required|string|max:100',
            'ward' => 'required|string|max:10',
            'street' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'pan' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
        ]);

        $registration->update($data);

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration updated.');
    }

    /**
     * Approve a registration.
     */
    public function approve(Registration $registration)
    {
        if ($registration->status === 'approved') {
            return back()->with('error', 'Registration is already approved.');
        }

        if ($registration->status === 'active') {
            return back()->with('error', 'Registration is already active.');
        }

        $registration->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.registrations.show', $registration)
            ->with('success', 'Registration approved. You can now generate an invoice.');
    }

    /**
     * Reject a registration.
     */
    public function reject(Registration $registration)
    {
        if ($registration->status === 'approved' || $registration->status === 'active') {
            return back()->with('error', 'Cannot reject an approved or active registration.');
        }

        $registration->update(['status' => 'rejected']);

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration rejected.');
    }

    /**
     * Assign an inspector to a registration.
     */
    public function assignInspector(Request $request, Registration $registration)
    {
        $request->validate([
            'inspector_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'remarks' => 'nullable|string|max:500',
        ]);

        if ($registration->inspections()->where('status', 'scheduled')->exists()) {
            return back()->with('error', 'An inspection is already scheduled for this registration.');
        }

        $inspection = Inspection::create([
            'registration_id' => $registration->id,
            'inspector_id' => $request->inspector_id,
            'scheduled_date' => $request->scheduled_date,
            'remarks' => $request->remarks,
            'status' => 'scheduled',
        ]);

        return back()->with('success', 'Inspector assigned and inspection scheduled.');
    }

    /**
     * List registrations that need duplicate review.
     */
    public function duplicateReviews()
    {
        $registrations = Registration::where('status', 'approved')
            ->whereDoesntHave('duplicateReviews')
            ->with('owner', 'hostel')
            ->latest()
            ->paginate(10);

        return view('admin.duplicate_review.index', compact('registrations'));
    }

    /**
     * Review a registration for duplication.
     */
    public function reviewDuplicate(Request $request, Registration $registration)
    {
        $request->validate([
            'is_duplicate' => 'required|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = new DuplicateDetectionService();
        $service->markReviewed($registration, $request->is_duplicate, $request->notes);

        if ($request->is_duplicate) {
            $registration->update(['status' => 'duplicate']);
        }

        return back()->with('success', 'Duplicate review recorded.');
    }

    /**
     * Download a document (for admin).
     */
    public function downloadDocument($id)
    {
        $document = Document::findOrFail($id);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return response()->download(
            storage_path('app/public/' . $document->file_path),
            basename($document->file_path)
        );
    }

    /**
     * (Legacy) Download an invoice - replaced by InvoiceController.
     */
    public function downloadInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        return redirect()->route('admin.invoices.download', $invoice);
    }
}