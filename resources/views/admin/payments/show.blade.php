@extends('layouts.admin')

@section('title', __('messages.payment') . ' #' . $payment->id)

@section('content')
<div style="max-width:1000px; margin:0 auto;">
    {{-- शीर्षक र कार्यहरू --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
        <h2 style="margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-credit-card" style="color:#0EA5E9;"></i>
            {{ __('messages.payment') }} #{{ $payment->id }}
            <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
                {{ $payment->created_at ? $payment->created_at->format('M d, Y H:i') : '' }}
            </span>
        </h2>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            @if($payment->status !== 'verified')
                <a href="{{ route('admin.payments.edit', $payment) }}" style="background:#F59E0B; color:#fff; padding:8px 16px; border-radius:6px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                </a>
                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:#EF4444; color:#fff; padding:8px 16px; border:none; border-radius:6px; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                    </button>
                </form>
            @else
                <span style="background:#e2e8f0; color:#94a3b8; padding:8px 16px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-lock"></i> {{ __('messages.verified_payment_locked') }}
                </span>
            @endif
        </div>
    </div>

    {{-- सफलता वा त्रुटि सन्देश --}}
    @if(session('success'))
        <div style="background:#dcfce7; border-left:4px solid #22C55E; color:#166534; padding:12px 16px; border-radius:8px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle" style="color:#22C55E;"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2; border-left:4px solid #ef4444; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-exclamation-circle" style="color:#ef4444;"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- स्टेटस ब्याज --}}
    <div style="margin-bottom:20px;">
        @php
            $statusColors = [
                'pending'  => ['bg' => '#fef3c7', 'text' => '#92400e', 'dot' => '#f59e0b'],
                'verified' => ['bg' => '#dcfce7', 'text' => '#166534', 'dot' => '#22c55e'],
                'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'dot' => '#ef4444'],
                'refunded' => ['bg' => '#e0f2fe', 'text' => '#075985', 'dot' => '#0ea5e9'],
            ];
            $colors = $statusColors[$payment->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'dot' => '#94a3b8'];
        @endphp
        <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.9rem; background:{{ $colors['bg'] }}; color:{{ $colors['text'] }};">
            <span style="width:10px; height:10px; border-radius:50%; display:inline-block; background:{{ $colors['dot'] }};"></span>
            {{ __('messages.status_' . $payment->status) }}
        </span>

        @if($payment->verified_at)
            <span style="margin-left:16px; color:#64748b; font-size:0.85rem;">
                <i class="fas fa-check-circle" style="color:#22C55E;"></i>
                {{ __('messages.verified_on') }}: {{ $payment->verified_at->format('Y-m-d H:i') }}
                @if($payment->verified_by)
                    {{ __('messages.by') }}: {{ $payment->verifiedBy?->name ?? '#' . $payment->verified_by }}
                @endif
            </span>
        @endif

        @if($payment->refunded_at)
            <span style="margin-left:16px; color:#64748b; font-size:0.85rem;">
                <i class="fas fa-undo-alt" style="color:#F59E0B;"></i>
                {{ __('messages.refunded_on') }}: {{ $payment->refunded_at->format('Y-m-d H:i') }}
                @if($payment->refunded_by)
                    {{ __('messages.by') }}: {{ $payment->refundedBy?->name ?? '#' . $payment->refunded_by }}
                @endif
                @if($payment->refund_reason)
                    <span style="color:#94a3b8;">({{ $payment->refund_reason }})</span>
                @endif
            </span>
        @endif
    </div>

    {{-- ⚠️ यदि verified छ तर receipt छैन भने सूचना (auto generate भएको छैन भने) --}}
    @if($payment->status == 'verified' && $payment->receipts->isEmpty())
        <div style="background:#f0fdf4; border-left:4px solid #22C55E; padding:12px 16px; border-radius:8px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-info-circle" style="color:#22C55E;"></i>
            <span style="color:#166534;">{{ __('messages.receipt_will_be_generated_automatically') }}</span>
        </div>
    @endif

    {{-- मुख्य विवरण --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:24px;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div><strong>{{ __('messages.payment_number') }}</strong> #{{ $payment->id }}</div>
            <div><strong>{{ __('messages.registration') }}</strong>
                @if($payment->registration)
                    <a href="{{ route('admin.registrations.show', $payment->registration) }}" style="color:#0EA5E9; text-decoration:none;">
                        {{ $payment->registration->hostel_name ?? $payment->registration->registration_number }}
                    </a>
                @else
                    <span style="color:#94a3b8;">{{ __('messages.not_available') }}</span>
                @endif
            </div>
            <div><strong>{{ __('messages.invoice') }}</strong>
                @if($payment->invoice)
                    <a href="{{ route('admin.invoices.show', $payment->invoice) }}" style="color:#0EA5E9; text-decoration:none;">
                        {{ $payment->invoice->invoice_number }}
                    </a>
                @else
                    <span style="color:#94a3b8;">{{ __('messages.not_linked') }}</span>
                @endif
            </div>
            <div><strong>{{ __('messages.amount') }}</strong> <strong style="color:#0f172a;">NPR {{ number_format($payment->amount, 2) }}</strong></div>
            <div><strong>{{ __('messages.payment_method') }}</strong> {{ ucfirst($payment->method) }}</div>
            <div><strong>{{ __('messages.transaction_id') }}</strong> {{ $payment->transaction_id ?? 'N/A' }}</div>
            <div><strong>{{ __('messages.payment_date') }}</strong> {{ $payment->payment_date->format('Y-m-d') }}</div>
            <div><strong>{{ __('messages.status') }}</strong>
                <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600;
                    @if($payment->status == 'verified') background:#dcfce7; color:#166534;
                    @elseif($payment->status == 'pending') background:#fef3c7; color:#92400e;
                    @elseif($payment->status == 'rejected') background:#fee2e2; color:#991b1b;
                    @else background:#f1f5f9; color:#475569; @endif">
                    {{ __('messages.status_'.$payment->status) }}
                </span>
            </div>
            <div><strong>{{ __('messages.bank_name') }}</strong> {{ $payment->bank_name ?? 'N/A' }}</div>
            <div><strong>{{ __('messages.bank_account') }}</strong> {{ $payment->bank_account ?? 'N/A' }}</div>
            @if($payment->remarks)
                <div style="grid-column:1/-1;"><strong>{{ __('messages.remarks') }}</strong> {{ $payment->remarks }}</div>
            @endif
        </div>
    </div>

    {{-- कार्य बटनहरू (Verify, Reject, Refund – Generate Receipt हटाइयो) --}}
    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:24px;">
        @if($payment->status == 'pending')
            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                @csrf
                <button type="submit" style="background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; padding:10px 24px; border:none; border-radius:50px; cursor:pointer; font-weight:600; box-shadow:0 4px 15px rgba(34,197,94,0.3);">
                    <i class="fas fa-check-circle"></i> {{ __('messages.verify') }}
                </button>
            </form>
        @endif

        @if($payment->status == 'pending')
            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_reject') }}');">
                @csrf
                <button type="submit" style="background:linear-gradient(135deg, #EF4444, #DC2626); color:#fff; padding:10px 24px; border:none; border-radius:50px; cursor:pointer; font-weight:600; box-shadow:0 4px 15px rgba(239,68,68,0.3);">
                    <i class="fas fa-times-circle"></i> {{ __('messages.reject') }}
                </button>
            </form>
        @endif

        @if($payment->status == 'verified')
            <form action="{{ route('admin.payments.refund', $payment) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_refund') }}');">
                @csrf
                <button type="submit" style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:10px 24px; border:none; border-radius:50px; cursor:pointer; font-weight:600; box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                    <i class="fas fa-undo-alt"></i> {{ __('messages.refund') }}
                </button>
            </form>
        @endif
    </div>

    @if($payment->status == 'verified')
        <div style="background:#f0fdf4; border-left:4px solid #22C55E; padding:12px 16px; border-radius:8px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle" style="color:#22C55E;"></i>
            <span style="color:#166534;">{{ __('messages.payment_verified_and_locked') }}</span>
        </div>
    @endif

    {{-- रसिदहरूको सूची --}}
    @if($payment->receipts->isNotEmpty())
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:24px;">
            <h4 style="margin:0 0 16px 0; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-receipt" style="color:#F59E0B;"></i>
                {{ __('messages.receipts') }}
                <span style="font-size:0.8rem; font-weight:400; color:#94a3b8;">({{ $payment->receipts->count() }})</span>
            </h4>
            @foreach($payment->receipts as $receipt)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #e2e8f0;">
                    <div>
                        <span style="font-weight:600;">{{ $receipt->receipt_number }}</span>
                        <span style="color:#94a3b8; font-size:0.85rem; margin-left:12px;">
                            {{ $receipt->issued_date->format('Y-m-d H:i') }}
                        </span>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <span style="font-weight:600; color:#0f172a;">NPR {{ number_format($receipt->amount, 2) }}</span>
                        <a href="{{ route('admin.receipts.show', $receipt) }}" style="background:#0EA5E9; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.8rem; font-weight:600;">
                            <i class="fas fa-eye"></i> {{ __('messages.view') }}
                        </a>
                        <a href="{{ route('admin.receipts.download', $receipt) }}" style="background:#22C55E; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.8rem; font-weight:600;">
                            <i class="fas fa-download"></i> {{ __('messages.download') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Invoice Summary --}}
    @if($payment->invoice)
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
            <h4 style="margin:0 0 12px 0; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-file-invoice" style="color:#0EA5E9;"></i>
                {{ __('messages.invoice_summary') }}
            </h4>
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px;">
                <div>
                    <span style="color:#94a3b8; font-size:0.8rem;">{{ __('messages.invoice_number') }}</span>
                    <div><strong>{{ $payment->invoice->invoice_number }}</strong></div>
                </div>
                <div>
                    <span style="color:#94a3b8; font-size:0.8rem;">{{ __('messages.total_amount') }}</span>
                    <div><strong>NPR {{ number_format($payment->invoice->amount, 2) }}</strong></div>
                </div>
                <div>
                    <span style="color:#94a3b8; font-size:0.8rem;">{{ __('messages.status') }}</span>
                    <div>
                        <span style="padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;
                            @if($payment->invoice->status == 'paid') background:#dcfce7; color:#166534;
                            @elseif($payment->invoice->status == 'partial') background:#fef3c7; color:#92400e;
                            @elseif($payment->invoice->status == 'overdue') background:#fee2e2; color:#991b1b;
                            @else background:#f1f5f9; color:#475569; @endif">
                            {{ __('messages.status_'.$payment->invoice->status) }}
                        </span>
                    </div>
                </div>
            </div>
            <div style="margin-top:12px;">
                <a href="{{ route('admin.invoices.show', $payment->invoice) }}" style="color:#0EA5E9; text-decoration:none;">
                    <i class="fas fa-arrow-right"></i> {{ __('messages.view_invoice_details') }}
                </a>
            </div>
        </div>
    @endif

    @if($payment->refund_reason)
        <div style="background:#fef3c7; border-left:4px solid #F59E0B; padding:12px 16px; border-radius:8px; margin-top:24px;">
            <strong><i class="fas fa-info-circle"></i> {{ __('messages.refund_reason') }}:</strong>
            <span style="color:#92400e;">{{ $payment->refund_reason }}</span>
        </div>
    @endif

</div>
@endsection