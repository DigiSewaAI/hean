@extends('layouts.admin')

@section('title', __('messages.receipts') . ' - HEAN Admin')

@section('content')
<div style="max-width:1200px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2 style="margin:0;"><i class="fas fa-receipt" style="color:#F59E0B;"></i> {{ __('messages.receipts') }}</h2>
    </div>

    {{-- Filters --}}
    <div style="background:#fff; border-radius:8px; padding:16px; margin-bottom:20px; border:1px solid #e2e8f0;">
        <form method="GET" action="{{ route('admin.receipts.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:end;">
            <div style="flex:1; min-width:200px;">
                <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b;">{{ __('messages.search') }}</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_receipts') }}" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
            </div>
            <div style="flex:1; min-width:200px;">
                <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b;">{{ __('messages.registration') }}</label>
                <select name="registration_id" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
                    <option value="">{{ __('messages.all_registrations') }}</option>
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ request('registration_id') == $reg->id ? 'selected' : '' }}>{{ $reg->hostel_name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" style="background:#0EA5E9; color:#fff; padding:8px 20px; border:none; border-radius:6px; cursor:pointer; font-weight:600;"><i class="fas fa-filter"></i> {{ __('messages.filter') }}</button>
                <a href="{{ route('admin.receipts.index') }}" style="background:#e2e8f0; color:#475569; padding:8px 20px; border-radius:6px; text-decoration:none; font-weight:600;"><i class="fas fa-times"></i> {{ __('messages.clear') }}</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div style="background:#fff; border-radius:8px; border:1px solid #e2e8f0; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
            <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                <tr>
                    <th style="padding:10px 12px; text-align:left;">#</th>
                    <th style="padding:10px 12px; text-align:left;">{{ __('messages.receipt_number') }}</th>
                    <th style="padding:10px 12px; text-align:left;">{{ __('messages.registration') }}</th>
                    <th style="padding:10px 12px; text-align:left;">{{ __('messages.invoice') }}</th>
                    <th style="padding:10px 12px; text-align:left;">{{ __('messages.amount') }}</th>
                    <th style="padding:10px 12px; text-align:left;">{{ __('messages.issued_date') }}</th>
                    <th style="padding:10px 12px; text-align:center;">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipts as $receipt)
                @php
                    $registration = $receipt->payment?->registration;
                    $invoice = $receipt->payment?->invoice;
                @endphp
                <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="padding:10px 12px;">{{ $loop->iteration }}</td>
                    <td style="padding:10px 12px; font-weight:600;">{{ $receipt->receipt_number }}</td>
                    <td style="padding:10px 12px;">
                        @if($registration)
                            <a href="{{ route('admin.registrations.show', $registration) }}" style="color:#0EA5E9; text-decoration:none;">
                                {{ $registration->hostel_name ?? $registration->registration_number }}
                            </a>
                        @else
                            <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                        @endif
                    </td>
                    <td style="padding:10px 12px;">
                        @if($invoice)
                            <a href="{{ route('admin.invoices.show', $invoice) }}" style="color:#0EA5E9; text-decoration:none;">
                                {{ $invoice->invoice_number }}
                            </a>
                        @else
                            <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                        @endif
                    </td>
                    <td style="padding:10px 12px; font-weight:500;">NPR {{ number_format($receipt->amount, 2) }}</td>
                    <td style="padding:10px 12px;">{{ $receipt->issued_date ? $receipt->issued_date->format('Y-m-d') : 'N/A' }}</td>
                    <td style="padding:10px 12px; text-align:center;">
                        <a href="{{ route('admin.receipts.show', $receipt) }}" style="background:#0EA5E9; color:#fff; padding:4px 12px; border-radius:4px; text-decoration:none; font-size:0.8rem;"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.receipts.download', $receipt) }}" style="background:#22C55E; color:#fff; padding:4px 12px; border-radius:4px; text-decoration:none; font-size:0.8rem;"><i class="fas fa-download"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="padding:30px; text-align:center; color:#94a3b8;">{{ __('messages.no_receipts_found') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px; display:flex; justify-content:space-between; align-items:center;">
        <span style="color:#64748b; font-size:0.85rem;">
            {{ __('messages.showing') }} {{ $receipts->firstItem() ?? 0 }} - {{ $receipts->lastItem() ?? 0 }} {{ __('messages.of') }} {{ $receipts->total() }}
        </span>
        {{ $receipts->appends(request()->query())->links() }}
    </div>
</div>
@endsection