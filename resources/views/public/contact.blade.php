@extends('layouts.public')

@section('title', __('messages.contact') . ' - HEAN')

@section('content')
<section class="contact-page" style="padding-top:120px; min-height:80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <span class="badge bg-primary px-3 py-2 mb-3" style="font-size:1rem;">@lang('messages.contact')</span>
                    <h1 class="display-4 fw-bold">@lang('messages.contact_title')</h1>
                    <p class="lead text-muted">@lang('messages.contact_desc')</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">@lang('messages.contact_name')</label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="@lang('messages.contact_name')" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">@lang('messages.contact_email')</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="@lang('messages.contact_email')" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label fw-semibold">@lang('messages.contact_message')</label>
                                <textarea name="message" id="message" rows="5" class="form-control form-control-lg" placeholder="@lang('messages.contact_message')" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                @lang('messages.contact_send')
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Info Cards -->
                <div class="row mt-5 g-4">
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded-3">
                            <i class="fas fa-map-marker-alt text-primary fs-2 mb-2"></i>
                            <p class="fw-semibold">@lang('messages.footer_address')</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded-3">
                            <i class="fas fa-phone text-primary fs-2 mb-2"></i>
                            <p class="fw-semibold">@lang('messages.footer_phone')</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded-3">
                            <i class="fas fa-envelope text-primary fs-2 mb-2"></i>
                            <p class="fw-semibold">@lang('messages.footer_email')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .contact-page .form-control {
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
    }
    .contact-page .form-control:focus {
        border-color: #0EA5E9;
        box-shadow: 0 0 0 3px rgba(14,165,233,0.15);
    }
    .contact-page .card {
        border-radius: 16px;
    }
    .contact-page .btn-primary {
        background: #0EA5E9;
        border: none;
        border-radius: 50px;
        padding: 14px;
        font-weight: 600;
        transition: 0.3s;
    }
    .contact-page .btn-primary:hover {
        background: #0284C7;
        transform: translateY(-2px);
    }
</style>
@endpush