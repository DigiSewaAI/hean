@extends('layouts.admin')

@section('title', 'रिपोर्टहरू - HEAN Admin')

@section('content')
<h2>रिपोर्टहरू</h2>
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; margin-bottom:30px;">
    <div class="stat-card"><div class="num">{{ $totalHostels ?? 0 }}</div><div class="label">कुल होस्टेल</div></div>
    <div class="stat-card"><div class="num">{{ $approvedHostels ?? 0 }}</div><div class="label">स्वीकृत होस्टेल</div></div>
    <div class="stat-card"><div class="num">{{ $pendingRegistrations ?? 0 }}</div><div class="label">पेन्डिङ आवेदन</div></div>
</div>

<h3>जिल्ला अनुसार होस्टेल</h3>
<table class="table-container">
    <thead><tr><th>जिल्ला</th><th>संख्या</th></tr></thead>
    <tbody>
        @forelse($districtStats ?? [] as $stat)
        <tr><td>{{ $stat->district }}</td><td>{{ $stat->total }}</td></tr>
        @empty
        <tr><td colspan="2">कुनै डाटा छैन।</td></tr>
        @endforelse
    </tbody>
</table>
@endsection