@extends('layouts.admin')

@section('title', __('messages.invoices') . ' - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-file-invoice" style="color:#0EA5E9;"></i>
        {{ __('messages.invoices') }}
    </h2>
    <a href="{{ route('admin.registrations.index') }}" 
       style="display:inline-flex; align-items:center; gap:8px; 
              background:#e2e8f0; color:#1e293b; padding:10px 20px; 
              border-radius:50px; text-decoration:none; font-weight:600; 
              font-size:0.9rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('messages.go_to_registrations') }}
    </a>
</div>

{{-- Filters --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:20px;">
    <form method="GET" action="{{ route('admin.invoices.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:end;">
        <div style="flex:1; min-width:180px;">
            <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b; margin-bottom:4px;">{{ __('messages.search') }}</label>
            <input type="text" name="search" class="form-control" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" placeholder="{{ __('messages.search_invoices') }}" value="{{ request('search') }}">
        </div>
        <div style="min-width:140px;">
            <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b; margin-bottom:4px;">{{ __('messages.status') }}</label>
            <select name="status" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;">
                <option value="">{{ __('messages.all_statuses') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('messages.status_pending') }}</option>
                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>{{ __('messages.status_partial') }}</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>{{ __('messages.status_paid') }}</option>
                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>{{ __('messages.status_overdue') }}</option>
            </select>
        </div>
        <div style="min-width:140px;">
            <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b; margin-bottom:4px;">{{ __('messages.from_date') }}</label>
            <input type="date" name="from" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" value="{{ request('from') }}">
        </div>
        <div style="min-width:140px;">
            <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b; margin-bottom:4px;">{{ __('messages.to_date') }}</label>
            <input type="date" name="to" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;" value="{{ request('to') }}">
        </div>
        <div style="display:flex; gap:8px;">
            <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:8px 20px; border:none; border-radius:8px; font-weight:600; cursor:pointer;">
                <i class="fas fa-filter"></i> {{ __('messages.filter') }}
            </button>
            <a href="{{ route('admin.invoices.index') }}" style="background:#e2e8f0; color:#475569; padding:8px 20px; border-radius:8px; text-decoration:none; font-weight:600;">
                <i class="fas fa-times"></i> {{ __('messages.clear') }}
            </a>
        </div>
    </form>
</div>

{{-- Table --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow-x:auto; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
    <table style="width:100%; border-collapse:collapse;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">#</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.invoice_number') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.registration') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.amount') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.issued_date') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.due_date') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.status') }}</th>
                <th style="padding:14px 16px; text-align:center; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
            <tr style="border-bottom:1px solid #f1f5f9; transition:0.2s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                <td style="padding:14px 16px; font-weight:600; color:#0f172a;">{{ $loop->iteration }}</td>
                <td style="padding:14px 16px; font-weight:600; color:#0f172a;">{{ $invoice->invoice_number }}</td>
                <td style="padding:14px 16px;">
                    @if($invoice->registration)
                        {{-- ✅ 8.3: दर्ता नम्बर (फलब्याक #ID) --}}
                        <a href="{{ route('admin.registrations.show', $invoice->registration) }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                            {{ $invoice->registration->registration_number ?? '#'.$invoice->registration->id }}
                        </a>
                        {{-- Optional: hostel name as small subtitle --}}
                        @if($invoice->registration->hostel_name)
                            <br><span style="font-size:0.7rem; color:#94a3b8;">{{ $invoice->registration->hostel_name }}</span>
                        @endif
                    @else
                        <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                    @endif
                </td>
                <td style="padding:14px 16px; font-weight:600; color:#0f172a;">NPR {{ number_format($invoice->amount, 2) }}</td>
                <td style="padding:14px 16px; color:#64748b;">{{ $invoice->issued_date ? $invoice->issued_date->format('Y-m-d') : 'N/A' }}</td>
                <td style="padding:14px 16px; color:#64748b;">{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}</td>
                <td style="padding:14px 16px;">
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; 
                        @if($invoice->status == 'paid') background:#dcfce7; color:#166534;
                        @elseif($invoice->status == 'pending') background:#fef3c7; color:#92400e;
                        @elseif($invoice->status == 'partial') background:#fef3c7; color:#92400e;
                        @elseif($invoice->status == 'overdue') background:#fee2e2; color:#991b1b;
                        @else background:#f1f5f9; color:#475569; @endif">
                        {{ __('messages.status_' . $invoice->status) }}
                    </span>
                </td>
                <td style="padding:14px 16px; text-align:center;">
                    <div style="display:flex; justify-content:center; gap:8px;">
                        <a href="{{ route('admin.invoices.show', $invoice) }}" style="color:#0EA5E9; transition:0.3s;" title="{{ __('messages.view') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.invoices.download', $invoice) }}" style="color:#22C55E; transition:0.3s;" title="{{ __('messages.download') }}">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:40px; color:#94a3b8;">
                    <i class="fas fa-file-invoice" style="font-size:3rem; display:block; margin-bottom:12px; color:#cbd5e1;"></i>
                    {{ __('messages.no_invoices_found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center;">
    <span style="color:#64748b; font-size:0.85rem;">
        {{ __('messages.showing') }} {{ $invoices->firstItem() ?? 0 }} - {{ $invoices->lastItem() ?? 0 }}
        {{ __('messages.of') }} {{ $invoices->total() }}
    </span>
    <div>
        {{ $invoices->appends(request()->query())->links() }}
    </div>
</div>
@endsection