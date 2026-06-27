@extends('layouts.public')

@section('title', __('messages.notices') . ' - HEAN')

@section('content')
<section class="notices-section" style="padding-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2>{{ __('messages.notices') }}</h2>
            <p>Stay updated with the latest notices and events.</p>
        </div>
        <div class="notice-list">
            @forelse($notices as $notice)
            <div class="notice-item">
                <div class="date">
                    <div class="day">{{ $notice->date->format('d') }}</div>
                    <div class="month">{{ $notice->date->format('M') }}</div>
                </div>
                <div class="content">
                    <h4>{{ $notice->title }}</h4>
                    <p>{{ Str::limit($notice->content, 100) }}</p>
                </div>
                <span class="badge">{{ $notice->category ?? 'General' }}</span>
            </div>
            @empty
            <p>No notices found.</p>
            @endforelse
        </div>
        <div class="pagination-wrapper">
            {{ $notices->links() }}
        </div>
    </div>
</section>
@endsection