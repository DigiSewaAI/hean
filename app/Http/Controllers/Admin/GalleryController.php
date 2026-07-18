<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of albums.
     */
    public function index()
    {
        $albums = GalleryAlbum::withCount('images')
                              ->latest()
                              ->paginate(15);
        return view('admin.gallery.index', compact('albums'));
    }

    /**
     * Show form to create a new album.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created album.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $album = GalleryAlbum::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'event_date' => $request->event_date,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.gallery.images.index', $album)
                         ->with('success', 'Album created. Now add images.');
    }

    /**
     * Show form to edit an album.
     */
    public function edit(GalleryAlbum $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified album.
     */
    public function update(Request $request, GalleryAlbum $gallery)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $gallery->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'event_date' => $request->event_date,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Album updated.');
    }

    /**
     * Remove the specified album and all its images.
     */
    public function destroy(GalleryAlbum $gallery)
    {
        // Delete all image files
        foreach ($gallery->images as $image) {
            if ($image->image) {
                Storage::disk('cloud')->delete($image->image);
            }
            $image->delete();
        }
        // Delete cover image if exists
        if ($gallery->cover_image) {
            Storage::disk('cloud')->delete($gallery->cover_image);
        }
        $gallery->delete();

        return back()->with('success', 'Album and all images deleted.');
    }

    // ------------------------------------------------------------------------
    // Image Management inside Album
    // ------------------------------------------------------------------------

    /**
     * Show images for a given album.
     */
    public function imagesIndex(GalleryAlbum $gallery)
    {
        $images = $gallery->images()->latest()->paginate(20);
        return view('admin.gallery.images', compact('gallery', 'images'));
    }

    /**
     * Upload multiple images to an album.
     */
    public function imagesStore(Request $request, GalleryAlbum $gallery)
    {
        $request->validate([
            'images.*' => 'required|image|max:4096',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('gallery', 'cloud');
                GalleryImage::create([
                    'album_id' => $gallery->id,
                    'image' => $path,
                    'title' => null,
                    'is_published' => true,
                ]);
            }
        }

        return redirect()->route('admin.gallery.images.index', $gallery)
                         ->with('success', 'Images added successfully.');
    }

    /**
     * Show form to edit an individual image (caption).
     */
    public function imageEdit(GalleryImage $image)
    {
        return view('admin.gallery.image-edit', compact('image'));
    }

    /**
     * Update an individual image.
     */
    public function imageUpdate(Request $request, GalleryImage $image)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $image->update([
            'title' => $request->title,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.gallery.images.index', $image->album_id)
                         ->with('success', 'Image updated.');
    }

    /**
     * Delete a single image.
     */
    public function imageDestroy(GalleryImage $image)
    {
        if ($image->image) {
            Storage::disk('cloud')->delete($image->image);
        }
        $image->delete();

        return back()->with('success', 'Image deleted.');
    }

    /**
     * Set cover image for an album.
     */
    public function setCover(GalleryAlbum $gallery, GalleryImage $image)
    {
        // Ensure the image belongs to the album
        if ($image->album_id != $gallery->id) {
            abort(404);
        }

        // Remove old cover file if exists
        if ($gallery->cover_image) {
            Storage::disk('cloud')->delete($gallery->cover_image);
        }

        // Copy the image file to a new path for cover (optional) or just reference the same path
        // We'll just store the same path
        $gallery->update(['cover_image' => $image->image]);

        return back()->with('success', 'Cover image set.');
    }
}