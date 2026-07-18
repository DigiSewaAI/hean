@extends('layouts.public')

@section('title', __('messages.gallery') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
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

{{-- ===== STATS BAR ===== --}}
<section style="padding:30px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:20px; text-align:center;">
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $images->total() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.gallery_stats_total') }}</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#22C55E;">
                    {{ $images->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.gallery_stats_current') }}</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#8B5CF6;">
                    {{ $images->total() > 0 ? ceil($images->total() / 12) : 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.gallery_stats_pages') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== GALLERY GRID GROUPED BY EVENT ===== --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">

        {{-- Section Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; margin-bottom:30px;">
            <div>
                <h2 style="font-size:2rem; font-weight:700; color:#0f172a; margin:0;">
                    <i class="fas fa-images" style="color:#0EA5E9; margin-right:10px;"></i> {{ __('messages.gallery_section_title') }}
                </h2>
                <p style="color:#64748b; margin-top:4px; font-size:0.95rem;">
                    {{ __('messages.gallery_found', ['count' => $images->total()]) }}
                </p>
            </div>
        </div>

        {{-- Grouped Gallery --}}
        @php
            $grouped = $images->groupBy('event_name');
            $groupCount = 0;
        @endphp

        @forelse($grouped as $eventName => $eventImages)
            @php
                $groupIndex = $loop->index;
                $groupImages = [];
                foreach ($eventImages as $image) {
                    $groupImages[] = [
                        'url' => Storage::url($image->image),
                        'title' => $image->title ?? $eventName ?? __('messages.gallery_image'),
                        'alt' => $image->title ?? $eventName ?? __('messages.gallery')
                    ];
                }
            @endphp

            <div class="event-group" style="margin-bottom:50px;">
                <h3 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin-bottom:20px; border-left:4px solid #0EA5E9; padding-left:15px; letter-spacing:0.02em;">
                    {{ $eventName ?? __('messages.uncategorized') }}
                    <span style="font-size:0.9rem; font-weight:400; color:#94a3b8; margin-left:10px;">({{ $eventImages->count() }} {{ __('messages.photos') }})</span>
                </h3>

                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:20px;">
                    @foreach($eventImages as $image)
                        @php
                            // Find index within this group
                            $idxInGroup = $loop->index;
                        @endphp
                        <div class="gallery-item" 
                             style="border-radius:16px; overflow:hidden; position:relative; aspect-ratio:1/1; cursor:pointer; box-shadow:0 4px 15px rgba(0,0,0,0.04); transition:transform 0.3s, box-shadow 0.3s;"
                             onclick="openGroupLightbox({{ $groupIndex }}, {{ $idxInGroup }})">
                            
                            <img src="{{ Storage::url($image->image) }}" 
                                 alt="{{ $image->title ?? $eventName ?? __('messages.gallery') }}" 
                                 style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s;">
                            
                            {{-- Overlay --}}
                            <div class="overlay" style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(0,0,0,0.6) 0%, transparent 60%); opacity:0; transition:opacity 0.3s; display:flex; align-items:flex-end; justify-content:center; flex-direction:column; padding:20px; color:#fff;">
                                <div style="width:100%; text-align:center;">
                                    <i class="fas fa-search-plus" style="font-size:1.5rem; margin-bottom:6px; display:block;"></i>
                                    @if($image->title)
                                        <span style="font-size:0.95rem; font-weight:600; text-shadow:0 2px 10px rgba(0,0,0,0.5);">{{ $image->title }}</span>
                                    @elseif($eventName)
                                        <span style="font-size:0.95rem; font-weight:600; text-shadow:0 2px 10px rgba(0,0,0,0.5);">{{ $eventName }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px; background:#f8fafc; border-radius:20px;">
                <i class="fas fa-images" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:15px;"></i>
                <p style="color:#94a3b8; font-size:1.1rem;">{{ __('messages.gallery_empty') }}</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="pagination-wrapper" style="margin-top:40px; display:flex; justify-content:center;">
            {{ $images->links() }}
        </div>
    </div>
</section>

{{-- ===== LIGHTBOX (PER GROUP) ===== --}}
<div id="lightbox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center; flex-direction:column; padding:40px 20px;">
    
    {{-- Close Button --}}
    <button onclick="closeLightbox()" style="position:absolute; top:20px; right:30px; background:none; border:none; color:#fff; font-size:2.5rem; cursor:pointer; transition:0.3s; z-index:10;">
        <i class="fas fa-times"></i>
    </button>

    {{-- Image --}}
    <img id="lightbox-img" src="" alt="Lightbox" style="max-width:90%; max-height:75vh; border-radius:12px; box-shadow:0 8px 40px rgba(0,0,0,0.4); object-fit:contain;">

    {{-- Title --}}
    <p id="lightbox-title" style="color:#fff; font-size:1.1rem; margin-top:16px; font-weight:500; text-align:center; max-width:600px;"></p>

    {{-- Navigation --}}
    <div style="position:absolute; bottom:40px; left:50%; transform:translateX(-50%); display:flex; gap:20px; align-items:center;">
        <button onclick="prevImage()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#fff; padding:10px 18px; border-radius:50%; cursor:pointer; transition:0.3s; font-size:1.2rem;">
            <i class="fas fa-chevron-left"></i>
        </button>
        <span id="lightbox-counter" style="color:#94a3b8; font-size:0.9rem;">1 / 1</span>
        <button onclick="nextImage()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#fff; padding:10px 18px; border-radius:50%; cursor:pointer; transition:0.3s; font-size:1.2rem;">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>

@endsection

@push('styles')
<style>
    .gallery-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .gallery-item:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    }
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    .gallery-item:hover .overlay {
        opacity: 1 !important;
    }
    .gallery-item img {
        transition: transform 0.4s ease;
    }
    #lightbox {
        animation: fadeIn 0.25s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    #lightbox button:hover {
        background: rgba(255,255,255,0.2) !important;
        transform: scale(1.1);
    }
    .pagination-wrapper .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination-wrapper .pagination .page-item .page-link {
        padding: 8px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        transition: 0.3s;
        font-weight: 500;
        font-size: 0.9rem;
        background: #fff;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover {
        background: #f1f5f9;
        border-color: #0EA5E9;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0EA5E9, #3B82F6);
        border-color: #0EA5E9;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .event-group {
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 30px;
    }
    .event-group:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .event-group h3 {
        font-family: 'Noto Sans Devanagari', 'Inter', sans-serif;
    }
</style>
@endpush

@push('scripts')
<script>
    // ===== PER-GROUP LIGHTBOX DATA =====
    const groups = [];

    @foreach($grouped as $eventName => $eventImages)
        const groupData = [];
        @foreach($eventImages as $image)
            groupData.push({
                url: "{{ Storage::url($image->image) }}",
                title: "{{ addslashes($image->title ?? $eventName ?? __('messages.gallery_image')) }}"
            });
        @endforeach
        groups.push(groupData);
    @endforeach

    let currentGroup = 0;
    let currentIndex = 0;

    function openGroupLightbox(groupIdx, idx) {
        currentGroup = groupIdx;
        currentIndex = idx;
        updateLightbox();
        document.getElementById('lightbox').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function updateLightbox() {
        const img = document.getElementById('lightbox-img');
        const title = document.getElementById('lightbox-title');
        const counter = document.getElementById('lightbox-counter');
        const group = groups[currentGroup];
        if (group && group[currentIndex]) {
            img.src = group[currentIndex].url;
            title.textContent = group[currentIndex].title;
            counter.textContent = (currentIndex + 1) + ' / ' + group.length;
        }
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function prevImage() {
        const group = groups[currentGroup];
        if (!group) return;
        if (currentIndex > 0) {
            currentIndex--;
            updateLightbox();
        } else {
            // Loop to last if you want, or just stay
        }
    }

    function nextImage() {
        const group = groups[currentGroup];
        if (!group) return;
        if (currentIndex < group.length - 1) {
            currentIndex++;
            updateLightbox();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
    });

    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });
</script>
@endpush