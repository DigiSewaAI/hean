@extends('layouts.public')

@section('title', __('messages.committee') . ' - HEAN')

@section('content')
<section style="padding-top:120px; padding-bottom:60px;">
    <div class="container">
        <div class="section-header">
            <h2>{{ __('messages.committee') }}</h2>
            <p>Meet our executive committee members.</p>
        </div>
        <div class="committee-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px,1fr)); gap:30px;">
            @forelse($members as $member)
            <div class="committee-card" style="background:#fff; border-radius:16px; padding:20px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.05);">
                <img src="{{ $member->image ? asset('storage/'.$member->image) : asset('images/avatar-placeholder.png') }}" alt="{{ $member->name }}" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:15px;">
                <h3>{{ $member->name }}</h3>
                <p style="color:#f97316; font-weight:600;">{{ $member->position }}</p>
                <div style="margin-top:10px;">
                    @if($member->facebook)<a href="{{ $member->facebook }}"><i class="fab fa-facebook"></i></a>@endif
                    @if($member->linkedin)<a href="{{ $member->linkedin }}"><i class="fab fa-linkedin"></i></a>@endif
                </div>
            </div>
            @empty
            <p>No committee members found.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection