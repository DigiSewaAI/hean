<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::latest()->paginate(12);
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'image' => 'required|image|max:4096',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'is_published' => $request->boolean('is_published', true),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gallery', 'cloud');
        }

        GalleryImage::create($data);

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'छवि थपियो।');
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $request->validate([
            'title' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'is_published' => $request->boolean('is_published', true),
        ];

        if ($request->hasFile('image')) {
            if ($gallery->image) {
    Storage::disk('cloud')->delete($gallery->image);
}
$data['image'] = $request->file('image')->store('gallery', 'cloud');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'छवि अद्यावधिक गरियो।');
    }

    public function destroy(GalleryImage $gallery)
    {
        if ($gallery->image) {
            Storage::disk('cloud')->delete($gallery->image);
        }
        $gallery->delete();
        return back()->with('success', 'छवि हटाइयो।');
    }
}