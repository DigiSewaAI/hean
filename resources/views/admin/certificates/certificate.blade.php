<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>सदस्यता प्रमाण पत्र</title>
    <style>
        body {
            font-family: dejavusans, sans-serif;
            font-size: 11pt;
            color: #000000;
            background: #ffffff;
            margin: 0;
            padding: 10px;
        }

        table.main {
            width: 100%;
            border-collapse: collapse;
        }

        table.red-border {
            width: 100%;
            border: 6px solid #c0392b;
            border-collapse: collapse;
        }

        table.green-band {
            width: 100%;
            border: 4px solid #2d7a3a;
            border-collapse: collapse;
        }

        table.inner-red {
            width: 100%;
            border: 2px solid #c0392b;
            border-collapse: collapse;
        }

        td.flower {
            width: 14px;
            height: 14px;
            background-color: #2d7a3a;
            border: 1px solid #1a5c25;
            text-align: center;
            vertical-align: middle;
            padding: 0;
        }

        td.content-area {
            padding: 15px;
            vertical-align: top;
        }

        .logo-box {
            width: 90px;
            height: 100px;
            border: 2px solid #2d7a3a;
            background-color: #f0f8f0;
            text-align: center;
            vertical-align: middle;
            display: table-cell;
        }
        .logo-box img {
            max-width: 80px;
            max-height: 80px;
            display: block;
            margin: auto;
        }

        .photo-box {
            width: 100px;
            height: 140px;
            border: 2px solid #333333;
            background-color: #fafafa;
            font-size: 10pt;
            text-align: center;
            vertical-align: middle;
            display: table-cell;
        }
        .photo-box img {
            max-width: 90px;
            max-height: 130px;
            display: block;
            margin: auto;
        }

        .ribbon {
            background-color: #8b1a1a;
            color: #ffffff;
            font-size: 20pt;
            font-weight: bold;
            letter-spacing: 2px;
            padding: 12px;
        }

        .org-name {
            font-size: 26pt;
            font-weight: bold;
            color: #1a3a6b;
            letter-spacing: 1px;
        }

        .office-info {
            font-size: 16pt;
            font-weight: bold;
            color: #333333;
        }

        .location {
            font-size: 14pt;
            color: #555555;
        }

        .contact {
            font-size: 12pt;
            color: #555555;
        }

        .cert-number {
            font-size: 10pt;
            color: #333333;
        }

        .membership-no {
            font-size: 12pt;
        }

        /* ----- स्वागत पाठ ठूलो (अपडेट) ----- */
        .welcome-text {
            font-size: 14pt;        /* पहिले 12pt */
            line-height: 2.2;       /* पहिले 2 */
            padding: 4px 0;
        }

        table.field-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.field-table td.label {
            width: 180px;
            font-weight: bold;
            font-size: 12pt;
            padding: 6px;
            color: #222222;
        }
        table.field-table td.value {
            border-bottom: 1px solid #333333;
            font-size: 12pt;
            padding: 6px;
        }
        table.field-table td.value-dotted {
            border-bottom: 1px dotted #333333;
            font-size: 12pt;
            padding: 6px;
        }

        .pan-box {
            border: 1px solid #333333;
            width: 18px;
            height: 18px;
            text-align: center;
            font-size: 10pt;
            display: inline-block;
            margin: 0 1px;
        }

        .signature-line {
            border-bottom: 1px solid #333333;
            width: 140px;
        }
        .signature-label {
            font-size: 13pt;
            font-weight: bold;
            color: #222222;
            padding-top: 8px;
        }

        .date-section {
            font-size: 12pt;
            color: #222222;
        }

        .footer-note {
            font-size: 10pt;
            font-weight: bold;
            color: #333333;
            border-top: 1px solid #cccccc;
            padding-top: 10px;
        }

        .shri-line {
            font-size: 14pt;
            padding: 5px 0;
        }
    </style>
</head>
<body>

@php
    // ===== LOGO PATH =====
    $logoPath = public_path('images/logo.png');
    if (!file_exists($logoPath)) {
        $logoPath = public_path('logo.png');
    }
    if (!file_exists($logoPath)) {
        $logoPath = '';
    }

    // ===== PHOTO =====
    $photoSrc = '';
    if (isset($registration->photo) && $registration->photo) {
        $photoPath = public_path('storage/' . $registration->photo);
        if (file_exists($photoPath) && is_file($photoPath)) {
            $imageData = file_get_contents($photoPath);
            if ($imageData !== false) {
                $ext = strtolower(pathinfo($photoPath, PATHINFO_EXTENSION));
                $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'jpeg' : 'png';
                $photoSrc = 'data:image/' . $mime . ';base64,' . base64_encode($imageData);
            }
        }
    }

    // ===== PAN =====
    $pan = $registration->pan_number ?? $registration->pan ?? '';

    // ===== OPERATOR NAME =====
    $operatorName = $registration->operator_name ?? $registration->owner->name ?? '—';

    // ===== HOSTEL NAME =====
    $hostelName = $registration->hostel->name ?? $registration->hostel_name ?? '—';

    // ===== ADDRESS =====
    $addressParts = [];
    if ($registration->district) $addressParts[] = $registration->district;
    if ($registration->municipality) $addressParts[] = $registration->municipality;
    if ($registration->ward) $addressParts[] = 'वडा ' . $registration->ward;
    if ($registration->street) $addressParts[] = $registration->street;
    $address = !empty($addressParts) ? implode(', ', $addressParts) : '—';

    // ===== REGISTRATION NUMBER =====
    $regNumber = $registration->registration_number ?? '—';

    // ===== CONTACT =====
    $contact = $registration->contact ?? $registration->contact_number ?? $registration->owner->phone ?? '—';

    // ===== CERTIFICATE NUMBER & DATE =====
    $certNumber = $certificate->certificate_number ?? '—';
    $issuedDate = $certificate->issued_date ? \Carbon\Carbon::parse($certificate->issued_date)->format('Y-m-d') : now()->format('Y-m-d');
@endphp

<table class="main" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table class="red-border" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table class="green-band" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <!-- TOP FLOWER ROW -->
                                    <table cellpadding="0" cellspacing="2" align="center" style="width:100%; margin-bottom:6px;">
                                        <tr>
                                            @for($i = 0; $i < 50; $i++)
                                                <td class="flower">&nbsp;</td>
                                            @endfor
                                        </tr>
                                    </table>

                                    <!-- MIDDLE ROW -->
                                    <table cellpadding="0" cellspacing="0" style="width:100%;">
                                        <tr>
                                            <!-- LEFT FLOWER COLUMN -->
                                            <td style="width: 20px; vertical-align: top; padding: 0;">
                                                <table cellpadding="0" cellspacing="2">
                                                    @for($i = 0; $i < 42; $i++)
                                                        <tr><td class="flower">&nbsp;</td></tr>
                                                    @endfor
                                                </table>
                                            </td>

                                            <td style="width: 6px;">&nbsp;</td>

                                            <!-- MAIN CONTENT -->
                                            <td class="content-area">
                                                <table class="inner-red" cellpadding="20" cellspacing="0">
                                                    <tr>
                                                        <td>

                                                            <!-- Certificate Number (RIGHT) -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="right" class="cert-number">
    दर्ता नं. ०२९/०७९/०८०
</td>
                                                                </tr>
                                                            </table>

                                                            <br>

                                                            <!-- Organization Name (CENTER) -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="center" class="org-name">
                                                                        होस्टल व्यवसायी संघ नेपाल
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <br><br>

                                                            <!-- Top Row: Logo | Info | Photo -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td style="width: 110px; text-align: center; vertical-align: middle;">
                                                                        <table class="logo-box" cellpadding="0" cellspacing="0" align="center">
                                                                            <tr>
                                                                                <td align="center" valign="middle" style="text-align:center; vertical-align:middle;">
                                                                                    @if($logoPath && file_exists($logoPath))
                                                                                        <img src="{{ $logoPath }}" width="80" height="80" alt="Logo">
                                                                                    @else
                                                                                        <span style="font-size:24pt; font-weight:bold; color:#c0392b;">H</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" valign="middle">
                                                                        <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                            <tr><td align="center" class="office-info">केन्द्रीय कार्यालय</td></tr>
                                                                            <tr><td align="center" class="location">काठमाडौं, नेपाल</td></tr>
<tr><td align="center" class="contact">सम्पर्क नं. : ९८६४१६४८०५, ०१ - ५९२१६१५</td></tr>                                                                        </table>
                                                                    </td>
                                                                    <td style="width: 110px; text-align: center; vertical-align: middle;">
                                                                        <table class="photo-box" cellpadding="0" cellspacing="0" align="center">
                                                                            <tr>
                                                                                <td align="center" valign="middle" style="text-align:center; vertical-align:middle;">
                                                                                    @if($photoSrc)
                                                                                        <img src="{{ $photoSrc }}" width="90" height="130" alt="Photo">
                                                                                    @else
                                                                                        संचालकको<br>फोटो
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <br><br>

                                                            <!-- Ribbon -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="center" class="ribbon">
                                                                        सदस्यता प्रमाण पत्र
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <br><br><br>

                                                        

                                                            <br>

                                                            <!-- Shri Line (CENTER) -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="center" class="shri-line">
                                                                        श्री {{ $operatorName }} लाई
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <br>

                                                            <!-- Welcome Text (CENTER) – अब ठूलो फन्टमा -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="center" class="welcome-text">
                                                                        होस्टल व्यवसायी संघ नेपालमा आवद्ध हुनुभएकोमा हार्दिक बधाई सहित<br>
                                                                        यो प्रमाण पत्र प्रदान गरिएको छ ।
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <br><br>

                                                            <!-- Fields -->
                                                            <table class="field-table" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="label">संचालकको नाम :</td>
                                                                    <td class="value">{{ $operatorName }}</td>
                                                                </tr>
                                                            </table>

                                                            <table class="field-table" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="label">होस्टल नाम :</td>
                                                                    <td class="value">{{ $hostelName }}</td>
                                                                </tr>
                                                            </table>

                                                            <table class="field-table" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="label">ठेगाना :</td>
                                                                    <td class="value">{{ $address }}</td>
                                                                </tr>
                                                            </table>

                                                            <table class="field-table" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="label">स्थाई लेखा नं. (PAN) :</td>
                                                                    <td class="value">
                                                                        @if($pan)
                                                                            @foreach(str_split($pan) as $digit)
                                                                                <span class="pan-box">{{ $digit }}</span>
                                                                            @endforeach
                                                                        @else
                                                                            —
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="field-table" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="label">दर्ता नं. :</td>
                                                                    <td class="value">{{ $regNumber }}</td>
                                                                </tr>
                                                            </table>
                                                            <table class="field-table" cellpadding="0" cellspacing="0">
    <tr>
        <td class="label">स्थानीय दर्ता नं. :</td>
        <td class="value">{{ $registration->local_registration_number ?? '—' }}</td>
    </tr>
</table>


                                                            <table class="field-table" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="label">सम्पर्क नं. :</td>
                                                                    <td class="value-dotted">{{ $contact }}</td>
                                                                </tr>
                                                            </table>

                                                            <br><br><br>

                                                            <!-- Signatures (LEFT and RIGHT) -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="left" style="width:50%; vertical-align:bottom;">
                                                                        <table cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <div class="signature-line">&nbsp;</div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" class="signature-label">महासचिव</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="right" style="width:50%; vertical-align:bottom;">
                                                                        <table cellpadding="0" cellspacing="0" align="right">
                                                                            <tr>
                                                                                <td align="right">
                                                                                    <div class="signature-line">&nbsp;</div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="right" class="signature-label">अध्यक्ष</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <br><br>

                                                            <!-- Date (CENTER) -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="center" class="date-section">
                                                                        मिति : {{ $issuedDate }}
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <br>

                                                            <!-- Footer Note (CENTER) -->
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;">
                                                                <tr>
                                                                    <td align="center" class="footer-note">
                                                                        द्रष्टव्य : यो प्रमाणपत्र हरेक आर्थिक वर्ष भित्र नविकरण गर्नुपर्नेछ ।
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td style="width: 6px;">&nbsp;</td>

                                            <!-- RIGHT FLOWER COLUMN -->
                                            <td style="width: 20px; vertical-align: top; padding: 0;">
                                                <table cellpadding="0" cellspacing="2">
                                                    @for($i = 0; $i < 42; $i++)
                                                        <tr><td class="flower">&nbsp;</td></tr>
                                                    @endfor
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- BOTTOM FLOWER ROW -->
                                    <table cellpadding="0" cellspacing="2" align="center" style="width:100%; margin-top:6px;">
                                        <tr>
                                            @for($i = 0; $i < 50; $i++)
                                                <td class="flower">&nbsp;</td>
                                            @endfor
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>