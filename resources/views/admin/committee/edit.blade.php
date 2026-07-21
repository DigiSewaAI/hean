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

        {{-- ✅ committee_type_id (readonly/disabled if already set) --}}
        <div class="form-row">
            <div class="form-group">
                <label for="committee_type_id">{{ __('messages.committee_type') }} <span style="color:#dc2626;">*</span></label>
                <select name="committee_type_id" id="committee_type_id" required 
                        style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="1" {{ old('committee_type_id', $committee->committee_type_id ?? 1) == 1 ? 'selected' : '' }}>{{ __('messages.central') }}</option>
                    <option value="2" {{ old('committee_type_id', $committee->committee_type_id) == 2 ? 'selected' : '' }}>{{ __('messages.district') }}</option>
                </select>
            </div>
            <div class="form-group" id="districtField" style="{{ old('committee_type_id', $committee->committee_type_id) == 2 ? 'display:block;' : 'display:none;' }}">
                <label for="district">{{ __('messages.district_name') }}</label>
                <input type="text" name="district" id="district" value="{{ old('district', $committee->district ?? '') }}" 
                       placeholder="{{ __('messages.district_placeholder') }}">
            </div>
        </div>

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
            {{-- ✅ linkedin हटाइयो --}}
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
                    <img src="{{ $committee->image_url }}" alt="{{ $committee->name }}" style="height:80px; width:80px; object-fit:cover; border-radius:50%;">
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

{{-- ✅ JavaScript: District field toggle --}}
@push('scripts')
<script>
    document.getElementById('committee_type_id').addEventListener('change', function() {
        var districtField = document.getElementById('districtField');
        if (this.value == '2') {
            districtField.style.display = 'block';
        } else {
            districtField.style.display = 'none';
        }
    });
</script>
@endpush

@endsection