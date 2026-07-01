@extends('layouts.admin')

@section('title', __('messages.add_gallery_image') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-images me-2" style="color:#0EA5E9;"></i> {{ __('messages.add_gallery_image') }}
    </h2>
    <a href="{{ route('admin.gallery.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ===== Error Messages ===== --}}
        @if($errors->any())
            <div style="background:#fef2f2; border-left:4px solid #dc2626; padding:12px 20px; border-radius:8px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:20px; color:#dc2626;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ===== Image Upload ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #F59E0B;">
            <h4 style="margin:0 0 16px 0; color:#F59E0B;">
                <i class="fas fa-image me-2"></i> {{ __('messages.image_upload') }}
            </h4>
            <div class="form-group">
                <label for="image" style="font-weight:600; color:#1e293b; margin-bottom:6px; display:block;">
                    {{ __('messages.image') }} <span style="color:#dc2626;">*</span>
                </label>
                <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.webp" required
                       style="width:100%; padding:10px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
                <small style="color:#64748b; font-size:0.75rem; display:block; margin-top:4px;">
                    <i class="fas fa-info-circle"></i> 
                    {{ __('messages.allowed_formats') }}
                </small>
                @error('image')
                    <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ===== Title ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
            <h4 style="margin:0 0 16px 0; color:#0EA5E9;">
                <i class="fas fa-tag me-2"></i> {{ __('messages.image_details') }}
            </h4>
            <div class="form-group">
                <label for="title" style="font-weight:600; color:#1e293b; margin-bottom:6px; display:block;">
                    {{ __('messages.title_optional') }}
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.2s;"
                       placeholder="{{ __('messages.title_placeholder') }}">
                @error('title')
                    <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ===== Publish Status ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #10B981;">
            <h4 style="margin:0 0 16px 0; color:#10B981;">
                <i class="fas fa-globe me-2"></i> {{ __('messages.publication_status') }}
            </h4>
            <div style="display:flex; align-items:center; gap:12px;">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                       style="width:20px; height:20px; accent-color:#0EA5E9; cursor:pointer;">
                <label for="is_published" style="font-weight:500; color:#1e293b; cursor:pointer;">
                    <i class="fas fa-eye" style="color:#0EA5E9;"></i> {{ __('messages.publish_publicly') }}
                </label>
            </div>
            <small style="color:#64748b; font-size:0.75rem; display:block; margin-top:6px;">
                <i class="fas fa-info-circle"></i> 
                {{ __('messages.publish_help_text') }}
            </small>
        </div>

        {{-- ===== Submit Buttons ===== --}}
        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> {{ __('messages.add_image') }}
            </button>
            <a href="{{ route('admin.gallery.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">
                {{ __('messages.cancel') }}
            </a>
        </div>

    </form>
</div>
@endsection