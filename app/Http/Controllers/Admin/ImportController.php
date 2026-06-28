<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    // यो फङ्क्सन पछि पूरा गरिनेछ – अहिले केवल प्लेसहोल्डर
    public function prepare(Request $request)
    {
        // ImportPreparationService::prepare($request->file('file'));
        return back()->with('info', 'Import preparation is under development.');
    }
}