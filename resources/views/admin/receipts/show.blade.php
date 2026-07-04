@extends('layouts.admin')

@section('title', __('messages.receipt') . ' #' . $receipt->receipt_number)

@section('content')
<div style="max-width:900px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2 style="margin:0;"><i class="fas fa-receipt" style="color:#F59E0B;"></i> {{ __('messages.receipt') }} #{{ $receipt->receipt_number }}</h2>
        <div>
            <a href="{{ route('admin.receipts.index') }}" style="background:#e2e8f0; color:#475569; padding:8px 16px; border-radius:6px; text-decoration:none; font-weight:600; margin-right:8px;"><i class="fas fa-arrow-left"></i> {{ __('messages.back_to_list') }}</a>
            <a href="{{ route('admin.receipts.download', $receipt) }}" style="background:#22C55E; color:#fff; padding:8px 16px; border-radius:6px; text-decoration:none; font-weight:600;"><i class="fas fa-download"></i> {{ __('messages.download_pdf') }}</a>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
        {{-- Receipt Details --}}
        <div style="background:#fff; border-radius:8px; border:1px solid #e2e8f0; padding:20px;">
            <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px;"><i class="fas fa-info-circle"></i> {{ __('messages.receipt_details') }}</h4>
            <table style="width:100%; border-collapse:collapse;">
                <tr><td style="padding:6px 0; font-weight:600; width:40%;">{{ __('messages.receipt_number') }}</td><td style="padding:6px 0;">{{ $receipt->receipt_number }}</td></tr>
                <tr><td style="padding:6px 0; font-weight:600;">{{ __('messages.amount') }}</td><td style="padding:6px 0; font-weight:700; color:#0EA5E9;">NPR {{ number_format($receipt->amount, 2) }}</td></tr>
                <tr><td style="padding:6px 0; font-weight:600;">{{ __('messages.issued_date') }}</td><td style="padding:6px 0;">{{ $receipt->issued_date ? $receipt->issued_date->format('Y-m-d H:i') : 'N/A' }}</td></tr>
                <tr><td style="padding:6px 0; font-weight:600;">{{ __('messages.payment_method') }}</td><td style="padding:6px 0;">{{ ucfirst($receipt->payment?->method ?? 'N/A') }}</td></tr>
                <tr>
                    <td style="padding:6px 0; font-weight:600;">{{ __('messages.remarks') }}</td>
                    <td style="padding:6px 0;">
                        @php
                            $remarks = $receipt->remarks;
                            if (empty($remarks) && $receipt->payment && $receipt->payment->invoice) {
                                $invoice = $receipt->payment->invoice;
                                $invoiceType = $invoice->invoice_type ?? 'unknown';
                                $typeLabel = __('messages.invoice_type_' . $invoiceType) ?? ucfirst(str_replace('_', ' ', $invoiceType));
                                $remarks = __('messages.payment_for_invoice') . ' ' . $invoice->invoice_number . ' (' . $typeLabel . ')';
                            }
                            if (empty($remarks)) {
                                $remarks = __('messages.none');
                            }
                        @endphp
                        {{ $remarks }}
                    </td>
                </tr>
            </table>
        </div>

        {{-- Registration & Invoice via Payment --}}
        <div>
            <div style="background:#fff; border-radius:8px; border:1px solid #e2e8f0; padding:20px; margin-bottom:16px;">
                <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px;"><i class="fas fa-file-alt"></i> {{ __('messages.registration') }}</h4>
                @php $registration = $receipt->payment?->registration; @endphp
                @if($registration)
                    {{-- ✅ 8.3: दर्ता नम्बर (फलब्याक #ID) --}}
                    <p style="margin:4px 0; font-weight:600; color:#0f172a;">
                        {{ $registration->registration_number ?? '#'.$registration->id }}
                    </p>
                    @if($registration->hostel_name)
                        <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                            <i class="fas fa-hotel"></i> {{ $registration->hostel_name }}
                        </p>
                    @endif
                    <a href="{{ route('admin.registrations.show', $registration) }}" style="display:inline-block; background:#0EA5E9; color:#fff; padding:4px 16px; border-radius:4px; text-decoration:none; font-size:0.85rem;"><i class="fas fa-eye"></i> {{ __('messages.view_registration') }}</a>
                @else
                    <p style="color:#94a3b8;">{{ __('messages.not_available') }}</p>
                @endif
            </div>

            <div style="background:#fff; border-radius:8px; border:1px solid #e2e8f0; padding:20px;">
                <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px;"><i class="fas fa-file-invoice"></i> {{ __('messages.invoice') }}</h4>
                @php $invoice = $receipt->payment?->invoice; @endphp
                @if($invoice)
                    <p style="margin:4px 0; font-weight:600;">{{ $invoice->invoice_number }}</p>
                    <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">NPR {{ number_format($invoice->amount, 2) }}</p>
                    <a href="{{ route('admin.invoices.show', $invoice) }}" style="display:inline-block; background:#0EA5E9; color:#fff; padding:4px 16px; border-radius:4px; text-decoration:none; font-size:0.85rem;"><i class="fas fa-eye"></i> {{ __('messages.view_invoice') }}</a>
                @else
                    <p style="color:#94a3b8;">{{ __('messages.not_available') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection