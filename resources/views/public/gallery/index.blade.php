@extends('layouts.public')

@section('title', __('messages.gallery') . ' - HEAN')

@section('content')
<section class="gallery-section" style="padding-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2>{{ __('messages.gallery') }}</h2>
            <p>Explore moments from our events and activities.</p>
        </div>
        <div class="gallery-grid">
            @forelse($images as $image)
            <div class="gallery-item">
                <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->title ?? 'Gallery' }}">
                <div class="overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            @empty
            <p>No images found.</p>
            @endforelse
        </div>
        <div class="pagination-wrapper">
            {{ $images->links() }}
        </div>
    </div>
</section>
@endsection