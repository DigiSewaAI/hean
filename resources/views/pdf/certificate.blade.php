<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; text-align: center; }
        .certificate { border: 5px double #0EA5E9; padding: 40px; margin: 20px; }
        h1 { color: #0EA5E9; font-size: 32px; }
        .content { font-size: 18px; margin: 30px 0; }
        .footer { margin-top: 50px; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>HEAN</h1>
        <h2>Certificate of Membership</h2>
        <p>This is to certify that</p>
        <h3>{{ $registration->owner->name ?? '' }}</h3>
        <p>Owner of <strong>{{ $registration->hostel->name ?? '' }}</strong></p>
        <p>has been officially registered as a member of</p>
        <h2>Hostel Entrepreneur Association of Nepal (HEAN)</h2>
        {{-- ✅ 8.3: दर्ता नम्बर (फलब्याक #ID) --}}
        <p><strong>दर्ता नम्बर:</strong> {{ $registration->registration_number ?? '#'.$registration->id }}</p>
        <p><strong>Issued on:</strong> {{ now()->format('F d, Y') }}</p>
        <div class="footer">
            <p>This certificate is the property of HEAN.</p>
        </div>
    </div>
</body>
</html>