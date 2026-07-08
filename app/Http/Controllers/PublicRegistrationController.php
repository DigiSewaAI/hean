<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\Registration;
use App\Models\Document;
use App\Models\Payment;
use App\Models\Province;
use App\Models\District;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicRegistrationController extends Controller
{
    public function create()
    {
        return view('public.register-hostel');
    }

    public function store(Request $request)
    {
        $validator = $this->validateForm($request);
        if ($validator->fails()) {
            return redirect()->route('register.hostel')
                ->withErrors($validator)
                ->withInput();
        }

        // Get names from IDs (province, district, municipality)
        $provinceName = Province::find($request->province)?->name;
        $districtName = District::find($request->district)?->name;
        $municipalityName = Municipality::find($request->municipality)?->name;

        // ✅ डुप्लिकेट जाँच – province पठाउनु हुँदैन
        $duplicate = Hostel::checkDuplicate(
            $request->hostel_name,          // नाम (नेपाली/अंग्रेजी दुवै खोज्छ)
            $districtName,                  // जिल्लाको नाम
            $municipalityName,              // नगरपालिकाको नाम
            $request->ward,
            $request->street,
            $request->block_name ?? null    // वैकल्पिक ब्लक
        );

        if ($duplicate) {
            return back()->withErrors([
                'hostel_name' => 'यसै नाम र ठेगानामा अर्को होस्टल पहिले नै दर्ता भएको छ। यदि यो फरक ब्लक हो भने कृपया "ब्लक / भवन नाम" भर्नुहोस्।'
            ])->withInput();
        }

        DB::beginTransaction();
        try {
            $registration = Registration::create([
                'source' => 'public',
                'submitted_at' => now(),
                'status' => 'pending',
                // Hostel details
                'hostel_name' => $request->hostel_name,
                'hostel_name_english' => $request->hostel_name_english,
                'hostel_type' => $request->hostel_type,
                'capacity' => $request->capacity,
                'rooms' => $request->rooms,
                'established_year' => $request->established_year,
                'contact' => $request->contact_number,
                'email' => $request->email,
                'website' => $request->website,
                'description' => $request->description,
                // Owner
                'operator_name' => $request->owner_name,
                // Address (store names from dropdown)
                'province' => $provinceName,
                'district' => $districtName,
                'municipality' => $municipalityName,
                'ward' => $request->ward,
                'street' => $request->street,
                'landmark' => $request->landmark,
                'pan' => $request->pan,
                // ✅ block_name थपियो (यो होस्टलमा मात्र होइन, यहाँ पनि)
                'block_name' => $request->block_name,
                'local_registration_number' => $request->local_registration_number,
            ]);

            // Documents
            $docTypes = ['registration_certificate', 'citizenship_copy', 'pan_certificate', 'signboard', 'other_documents'];
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

            // Payment
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

    public function success($id)
    {
        $registration = Registration::with('documents')->findOrFail($id);
        return view('public.registration-success', compact('registration'));
    }

    protected function validateForm(Request $request)
    {
        $rules = [
            'hostel_name' => 'required|string|max:255',
            'hostel_name_english' => 'required|string|max:255',
            'hostel_type' => 'required|in:boys,girls,co-ed',
            'capacity' => 'required|integer|min:1',
            'rooms' => 'required|integer|min:1',
            'established_year' => 'required|integer|min:1900|max:' . date('Y'),
            'contact_number' => 'required|string|max:20',      // ✅ 'unique' हटाइयो (पहिले नै थिएन)
            'email' => 'required|email|max:255',               // ✅ 'unique' हटाइयो
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'owner_name' => 'required|string|max:255',
            'province' => 'required|exists:provinces,id',
            'district' => 'required|exists:districts,id',
            'municipality' => 'required|exists:municipalities,id',
            'ward' => 'required|integer|min:1|max:32',
            'street' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'pan' => 'required|string|max:50',                // ✅ 'unique' हटाइयो
            'block_name' => 'nullable|string|max:255',        // ✅ नयाँ: वैकल्पिक ब्लक
            'documents.registration_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documents.citizenship_copy' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documents.pan_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documents.signboard' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'documents.other_documents' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'payment_method' => 'nullable|in:bank,esewa,khalti',
            'transaction_id' => 'nullable|string|max:255',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'local_registration_number' => 'required|string|max:100',

        ];

        return Validator::make($request->all(), $rules);
    }
}