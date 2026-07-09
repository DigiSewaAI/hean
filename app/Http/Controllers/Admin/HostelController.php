<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HostelController extends Controller
{
    public function index(Request $request)
{
    $query = Hostel::query();

    // ===== 1. BASIC SEARCH (Multiple Fields) =====
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name_nepali', 'LIKE', "%{$search}%")
              ->orWhere('name_english', 'LIKE', "%{$search}%")
              ->orWhere('district', 'LIKE', "%{$search}%")
              ->orWhere('operator_name', 'LIKE', "%{$search}%")
              ->orWhere('contact', 'LIKE', "%{$search}%")
              ->orWhere('registration_number', 'LIKE', "%{$search}%")
              ->orWhere('local_registration_number', 'LIKE', "%{$search}%");
        });
    }

    // ===== 2. ADVANCED SEARCH: Local Registration Number =====
    if ($request->filled('local_reg_number')) {
        $query->where('local_registration_number', 'LIKE', "%{$request->local_reg_number}%");
    }

    // ===== 3. FILTER: Status (Approved/Pending) =====
    if ($request->filled('status')) {
        if ($request->status === 'approved') {
            $query->where('approved', true);
        } elseif ($request->status === 'pending') {
            $query->where('approved', false);
        }
    }

    // ===== 4. FILTER: Featured =====
    if ($request->filled('featured')) {
        $query->where('featured', $request->featured === '1');
    }

    // ===== 5. FILTER: Visibility =====
    if ($request->filled('visible')) {
        $query->where('visible', $request->visible === '1');
    }

    // ===== 6. FILTER: Type =====
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // ===== 7. FILTER: District (Dynamic Dropdown) =====
    if ($request->filled('district')) {
        $query->where('district', $request->district);
    }

    // ===== 8. FILTER: Capacity Range =====
    if ($request->filled('capacity_min')) {
        $query->where('capacity', '>=', $request->capacity_min);
    }
    if ($request->filled('capacity_max')) {
        $query->where('capacity', '<=', $request->capacity_max);
    }

    // ===== 9. FILTER: Created Date Range =====
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    // ===== 10. SORTING =====
    switch ($request->sort) {
        case 'oldest':
            $query->oldest();
            break;
        case 'name_asc':
            $query->orderBy('name_nepali', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name_nepali', 'desc');
            break;
        case 'district_asc':
            $query->orderBy('district', 'asc');
            break;
        case 'capacity_desc':
            $query->orderBy('capacity', 'desc');
            break;
        case 'capacity_asc':
            $query->orderBy('capacity', 'asc');
            break;
        case 'reg_number_asc':
            $query->orderBy('registration_number', 'asc');
            break;
        case 'reg_number_desc':
            $query->orderBy('registration_number', 'desc');
            break;
        default:
            $query->latest();
            break;
    }

    // ===== PAGINATE =====
    $hostels = $query->paginate(15)->appends($request->query());

    // ===== STATS (Total, Approved, Featured, Visible) =====
    $totalHostels = Hostel::count();
    $approvedCount = Hostel::where('approved', true)->count();
    $featuredCount = Hostel::where('featured', true)->count();
    $visibleCount = Hostel::where('visible', true)->count();

    // ===== DISTINCT DISTRICTS FOR DROPDOWN =====
    $districts = Hostel::select('district')->distinct()->orderBy('district')->pluck('district');

    return view('admin.hostels.index', compact('hostels', 'totalHostels', 'approvedCount', 'featuredCount', 'visibleCount', 'districts'));
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
            'type' => 'required|in:boys,girls,co-ed',
            'capacity' => 'required|integer|min:0',
            'rooms' => 'required|integer|min:0',
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
            'local_registration_number' => 'required|string|max:100',
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

    /**
     * Update hostel.
     * ✅ registration_number बाहेक सबै अपडेट गरिन्छ (immutable)
     */
    public function update(Request $request, Hostel $hostel)
    {
        $data = $request->validate([
            'name_nepali' => 'required|string',
            'name_english' => 'nullable|string',
            'type' => 'required|in:boys,girls,co-ed',
            'capacity' => 'required|integer|min:0',
            'rooms' => 'required|integer|min:0', 
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
            'local_registration_number' => 'required|string|max:100',

        ]);

        // Image handle
        if ($request->hasFile('image')) {
            if ($hostel->image) {
                Storage::disk('public')->delete($hostel->image);
            }
            $data['image'] = $request->file('image')->store('hostels', 'public');
        }

        // ✅ registration_number बाहेक update गर्ने (सुरक्षाका लागि)
        $hostel->update($request->except(['registration_number', '_token', '_method']));

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

    /**
     * Display the specified hostel.
     */
    public function show(Hostel $hostel)
    {
        return view('admin.hostels.show', compact('hostel'));
    }

    public function bulkAction(Request $request)
    {
        // ✅ _method field हटाउनुहोस् (Laravel method spoofing बाट)
        $data = $request->except('_method', '_token');
        
        // ✅ Validation
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:hostels,id',
            'bulk_action' => 'required|in:approve,reject,feature,unfeature,hide,show,delete',
        ]);

        $ids = $request->ids;
        $action = $request->bulk_action;

        try {
            switch ($action) {
                case 'approve':
                    Hostel::whereIn('id', $ids)->update(['approved' => true]);
                    $message = 'चयन गरिएका होस्टेलहरू स्वीकृत गरियो।';
                    break;
                case 'reject':
                    Hostel::whereIn('id', $ids)->update(['approved' => false]);
                    $message = 'चयन गरिएका होस्टेलहरू अस्वीकृत गरियो।';
                    break;
                case 'feature':
                    Hostel::whereIn('id', $ids)->update(['featured' => true]);
                    $message = 'चयन गरिएका होस्टेलहरू फिचर्ड गरियो।';
                    break;
                case 'unfeature':
                    Hostel::whereIn('id', $ids)->update(['featured' => false]);
                    $message = 'चयन गरिएका होस्टेलहरूको फिचर्ड हटाइयो।';
                    break;
                case 'hide':
                    Hostel::whereIn('id', $ids)->update(['visible' => false]);
                    $message = 'चयन गरिएका होस्टेलहरू लुकाइयो।';
                    break;
                case 'show':
                    Hostel::whereIn('id', $ids)->update(['visible' => true]);
                    $message = 'चयन गरिएका होस्टेलहरू देखाइयो।';
                    break;
                case 'delete':
                    Hostel::whereIn('id', $ids)->delete();
                    $message = 'चयन गरिएका होस्टेलहरू मेटियो।';
                    break;
                default:
                    return back()->with('error', 'अमान्य कार्य।');
            }

            return redirect()->route('admin.hostels.index')->with('success', $message);
            
        } catch (\Exception $e) {
            return back()->with('error', 'केही त्रुटि भयो: ' . $e->getMessage());
        }
    }
}