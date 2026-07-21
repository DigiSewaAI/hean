<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    public function index(Request $request)
    {
        $query = CommitteeMember::query();

        // ===== 1. BASIC SEARCH =====
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('position', 'LIKE', "%{$search}%");
            });
        }

        // ===== 2. FILTER: Published Status =====
        if ($request->filled('published')) {
            if ($request->published === 'published') {
                $query->where('is_published', true);
            } elseif ($request->published === 'unpublished') {
                $query->where('is_published', false);
            }
        }

        // ===== 3. FILTER: Position (Dynamic Dropdown) =====
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        // ===== 4. SORTING =====
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'position_asc':
                $query->orderBy('position', 'asc');
                break;
            case 'position_desc':
                $query->orderBy('position', 'desc');
                break;
            case 'order_asc':
                $query->orderBy('order', 'asc');
                break;
            case 'order_desc':
                $query->orderBy('order', 'desc');
                break;
            default:
                $query->orderBy('order', 'asc');
                break;
        }

        // ===== PAGINATE =====
        $members = $query->paginate(10)->appends($request->query());

        // ===== STATS =====
        $totalMembers = CommitteeMember::count();
        $publishedCount = CommitteeMember::where('is_published', true)->count();
        $unpublishedCount = CommitteeMember::where('is_published', false)->count();

        // ===== DISTINCT POSITIONS FOR DROPDOWN =====
        $positions = CommitteeMember::select('position')
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        return view('admin.committee.index', compact(
            'members',
            'totalMembers',
            'publishedCount',
            'unpublishedCount',
            'positions'
        ));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get();
        return view('admin.committee.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'facebook' => 'nullable|url|max:255',
            'is_published' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'committee_type_id' => 'required|integer|in:1,2',
            'district_id' => 'nullable|integer|exists:districts,id',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('committee', 'cloud');
        }

        CommitteeMember::create($data);

        return redirect()->route('admin.committee.index')
                         ->with('success', 'समिति सदस्य थपियो।');
    }

    public function edit(CommitteeMember $committee)
    {
        $districts = District::orderBy('name')->get();
        return view('admin.committee.edit', compact('committee', 'districts'));
    }

    public function update(Request $request, CommitteeMember $committee)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'facebook' => 'nullable|url|max:255',
            'is_published' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'committee_type_id' => 'required|integer|in:1,2',
            'district_id' => 'nullable|integer|exists:districts,id',
        ]);

        if ($request->hasFile('image')) {
            if ($committee->image) {
                Storage::disk('cloud')->delete($committee->image);
            }
            $data['image'] = $request->file('image')->store('committee', 'cloud');
        }

        $committee->update($data);

        return redirect()->route('admin.committee.index')
                         ->with('success', 'समिति सदस्य अद्यावधिक गरियो।');
    }

    public function destroy(CommitteeMember $committee)
    {
        if ($committee->image) {
            Storage::disk('cloud')->delete($committee->image);
        }
        $committee->delete();
        return back()->with('success', 'सदस्य हटाइयो।');
    }
}