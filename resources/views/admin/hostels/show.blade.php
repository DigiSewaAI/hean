@extends('layouts.admin')

@section('title', $hostel->name_nepali . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-hotel me-2" style="color:#0EA5E9;"></i> {{ $hostel->name_nepali }}
        {{-- ✅ 8.3: दर्ता नम्बर हेडरमा थपियो --}}
        <span style="font-size:0.9rem; font-weight:400; color:#64748b; margin-left:12px;">
            <i class="fas fa-hashtag" style="color:#0EA5E9;"></i>
            {{ $hostel->registration_number }}
        </span>
    </h2>
    <a href="{{ route('admin.hostels.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
    </a>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">

    {{-- Left Column --}}
    <div>
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-info-circle"></i> {{ __('messages.details') }}
            </div>
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                {{-- ✅ 8.3: दर्ता नम्बर विवरणमा पहिलो पङ्क्तिमा देखाइयो --}}
                <div style="grid-column:1/-1; background:#f0f9ff; padding:10px 14px; border-radius:8px; border-left:4px solid #0EA5E9;">
                    <label style="font-size:0.7rem; text-transform:uppercase; color:#0EA5E9; font-weight:700;">दर्ता नम्बर</label>
                    <p style="font-weight:700; color:#0f172a; margin:2px 0 0; font-size:1.1rem;">
                        {{ $hostel->registration_number }}
                    </p>
                </div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.hostel_name_nepali') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->name_nepali }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.hostel_name_english') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->name_english ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.type') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ ucfirst($hostel->type ?? __('messages.not_available')) }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.capacity') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->capacity ?? __('messages.not_available') }} {{ __('messages.beds') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.rooms') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->rooms ?? __('messages.not_available') }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.operator_name') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->operator_name }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.contact') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->contact }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.district') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->district }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.municipality') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->municipality }}</p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.ward') }}</label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;">{{ $hostel->ward }}</p></div>
                <div style="grid-column:1/-1;"><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.street') }}</label><p style="color:#475569; margin:2px 0 0;">{{ $hostel->street ?? __('messages.not_available') }}</p></div>
                @if($hostel->description)
                    <div style="grid-column:1/-1;"><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;">{{ __('messages.description') }}</label><p style="color:#475569; margin:2px 0 0;">{{ $hostel->description }}</p></div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div>
        {{-- Image --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="background:linear-gradient(135deg, #8B5CF6, #7C3AED); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-image"></i> {{ __('messages.image') }}
            </div>
            <div style="padding:20px; text-align:center;">
                @if($hostel->image)
                    <img src="{{ asset('storage/'.$hostel->image) }}" alt="{{ $hostel->name_nepali }}" style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                @else
                    <div style="padding:30px;">
                        <i class="fas fa-image" style="font-size:3rem; color:#cbd5e1;"></i>
                        <p style="color:#94a3b8; margin-top:8px;">{{ __('messages.no_image') }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Status --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="background:linear-gradient(135deg, #1E293B, #0F172A); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-toggle-on"></i> {{ __('messages.status') }}
            </div>
            <div style="padding:20px; display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#f8fafc; border-radius:8px;">
                    <span style="font-weight:500; color:#1e293b;">{{ __('messages.approved') }}</span>
                    <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; {{ $hostel->approved ? 'background:#dcfce7; color:#166534;' : 'background:#fef3c7; color:#92400e;' }}">
                        {{ $hostel->approved ? '✅ ' . __('messages.yes') : '❌ ' . __('messages.no') }}
                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#f8fafc; border-radius:8px;">
                    <span style="font-weight:500; color:#1e293b;">{{ __('messages.featured') }}</span>
                    <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; {{ $hostel->featured ? 'background:#dcfce7; color:#166534;' : 'background:#f8fafc; color:#94a3b8;' }}">
                        {{ $hostel->featured ? '⭐ ' . __('messages.yes') : '—' }}
                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#f8fafc; border-radius:8px;">
                    <span style="font-weight:500; color:#1e293b;">{{ __('messages.visible') }}</span>
                    <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; {{ $hostel->visible ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;' }}">
                        {{ $hostel->visible ? '👁️ ' . __('messages.yes') : '🚫 ' . __('messages.no') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection