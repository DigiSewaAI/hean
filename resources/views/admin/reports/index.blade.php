@extends('layouts.admin')

@section('title', __('messages.admin_reports_title') . ' - HEAN Admin')

@section('content')
<h2>{{ __('messages.admin_reports_title') }}</h2>
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; margin-bottom:30px;">
    <div class="stat-card"><div class="num">{{ $totalHostels ?? 0 }}</div><div class="label">{{ __('messages.total_hostels') }}</div></div>
    <div class="stat-card"><div class="num">{{ $approvedHostels ?? 0 }}</div><div class="label">{{ __('messages.approved_hostels') }}</div></div>
    <div class="stat-card"><div class="num">{{ $pendingRegistrations ?? 0 }}</div><div class="label">{{ __('messages.pending_registrations') }}</div></div>
</div>

<h3>{{ __('messages.hostels_by_district') }}</h3>
<table class="table-container">
    <thead><tr><th>{{ __('messages.district') }}</th><th>{{ __('messages.count') }}</th></tr></thead>
    <tbody>
        @forelse($districtStats ?? [] as $stat)
        <tr><td>{{ $stat->district }}</td><td>{{ $stat->total }}</td></tr>
        @empty
        <tr><td colspan="2">{{ __('messages.no_data_available') }}</td></tr>
        @endforelse
    </tbody>
</table>
@endsection