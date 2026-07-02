@extends('layouts.public')

@section('title', $notice->title . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:2.5rem; font-weight:800; margin-bottom:10px;">
            <i class="fas fa-bullhorn me-3"></i> {{ $notice->title }}
        </h1>
        <p style="font-size:1.1rem; opacity:0.9; max-width:600px; margin:0 auto;">
            {{ $notice->category ?? __('messages.general') }} · {{ $notice->date->format('d M Y') }}
        </p>
    </div>
</section>

{{-- ===== NOTICE DETAIL ===== --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">
        <div style="max-width:800px; margin:0 auto;">

            {{-- Back Button --}}
            <div style="margin-bottom:30px;">
                <a href="{{ route('notices.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#0EA5E9; text-decoration:none; font-weight:600; transition:0.3s;">
                    <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_notices') }}
                </a>
            </div>

            {{-- Main Card --}}
            <div style="background:#fff; border-radius:20px; padding:40px; box-shadow:0 4px 20px rgba(0,0,0,0.05); border:1px solid #e2e8f0;">

                {{-- Featured Badge --}}
                @if($notice->is_featured)
                    <div style="display:inline-block; background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:4px 18px; border-radius:50px; font-size:0.75rem; font-weight:700; margin-bottom:16px;">
                        <i class="fas fa-star"></i> {{ __('messages.featured') }}
                    </div>
                @endif

                {{-- Category --}}
                <div style="display:inline-block; background:rgba(14,165,233,0.1); color:#0EA5E9; padding:4px 16px; border-radius:50px; font-size:0.8rem; font-weight:600; margin-bottom:16px;">
                    {{ $notice->category ?? __('messages.general') }}
                </div>

                {{-- Title --}}
                <h2 style="font-size:2rem; font-weight:800; color:#0f172a; margin-bottom:12px;">
                    {{ $notice->title }}
                </h2>

                {{-- Date --}}
                <div style="color:#64748b; font-size:0.9rem; margin-bottom:20px; display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <i class="far fa-calendar-alt" style="color:#0EA5E9;"></i>
                    {{ $notice->date->format('l, d F Y') }}
                    <span style="color:#cbd5e1;">|</span>
                    <i class="far fa-clock" style="color:#0EA5E9;"></i>
                    {{ __('messages.posted') }} {{ $notice->created_at->diffForHumans() }}
                </div>

                {{-- Image (if any) --}}
                @if($notice->image)
                    <div style="margin-bottom:25px; border-radius:16px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
                        <img src="{{ asset('storage/'.$notice->image) }}" alt="{{ $notice->title }}" style="width:100%; max-height:400px; object-fit:cover;">
                    </div>
                @endif

                {{-- Content --}}
                <div style="font-size:1.05rem; line-height:1.8; color:#1e293b;">
                    {!! nl2br(e($notice->content)) !!}
                </div>

                {{-- Share / Footer --}}
                <div style="margin-top:30px; padding-top:20px; border-top:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <span style="color:#94a3b8; font-size:0.85rem;">
                        <i class="fas fa-tag"></i> {{ $notice->category ?? __('messages.general') }}
                    </span>
                    <span style="color:#94a3b8; font-size:0.85rem;">
                        <i class="fas fa-eye"></i> {{ __('messages.read') }}
                    </span>
                </div>

            </div>

            {{-- Back to list link --}}
            <div style="text-align:center; margin-top:30px;">
                <a href="{{ route('notices.index') }}" style="display:inline-flex; align-items:center; gap:8px; background:#e2e8f0; color:#1e293b; padding:10px 30px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">
                    <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_all_notices') }}
                </a>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Card hover effect */
    .notice-detail-card {
        transition: transform 0.2s;
    }
    .notice-detail-card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush