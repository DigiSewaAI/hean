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
        // For simplicity, we might just redirect to public registration or create a form.
        // Here we can show a form to select an existing user/owner, or create new.
        // We'll assume we have a form.
        return view('admin.registrations.create');
    }

    /**
     * Store a new registration (admin manual).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'owner_id' => 'nullable|exists:users,id',
            'hostel_name' => 'required|string|max:255',
            'hostel_type' => 'required|in:boys,girls,co-ed',
            'capacity' => 'required|integer|min:1',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'contact_number' => 'required|string|max:20',
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
            'source' => 'sometimes|in:public,admin,import,renewal',
        ]);

        // If owner_id is not provided, create a new owner? For admin, we may require owner_id.
        // We'll set a default source.
        $data['source'] = $data['source'] ?? 'admin';
        $data['submitted_at'] = now();
        $data['status'] = 'pending';

        // Create registration
        $registration = Registration::create($data);

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration created successfully.');
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
            'hostel_type' => 'required|in:boys,girls,co-ed',
            'capacity' => 'required|integer|min:1',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'contact_number' => 'required|string|max:20',
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
        // Prevent duplicate approval
        if ($registration->status === 'approved') {
            return back()->with('error', 'Registration is already approved.');
        }

        DB::beginTransaction();
        try {
            // Update registration
            $registration->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            // Create or update the associated hostel
            if ($registration->hostel_id) {
                $hostel = Hostel::find($registration->hostel_id);
                if ($hostel) {
                    $hostel->update([
                        'name' => $registration->hostel_name,
                        'type' => $registration->hostel_type,
                        'capacity' => $registration->capacity,
                        'established_year' => $registration->established_year,
                        'contact_number' => $registration->contact_number,
                        'email' => $registration->email,
                        'website' => $registration->website,
                        'description' => $registration->description,
                        'province' => $registration->province,
                        'district' => $registration->district,
                        'municipality' => $registration->municipality,
                        'ward' => $registration->ward,
                        'street' => $registration->street,
                        'landmark' => $registration->landmark,
                        'approved' => true,
                        'visible' => true,
                    ]);
                }
            } else {
                // Create new hostel from registration data
                $hostel = Hostel::create([
                    'name' => $registration->hostel_name,
                    'type' => $registration->hostel_type,
                    'capacity' => $registration->capacity,
                    'established_year' => $registration->established_year,
                    'contact_number' => $registration->contact_number,
                    'email' => $registration->email,
                    'website' => $registration->website,
                    'description' => $registration->description,
                    'province' => $registration->province,
                    'district' => $registration->district,
                    'municipality' => $registration->municipality,
                    'ward' => $registration->ward,
                    'street' => $registration->street,
                    'landmark' => $registration->landmark,
                    'owner_id' => $registration->owner_id,
                    'approved' => true,
                    'visible' => true,
                ]);
                $registration->update(['hostel_id' => $hostel->id]);
            }

            // Check for duplicates (optional)
            $duplicateService = new DuplicateDetectionService();
            if ($duplicateService->check($registration)) {
                // Mark as potential duplicate for review
                // But we already approved; we can flag it.
                // We'll just log or notify.
            }

            DB::commit();

            return redirect()->route('admin.registrations.index')
                ->with('success', 'Registration approved and hostel created/updated.');
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

        // Check if inspection already exists for this registration
        if ($registration->inspections()->where('status', 'pending')->exists()) {
            return back()->with('error', 'An inspection is already pending for this registration.');
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
        // Get registrations that are approved but have not been reviewed for duplicates
        // Or we can get all registrations pending duplicate review.
        // For simplicity, we'll get all registrations with status = 'approved' and no duplicate review.
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
            // Optionally mark registration as duplicate or take action
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