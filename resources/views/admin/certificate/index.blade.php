@extends('layouts.admin')

@section('title', 'प्रमाणपत्र - HEAN Admin')

@section('content')
<h2>प्रमाणपत्र पूर्वावलोकन</h2>
<div class="certificate-preview">
    <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="HEAN" style="height:50px;">
</div>
    <h3>{{ $data['hostel_name'] ?? 'होस्टेल नाम' }}</h3>
    <div class="details">ठेगाना: {{ $data['address'] ?? 'ठेगाना' }}</div>
    <div class="reg-no">दर्ता नं: {{ $data['registration_no'] ?? 'HEAN-2025-001' }}</div>
    <div>मिति: {{ $data['date'] ?? now()->format('Y-m-d') }}</div>
</div>

<form action="{{ route('admin.certificate.generate') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>आवेदन ID</label>
        <input type="number" name="registration_id" required>
    </div>
    <button type="submit" class="btn btn-primary">प्रमाणपत्र जारी गर्नुहोस्</button>
</form>
@endsection