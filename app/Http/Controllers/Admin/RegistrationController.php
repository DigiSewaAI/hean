<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::latest()->paginate(10);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function create()
    {
        return view('admin.registrations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hostel_name' => 'required|string',
            'operator_name' => 'required|string',
            'district' => 'required|string',
            'municipality' => 'required|string',
            'ward' => 'required|string',
            'street' => 'nullable|string',
            'contact' => 'required|string',
            'documents' => 'nullable|array',
        ]);

        $data['status'] = 'pending';
        Registration::create($data);

        return redirect()->route('admin.registrations.index')
                         ->with('success', 'आवेदन सफलतापूर्वक दर्ता गरियो।');
    }

    public function approve(Registration $registration)
    {
        $registration->status = 'approved';
        $registration->save();

        // Convert to Hostel
        Hostel::create([
            'name_nepali' => $registration->hostel_name,
            'name_english' => $registration->hostel_name,
            'operator_name' => $registration->operator_name,
            'district' => $registration->district,
            'municipality' => $registration->municipality,
            'ward' => $registration->ward,
            'street' => $registration->street,
            'contact' => $registration->contact,
            'approved' => true,
            'visible' => true,
            'featured' => false,
        ]);

        return back()->with('success', 'आवेदन स्वीकृत गरियो र होस्टेल सूचीमा थपियो।');
    }

    public function reject(Registration $registration)
    {
        $registration->status = 'rejected';
        $registration->save();

        return back()->with('error', 'आवेदन अस्वीकृत गरियो।');
    }
}