<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // ✅ GET /contact – Contact page देखाउने
    public function index()
    {
        return view('public.contact');
    }

    // ✅ POST /contact – Form submit गर्ने
    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        // Mail send गर्न चाहेमा:
        // Mail::to('admin@hean.com')->send(new ContactMail($request->all()));

        return back()->with('success', __('messages.contact_success'));
    }
}