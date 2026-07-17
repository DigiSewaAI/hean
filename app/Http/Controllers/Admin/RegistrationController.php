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
use App\Exports\RegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;

class RegistrationController extends Controller
{
    /**
 * List all registrations with advanced search/filter.
 */
public function index(Request $request)
{
    $query = Registration::with('owner', 'hostel');

    // ===== 1. BASIC SEARCH (Multiple Fields) =====
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('hostel_name', 'LIKE', "%{$search}%")
              ->orWhere('hostel_name_english', 'LIKE', "%{$search}%")
              ->orWhere('operator_name', 'LIKE', "%{$search}%")
              ->orWhere('contact', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('pan', 'LIKE', "%{$search}%")
              ->orWhere('registration_number', 'LIKE', "%{$search}%")
              ->orWhere('local_registration_number', 'LIKE', "%{$search}%");
        });
    }

    // ===== 2. ADVANCED SEARCH: Local Registration Number =====
    if ($request->filled('local_reg_number')) {
        $query->where('local_registration_number', 'LIKE', "%{$request->local_reg_number}%");
    }

    // ===== 3. FILTER: Status =====
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // ===== 4. FILTER: Source (Public/Admin) =====
    if ($request->filled('source')) {
        $query->where('source', $request->source);
    }

    // ===== 5. FILTER: District =====
    if ($request->filled('district')) {
        $query->where('district', $request->district);
    }

    // ===== 6. FILTER: Submitted Date Range =====
    if ($request->filled('date_from')) {
        $query->whereDate('submitted_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('submitted_at', '<=', $request->date_to);
    }

    // ===== 7. SORTING =====
    switch ($request->sort) {
        case 'oldest':
            $query->oldest();
            break;
        case 'reg_number_asc':
            $query->orderBy('registration_number', 'asc');
            break;
        case 'reg_number_desc':
            $query->orderBy('registration_number', 'desc');
            break;
        case 'status_asc':
            $query->orderBy('status', 'asc');
            break;
        case 'status_desc':
            $query->orderBy('status', 'desc');
            break;
        default:
            $query->latest();
            break;
    }

    // ===== PAGINATE =====
    $registrations = $query->paginate(15)->appends($request->query());

    // ===== STATS =====
    $totalRegistrations = Registration::count();
    $pendingCount = Registration::where('status', 'pending')->count();
    $approvedCount = Registration::where('status', 'approved')->count();
    $rejectedCount = Registration::where('status', 'rejected')->count();

    // ===== DISTINCT DISTRICTS FOR DROPDOWN =====
    $districts = Registration::select('district')->distinct()->orderBy('district')->pluck('district');

    return view('admin.registrations.index', compact(
        'registrations',
        'totalRegistrations',
        'pendingCount',
        'approvedCount',
        'rejectedCount',
        'districts'
    ));
}

    /**
     * Show a single registration with all related data.
     */
    public function show(Registration $registration)
    {
        $registration->load([
            'owner',
            'hostel',
            'uploadedDocuments',
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
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
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
            'local_registration_number' => 'nullable|string|max:100',

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
                'block_name' => $request->block_name,
                'local_registration_number' => $request->local_registration_number,
            ]);

            // Upload documents and capture first photo path
            $firstPhotoPath = null;
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $type => $file) {
                    // अब (cloud डिस्क)
$path = $file->store('documents/' . $registration->id, 'cloud');
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
    $data = $request->validate([
        'hostel_name' => 'required|string|max:255',
        'hostel_name_english' => 'nullable|string|max:255',
        'hostel_type' => 'required|in:boys,girls,co-ed',
        'capacity' => 'required|integer|min:1',
        'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
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
        'block_name' => 'nullable|string|max:255',
        'status' => 'required|in:pending,approved,active,rejected,duplicate,awaiting_payment,inspection',
        'local_registration_number' => 'nullable|string|max:100',
    ]);

    $data = $request->except(['registration_number', '_token', '_method']);
    $registration->update($data);

    if ($request->hasFile('documents')) {
        foreach ($request->file('documents') as $type => $file) {
            if ($type === 'additional' && is_array($file)) {
                foreach ($file as $f) {
                    if ($f) {
                        $path = $f->store('documents/' . $registration->id, 'cloud');
                        Document::create([
                            'registration_id' => $registration->id,
                            'type' => $type,
                            'file_path' => $path,
                            'uploaded_at' => now(),
                        ]);
                    }
                }
            } else {
                if ($file) {
                    $path = $file->store('documents/' . $registration->id, 'cloud');
                    Document::create([
                        'registration_id' => $registration->id,
                        'type' => $type,
                        'file_path' => $path,
                        'uploaded_at' => now(),
                    ]);
                }
            }
        }
    }

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
            $doc = $registration->uploadedDocuments()->whereIn('type', ['signboard', 'photos'])->first();
            if ($doc) {
    $cleanPath = str_replace('public/', '', $doc->file_path);
    if (Storage::disk('cloud')->exists($cleanPath)) {
        $filename = uniqid() . '_' . basename($doc->file_path);
        $newPath = 'hostels/' . $filename;
        // cloud बाट public/local मा copy गर्नु पर्छ भने (तर सामान्यतया हामी सिधा URL प्रयोग गर्छौं)
        // यदि hostel image पनि cloud मै राख्ने हो भने:
        Storage::disk('cloud')->copy($cleanPath, $newPath);
        $imagePath = $newPath;
    }
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
                        'local_registration_number' => $registration->local_registration_number,
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
        $doc = $registration->uploadedDocuments()->whereIn('type', ['signboard', 'photos'])->first();
        if ($doc) {
    $cleanPath = str_replace('public/', '', $doc->file_path);
    if (Storage::disk('cloud')->exists($cleanPath)) {
        $filename = uniqid() . '_' . basename($doc->file_path);
        $newPath = 'hostels/' . $filename;
        // cloud बाट public/local मा copy गर्नु पर्छ भने (तर सामान्यतया हामी सिधा URL प्रयोग गर्छौं)
        // यदि hostel image पनि cloud मै राख्ने हो भने:
        Storage::disk('cloud')->copy($cleanPath, $newPath);
        $imagePath = $newPath;
    }
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
            'block_name' => $registration->block_name ?? null,
            'local_registration_number' => $registration->local_registration_number,
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
    public function downloadDocument(Document $document)
{
    $cleanPath = str_replace('public/', '', $document->file_path);

    if (Storage::disk('cloud')->exists($cleanPath)) {
        return Storage::disk('cloud')->download($cleanPath);
    }

    if (Storage::disk('public')->exists($document->file_path)) {
        return Storage::disk('public')->download($document->file_path);
    }

    abort(404, 'File not found.');
}

    /**
     * (Legacy) Download an invoice - replaced by InvoiceController.
     */
    public function downloadInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        return redirect()->route('admin.invoices.download', $invoice);
    }
    public function export(Request $request)
{
    $filters = $request->only([
        'search', 'status', 'source', 'district',
        'local_reg_number', 'date_from', 'date_to'
    ]);

    $export = new RegistrationsExport($filters);
    return Excel::download($export, 'registrations_' . date('Y-m-d') . '.xlsx');
}
/**
 * Delete a document (and remove file from storage).
 */
public function deleteDocument(Document $document)
{
    // File path सफा गर्नुहोस् (किनभने store गर्दा 'public/' prefix आउन सक्छ)
    $cleanPath = str_replace('public/', '', $document->file_path);

    // पहिले cloud मा छ कि जाँच गर्नुहोस् (किनभने store मा cloud प्रयोग भएको छ)
    if (Storage::disk('cloud')->exists($cleanPath)) {
        Storage::disk('cloud')->delete($cleanPath);
    }
    // पुराना public मा भएका फाइलहरूको लागि fallback
    elseif (Storage::disk('public')->exists($document->file_path)) {
        Storage::disk('public')->delete($document->file_path);
    }

    $document->delete();

    return back()->with('success', 'Document deleted successfully.');
}

}