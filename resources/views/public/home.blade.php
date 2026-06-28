@extends('layouts.public')

@section('title', __('messages.home') . ' - HEAN')

@section('content')
{{-- Hero Section --}}
<section class="hero" id="home" style="min-height:100vh; display:flex; align-items:center; padding:120px 0 80px; position:relative; background:linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); overflow:hidden;">
    <div class="container" style="display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;">
        <div class="hero-content" style="position:relative; z-index:2;">
            <span class="hero-badge" style="display:inline-block; background:rgba(14,165,233,0.12); color:#0EA5E9; padding:8px 20px; border-radius:50px; font-size:0.85rem; font-weight:600; letter-spacing:0.5px; margin-bottom:20px;">{{ __('messages.hero_badge') }}</span>
            <h1 style="font-size:3.8rem; font-weight:800; line-height:1.2; color:#0f172a; max-width:700px;">{!! __('messages.hero_title') !!}</h1>
            <p style="font-size:1.2rem; color:#475569; max-width:540px; margin:20px 0 30px; line-height:1.7;">{{ __('messages.hero_desc') }}</p>
            <div class="hero-buttons" style="display:flex; gap:16px; flex-wrap:wrap;">
                {{-- REMOVED: Become Member button --}}
                <a href="{{ route('hostels.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; font-weight:600; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; transition:0.3s;">{{ __('messages.explore_network') }}</a>
            </div>
        </div>
        <div class="hero-dashboard" style="display:grid; grid-template-columns:1fr 1fr; gap:24px; background:rgba(255,255,255,0.7); backdrop-filter:blur(10px); padding:30px; border-radius:20px; border:1px solid rgba(255,255,255,0.5);">
            <div class="dash-stat">
                <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">600+</div>
                <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500;">@lang('messages.stats_hostels')</div>
            </div>
            <div class="dash-stat">
                <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">600+</div>
                <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500;">@lang('messages.stats_members')</div>
            </div>
            <div class="dash-stat">
                <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">Multiple</div>
                <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500;">@lang('messages.stats_districts')</div>
            </div>
            <div class="dash-stat">
                <div class="number" style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">Growing</div>
                <div class="label" style="font-size:0.85rem; color:#64748b; font-weight:500;">Community</div>
            </div>
        </div>
    </div>
</section>

{{-- About Section --}}
<section class="about-section" id="about" style="padding:100px 0; background:#ffffff;">
    <div class="container">
        <div class="about-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;">
            <div class="about-image">
                <img src="{{ asset('images/about.jpg') }}" alt="About HEAN" style="width:100%; border-radius:24px; box-shadow:0 20px 60px rgba(0,0,0,0.08);">
            </div>
            <div class="about-content">
                <span class="section-badge" style="display:inline-block; background:rgba(14,165,233,0.1); color:#0EA5E9; padding:6px 18px; border-radius:50px; font-size:0.8rem; font-weight:600; margin-bottom:15px;">{{ __('messages.about') }}</span>
                <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a; margin-bottom:20px;">{{ __('messages.about_title') }}</h2>
                <p style="color:#475569; line-height:1.8; margin-bottom:20px;">{{ __('messages.about_desc') }}</p>
                <div class="about-features" style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-top:25px;">
                    <div class="item" style="display:flex; align-items:center; gap:12px; font-weight:500; color:#1e293b;">
                        {!! __('messages.about_feature_1') !!}
                    </div>
                    <div class="item" style="display:flex; align-items:center; gap:12px; font-weight:500; color:#1e293b;">
                        {!! __('messages.about_feature_2') !!}
                    </div>
                    <div class="item" style="display:flex; align-items:center; gap:12px; font-weight:500; color:#1e293b;">
                        {!! __('messages.about_feature_3') !!}
                    </div>
                    <div class="item" style="display:flex; align-items:center; gap:12px; font-weight:500; color:#1e293b;">
                        {!! __('messages.about_feature_4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Trust Bar --}}
<section class="trust-bar" style="background:#0f172a; padding:40px 0; color:#f8fafc;">
    <div class="container">
        <div class="logos" style="display:flex; justify-content:space-around; align-items:center; flex-wrap:wrap; gap:30px;">
            <span style="color:#f8fafc; font-weight:600; font-size:1.1rem;">{{ __('messages.trust_bar_title') }}</span>
        </div>
    </div>
</section>

{{-- Recently Registered Hostels --}}
<section class="hostels-section" id="hostels" style="padding:100px 0; background:#f8fafc;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:50px;">
            <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a;">{{ __('messages.hostels_section_title') }}</h2>
            <p style="color:#64748b; margin-top:10px;">{{ __('messages.hostels_section_desc') }}</p>
        </div>
        <div class="hostel-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:30px;">
            @forelse($hostels as $hostel)
            <div class="hostel-card" style="background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:0.3s;">
                <div class="hostel-img" style="height:200px; overflow:hidden;">
                    <img src="{{ $hostel->image ? asset('storage/'.$hostel->image) : asset('images/hostel-placeholder.jpg') }}" alt="{{ $hostel->name_nepali }}" style="width:100%; height:100%; object-fit:cover; transition:0.4s;">
                </div>
                <div class="hostel-body" style="padding:20px;">
                    <h3 style="font-size:1.2rem; font-weight:700; color:#0f172a; margin-bottom:4px;">{{ $hostel->name_nepali }}</h3>
                    <div class="location" style="font-size:0.9rem; color:#64748b; display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <i class="fas fa-map-marker-alt" style="color:#0EA5E9;"></i> {{ $hostel->district }}-{{ $hostel->ward }}
                    </div>
                    <div class="meta" style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; padding-top:10px; border-top:1px solid #e2e8f0; font-size:0.85rem;">
                        <span style="color:#64748b;"><i class="far fa-calendar-alt"></i> {{ $hostel->created_at->format('d M Y') }}</span>
                        <a href="{{ route('hostels.show', $hostel) }}" class="btn btn-primary btn-sm" style="padding:6px 16px; border-radius:50px; background:#0EA5E9; color:#fff; text-decoration:none; font-weight:600; font-size:0.8rem;">View Profile</a>
                    </div>
                </div>
            </div>
            @empty
            <p>No hostels found.</p>
            @endforelse
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('hostels.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; font-weight:600; transition:0.3s;">{{ __('messages.view_all_hostels') }}</a>
        </div>
    </div>
</section>

{{-- Notices --}}
<section class="notices-section" id="notices" style="padding:100px 0; background:#fff;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:50px;">
            <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a;">{{ __('messages.notices_section_title') }}</h2>
            <p style="color:#64748b; margin-top:10px;">{{ __('messages.notices_section_desc') }}</p>
        </div>
        <div class="notice-list" style="display:grid; gap:20px;">
            @forelse($notices as $notice)
            <div class="notice-item" style="display:flex; align-items:center; gap:20px; padding:20px; background:#f8fafc; border-radius:16px; transition:0.3s;">
                <div class="date" style="min-width:70px; text-align:center; background:#fff; padding:10px 12px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                    <div class="day" style="font-size:1.6rem; font-weight:800; color:#0EA5E9; line-height:1;">{{ $notice->date->format('d') }}</div>
                    <div class="month" style="font-size:0.7rem; text-transform:uppercase; color:#64748b; font-weight:600;">{{ $notice->date->format('M') }}</div>
                </div>
                <div class="content" style="flex:1;">
                    <h4 style="font-weight:600; color:#0f172a; margin-bottom:4px;">{{ $notice->title }}</h4>
                    <p style="font-size:0.9rem; color:#64748b;">{{ Str::limit($notice->content, 100) }}</p>
                </div>
                <span class="badge" style="background:rgba(14,165,233,0.1); color:#0EA5E9; padding:4px 14px; border-radius:50px; font-size:0.7rem; font-weight:600;">{{ $notice->category ?? 'General' }}</span>
            </div>
            @empty
            <p>No notices found.</p>
            @endforelse
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('notices.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; font-weight:600;">{{ __('messages.view_all_notices') }}</a>
        </div>
    </div>
</section>

{{-- Gallery --}}
<section class="gallery-section" id="gallery" style="padding:100px 0; background:#f8fafc;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:50px;">
            <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a;">{{ __('messages.gallery_section_title') }}</h2>
            <p style="color:#64748b; margin-top:10px;">{{ __('messages.gallery_section_desc') }}</p>
        </div>
        <div class="gallery-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(240px,1fr)); gap:20px;">
            @forelse($gallery as $image)
            <div class="gallery-item" style="border-radius:16px; overflow:hidden; position:relative; aspect-ratio:1/1; cursor:pointer;">
                <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->title ?? 'Gallery' }}" style="width:100%; height:100%; object-fit:cover; transition:0.4s;">
                <div class="overlay" style="position:absolute; inset:0; background:rgba(15,23,42,0.4); opacity:0; transition:0.3s; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-search-plus" style="color:#fff; font-size:2rem;"></i>
                </div>
            </div>
            @empty
            <p>No images found.</p>
            @endforelse
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="{{ route('gallery.index') }}" class="btn btn-outline" style="padding:14px 34px; border-radius:50px; border:2px solid #cbd5e1; color:#1e293b; text-decoration:none; font-weight:600;">{{ __('messages.view_all_gallery') }}</a>
        </div>
    </div>
</section>

{{-- Member Voices --}}
<section class="member-voices-section" style="padding:80px 0; background:#0f172a; color:#f8fafc;">
    <div class="container" style="text-align:center;">
        <h2 style="font-size:2.2rem; font-weight:700; margin-bottom:12px;">Member Voices</h2>
        <p style="color:#94a3b8; font-size:1.1rem;">Coming Soon — Real stories from our hostel entrepreneurs.</p>
        <div style="margin-top:30px; display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
            <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500;">👥 200+ Members</span>
            <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500;">🏆 5+ Awards</span>
            <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500;">🌍 30+ Districts</span>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section" style="padding:80px 0; background:linear-gradient(135deg, #0EA5E9, #10B981); color:#fff; text-align:center;">
    <div class="container">
        <h2 style="font-size:2.5rem; font-weight:700; margin-bottom:15px;">{{ __('messages.cta_title') }}</h2>
        <p style="opacity:0.9; max-width:500px; margin:0 auto 30px;">{{ __('messages.cta_desc') }}</p>
        {{-- REMOVED: Become Member button (CTA) --}}
        {{-- Optionally add a link to the hostel list --}}
        <a href="{{ route('hostels.index') }}" class="btn btn-white" style="background:#fff; color:#0EA5E9; padding:14px 40px; border-radius:50px; font-weight:600; text-decoration:none; display:inline-block; transition:0.3s;">{{ __('messages.explore_network') }}</a>
    </div>
</section>
@endsection