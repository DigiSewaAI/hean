@extends('layouts.admin')

@section('title', __('messages.content_management') . ' - HEAN Admin')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold mb-0" style="color: #0f172a;">
            <i class="fas fa-edit text-primary me-2" style="color: #0EA5E9 !important;"></i>
            {{ __('messages.content_management') }}
        </h1>
        <span class="text-muted">
            <i class="far fa-clock me-1"></i>
            {{ __('messages.last_updated') }}: {{ now()->format('M d, Y H:i') }}
        </span>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('messages.close') }}"></button>
        </div>
    @endif

    <!-- Main Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3" style="background: linear-gradient(135deg, #0EA5E9, #3B82F6) !important; color: white;">
            <i class="fas fa-sliders-h me-2"></i> {{ __('messages.homepage_content_settings') }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cms.update') }}" method="POST">
                @csrf

                <!-- ===== Hero Section ===== -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3" style="color: #0EA5E9;">
                        <i class="fas fa-star me-2"></i> {{ __('messages.hero_section') }}
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hero_title" class="form-label fw-semibold text-muted text-uppercase small">
                                    <i class="fas fa-heading me-1"></i> {{ __('messages.cms_hero_title') }}
                                </label>
                                <input type="text" class="form-control form-control-lg" id="hero_title" name="hero_title"
                                       value="{{ $settings['hero_title'] ?? '' }}" placeholder="{{ __('messages.placeholder_hero_title') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hero_badge" class="form-label fw-semibold text-muted text-uppercase small">
                                    <i class="fas fa-tag me-1"></i> {{ __('messages.cms_hero_badge') }}
                                </label>
                                <input type="text" class="form-control form-control-lg" id="hero_badge" name="hero_badge"
                                       value="{{ $settings['hero_badge'] ?? '' }}" placeholder="{{ __('messages.placeholder_hero_badge') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="hero_subtitle" class="form-label fw-semibold text-muted text-uppercase small">
                                    <i class="fas fa-align-left me-1"></i> {{ __('messages.cms_hero_subtitle') }}
                                </label>
                                <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="3"
                                          placeholder="{{ __('messages.placeholder_hero_subtitle') }}">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-2 opacity-25" style="border-color: #0EA5E9;">

                <!-- ===== About Section ===== -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3" style="color: #22C55E;">
                        <i class="fas fa-info-circle me-2"></i> {{ __('messages.about_section') }}
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="about_title" class="form-label fw-semibold text-muted text-uppercase small">
                                    <i class="fas fa-heading me-1"></i> {{ __('messages.cms_about_title') }}
                                </label>
                                <input type="text" class="form-control form-control-lg" id="about_title" name="about_title"
                                       value="{{ $settings['about_title'] ?? '' }}" placeholder="{{ __('messages.placeholder_about_title') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="about_content" class="form-label fw-semibold text-muted text-uppercase small">
                                    <i class="fas fa-align-left me-1"></i> {{ __('messages.cms_about_content') }}
                                </label>
                                <textarea class="form-control" id="about_content" name="about_content" rows="5"
                                          placeholder="{{ __('messages.placeholder_about_content') }}">{{ $settings['about_content'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-2 opacity-25" style="border-color: #22C55E;">

                <!-- ===== CTA Section ===== -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3" style="color: #8B5CF6;">
                        <i class="fas fa-bullhorn me-2"></i> {{ __('messages.call_to_action') }}
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cta_title" class="form-label fw-semibold text-muted text-uppercase small">
                                    <i class="fas fa-heading me-1"></i> {{ __('messages.cms_cta_title') }}
                                </label>
                                <input type="text" class="form-control form-control-lg" id="cta_title" name="cta_title"
                                       value="{{ $settings['cta_title'] ?? '' }}" placeholder="{{ __('messages.placeholder_cta_title') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="cta_content" class="form-label fw-semibold text-muted text-uppercase small">
                                    <i class="fas fa-align-left me-1"></i> {{ __('messages.cms_cta_content') }}
                                </label>
                                <textarea class="form-control" id="cta_content" name="cta_content" rows="3"
                                          placeholder="{{ __('messages.placeholder_cta_content') }}">{{ $settings['cta_content'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Submit Button -->
                <div class="d-flex gap-3 flex-wrap">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fs-6"
                            style="background: linear-gradient(135deg, #0EA5E9, #3B82F6); border: none; box-shadow: 0 4px 15px rgba(14,165,233,0.3); transition: 0.3s;">
                        <i class="fas fa-save me-2"></i> {{ __('messages.cms_save') }}
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-times me-2"></i> {{ __('messages.cancel') }}
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Tip Box -->
    <div class="card border-0 shadow-sm mt-4 bg-light">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="fas fa-lightbulb text-warning fs-3 me-3"></i>
                <div>
                    <h6 class="fw-bold mb-1">{{ __('messages.quick_tip') }}</h6>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                        {{ __('messages.changes_appear_immediately') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Inline Styles for CMS -->
<style>
    .card {
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .card-header {
        border-bottom: none;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .card-body {
        background: #ffffff;
    }
    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: 0.3s;
        background-color: #f8fafc;
    }
    .form-control:focus {
        border-color: #0EA5E9;
        box-shadow: 0 0 0 4px rgba(14,165,233,0.12);
        background-color: #ffffff;
    }
    .form-control-lg {
        font-size: 1.1rem;
    }
    textarea.form-control {
        min-height: 100px;
    }
    .btn-primary {
        transition: all 0.2s ease;
    }
    .btn-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(14,165,233,0.4) !important;
    }
    .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
    .form-label {
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 4px;
    }
    hr {
        opacity: 0.3;
        margin: 1.5rem 0;
    }
    .bg-light {
        background-color: #f8fafc !important;
    }
    .alert {
        border-radius: 12px;
        padding: 1rem 1.5rem;
    }
    .alert-success {
        background-color: #d1fae5;
        border-color: #10b981;
        color: #065f46;
    }
    .alert-success .btn-close {
        filter: brightness(0.5);
    }
</style>
@endsection