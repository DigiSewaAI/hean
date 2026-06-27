<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Send email logic (optional)
        // Mail::to('admin@hean.com')->send(...);

        return back()->with('success', 'तपाईंको सन्देश पठाइयो। धन्यवाद!');
    }
}