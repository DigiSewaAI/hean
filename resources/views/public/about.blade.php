@extends('layouts.public')

@section('title', __('messages.about') . ' - HEAN')

@section('content')
<section class="about-section" style="padding-top:120px;">
    <div class="container">
        <div class="about-grid">
            <div class="about-image">
                <img src="{{ asset('images/about.jpg') }}" alt="About HEAN">
            </div>
            <div class="about-content">
                <span class="section-badge">{{ __('messages.about') }}</span>
                <h2>{{ __('messages.about_title') }}</h2>
                <p>{{ __('messages.about_desc') }}</p>
                <div class="about-features">
                    <div class="item"><span class="icon">✅</span> {{ __('messages.about_feature_1') }}</div>
                    <div class="item"><span class="icon">✅</span> {{ __('messages.about_feature_2') }}</div>
                    <div class="item"><span class="icon">✅</span> {{ __('messages.about_feature_3') }}</div>
                    <div class="item"><span class="icon">✅</span> {{ __('messages.about_feature_4') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection