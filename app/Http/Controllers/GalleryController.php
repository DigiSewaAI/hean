<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::where('is_published', true)
                              ->withCount('images')
                              ->latest()
                              ->paginate(12);
        return view('public.gallery.index', compact('albums'));
    }

    public function show(GalleryAlbum $album)
    {
        // Ensure album is published
        if (!$album->is_published) {
            abort(404);
        }
        $images = $album->images()->where('is_published', true)->latest()->get();
        return view('public.gallery.show', compact('album', 'images'));
    }
}