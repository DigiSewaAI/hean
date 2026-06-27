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
        return view('public.committee.index', compact('members'));
    }
}