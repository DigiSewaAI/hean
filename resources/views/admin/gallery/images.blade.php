@extends('layouts.admin')

@section('title', $gallery->name . ' - Manage Images')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-images me-2" style="color:#0EA5E9;"></i> {{ $gallery->name }}
        <small style="font-size:0.9rem; font-weight:400; color:#64748b;">({{ $images->total() }} {{ __('photos') }})</small>
    </h2>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('admin.gallery.edit', $gallery) }}" style="display:inline-flex; align-items:center; gap:6px; background:#F59E0B; color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
            <i class="fas fa-edit"></i> {{ __('Edit Album') }}
        </a>
        <a href="{{ route('admin.gallery.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04); margin-bottom:30px;">
    <h4 style="margin:0 0 16px 0;"><i class="fas fa-upload me-2"></i> {{ __('Upload New Images') }}</h4>
    <form action="{{ route('admin.gallery.images.store', $gallery) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            <input type="file" name="images[]" accept=".jpg,.jpeg,.png,.webp" multiple required style="flex:1; min-width:200px; padding:10px; border:1.5px solid #e2e8f0; border-radius:8px;">
            <button type="submit" style="background:#0EA5E9; color:#fff; border:none; padding:10px 24px; border-radius:50px; font-weight:600; cursor:pointer;">
                <i class="fas fa-cloud-upload-alt"></i> {{ __('Upload') }}
            </button>
        </div>
        @error('images.*') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
    </form>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <h4 style="margin:0 0 16px 0;"><i class="fas fa-list me-2"></i> {{ __('Current Images') }}</h4>

    @if($images->count())
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px,1fr)); gap:20px;">
            @foreach($images as $image)
                <div style="background:#f8fafc; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                    <div style="position:relative; height:140px; background:#e2e8f0;">
                        <img src="{{ Storage::disk('cloud')->url($image->image) }}" alt="{{ $image->title }}" style="width:100%; height:100%; object-fit:cover;">
                        @if($gallery->cover_image == $image->image)
                            <span style="position:absolute; top:8px; left:8px; background:#22C55E; color:#fff; padding:2px 10px; border-radius:20px; font-size:0.65rem; font-weight:600;">{{ __('Cover') }}</span>
                        @endif
                    </div>
                    <div style="padding:10px;">
                        <form action="{{ route('admin.gallery.images.update', $image) }}" method="POST" style="display:flex; flex-direction:column; gap:6px;">
                            @csrf @method('PUT')
                            <input type="text" name="title" value="{{ $image->title }}" placeholder="{{ __('Caption') }}" style="width:100%; padding:6px 8px; border:1px solid #e2e8f0; border-radius:6px; font-size:0.8rem;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <input type="checkbox" name="is_published" value="1" {{ $image->is_published ? 'checked' : '' }} style="accent-color:#0EA5E9;">
                                <label style="font-size:0.75rem; color:#1e293b;">{{ __('Published') }}</label>
                            </div>
                            <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:4px;">
                                <button type="submit" style="background:#0EA5E9; color:#fff; border:none; padding:4px 12px; border-radius:6px; font-size:0.7rem; cursor:pointer;">
                                    <i class="fas fa-save"></i> {{ __('Update') }}
                                </button>
                                @if($gallery->cover_image != $image->image)
                                    <form action="{{ route('admin.gallery.setCover', [$gallery, $image]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background:#10B981; color:#fff; border:none; padding:4px 12px; border-radius:6px; font-size:0.7rem; cursor:pointer;">
                                            <i class="fas fa-star"></i> {{ __('Set Cover') }}
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.gallery.images.destroy', $image) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:#ef4444; color:#fff; border:none; padding:4px 12px; border-radius:6px; font-size:0.7rem; cursor:pointer;" onclick="return confirm('{{ __('Delete this image?') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $images->links() }}
    @else
        <p style="text-align:center; padding:30px; color:#94a3b8;">{{ __('No images in this album yet. Upload some!') }}</p>
    @endif
</div>
@endsection