<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\Registration;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalHostels = Hostel::count();
        $approvedHostels = Hostel::where('approved', true)->count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();

        $districtStats = Hostel::select('district', \DB::raw('count(*) as total'))
                               ->groupBy('district')
                               ->get();

        return view('admin.reports.index', compact(
            'totalHostels',
            'approvedHostels',
            'pendingRegistrations',
            'districtStats'
        ));
    }
}