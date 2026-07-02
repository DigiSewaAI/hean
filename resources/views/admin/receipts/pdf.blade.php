<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Receipt {{ $receipt->receipt_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'notosansdevanagari', 'DejaVu Sans', sans-serif;  <!-- ✅ Explicit font for Nepali -->
            font-size: 13px;
            line-height: 1.6;
            color: #1e293b;
            padding: 30px;
            background: #f8fafc;
        }
        .receipt-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px 35px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            position: relative;
            overflow: hidden;
        }

        /* ===== WATERMARK ===== */
        /* Removed - handled by controller */

        /* ===== HEADER ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #22C55E;
            padding-bottom: 20px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .header-left .logo img {
            height: 65px;
            width: auto;
        }
        .header-left .org .nepali-name {
            font-size: 16px;
            font-weight: 700;
            color: #0b2b4a;
            letter-spacing: 0.5px;
        }
        .header-left .org .main-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e5f8e;
        }
        .header-left .org .sub-name {
            font-size: 13px;
            font-weight: 600;
            color: #0b2b4a;
        }
        .header-left .org .regd-no {
            font-size: 11px;
            font-weight: 500;
            color: #475569;
            margin-top: 2px;
        }
        .header-right {
            text-align: right;
        }
        .header-right .doc-type {
            font-size: 28px;
            font-weight: 900;
            color: #22C55E;
            letter-spacing: 3px;
        }
        .header-right .doc-meta {
            margin-top: 4px;
            font-size: 12px;
            color: #475569;
            line-height: 1.8;
        }
        .header-right .doc-meta strong {
            color: #0f172a;
        }
        .header-right .org-details {
            font-size: 11px;
            color: #475569;
            margin-top: 4px;
            line-height: 1.5;
        }

        /* ===== RECEIVED FROM ===== */
        .received {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
            position: relative;
            z-index: 1;
        }
        .received .from .label {
            font-weight: 700;
            font-size: 14px;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .received .from .value {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 4px;
        }
        .received .from .sub-value {
            font-weight: 400;
            font-size: 13px;
            color: #475569;
        }
        .received .details {
            text-align: right;
            font-size: 13px;
            color: #475569;
            line-height: 2;
        }
        .received .details strong {
            color: #0f172a;
        }

        /* ===== TABLE ===== */
        .table-wrap {
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        table.items thead th {
            background: #f1f5f9;
            color: #1e293b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px 15px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }
        table.items tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        table.items tbody tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }

        /* ===== TOTALS ===== */
        .totals {
            display: flex;
            justify-content: flex-end;
            padding-right: 15px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .totals table {
            width: 320px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .totals table td {
            padding: 8px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        .totals table .total-row td {
            font-weight: 800;
            font-size: 18px;
            color: #0f172a;
            border-bottom: 3px solid #22C55E;
            padding-top: 14px;
        }

        /* ===== STATUS ===== */
        .status-row {
            background: #f8fafc;
            border-radius: 8px;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            border: 1px solid #e2e8f0;
            position: relative;
            z-index: 1;
        }
        .status-label {
            font-weight: 700;
            font-size: 15px;
            color: #0f172a;
        }
        .paid-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 4px 24px;
            border-radius: 30px;
            font-weight: 800;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 13px;
            color: #64748b;
            position: relative;
            z-index: 1;
        }
        .footer .thank {
            font-weight: 600;
            font-size: 16px;
            color: #0f172a;
        }
        .footer .org-name {
            margin-top: 4px;
            font-size: 13px;
            color: #475569;
        }
        .footer .digital-note {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 6px;
            font-style: italic;
        }
        .footer .signature {
            text-align: right;
        }
        .footer .signature .title {
            font-weight: 600;
            color: #0f172a;
            font-size: 12px;
        }
        .footer .signature .line {
            width: 180px;
            border-top: 1px solid #94a3b8;
            margin-top: 8px;
            margin-left: auto;
        }

        @media print {
            body { padding: 10px; background: #fff; }
            .receipt-wrapper { border: none; box-shadow: none; padding: 15px; }
        }
    </style>
</head>
<body>
<div class="receipt-wrapper">

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="logo">
                <img src="{{ public_path('images/logo.png') }}" alt="HEAN Logo">
            </div>
            <div class="org">
                <div class="nepali-name">होस्टल व्यवसायी संघ नेपाल</div>
                <div class="main-name">Hostel Entrepreneurs Association Nepal</div>
                <div class="sub-name">HEAN</div>
                <div class="regd-no">Regd. No: 029/079/080 | PAN: 618525252</div>
            </div>
        </div>
        <div class="header-right">
            <div class="doc-type">RECEIPT</div>
            <div class="doc-meta">
                <div><strong>Receipt No:</strong> {{ $receipt->receipt_number }}</div>
                <div><strong>Date:</strong> {{ $receipt->issued_date->format('Y-m-d') }}</div>
            </div>
            <div class="org-details">
                New Baneshwor, Kathmandu<br>
                Contact: 01-5921615 / 9864164805
            </div>
        </div>
    </div>

    {{-- RECEIVED FROM --}}
    <div class="received">
        <div class="from">
            <div class="label">Received From</div>
            <div class="value">{{ $payment->registration->owner->name ?? $payment->registration->operator_name ?? 'N/A' }}</div>
            <div class="sub-value">{{ $payment->registration->hostel->name ?? $payment->registration->hostel_name ?? '' }}</div>
        </div>
        <div class="details">
            <div><strong>Registration #:</strong> {{ $payment->registration->registration_number ?? $payment->registration_id }}</div>
            @if($payment->invoice)
                <div><strong>Invoice:</strong> {{ $payment->invoice->invoice_number }}</div>
            @endif
            <div><strong>Payment Method:</strong> {{ ucfirst($payment->method) }}</div>
            <div><strong>Transaction ID:</strong> {{ $payment->transaction_id ?? 'N/A' }}</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrap">
        <table class="items">
            <thead>
                <tr>
                    <th style="width:8%;" class="text-center">#</th>
                    <th style="width:52%;">DESCRIPTION</th>
                    <th style="width:20%;">INVOICE NO.</th>
                    <th style="width:20%;" class="text-right">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Payment Received</td>
                    <td>{{ $payment->invoice->invoice_number ?? 'N/A' }}</td>
                    <td class="text-right">NPR {{ number_format($receipt->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- TOTALS --}}
    <div class="totals">
        <table>
            <tr>
                <td style="border-bottom: none; text-align:right;">Amount Paid</td>
                <td style="border-bottom: none; text-align:right;">NPR {{ number_format($receipt->amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td style="text-align:right;">Total Paid</td>
                <td style="text-align:right;">NPR {{ number_format($receipt->amount, 2) }}</td>
            </tr>
        </table>
    </div>

    {{-- STATUS --}}
    <div class="status-row">
        <span class="status-label">Payment Status</span>
        <span class="paid-badge">✅ Paid</span>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div>
            <div class="thank">Thank you for your payment.</div>
            <div class="org-name">Hostel Entrepreneurs Association Nepal</div>
            <div class="digital-note">🔹 This is a digitally generated receipt. No signature required.</div>
        </div>
        <div class="signature">
            <div class="title">— — —</div>
            <div style="font-size:11px; color:#94a3b8;">Machine Generated</div>
        </div>
    </div>

</div>
</body>
</html>