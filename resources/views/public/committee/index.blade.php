@extends('layouts.public')

@section('title', __('messages.committee') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:3rem; font-weight:800; margin-bottom:12px;">
            <i class="fas fa-users me-3"></i> @lang('messages.committee')
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto;">
            {{ __('messages.committee_hero_desc') }}
        </p>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<section style="padding:30px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:20px; text-align:center;">
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $members->count() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.committee_stats_total') }}</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#22C55E;">
                    {{ $members->pluck('position')->unique()->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.committee_stats_positions') }}</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#8B5CF6;">
                    {{ $members->where('is_published', true)->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.committee_stats_active') }}</div>
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
            <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin-bottom:8px; border-left:5px solid #0EA5E9; padding-left:15px;">
                <i class="fas fa-star" style="color:#0EA5E9;"></i> {{ __('messages.central_executive_committee') }}
            </h2>
            <p style="color:#64748b; margin-bottom:30px;">{{ __('messages.central_executive_desc') }}</p>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:30px;">
                @foreach($central as $member)
                <div class="committee-card" style="background:#fff; border-radius:20px; padding:30px 20px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:transform 0.3s, box-shadow 0.3s; border:1px solid #f1f5f9; position:relative;">
                    <div style="position:relative; display:inline-block; margin-bottom:15px;">
                        <img src="{{ $member->image_url }}" 
                             alt="{{ $member->name }}" 
                             style="width:130px; height:130px; border-radius:50%; object-fit:cover; border:4px solid #e2e8f0; transition:border-color 0.3s;">
                        @if($member->is_published)
                            <span style="position:absolute; bottom:4px; right:4px; width:16px; height:16px; background:#22C55E; border-radius:50%; border:3px solid #fff; display:block;"></span>
                        @endif
                    </div>
                    <h3 style="font-size:1.2rem; font-weight:700; color:#0f172a; margin-bottom:4px;">{{ $member->name }}</h3>
                    <div style="display:inline-block; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:4px 16px; border-radius:50px; font-size:0.75rem; font-weight:600; margin-bottom:12px;">
                        {{ $member->position }}
                    </div>
                    @if($member->order)
                        <p style="color:#94a3b8; font-size:0.7rem; margin-bottom:8px;"><i class="fas fa-hashtag"></i> {{ __('messages.committee_order_label') }} {{ $member->order }}</p>
                    @endif
                    <div style="display:flex; justify-content:center; gap:12px; margin-top:10px; padding-top:15px; border-top:1px solid #e2e8f0;">
                        @if($member->facebook)
                            <a href="{{ $member->facebook }}" target="_blank" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#1877F2; color:#fff; border-radius:50%; text-decoration:none; transition:0.3s; font-size:0.9rem;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($member->linkedin)
                            <a href="{{ $member->linkedin }}" target="_blank" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#0A66C2; color:#fff; border-radius:50%; text-decoration:none; transition:0.3s; font-size:0.9rem;">
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
            <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin-bottom:8px; border-left:5px solid #8B5CF6; padding-left:15px;">
                <i class="fas fa-map-marker-alt" style="color:#8B5CF6;"></i> {{ __('messages.district_committees') }}
            </h2>
            <p style="color:#64748b; margin-bottom:30px;">{{ __('messages.district_committees_desc') }}</p>

            @php
                $districtGroups = $districts->groupBy(function($item) {
                    preg_match('/\((.*?)\)/', $item->position, $matches);
                    return $matches[1] ?? 'Other';
                });
            @endphp

            @foreach($districtGroups as $districtName => $groupMembers)
            <div style="margin-bottom:40px;">
                <h3 style="font-size:1.3rem; font-weight:600; color:#1e293b; margin-bottom:20px; background:#f1f5f9; padding:8px 16px; border-radius:8px; display:inline-block;">
                    {{ $districtName }}
                </h3>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px,1fr)); gap:25px;">
                    @foreach($groupMembers as $member)
                    <div class="committee-card" style="background:#fff; border-radius:16px; padding:20px 15px; text-align:center; box-shadow:0 2px 12px rgba(0,0,0,0.04); transition:0.3s; border:1px solid #f1f5f9;">
                        <div style="position:relative; display:inline-block; margin-bottom:12px;">
                            <img src="{{ $member->image_url }}" 
                                 alt="{{ $member->name }}" 
                                 style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0;">
                        </div>
                        <h4 style="font-size:1rem; font-weight:700; color:#0f172a; margin-bottom:2px;">{{ $member->name }}</h4>
                        <div style="font-size:0.7rem; color:#8B5CF6; font-weight:600; background:#f3e8ff; padding:2px 12px; border-radius:50px; display:inline-block; margin-bottom:8px;">
                            {{ $member->position }}
                        </div>
                        @if($member->order)
                            <p style="color:#94a3b8; font-size:0.65rem;">{{ __('messages.committee_order_label') }} {{ $member->order }}</p>
                        @endif
                        <div style="display:flex; justify-content:center; gap:10px; margin-top:8px; padding-top:10px; border-top:1px solid #e2e8f0;">
                            @if($member->facebook)
                                <a href="{{ $member->facebook }}" target="_blank" style="color:#1877F2; font-size:0.9rem;"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" style="color:#0A66C2; font-size:0.9rem;"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            @if(!$member->facebook && !$member->linkedin)
                                <span style="color:#94a3b8; font-size:0.65rem;">—</span>
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
            <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin-bottom:8px; border-left:5px solid #64748b; padding-left:15px;">
                <i class="fas fa-history" style="color:#64748b;"></i> {{ __('messages.former_founder_committees') }}
            </h2>
            <p style="color:#64748b; margin-bottom:30px;">{{ __('messages.former_founder_desc') }}</p>

            @php
                $formerGroups = $former->groupBy(function($item) {
                    preg_match('/\((.*?)\)/', $item->position, $matches);
                    return $matches[1] ?? 'Other';
                });
            @endphp

            @foreach($formerGroups as $groupName => $groupMembers)
            <div style="margin-bottom:40px;">
                <h3 style="font-size:1.2rem; font-weight:600; color:#1e293b; margin-bottom:20px; background:#e2e8f0; padding:6px 14px; border-radius:6px; display:inline-block;">
                    {{ $groupName }}
                </h3>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:20px;">
                    @foreach($groupMembers as $member)
                    <div class="committee-card" style="background:#f8fafc; border-radius:12px; padding:16px 12px; text-align:center; border:1px solid #e2e8f0; transition:0.3s;">
                        <div style="position:relative; display:inline-block; margin-bottom:10px;">
                            <img src="{{ $member->image_url }}" 
                                 alt="{{ $member->name }}" 
                                 style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0;">
                        </div>
                        <h4 style="font-size:0.95rem; font-weight:600; color:#0f172a; margin-bottom:2px;">{{ $member->name }}</h4>
                        <div style="font-size:0.65rem; color:#64748b; font-weight:500; background:#e2e8f0; padding:1px 10px; border-radius:50px; display:inline-block; margin-bottom:6px;">
                            {{ $member->position }}
                        </div>
                        @if($member->order)
                            <p style="color:#94a3b8; font-size:0.6rem;">{{ __('messages.committee_order_label') }} {{ $member->order }}</p>
                        @endif
                        <div style="display:flex; justify-content:center; gap:8px; margin-top:6px; padding-top:8px; border-top:1px solid #e2e8f0;">
                            @if($member->facebook)
                                <a href="{{ $member->facebook }}" target="_blank" style="color:#1877F2; font-size:0.8rem;"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" style="color:#0A66C2; font-size:0.8rem;"><i class="fab fa-linkedin-in"></i></a>
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
    .committee-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08) !important;
        border-color: #0EA5E9 !important;
    }
    .committee-card:hover img {
        border-color: #0EA5E9 !important;
    }
    @media (max-width: 768px) {
        .committee-card {
            padding: 16px 12px !important;
        }
        .committee-card img {
            width: 80px !important;
            height: 80px !important;
        }
    }
</style>
@endpush