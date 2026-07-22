{{-- VERSION 2.0 --}}
@extends('layouts.admin')

@section('title', __('messages.invoice') . ' #' . $invoice->invoice_number . ' - HEAN Admin')

@section('content')
<div style="max-width:1200px; margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
        <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-invoice" style="color:#0EA5E9;"></i>
            {{ __('messages.invoice') }} #{{ $invoice->invoice_number }}
            <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
                {{ $invoice->issued_date ? $invoice->issued_date->format('M d, Y') : __('messages.not_available') }}
            </span>
        </h2>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="{{ route('admin.invoices.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
                <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_list') }}
            </a>
            @if($invoice->pdf_path)
                <a href="{{ route('admin.invoices.download', $invoice) }}" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; box-shadow:0 4px 15px rgba(34,197,94,0.3);">
                    <i class="fas fa-download"></i> {{ __('messages.download_pdf') }}
                </a>
            @endif
        </div>
    </div>

    {{-- Status Badge --}}
    <div style="margin-bottom:20px;">
        @php
            $statusColors = [
                'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'partial' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'paid'    => ['bg' => '#dcfce7', 'text' => '#166534'],
                'overdue' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            ];
            $colors = $statusColors[$invoice->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
        @endphp
        <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.9rem; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
            <span style="width:10px; height:10px; border-radius:50%; display:inline-block; background:{{ $colors['text'] }};"></span>
            {{ __('messages.status_' . $invoice->status) }}
        </span>
    </div>

    {{-- Main Grid --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        {{-- Left: Invoice Details --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
            <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-info-circle" style="color:#0EA5E9;"></i> {{ __('messages.invoice_details') }}
            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.invoice_number') }}</span>
                    <br><strong style="color:#0f172a;">{{ $invoice->invoice_number }}</strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.amount') }}</span>
                    <br><strong style="color:#0f172a; font-size:1.2rem;">NPR {{ number_format($invoice->amount, 2) }}</strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.issued_date') }}</span>
                    <br>{{ $invoice->issued_date ? $invoice->issued_date->format('Y-m-d H:i') : 'N/A' }}
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.due_date') }}</span>
                    <br>
                    {{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}
                    @if($invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid')
                        <span style="background:#fee2e2; color:#991b1b; padding:2px 8px; border-radius:50px; font-size:0.7rem; font-weight:600; margin-left:6px;">{{ __('messages.overdue') }}</span>
                    @endif
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.invoice_type') }}</span>
                    <br>{{ __('messages.invoice_type_' . $invoice->invoice_type) }}
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;">{{ __('messages.status') }}</span>
                    <br>
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.8rem; font-weight:600; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
                        {{ __('messages.status_' . $invoice->status) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Right: Registration & Payments --}}
        <div>

            {{-- Registration Info --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:16px;">
                <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-file-alt" style="color:#0EA5E9;"></i> {{ __('messages.registration') }}
                </h4>
                @if($invoice->registration)
                    <p style="margin:4px 0; font-weight:600; color:#0f172a;">{{ $invoice->registration->hostel_name ?? $invoice->registration->registration_number }}</p>
                    <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                        <i class="fas fa-hashtag"></i> {{ $invoice->registration->registration_number ?? '#'.$invoice->registration->id }}
                    </p>
                    <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                        <i class="fas fa-map-marker-alt"></i> {{ $invoice->registration->district }}, {{ $invoice->registration->municipality }}
                    </p>
                    <a href="{{ route('admin.registrations.show', $invoice->registration) }}" style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem; margin-top:8px;">
                        <i class="fas fa-eye"></i> {{ __('messages.view_registration') }}
                    </a>
                @else
                    <p style="color:#94a3b8;">{{ __('messages.not_available') }}</p>
                @endif
            </div>

            {{-- Payment Summary --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
                <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-credit-card" style="color:#22C55E;"></i> {{ __('messages.payments') }}
                </h4>
                @php
                    $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');
                    $balance = $invoice->amount - $totalPaid;
                @endphp
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; text-align:center; margin-bottom:12px;">
                    <div style="background:#f8fafc; padding:12px; border-radius:8px;">
                        <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.total_paid') }}</div>
                        <div style="font-weight:700; font-size:1.3rem; color:#22C55E;">NPR {{ number_format($totalPaid, 2) }}</div>
                    </div>
                    <div style="background:#f8fafc; padding:12px; border-radius:8px;">
                        <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;">{{ __('messages.outstanding') }}</div>
                        <div style="font-weight:700; font-size:1.3rem; color:#EF4444;">NPR {{ number_format(max(0, $balance), 2) }}</div>
                    </div>
                </div>

                @if($invoice->payments->count())
                    <div style="max-height:200px; overflow-y:auto;">
                        @foreach($invoice->payments as $payment)
                            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                                <div>
                                    <span style="font-weight:500;">{{ ucfirst($payment->method) }}</span>
                                    <span style="font-size:0.75rem; color:#94a3b8; margin-left:8px;">{{ $payment->transaction_id ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span style="font-weight:600;">NPR {{ number_format($payment->amount, 2) }}</span>
                                    <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                                        @if($payment->status == 'verified') background:#dcfce7; color:#166534;
                                        @elseif($payment->status == 'pending') background:#fef3c7; color:#92400e;
                                        @else background:#f1f5f9; color:#475569; @endif
                                    ">
                                        {{ __('messages.status_'.$payment->status) }}
                                    </span>
                                    @if($payment->status == 'verified' && $payment->receipts->isNotEmpty())
                                        <a href="{{ route('admin.receipts.download', $payment->receipts->first()) }}" 
                                           style="margin-left:4px; background:#F59E0B; color:#fff; padding:2px 8px; border-radius:50px; text-decoration:none; font-size:0.6rem; font-weight:600;">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="text-align:center; color:#94a3b8; padding:12px 0;">{{ __('messages.no_payments_recorded') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- 🆕 NEW SECTION: INVOICE ITEMS (Multi-line) --}}
    {{-- ============================================================ --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
        <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-list" style="color:#0EA5E9;"></i> Invoice Items
        </h4>

        @if($invoice->items->count())
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
                    <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <tr>
                            <th style="padding:10px 12px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">#</th>
                            <th style="padding:10px 12px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Description</th>
                            <th style="padding:10px 12px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Qty</th>
                            <th style="padding:10px 12px; text-align:right; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Unit Price</th>
                            <th style="padding:10px 12px; text-align:right; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Amount</th>
                            @if($invoice->items->contains('remarks'))
                                <th style="padding:10px 12px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">Remarks</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($invoice->items as $index => $item)
                            @php $subtotal += $item->amount; @endphp
                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <td style="padding:10px 12px; font-weight:500; color:#0f172a;">{{ $loop->iteration }}</td>
                                <td style="padding:10px 12px; color:#0f172a;">{{ $item->description }}</td>
                                <td style="padding:10px 12px; text-align:center; color:#0f172a;">{{ $item->quantity }}</td>
                                <td style="padding:10px 12px; text-align:right; color:#0f172a;">NPR {{ number_format($item->unit_price, 2) }}</td>
                                <td style="padding:10px 12px; text-align:right; font-weight:600; color:#0f172a;">NPR {{ number_format($item->amount, 2) }}</td>
                                @if($invoice->items->contains('remarks'))
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
                    <tr style="border-top:3px solid #0EA5E9;">
                        <td style="padding:8px 12px; text-align:right; font-weight:700; font-size:1.1rem; color:#0f172a;">Total</td>
                        <td style="padding:8px 12px; text-align:right; font-weight:700; font-size:1.1rem; color:#0f172a;">NPR {{ number_format($invoice->amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        @else
            <p style="text-align:center; color:#94a3b8; padding:20px 0;">No items found for this invoice.</p>
        @endif
    </div>

    {{-- Actions --}}
    <div style="margin-top:24px; background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:16px 20px; display:flex; gap:12px; flex-wrap:wrap;">
        @if($invoice->pdf_path)
            <a href="{{ route('admin.invoices.download', $invoice) }}" style="display:inline-flex; align-items:center; gap:6px; background:#22C55E; color:#fff; padding:8px 24px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.85rem; box-shadow:0 4px 15px rgba(34,197,94,0.3);">
                <i class="fas fa-file-pdf"></i> {{ __('messages.download_pdf') }}
            </a>
        @endif

        {{-- Add Payment as Form (GET) --}}
        @if($invoice->status !== 'paid')
            <form action="{{ route('admin.payments.create') }}" method="GET" style="display:inline;">
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <button type="submit" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:8px 24px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                    <i class="fas fa-plus-circle"></i> {{ __('messages.add_payment') }}
                </button>
            </form>
        @endif
        @if($invoice->registration)
            <a href="{{ route('admin.registrations.show', $invoice->registration) }}" 
               style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 24px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
                <i class="fas fa-arrow-right"></i> {{ __('messages.go_to_registration') }}
            </a>
        @endif
    </div>

</div>
@endsection