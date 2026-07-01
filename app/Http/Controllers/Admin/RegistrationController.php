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
use App\Models\Province;
use App\Models\District;
use App\Models\Municipality;
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
     */
    public function show(Registration $registration)
    {
        $registration->load('owner', 'hostel', 'documents', 'payments', 'invoices', 'certificates', 'inspections', 'duplicateReviews');
        $inspectors = User::where('role', 'inspector')->get();

        return view('admin.registrations.show', compact('registration', 'inspectors'));
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
     * ✅ Complete fix with proper validation and field mapping
     */
    public function store(Request $request)
    {
        // ✅ 1. Validation – सबै fields मिलाउनुहोस्
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
            // Documents – optional, फारममा required छ तर controller मा optional राख्न सकिन्छ
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // Payment fields
            'payment_status' => 'nullable|in:pending,submitted,verified,rejected',
            'payment_method' => 'nullable|in:bank,qr,cash',
            'payment_transaction_id' => 'nullable|string|max:255',
            'source' => 'sometimes|in:public,admin,import,renewal',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // ✅ 2. Province/District/Municipality को नाम ID बाट fetch
            $provinceName = Province::find($request->province)?->name;
            $districtName = District::find($request->district)?->name;
            $municipalityName = Municipality::find($request->municipality)?->name;

            // ✅ 3. Registration create – सही columns मात्र
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

            // ✅ 4. Documents upload – documents table मा save
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $type => $file) {
                    // $type = 'pan', 'citizenship', 'license', etc.
                    $path = $file->store('public/documents/' . $registration->id, 'public');
                    Document::create([
                        'registration_id' => $registration->id,
                        'type' => $type,
                        'file_path' => $path,
                        'uploaded_at' => now(),
                    ]);
                }
            }

            // ✅ 5. Payment (यदि payment_method भरिएको छ भने)
            if ($request->filled('payment_method')) {
                // मानौं Payment model छ र payment create गर्नुहोस्
                // (तपाईंको आवश्यकता अनुसार)
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
     * Creates a Hostel record and updates registration status.
     */
    public function approve(Registration $registration)
    {
        if ($registration->status === 'approved') {
            return back()->with('error', 'Registration is already approved.');
        }

        DB::beginTransaction();
        try {
            $registration->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            $hostelData = [
                'name_nepali'    => $registration->hostel_name ?? 'N/A',
                'name_english'   => $registration->hostel_name_english ?? $registration->hostel_name ?? 'N/A',
                'operator_name'  => optional($registration->owner)->name ?? $registration->operator_name ?? 'N/A',
                'contact'        => $registration->contact ?? 'N/A',
                'description'    => $registration->description ?? null,
                'province'       => $registration->province ?? null,
                'district'       => $registration->district ?? 'Unknown',
                'municipality'   => $registration->municipality ?? 'Unknown',
                'ward'           => $registration->ward ?? '0',
                'street'         => $registration->street ?? null,
                'landmark'       => $registration->landmark ?? null,
                'type'           => $registration->hostel_type ?? null,
                'capacity'       => $registration->capacity ?? 0,
                'rooms'          => $registration->rooms ?? $registration->capacity ?? 0,
                'established_year' => $registration->established_year ?? null,
                'email'          => $registration->email ?? null,
                'website'        => $registration->website ?? null,
                'approved'       => true,
                'visible'        => true,
                'featured'       => false,
                'owner_id'       => $registration->owner_id ?? null,
            ];

            if ($registration->hostel_id) {
                $hostel = Hostel::find($registration->hostel_id);
                if ($hostel) {
                    $hostel->update($hostelData);
                } else {
                    $hostel = Hostel::create($hostelData);
                    $registration->update(['hostel_id' => $hostel->id]);
                }
            } else {
                $hostel = Hostel::create($hostelData);
                $registration->update(['hostel_id' => $hostel->id]);
            }

            DB::commit();

            return redirect()->route('admin.registrations.index')
                ->with('success', 'Registration approved and hostel created/updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve: ' . $e->getMessage());
        }
    }

    /**
     * Reject a registration.
     */
    public function reject(Registration $registration)
    {
        if ($registration->status === 'approved') {
            return back()->with('error', 'Cannot reject an already approved registration.');
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

    // पहिले नै पेन्डिङ inspection छ कि छैन check गर्नुहोस्
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
     * Download an invoice (for admin).
     */
    public function downloadInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (!Storage::disk('public')->exists($invoice->pdf_path)) {
            abort(404, 'File not found.');
        }

        return response()->download(
            storage_path('app/public/' . $invoice->pdf_path),
            'invoice_' . $invoice->invoice_number . '.pdf'
        );
    }

    /**
     * (Optional) Show a list of all documents for a registration.
     */
    public function documents(Registration $registration)
    {
        $documents = $registration->documents;
        return view('admin.registrations.documents', compact('registration', 'documents'));
    }
}