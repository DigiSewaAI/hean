@extends('layouts.admin')

@section('title', __('messages.admin_dashboard') . ' - HEAN Admin')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="num">{{ $totalHostels ?? 0 }}</div>
        <div class="label">{{ __('messages.admin_total_hostels') }}</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $pendingRegistrations ?? 0 }}</div>
        <div class="label">{{ __('messages.admin_pending_registrations') }}</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $inspectionsPending ?? 0 }}</div>
        <div class="label">{{ __('messages.admin_inspections_pending') }}</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $members ?? 0 }}</div>
        <div class="label">{{ __('messages.admin_members') }}</div>
    </div>
</div>

<!-- Chart placeholder -->
<div style="background:#fff; border-radius:16px; padding:30px; margin-top:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <h4>{{ __('messages.monthly_registrations') ?? 'Monthly Registrations' }}</h4>
    <canvas id="dashboardChart" height="100"></canvas>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: '{{ __('messages.registrations') ?? "Registrations" }}',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#f97316',
                    tension: 0.4
                }]
            }
        });
    });
</script>
@endpush