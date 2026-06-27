@extends('layouts.admin')

@section('title', 'सेटिङहरू - HEAN Admin')

@section('content')
<h2>सेटिङहरू</h2>
<form action="{{ route('admin.settings.update') }}" method="POST" class="dashboard-form">
    @csrf
    <div class="form-group"><label>साइट नाम</label><input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"></div>
    <div class="form-group"><label>ठेगाना</label><input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}"></div>
    <div class="form-group"><label>फोन</label><input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}"></div>
    <div class="form-group"><label>इमेल</label><input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}"></div>
    <div class="form-group"><label>कार्यालय समय</label><input type="text" name="office_hours" value="{{ $settings['office_hours'] ?? '' }}"></div>
    <button type="submit" class="btn btn-primary">अद्यावधिक गर्नुहोस्</button>
</form>
@endsection