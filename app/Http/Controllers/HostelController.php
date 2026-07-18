<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'newest');

        // Base query: approved & visible hostels
        $query = Hostel::where('approved', true)->where('visible', true);

        // Overall statistics (unfiltered)
        $totalHostels = (clone $query)->count();
        $totalDistricts = (clone $query)->distinct('district')->count('district');

        // Apply search filter on name and registration numbers
        if (!empty($search)) {
            $searchTerm = trim($search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name_nepali', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('name_english', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('registration_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('local_registration_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('old_registration_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('pan', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Apply sorting
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'name') {
            $query->orderByRaw('COALESCE(name_english, name_nepali) ASC');
        } else {
            $query->latest(); // newest
        }

        $hostels = $query->paginate(12)->withQueryString();

        return view('public.hostels.index', compact('hostels', 'totalHostels', 'totalDistricts'));
    }

    public function show(Hostel $hostel)
    {
        if (!$hostel->approved || !$hostel->visible) {
            abort(404);
        }
        return view('public.hostels.show', compact('hostel'));
    }
}