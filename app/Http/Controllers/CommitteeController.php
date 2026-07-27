<?php

namespace App\Http\Controllers;

use App\Models\CommitteeMember;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function index()
{
    $members = CommitteeMember::where('is_published', true)
                              ->orderBy('order')
                              ->get();

    // Grouping logic (पहिले जस्तै)
    $central = $members->filter(function ($item) {
        return !str_contains($item->position, '(');
    })->values();

    $former = $members->filter(function ($item) {
        return str_contains($item->position, '(') && 
               (str_contains($item->position, 'Founder') || 
                str_contains($item->position, 'Former'));
    })->values();

    $districts = $members->filter(function ($item) {
        return str_contains($item->position, '(') && 
               !str_contains($item->position, 'Founder') && 
               !str_contains($item->position, 'Former');
    })->values();

    // ✅ नयाँ: Special Leadership (संरक्षक, संस्थापक अध्यक्ष, पूर्व अध्यक्ष, निवर्तमान अध्यक्ष)
    $specialPositions = [
        'Patron', 'संरक्षक',
        'President (Founder)', 'Founder President', 'संस्थापक अध्यक्ष',
        'President (Former 2080)', 'President (Former 2079)', 'Former President', 'पूर्व अध्यक्ष',
        'Outgoing President', 'निवर्तमान अध्यक्ष',
    ];

    $specialLeadership = CommitteeMember::where('is_published', true)
        ->whereIn('position', $specialPositions)
        ->orderBy('order')
        ->get();

    // Stats
    $totalMembers   = $members->unique('name')->count();
    $totalPositions = $members->pluck('position')->unique()->count();
    $activeMembers  = $members->where('is_published', true)->unique('name')->count();

    return view('public.committee.index', compact(
        'central', 
        'former', 
        'districts', 
        'members', 
        'totalMembers', 
        'totalPositions', 
        'activeMembers',
        'specialLeadership'
    ));
}
}