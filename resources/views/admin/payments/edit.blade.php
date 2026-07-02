@extends('layouts.admin')

@section('title', __('messages.edit_payment'))

@section('content')
<div style="max-width:800px; margin:0 auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
    <h2 style="margin:0 0 20px 0; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-edit" style="color:#F59E0B;"></i> {{ __('messages.edit_payment') }} #{{ $payment->id }}
    </h2>

    @if($payment->status === 'verified')
        <div style="background:#fef3c7; border-left:4px solid #F59E0B; padding:12px 16px; border-radius:6px; margin-bottom:20px;">
            <i class="fas fa-exclamation-triangle" style="color:#F59E0B;"></i>
            {{ __('messages.verified_payment_cannot_edit') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#fee2e2; border:1px solid #ef4444; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- registration_id – select --}}
        <div style="margin-bottom:16px;">
            <label for="registration_id" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.registration') }} <span style="color:#ef4444;">*</span></label>
            <select name="registration_id" id="registration_id" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; @error('registration_id') border-color:#ef4444; @enderror" required>
                @foreach($registrations as $reg)
                    <option value="{{ $reg->id }}" {{ old('registration_id', $payment->registration_id) == $reg->id ? 'selected' : '' }}>
                        {{ $reg->hostel_name }} ({{ $reg->registration_number ?? $reg->id }})
                    </option>
                @endforeach
            </select>
            @error('registration_id') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        {{-- invoice_id – required --}}
        <div style="margin-bottom:16px;">
            <label for="invoice_id" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.invoice') }} <span style="color:#ef4444;">*</span></label>
            <select name="invoice_id" id="invoice_id" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; @error('invoice_id') border-color:#ef4444; @enderror" required>
                <option value="">{{ __('messages.select_invoice') }}</option>
                @foreach($invoices as $inv)
                    <option value="{{ $inv->id }}" {{ old('invoice_id', $payment->invoice_id) == $inv->id ? 'selected' : '' }}>
                        {{ $inv->invoice_number }} (NPR {{ number_format($inv->amount, 2) }})
                    </option>
                @endforeach
            </select>
            @error('invoice_id') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        {{-- बाँकी फिल्डहरू (create जस्तै) --}}
        <div style="margin-bottom:16px;">
            <label for="method" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.payment_method') }} <span style="color:#ef4444;">*</span></label>
            <select name="method" id="method" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; @error('method') border-color:#ef4444; @enderror" required>
                <option value="bank" {{ old('method', $payment->method) == 'bank' ? 'selected' : '' }}>{{ __('Bank') }}</option>
                <option value="esewa" {{ old('method', $payment->method) == 'esewa' ? 'selected' : '' }}>{{ __('eSewa') }}</option>
                <option value="khalti" {{ old('method', $payment->method) == 'khalti' ? 'selected' : '' }}>{{ __('Khalti') }}</option>
                <option value="cash" {{ old('method', $payment->method) == 'cash' ? 'selected' : '' }}>{{ __('Cash') }}</option>
            </select>
            @error('method') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label for="amount" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.amount') }} (NPR) <span style="color:#ef4444;">*</span></label>
            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; @error('amount') border-color:#ef4444; @enderror" required>
            @error('amount') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label for="transaction_id" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.transaction_id') }}</label>
            <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
            @error('transaction_id') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label for="payment_date" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.payment_date') }} <span style="color:#ef4444;">*</span></label>
            <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; @error('payment_date') border-color:#ef4444; @enderror" required>
            @error('payment_date') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label for="bank_name" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.bank_name') }}</label>
            <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $payment->bank_name) }}" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
            @error('bank_name') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label for="bank_account" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.bank_account') }}</label>
            <input type="text" name="bank_account" id="bank_account" value="{{ old('bank_account', $payment->bank_account) }}" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
            @error('bank_account') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label for="status" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.status') }} <span style="color:#ef4444;">*</span></label>
            <select name="status" id="status" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; @error('status') border-color:#ef4444; @enderror" required>
                <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>{{ __('messages.status_pending') }}</option>
                <option value="verified" {{ old('status', $payment->status) == 'verified' ? 'selected' : '' }}>{{ __('messages.status_verified') }}</option>
                <option value="rejected" {{ old('status', $payment->status) == 'rejected' ? 'selected' : '' }}>{{ __('messages.status_rejected') }}</option>
                <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>{{ __('messages.status_refunded') }}</option>
            </select>
            @error('status') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom:24px;">
            <label for="remarks" style="display:block; font-weight:600; margin-bottom:4px;">{{ __('messages.remarks') }}</label>
            <textarea name="remarks" id="remarks" rows="3" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">{{ old('remarks', $payment->remarks) }}</textarea>
            @error('remarks') <span style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit" style="background:#F59E0B; color:#fff; padding:10px 24px; border:none; border-radius:6px; cursor:pointer; font-weight:600;" {{ $payment->status === 'verified' ? 'disabled' : '' }}>
                <i class="fas fa-save"></i> {{ __('messages.update') }}
            </button>
            <a href="{{ route('admin.payments.index') }}" style="background:#e2e8f0; color:#475569; padding:10px 24px; border-radius:6px; text-decoration:none; font-weight:600;">
                {{ __('messages.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection