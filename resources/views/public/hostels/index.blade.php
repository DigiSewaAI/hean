@extends('layouts.public')

@section('title', __('messages.hostels') . ' - HEAN')

@section('content')
<section class="hostels-section" style="padding-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2>{{ __('messages.hostels') }}</h2>
            <p>Explore all hostels registered with HEAN.</p>
        </div>
        <div class="hostel-grid">
            @forelse($hostels as $hostel)
            <div class="hostel-card">
                <div class="hostel-img">
                    <img src="{{ $hostel->image ? asset('storage/'.$hostel->image) : asset('images/hostel-placeholder.jpg') }}" alt="{{ $hostel->name_nepali }}">
                </div>
                <div class="hostel-body">
                    <h3>{{ $hostel->name_nepali }}</h3>
                    <div class="location"><i class="fas fa-map-marker-alt"></i> {{ $hostel->district }}-{{ $hostel->ward }}</div>
                    <div class="meta">
                        <span class="contact"><i class="fas fa-phone"></i> {{ $hostel->contact }}</span>
                        <a href="{{ route('hostels.show', $hostel) }}" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
            @empty
            <p>No hostels found.</p>
            @endforelse
        </div>
        <div class="pagination-wrapper">
            {{ $hostels->links() }}
        </div>
    </div>
</section>
@endsection