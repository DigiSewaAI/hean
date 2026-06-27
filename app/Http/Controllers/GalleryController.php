<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::where('is_published', true)
                              ->latest()
                              ->paginate(12);
        return view('public.gallery.index', compact('images'));
    }
}