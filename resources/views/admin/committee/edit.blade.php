@extends('layouts.admin')

@section('title', __('messages.edit_committee_member') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>{{ __('messages.edit_committee_member') }}</h2>
    <a href="{{ route('admin.committee.index') }}" class="btn btn-outline-sm">← {{ __('messages.back') }}</a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.committee.update', $committee) }}" method="POST" enctype="multipart/form-data" class="dashboard-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">{{ __('messages.name') }} <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $committee->name) }}" required placeholder="{{ __('messages.full_name') }}">
            </div>
            <div class="form-group">
                <label for="position">{{ __('messages.position') }} <span style="color:#dc2626;">*</span></label>
                <input type="text" name="position" id="position" value="{{ old('position', $committee->position) }}" required placeholder="{{ __('messages.position_placeholder') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="facebook">{{ __('messages.facebook_link') }}</label>
                <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $committee->facebook) }}" placeholder="{{ __('messages.facebook_placeholder') }}">
            </div>
            <div class="form-group">
                <label for="linkedin">{{ __('messages.linkedin_link') }}</label>
                <input type="url" name="linkedin" id="linkedin" value="{{ old('linkedin', $committee->linkedin) }}" placeholder="{{ __('messages.linkedin_placeholder') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="order">{{ __('messages.order') }}</label>
                <input type="number" name="order" id="order" value="{{ old('order', $committee->order ?? 0) }}" min="0">
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:12px; padding-top:28px;">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $committee->is_published) ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0EA5E9;">
                <label for="is_published" style="margin:0; font-weight:500; cursor:pointer;">{{ __('messages.publish') }}</label>
            </div>
        </div>

        <div class="form-group">
            <label for="image">{{ __('messages.photo') }}</label>
            @if($committee->image)
                <div style="margin-bottom:10px;">
                    <img src="{{ asset('storage/'.$committee->image) }}" alt="{{ $committee->name }}" style="height:80px; width:80px; object-fit:cover; border-radius:50%;">
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*">
            <small style="color:#64748b; display:block; margin-top:4px;">{{ __('messages.upload_new_photo_optional') }}</small>
        </div>

        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" class="btn btn-primary-sm" style="background:#0EA5E9; padding:10px 30px; border:none; border-radius:8px; color:#fff; font-weight:600; cursor:pointer; transition:0.3s;">
                <i class="fas fa-save"></i> {{ __('messages.update') }}
            </button>
            <a href="{{ route('admin.committee.index') }}" class="btn btn-outline-sm" style="padding:10px 30px; border:1px solid #cbd5e1; border-radius:8px; color:#1e293b; text-decoration:none; font-weight:500;">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection