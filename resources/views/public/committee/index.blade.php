@extends('layouts.public')

@section('title', __('messages.committee') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #1E40AF); color: white; text-align: center; padding-bottom:60px; position:relative; overflow:hidden;">
    {{-- Background Pattern --}}
    <div style="position:absolute; top:-50%; right:-20%; width:600px; height:600px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
    <div style="position:absolute; bottom:-40%; left:-10%; width:400px; height:400px; background:rgba(255,255,255,0.03); border-radius:50%;"></div>
    <div class="container" style="position:relative; z-index:2;">
        <h1 style="font-size:3.2rem; font-weight:800; margin-bottom:12px; letter-spacing:-0.5px;">
            <i class="fas fa-users me-3"></i> @lang('messages.committee')
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto; font-weight:300;">
            {{ __('messages.committee_hero_desc') }}
        </p>
    </div>
</section>

{{-- ===== STATS BAR (Enhanced) ===== --}}
<section style="padding:35px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:20px; text-align:center;">
            <div style="background:#fff; padding:20px; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                <div style="font-size:2.4rem; font-weight:800; color:#0EA5E9;">{{ $members->count() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.85rem; font-weight:500;">{{ __('messages.committee_stats_total') }}</div>
            </div>
            <div style="background:#fff; padding:20px; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                <div style="font-size:2.4rem; font-weight:800; color:#22C55E;">
                    {{ $members->pluck('position')->unique()->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.85rem; font-weight:500;">{{ __('messages.committee_stats_positions') }}</div>
            </div>
            <div style="background:#fff; padding:20px; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                <div style="font-size:2.4rem; font-weight:800; color:#8B5CF6;">
                    {{ $members->where('is_published', true)->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.85rem; font-weight:500;">{{ __('messages.committee_stats_active') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== COMMITTEE SECTIONS ===== --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">

        {{-- ---------- 1. Central Executive Committee ---------- --}}
        @if($central->count())
        <div style="margin-bottom:60px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:8px; flex-wrap:wrap;">
                <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; border-left:5px solid #0EA5E9; padding-left:15px;">
                    <i class="fas fa-star" style="color:#0EA5E9;"></i> {{ __('messages.central_executive_committee') }}
                </h2>
                <span style="background:#0EA5E9; color:#fff; padding:4px 16px; border-radius:50px; font-size:0.75rem; font-weight:600; white-space:nowrap;">
                    {{ $central->count() }} {{ __('messages.members') }}
                </span>
            </div>
            <p style="color:#64748b; margin-bottom:30px; font-size:0.95rem;">{{ __('messages.central_executive_desc') }}</p>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px,1fr)); gap:30px;">
                @foreach($central as $member)
                <div class="committee-card" style="background:#fff; border-radius:20px; padding:28px 20px 22px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:all 0.35s ease; border:1px solid #f1f5f9; position:relative;">
                    {{-- Badge --}}
                    @if($member->position == 'President')
    <div style="position:absolute; top:12px; right:12px; background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.85rem; box-shadow:0 2px 10px rgba(245,158,11,0.3);">
        <i class="fas fa-crown"></i>
    </div>
@endif
                    <div style="position:relative; display:inline-block; margin-bottom:15px;">
                        <img src="{{ $member->image_url }}" 
                             alt="{{ $member->name }}" 
                             style="width:130px; height:130px; border-radius:50%; object-fit:cover; border:4px solid #e2e8f0; transition:border-color 0.3s;">
                        @if($member->is_published)
                            <span style="position:absolute; bottom:4px; right:4px; width:16px; height:16px; background:#22C55E; border-radius:50%; border:3px solid #fff; display:block;"></span>
                        @endif
                    </div>
                    <h3 style="font-size:1.2rem; font-weight:700; color:#0f172a; margin-bottom:4px;">{{ $member->name }}</h3>
                    <div style="display:inline-block; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:4px 16px; border-radius:50px; font-size:0.7rem; font-weight:600; margin-bottom:12px;">
                        {{ $member->position }}
                    </div>
                    <div style="display:flex; justify-content:center; gap:10px; margin-top:10px; padding-top:14px; border-top:1px solid #e2e8f0;">
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
                            <span style="color:#94a3b8; font-size:0.75rem;">{{ __('messages.committee_no_social') }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ---------- 2. District Committees ---------- --}}
        @if($districts->count())
        <div style="margin-bottom:60px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:8px; flex-wrap:wrap;">
                <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; border-left:5px solid #8B5CF6; padding-left:15px;">
                    <i class="fas fa-map-marker-alt" style="color:#8B5CF6;"></i> {{ __('messages.district_committees') }}
                </h2>
                <span style="background:#8B5CF6; color:#fff; padding:4px 16px; border-radius:50px; font-size:0.75rem; font-weight:600; white-space:nowrap;">
                    {{ $districts->count() }} {{ __('messages.members') }}
                </span>
            </div>
            <p style="color:#64748b; margin-bottom:30px; font-size:0.95rem;">{{ __('messages.district_committees_desc') }}</p>

            @php
                $districtGroups = $districts->groupBy(function($item) {
                    preg_match('/\((.*?)\)/', $item->position, $matches);
                    return $matches[1] ?? 'Other';
                });
            @endphp

            @foreach($districtGroups as $districtName => $groupMembers)
            <div style="margin-bottom:40px; background:#fafbfc; border-radius:16px; padding:20px 20px 25px; border:1px solid #eef2f6;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
                    <h3 style="font-size:1.2rem; font-weight:600; color:#1e293b; margin:0; background:linear-gradient(135deg, #8B5CF6, #7C3AED); padding:6px 18px; border-radius:8px; display:inline-block; color:#fff;">
                        <i class="fas fa-map-pin"></i> {{ $districtName }}
                    </h3>
                    <span style="background:#e2e8f0; color:#1e293b; padding:2px 14px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                        {{ $groupMembers->count() }} {{ __('messages.members') }}
                    </span>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px,1fr)); gap:20px;">
                    @foreach($groupMembers as $member)
                    <div class="committee-card district-card" style="background:#fff; border-radius:14px; padding:18px 14px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.04); transition:all 0.3s ease; border:1px solid #f1f5f9;">
                        <div style="position:relative; display:inline-block; margin-bottom:10px;">
                            <img src="{{ $member->image_url }}" 
                                 alt="{{ $member->name }}" 
                                 style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0;">
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
        <div style="margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:8px; flex-wrap:wrap;">
                <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; border-left:5px solid #64748b; padding-left:15px;">
                    <i class="fas fa-history" style="color:#64748b;"></i> {{ __('messages.former_founder_committees') }}
                </h2>
                <span style="background:#64748b; color:#fff; padding:4px 16px; border-radius:50px; font-size:0.75rem; font-weight:600; white-space:nowrap;">
                    {{ $former->count() }} {{ __('messages.members') }}
                </span>
            </div>
            <p style="color:#64748b; margin-bottom:30px; font-size:0.95rem;">{{ __('messages.former_founder_desc') }}</p>

            @php
                $formerGroups = $former->groupBy(function($item) {
                    preg_match('/\((.*?)\)/', $item->position, $matches);
                    return $matches[1] ?? 'Other';
                });
            @endphp

            @foreach($formerGroups as $groupName => $groupMembers)
            <div style="margin-bottom:30px;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                    <h3 style="font-size:1.1rem; font-weight:600; color:#1e293b; margin:0; background:#e2e8f0; padding:5px 16px; border-radius:6px; display:inline-block;">
                        {{ $groupName }}
                    </h3>
                    <span style="background:#cbd5e1; color:#1e293b; padding:1px 12px; border-radius:50px; font-size:0.65rem; font-weight:600;">
                        {{ $groupMembers->count() }}
                    </span>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(190px,1fr)); gap:16px;">
                    @foreach($groupMembers as $member)
                    <div class="committee-card former-card" style="background:#f8fafc; border-radius:12px; padding:14px 12px; text-align:center; border:1px solid #e2e8f0; transition:all 0.3s ease;">
                        <div style="position:relative; display:inline-block; margin-bottom:8px;">
                            <img src="{{ $member->image_url }}" 
                                 alt="{{ $member->name }}" 
                                 style="width:70px; height:70px; border-radius:50%; object-fit:cover; border:2px solid #e2e8f0;">
                        </div>
                        <h4 style="font-size:0.85rem; font-weight:600; color:#0f172a; margin-bottom:2px;">{{ $member->name }}</h4>
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
        <div style="text-align:center; padding:60px 20px; background:#f8fafc; border-radius:20px;">
            <i class="fas fa-users" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:15px;"></i>
            <p style="color:#94a3b8; font-size:1.1rem;">{{ __('messages.committee_empty') }}</p>
        </div>
        @endif

    </div>
</section>

{{-- ===== QR CODE SECTION ===== --}}
<x-qr-section />

@endsection

@push('styles')
<style>
    /* Committee Card Hover Effects */
    .committee-card {
        transition: all 0.3s ease;
    }
    .committee-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
        border-color: #0EA5E9 !important;
    }
    .committee-card:hover img {
        border-color: #0EA5E9 !important;
    }

    /* District Card */
    .district-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(139,92,246,0.10) !important;
        border-color: #8B5CF6 !important;
    }
    .district-card:hover img {
        border-color: #8B5CF6 !important;
    }

    /* Former Card */
    .former-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06) !important;
        border-color: #94a3b8 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .committee-card {
            padding: 18px 12px !important;
        }
        .committee-card img {
            width: 90px !important;
            height: 90px !important;
        }
        .district-card img {
            width: 70px !important;
            height: 70px !important;
        }
        .former-card img {
            width: 60px !important;
            height: 60px !important;
        }
        .container {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
    }

    /* Section headers with badges */
    .section-header-with-count {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Member count badge */
    .member-count-badge {
        background: #0EA5E9;
        color: #fff;
        padding: 2px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    // Optional: Add any JS if needed
</script>
@endpush