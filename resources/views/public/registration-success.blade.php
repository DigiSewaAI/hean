@extends('layouts.public')

@section('title', 'Registration Submitted Successfully - HEAN')

@section('content')

{{-- ✅ Fixed: Navbar को लागि margin-top थपियो --}}
<div style="margin-top: 120px; padding: 20px 0 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                {{-- ===== SUCCESS CARD ===== --}}
                <div style="background:#ffffff; border-radius:24px; box-shadow:0 20px 60px rgba(0,0,0,0.06); padding:50px 40px; text-align:center; position:relative; overflow:hidden; border-top:6px solid #22C55E;">

                    {{-- Decorative background --}}
                    <div style="position:absolute; top:-80px; right:-80px; width:250px; height:250px; background:radial-gradient(circle, rgba(34,197,94,0.05) 0%, transparent 70%); border-radius:50%; pointer-events:none;"></div>
                    <div style="position:absolute; bottom:-60px; left:-60px; width:200px; height:200px; background:radial-gradient(circle, rgba(14,165,233,0.04) 0%, transparent 70%); border-radius:50%; pointer-events:none;"></div>

                    {{-- Success Icon --}}
                    <div style="margin-bottom:24px; position:relative; z-index:1;">
                        <div style="display:inline-flex; align-items:center; justify-content:center; width:100px; height:100px; border-radius:50%; background:linear-gradient(135deg, #22C55E, #16A34A); box-shadow:0 8px 30px rgba(34,197,94,0.3);">
                            <i class="fas fa-check-circle" style="color:#fff; font-size:48px;"></i>
                        </div>
                    </div>

                    {{-- Title --}}
                    <h1 style="font-size:2.2rem; font-weight:800; color:#0f172a; margin-bottom:6px; letter-spacing:-0.5px; position:relative; z-index:1;">
                        🎉 Registration Submitted!
                    </h1>

                    {{-- Subtitle --}}
                    <p style="font-size:1.1rem; color:#64748b; margin-bottom:20px; position:relative; z-index:1;">
                        Your hostel registration has been received successfully.
                    </p>

                    {{-- Divider --}}
                    <div style="width:60px; height:3px; background:linear-gradient(90deg, #22C55E, #0EA5E9); border-radius:4px; margin:0 auto 24px;"></div>

                    {{-- आवेदन ID --}}
                    <div style="display:inline-block; background:#f0f9ff; border:2px dashed #0EA5E9; border-radius:16px; padding:16px 32px; margin-bottom:24px; position:relative; z-index:1;">
                        <span style="display:block; font-size:0.75rem; text-transform:uppercase; color:#64748b; font-weight:600; letter-spacing:0.5px;">
                            <i class="fas fa-id-card" style="color:#0EA5E9;"></i> आवेदन ID
                        </span>
                        <span style="display:block; font-size:2.5rem; font-weight:800; color:#0EA5E9; letter-spacing:1px;">
                            #{{ $registration->id }}
                        </span>
                        <span style="display:block; font-size:0.85rem; font-weight:600; color:#F59E0B; margin-top:4px;">
                            ⏳ स्थिति: पेन्डिङ (Pending)
                        </span>
                        <span style="display:block; font-size:0.7rem; color:#94a3b8; margin-top:2px;">
                            पूर्ण दर्ता नम्बर स्वीकृत पछि प्राप्त हुनेछ
                        </span>
                    </div>

                    {{-- ✅ QR Code (Only QR – No buttons) --}}
                    <div style="margin:20px auto; display:inline-block; background:#fff; padding:12px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
                        <img src="{{ asset('images/payment-qr.png') }}" alt="Payment QR Code" style="width:150px; height:150px; object-fit:contain; display:block;">
                    </div>
                    <p style="font-size:0.85rem; color:#94a3b8; margin-top:8px;">
                        <i class="fas fa-qrcode" style="color:#0EA5E9;"></i> QR स्क्यान गरेर भुक्तानी गर्नुहोस्
                    </p>

                    {{-- Status Info --}}
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:28px; position:relative; z-index:1;">
                        <div style="background:#f8fafc; border-radius:12px; padding:14px 10px; border:1px solid #e2e8f0;">
                            <div style="font-size:1.2rem; margin-bottom:2px;">⏳</div>
                            <div style="font-size:0.8rem; color:#94a3b8; font-weight:500;">Status</div>
                            <div style="font-weight:700; color:#F59E0B; font-size:0.9rem;">Pending</div>
                        </div>
                        <div style="background:#f8fafc; border-radius:12px; padding:14px 10px; border:1px solid #e2e8f0;">
                            <div style="font-size:1.2rem; margin-bottom:2px;">🏨</div>
                            <div style="font-size:0.8rem; color:#94a3b8; font-weight:500;">Hostel</div>
                            <div style="font-weight:700; color:#0f172a; font-size:0.9rem;">{{ $registration->hostel_name ?? 'N/A' }}</div>
                        </div>
                        <div style="background:#f8fafc; border-radius:12px; padding:14px 10px; border:1px solid #e2e8f0;">
                            <div style="font-size:1.2rem; margin-bottom:2px;">👤</div>
                            <div style="font-size:0.8rem; color:#94a3b8; font-weight:500;">Owner</div>
                            <div style="font-weight:700; color:#0f172a; font-size:0.9rem;">{{ $registration->operator_name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    {{-- Next Steps Message --}}
                    <div style="background:#f8fafc; border-radius:12px; padding:16px 20px; margin-bottom:28px; text-align:left; border-left:4px solid #0EA5E9; position:relative; z-index:1;">
                        <p style="margin:0; font-size:0.95rem; color:#475569; line-height:1.7;">
                            <i class="fas fa-info-circle" style="color:#0EA5E9; margin-right:8px;"></i>
                            <strong>Next Steps:</strong> Our team will review your application and contact you within <strong>24-48 hours</strong>. You will receive a confirmation email once your registration is approved.
                        </p>
                    </div>

                    {{-- Navigation Buttons (Safe public routes only) --}}
                    <div style="display:flex; flex-wrap:wrap; gap:12px; justify-content:center; position:relative; z-index:1;">
                        <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:12px 32px; border-radius:50px; font-weight:600; font-size:1rem; text-decoration:none; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                            <i class="fas fa-home"></i> Go to Home
                        </a>
                        <a href="{{ route('hostels.index') }}" style="display:inline-flex; align-items:center; gap:8px; background:#e2e8f0; color:#1e293b; padding:12px 32px; border-radius:50px; font-weight:600; font-size:1rem; text-decoration:none; transition:0.3s;">
                            <i class="fas fa-hotel"></i> Browse Hostels
                        </a>
                    </div>

                    {{-- Footer Note --}}
                    <div style="margin-top:24px; padding-top:20px; border-top:1px solid #e2e8f0; position:relative; z-index:1;">
                        <p style="color:#94a3b8; font-size:0.8rem; margin:0;">
                            <i class="fas fa-envelope" style="color:#22C55E;"></i>
                            A confirmation email has been sent to your registered email address.
                        </p>
                        <p style="color:#94a3b8; font-size:0.75rem; margin:4px 0 0;">
                            <i class="fas fa-print"></i> कृपया यो दर्ता नम्बर भविष्यको लागि सुरक्षित राख्नुहोस्।
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Card hover effect */
    .success-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .success-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 30px 80px rgba(0,0,0,0.08) !important;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .container .col-lg-8 {
            padding: 0 12px;
        }
        .card-body {
            padding: 30px 20px !important;
        }
        .status-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        .btn {
            width: 100%;
            justify-content: center;
        }
        h1 {
            font-size: 1.8rem !important;
        }
        .registration-id {
            font-size: 2rem !important;
        }
        /* QR code mobile adjustment */
        .qr-code-img {
            width: 120px !important;
            height: 120px !important;
        }
    }
</style>
@endpush