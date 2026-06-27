@extends('layouts.admin')

@section('title', 'होस्टेल थप्नुहोस् - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">होस्टेल थप्नुहोस्</h2>
    <a href="{{ route('admin.hostels.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> फिर्ता
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.hostels.store') }}" method="POST" enctype="multipart/form-data" class="dashboard-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="name_nepali">नाम (नेपाली) <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name_nepali" id="name_nepali" value="{{ old('name_nepali') }}" required>
            </div>
            <div class="form-group">
                <label for="name_english">नाम (अंग्रेजी)</label>
                <input type="text" name="name_english" id="name_english" value="{{ old('name_english') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="operator_name">सञ्चालक <span style="color:#dc2626;">*</span></label>
                <input type="text" name="operator_name" id="operator_name" value="{{ old('operator_name') }}" required>
            </div>
            <div class="form-group">
                <label for="contact">सम्पर्क <span style="color:#dc2626;">*</span></label>
                <input type="text" name="contact" id="contact" value="{{ old('contact') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="district">जिल्ला <span style="color:#dc2626;">*</span></label>
                <input type="text" name="district" id="district" value="{{ old('district') }}" required>
            </div>
            <div class="form-group">
                <label for="municipality">नगरपालिका <span style="color:#dc2626;">*</span></label>
                <input type="text" name="municipality" id="municipality" value="{{ old('municipality') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="ward">वडा <span style="color:#dc2626;">*</span></label>
                <input type="text" name="ward" id="ward" value="{{ old('ward') }}" required>
            </div>
            <div class="form-group">
                <label for="street">सडक</label>
                <input type="text" name="street" id="street" value="{{ old('street') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description">विवरण</label>
            <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image">छवि</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:12px; padding-top:28px;">
                <input type="checkbox" name="approved" id="approved" value="1" {{ old('approved', true) ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0EA5E9;">
                <label for="approved" style="margin:0; font-weight:500; cursor:pointer;">स्वीकृत</label>
            </div>
        </div>

        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> थप्नुहोस्
            </button>
            <a href="{{ route('admin.hostels.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">रद्द गर्नुहोस्</a>
        </div>
    </form>
</div>
@endsection