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
     * ✅ डुप्लिकेट जाँच, block_name, र registration_number ह्यान्डलिङ थपियो।
     */
    public function store(Request $request)
    {
        // ✅ block_name थपियो (वैकल्पिक)
        $validator = Validator::make($request->all(), [
            'hostel_name' => 'required|string|max:255',
            'hostel_name_english' => 'nullable|string|max:255',
            'hostel_type' => 'required|in:boys,girls,co-ed',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'pan' => 'nullable|string|max:50',              // ✅ 'unique' हटाइयो (पहिले नै थिएन)
            'capacity' => 'required|integer|min:1',
            'rooms' => 'nullable|integer|min:0',
            'operator_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',            // ✅ 'unique' हटाइयो
            'contact' => 'required|string|max:20',          // ✅ 'unique' हटाइयो
            'website' => 'nullable|url|max:255',
            'province' => 'required|exists:provinces,id',
            'district' => 'required|exists:districts,id',
            'municipality' => 'required|exists:municipalities,id',
            'ward' => 'required|integer|min:1|max:32',
            'street' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'block_name' => 'nullable|string|max:255',      // ✅ नयाँ
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'source' => 'sometimes|in:public,admin,import,renewal',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ✅ नामहरू लिनुहोस् (province, district, municipality)
        $provinceName = \App\Models\Province::find($request->province)?->name;
        $districtName = \App\Models\District::find($request->district)?->name;
        $municipalityName = \App\Models\Municipality::find($request->municipality)?->name;

        // ✅ डुप्लिकेट जाँच – province पठाउनु हुँदैन
        $duplicate = Hostel::checkDuplicate(
            $request->hostel_name,
            $districtName,
            $municipalityName,
            $request->ward,
            $request->street,
            $request->block_name ?? null
        );

        if ($duplicate) {
            return back()->withErrors([
                'hostel_name' => 'यसै नाम र ठेगानामा अर्को होस्टल पहिले नै दर्ता भएको छ। यदि यो फरक ब्लक हो भने कृपया "ब्लक / भवन नाम" भर्नुहोस्।'
            ])->withInput();
        }

        DB::beginTransaction();
        try {
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
                'block_name' => $request->block_name,        // ✅ थपियो
                // ❌ 'registration_number' हटाइयो – model event ले जनरेट गर्छ
            ]);

            // Upload documents and capture first photo path
            $firstPhotoPath = null;
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $type => $file) {
                    $path = $file->store('public/documents/' . $registration->id, 'public');
                    Document::create([
                        'registration_id' => $registration->id,
                        'type' => $type,
                        'file_path' => $path,
                        'uploaded_at' => now(),
                    ]);

                    if ($type === 'photos' && is_null($firstPhotoPath)) {
                        $firstPhotoPath = $path;
                    }
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
     * ✅ registration_number बाहेक सबै अपडेट गरिन्छ।
     */
    public function update(Request $request, Registration $registration)
    {
        // ✅ registration_number validation बाट हटाइयो
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
            'block_name' => 'nullable|string|max:255',      // ✅ थपियो
            'status' => 'required|in:pending,approved,active,rejected,duplicate,awaiting_payment,inspection',
        ]);

        // ✅ registration_number हटाउनुहोस् (सुरक्षाका लागि)
        $data = $request->except(['registration_number', '_token', '_method']);

        $registration->update($data);

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration updated.');
    }

    /**
     * Approve a registration.
     * ✅ Creates/updates the associated hostel and copies the first photo/signboard.
     */
    public function approve(Registration $registration)
    {
        if ($registration->status === 'approved' || $registration->status === 'active') {
            return back()->with('error', 'Registration is already approved or active.');
        }

        DB::beginTransaction();
        try {
            // ✅ 1. Ensure hostel exists (create if not)
            $this->ensureHostelExists($registration);

            // ✅ 2. Copy image from documents (signboard or photos)
            $imagePath = null;
            $doc = $registration->documents()->whereIn('type', ['signboard', 'photos'])->first();
            if ($doc && Storage::disk('public')->exists($doc->file_path)) {
                $filename = uniqid() . '_' . basename($doc->file_path);
                $newPath = 'hostels/' . $filename;
                Storage::disk('public')->copy($doc->file_path, $newPath);
                $imagePath = $newPath;
            }

            // ✅ 3. Update hostel with all registration data and image
            if ($registration->hostel_id) {
                $hostel = Hostel::find($registration->hostel_id);
                if ($hostel) {
                    $hostel->update([
                        'name_nepali' => $registration->hostel_name,
                        'name_english' => $registration->hostel_name_english,
                        'operator_name' => $registration->operator_name,
                        'contact' => $registration->contact,
                        'description' => $registration->description,
                        'province' => $registration->province,
                        'district' => $registration->district,
                        'municipality' => $registration->municipality,
                        'ward' => $registration->ward,
                        'street' => $registration->street,
                        'landmark' => $registration->landmark,
                        'type' => $registration->hostel_type,
                        'capacity' => $registration->capacity,
                        'rooms' => $registration->rooms,
                        'established_year' => $registration->established_year,
                        'email' => $registration->email,
                        'website' => $registration->website,
                        'image' => $imagePath ?? $hostel->image,
                        'approved' => true,
                        'visible' => true,
                    ]);
                }
            }

            // ✅ 4. Update registration status
            $registration->status = 'approved';
            $registration->approved_at = now();
            $registration->save();

            DB::commit();

            return redirect()->route('admin.registrations.show', $registration)
                ->with('success', 'Registration approved and hostel updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Approval failed: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Error during approval: ' . $e->getMessage()]);
        }
    }

    /**
     * Ensure a hostel exists for the registration.
     * ✅ refresh(), guard, र registration_number प्रतिलिपि थपियो।
     */
    private function ensureHostelExists(Registration $registration)
    {
        if ($registration->hostel_id) {
            return;
        }

        // Copy image from documents (signboard or photos)
        $imagePath = null;
        $doc = $registration->documents()->whereIn('type', ['signboard', 'photos'])->first();
        if ($doc && Storage::disk('public')->exists($doc->file_path)) {
            $filename = uniqid() . '_' . basename($doc->file_path);
            $newPath = 'hostels/' . $filename;
            Storage::disk('public')->copy($doc->file_path, $newPath);
            $imagePath = $newPath;
        }

        // ✅ Hostel सिर्जना गर्नुहोस् (block_name पनि पठाउनुहोस्)
        $hostel = Hostel::create([
            'name_nepali' => $registration->hostel_name,
            'name_english' => $registration->hostel_name_english,
            'operator_name' => $registration->operator_name,
            'contact' => $registration->contact,
            'description' => $registration->description,
            'province' => $registration->province,
            'district' => $registration->district,
            'municipality' => $registration->municipality,
            'ward' => $registration->ward,
            'street' => $registration->street,
            'landmark' => $registration->landmark,
            'type' => $registration->hostel_type,
            'capacity' => $registration->capacity,
            'rooms' => $registration->rooms,
            'established_year' => $registration->established_year,
            'email' => $registration->email,
            'website' => $registration->website,
            'block_name' => $registration->block_name ?? null,  // ✅ थपियो
            'image' => $imagePath,
            'approved' => true,
            'visible' => true,
            'featured' => false,
        ]);

        // ✅ ताजा मान ल्याउन refresh() – event बाट registration_number ल्याउँछ
        $hostel->refresh();

        $registration->hostel_id = $hostel->id;

        // ✅ Guard: यदि पहिले नै registration_number सेट छैन भने मात्र प्रतिलिपि गर्ने
        if (empty($registration->registration_number)) {
            $registration->registration_number = $hostel->registration_number;
        }

        $registration->save();
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