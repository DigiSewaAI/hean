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

            // ✅ यदि remarks मा "messages.invoice_type_multi" छ भने बदल्ने
            if (str_contains($remarks, 'messages.invoice_type_multi')) {
                $remarks = str_replace(
                    '(messages.invoice_type_multi)',
                    '(Multi-line Invoice)',
                    $remarks
                );
            }

            // यदि remarks खाली छ भने alternative दिने
            if (empty($remarks) && $receipt->payment && $receipt->payment->invoice) {
                $invoice = $receipt->payment->invoice;
                if ($invoice->invoice_type === 'multi') {
                    $remarks = 'Payment for Invoice ' . $invoice->invoice_number . ' (Multi-line Invoice)';
                } else {
                    $typeLabel = __('messages.invoice_type_' . $invoice->invoice_type) ?? ucfirst(str_replace('_', ' ', $invoice->invoice_type));
                    $remarks = __('messages.payment_for_invoice') . ' ' . $invoice->invoice_number . ' (' . $typeLabel . ')';
                }
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

    {{-- ============================================================ --}}
    {{-- 🆕 NEW SECTION: INVOICE ITEMS --}}
    {{-- ============================================================ --}}
    @php
        $invoice = $receipt->payment?->invoice;
        $items = $invoice ? $invoice->items : collect();
    @endphp

    @if($invoice && $items->count())
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
            <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-list" style="color:#0EA5E9;"></i> Invoice Items
            </h4>

            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
                    <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <tr>
                            <th style="padding:10px 12px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">#</th>
                            <th style="padding:10px 12px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Description</th>
                            <th style="padding:10px 12px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Qty</th>
                            <th style="padding:10px 12px; text-align:right; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Unit Price</th>
                            <th style="padding:10px 12px; text-align:right; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Amount</th>
                            @if($items->contains('remarks'))
                                <th style="padding:10px 12px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Remarks</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($items as $index => $item)
                            @php $subtotal += $item->amount; @endphp
                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:10px 12px; font-weight:500; color:#0f172a;">{{ $loop->iteration }}</td>
                                <td style="padding:10px 12px; color:#0f172a;">{{ $item->description }}</td>
                                <td style="padding:10px 12px; text-align:center; color:#0f172a;">{{ $item->quantity }}</td>
                                <td style="padding:10px 12px; text-align:right; color:#0f172a;">NPR {{ number_format($item->unit_price, 2) }}</td>
                                <td style="padding:10px 12px; text-align:right; font-weight:600; color:#0f172a;">NPR {{ number_format($item->amount, 2) }}</td>
                                @if($items->contains('remarks'))
                                    <td style="padding:10px 12px; color:#64748b;">{{ $item->remarks ?? '—' }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div style="display:flex; justify-content:flex-end; margin-top:16px; padding-top:12px; border-top:2px solid #e2e8f0;">
                <table style="width:300px; border-collapse:collapse; font-size:0.9rem;">
                    <tr>
                        <td style="padding:4px 12px; text-align:right; font-weight:500; color:#475569;">Subtotal</td>
                        <td style="padding:4px 12px; text-align:right; font-weight:600; color:#0f172a;">NPR {{ number_format($subtotal, 2) }}</td>
                    </tr>
                    @if($invoice->discount > 0)
                    <tr>
                        <td style="padding:4px 12px; text-align:right; font-weight:500; color:#475569;">Discount</td>
                        <td style="padding:4px 12px; text-align:right; font-weight:600; color:#EF4444;">- NPR {{ number_format($invoice->discount, 2) }}</td>
                    </tr>
                    @endif
                    @if($invoice->tax > 0)
                    <tr>
                        <td style="padding:4px 12px; text-align:right; font-weight:500; color:#475569;">Tax</td>
                        <td style="padding:4px 12px; text-align:right; font-weight:600; color:#22C55E;">+ NPR {{ number_format($invoice->tax, 2) }}</td>
                    </tr>
                    @endif
                    <tr style="border-top:3px solid #F59E0B;">
                        <td style="padding:8px 12px; text-align:right; font-weight:700; font-size:1.1rem; color:#0f172a;">Total</td>
                        <td style="padding:8px 12px; text-align:right; font-weight:700; font-size:1.1rem; color:#0f172a;">NPR {{ number_format($receipt->amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection