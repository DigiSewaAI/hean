@extends('layouts.admin')

@section('title', __('messages.receipts') . ' - HEAN Admin')

@section('content')

{{-- ===== STATS BAR ===== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#F59E0B; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-receipt" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $totalReceipts ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_receipts') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#22C55E; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-money-bill-wave" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">NPR {{ number_format($totalAmount ?? 0, 2) }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_amount') }}</div>
        </div>
    </div>
</div>

{{-- ===== TOOLBAR: SEARCH + FILTERS + ACTIONS ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="{{ route('admin.receipts.index') }}" method="GET" id="filterForm">
        {{-- Basic Search & Quick Filters --}}
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#F59E0B;"></i> {{ __('messages.search') }}
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="रसिद नं., होस्टल नाम, दर्ता नम्बर, इनभ्वाइस..." 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            {{-- Filter: Registration --}}
            <div style="flex:1.5; min-width:180px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.registration') }}</label>
                <select name="registration_id" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all_registrations') }}</option>
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ request('registration_id') == $reg->id ? 'selected' : '' }}>
                            {{ $reg->hostel_name }} ({{ $reg->registration_number ?? '#' . $reg->id }})
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
                    <option value="amount_asc" {{ request('sort')=='amount_asc'?'selected':'' }}>{{ __('messages.sort_amount_asc') }}</option>
                    <option value="amount_desc" {{ request('sort')=='amount_desc'?'selected':'' }}>{{ __('messages.sort_amount_desc') }}</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <button type="submit" style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(245,158,11,0.25);">
                    <i class="fas fa-filter"></i> {{ __('messages.filter') }}
                </button>
                <a href="{{ route('admin.receipts.index') }}" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-undo"></i> {{ __('messages.reset') }}
                </a>
                <button type="button" onclick="document.getElementById('advancedFilters').style.display = (document.getElementById('advancedFilters').style.display === 'none' ? 'block' : 'none')" 
                        style="background:#f1f5f9; color:#1e293b; border:1px solid #e2e8f0; padding:10px 16px; border-radius:50px; font-weight:500; font-size:0.85rem; cursor:pointer; transition:0.2s;">
                    <i class="fas fa-sliders-h"></i> {{ __('messages.advanced') }}
                </button>
            </div>
        </div>

        {{-- Advanced Filters (collapsible) --}}
        <div id="advancedFilters" style="display: {{ request()->hasAny(['amount_min', 'amount_max', 'date_from', 'date_to']) ? 'block' : 'none' }}; margin-top:16px; padding-top:16px; border-top:1px solid #e2e8f0;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:12px;">
                {{-- Amount Min --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.amount_min') }}</label>
                    <input type="number" name="amount_min" value="{{ request('amount_min') }}" placeholder="Min" min="0" step="0.01"
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
                </div>

                {{-- Amount Max --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.amount_max') }}</label>
                    <input type="number" name="amount_max" value="{{ request('amount_max') }}" placeholder="Max" min="0" step="0.01"
                           style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc;">
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

{{-- ===== TABLE ===== --}}
<div style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">#</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.receipt_number') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.registration') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.invoice') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.amount') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.issued_date') }}</th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($receipts as $receipt)
            @php
                $registration = $receipt->payment?->registration;
                $invoice = $receipt->payment?->invoice;
            @endphp
            <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">{{ $loop->iteration + ($receipts->currentPage() - 1) * $receipts->perPage() }}</td>
                <td style="padding:12px 16px; font-weight:600; color:#0f172a;">{{ $receipt->receipt_number }}</td>
                <td style="padding:12px 16px;">
                    @if($registration)
                        <a href="{{ route('admin.registrations.show', $registration) }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                            {{ $registration->registration_number ?? '#'.$registration->id }}
                        </a>
                        @if($registration->hostel_name)
                            <br><span style="font-size:0.7rem; color:#94a3b8;">{{ $registration->hostel_name }}</span>
                        @endif
                    @else
                        <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px;">
                    @if($invoice)
                        <a href="{{ route('admin.invoices.show', $invoice) }}" style="color:#0EA5E9; text-decoration:none;">
                            {{ $invoice->invoice_number }}
                        </a>
                    @else
                        <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px; font-weight:600; color:#0f172a;">NPR {{ number_format($receipt->amount, 2) }}</td>
                <td style="padding:12px 16px; color:#64748b;">{{ $receipt->issued_date ? $receipt->issued_date->format('Y-m-d') : 'N/A' }}</td>
                <td style="padding:12px 16px; text-align:center; white-space:nowrap;">
                    <div style="display:flex; justify-content:center; gap:8px;">
                        <a href="{{ route('admin.receipts.show', $receipt) }}" style="display:inline-block; padding:6px 10px; background:#0EA5E9; color:#fff; border-radius:6px; font-size:0.75rem; font-weight:600; text-decoration:none;" title="{{ __('messages.view') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.receipts.download', $receipt) }}" style="display:inline-block; padding:6px 10px; background:#22C55E; color:#fff; border-radius:6px; font-size:0.75rem; font-weight:600; text-decoration:none;" title="{{ __('messages.download') }}">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-receipt" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    {{ __('messages.no_receipts_found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
<div style="margin-top:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
    <span style="color:#64748b; font-size:0.85rem;">
        {{ __('messages.showing') }} {{ $receipts->firstItem() ?? 0 }} - {{ $receipts->lastItem() ?? 0 }} {{ __('messages.of') }} {{ $receipts->total() }}
    </span>
    <div>
        {{ $receipts->appends(request()->query())->links() }}
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
        border-color: #F59E0B;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #F59E0B, #D97706);
        border-color: #F59E0B;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush