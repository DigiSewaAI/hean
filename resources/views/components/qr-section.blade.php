{{-- ===== QR & PAYMENT SECTION (Side by Side) ===== --}}
<section class="qr-payment-section" style="padding:50px 0; background:#f8fafc;">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px; max-width:1000px; margin:0 auto;">

            {{-- ===== LEFT: REGISTRATION QR (Blue) ===== --}}
            <div style="background:#fff; padding:30px; border-radius:20px; box-shadow:0 4px 20px rgba(0,0,0,0.06); text-align:center;">
                <span style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 18px; border-radius:50px; font-size:0.8rem; font-weight:600; margin-bottom:12px; letter-spacing:0.03em;">
                    <i class="fas fa-qrcode me-2"></i> {{ __('messages.qr_badge') }}
                </span>
                <h3 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin-bottom:8px;">{{ __('messages.qr_heading') }}</h3>
                <p style="color:#64748b; font-size:0.95rem; max-width:350px; margin:0 auto 20px;">{{ __('messages.qr_desc') }}</p>

                <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:20px;">
                    {{-- QR Code --}}
                    <div style="background:#f8fafc; padding:15px; border-radius:12px;">
                        <img src="{{ asset('images/qrcode.png') }}" alt="Register QR" style="width:120px; height:120px; display:block;">
                    </div>

                    <span style="color:#94a3b8; font-weight:600;">{{ __('messages.or') }}</span>

                    {{-- Register Button --}}
                    <a href="{{ route('register.hostel') }}" 
                       style="background:#0EA5E9; color:#fff; padding:12px 28px; border-radius:50px; font-weight:600; text-decoration:none; display:inline-block; transition:0.3s; font-size:0.9rem; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                        <i class="fas fa-pen me-2"></i> {{ __('messages.register_direct') }}
                    </a>
                </div>

                <p style="color:#94a3b8; font-size:0.8rem; margin-top:12px;">
                    <i class="fas fa-camera me-1"></i> {{ __('messages.qr_after_scan') }}
                </p>
            </div>

            {{-- ===== RIGHT: PAYMENT QR (Green) ===== --}}
            <div style="background:#fff; padding:30px; border-radius:20px; box-shadow:0 4px 20px rgba(0,0,0,0.06); text-align:center; border:2px solid rgba(16,185,129,0.15);">
                <span style="display:inline-block; background:#10B981; color:#fff; padding:6px 18px; border-radius:50px; font-size:0.8rem; font-weight:600; margin-bottom:12px; letter-spacing:0.03em;">
                    <i class="fas fa-credit-card me-2"></i> {{ __('messages.payment_badge') }}
                </span>
                <h3 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin-bottom:8px;">{{ __('messages.payment_heading') }}</h3>
                <p style="color:#64748b; font-size:0.95rem; max-width:350px; margin:0 auto 20px;">{{ __('messages.payment_desc') }}</p>

                <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:20px;">
                    {{-- Payment QR --}}
                    <div style="background:#f8fafc; padding:15px; border-radius:12px;">
                        <img src="{{ asset('images/payment-qr.png') }}" alt="Payment QR" style="width:120px; height:120px; display:block;">
                    </div>

                    <span style="color:#94a3b8; font-weight:600;">{{ __('messages.or') }}</span>

                    {{-- Pay Now Button --}}
                    <a href="{{ url('/payment') }}" 
                       style="background:#10B981; color:#fff; padding:12px 28px; border-radius:50px; font-weight:600; text-decoration:none; display:inline-block; transition:0.3s; font-size:0.9rem; box-shadow:0 4px 15px rgba(16,185,129,0.3);">
                        <i class="fas fa-arrow-right me-2"></i> {{ __('messages.pay_now') }}
                    </a>
                </div>

                <p style="color:#94a3b8; font-size:0.8rem; margin-top:12px;">
                    <i class="fas fa-shield-alt me-1"></i> {{ __('messages.payment_secure') }}
                </p>
            </div>

        </div>
    </div>
</section>