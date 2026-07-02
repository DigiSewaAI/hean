@extends('layouts.admin')

@section('title', __('messages.payments'))

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-credit-card" style="color:#0EA5E9;"></i>
        {{ __('messages.payments') }}
    </h2>
    <a href="{{ route('admin.payments.create') }}" 
       style="display:inline-flex; align-items:center; gap:8px; 
              background:linear-gradient(135deg, #22C55E, #16A34A); 
              color:#fff; padding:12px 28px; border-radius:50px; 
              font-weight:600; font-size:1rem; text-decoration:none; 
              box-shadow:0 4px 15px rgba(34,197,94,0.3); 
              transition:all 0.3s ease; border:2px solid transparent;"
       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(34,197,94,0.4)';"
       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(34,197,94,0.3)';">
        <i class="fas fa-plus-circle" style="font-size:1.2rem;"></i> {{ __('messages.add_payment') }}
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.payments.index') }}" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
    <input type="text" name="search" placeholder="{{ __('messages.search_payments') }}" value="{{ request('search') }}" 
           style="flex:1; min-width:200px; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;"
           onfocus="this.style.borderColor='#0EA5E9'; this.style.outline='none';"
           onblur="this.style.borderColor='#e2e8f0';">
    <select name="status" style="padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff; min-width:150px;">
        <option value="">{{ __('messages.all_statuses') }}</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>{{ __('messages.pending') }}</option>
        <option value="verified" {{ request('status')=='verified'?'selected':'' }}>{{ __('messages.verified') }}</option>
        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>{{ __('messages.rejected') }}</option>
        <option value="refunded" {{ request('status')=='refunded'?'selected':'' }}>{{ __('messages.refunded') }}</option>
    </select>
    <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:10px 24px; border:none; border-radius:8px; font-weight:600; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-filter"></i> {{ __('messages.filter') }}
    </button>
    <a href="{{ route('admin.payments.index') }}" style="background:#e2e8f0; color:#475569; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500; transition:0.3s;">
        <i class="fas fa-undo"></i> {{ __('messages.reset') }}
    </a>
</form>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:#dbeafe; width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#0EA5E9; font-size:1.5rem;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <span style="color:#94a3b8; font-size:0.85rem;">{{ __('messages.total_paid') }}</span>
                <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">NPR {{ number_format($totalPayments, 2) }}</div>
            </div>
        </div>
    </div>
    <div style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:#fef3c7; width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#F59E0B; font-size:1.5rem;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <span style="color:#94a3b8; font-size:0.85rem;">{{ __('messages.pending_payments') }}</span>
                <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $pendingCount }}</div>
            </div>
        </div>
    </div>
    <div style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:#dcfce7; width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#22C55E; font-size:1.5rem;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <span style="color:#94a3b8; font-size:0.85rem;">{{ __('messages.verified_payments') }}</span>
                <div style="font-size:1.5rem; font-weight:700; color:#0f172a;">{{ $verifiedCount }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow-x:auto; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
    <table style="width:100%; border-collapse:collapse;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.payment_number') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.registration') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.invoice') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.amount') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.method') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.status') }}</th>
                <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.date') }}</th>
                <th style="padding:14px 16px; text-align:center; font-weight:600; color:#475569; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr style="border-bottom:1px solid #f1f5f9; transition:0.2s;" onmouseover="this.style.backgroundColor='#f8fafc';" onmouseout="this.style.backgroundColor='transparent';">
                <td style="padding:14px 16px; font-weight:600; color:#0f172a;">#{{ $payment->id }}</td>
                <td style="padding:14px 16px;">
                    <a href="{{ route('admin.registrations.show', $payment->registration) }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                        {{ $payment->registration->hostel_name ?? 'N/A' }}
                    </a>
                </td>
                <td style="padding:14px 16px;">
                    @if($payment->invoice)
                        <a href="{{ route('admin.invoices.show', $payment->invoice) }}" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                            {{ $payment->invoice->invoice_number }}
                        </a>
                    @else
                        <span style="color:#94a3b8; font-size:0.85rem;">{{ __('messages.not_linked') }}</span>
                    @endif
                </td>
                <td style="padding:14px 16px; font-weight:600; color:#0f172a;">NPR {{ number_format($payment->amount, 2) }}</td>
                <td style="padding:14px 16px;">
                    <span style="background:#f1f5f9; padding:4px 12px; border-radius:50px; font-size:0.75rem; font-weight:500; color:#475569;">
                        {{ ucfirst($payment->method) }}
                    </span>
                </td>
                <td style="padding:14px 16px;">
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; 
                        @if($payment->status == 'verified') background:#dcfce7; color:#166534;
                        @elseif($payment->status == 'pending') background:#fef3c7; color:#92400e;
                        @elseif($payment->status == 'rejected') background:#fee2e2; color:#991b1b;
                        @else background:#f1f5f9; color:#475569; @endif">
                        {{ __('messages.status_'.$payment->status) }}
                    </span>
                </td>
                <td style="padding:14px 16px; color:#64748b;">{{ $payment->payment_date->format('Y-m-d') }}</td>
                <td style="padding:14px 16px; text-align:center;">
                    <div style="display:flex; justify-content:center; gap:8px;">
                        <a href="{{ route('admin.payments.show', $payment) }}" style="color:#0EA5E9; transition:0.3s;" title="{{ __('messages.view') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        {{-- ✅ Edit button – verified payments मा नदेखाउने --}}
                        @if($payment->status !== 'verified')
                            <a href="{{ route('admin.payments.edit', $payment) }}" style="color:#F59E0B; transition:0.3s;" title="{{ __('messages.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endif
                        {{-- ✅ Delete button – verified payments मा नदेखाउने --}}
                        @if($payment->status !== 'verified')
                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:#EF4444; cursor:pointer; transition:0.3s;" title="{{ __('messages.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:40px; color:#94a3b8;">
                    <i class="fas fa-credit-card" style="font-size:3rem; display:block; margin-bottom:12px; color:#cbd5e1;"></i>
                    {{ __('messages.no_payments_found') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $payments->links() }}
</div>

@endsection