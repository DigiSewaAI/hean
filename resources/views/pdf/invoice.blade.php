<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HEAN – Invoice</h1>
        <p>Hostel Entrepreneur Association of Nepal</p>
    </div>
    <div class="details">
        <p><strong>Invoice #:</strong> {{ $invoiceNumber }}</p>
        <p><strong>Date:</strong> {{ now()->format('Y-m-d') }}</p>
        <p><strong>Registration ID:</strong> #{{ $registration->id }}</p>
        <p><strong>Hostel:</strong> {{ $registration->hostel->name ?? '' }}</p>
        <p><strong>Owner:</strong> {{ $registration->owner->name ?? '' }}</p>
        <p><strong>Amount:</strong> NPR {{ number_format($request->amount, 2) }}</p>
        @if($request->due_date)
        <p><strong>Due Date:</strong> {{ $request->due_date }}</p>
        @endif
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Membership Registration Fee</td>
                <td>NPR {{ number_format($request->amount, 2) }}</td>
            </tr>
            <tr class="total">
                <td>Total</td>
                <td>NPR {{ number_format($request->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <p style="margin-top: 30px;">Thank you for being a member of HEAN.</p>
</body>
</html>