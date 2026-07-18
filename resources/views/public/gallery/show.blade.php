@extends('layouts.public')

@section('title', $album->name . ' - HEAN')

@section('content')

<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:2.5rem; font-weight:800; margin-bottom:8px;">{{ $album->name }}</h1>
        @if($album->event_date)
            <p style="font-size:1rem; opacity:0.9;"><i class="far fa-calendar-alt"></i> {{ $album->event_date->format('F d, Y') }}</p>
        @endif
        @if($album->description)
            <p style="max-width:600px; margin:12px auto 0; opacity:0.9;">{{ $album->description }}</p>
        @endif
        <p style="margin-top:20px;"><span style="background:rgba(255,255,255,0.2); padding:6px 20px; border-radius:30px;">{{ $images->count() }} {{ __('photos') }}</span></p>
    </div>
</section>

<section style="padding:60px 0; background:#ffffff;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:20px;">
            @forelse($images as $image)
                <div class="gallery-item" style="border-radius:16px; overflow:hidden; position:relative; aspect-ratio:1/1; cursor:pointer; box-shadow:0 4px 15px rgba(0,0,0,0.04); transition:transform 0.3s, box-shadow 0.3s;" onclick="openLightbox({{ $loop->index }})">
                    <img src="{{ Storage::disk('cloud')->url($image->image) }}" alt="{{ $image->title ?? $album->name }}" style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s;">
                    <div class="overlay" style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(0,0,0,0.6) 0%, transparent 60%); opacity:0; transition:opacity 0.3s; display:flex; align-items:flex-end; justify-content:center; padding:20px;">
                        <div style="text-align:center; color:#fff; width:100%;">
                            <i class="fas fa-search-plus" style="font-size:1.5rem; display:block; margin-bottom:6px;"></i>
                            @if($image->title)
                                <span style="font-size:0.95rem; font-weight:600; text-shadow:0 2px 10px rgba(0,0,0,0.5);">{{ $image->title }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p style="grid-column:1/-1; text-align:center; padding:40px; color:#94a3b8;">{{ __('No published images in this album.') }}</p>
            @endforelse
        </div>
    </div>
</section>

{{-- LIGHTBOX --}}
<div id="lightbox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center; flex-direction:column; padding:40px 20px;">
    <button onclick="closeLightbox()" style="position:absolute; top:20px; right:30px; background:none; border:none; color:#fff; font-size:2.5rem; cursor:pointer; z-index:10;"><i class="fas fa-times"></i></button>
    <img id="lightbox-img" src="" alt="Lightbox" style="max-width:90%; max-height:75vh; border-radius:12px; box-shadow:0 8px 40px rgba(0,0,0,0.4); object-fit:contain;">
    <p id="lightbox-title" style="color:#fff; font-size:1.1rem; margin-top:16px; font-weight:500; text-align:center; max-width:600px;"></p>
    <div style="position:absolute; bottom:40px; left:50%; transform:translateX(-50%); display:flex; gap:20px; align-items:center;">
        <button onclick="prevImage()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#fff; padding:10px 18px; border-radius:50%; cursor:pointer; transition:0.3s; font-size:1.2rem;"><i class="fas fa-chevron-left"></i></button>
        <span id="lightbox-counter" style="color:#94a3b8; font-size:0.9rem;">1 / {{ $images->count() }}</span>
        <button onclick="nextImage()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#fff; padding:10px 18px; border-radius:50%; cursor:pointer; transition:0.3s; font-size:1.2rem;"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

@endsection

@push('styles')
<style>
    .gallery-item:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important; }
    .gallery-item:hover img { transform: scale(1.05); }
    .gallery-item:hover .overlay { opacity: 1 !important; }
    .gallery-item img { transition: transform 0.4s ease; }
    #lightbox { animation: fadeIn 0.25s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    #lightbox button:hover { background: rgba(255,255,255,0.2) !important; transform: scale(1.1); }
</style>
@endpush

@push('scripts')
<script>
    const images = @json($images->map(function($img) {
        return [
            'url' => Storage::disk('cloud')->url($img->image),
            'title' => $img->title ?? '{{ $album->name }}'
        ];
    }));

    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        document.getElementById('lightbox').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function updateLightbox() {
        const img = document.getElementById('lightbox-img');
        const title = document.getElementById('lightbox-title');
        const counter = document.getElementById('lightbox-counter');
        if (images[currentIndex]) {
            img.src = images[currentIndex].url;
            title.textContent = images[currentIndex].title;
            counter.textContent = (currentIndex + 1) + ' / ' + images.length;
        }
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function prevImage() {
        if (currentIndex > 0) { currentIndex--; updateLightbox(); }
    }

    function nextImage() {
        if (currentIndex < images.length - 1) { currentIndex++; updateLightbox(); }
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