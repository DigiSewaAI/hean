@extends('layouts.public')

@section('title', __('messages.contact') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:3rem; font-weight:800; margin-bottom:12px;">
            <i class="fas fa-phone-alt me-3"></i> @lang('messages.contact')
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto;">
            @lang('messages.contact_desc')
        </p>
    </div>
</section>

{{-- ===== MAIN CONTENT ===== --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; padding:16px 20px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ===== TWO COLUMN: FORM + MAP ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            {{-- LEFT: Contact Form --}}
            <div style="background:#f8fafc; border-radius:20px; padding:40px; box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <h3 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin-bottom:6px;">
                    <i class="fas fa-paper-plane" style="color:#0EA5E9; margin-right:10px;"></i> {{ __('messages.contact_form_title') }}
                </h3>
                <p style="color:#64748b; margin-bottom:25px; font-size:0.95rem;">{{ __('messages.contact_form_desc') }}</p>

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    {{-- Name Field --}}
                    <div class="form-group" style="margin-bottom:20px;">
                        <label for="name" style="font-weight:600; color:#1e293b; margin-bottom:6px; display:block;">
                            <i class="fas fa-user" style="color:#0EA5E9; width:20px;"></i> @lang('messages.contact_name') <span style="color:#dc2626;">*</span>
                        </label>
                        <div style="position:relative;">
                            <i class="fas fa-user" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                            <input type="text" name="name" id="name" class="form-control form-control-lg" 
                                   placeholder="@lang('messages.contact_name')" required
                                   style="padding-left:44px; border:1.5px solid #e2e8f0; border-radius:12px; font-size:1rem; transition:0.3s; width:100%;">
                        </div>
                    </div>

                    {{-- Email Field --}}
                    <div class="form-group" style="margin-bottom:20px;">
                        <label for="email" style="font-weight:600; color:#1e293b; margin-bottom:6px; display:block;">
                            <i class="fas fa-envelope" style="color:#0EA5E9; width:20px;"></i> @lang('messages.contact_email') <span style="color:#dc2626;">*</span>
                        </label>
                        <div style="position:relative;">
                            <i class="fas fa-envelope" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" 
                                   placeholder="@lang('messages.contact_email')" required
                                   style="padding-left:44px; border:1.5px solid #e2e8f0; border-radius:12px; font-size:1rem; transition:0.3s; width:100%;">
                        </div>
                    </div>

                    {{-- Message Field --}}
                    <div class="form-group" style="margin-bottom:25px;">
                        <label for="message" style="font-weight:600; color:#1e293b; margin-bottom:6px; display:block;">
                            <i class="fas fa-comment-dots" style="color:#0EA5E9; width:20px;"></i> @lang('messages.contact_message') <span style="color:#dc2626;">*</span>
                        </label>
                        <div style="position:relative;">
                            <i class="fas fa-comment-dots" style="position:absolute; left:16px; top:20px; color:#94a3b8;"></i>
                            <textarea name="message" id="message" rows="5" class="form-control form-control-lg" 
                                      placeholder="@lang('messages.contact_message')" required
                                      style="padding-left:44px; padding-top:14px; border:1.5px solid #e2e8f0; border-radius:12px; font-size:1rem; transition:0.3s; width:100%; resize:vertical;"></textarea>
                        </div>
                    </div>

                    <button type="submit" style="display:inline-flex; align-items:center; gap:10px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:14px 40px; border:none; border-radius:50px; font-weight:600; font-size:1.05rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3); width:100%; justify-content:center;">
                        <i class="fas fa-paper-plane"></i> @lang('messages.contact_send')
                    </button>
                </form>
            </div>

            {{-- RIGHT: Google Map --}}
            <div style="background:#f8fafc; border-radius:20px; padding:25px; box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <h3 style="font-size:1.3rem; font-weight:700; color:#0f172a; margin-bottom:15px;">
                    <i class="fas fa-map-marked-alt" style="color:#0EA5E9; margin-right:10px;"></i> {{ __('messages.contact_map_title') }}
                </h3>
                <div style="border-radius:16px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
                    <iframe 
                        src="https://www.google.com/maps/embed?q=Kathmandu-10+Nepal" 
                        width="100%" 
                        height="350" 
                        style="border:0; display:block;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div style="margin-top:15px; display:flex; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                    <span style="font-size:0.9rem; color:#64748b;">
                        <i class="fas fa-map-pin" style="color:#0EA5E9;"></i> {{ __('messages.contact_address') }}
                    </span>
                    <a href="https://maps.app.goo.gl/PQK1eXWibN9LzkaS6" target="_blank" style="color:#0EA5E9; text-decoration:none; font-weight:600; font-size:0.9rem;">
                        <i class="fas fa-external-link-alt"></i> {{ __('messages.contact_view_map') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== CONTACT INFO CARDS ===== --}}
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:20px; margin-top:40px;">
            <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; border:1px solid #e2e8f0; transition:0.3s;">
                <div style="width:55px; height:55px; background:#0EA5E9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                    <i class="fas fa-map-marker-alt" style="color:#fff; font-size:1.3rem;"></i>
                </div>
                <h5 style="font-weight:700; color:#0f172a; margin-bottom:4px;">@lang('messages.footer_address')</h5>
                <p style="color:#64748b; font-size:0.9rem; margin:0;">{{ __('messages.contact_address') }}</p>
            </div>
            <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; border:1px solid #e2e8f0; transition:0.3s;">
                <div style="width:55px; height:55px; background:#22C55E; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                    <i class="fas fa-phone-alt" style="color:#fff; font-size:1.3rem;"></i>
                </div>
                <h5 style="font-weight:700; color:#0f172a; margin-bottom:4px;">@lang('messages.footer_phone')</h5>
                <p style="color:#64748b; font-size:0.9rem; margin:0;">०१-५९२१६१५</p>
            </div>
            <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; border:1px solid #e2e8f0; transition:0.3s;">
                <div style="width:55px; height:55px; background:#8B5CF6; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                    <i class="fas fa-envelope" style="color:#fff; font-size:1.3rem;"></i>
                </div>
                <h5 style="font-weight:700; color:#0f172a; margin-bottom:4px;">@lang('messages.footer_email')</h5>
                <p style="color:#64748b; font-size:0.9rem; margin:0;">hostelsangh@gmail.com</p>
            </div>
            <div style="background:#f8fafc; border-radius:16px; padding:25px; text-align:center; border:1px solid #e2e8f0; transition:0.3s;">
                <div style="width:55px; height:55px; background:#F59E0B; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                    <i class="fas fa-clock" style="color:#fff; font-size:1.3rem;"></i>
                </div>
                <h5 style="font-weight:700; color:#0f172a; margin-bottom:4px;">@lang('messages.footer_office_hours')</h5>
                <p style="color:#64748b; font-size:0.9rem; margin:0;">{{ __('messages.contact_office_hours') }}</p>
            </div>
        </div>

        {{-- ===== QR CODE SECTION ===== --}}
<x-qr-section />

{{-- ===== CTA SECTION ===== --}}
<section style="padding:50px 0; background:linear-gradient(135deg, #0EA5E9, #10B981); color:#fff; text-align:center;">
    <div class="container">
        <h2 style="font-size:2rem; font-weight:700; margin-bottom:10px;">{{ __('messages.cta_title') }}</h2>
        <p style="opacity:0.9; max-width:500px; margin:0 auto 20px;">{{ __('messages.cta_desc') }}</p>
        <a href="{{ route('hostels.index') }}" style="display:inline-block; background:#fff; color:#0EA5E9; padding:14px 40px; border-radius:50px; font-weight:600; text-decoration:none; transition:0.3s; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
            <i class="fas fa-hotel me-2"></i> {{ __('messages.explore_network') }}
        </a>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Form input focus effect */
    .form-control:focus {
        border-color: #0EA5E9 !important;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12) !important;
        outline: none;
    }

    /* Contact info cards hover effect */
    .contact-page .bg-light:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    /* QR Section hover */
    .qr-section:hover {
        border-color: #0EA5E9 !important;
        transition: border-color 0.3s;
    }
</style>
@endpush