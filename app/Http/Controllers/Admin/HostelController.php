<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::latest()->paginate(10);
        return view('admin.hostels.index', compact('hostels'));
    }

    public function create()
    {
        return view('admin.hostels.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_nepali' => 'required|string',
            'name_english' => 'nullable|string',
            'operator_name' => 'required|string',
            'district' => 'required|string',
            'municipality' => 'required|string',
            'ward' => 'required|string',
            'street' => 'nullable|string',
            'contact' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'approved' => 'boolean',
            'featured' => 'boolean',
            'visible' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hostels', 'public');
        }

        Hostel::create($data);

        return redirect()->route('admin.hostels.index')
                         ->with('success', 'होस्टेल सफलतापूर्वक थपियो।');
    }

    public function edit(Hostel $hostel)
    {
        return view('admin.hostels.edit', compact('hostel'));
    }

    public function update(Request $request, Hostel $hostel)
    {
        $data = $request->validate([
            'name_nepali' => 'required|string',
            'name_english' => 'nullable|string',
            'operator_name' => 'required|string',
            'district' => 'required|string',
            'municipality' => 'required|string',
            'ward' => 'required|string',
            'street' => 'nullable|string',
            'contact' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'approved' => 'boolean',
            'featured' => 'boolean',
            'visible' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($hostel->image) {
                Storage::disk('public')->delete($hostel->image);
            }
            $data['image'] = $request->file('image')->store('hostels', 'public');
        }

        $hostel->update($data);

        return redirect()->route('admin.hostels.index')
                         ->with('success', 'होस्टेल अद्यावधिक गरियो।');
    }

    public function destroy(Hostel $hostel)
    {
        if ($hostel->image) {
            Storage::disk('public')->delete($hostel->image);
        }
        $hostel->delete();

        return back()->with('success', 'होस्टेल हटाइयो।');
    }

    public function approve(Hostel $hostel)
    {
        $hostel->approved = true;
        $hostel->save();
        return back()->with('success', 'होस्टेल स्वीकृत गरियो।');
    }

    public function feature(Hostel $hostel)
    {
        $hostel->featured = !$hostel->featured;
        $hostel->save();
        return back()->with('success', 'होस्टेलको फिचर्ड स्थिति परिवर्तन गरियो।');
    }

    public function hide(Hostel $hostel)
    {
        $hostel->visible = !$hostel->visible;
        $hostel->save();
        return back()->with('success', 'होस्टेलको दृश्यता परिवर्तन गरियो।');
    }
}