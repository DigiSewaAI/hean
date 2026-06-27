@extends('layouts.admin')

@section('title', 'ग्यालरी - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">ग्यालरी</h2>
    <a href="{{ route('admin.gallery.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> नयाँ थप्नुहोस्
    </a>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:20px;">
    @forelse($images as $image)
    <div style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
        <img src="{{ asset('storage/'.$image->image) }}" style="width:100%; height:150px; object-fit:cover;">
        <div style="padding:12px;">
            <p style="font-weight:600; color:#0f172a; margin-bottom:4px; font-size:0.9rem;">{{ $image->title ?? 'Untitled' }}</p>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('admin.gallery.edit', $image) }}" class="btn-action btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:4px 12px; border-radius:6px; text-decoration:none; font-size:0.7rem; display:inline-block;">सम्पादन</a>
                <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action btn-danger-sm" style="background:#ef4444; color:#fff; padding:4px 12px; border-radius:6px; border:none; font-size:0.7rem; cursor:pointer;" onclick="return confirm('के तपाईं यो छवि मेट्न चाहनुहुन्छ?')">मेट्नुहोस्</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p style="grid-column:1/-1; text-align:center; padding:40px; color:#94a3b8;">कुनै छवि छैन।</p>
    @endforelse
</div>
{{ $images->links() }}
@endsection