@extends('layouts.public')

@section('title', __('messages.hostels') . ' - HEAN')

@section('content')
<section class="hostels-section" style="padding-top:120px; padding-bottom:60px; background:#f8fafc;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:50px;">
            <h2 style="font-size:2.5rem; font-weight:700; color:#0f172a;">{{ __('messages.hostels') }}</h2>
            <p style="color:#64748b; margin-top:8px;">Explore all hostels registered with HEAN.</p>
        </div>

        <div class="hostel-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:30px;">
            @forelse($hostels as $hostel)
            <div class="hostel-card" style="background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:transform 0.3s, box-shadow 0.3s; display:flex; flex-direction:column;">
                <div class="hostel-img" style="height:200px; overflow:hidden;">
                    <img src="{{ $hostel->image ? asset('storage/'.$hostel->image) : asset('images/hostel-placeholder.jpg') }}" alt="{{ $hostel->name_nepali }}" style="width:100%; height:100%; object-fit:cover; transition:0.4s;">
                </div>
                <div class="hostel-body" style="padding:20px; flex:1; display:flex; flex-direction:column;">
                    <h3 style="font-size:1.2rem; font-weight:700; color:#0f172a; margin-bottom:4px;">{{ $hostel->name_nepali }}</h3>
                    <div class="location" style="font-size:0.9rem; color:#64748b; display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <i class="fas fa-map-marker-alt" style="color:#0EA5E9;"></i> {{ $hostel->district }}-{{ $hostel->ward }}
                    </div>
                    <div class="meta" style="display:flex; justify-content:space-between; align-items:center; margin-top:auto; padding-top:15px; border-top:1px solid #e2e8f0; font-size:0.85rem;">
                        <span class="contact" style="color:#0EA5E9; font-weight:600;"><i class="fas fa-phone"></i> {{ $hostel->contact }}</span>
                        <a href="{{ route('hostels.show', $hostel) }}" style="display:inline-flex; align-items:center; gap:6px; background:#0EA5E9; color:#fff; padding:6px 18px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.8rem; transition:0.3s; box-shadow:0 2px 10px rgba(14,165,233,0.3);">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p style="grid-column:1/-1; text-align:center; padding:40px; color:#94a3b8;">No hostels found.</p>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="margin-top:40px; display:flex; justify-content:center;">
            {{ $hostels->links() }}
        </div>
    </div>
</section>
@endsection