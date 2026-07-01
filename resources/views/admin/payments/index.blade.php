@extends('layouts.admin')

@section('title', __('messages.payments'))

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>{{ __('messages.payments') }}</h2>
    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> {{ __('messages.add_payment') }}
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.payments.index') }}" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">
    <input type="text" name="search" placeholder="{{ __('messages.search_payments') }}" value="{{ request('search') }}" style="padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
    <select name="status" style="padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
        <option value="">{{ __('messages.all_statuses') }}</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>{{ __('messages.pending') }}</option>
        <option value="verified" {{ request('status')=='verified'?'selected':'' }}>{{ __('messages.verified') }}</option>
        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>{{ __('messages.rejected') }}</option>
        <option value="refunded" {{ request('status')=='refunded'?'selected':'' }}>{{ __('messages.refunded') }}</option>
    </select>
    <button type="submit" style="background:#0EA5E9; color:#fff; padding:8px 16px; border:none; border-radius:6px;">{{ __('messages.filter') }}</button>
</form>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
        <span style="color:#94a3b8;">{{ __('messages.total_paid') }}</span>
        <div style="font-size:1.5rem; font-weight:700;">NPR {{ number_format($totalPayments, 2) }}</div>
    </div>
    <div style="background:#fff; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
        <span style="color:#94a3b8;">{{ __('messages.pending_payments') }}</span>
        <div style="font-size:1.5rem; font-weight:700;">{{ $pendingCount }}</div>
    </div>
    <div style="background:#fff; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
        <span style="color:#94a3b8;">{{ __('messages.verified_payments') }}</span>
        <div style="font-size:1.5rem; font-weight:700;">{{ $verifiedCount }}</div>
    </div>
</div>

{{-- Table --}}
<div style="background:#fff; border-radius:8px; overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse;">
        <thead style="background:#f8fafc;">
            <tr>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.payment_number') }}</th>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.registration') }}</th>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.invoice') }}</th>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.amount') }}</th>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.method') }}</th>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.status') }}</th>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.date') }}</th>
                <th style="padding:12px 16px; text-align:left;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td style="padding:12px 16px;">#{{ $payment->id }}</td>
                <td style="padding:12px 16px;">
                    <a href="{{ route('admin.registrations.show', $payment->registration) }}">
                        {{ $payment->registration->hostel_name ?? 'N/A' }}
                    </a>
                </td>
                <td style="padding:12px 16px;">
                    @if($payment->invoice)
                        <a href="{{ route('admin.registrations.show', $payment->registration) }}#invoice-{{ $payment->invoice_id }}">
                            {{ $payment->invoice->invoice_number }}
                        </a>
                    @else
                        <span style="color:#94a3b8;">{{ __('messages.not_linked') }}</span>
                    @endif
                </td>
                <td style="padding:12px 16px;">NPR {{ number_format($payment->amount, 2) }}</td>
                <td style="padding:12px 16px;">{{ ucfirst($payment->method) }}</td>
                <td style="padding:12px 16px;">
                    <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; 
                        @if($payment->status == 'verified') background:#dcfce7; color:#166534;
                        @elseif($payment->status == 'pending') background:#fef3c7; color:#92400e;
                        @elseif($payment->status == 'rejected') background:#fee2e2; color:#991b1b;
                        @else background:#f1f5f9; color:#475569; @endif">
                        {{ __('messages.status_'.$payment->status) }}
                    </span>
                </td>
                <td style="padding:12px 16px;">{{ $payment->payment_date->format('Y-m-d') }}</td>
                <td style="padding:12px 16px;">
                    <a href="{{ route('admin.payments.show', $payment) }}" style="color:#0EA5E9;"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.payments.edit', $payment) }}" style="color:#F59E0B; margin-left:8px;"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#EF4444; cursor:pointer;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; padding:30px; color:#94a3b8;">{{ __('messages.no_payments_found') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $payments->links() }}
@endsection