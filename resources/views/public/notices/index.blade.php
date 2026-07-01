@extends('layouts.public')

@section('title', __('messages.notices') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:3rem; font-weight:800; margin-bottom:12px;">
            <i class="fas fa-bullhorn me-3"></i> @lang('messages.notices')
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto;">
            Stay updated with the latest notices and events from HEAN.
        </p>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<section style="padding:30px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:20px; text-align:center;">
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $notices->total() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">कुल सूचनाहरू</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#22C55E;">
                    {{ $notices->pluck('category')->filter()->unique()->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">विभागहरू</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#8B5CF6;">
                    {{ $notices->where('is_featured', true)->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">विशेष सूचना</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== NOTICES LIST ===== --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">

        {{-- Section Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; margin-bottom:30px;">
            <div>
                <h2 style="font-size:2rem; font-weight:700; color:#0f172a; margin:0;">
                    <i class="fas fa-list-ul" style="color:#0EA5E9; margin-right:10px;"></i> सबै सूचनाहरू
                </h2>
                <p style="color:#64748b; margin-top:4px; font-size:0.95rem;">
                    {{ $notices->total() }} सूचनाहरू फेला पर्यो
                </p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <span style="color:#64748b; font-size:0.85rem; font-weight:500;">
                    <i class="fas fa-filter"></i> फिल्टर:
                </span>
                <select style="padding:8px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.85rem; background:#fff; color:#1e293b; cursor:pointer;">
                    <option>सबै</option>
                    <option>घटना</option>
                    <option>समाचार</option>
                    <option>कार्यशाला</option>
                </select>
            </div>
        </div>

        {{-- Notices List --}}
        <div style="display:grid; gap:20px;">
            @forelse($notices as $notice)
            <div class="notice-item" style="display:flex; align-items:center; gap:20px; padding:20px 24px; background:#f8fafc; border-radius:16px; transition:0.3s; border:1px solid #e2e8f0; flex-wrap:wrap;">

                {{-- Date Block --}}
                <div style="min-width:70px; text-align:center; background:#fff; padding:12px 10px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.04); border:1px solid #e2e8f0;">
                    <div style="font-size:1.6rem; font-weight:800; color:#0EA5E9; line-height:1.2;">{{ $notice->date->format('d') }}</div>
                    <div style="font-size:0.7rem; text-transform:uppercase; color:#64748b; font-weight:600;">{{ $notice->date->format('M') }}</div>
                    <div style="font-size:0.6rem; color:#94a3b8; font-weight:500;">{{ $notice->date->format('Y') }}</div>
                </div>

                {{-- Content --}}
                <div style="flex:1; min-width:200px;">
                    <h4 style="font-weight:700; color:#0f172a; margin-bottom:6px; font-size:1.1rem;">
                        {{ $notice->title }}
                        @if($notice->is_featured)
                            <span style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:2px 12px; border-radius:50px; font-size:0.65rem; font-weight:600; margin-left:8px; display:inline-block;">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @endif
                    </h4>
                    <p style="font-size:0.95rem; color:#64748b; margin:0; line-height:1.6;">
                        {{ Str::limit($notice->content, 120) }}
                    </p>
                </div>

                {{-- Category Badge + Action --}}
                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <span style="background:rgba(14,165,233,0.1); color:#0EA5E9; padding:6px 16px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                        {{ $notice->category ?? 'General' }}
                    </span>
                    <a href="{{ route('notices.show', $notice) }}" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:6px 18px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.8rem; transition:0.3s; box-shadow:0 2px 10px rgba(14,165,233,0.3);">
                        <i class="fas fa-arrow-right"></i> View
                    </a>
                </div>

            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px; background:#f8fafc; border-radius:20px;">
                <i class="fas fa-bullhorn" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:15px;"></i>
                <p style="color:#94a3b8; font-size:1.1rem;">कुनै सूचना फेला परेन।</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper" style="margin-top:40px; display:flex; justify-content:center;">
            {{ $notices->links() }}
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Notice Item Hover */
    .notice-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.06) !important;
        border-color: #0EA5E9 !important;
        background: #f1f5f9 !important;
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