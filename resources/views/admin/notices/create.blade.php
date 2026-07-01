@extends('layouts.admin')

@section('title', __('messages.add_notice_title') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">{{ __('messages.add_notice') }}</h2>
    <a href="{{ route('admin.notices.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.notices.store') }}" method="POST" enctype="multipart/form-data" class="dashboard-form">
        @csrf

        <div class="form-group">
            <label for="title">{{ __('messages.title') }} <span style="color:#dc2626;">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="{{ __('messages.title_placeholder') }}">
        </div>

        <div class="form-group">
            <label for="content">{{ __('messages.content') }} <span style="color:#dc2626;">*</span></label>
            <textarea name="content" id="content" rows="6" required placeholder="{{ __('messages.content_placeholder') }}">{{ old('content') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date">{{ __('messages.date') }} <span style="color:#dc2626;">*</span></label>
                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label for="category">{{ __('messages.category') }}</label>
                <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="{{ __('messages.category_placeholder') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group" style="display:flex; align-items:center; gap:12px; padding-top:28px;">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0EA5E9;">
                <label for="is_featured" style="margin:0; font-weight:500; cursor:pointer;">{{ __('messages.featured') }}</label>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:12px; padding-top:28px;">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0EA5E9;">
                <label for="is_published" style="margin:0; font-weight:500; cursor:pointer;">{{ __('messages.publish') }}</label>
            </div>
        </div>

        <div class="form-group">
            <label for="image">{{ __('messages.image') }}</label>
            <input type="file" name="image" id="image" accept="image/*">
            <small style="color:#64748b; display:block; margin-top:4px;">{{ __('messages.recommended_image_size_notice') }}</small>
        </div>

        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> {{ __('messages.save') }}
            </button>
            <a href="{{ route('admin.notices.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection