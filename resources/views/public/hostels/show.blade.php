@extends('layouts.public')

@section('title', $hostel->name_nepali . ' - HEAN')

@section('content')
<section style="padding-top:140px; padding-bottom:60px; background:#f8fafc;">
    <div class="container">
        <div style="display:flex; gap:40px; flex-wrap:wrap; background:#fff; border-radius:24px; padding:40px; box-shadow:0 4px 30px rgba(0,0,0,0.05);">
            <div style="flex:1; min-width:300px;">
                @if($hostel->image)
                    <img src="{{ asset('storage/'.$hostel->image) }}" alt="{{ $hostel->name_nepali }}" style="width:100%; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                @else
                    <div style="background:#e2e8f0; width:100%; height:300px; border-radius:16px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:1.2rem;">
                        <i class="fas fa-hotel" style="font-size:4rem; opacity:0.3;"></i>
                    </div>
                @endif
            </div>
            <div style="flex:2; min-width:300px;">
                <h1 style="font-size:2.5rem; font-weight:800; color:#0f172a; margin-bottom:8px;">{{ $hostel->name_nepali }}</h1>
                @if($hostel->name_english)
                    <h2 style="font-size:1.2rem; font-weight:400; color:#64748b; margin-bottom:20px;">{{ $hostel->name_english }}</h2>
                @endif

                <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:20px;">
                    <span style="background:#eef2ff; color:#0EA5E9; padding:4px 14px; border-radius:50px; font-weight:600; font-size:0.85rem;">
                        <i class="fas fa-map-marker-alt"></i> {{ $hostel->district }}-{{ $hostel->ward }}
                    </span>
                    <span style="background:#eef2ff; color:#0EA5E9; padding:4px 14px; border-radius:50px; font-weight:600; font-size:0.85rem;">
                        <i class="fas fa-user"></i> {{ $hostel->operator_name }}
                    </span>
                    <span style="background:{{ $hostel->approved ? '#d1fae5' : '#fef3c7' }}; color:{{ $hostel->approved ? '#059669' : '#d97706' }}; padding:4px 14px; border-radius:50px; font-weight:600; font-size:0.85rem;">
                        <i class="fas fa-check-circle"></i> {{ $hostel->approved ? __('messages.approved') : __('messages.pending') }}
                    </span>
                </div>

                <div style="margin-bottom:20px;">
                    <p style="color:#475569; line-height:1.8;">{{ $hostel->description ?? __('messages.description_not_available') }}</p>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; background:#f8fafc; padding:20px; border-radius:16px;">
                    <div><i class="fas fa-phone" style="color:#0EA5E9;"></i> <strong>{{ __('messages.contact_label') }}:</strong> {{ $hostel->contact }}</div>
                    <div><i class="fas fa-map-pin" style="color:#0EA5E9;"></i> <strong>{{ __('messages.address_label') }}:</strong> {{ $hostel->street ?? __('messages.not_available') }}, {{ $hostel->municipality }}</div>
                    <div><i class="fas fa-calendar-alt" style="color:#0EA5E9;"></i> <strong>{{ __('messages.registration_date_label') }}:</strong> {{ $hostel->created_at->format('d M Y') }}</div>
                    <div><i class="fas fa-certificate" style="color:#0EA5E9;"></i> <strong>{{ __('messages.status_label') }}:</strong> {{ $hostel->approved ? __('messages.approved') : __('messages.pending') }}</div>
                </div>

                <div style="margin-top:30px;">
                    <a href="{{ route('hostels.index') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 24px; border-radius:50px; text-decoration:none; font-weight:600; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                        <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_hostels') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection