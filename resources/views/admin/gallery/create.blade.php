@extends('layouts.admin')

@section('title', __('Add Event / Album') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-folder-plus me-2" style="color:#0EA5E9;"></i> {{ __('Add Event / Album') }}
    </h2>
    <a href="{{ route('admin.gallery.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('Back') }}
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.gallery.store') }}" method="POST">
        @csrf

        @if($errors->any())
            <div style="background:#fef2f2; border-left:4px solid #dc2626; padding:12px 20px; border-radius:8px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:20px; color:#dc2626;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
            <div class="form-group">
                <label for="name" style="font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">{{ __('Event / Album Name') }} <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px;" placeholder="e.g. Annual General Meeting 2026">
                @error('name') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label for="description" style="font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">{{ __('Description') }}</label>
                <textarea name="description" id="description" rows="3" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px;">{{ old('description') }}</textarea>
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label for="event_date" style="font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">{{ __('Event Date') }}</label>
                <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px;">
            </div>

            <div style="margin-top:16px; display:flex; align-items:center; gap:12px;">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} style="width:20px; height:20px; accent-color:#0EA5E9;">
                <label for="is_published" style="font-weight:500; color:#1e293b; cursor:pointer;">{{ __('Publish publicly') }}</label>
            </div>
        </div>

        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> {{ __('Create Album') }}
            </button>
            <a href="{{ route('admin.gallery.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection