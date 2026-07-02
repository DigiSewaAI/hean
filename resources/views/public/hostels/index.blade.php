@extends('layouts.public')

@section('title', __('messages.hostels') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:3rem; font-weight:800; margin-bottom:12px;">
            <i class="fas fa-hotel me-3"></i> @lang('messages.hostels')
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto;">
            {{ __('messages.hostels_hero_desc') }}
        </p>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<section style="padding:30px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:20px; text-align:center;">
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $hostels->total() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.stats_total_hostels') }}</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#22C55E;">{{ $hostels->pluck('district')->unique()->count() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.stats_districts') }}</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#8B5CF6;">{{ $hostels->total() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">{{ __('messages.stats_member_hostels') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== HOSTELS GRID ===== --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">

        {{-- Section Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; margin-bottom:30px;">
            <div>
                <h2 style="font-size:2rem; font-weight:700; color:#0f172a; margin:0;">
                    <i class="fas fa-list-ul" style="color:#0EA5E9; margin-right:10px;"></i> {{ __('messages.all_hostels') }}
                </h2>
                <p style="color:#64748b; margin-top:4px; font-size:0.95rem;">
                    {{ $hostels->total() }} {{ __('messages.hostels_found') }}
                </p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <span style="color:#64748b; font-size:0.85rem; font-weight:500;">
                    <i class="fas fa-sort"></i> {{ __('messages.sort_by') }}
                </span>
                <select style="padding:8px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.85rem; background:#fff; color:#1e293b; cursor:pointer;">
                    <option value="newest">{{ __('messages.sort_newest') }}</option>
                    <option value="oldest">{{ __('messages.sort_oldest') }}</option>
                    <option value="name">{{ __('messages.sort_name') }}</option>
                </select>
            </div>
        </div>

        {{-- Hostel Grid --}}
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:30px;">
            @forelse($hostels as $hostel)
            <div class="hostel-card" style="background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:transform 0.3s, box-shadow 0.3s; display:flex; flex-direction:column; border:1px solid #f1f5f9;">

                {{-- Image --}}
                <div class="hostel-img" style="height:200px; overflow:hidden; position:relative;">
                    <img src="{{ $hostel->image ? asset('storage/'.$hostel->image) : asset('images/hostel-placeholder.jpg') }}" 
                         alt="{{ $hostel->name_nepali }}" 
                         style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s;">
                    {{-- Featured Badge --}}
                    @if($hostel->featured)
                        <span style="position:absolute; top:12px; right:12px; background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:4px 14px; border-radius:50px; font-size:0.7rem; font-weight:700; box-shadow:0 2px 10px rgba(245,158,11,0.3);">
                            <i class="fas fa-star me-1"></i> {{ __('messages.featured') }}
                        </span>
                    @endif
                    {{-- Type Badge --}}
                    <span style="position:absolute; bottom:12px; left:12px; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); color:#fff; padding:4px 14px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                        {{ ucfirst($hostel->type ?? __('messages.general')) }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="hostel-body" style="padding:20px; flex:1; display:flex; flex-direction:column;">
                    <h3 style="font-size:1.15rem; font-weight:700; color:#0f172a; margin-bottom:4px; line-height:1.3;">
                        {{ $hostel->name_nepali }}
                    </h3>
                    @if($hostel->name_english)
                        <p style="font-size:0.8rem; color:#94a3b8; margin-bottom:6px;">{{ $hostel->name_english }}</p>
                    @endif
                    <div class="location" style="font-size:0.9rem; color:#64748b; display:flex; align-items:center; gap:6px; margin-bottom:8px;">
                        <i class="fas fa-map-marker-alt" style="color:#0EA5E9;"></i> 
                        {{ $hostel->district }}{{ $hostel->municipality ? ', '.$hostel->municipality : '' }}-{{ $hostel->ward }}
                    </div>
                    <div style="display:flex; gap:12px; font-size:0.8rem; color:#64748b; margin-bottom:12px; flex-wrap:wrap;">
                        @if($hostel->capacity)
                            <span><i class="fas fa-bed" style="color:#0EA5E9;"></i> {{ $hostel->capacity }} {{ __('messages.beds') }}</span>
                        @endif
                        @if($hostel->rooms)
                            <span><i class="fas fa-door-open" style="color:#0EA5E9;"></i> {{ $hostel->rooms }} {{ __('messages.rooms') }}</span>
                        @endif
                        @if($hostel->contact)
                            <span><i class="fas fa-phone" style="color:#0EA5E9;"></i> {{ $hostel->contact }}</span>
                        @endif
                    </div>
                    <div class="meta" style="display:flex; justify-content:space-between; align-items:center; margin-top:auto; padding-top:15px; border-top:1px solid #e2e8f0; font-size:0.85rem;">
                        <span style="color:#94a3b8; font-size:0.75rem;">
                            <i class="far fa-calendar-alt"></i> {{ $hostel->created_at->format('d M Y') }}
                        </span>
                        <a href="{{ route('hostels.show', $hostel) }}" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:6px 18px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.8rem; transition:0.3s; box-shadow:0 2px 10px rgba(14,165,233,0.3);">
                            <i class="fas fa-eye"></i> {{ __('messages.view') }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px; background:#f8fafc; border-radius:20px;">
                <i class="fas fa-hotel" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:15px;"></i>
                <p style="color:#94a3b8; font-size:1.1rem;">{{ __('messages.no_hostels_found') }}</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper" style="margin-top:40px; display:flex; justify-content:center;">
            {{ $hostels->links() }}
        </div>
    </div>
</section>

{{-- ===== QR CODE SECTION ===== --}}
<section style="padding:50px 0; background:#f8fafc;">
    <div class="container">
        <div style="text-align:center; padding:40px 30px; background:#fff; border-radius:16px; border:2px dashed #0EA5E9; max-width:600px; margin:0 auto;">
            <div style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 20px; border-radius:50px; font-size:0.85rem; font-weight:600; margin-bottom:15px;">
                <i class="fas fa-qrcode me-2"></i> {{ __('messages.qr_about_badge') }}
            </div>
            <h4 style="font-weight:700; color:#0f172a; margin-bottom:10px;">
                {{ __('messages.qr_about_heading') }}
            </h4>
            <p style="color:#64748b; font-size:0.95rem; max-width:400px; margin:0 auto 20px;">
                {{ __('messages.qr_about_desc') }}
            </p>
            <div style="display:inline-block; background:#fff; padding:15px; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
                <img src="{{ asset('images/qrcode.png') }}" alt="QR Code for Registration" style="width:180px; height:180px; display:block; margin:0 auto;">
            </div>
            <p style="color:#94a3b8; font-size:0.8rem; margin-top:12px;">
                <i class="fas fa-camera me-1"></i> {{ __('messages.qr_about_after') }}
            </p>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Hostel Card Hover Effects */
    .hostel-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
        border-color: #0EA5E9 !important;
    }

    .hostel-card:hover .hostel-img img {
        transform: scale(1.05);
    }

    .hostel-img img {
        transition: transform 0.4s ease;
    }

    /* Pagination Styling */
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

    /* Select dropdown */
    select:focus {
        outline: none;
        border-color: #0EA5E9 !important;
        box-shadow: 0 0 0 3px rgba(14,165,233,0.12);
    }
</style>
@endpush