@extends('layouts.admin')

@section('title', __('messages.admin_gallery_title') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">{{ __('messages.admin_gallery_title') }}</h2>
    <a href="{{ route('admin.gallery.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> {{ __('Add Event / Album') }}
    </a>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:25px;">
    @forelse($albums as $album)
    <div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.06); transition:transform 0.3s;">
        <div style="position:relative; height:160px; background:#f1f5f9;">
            <img src="{{ $album->cover_url }}" alt="{{ $album->name }}" style="width:100%; height:100%; object-fit:cover;">
            <span style="position:absolute; bottom:8px; right:8px; background:rgba(0,0,0,0.7); color:#fff; padding:2px 10px; border-radius:20px; font-size:0.75rem;">
                {{ $album->photo_count }} {{ __('photos') }}
            </span>
        </div>
        <div style="padding:15px;">
            <h5 style="font-weight:600; color:#0f172a; margin:0 0 4px;">{{ $album->name }}</h5>
            @if($album->event_date)
                <small style="color:#64748b;"><i class="far fa-calendar-alt"></i> {{ $album->event_date->format('M d, Y') }}</small>
            @endif
            <div style="display:flex; gap:8px; margin-top:12px; flex-wrap:wrap;">
                <a href="{{ route('admin.gallery.images.index', $album) }}" class="btn-action btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:4px 12px; border-radius:6px; text-decoration:none; font-size:0.75rem; display:inline-flex; align-items:center; gap:4px;">
                    <i class="fas fa-images"></i> {{ __('Manage Images') }}
                </a>
                <a href="{{ route('admin.gallery.edit', $album) }}" class="btn-action btn-warning-sm" style="background:#F59E0B; color:#fff; padding:4px 12px; border-radius:6px; text-decoration:none; font-size:0.75rem; display:inline-flex; align-items:center; gap:4px;">
                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                </a>
                <form action="{{ route('admin.gallery.destroy', $album) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action btn-danger-sm" style="background:#ef4444; color:#fff; padding:4px 12px; border-radius:6px; border:none; font-size:0.75rem; cursor:pointer; display:inline-flex; align-items:center; gap:4px;" onclick="return confirm('{{ __('Delete this album and all its images?') }}')">
                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p style="grid-column:1/-1; text-align:center; padding:40px; color:#94a3b8;">{{ __('No albums found. Create one!') }}</p>
    @endforelse
</div>
{{ $albums->links() }}
@endsection