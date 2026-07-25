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

    // Grouping logic
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

    // ✅ नयाँ – Stats को लागि सही गणना
    $totalMembers   = $members->unique('name')->count();                      // 99
    $totalPositions = $members->pluck('position')->unique()->count();        // 63
    $activeMembers  = $members->where('is_published', true)->unique('name')->count(); // 99

    return view('public.committee.index', compact(
        'central', 
        'former', 
        'districts', 
        'members', 
        'totalMembers', 
        'totalPositions', 
        'activeMembers'
    ));
}
}