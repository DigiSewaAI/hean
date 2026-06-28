@extends('layouts.public')

@section('title', __('messages.about') . ' - HEAN')

@section('content')

<!-- ===== HERO BANNER ===== -->
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:60px;">
    <div class="container">
        <h1 style="font-size:3.5rem; font-weight:800; margin-bottom:16px;">
            {{ __('messages.about_title') }}
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:700px; margin:0 auto;">
            {{ __('messages.hero_desc') }}
        </p>
    </div>
</section>

<!-- ===== MAIN CONTENT ===== -->
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">

        <!-- ===== INTRO WITH IMAGE (LEFT) ===== -->
        <div style="display:flex; flex-wrap:wrap; align-items:center; gap:40px; margin-bottom:60px;">
            <div style="flex:1; min-width:300px;">
                <img src="{{ asset('images/about.jpg') }}" alt="About HEAN" style="width:100%; border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,0.08);">
            </div>
            <div style="flex:1; min-width:300px;">
                <span class="section-badge" style="display:inline-block; background:rgba(14,165,233,0.12); color:#0EA5E9; padding:6px 18px; border-radius:50px; font-size:0.8rem; font-weight:600; margin-bottom:15px;">
                    {{ __('messages.about') }}
                </span>
                <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a; margin-bottom:20px;">
                    {{ __('messages.who_we_are') }}
                </h2>
                <p style="color:#475569; line-height:1.8; font-size:1.05rem;">
                    {{ __('messages.about_full_desc') }}
                </p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:25px;">
                    <div style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b;">
                        <span style="color:#0EA5E9; font-size:1.2rem;">✅</span>
                        {{ __('messages.about_feature_1') }}
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b;">
                        <span style="color:#0EA5E9; font-size:1.2rem;">✅</span>
                        {{ __('messages.about_feature_2') }}
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b;">
                        <span style="color:#0EA5E9; font-size:1.2rem;">✅</span>
                        {{ __('messages.about_feature_3') }}
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; font-weight:500; color:#1e293b;">
                        <span style="color:#0EA5E9; font-size:1.2rem;">✅</span>
                        {{ __('messages.about_feature_4') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== VISION & MISSION ===== -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px; margin-bottom:60px;">
            <div style="background:#f8fafc; border-radius:20px; padding:35px; border-left:6px solid #0EA5E9;">
                <h3 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin-bottom:16px;">
                    <i class="fas fa-eye" style="color:#0EA5E9; margin-right:10px;"></i> {{ __('messages.vision') }}
                </h3>
                <p style="color:#475569; line-height:1.8; font-size:1rem;">
                    {{ __('messages.vision_desc') }}
                </p>
            </div>
            <div style="background:#f8fafc; border-radius:20px; padding:35px; border-left:6px solid #22C55E;">
                <h3 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin-bottom:16px;">
                    <i class="fas fa-bullseye" style="color:#22C55E; margin-right:10px;"></i> {{ __('messages.mission') }}
                </h3>
                <p style="color:#475569; line-height:1.8; font-size:1rem;">
                    {{ __('messages.mission_desc') }}
                </p>
            </div>
        </div>

        <!-- ===== GOALS ===== -->
        <div style="margin-bottom:60px;">
            <h3 style="font-size:2rem; font-weight:700; color:#0f172a; text-align:center; margin-bottom:30px;">
                <i class="fas fa-flag-checkered" style="color:#8B5CF6; margin-right:12px;"></i> {{ __('messages.our_goals') }}
            </h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px,1fr)); gap:25px;">
                <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                    <div style="font-size:2.5rem; margin-bottom:12px;">🤝</div>
                    <h5 style="font-weight:700; color:#0f172a; margin-bottom:8px;">{{ __('messages.goal_1') }}</h5>
                </div>
                <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                    <div style="font-size:2.5rem; margin-bottom:12px;">🏆</div>
                    <h5 style="font-weight:700; color:#0f172a; margin-bottom:8px;">{{ __('messages.goal_2') }}</h5>
                </div>
                <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                    <div style="font-size:2.5rem; margin-bottom:12px;">📚</div>
                    <h5 style="font-weight:700; color:#0f172a; margin-bottom:8px;">{{ __('messages.goal_3') }}</h5>
                </div>
                <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                    <div style="font-size:2.5rem; margin-bottom:12px;">📢</div>
                    <h5 style="font-weight:700; color:#0f172a; margin-bottom:8px;">{{ __('messages.goal_4') }}</h5>
                </div>
            </div>
        </div>

        <!-- ===== FOUNDING + STATS + PRESIDENT ===== -->
        <div style="background:linear-gradient(135deg, #0f172a, #1e293b); border-radius:20px; padding:40px; color:#f8fafc; text-align:center;">
            <h3 style="font-size:1.8rem; font-weight:700; margin-bottom:12px;">
                <i class="fas fa-calendar-alt" style="color:#0EA5E9; margin-right:12px;"></i> 
                {{ __('messages.founded_title') }}
            </h3>
            <p style="opacity:0.9; max-width:700px; margin:0 auto 20px; line-height:1.8;">
                {{ __('messages.founded_desc') }}
            </p>

            <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:25px;">
                <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500;">
                    👥 200+ {{ __('messages.members') }}
                </span>
                <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500;">
                    🏆 5+ {{ __('messages.years_excellence') }}
                </span>
                <span style="background:rgba(255,255,255,0.06); padding:8px 20px; border-radius:50px; font-weight:500;">
                    🌍 30+ {{ __('messages.districts') }}
                </span>
            </div>

            <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:25px;">
                <h4 style="color:#0EA5E9; font-weight:600; margin-bottom:8px;">{{ __('messages.president_message_title') }}</h4>
                <p style="opacity:0.9; max-width:600px; margin:0 auto; font-style:italic;">
                    {{ __('messages.president_message') }}
                </p>
                <p style="margin-top:12px; font-weight:600;">
                    — {{ __('messages.president_name') }} <span style="opacity:0.7; font-weight:400;">({{ __('messages.president_designation') }})</span>
                </p>
            </div>
        </div>

    </div>
</section>

<!-- ===== CTA ===== -->
<section style="padding:60px 0; background:linear-gradient(135deg, #0EA5E9, #10B981); color:#fff; text-align:center;">
    <div class="container">
        <h2 style="font-size:2.2rem; font-weight:700; margin-bottom:12px;">{{ __('messages.cta_title') }}</h2>
        <p style="opacity:0.9; max-width:500px; margin:0 auto 25px;">{{ __('messages.cta_desc') }}</p>
        <a href="{{ route('membership.step', 1) }}" class="btn btn-white" style="background:#fff; color:#0EA5E9; padding:14px 40px; border-radius:50px; font-weight:600; text-decoration:none; display:inline-block; transition:0.3s;">
            {{ __('messages.cta_button') }}
        </a>
    </div>
</section>

<style>
    .section-badge {
        display: inline-block;
        background: rgba(14,165,233,0.12);
        color: #0EA5E9;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 15px;
    }
</style>
@endsection