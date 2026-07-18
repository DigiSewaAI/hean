@extends('layouts.public')

@section('title', __('messages.gallery') . ' - HEAN')

@section('content')

{{-- HERO BANNER --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:3rem; font-weight:800; margin-bottom:12px;">
            <i class="fas fa-images me-3"></i> @lang('messages.gallery')
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto;">
            {{ __('messages.gallery_hero_desc') }}
        </p>
    </div>
</section>

{{-- STATS --}}
<section style="padding:30px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:20px; text-align:center;">
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $albums->total() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('Albums') }}</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#22C55E;">
                    {{ $albums->sum('images_count') }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('Total Photos') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ALBUMS GRID --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:30px;">
            @forelse($albums as $album)
                <a href="{{ route('gallery.show', $album) }}" style="text-decoration:none; color:inherit; display:block;">
                    <div style="border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.06); transition:transform 0.3s, box-shadow 0.3s; background:#fff;">
                        <div style="position:relative; height:200px; background:#e2e8f0;">
                            <img src="{{ $album->cover_url }}" alt="{{ $album->name }}" style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s;">
                            <span style="position:absolute; bottom:10px; right:10px; background:rgba(0,0,0,0.7); color:#fff; padding:4px 14px; border-radius:20px; font-size:0.8rem; font-weight:500;">
                                {{ $album->images_count }} {{ __('photos') }}
                            </span>
                        </div>
                        <div style="padding:16px;">
                            <h3 style="font-size:1.2rem; font-weight:700; margin:0 0 4px; color:#0f172a;">{{ $album->name }}</h3>
                            @if($album->event_date)
                                <small style="color:#64748b;"><i class="far fa-calendar-alt"></i> {{ $album->event_date->format('M d, Y') }}</small>
                            @endif
                            @if($album->description)
                                <p style="color:#64748b; font-size:0.9rem; margin-top:8px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $album->description }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column:1/-1; text-align:center; padding:60px 20px; background:#f8fafc; border-radius:20px;">
                    <i class="fas fa-images" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:15px;"></i>
                    <p style="color:#94a3b8; font-size:1.1rem;">{{ __('No albums found.') }}</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="margin-top:40px; display:flex; justify-content:center;">
            {{ $albums->links() }}
        </div>
    </div>
</section>

@endsection