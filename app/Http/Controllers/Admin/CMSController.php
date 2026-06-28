<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // यदि Setting मोडेल छ भने; नभए temporary session वा config प्रयोग गर्न सकिन्छ

class CMSController extends Controller
{
    public function index()
    {
        // यहाँ सेटिङहरू डाटाबेसबाट ल्याउने
        $settings = Setting::pluck('value', 'key')->toArray(); // मानौं Setting मोडेल छ
        return view('admin.cms.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'hero_badge' => 'nullable|string',
            'about_title' => 'nullable|string',
            'about_content' => 'nullable|string',
            'cta_title' => 'nullable|string',
            'cta_content' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.cms.index')->with('success', 'CMS updated successfully!');
    }
}