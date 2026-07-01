@extends('layouts.admin')

@section('title', __('messages.payment') . ' #' . $payment->id)

@section('content')
<div style="max-width:1000px; margin:0 auto;">
    {{-- शीर्षक र कार्यहरू --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2 style="margin:0;">{{ __('messages.payment') }} #{{ $payment->id }}</h2>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.payments.edit', $payment) }}" style="background:#F59E0B; color:#fff; padding:8px 16px; border-radius:6px; text-decoration:none;">
                <i class="fas fa-edit"></i> {{ __('messages.edit') }}
            </a>
            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                @csrf @method('DELETE')
                <button type="submit" style="background:#EF4444; color:#fff; padding:8px 16px; border:none; border-radius:6px; cursor:pointer;">
                    <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                </button>
            </form>
        </div>
    </div>

    {{-- सफलता वा त्रुटि सन्देश --}}
    @if(session('success'))
        <div style="background:#dcfce7; border:1px solid #22C55E; color:#166534; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2; border:1px solid #ef4444; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- मुख्य विवरण --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:24px;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div><strong>{{ __('messages.payment_number') }}</strong> #{{ $payment->id }}</div>
            <div><strong>{{ __('messages.registration') }}</strong> 
                <a href="{{ route('admin.registrations.show', $payment->registration) }}">{{ $payment->registration->hostel_name ?? 'N/A' }}</a>
            </div>
            <div><strong>{{ __('messages.invoice') }}</strong> 
                @if($payment->invoice)
                    <a href="{{ route('admin.registrations.show', $payment->registration) }}#invoice-{{ $payment->invoice_id }}">{{ $payment->invoice->invoice_number }}</a>
                @else
                    <span style="color:#94a3b8;">{{ __('messages.not_linked') }}</span>
                @endif
            </div>
            <div><strong>{{ __('messages.amount') }}</strong> NPR {{ number_format($payment->amount, 2) }}</div>
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
            <div style="grid-column:1/-1;"><strong>{{ __('messages.bank_name') }}</strong> {{ $payment->bank_name ?? 'N/A' }}</div>
            <div style="grid-column:1/-1;"><strong>{{ __('messages.bank_account') }}</strong> {{ $payment->bank_account ?? 'N/A' }}</div>
            @if($payment->remarks)
            <div style="grid-column:1/-1;"><strong>{{ __('messages.remarks') }}</strong> {{ $payment->remarks }}</div>
            @endif
        </div>
    </div>

    {{-- कार्य बटनहरू (Verify, Reject, Refund, Generate Receipt) --}}
    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:24px;">
        @if($payment->status != 'verified')
            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                @csrf
                <button type="submit" style="background:#22C55E; color:#fff; padding:8px 20px; border:none; border-radius:6px; cursor:pointer;">
                    <i class="fas fa-check-circle"></i> {{ __('messages.verify') }}
                </button>
            </form>
        @endif

        @if($payment->status != 'verified' && $payment->status != 'rejected')
            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_reject') }}');">
                @csrf
                <button type="submit" style="background:#EF4444; color:#fff; padding:8px 20px; border:none; border-radius:6px; cursor:pointer;">
                    <i class="fas fa-times-circle"></i> {{ __('messages.reject') }}
                </button>
            </form>
        @endif

        @if($payment->status == 'verified')
            <form action="{{ route('admin.payments.refund', $payment) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_refund') }}');">
                @csrf
                <button type="submit" style="background:#F59E0B; color:#fff; padding:8px 20px; border:none; border-radius:6px; cursor:pointer;">
                    <i class="fas fa-undo-alt"></i> {{ __('messages.refund') }}
                </button>
            </form>
        @endif

        @if($payment->status == 'verified' && $payment->receipts->isEmpty())
            <form action="{{ route('admin.receipts.generate', $payment) }}" method="POST">
                @csrf
                <button type="submit" style="background:#0EA5E9; color:#fff; padding:8px 20px; border:none; border-radius:6px; cursor:pointer;">
                    <i class="fas fa-receipt"></i> {{ __('messages.generate_receipt') }}
                </button>
            </form>
        @endif
    </div>

    {{-- रसिदहरूको सूची (यदि कुनै छ भने) --}}
    @if($payment->receipts->isNotEmpty())
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
        <h4 style="margin:0 0 16px 0;">{{ __('messages.receipts') }}</h4>
        @foreach($payment->receipts as $receipt)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <span><strong>{{ $receipt->receipt_number }}</strong> ({{ $receipt->issued_date->format('Y-m-d') }})</span>
                <span>
                    NPR {{ number_format($receipt->amount, 2) }}
                    <a href="{{ route('admin.receipts.download', $receipt) }}" style="margin-left:16px; background:#0EA5E9; color:#fff; padding:2px 12px; border-radius:50px; text-decoration:none; font-size:0.8rem;">
                        <i class="fas fa-download"></i> {{ __('messages.download') }}
                    </a>
                </span>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection