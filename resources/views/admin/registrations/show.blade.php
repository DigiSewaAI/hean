@extends('layouts.admin')

@section('title', 'आवेदन विवरण - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>आवेदन विवरण #{{ $registration->id }}</h2>
    <a href="{{ route('admin.registrations.index') }}" class="btn btn-outline">← फिर्ता</a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div><strong>होस्टेल नाम:</strong> {{ $registration->hostel_name }}</div>
        <div><strong>सञ्चालक:</strong> {{ $registration->operator_name }}</div>
        <div><strong>जिल्ला:</strong> {{ $registration->district }}</div>
        <div><strong>नगरपालिका:</strong> {{ $registration->municipality }}</div>
        <div><strong>वडा:</strong> {{ $registration->ward }}</div>
        <div><strong>सडक:</strong> {{ $registration->street ?? 'N/A' }}</div>
        <div><strong>सम्पर्क:</strong> {{ $registration->contact }}</div>
        <div>
            <strong>स्थिति:</strong>
            <span class="badge-status badge-{{ $registration->status }}">
                {{ ucfirst($registration->status) }}
            </span>
        </div>
        <div><strong>मिति:</strong> {{ $registration->created_at->format('Y-m-d') }}</div>
    </div>
</div>

<div style="margin-top:30px; display:flex; gap:15px; flex-wrap:wrap;">
    {{-- Approve Button --}}
    @if($registration->status === 'pending')
    <form action="{{ route('admin.registrations.approve', $registration) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-success">✅ स्वीकृत गर्नुहोस्</button>
    </form>
    @endif

    {{-- Reject Button --}}
    @if($registration->status === 'pending' || $registration->status === 'inspection')
    <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger" onclick="return confirm('के तपाईं निश्चित हुनुहुन्छ?')">❌ अस्वीकृत गर्नुहोस्</button>
    </form>
    @endif

    {{-- Inspection Button --}}
    @if($registration->status === 'pending')
    <a href="{{ route('admin.inspections.create', $registration) }}" class="btn btn-primary">🔍 निरीक्षण गर्नुहोस्</a>
    @endif

    {{-- Certificate Button --}}
    @if($registration->status === 'approved' || $registration->status === 'inspection')
    <form action="{{ route('admin.certificate.generate') }}" method="POST" style="display:inline;">
        @csrf
        <input type="hidden" name="registration_id" value="{{ $registration->id }}">
        <button type="submit" class="btn btn-primary" style="background: #8b5cf6; box-shadow: 0 8px 25px rgba(139,92,246,0.3);">
            📜 प्रमाणपत्र जारी गर्नुहोस्
        </button>
    </form>
    @endif

    {{-- Certificate Preview Link (if already generated) --}}
    @if(session('certificate_data'))
    <a href="{{ route('admin.certificate.index') }}" class="btn btn-outline" style="border-color:#8b5cf6; color:#8b5cf6;">
        👁️ प्रमाणपत्र पूर्वावलोकन
    </a>
    @endif
</div>

{{-- Flash Message --}}
@if(session('success'))
<div style="margin-top:20px; background:#10b981; color:#fff; padding:12px 20px; border-radius:10px;">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="margin-top:20px; background:#ef4444; color:#fff; padding:12px 20px; border-radius:10px;">
    {{ session('error') }}
</div>
@endif
@endsection