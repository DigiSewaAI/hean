<section class="qr-section" style="padding:50px 0; background:#f8fafc; text-align:center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <span class="badge" style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 18px; border-radius:50px; font-size:0.8rem; font-weight:600; margin-bottom:12px; letter-spacing:0.03em;">
                    <i class="fas fa-qrcode me-2"></i> {{ __('messages.qr_badge') }}
                </span>
                <h3 style="font-size:2rem; font-weight:700; color:#0f172a; margin-bottom:12px; letter-spacing:0.02em; line-height:1.4; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                    {{ __('messages.qr_heading') }}
                </h3>
                <p style="color:#64748b; font-size:1.1rem; max-width:500px; margin:0 auto 24px; letter-spacing:0.02em; line-height:1.7; font-family:'Noto Sans Devanagari', 'Inter', sans-serif;">
                    {{ __('messages.qr_desc') }}
                </p>

                {{-- QR Code + Direct Link (Side by side) --}}
                <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:30px;">

                    {{-- QR Code --}}
                    <div style="background:#fff; padding:20px; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.06); display:inline-block;">
                        <img src="{{ asset('images/qrcode.png') }}" alt="{{ __('messages.qr_badge') }}" style="width:160px; height:160px; display:block; margin:0 auto;">
                    </div>

                    {{-- OR Divider --}}
                    <span style="color:#94a3b8; font-weight:600;">{{ __('messages.or') }}</span>

                    {{-- Direct Registration Button --}}
                    <a href="{{ route('register') }}" 
                       class="btn btn-primary" 
                       style="background:#0EA5E9; color:#fff; padding:14px 34px; border-radius:50px; font-weight:600; text-decoration:none; display:inline-block; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                        <i class="fas fa-pen me-2"></i> {{ __('messages.register_direct') }}
                    </a>
                </div>

                <p style="color:#94a3b8; font-size:0.85rem; margin-top:16px; letter-spacing:0.02em;">
                    <i class="fas fa-camera me-1"></i> {{ __('messages.qr_after_scan') }}
                </p>
            </div>
        </div>
    </div>
</section>