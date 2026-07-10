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

    // ========== नयाँ थपिएको: Supporting Organizations ==========
    $supportingOrganizations = [
    [
        'name' => 'HostelHub Nepal',
        'logo' => asset('images/partners/hostelhub.png'),
        'partner_type' => '💻 Official Technology Partner',
        'url' => 'https://www.hostelhubnepal.com',  // ✅ EXACT
    ],
    [
        'name' => 'Everest Hospital',
        'logo' => asset('images/partners/everest.png'),
        'partner_type' => '🏥 Healthcare Partner',
        'url' => 'https://www.findhealthclinics.org/NP/Kathmandu/368333303375550/Everest-Hospital',  // ✅ EXACT
    ],
    [
        'name' => 'WorldLink',
        'logo' => asset('images/partners/worldlink.png'),
        'partner_type' => '🌐 Connectivity Partner',
        'url' => 'https://worldlink.com.np/',  // ✅ EXACT
    ],
    [
        'name' => 'NIC Asia Bank',
        'logo' => asset('images/partners/nicasia.png'),
        'partner_type' => '🏦 Banking Partner',
        'url' => 'https://www.nicasiacapital.com/',  // ✅ EXACT
    ],
    [
        'name' => 'Prabhu Insurance',
        'logo' => asset('images/partners/prabhu.png'),
        'partner_type' => '🛡️ Insurance Partner',
        'url' => 'https://www.prabhubank.com/',  // ✅ EXACT
    ],
    [
        'name' => 'Kantipur Media',
        'logo' => asset('images/partners/kantipur.png'),
        'partner_type' => '📰 Media Partner',
        'url' => 'https://kantipurtv.com/',  // ✅ EXACT
    ],
];
    // =========================================================

    return view('public.home', compact('hostels', 'notices', 'committee', 'gallery', 'stats', 'supportingOrganizations'));
}

    public function about()
    {
        return view('public.about');
    }
}