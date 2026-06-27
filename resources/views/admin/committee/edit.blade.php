@extends('layouts.admin')

@section('title', 'समिति सदस्य सम्पादन - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>समिति सदस्य सम्पादन</h2>
    <a href="{{ route('admin.committee.index') }}" class="btn btn-outline-sm">← फिर्ता</a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.committee.update', $committee) }}" method="POST" enctype="multipart/form-data" class="dashboard-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">नाम <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $committee->name) }}" required placeholder="पूरा नाम">
            </div>
            <div class="form-group">
                <label for="position">पद <span style="color:#dc2626;">*</span></label>
                <input type="text" name="position" id="position" value="{{ old('position', $committee->position) }}" required placeholder="जस्तै: अध्यक्ष">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="facebook">Facebook लिङ्क</label>
                <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $committee->facebook) }}" placeholder="https://facebook.com/username">
            </div>
            <div class="form-group">
                <label for="linkedin">LinkedIn लिङ्क</label>
                <input type="url" name="linkedin" id="linkedin" value="{{ old('linkedin', $committee->linkedin) }}" placeholder="https://linkedin.com/in/username">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="order">क्रम (Order)</label>
                <input type="number" name="order" id="order" value="{{ old('order', $committee->order ?? 0) }}" min="0">
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:12px; padding-top:28px;">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $committee->is_published) ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0EA5E9;">
                <label for="is_published" style="margin:0; font-weight:500; cursor:pointer;">प्रकाशित गर्नुहोस्</label>
            </div>
        </div>

        <div class="form-group">
            <label for="image">फोटो</label>
            @if($committee->image)
                <div style="margin-bottom:10px;">
                    <img src="{{ asset('storage/'.$committee->image) }}" alt="{{ $committee->name }}" style="height:80px; width:80px; object-fit:cover; border-radius:50%;">
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*">
            <small style="color:#64748b; display:block; margin-top:4px;">नयाँ फोटो अपलोड गर्नुहोस् (वैकल्पिक)</small>
        </div>

        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" class="btn btn-primary-sm" style="background:#0EA5E9; padding:10px 30px; border:none; border-radius:8px; color:#fff; font-weight:600; cursor:pointer; transition:0.3s;">
                <i class="fas fa-save"></i> अद्यावधिक गर्नुहोस्
            </button>
            <a href="{{ route('admin.committee.index') }}" class="btn btn-outline-sm" style="padding:10px 30px; border:1px solid #cbd5e1; border-radius:8px; color:#1e293b; text-decoration:none; font-weight:500;">रद्द गर्नुहोस्</a>
        </div>
    </form>
</div>
@endsection