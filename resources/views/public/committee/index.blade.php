@extends('layouts.public')

@section('title', __('messages.committee') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:60px;">
    <div class="container">
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:16px;">
            <span style="background:rgba(255,255,255,0.15); padding:8px 24px; border-radius:50px; font-size:0.8rem; font-weight:600; letter-spacing:1px; backdrop-filter:blur(4px);">
                <i class="fas fa-users me-2"></i> {{ __('messages.hero_badge') }}
            </span>
            <h1 style="font-size:3.5rem; font-weight:800; margin-bottom:4px; letter-spacing:-0.02em; line-height:1.2;">
                <i class="fas fa-handshake me-3" style="opacity:0.8;"></i> @lang('messages.committee')
            </h1>
            <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto; line-height:1.8;">
                {{ __('messages.committee_hero_desc') }}
            </p>
        </div>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<section style="padding:40px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:24px; text-align:center;">
            <div style="background:#fff; border-radius:16px; padding:20px; box-shadow:0 2px 12px rgba(0,0,0,0.04); border:1px solid #e2e8f0;">
                <div style="font-size:2.5rem; font-weight:800; color:#0EA5E9;">{{ $members->count() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500; letter-spacing:0.03em;">{{ __('messages.committee_stats_total') }}</div>
            </div>
            <div style="background:#fff; border-radius:16px; padding:20px; box-shadow:0 2px 12px rgba(0,0,0,0.04); border:1px solid #e2e8f0;">
                <div style="font-size:2.5rem; font-weight:800; color:#22C55E;">
                    {{ $members->pluck('position')->unique()->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500; letter-spacing:0.03em;">{{ __('messages.committee_stats_positions') }}</div>
            </div>
            <div style="background:#fff; border-radius:16px; padding:20px; box-shadow:0 2px 12px rgba(0,0,0,0.04); border:1px solid #e2e8f0;">
                <div style="font-size:2.5rem; font-weight:800; color:#8B5CF6;">
                    {{ $members->where('is_published', true)->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500; letter-spacing:0.03em;">{{ __('messages.committee_stats_active') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== COMMITTEE SECTIONS ===== --}}
<section style="padding:70px 0; background:#ffffff;">
    <div class="container">

        {{-- ---------- 1. Central Executive Committee ---------- --}}
        @if($central->count())
        <div style="margin-bottom:70px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                <div style="width:5px; height:40px; background:linear-gradient(180deg, #0EA5E9, #3B82F6); border-radius:4px;"></div>
                <h2 style="font-size:2rem; font-weight:700; color:#0f172a; margin:0;">
                    <i class="fas fa-star" style="color:#0EA5E9;"></i> {{ __('messages.central_executive_committee') }}
                </h2>
                <span style="background:#0EA5E9; color:#fff; padding:2px 14px; border-radius:50px; font-size:0.7rem; font-weight:600; letter-spacing:0.5px; margin-left:auto;">
                    {{ $central->count() }} {{ __('messages.members') }}
                </span>
            </div>
            <p style="color:#64748b; margin-bottom:30px; padding-left:17px;">{{ __('messages.central_executive_desc') }}</p>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px,1fr)); gap:30px;">
                @foreach($central as $member)
                <div class="committee-card" style="background:#fff; border-radius:20px; padding:30px 20px 25px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s; border:1px solid #f1f5f9; position:relative;">
                    <div style="position:relative; display:inline-block; margin-bottom:16px;">
                        <img src="{{ $member->image_url }}" 
                             alt="{{ $member->name }}" 
                             style="width:140px; height:140px; border-radius:50%; object-fit:cover; border:5px solid #e2e8f0; transition:border-color 0.3s, transform 0.3s;">
                        @if($member->is_published)
                            <span style="position:absolute; bottom:6px; right:6px; width:18px; height:18px; background:#22C55E; border-radius:50%; border:4px solid #fff; display:block; box-shadow:0 2px 8px rgba(34,197,94,0.3);"></span>
                        @endif
                        {{-- Order Badge --}}
                        @if($member->order)
                            <span style="position:absolute; top:-6px; right:-6px; background:#0f172a; color:#fff; font-size:0.6rem; font-weight:700; width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                                #{{ $member->order }}
                            </span>
                        @endif
                    </div>
                    <h3 style="font-size:1.15rem; font-weight:700; color:#0f172a; margin-bottom:4px;">{{ $member->name }}</h3>
                    <div style="display:inline-block; background:linear-gradient(135deg, #0EA5E9, #2563EB); color:#fff; padding:5px 18px; border-radius:50px; font-size:0.7rem; font-weight:600; margin-bottom:14px; letter-spacing:0.3px;">
                        {{ $member->position }}
                    </div>
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:10px; padding-top:14px; border-top:1px solid #e2e8f0;">
                        @if($member->facebook)
                            <a href="{{ $member->facebook }}" target="_blank" style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; background:#1877F2; color:#fff; border-radius:50%; text-decoration:none; transition:0.3s; font-size:0.85rem;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($member->linkedin)
                            <a href="{{ $member->linkedin }}" target="_blank" style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; background:#0A66C2; color:#fff; border-radius:50%; text-decoration:none; transition:0.3s; font-size:0.85rem;">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if(!$member->facebook && !$member->linkedin)
                            <span style="color:#94a3b8; font-size:0.7rem; font-weight:500;">{{ __('messages.committee_no_social') }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ---------- 2. District Committees ---------- --}}
        @if($districts->count())
        <div style="margin-bottom:70px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                <div style="width:5px; height:40px; background:linear-gradient(180deg, #8B5CF6, #6D28D9); border-radius:4px;"></div>
                <h2 style="font-size:2rem; font-weight:700; color:#0f172a; margin:0;">
                    <i class="fas fa-map-marker-alt" style="color:#8B5CF6;"></i> {{ __('messages.district_committees') }}
                </h2>
                <span style="background:#8B5CF6; color:#fff; padding:2px 14px; border-radius:50px; font-size:0.7rem; font-weight:600; letter-spacing:0.5px; margin-left:auto;">
                    {{ $districts->count() }} {{ __('messages.members') }}
                </span>
            </div>
            <p style="color:#64748b; margin-bottom:30px; padding-left:17px;">{{ __('messages.district_committees_desc') }}</p>

            @php
                $districtGroups = $districts->groupBy(function($item) {
                    preg_match('/\((.*?)\)/', $item->position, $matches);
                    return $matches[1] ?? 'Other';
                });
            @endphp

            @foreach($districtGroups as $districtName => $groupMembers)
            <div style="margin-bottom:40px; background:#fafcff; border-radius:16px; padding:24px; border:1px solid #eef2ff;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
                    <span style="background:#8B5CF6; color:#fff; font-size:0.9rem; font-weight:700; padding:4px 18px; border-radius:50px; letter-spacing:0.5px;">
                        {{ $districtName }}
                    </span>
                    <span style="color:#94a3b8; font-size:0.8rem; font-weight:500;">
                        {{ $groupMembers->count() }} {{ __('messages.members') }}
                    </span>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:20px;">
                    @foreach($groupMembers as $member)
                    <div class="committee-card" style="background:#fff; border-radius:14px; padding:18px 14px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:0.3s; border:1px solid #f1f5f9;">
                        <div style="position:relative; display:inline-block; margin-bottom:10px;">
                            <img src="{{ $member->image_url }}" 
                                 alt="{{ $member->name }}" 
                                 style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0; transition:border-color 0.3s;">
                        </div>
                        <h4 style="font-size:0.95rem; font-weight:700; color:#0f172a; margin-bottom:2px;">{{ $member->name }}</h4>
                        <div style="font-size:0.65rem; color:#8B5CF6; font-weight:600; background:#f3e8ff; padding:2px 12px; border-radius:50px; display:inline-block; margin-bottom:6px;">
                            {{ $member->position }}
                        </div>
                        <div style="display:flex; justify-content:center; gap:8px; margin-top:6px; padding-top:8px; border-top:1px solid #e2e8f0;">
                            @if($member->facebook)
                                <a href="{{ $member->facebook }}" target="_blank" style="color:#1877F2; font-size:0.85rem;"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" style="color:#0A66C2; font-size:0.85rem;"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if(!$member->facebook && !$member->linkedin)
                                <span style="color:#94a3b8; font-size:0.6rem;">—</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- ---------- 3. Former / Founder Committees ---------- --}}
        @if($former->count())
        <div>
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                <div style="width:5px; height:40px; background:linear-gradient(180deg, #64748b, #334155); border-radius:4px;"></div>
                <h2 style="font-size:2rem; font-weight:700; color:#0f172a; margin:0;">
                    <i class="fas fa-history" style="color:#64748b;"></i> {{ __('messages.former_founder_committees') }}
                </h2>
                <span style="background:#64748b; color:#fff; padding:2px 14px; border-radius:50px; font-size:0.7rem; font-weight:600; letter-spacing:0.5px; margin-left:auto;">
                    {{ $former->count() }} {{ __('messages.members') }}
                </span>
            </div>
            <p style="color:#64748b; margin-bottom:30px; padding-left:17px;">{{ __('messages.former_founder_desc') }}</p>

            @php
                $formerGroups = $former->groupBy(function($item) {
                    preg_match('/\((.*?)\)/', $item->position, $matches);
                    return $matches[1] ?? 'Other';
                });
            @endphp

            @foreach($formerGroups as $groupName => $groupMembers)
            <div style="margin-bottom:35px; background:#f8fafc; border-radius:12px; padding:20px 24px; border:1px solid #e2e8f0;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                    <span style="background:#475569; color:#fff; font-size:0.8rem; font-weight:700; padding:3px 16px; border-radius:50px; letter-spacing:0.3px;">
                        {{ $groupName }}
                    </span>
                    <span style="color:#94a3b8; font-size:0.75rem; font-weight:500;">
                        {{ $groupMembers->count() }} {{ __('messages.members') }}
                    </span>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px,1fr)); gap:16px;">
                    @foreach($groupMembers as $member)
                    <div class="committee-card" style="background:#fff; border-radius:10px; padding:14px 12px; text-align:center; border:1px solid #e2e8f0; transition:0.3s;">
                        <div style="position:relative; display:inline-block; margin-bottom:8px;">
                            <img src="{{ $member->image_url }}" 
                                 alt="{{ $member->name }}" 
                                 style="width:70px; height:70px; border-radius:50%; object-fit:cover; border:2px solid #e2e8f0;">
                        </div>
                        <h5 style="font-size:0.85rem; font-weight:600; color:#0f172a; margin-bottom:2px;">{{ $member->name }}</h5>
                        <div style="font-size:0.6rem; color:#64748b; font-weight:500; background:#e2e8f0; padding:1px 10px; border-radius:50px; display:inline-block; margin-bottom:4px;">
                            {{ $member->position }}
                        </div>
                        <div style="display:flex; justify-content:center; gap:6px; margin-top:4px; padding-top:6px; border-top:1px solid #e2e8f0;">
                            @if($member->facebook)
                                <a href="{{ $member->facebook }}" target="_blank" style="color:#1877F2; font-size:0.75rem;"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" style="color:#0A66C2; font-size:0.75rem;"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if(!$member->facebook && !$member->linkedin)
                                <span style="color:#94a3b8; font-size:0.55rem;">—</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($members->count() == 0)
        <div style="text-align:center; padding:80px 20px; background:#f8fafc; border-radius:24px; border:2px dashed #e2e8f0;">
            <i class="fas fa-users" style="font-size:4rem; color:#cbd5e1; display:block; margin-bottom:16px;"></i>
            <h3 style="color:#1e293b; font-weight:600; margin-bottom:4px;">{{ __('messages.no_members_found') }}</h3>
            <p style="color:#94a3b8; font-size:1rem;">{{ __('messages.committee_empty') }}</p>
        </div>
        @endif

    </div>
</section>

{{-- ===== QR CODE SECTION ===== --}}
<x-qr-section />

@endsection

@push('styles')
<style>
    .committee-card:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
        border-color: #0EA5E9 !important;
    }

    .committee-card:hover img {
        border-color: #0EA5E9 !important;
        transform: scale(1.03);
    }

    .committee-card img {
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    /* District card hover */
    .committee-card:hover .committee-card {
        border-color: #8B5CF6 !important;
    }

    @media (max-width: 768px) {
        .committee-card {
            padding: 16px 12px !important;
        }
        .committee-card img {
            width: 80px !important;
            height: 80px !important;
        }
        h1 {
            font-size: 2.5rem !important;
        }
        h2 {
            font-size: 1.5rem !important;
        }
    }

    /* Smooth fade-in animation */
    .committee-card {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .committee-card:nth-child(1) { animation-delay: 0.05s; }
    .committee-card:nth-child(2) { animation-delay: 0.10s; }
    .committee-card:nth-child(3) { animation-delay: 0.15s; }
    .committee-card:nth-child(4) { animation-delay: 0.20s; }
    .committee-card:nth-child(5) { animation-delay: 0.25s; }
    .committee-card:nth-child(6) { animation-delay: 0.30s; }
    .committee-card:nth-child(7) { animation-delay: 0.35s; }
    .committee-card:nth-child(8) { animation-delay: 0.40s; }
    .committee-card:nth-child(9) { animation-delay: 0.45s; }
    .committee-card:nth-child(10) { animation-delay: 0.50s; }
    .committee-card:nth-child(11) { animation-delay: 0.55s; }
    .committee-card:nth-child(12) { animation-delay: 0.60s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush