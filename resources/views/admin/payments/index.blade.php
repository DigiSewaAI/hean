@extends('layouts.admin')

@section('title', __('messages.payments') . ' - HEAN Admin')

@section('content')

{{-- ===== STATS BAR ===== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#0EA5E9; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-money-bill-wave" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">NPR {{ number_format($totalPayments ?? 0, 2) }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.total_paid') }}</div>
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
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $verifiedCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_verified') }}</div>
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
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#8B5CF6; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-undo-alt" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $refundedCount ?? 0 }}</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;">{{ __('messages.status_refunded') }}</div>
        </div>
    </div>
</div>

{{-- ===== TOOLBAR: SEARCH + FILTERS + ACTIONS ===== --}}
<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="{{ route('admin.payments.index') }}" method="GET" id="filterForm">
        {{-- Basic Search & Quick Filters --}}
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
            {{-- Search --}}
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#0EA5E9;"></i> {{ __('messages.search') }}
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ट्रान्जेक्सन आईडी, विधि, होस्टल नाम, दर्ता नम्बर..." 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            {{-- Filter: Status --}}
            <div style="flex:1; min-width:140px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.status') }}</label>
                <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>{{ __('messages.status_pending') }}</option>
                    <option value="verified" {{ request('status')=='verified'?'selected':'' }}>{{ __('messages.status_verified') }}</option>
                    <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>{{ __('messages.status_rejected') }}</option>
                    <option value="refunded" {{ request('status')=='refunded'?'selected':'' }}>{{ __('messages.status_refunded') }}</option>
                </select>
            </div>

            {{-- Filter: Method --}}
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.method') }}</label>
                <select name="method" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="">{{ __('messages.all') }}</option>
                    @foreach($methods as $method)
                        <option value="{{ $method }}" {{ request('method')==$method?'selected':'' }}>{{ ucfirst($method) }}</option>
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
                    <option value="date_asc" {{ request('sort')=='date_asc'?'selected':'' }}>{{ __('messages.sort_date_asc') }}</option>
                    <option value="status_asc" {{ request('sort')=='status_asc'?'selected':'' }}>{{ __('messages.sort_status_asc') }}</option>
                    <option value="status_desc" {{ request('sort')=='status_desc'?'selected':'' }}>{{ __('messages.sort_status_desc') }}</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.25);">
                    <i class="fas fa-filter"></i> {{ __('messages.filter') }}
                </button>
                <a href="{{ route('admin.payments.index') }}" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-undo"></i> {{ __('messages.reset') }}
                </a>
                <button type="button" onclick="document.getElementById('advancedFilters').style.display = (document.getElementById('advancedFilters').style.display === 'none' ? 'block' : 'none')" 
                        style="background:#f1f5f9; color:#1e293b; border:1px solid #e2e8f0; padding:10px 16px; border-radius:50px; font-weight:500; font-size:0.85rem; cursor:pointer; transition:0.2s;">
                    <i class="fas fa-sliders-h"></i> {{ __('messages.advanced') }}
                </button>
            </div>
        </div>

        {{-- Advanced Filters (collapsible) --}}
        <div id="advancedFilters" style="display: {{ request()->hasAny(['amount_min', 'amount_max', 'date_from', 'date_to', 'registration_id']) ? 'block' : 'none' }}; margin-top:16px; padding-top:16px; border-top:1px solid #e2e8f0;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:12px;">
                {{-- Registration Dropdown --}}
                <div>
                    <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">{{ __('messages.registration') }}</label>
                    <select name="registration_id" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach($registrations as $reg)
                            <option value="{{ $reg->id }}" {{ request('registration_id')==$reg->id?'selected':'' }}>
                                {{ $reg->registration_number }} - {{ $reg->hostel_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

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
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.transaction_id') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.registration') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.invoice') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.amount') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.method') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.status') }}</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.payment_date') }}</th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">{{ $payment->transaction_id ?? '—' }}</td>
                <td style="padding:12px 16px;">
                    @if($payment->registration)
                        <a href="{{ route('admin.registrations.show', $payment->registration) }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                            {{ $payment->registration->registration_number ?? '#'.$payment->registration->id }}
                        </a>
                        @if($payment->registration->hostel_name)
                            <br><span style="font-size:0.7rem; color:#94a3b8;">{{ $payment->registration->hostel_name }}</span>
                        @endif
                    @else
                        <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px;">
                    @if($payment->invoice)
                        <a href="{{ route('admin.invoices.show', $payment->invoice) }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                            {{ $payment->invoice->invoice_number }}
                        </a>
                    @else
                        <span style="color:#94a3b8;">{{ __('messages.not_linked') }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px; font-weight:600; color:#0f172a;">NPR {{ number_format($payment->amount, 2) }}</td>
                <td style="padding:12px 16px;">
                    <span style="background:#f1f5f9; padding:4px 12px; border-radius:50px; font-size:0.75rem; font-weight:500; color:#475569;">
                        {{ ucfirst($payment->method) }}
                    </span>
                </td>
                <td style="padding:12px 16px;">
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; 
                        @if($payment->status == 'verified') background:#dcfce7; color:#166534;
                        @elseif($payment->status == 'pending') background:#fef3c7; color:#92400e;
                        @elseif($payment->status == 'rejected') background:#fee2e2; color:#991b1b;
                        @elseif($payment->status == 'refunded') background:#f3e8ff; color:#7c3aed;
                        @else background:#f1f5f9; color:#475569; @endif">
                        {{ __('messages.status_'.$payment->status) }}
                    </span>
                </td>
                <td style="padding:12px 16px; color:#64748b;">{{ $payment->payment_date->format('Y-m-d') }}</td>
                <td style="padding:12px 16px; text-align:center; white-space:nowrap;">
                    <div style="display:flex; justify-content:center; gap:6px;">
                        <a href="{{ route('admin.payments.show', $payment) }}" style="display:inline-block; padding:4px 10px; background:#0EA5E9; color:#fff; border-radius:6px; font-size:0.75rem; font-weight:600; text-decoration:none;" title="{{ __('messages.view') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($payment->status !== 'verified')
                            <a href="{{ route('admin.payments.edit', $payment) }}" style="display:inline-block; padding:4px 10px; background:#F59E0B; color:#fff; border-radius:6px; font-size:0.75rem; font-weight:600; text-decoration:none;" title="{{ __('messages.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" style="padding:4px 10px; background:#EF4444; color:#fff; border:none; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer; transition:0.2s;" onclick="return confirm('{{ __('messages.confirm_delete_payment') }}')" title="{{ __('messages.delete') }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                        @if($payment->status === 'pending')
                            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" style="padding:4px 10px; background:#22C55E; color:#fff; border:none; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer; transition:0.2s;" onclick="return confirm('{{ __('messages.confirm_verify_payment') }}')" title="{{ __('messages.verify') }}">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" style="padding:4px 10px; background:#EF4444; color:#fff; border:none; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer; transition:0.2s;" onclick="return confirm('{{ __('messages.confirm_reject_payment') }}')" title="{{ __('messages.reject') }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @endif
                        
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-credit-card" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    {{ __('messages.no_payments_found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===== PAGINATION ===== --}}
<div style="margin-top:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
    <span style="color:#64748b; font-size:0.85rem;">
        {{ __('messages.showing') }} {{ $payments->firstItem() ?? 0 }} - {{ $payments->lastItem() ?? 0 }} {{ __('messages.of') }} {{ $payments->total() }}
    </span>
    <div>
        {{ $payments->appends(request()->query())->links() }}
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