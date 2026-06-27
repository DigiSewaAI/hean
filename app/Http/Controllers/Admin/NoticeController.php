<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()->paginate(10);
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
            'category' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('notices', 'public');
        }

        Notice::create($data);

        return redirect()->route('admin.notices.index')
                         ->with('success', 'सूचना थपियो।');
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
            'category' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($notice->image) {
                Storage::disk('public')->delete($notice->image);
            }
            $data['image'] = $request->file('image')->store('notices', 'public');
        }

        $notice->update($data);

        return redirect()->route('admin.notices.index')
                         ->with('success', 'सूचना अद्यावधिक गरियो।');
    }

    public function destroy(Notice $notice)
    {
        if ($notice->image) {
            Storage::disk('public')->delete($notice->image);
        }
        $notice->delete();
        return back()->with('success', 'सूचना हटाइयो।');
    }
}