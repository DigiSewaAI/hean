<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function create(Registration $registration)
    {
        return view('admin.inspections.create', compact('registration'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'checklist' => 'nullable|array',
            'remarks' => 'nullable|string',
        ]);

        $registration = Registration::find($request->registration_id);
        $registration->status = 'approved'; // or 'inspection_completed'
        $registration->save();

        // Save inspection data (you may create an Inspection model)

        return redirect()->route('admin.registrations.show', $registration)
                         ->with('success', 'निरीक्षण पूरा भयो र आवेदन स्वीकृत गरियो।');
    }
}