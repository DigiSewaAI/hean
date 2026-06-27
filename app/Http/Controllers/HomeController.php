<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\Notice;
use App\Models\CommitteeMember;
use App\Models\GalleryImage;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hostels = Hostel::where('approved', true)->where('visible', true)
                         ->latest()->take(8)->get();
        $notices = Notice::where('is_published', true)->latest()->take(4)->get();
        $committee = CommitteeMember::where('is_published', true)->orderBy('order')->get();
        $gallery = GalleryImage::where('is_published', true)->take(8)->get();

        $stats = [
            'hostels' => Hostel::where('approved', true)->count(),
            'members' => \App\Models\User::where('role', '!=', 'viewer')->count(),
            'districts' => Hostel::distinct('district')->count(),
            'growth' => 24,
        ];

        return view('public.home', compact('hostels', 'notices', 'committee', 'gallery', 'stats'));
    }

    public function about()
    {
        return view('public.about');
    }
}