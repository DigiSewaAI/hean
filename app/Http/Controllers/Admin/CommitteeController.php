<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    public function index()
    {
        $members = CommitteeMember::orderBy('order')->paginate(10);
        return view('admin.committee.index', compact('members'));
    }

    public function create()
    {
        return view('admin.committee.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('committee', 'public');
        }

        CommitteeMember::create($data);

        return redirect()->route('admin.committee.index')
                         ->with('success', 'समिति सदस्य थपियो।');
    }

    public function edit(CommitteeMember $committee)
    {
        return view('admin.committee.edit', compact('committee'));
    }

    public function update(Request $request, CommitteeMember $committee)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($committee->image) {
                Storage::disk('public')->delete($committee->image);
            }
            $data['image'] = $request->file('image')->store('committee', 'public');
        }

        $committee->update($data);

        return redirect()->route('admin.committee.index')
                         ->with('success', 'समिति सदस्य अद्यावधिक गरियो।');
    }

    public function destroy(CommitteeMember $committee)
    {
        if ($committee->image) {
            Storage::disk('public')->delete($committee->image);
        }
        $committee->delete();
        return back()->with('success', 'सदस्य हटाइयो।');
    }
}