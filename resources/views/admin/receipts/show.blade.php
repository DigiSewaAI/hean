@extends('layouts.admin')

@section('title', __('messages.receipt') . ' ' . $receipt->receipt_number)

@section('content')
<div style="max-width:800px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2 style="margin:0;">{{ __('messages.receipt') }}: {{ $receipt->receipt_number }}</h2>
        <div>
            <a href="{{ route('admin.receipts.download', $receipt) }}" style="background:#0EA5E9; color:#fff; padding:8px 20px; border-radius:6px; text-decoration:none;">
                <i class="fas fa-download"></i> {{ __('messages.download_pdf') }}
            </a>
            <a href="{{ route('admin.receipts.index') }}" style="background:#e2e8f0; color:#475569; padding:8px 20px; border-radius:6px; text-decoration:none; margin-left:8px;">
                {{ __('messages.back') }}
            </a>
        </div>
    </div>

    {{-- विवरण कार्ड --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div><strong>{{ __('messages.receipt_number') }}</strong><br>{{ $receipt->receipt_number }}</div>
            <div><strong>{{ __('messages.issue_date') }}</strong><br>{{ $receipt->issued_date->format('Y-m-d') }}</div>
            <div><strong>{{ __('messages.registration') }}</strong><br>
                <a href="{{ route('admin.registrations.show', $receipt->registration) }}">
                    {{ $receipt->registration->hostel_name ?? 'N/A' }}
                </a>
            </div>
            <div><strong>{{ __('messages.payment') }}</strong><br>
                <a href="{{ route('admin.payments.show', $receipt->payment) }}">#{{ $receipt->payment_id }}</a>
            </div>
            <div><strong>{{ __('messages.invoice') }}</strong><br>
                @if($receipt->invoice)
                    {{ $receipt->invoice->invoice_number }}
                @else
                    <span style="color:#94a3b8;">{{ __('messages.not_linked') }}</span>
                @endif
            </div>
            <div><strong>{{ __('messages.amount') }}</strong><br>NPR {{ number_format($receipt->amount, 2) }}</div>
            <div style="grid-column:1/-1;"><strong>{{ __('messages.remarks') }}</strong><br>{{ $receipt->remarks ?? 'N/A' }}</div>
        </div>
    </div>

    {{-- PDF पूर्वावलोकन (यदि फाइल अवस्थित छ भने) --}}
    @if($receipt->pdf_path && Storage::disk('public')->exists($receipt->pdf_path))
    <div style="margin-top:24px; background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:16px;">
        <h4 style="margin:0 0 12px 0;">{{ __('messages.preview') }}</h4>
        <iframe src="{{ asset('storage/' . $receipt->pdf_path) }}" style="width:100%; height:500px; border:1px solid #e2e8f0; border-radius:6px;"></iframe>
    </div>
    @else
    <div style="margin-top:24px; background:#fef3c7; border:1px solid #F59E0B; color:#92400e; padding:16px; border-radius:8px;">
        {{ __('messages.pdf_not_available') }}
    </div>
    @endif
</div>
@endsection