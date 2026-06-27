<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->session()->get('certificate_data', [
            'hostel_name' => 'सूर्योदय होस्टेल',
            'address' => 'काठमाडौं-१२, नेपाल',
            'registration_no' => 'HEAN-2025-001',
            'date' => now()->format('Y-m-d'),
        ]);

        return view('admin.certificate.index', compact('data'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
        ]);

        $registration = Registration::find($request->registration_id);

        $data = [
            'hostel_name' => $registration->hostel_name,
            'address' => $registration->district . ', ' . $registration->municipality,
            'registration_no' => 'HEAN-' . now()->year . '-' . str_pad($registration->id, 3, '0', STR_PAD_LEFT),
            'date' => now()->format('Y-m-d'),
        ];

        session(['certificate_data' => $data]);

        return redirect()->route('admin.certificate.index')
                         ->with('success', 'प्रमाणपत्र जारी गरियो।');
    }
}