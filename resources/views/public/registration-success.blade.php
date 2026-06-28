@extends('layouts.public')

@section('title', 'Registration Successful - HEAN')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-4 text-center p-5" style="border-top: 6px solid #22C55E;">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 90px; height: 90px; background: #22C55E;">
                        <i class="fas fa-check-circle text-white" style="font-size: 44px;"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-success">Registration Submitted!</h2>
                <p class="fs-5 text-muted">Your hostel registration has been received.</p>
                <div class="bg-light p-3 rounded-3 d-inline-block mx-auto my-3">
                    <span class="text-muted">Registration ID</span>
                    <div class="fw-bold fs-3 text-primary">#{{ $registration->id }}</div>
                </div>
                <p class="text-muted">We will review your application and contact you soon.</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5 rounded-pill mt-3">
                    <i class="fas fa-home me-2"></i> Go to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection