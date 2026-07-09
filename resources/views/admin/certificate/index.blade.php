@extends('layouts.admin')

@section('title', __('messages.admin_certificate_title'))

@section('content')

{{-- ===== STATS BAR ===== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#8B5CF6; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-certificate" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $totalCertificates ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_certificates') }}</div>
        </div>
    </div>
</div>

{{-- ===== TOOLBAR: SEARCH + FILTERS ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="{{ route('admin.certificate.index') }}" method="GET" id="filterForm">
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#8B5CF6;"></i> {{ __('messages.search') }}
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="प्रमाणपत्र नं., होस्टल नाम, दर्ता नम्बर..." 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            {{-- Filter: Registration --}}
            <div style="flex:1.5; min-width:180px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.registration') }}</label>
                <select name="registration_id" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all_registrations') }}</option>
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ request('registration_id') == $reg->id ? 'selected' : '' }}>
                            {{ $reg->registration_number }} - {{ $reg->hostel_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sort --}}
            <div style="flex:1; min-width:130px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.sort_by') }}</label>
                <select name="sort" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>{{ __('messages.sort_latest') }}</option>
                    <option value="oldest" {{ request('sort')=='oldest'?'selected':'' }}>{{ __('messages.sort_oldest') }}</option>
                    <option value="cert_number_asc" {{ request('sort')=='cert_number_asc'?'selected':'' }}>{{ __('messages.sort_cert_number_asc') }}</option>
                    <option value="cert_number_desc" {{ request('sort')=='cert_number_desc'?'selected':'' }}>{{ __('messages.sort_cert_number_desc') }}</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <button type="submit" style="background:linear-gradient(135deg, #8B5CF6, #7C3AED); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(139,92,246,0.25);">
                    <i class="fas fa-filter"></i> {{ __('messages.filter') }}
                </button>
                <a href="{{ route('admin.certificate.index') }}" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-undo"></i> {{ __('messages.reset') }}
                </a>
                <button type="button" onclick="document.getElementById('advancedFilters').style.display = (document.getElementById('advancedFilters').style.display === 'none' ? 'block' : 'none')" 
                        style="background:#f1f5f9; color:#1e293b; border:1px solid #e2e8f0; padding:10px 16px; border-radius:50px; font-weight:500; font-size:0.85rem; cursor:pointer; transition:0.2s;">
                    <i class="fas fa-sliders-h"></i> {{ __('messages.advanced') }}
                </button>
            </div>
        </div>

        {{-- Advanced Filters (collapsible) --}}
        <div id="advancedFilters" style="display: {{ request()->hasAny(['date_from', 'date_to']) ? 'block' : 'none' }}; margin-top:16px; padding-top:16px; border-top:1px solid #e2e8f0;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_from') }}</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_to') }}</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ===== GENERATE CERTIFICATE FORM ===== --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:24px;">
    <form action="{{ route('admin.certificate.generate') }}" method="POST">
        @csrf
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-id-card" style="color:#8B5CF6;"></i> {{ __('messages.registration_id') }}
                </label>
                <select name="registration_id" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;" required>
                    <option value="">{{ __('messages.select_registration') }}</option>
                    @foreach(\App\Models\Registration::with('hostel')->whereIn('status', ['approved', 'active'])->get() as $reg)
                        <option value="{{ $reg->id }}">
                            {{ $reg->registration_number ?? '#'.$reg->id }} – {{ $reg->hostel->name ?? __('messages.not_available') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex:1; min-width:150px;">
                <button type="submit" style="width:100%; background:linear-gradient(135deg, #8B5CF6, #7C3AED); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(139,92,246,0.25);">
                    <i class="fas fa-certificate me-2"></i> {{ __('messages.generate_certificate') }}
                </button>
            </div>
        </div>
    </form>
</div>

{{-- ===== GENERATED CERTIFICATES LIST ===== --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #8B5CF6, #7C3AED); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-list-ul"></i>
        <span>{{ __('messages.generated_certificates') }}</span>
        <span style="margin-left:auto; background:rgba(255,255,255,0.2); padding:2px 14px; border-radius:50px; font-size:0.8rem;">
            {{ $certificates->total() ?? 0 }}
        </span>
    </div>

    <div style="padding:16px; overflow-x:auto;">
        @if($certificates->count() > 0)
            <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
                <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                    <tr>
                        <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.certificate_number') }}</th>
                        <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.registration') }}</th>
                        <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.hostel') }}</th>
                        <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.issued_date') }}</th>
                        <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $cert)
                    <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                        <td style="padding:12px 16px; font-weight:600; color:#0f172a;">
                            <span style="background:#eef2ff; color:#4338ca; padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600;">
                                {{ $cert->certificate_number }}
                            </span>
                        </td>
                        <td style="padding:12px 16px; color:#1e293b;">
                            {{ $cert->registration->registration_number ?? '#'.$cert->registration_id }}
                        </td>
                        <td style="padding:12px 16px; color:#1e293b;">
                            {{ $cert->registration->hostel->name ?? __('messages.not_available') }}
                        </td>
                        <td style="padding:12px 16px; color:#475569;">
                            {{ $cert->issued_date ? \Carbon\Carbon::parse($cert->issued_date)->format('Y-m-d') : __('messages.not_available') }}
                        </td>
                        <td style="padding:12px 16px; text-align:center;">
                            <div style="display:flex; justify-content:center; gap:8px;">
                                <a href="{{ route('admin.certificates.download', $cert->id) }}" 
                                   style="display:inline-block; padding:6px 14px; background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600; box-shadow:0 2px 10px rgba(34,197,94,0.25); transition:0.3s;">
                                    <i class="fas fa-download me-1"></i> {{ __('messages.download') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                            <i class="fas fa-file-alt" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                            {{ __('messages.no_certificates') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top:16px;">
                {{ $certificates->appends(request()->query())->links() }}
            </div>
        @else
            <div style="text-align:center; padding:40px 20px;">
                <i class="fas fa-file-alt" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:12px;"></i>
                <p style="color:#94a3b8; font-size:0.95rem; margin:0;">
                    {{ __('messages.no_certificates') }}
                </p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    tbody tr:hover {
        background: #f8fafc;
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
        padding: 8px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        transition: 0.2s;
        font-weight: 500;
        font-size: 0.9rem;
        background: #fff;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover {
        background: #f1f5f9;
        border-color: #8B5CF6;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        border-color: #8B5CF6;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush