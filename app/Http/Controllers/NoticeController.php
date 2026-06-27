<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::where('is_published', true)
                         ->latest()
                         ->paginate(10);
        return view('public.notices.index', compact('notices'));
    }

    public function show(Notice $notice)
    {
        if (!$notice->is_published) {
            abort(404);
        }
        return view('public.notices.show', compact('notice'));
    }
}