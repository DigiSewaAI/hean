@section('bodyClass', 'homepage')
@extends('layouts.public')

@section('title', __('messages.home') . ' - HEAN')

@section('content')

{{-- ===== HERO SECTION (BALANCED: No cut, reduced gap) ===== --}}
<section class="hero" id="home" style="min-height:100vh; display:flex; align-items:center; padding: calc(var(--navbar-height) + 20px) 0 80px;

 position:relative; background:linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); overflow:hidden;">
    <div class="container grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="hero-content" style="position:relative; z-index:2; overflow:visible;">

            {{-- Badge --}}
            <span class="hero-badge" style="display:inline-block; background:rgba(14,165,233,0.12); color:#0EA5E9; padding:8px 20px; border-radius:50px; font-size:0.85rem; font-weight:600; letter-spacing:0.5px; margin-bottom:16px;">
                {{ __('messages.hero_badge') }}
            </span>

            {{-- ✅ Balanced: No cut, reduced gap --}}
            <h1 style="font-size:3.8rem; font-weight:800; line-height:1.4; color:#0f172a; max-width:700px; letter-spacing:0.02em; word-spacing:0.03em; padding:4px 0; overflow:visible; display:inline-block; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                {!! __('messages.hero_title') !!}
            </h1>

            {{-- ✅ Balanced subtitle --}}
            <p style="font-size:1.2rem; color:#475569; max-width:540px; margin:16px 0 24px; line-height:1.8; letter-spacing:0.02em; padding:2px 0; overflow:visible; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                {{ __('messages.hero_desc') }}
            </p>

            {{-- Hero Buttons --}}
            <div class="hero-buttons" style="display:flex; gap:16px; flex-wrap:wrap;">
                <a href="{{ route('hostels.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; font-weight:600; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; transition:0.3s; display:inline-block;">
                    {{ __('messages.explore_network') }}
                </a>
            </div>
        </div>

        {{-- Stats Dashboard --}}
<div class="hero-dashboard grid grid-cols-1 sm:grid-cols-2 gap-6" style="background:rgba(255,255,255,0.7); backdrop-filter:blur(10px); padding:30px; border-radius:20px; border:1px solid rgba(255,255,255,0.5);">    <div class="dash-stat" style="text-align:center;">
        <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $stats['hostels'] ?? '0' }}+</div>
        <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500; letter-spacing:0.03em;">@lang('messages.stats_hostels')</div>
    </div>
    <div class="dash-stat" style="text-align:center;">
        <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $stats['members'] ?? '0' }}+</div>
        <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500; letter-spacing:0.03em;">@lang('messages.stats_members')</div>
    </div>
    <div class="dash-stat" style="text-align:center;">
        <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $stats['districts'] ?? '0' }}</div>
        <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500; letter-spacing:0.03em;">@lang('messages.stats_districts')</div>
    </div>
    <div class="dash-stat" style="text-align:center;">
        <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $stats['growth'] ?? '0' }}%</div>
        <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500; letter-spacing:0.03em;">{{ __('messages.stats_community') }}</div>
    </div>
</div>
    </div>
</section>

{{-- ===== ABOUT SECTION ===== --}}
<section class="about-section" id="about" style="padding:80px 0; background:#ffffff;">
    <div class="container">
<div class="about-grid grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="about-image">
                <img src="{{ asset('images/about.jpg') }}" alt="About HEAN" style="width:100%; border-radius:24px; box-shadow:0 20px 60px rgba(0,0,0,0.08);">
            </div>
            <div class="about-content">
                <span class="section-badge" style="display:inline-block; background:rgba(14,165,233,0.1); color:#0EA5E9; padding:6px 18px; border-radius:50px; font-size:0.8rem; font-weight:600; margin-bottom:15px; letter-spacing:0.03em;">
                    {{ __('messages.about') }}
                </span>
                <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a; margin-bottom:16px; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                    {{ __('messages.about_title') }}
                </h2>
                <p style="color:#475569; line-height:1.8; margin-bottom:16px; letter-spacing:0.02em; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                    {{ __('messages.about_desc') }}
                </p>
<div class="about-features grid grid-cols-1 sm:grid-cols-2 gap-3 mt-5">
                        <div class="item" style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b; letter-spacing:0.02em; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                        {!! __('messages.about_feature_1') !!}
                    </div>
                    <div class="item" style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b; letter-spacing:0.02em; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                        {!! __('messages.about_feature_2') !!}
                    </div>
                    <div class="item" style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b; letter-spacing:0.02em; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                        {!! __('messages.about_feature_3') !!}
                    </div>
                    <div class="item" style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b; letter-spacing:0.02em; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                        {!! __('messages.about_feature_4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SUPPORTING ORGANIZATIONS ===== --}}
<x-supporting-organizations :organizations="$supportingOrganizations" />

{{-- ===== HOSTELS SECTION ===== --}}
<section class="hostels-section" id="hostels" style="padding:80px 0; background:#f8fafc;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:40px;">
            <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.hostels_section_title') }}</h2>
            <p style="color:#64748b; margin-top:8px; letter-spacing:0.02em; line-height:1.7; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.hostels_section_desc') }}</p>
        </div>
        <div class="hostel-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:30px;">
            @forelse($hostels as $hostel)
            <div class="hostel-card" style="background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:0.3s;">
                <div class="hostel-img" style="height:200px; overflow:hidden;">
<img src="{{ $hostel->image ? Storage::url($hostel->image) : asset('images/hostel-placeholder.jpg') }}" alt="{{ $hostel->name_english ?? $hostel->name_nepali }}" style="width:100%; height:100%; object-fit:cover; transition:0.4s;">                </div>
                <div class="hostel-body" style="padding:20px;">
                    <h3 style="font-size:1.2rem; font-weight:700; color:#0f172a; margin-bottom:2px;">
    {{ $hostel->name_english ?? $hostel->name_nepali }}
</h3>
<div style="font-size:0.8rem; color:#94a3b8; margin-bottom:4px;">
    {{ $hostel->name_nepali }}
</div>
<div class="location" style="font-size:0.9rem; color:#64748b; display:flex; align-items:center; gap:6px; margin-bottom:6px;">
    <i class="fas fa-map-marker-alt" style="color:#0EA5E9;"></i> {{ $hostel->district }}-{{ $hostel->ward }}
</div>
                    <div class="meta" style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; padding-top:10px; border-top:1px solid #e2e8f0; font-size:0.85rem;">
                        <span style="color:#64748b; letter-spacing:0.02em;"><i class="far fa-calendar-alt"></i> {{ $hostel->created_at->format('d M Y') }}</span>
                        <a href="{{ route('hostels.show', $hostel) }}" class="btn btn-primary btn-sm" style="padding:6px 16px; border-radius:50px; background:#0EA5E9; color:#fff; text-decoration:none; font-weight:600; font-size:0.8rem;">{{ __('messages.view_profile') }}</a>
                    </div>
                </div>
            </div>
            @empty
            <p>{{ __('messages.no_hostels_found') }}</p>
            @endforelse
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('hostels.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; font-weight:600; transition:0.3s; display:inline-block;">{{ __('messages.view_all_hostels') }}</a>
        </div>
    </div>
</section>

{{-- ===== NOTICES SECTION ===== --}}
<section class="notices-section" id="notices" style="padding:80px 0; background:#fff;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:40px;">
            <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.notices_section_title') }}</h2>
            <p style="color:#64748b; margin-top:8px; letter-spacing:0.02em; line-height:1.7; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.notices_section_desc') }}</p>
        </div>
        <div class="notice-list" style="display:grid; gap:20px;">
            @forelse($notices as $notice)
            <div class="notice-item" style="display:flex; align-items:center; gap:20px; padding:20px; background:#f8fafc; border-radius:16px; transition:0.3s;">
                <div class="date" style="min-width:70px; text-align:center; background:#fff; padding:10px 12px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                    <div class="day" style="font-size:1.6rem; font-weight:800; color:#0EA5E9; line-height:1.2;">{{ $notice->date->format('d') }}</div>
                    <div class="month" style="font-size:0.7rem; text-transform:uppercase; color:#64748b; font-weight:600; letter-spacing:0.03em;">{{ $notice->date->format('M') }}</div>
                </div>
                <div class="content" style="flex:1;">
                    <h4 style="font-weight:600; color:#0f172a; margin-bottom:4px; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ $notice->title }}</h4>
                    <p style="font-size:0.9rem; color:#64748b; letter-spacing:0.02em; line-height:1.7; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ Str::limit($notice->content, 100) }}</p>
                </div>
                <span class="badge" style="background:rgba(14,165,233,0.1); color:#0EA5E9; padding:4px 14px; border-radius:50px; font-size:0.7rem; font-weight:600; letter-spacing:0.03em;">{{ $notice->category ?? __('messages.general') }}</span>
            </div>
            @empty
            <p>{{ __('messages.no_notices_found') }}</p>
            @endforelse
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('notices.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; font-weight:600; display:inline-block;">{{ __('messages.view_all_notices') }}</a>
        </div>
    </div>
</section>

{{-- ===== GALLERY SECTION (Right to Left Scrolling) ===== --}}
<section class="gallery-section" id="gallery" style="padding:80px 0; background:#f8fafc;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:40px;">
            <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                {{ __('messages.gallery_section_title') }}
            </h2>
            <p style="color:#64748b; margin-top:8px; letter-spacing:0.02em; line-height:1.7; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                {{ __('messages.gallery_section_desc') }}
            </p>
        </div>

        {{-- Scrolling Gallery --}}
        <div style="overflow:hidden; position:relative; width:100%;">
            <div class="gallery-scroll" style="display:flex; gap:20px; animation: scrollGallery 25s linear infinite; width:max-content;">
                @forelse($gallery as $image)
                    <div style="flex:0 0 280px; border-radius:16px; overflow:hidden; position:relative; aspect-ratio:1/1; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
                        <img src="{{ Storage::url($image->image) }}" 
     alt="{{ $image->title ?? __('messages.gallery') }}" 
     style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s;">
                        @if($image->title)
                            <div style="position:absolute; bottom:0; left:0; right:0; padding:12px; background:linear-gradient(transparent, rgba(0,0,0,0.6)); color:#fff; font-size:0.85rem; font-weight:500; text-align:center;">
                                {{ $image->title }}
                            </div>
                        @endif
                    </div>
                @empty
                    <p>{{ __('messages.no_images_found') }}</p>
                @endforelse

                {{-- Duplicate for seamless scrolling --}}
@forelse($gallery as $image)
    <div style="flex:0 0 280px; border-radius:16px; overflow:hidden; position:relative; aspect-ratio:1/1; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
        <img src="{{ Storage::url($image->image) }}" 
             alt="{{ $image->title ?? __('messages.gallery') }}" 
             style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s;">
        @if($image->title)
            <div style="position:absolute; bottom:0; left:0; right:0; padding:12px; background:linear-gradient(transparent, rgba(0,0,0,0.6)); color:#fff; font-size:0.85rem; font-weight:500; text-align:center;">
                {{ $image->title }}
            </div>
        @endif
    </div>
@empty
@endforelse
            </div>
        </div>

        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('gallery.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; font-weight:600; display:inline-block; transition:0.3s;">
                {{ __('messages.view_all_gallery') }}
            </a>
        </div>
    </div>
</section>

{{-- ===== MEMBER VOICES ===== --}}
<section class="member-voices-section" style="padding:60px 0; background:#0f172a; color:#f8fafc;">
    <div class="container" style="text-align:center;">
        <h2 style="font-size:2.2rem; font-weight:700; margin-bottom:12px; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.member_voices') }}</h2>
        <p style="color:#94a3b8; font-size:1.1rem; letter-spacing:0.02em; line-height:1.7; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.member_voices_sub') }}</p>
        <div style="margin-top:30px; display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
            <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500; letter-spacing:0.03em;">{{ __('messages.member_stats_members') }}</span>
            <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500; letter-spacing:0.03em;">{{ __('messages.member_stats_awards') }}</span>
            <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500; letter-spacing:0.03em;">{{ __('messages.member_stats_districts') }}</span>
        </div>
    </div>
</section>

{{-- ===== CTA SECTION ===== --}}
<section class="cta-section" style="padding:60px 0; background:linear-gradient(135deg, #0EA5E9, #10B981); color:#fff; text-align:center;">
    <div class="container">
        <h2 style="font-size:2.5rem; font-weight:700; margin-bottom:12px; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.cta_title') }}</h2>
        <p style="opacity:0.9; max-width:500px; margin:0 auto 24px; letter-spacing:0.02em; line-height:1.7; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">{{ __('messages.cta_desc') }}</p>
        <a href="{{ route('hostels.index') }}" class="btn btn-white" style="background:#fff; color:#0EA5E9; padding:14px 40px; border-radius:50px; font-weight:600; text-decoration:none; display:inline-block; transition:0.3s; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
            <i class="fas fa-hotel me-2"></i> {{ __('messages.explore_network') }}
        </a>
    </div>
</section>

{{-- ===== QR CODE SECTION ===== --}}
<x-qr-section />

@endsection

@push('styles')
<style>
    /* ✅ Google Font for Nepali support */
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600;700;800&display=swap');

    /* Hero Badge */
    .hero-badge {
        display: inline-block;
        background: rgba(14, 165, 233, 0.12);
        color: #0EA5E9;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }

    /* Section Badge */
    .section-badge {
        display: inline-block;
        background: rgba(14, 165, 233, 0.1);
        color: #0EA5E9;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 15px;
        letter-spacing: 0.03em;
    }

    /* Hostel Card */
    .hostel-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08) !important;
    }
    .hostel-card:hover .hostel-img img {
        transform: scale(1.05);
    }
    .hostel-img img {
        transition: transform 0.4s ease;
    }

    /* Notice Item */
    .notice-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    /* Gallery Item */
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    .gallery-item:hover .overlay {
        opacity: 1 !important;
    }
    .gallery-item img {
        transition: transform 0.4s ease;
    }

    /* CTA Button */
    .btn-white:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    @media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem !important;
    }
    /* .about-grid र .hero-dashboard को grid हटाइयो – Tailwind ले नै handle गर्छ */
}
    /* Gallery Scroll Animation - Right to Left */
.gallery-scroll {
    display: flex;
    gap: 20px;
    animation: scrollGallery 25s linear infinite;
    width: max-content;
}

@keyframes scrollGallery {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

/* Pause on hover */
.gallery-scroll:hover {
    animation-play-state: paused;
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-scroll {
        gap: 12px;
        animation-duration: 20s;
    }
    .gallery-scroll > div {
        flex: 0 0 200px !important;
    }
}
/* 🚀 Home page mobile overflow fix */
@media (max-width: 768px) {
    .hero .container {
        max-width: 100% !important;
        overflow: hidden !important;
    }
    .hero-content {
        max-width: 100% !important;
        overflow: hidden !important;
    }
    .hero-dashboard {
        max-width: 100% !important;
        overflow: hidden !important;
    }
}
</style>
@endpush