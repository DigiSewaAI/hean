<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::where('approved', true)->where('visible', true)
                         ->latest()->paginate(12);
        return view('public.hostels.index', compact('hostels'));
    }

    public function show(Hostel $hostel)
    {
        if (!$hostel->approved || !$hostel->visible) {
            abort(404);
        }
        return view('public.hostels.show', compact('hostel'));
    }
}