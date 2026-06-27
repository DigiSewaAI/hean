<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalHostels = Hostel::count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();
        $inspectionsPending = Registration::where('status', 'inspection')->count();
        $members = User::where('role', '!=', 'viewer')->count();

        return view('admin.dashboard', compact(
            'totalHostels',
            'pendingRegistrations',
            'inspectionsPending',
            'members'
        ));
    }
}