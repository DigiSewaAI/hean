@extends('layouts.admin')

@section('title', __('messages.receipts'))

@section('content')
<div>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>{{ __('messages.receipts') }}</h2>
    </div>

    {{-- फिल्टर --}}
    <form method="GET" action="{{ route('admin.receipts.index') }}" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">
        <input type="text" name="search" placeholder="{{ __('messages.search_receipts') }}" value="{{ request('search') }}" style="padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
        <select name="registration_id" style="padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
            <option value="">{{ __('messages.all_registrations') }}</option>
            @foreach($registrations as $reg)
                <option value="{{ $reg->id }}" {{ request('registration_id') == $reg->id ? 'selected' : '' }}>{{ $reg->hostel_name }}</option>
            @endforeach
        </select>
        <button type="submit" style="background:#0EA5E9; color:#fff; padding:8px 16px; border:none; border-radius:6px;">{{ __('messages.filter') }}</button>
    </form>

    {{-- तालिका --}}
    <div style="background:#fff; border-radius:8px; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:#f8fafc;">
                <tr>
                    <th style="padding:12px 16px; text-align:left;">{{ __('messages.receipt_number') }}</th>
                    <th style="padding:12px 16px; text-align:left;">{{ __('messages.registration') }}</th>
                    <th style="padding:12px 16px; text-align:left;">{{ __('messages.invoice') }}</th>
                    <th style="padding:12px 16px; text-align:left;">{{ __('messages.amount') }}</th>
                    <th style="padding:12px 16px; text-align:left;">{{ __('messages.issue_date') }}</th>
                    <th style="padding:12px 16px; text-align:left;">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipts as $receipt)
                <tr>
                    <td style="padding:12px 16px;">{{ $receipt->receipt_number }}</td>
                    <td style="padding:12px 16px;">
                        <a href="{{ route('admin.registrations.show', $receipt->registration) }}">
                            {{ $receipt->registration->hostel_name ?? 'N/A' }}
                        </a>
                    </td>
                    <td style="padding:12px 16px;">
                        @if($receipt->invoice)
                            {{ $receipt->invoice->invoice_number }}
                        @else
                            <span style="color:#94a3b8;">{{ __('messages.not_linked') }}</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px;">NPR {{ number_format($receipt->amount, 2) }}</td>
                    <td style="padding:12px 16px;">{{ $receipt->issued_date->format('Y-m-d') }}</td>
                    <td style="padding:12px 16px;">
                        <a href="{{ route('admin.receipts.show', $receipt) }}" style="color:#0EA5E9; margin-right:8px;"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.receipts.download', $receipt) }}" style="color:#22C55E;"><i class="fas fa-download"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; padding:30px; color:#94a3b8;">{{ __('messages.no_receipts_found') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $receipts->links() }}
</div>
@endsection