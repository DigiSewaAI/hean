<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\Registration;
use App\Models\Document;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicRegistrationController extends Controller
{
    /**
     * Show the single registration form.
     */
    public function create()
    {
        return view('public.register-hostel');
    }

    /**
     * Store the registration.
     */
    public function store(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->fails()) {
            return redirect()->route('register.hostel')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // 1. Create Registration (without user account)
            $registration = Registration::create([
                'source' => 'public',
                'submitted_at' => now(),
                'status' => 'pending',
                // Hostel details
                'hostel_name' => $request->hostel_name,
                'hostel_type' => $request->hostel_type,
                'capacity' => $request->capacity,
                'established_year' => $request->established_year,
                'contact' => $request->contact_number,
                'email' => $request->email,
                'website' => $request->website,
                'description' => $request->description,
                // Owner details
                'operator_name' => $request->owner_name,
                // Address
                'province' => $request->province,
                'district' => $request->district,
                'municipality' => $request->municipality,
                'ward' => $request->ward,
                'street' => $request->street,
                'landmark' => $request->landmark,
                // Additional
                'pan' => $request->pan,
                'registration_number' => $request->registration_number,
                // No owner_id – we don't create a user
            ]);

            // 2. Save Documents
            $docTypes = ['registration_certificate', 'citizenship_copy', 'pan_certificate', 'other_documents'];
            foreach ($docTypes as $type) {
                if ($request->hasFile("documents.{$type}")) {
                    $file = $request->file("documents.{$type}");
                    $path = $file->store('public/documents/' . $registration->id, 'public');
                    Document::create([
                        'registration_id' => $registration->id,
                        'type' => $type,
                        'file_path' => $path,
                        'uploaded_at' => now(),
                    ]);
                }
            }

            // 3. Save Payment (if any)
            if ($request->filled('payment_method')) {
                Payment::create([
                    'registration_id' => $registration->id,
                    'method' => $request->payment_method,
                    'transaction_id' => $request->transaction_id,
                    'amount' => $request->payment_amount ?? 1500,
                    'payment_date' => $request->payment_date ?? now(),
                    'bank_name' => $request->bank_name,
                    'bank_account' => $request->bank_account,
                ]);
            }

            DB::commit();

            return redirect()->route('registration.success', ['id' => $registration->id])
                ->with('success', 'Registration submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Public registration failed: ' . $e->getMessage());
            return back()->withErrors(['general' => 'An error occurred: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show success page.
     */
    public function success($id)
    {
        $registration = Registration::with('documents')->findOrFail($id);
        return view('public.registration-success', compact('registration'));
    }

    /**
     * Validate the form.
     */
    protected function validateForm(Request $request)
    {
        $rules = [
            // Hostel
            'hostel_name' => 'required|string|max:255',
            'hostel_type' => 'required|in:boys,girls,co-ed',
            'capacity' => 'required|integer|min:1',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            // Owner
            'owner_name' => 'required|string|max:255',
            // Address
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'municipality' => 'required|string|max:100',
            'ward' => 'required|string|max:10',
            'street' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            // PAN & reg number (for duplicate checks)
            'pan' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            // Documents
            'documents.registration_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documents.citizenship_copy' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documents.pan_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documents.other_documents' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // Payment (optional)
            'payment_method' => 'nullable|in:bank,esewa,khalti',
            'transaction_id' => 'nullable|string|max:255',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
        ];

        return Validator::make($request->all(), $rules);
    }
}