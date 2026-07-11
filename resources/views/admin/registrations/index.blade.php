@extends('layouts.admin')

@section('title', __('messages.admin_registrations_title') . ' - HEAN Admin')

@section('content')

{{-- ===== STATS BAR ===== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#0EA5E9; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-file-alt" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $totalRegistrations ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_registrations') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#F59E0B; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-clock" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $pendingCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_pending') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#22C55E; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-check-circle" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $approvedCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_approved') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#EF4444; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-times-circle" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $rejectedCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_rejected') }}</div>
        </div>
    </div>
</div>

{{-- ===== TOOLBAR: SEARCH + FILTERS + ACTIONS ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="{{ route('admin.registrations.index') }}" method="GET" id="filterForm">
        {{-- Basic Search & Quick Filters --}}
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#0EA5E9;"></i> {{ __('messages.search') }}
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="होस्टल नाम, दर्ता नम्बर, स्थानीय दर्ता, PAN..." 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            {{-- Filter: Status --}}
            <div style="flex:1; min-width:140px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.status') }}</label>
                <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>{{ __('messages.status_pending') }}</option>
                    <option value="approved" {{ request('status')=='approved'?'selected':'' }}>{{ __('messages.status_approved') }}</option>
                    <option value="awaiting_payment" {{ request('status')=='awaiting_payment'?'selected':'' }}>{{ __('messages.status_awaiting_payment') }}</option>
                    <option value="active" {{ request('status')=='active'?'selected':'' }}>{{ __('messages.status_active') }}</option>
                    <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>{{ __('messages.status_rejected') }}</option>
                    <option value="duplicate" {{ request('status')=='duplicate'?'selected':'' }}>{{ __('messages.status_duplicate') }}</option>
                </select>
            </div>

            {{-- Filter: Source --}}
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.source') }}</label>
                <select name="source" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="public" {{ request('source')=='public'?'selected':'' }}>{{ __('messages.source_public') }}</option>
                    <option value="admin" {{ request('source')=='admin'?'selected':'' }}>{{ __('messages.source_admin') }}</option>
                    <option value="import" {{ request('source')=='import'?'selected':'' }}>{{ __('messages.source_import') }}</option>
                    <option value="renewal" {{ request('source')=='renewal'?'selected':'' }}>{{ __('messages.source_renewal') }}</option>
                </select>
            </div>

            {{-- Sort --}}
            <div style="flex:1; min-width:130px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.sort_by') }}</label>
                <select name="sort" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>{{ __('messages.sort_latest') }}</option>
                    <option value="oldest" {{ request('sort')=='oldest'?'selected':'' }}>{{ __('messages.sort_oldest') }}</option>
                    <option value="reg_number_asc" {{ request('sort')=='reg_number_asc'?'selected':'' }}>{{ __('messages.sort_reg_number_asc') }}</option>
                    <option value="reg_number_desc" {{ request('sort')=='reg_number_desc'?'selected':'' }}>{{ __('messages.sort_reg_number_desc') }}</option>
                    <option value="status_asc" {{ request('sort')=='status_asc'?'selected':'' }}>{{ __('messages.sort_status_asc') }}</option>
                    <option value="status_desc" {{ request('sort')=='status_desc'?'selected':'' }}>{{ __('messages.sort_status_desc') }}</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
    <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.25);">
        <i class="fas fa-filter"></i> {{ __('messages.filter') }}
    </button>
    <a href="{{ route('admin.registrations.index') }}" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
        <i class="fas fa-undo"></i> {{ __('messages.reset') }}
    </a>
    <button type="button" onclick="document.getElementById('advancedFilters').style.display = (document.getElementById('advancedFilters').style.display === 'none' ? 'block' : 'none')" 
            style="background:#f1f5f9; color:#1e293b; border:1px solid #e2e8f0; padding:10px 16px; border-radius:50px; font-weight:500; font-size:0.85rem; cursor:pointer; transition:0.2s;">
        <i class="fas fa-sliders-h"></i> {{ __('messages.advanced') }}
    </button>
    <a href="{{ route('admin.registrations.export', request()->query()) }}" 
       style="display:inline-flex; align-items:center; gap:6px; background:#22C55E; color:#fff; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; margin-left:4px;">
        <i class="fas fa-file-excel"></i> {{ __('messages.export_excel') }}
    </a>
</div>
        {{-- Advanced Filters (collapsible) --}}
        <div id="advancedFilters" style="display: {{ request()->hasAny(['local_reg_number', 'district', 'date_from', 'date_to']) ? 'block' : 'none' }}; margin-top:16px; padding-top:16px; border-top:1px solid #e2e8f0;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:12px;">
                {{-- Local Registration Number --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">स्थानीय दर्ता नम्बर</label>
                    <input type="text" name="local_reg_number" value="{{ request('local_reg_number') }}" placeholder="KMC-W31-2082-..." 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- District Dropdown --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.district') }}</label>
                    <select name="district" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach($districts as $dist)
                            <option value="{{ $dist }}" {{ request('district')==$dist?'selected':'' }}>{{ $dist }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Date From --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_from') }}</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- Date To --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.date_to') }}</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ===== NEW REGISTRATION BUTTON ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
    <div style="font-size:0.9rem; color:#64748b;">
        <i class="fas fa-info-circle"></i> 
        {{ __('messages.showing_registrations', ['total' => $registrations->total(), 'from' => $registrations->firstItem() ?? 0, 'to' => $registrations->lastItem() ?? 0]) }}
    </div>
    <a href="{{ route('admin.registrations.create') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> {{ __('messages.new_registration') }}
    </a>
</div>

{{-- ===== TABLE ===== --}}
<div style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <tr>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">दर्ता नम्बर</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">स्थानीय दर्ता</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">पुरानो दर्ता नम्बर</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.hostel') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.district') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.source') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.status') }}</th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
            @php
                // Determine actual status for display
                $displayStatus = $reg->status;
                if ($reg->status === 'approved') {
                    $hasInvoice = $reg->invoices->isNotEmpty();
                    if ($hasInvoice) {
                        $latestInvoice = $reg->invoices->sortByDesc('id')->first();
                        if ($latestInvoice && $latestInvoice->status !== 'paid') {
                            $displayStatus = 'awaiting_payment';
                        }
                    }
                }
                $statusColorMap = [
                    'pending'          => ['bg' => '#e2e8f0', 'text' => '#475569'],
                    'approved'         => ['bg' => '#dcfce7', 'text' => '#166534'],
                    'awaiting_payment' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'active'           => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                    'expired'          => ['bg' => '#f1f5f9', 'text' => '#64748b'],
                    'rejected'         => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                    'duplicate'        => ['bg' => '#fce4ec', 'text' => '#880e4f'],
                    'inspection'       => ['bg' => '#fef3c7', 'text' => '#92400e'],
                ];
                $colors = $statusColorMap[$displayStatus] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
            @endphp
            <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                <td style="padding:12px 16px; font-weight:600; color:#0f172a;">
                    @if($reg->hostel)
                        <a href="{{ route('admin.hostels.show', $reg->hostel) }}" style="color:#0EA5E9; text-decoration:none; font-weight:600;">
                            {{ $reg->hostel->registration_number }}
                        </a>
                    @else
                        {{ $reg->registration_number ?? 'N/A' }}
                    @endif
                </td>
                                <td style="padding:12px 16px; font-size:0.85rem; color:#475569;">
                    {{ $reg->local_registration_number ?? '—' }}
                </td>
                <td style="padding:12px 16px; font-size:0.85rem; color:#475569;">
                    {{ $reg->old_registration_number ?? '—' }}
                </td>
                                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">
                    {{ $reg->hostel_name ?? 'N/A' }}
                    @if($reg->hostel_name_english && $reg->hostel_name_english != $reg->hostel_name)
                        <br><span style="font-size:0.7rem; color:#94a3b8;">{{ $reg->hostel_name_english }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px; color:#475569;">{{ $reg->district ?? __('messages.not_available') }}</td>
                <td style="padding:12px 16px;">
                    <span style="padding:2px 10px; border-radius:50px; font-size:0.7rem; font-weight:600; background:#f1f5f9; color:#475569;">
                        {{ ucfirst($reg->source ?? 'N/A') }}
                    </span>
                </td>
                <td style="padding:12px 16px;">
                    <span style="padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
                        {{ __('messages.status_' . $displayStatus) }}
                    </span>
                </td>
                <td style="padding:12px 16px; text-align:center; white-space:nowrap;">
                    <a href="{{ route('admin.registrations.show', $reg) }}" style="display:inline-block; padding:6px 14px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600; transition:0.2s;">
                        <i class="fas fa-eye"></i> {{ __('messages.view_details') }}
                    </a>
                    <a href="{{ route('admin.registrations.edit', $reg) }}" style="display:inline-block; padding:6px 14px; background:#F59E0B; color:#fff; border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600; transition:0.2s;">
                        <i class="fas fa-edit"></i>
                    </a>
                    @if($reg->status === 'pending')
                        <form action="{{ route('admin.registrations.approve', $reg) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" style="padding:6px 14px; background:#22C55E; color:#fff; border:none; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer; transition:0.2s;">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                                <td colspan="8" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-file-alt" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    {{ __('messages.no_registrations') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
<div style="margin-top:24px; display:flex; justify-content:center;">
    {{ $registrations->appends(request()->query())->links() }}
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
</style>
@endpush