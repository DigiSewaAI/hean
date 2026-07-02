<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'notosansdevanagari', 'Arial', sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #1e293b;
            padding: 30px;
            background: #ffffff;
        }
        .invoice-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px 35px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        /* ===== HEADER ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #22C55E;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .header-left .logo img {
            height: 60px;
            width: auto;
        }
        .header-left .org .main-name {
            font-size: 18px;
            font-weight: 800;
            color: #0b2b4a;
        }
        .header-left .org .sub-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e5f8e;
        }
        .header-right {
            text-align: right;
        }
        .header-right .doc-type {
            font-size: 26px;
            font-weight: 900;
            color: #22C55E;
            letter-spacing: 3px;
        }
        .header-right .doc-meta {
            margin-top: 6px;
            font-size: 13px;
            color: #475569;
            line-height: 1.8;
        }
        .header-right .doc-meta strong {
            color: #0f172a;
        }

        /* ===== DETAILS ===== */
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .details .left .label {
            font-weight: 700;
            font-size: 14px;
            color: #0f172a;
        }
        .details .left .value {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 4px;
        }
        .details .left .sub-value {
            font-weight: 400;
            font-size: 13px;
            color: #475569;
        }
        .details .right {
            text-align: right;
            font-size: 13px;
            color: #475569;
            line-height: 2;
        }
        .details .right strong {
            color: #0f172a;
        }

        /* ===== TABLE ===== */
        .table-wrap {
            margin-bottom: 25px;
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
            font-size: 12px;
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
        .footer .signature {
            text-align: right;
        }
        .footer .signature .title {
            font-weight: 700;
            color: #0f172a;
            font-size: 14px;
        }
        .footer .signature .line {
            width: 180px;
            border-top: 2px solid #0f172a;
            margin-top: 30px;
            margin-left: auto;
        }

        @media print {
            body { padding: 10px; }
            .invoice-wrapper { border: none; padding: 15px; }
        }
    </style>
</head>
<body>
<div class="invoice-wrapper">

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="logo">
                <img src="{{ public_path('images/logo.png') }}" alt="HEAN Logo">
            </div>
            <div class="org">
                <div class="main-name">Hostel Entrepreneurs Association Nepal</div>
                <div class="sub-name">HEAN</div>
            </div>
        </div>
        <div class="header-right">
            <div class="doc-type">INVOICE</div>
            <div class="doc-meta">
                <div><strong>Invoice #:</strong> {{ $invoiceNumber }}</div>
                <div><strong>Date:</strong> {{ now()->format('Y-m-d') }}</div>
            </div>
        </div>
    </div>

    {{-- DETAILS --}}
    <div class="details">
        <div class="left">
            <div class="label">Bill To</div>
            <div class="value">{{ $registration->owner->name ?? $registration->operator_name ?? 'N/A' }}</div>
            <div class="sub-value">{{ $registration->hostel->name ?? $registration->hostel_name ?? '' }}</div>
        </div>
        <div class="right">
            <div><strong>Registration #:</strong> {{ $registration->registration_number ?? '#'.$registration->id }}</div>
            @if($request->due_date)
                <div><strong>Due Date:</strong> {{ $request->due_date }}</div>
            @endif
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrap">
        <table class="items">
            <thead>
                <tr>
                    <th style="width:8%;">#</th>
                    <th style="width:52%;">DESCRIPTION</th>
                    <th style="width:20%;" class="text-right">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Membership Registration Fee</td>
                    <td class="text-right">NPR {{ number_format($request->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- TOTALS --}}
    <div class="totals">
        <table>
            <tr>
                <td style="border-bottom: none; text-align:right;">Total</td>
                <td style="border-bottom: none; text-align:right;">NPR {{ number_format($request->amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td style="text-align:right;">Total Due</td>
                <td style="text-align:right;">NPR {{ number_format($request->amount, 2) }}</td>
            </tr>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div>
            <div class="thank">Thank you for being a member of HEAN.</div>
            <div class="org-name">Hostel Entrepreneurs Association Nepal</div>
        </div>
        <div class="signature">
            <div class="title">Authorized Signature</div>
            <div class="line"></div>
        </div>
    </div>

</div>
</body>
</html>