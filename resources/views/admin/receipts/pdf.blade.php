<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.receipt') }} {{ $receipt->receipt_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background: #f2f2f2; }
        .total { font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #94a3b8; font-size: 0.8rem; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('messages.receipt') }}</h1>
        <p>{{ __('messages.hostel_entrepreneur_association') }}</p>
    </div>
    <div class="details">
        <p><strong>{{ __('messages.receipt_number') }}:</strong> {{ $receipt->receipt_number }}</p>
        <p><strong>{{ __('messages.issue_date') }}:</strong> {{ $receipt->issued_date->format('Y-m-d') }}</p>
        <p><strong>{{ __('messages.registration') }}:</strong> #{{ $receipt->registration_id }} - {{ $receipt->registration->hostel_name ?? '' }}</p>
        @if($receipt->invoice)
        <p><strong>{{ __('messages.invoice') }}:</strong> {{ $receipt->invoice->invoice_number }}</p>
        @endif
        <p><strong>{{ __('messages.payment_method') }}:</strong> {{ ucfirst($payment->method) }}</p>
        <p><strong>{{ __('messages.transaction_id') }}:</strong> {{ $payment->transaction_id ?? 'N/A' }}</p>
        @if($receipt->remarks)
        <p><strong>{{ __('messages.remarks') }}:</strong> {{ $receipt->remarks }}</p>
        @endif
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('messages.description') }}</th>
                <th>{{ __('messages.amount') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ __('messages.payment_received') }}</td>
                <td>NPR {{ number_format($receipt->amount, 2) }}</td>
            </tr>
            <tr class="total">
                <td>{{ __('messages.total') }}</td>
                <td>NPR {{ number_format($receipt->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="footer">
        {{ __('messages.thank_you_for_payment') }}
    </div>
</body>
</html>