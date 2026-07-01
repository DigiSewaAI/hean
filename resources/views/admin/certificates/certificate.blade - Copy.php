<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEAN सदस्यता प्रमाणपत्र</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'dejavusans', sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .certificate-wrapper {
            max-width: 800px;
            width: 100%;
            background: #ffffff;
            border: 6px solid #1F2E5A;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            padding: 20px;
            position: relative;
            page-break-inside: avoid;
            overflow: hidden;
        }
        /* Watermark */
        .certificate-wrapper::before {
            content: "HEAN";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 120px;
            font-weight: 900;
            color: rgba(31, 46, 90, 0.06);
            letter-spacing: 15px;
            pointer-events: none;
            font-family: 'dejavusans', sans-serif;
        }
        .certificate-border {
            border: 3px solid #7B2D3A;
            border-radius: 12px;
            padding: 20px;
            background: #fcfaf6;
            position: relative;
            z-index: 1;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .logo-box {
            width: 70px;
            height: 70px;
            background: #1F2E5A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            font-size: 20px;
            text-transform: uppercase;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(31,46,90,0.3);
        }
        /* वास्तविक लोगोको लागि img tag प्रयोग गर्न सक्नुहुन्छ */
        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: contain;
        }
        .header-center {
            text-align: center;
            flex: 1;
            padding: 0 10px;
        }
        .org-name {
            font-size: 22px;
            font-weight: 700;
            color: #1F2E5A;
            line-height: 1.3;
            text-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .org-sub {
            font-size: 14px;
            font-weight: 400;
            color: #475569;
        }
        .org-contact {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }
        .header-right {
            text-align: right;
            flex-shrink: 0;
            min-width: 100px;
        }
        .cert-id {
            background: linear-gradient(135deg, #1F2E5A, #2F6B4F);
            color: #fff;
            padding: 5px 16px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            letter-spacing: 0.5px;
        }
        .qr-placeholder {
            margin-top: 6px;
            font-size: 10px;
            color: #1F2E5A;
            border: 1.5px solid #1F2E5A;
            border-radius: 4px;
            padding: 3px 8px;
            display: inline-block;
            background: #f0f0f0;
        }
        .divider {
            border: none;
            height: 2px;
            background: linear-gradient(to right, transparent, #1F2E5A 20%, #1F2E5A 80%, transparent);
            margin: 12px 0;
            opacity: 0.5;
        }

        /* Title Ribbon */
        .cert-title-wrapper {
            text-align: center;
            margin: 8px 0 14px;
        }
        .cert-title {
            display: inline-block;
            background: linear-gradient(135deg, #1F2E5A, #2F6B4F);
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            padding: 6px 36px;
            border-radius: 50px;
            letter-spacing: 2px;
            box-shadow: 0 6px 20px rgba(31,46,90,0.25);
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Body Text */
        .body-text {
            text-align: center;
            font-size: 17px;
            line-height: 2.2;
            color: #1e293b;
            margin: 12px 0 18px;
        }
        .highlight-name {
            font-weight: 700;
            color: #7B2D3A;
            font-size: 20px;
            border-bottom: 2px dashed #2F6B4F;
            padding: 0 8px;
            display: inline-block;
        }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 16px 0 20px;
        }
        .info-card {
            border: 2px solid #1F2E5A;
            border-radius: 10px;
            padding: 12px 16px;
            background: linear-gradient(135deg, #f8f6f0, #f0ede4);
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .info-card .label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            margin-bottom: 3px;
        }
        .info-card .value {
            font-weight: 600;
            color: #0f172a;
            font-size: 16px;
            word-break: break-word;
        }
        .info-card .value.empty {
            color: #94a3b8;
            font-weight: 300;
        }

        /* Footer Signatures */
        .signature-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 2px solid #e2e8f0;
        }
        .signature-block {
            text-align: center;
            flex: 1;
        }
        .signature-block .stamp {
            width: 60px;
            height: 60px;
            border: 2px dashed #2F6B4F;
            border-radius: 50%;
            margin: 0 auto 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            text-align: center;
            line-height: 1.3;
            background: #f8f6f0;
        }
        .signature-block .stamp.solid {
            border-style: solid;
        }
        .signature-block .stamp.maroon {
            border-color: #7B2D3A;
            color: #7B2D3A;
            background: #fdf6f4;
        }
        .signature-block .stamp.navy {
            border-color: #1F2E5A;
            color: #1F2E5A;
            background: #f4f6fa;
        }
        .signature-block .line {
            width: 100px;
            height: 2px;
            background: #1F2E5A;
            margin: 6px auto 3px;
        }
        .signature-block .label-text {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.5px;
        }

        .issued-date {
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #1F2E5A;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }

        /* Action Buttons (print हुँदा लुकाउने) */
        .no-print {
            text-align: center;
            margin-top: 16px;
        }
        .btn-pdf {
            display: inline-block;
            padding: 8px 20px;
            background: #1F2E5A;
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin: 0 4px;
            border: none;
            cursor: pointer;
            font-family: 'dejavusans', sans-serif;
            transition: 0.2s;
        }
        .btn-pdf:hover {
            background: #2F6B4F;
            transform: scale(1.02);
        }
        .btn-pdf.btn-print {
            background: #7B2D3A;
        }
        .btn-pdf.btn-print:hover {
            background: #5a1f2a;
        }
        .btn-pdf.btn-back {
            background: #64748b;
        }
        .btn-pdf.btn-back:hover {
            background: #475569;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .certificate-wrapper {
                box-shadow: none;
                border: 4px solid #1F2E5A;
                padding: 12px;
                border-radius: 8px;
                max-width: 100%;
                margin: 0;
            }
            .no-print {
                display: none !important;
            }
            .certificate-wrapper::before {
                font-size: 100px;
                opacity: 0.04;
            }
        }
    </style>
</head>
<body>
<div class="certificate-wrapper">
    <div class="certificate-border">
        <!-- Header -->
        <div class="header">
            <div class="logo-box">
                <!-- यहाँ लोगो इमेजको base64 डाटा राख्नुहोस् -->
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" alt="HEAN Logo" class="logo-img" style="width:70px;height:70px;border-radius:50%;object-fit:cover;">
            </div>
            <div class="header-center">
                <div class="org-name">होस्टेल व्यवसायी संघ नेपाल (HEAN)</div>
                <div class="org-sub">केन्द्रीय कार्यालय · काठमाडौं, नेपाल</div>
                <div class="org-contact">सम्पर्क: ०१-५९२१६१५ | दर्ता नं: {{ $certificate->registration_id ?? '—' }}</div>
            </div>
            <div class="header-right">
                <div class="cert-id">Cert. No: {{ $certificate->certificate_number ?? 'HEAN-'.date('Y').'-001' }}</div>
                <div class="qr-placeholder">QR</div>
            </div>
        </div>
        <hr class="divider">

        <!-- Title -->
        <div class="cert-title-wrapper">
            <span class="cert-title">सदस्यता प्रमाणपत्र</span>
        </div>

        <!-- Body -->
        <div class="body-text">
            श्री <span class="highlight-name">
                {{ $certificate->registration->owner->name ?? '—' }}
            </span> लाई <br>
            होस्टेल व्यवसायी संघ नेपालमा आबद्ध हुनुभएकोमा हार्दिक बधाई सहित <br>
            यो सदस्यता प्रमाणपत्र प्रदान गरिएको छ ।
        </div>

        <!-- Info Cards -->
        <div class="info-grid">
            <div class="info-card">
                <div class="label">सञ्चालकको नाम</div>
                <div class="value">{{ $certificate->registration->owner->name ?? '—' }}</div>
                <div class="label" style="margin-top:8px;">ठेगाना</div>
                <div class="value">{{ $certificate->registration->address ?? $certificate->registration->owner->address ?? '—' }}</div>
                <div class="label" style="margin-top:8px;">सम्पर्क नं.</div>
                <div class="value">{{ $certificate->registration->contact ?? $certificate->registration->owner->phone ?? '—' }}</div>
            </div>
            <div class="info-card">
                <div class="label">दर्ता नं.</div>
                <div class="value">{{ $certificate->registration_id ?? '—' }}</div>
                <div class="label" style="margin-top:8px;">स्थायी लेखा नं.</div>
                <div class="value">{{ $certificate->registration->pan ?? $certificate->registration->owner->pan ?? '—' }}</div>
                <div class="label" style="margin-top:8px;">जारी मिति</div>
                <div class="value">{{ $certificate->issued_date ? \Carbon\Carbon::parse($certificate->issued_date)->format('Y-m-d') : now()->format('Y-m-d') }}</div>
            </div>
        </div>

        <!-- Signatures -->
        <div class="signature-row">
            <div class="signature-block">
                <div class="stamp solid maroon">महासचिव</div>
                <div class="line"></div>
                <div class="label-text">महासचिव</div>
            </div>
            <div class="signature-block">
                <div class="stamp">छाप<br>HEAN</div>
                <div class="label-text">आधिकारिक छाप</div>
            </div>
            <div class="signature-block">
                <div class="stamp solid navy">अध्यक्ष</div>
                <div class="line"></div>
                <div class="label-text">अध्यक्ष</div>
            </div>
        </div>

        <div class="issued-date">
            मिति: {{ $certificate->issued_date ? \Carbon\Carbon::parse($certificate->issued_date)->format('Y-m-d') : now()->format('Y-m-d') }}
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="no-print">
    <a href="{{ route('admin.certificates.download', $certificate->id) }}" class="btn-pdf">⬇ PDF डाउनलोड</a>
    <button onclick="window.print()" class="btn-pdf btn-print">🖨 प्रिन्ट</button>
    <a href="{{ route('admin.certificate.index') }}" class="btn-pdf btn-back">⬅ फिर्ता</a>
</div>
</body>
</html>