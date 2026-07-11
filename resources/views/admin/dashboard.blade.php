@extends('layouts.admin')

@section('title', __('messages.admin_dashboard') . ' - HEAN Admin')

@section('content')

{{-- =============================================================
    CHECK DATA AVAILABILITY
    ============================================================= --}}
@php
    $hasMonthlyData = isset($monthlyRegistrations) && $monthlyRegistrations->isNotEmpty() && $monthlyRegistrations->sum('count') > 0;
    $hasTypeData = isset($typeDistribution) && $typeDistribution->isNotEmpty() && $typeDistribution->sum() > 0;
    $hasStatusData = isset($statusDistribution) && $statusDistribution->isNotEmpty() && $statusDistribution->sum() > 0;
    $hasRevenueData = isset($monthlyRevenue) && $monthlyRevenue->isNotEmpty() && $monthlyRevenue->sum('total') > 0;
@endphp

{{-- =============================================================
    ALERTS / NOTIFICATIONS
    ============================================================= --}}
@if(!empty($alerts) && count($alerts) > 0)
    <div style="margin-bottom:20px;">
        @foreach($alerts as $alert)
            <div style="background:{{ $alert['type'] == 'danger' ? '#fef2f2' : ($alert['type'] == 'warning' ? '#fef3c7' : '#eff6ff') }}; 
                        border-left:5px solid {{ $alert['type'] == 'danger' ? '#dc2626' : ($alert['type'] == 'warning' ? '#f59e0b' : '#3b82f6') }};
                        padding:12px 18px; border-radius:8px; margin-bottom:8px; 
                        display:flex; align-items:center; gap:12px;">
                <span style="font-size:1.2rem;">{{ $alert['icon'] ?? '⚠️' }}</span>
                <span style="color:{{ $alert['type'] == 'danger' ? '#991b1b' : ($alert['type'] == 'warning' ? '#92400e' : '#1e40af') }}; font-size:0.9rem; flex:1;">
                    {!! $alert['message'] !!}
                    @if(isset($alert['link']))
                        <a href="{{ $alert['link'] }}" style="font-weight:600; text-decoration:underline; margin-left:8px; color:inherit;">
                            {{ __('messages.view_details') }}
                        </a>
                    @endif
                </span>
                <button onclick="this.parentElement.style.display='none'" style="background:none; border:none; color:#94a3b8; cursor:pointer; font-size:1.2rem;">×</button>
            </div>
        @endforeach
    </div>
@endif

{{-- =============================================================
    PRIMARY STATS GRID (6 Cards)
    ============================================================= --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:14px; margin-bottom:18px;">
    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:12px;">
        <div style="background:#0EA5E9; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-hotel" style="font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:1.4rem; font-weight:700; color:#0f172a;">{{ number_format($totalHostels ?? 0) }}</div>
            <div style="font-size:0.65rem; color:#64748b; text-transform:uppercase;">{{ __('messages.total_hostels') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:12px;">
        <div style="background:#F59E0B; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-clock" style="font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:1.4rem; font-weight:700; color:#0f172a;">{{ number_format($pendingRegistrations ?? 0) }}</div>
            <div style="font-size:0.65rem; color:#64748b; text-transform:uppercase;">{{ __('messages.pending_registrations') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:12px;">
        <div style="background:#8B5CF6; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-clipboard-list" style="font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:1.4rem; font-weight:700; color:#0f172a;">{{ number_format($inspectionsPending ?? 0) }}</div>
            <div style="font-size:0.65rem; color:#64748b; text-transform:uppercase;">{{ __('messages.inspections_pending') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:12px;">
        <div style="background:#10B981; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-users" style="font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:1.4rem; font-weight:700; color:#0f172a;">{{ number_format($members ?? 0) }}</div>
            <div style="font-size:0.65rem; color:#64748b; text-transform:uppercase;">{{ __('messages.members') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:12px;">
        <div style="background:#22C55E; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-money-bill-wave" style="font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:1.4rem; font-weight:700; color:#0f172a;">NPR {{ number_format($totalRevenue ?? 0, 0) }}</div>
            <div style="font-size:0.65rem; color:#64748b; text-transform:uppercase;">{{ __('messages.total_revenue') }}</div>
        </div>
    </div>
    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:12px;">
        <div style="background:#EC4899; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-certificate" style="font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:1.4rem; font-weight:700; color:#0f172a;">{{ number_format($totalCertificates ?? 0) }}</div>
            <div style="font-size:0.65rem; color:#64748b; text-transform:uppercase;">{{ __('messages.certificates') }}</div>
        </div>
    </div>
</div>

{{-- =============================================================
    SECONDARY STATS ROW (5 Small Cards)
    ============================================================= --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(100px,1fr)); gap:10px; margin-bottom:18px;">
    <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; text-align:center; border:1px solid #e2e8f0;">
        <div style="font-size:0.6rem; color:#64748b; text-transform:uppercase;">{{ __('messages.today') }}</div>
        <div style="font-size:1.2rem; font-weight:700; color:#0f172a;">{{ number_format($todayRegistrations ?? 0) }}</div>
    </div>
    <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; text-align:center; border:1px solid #e2e8f0;">
        <div style="font-size:0.6rem; color:#64748b; text-transform:uppercase;">{{ __('messages.this_week') }}</div>
        <div style="font-size:1.2rem; font-weight:700; color:#0f172a;">{{ number_format($thisWeekRegistrations ?? 0) }}</div>
    </div>
    <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; text-align:center; border:1px solid #e2e8f0;">
        <div style="font-size:0.6rem; color:#64748b; text-transform:uppercase;">{{ __('messages.this_month') }}</div>
        <div style="font-size:1.2rem; font-weight:700; color:#0f172a;">{{ number_format($thisMonthRegistrations ?? 0) }}</div>
    </div>
    <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; text-align:center; border:1px solid #e2e8f0;">
        <div style="font-size:0.6rem; color:#64748b; text-transform:uppercase;">{{ __('messages.active_hostels') }}</div>
        <div style="font-size:1.2rem; font-weight:700; color:#0f172a;">{{ number_format($activeHostels ?? 0) }}</div>
    </div>
    <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; text-align:center; border:1px solid #e2e8f0;">
        <div style="font-size:0.6rem; color:#64748b; text-transform:uppercase;">{{ __('messages.expired') }}</div>
        <div style="font-size:1.2rem; font-weight:700; color:#dc2626;">{{ number_format($expiredRegistrations ?? 0) }}</div>
    </div>
</div>

{{-- =============================================================
    QUICK ACTION BUTTONS (Only Approve Pending)
    ============================================================= --}}
<div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    @if($pendingRegistrations > 0)
        <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}" 
           style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.85rem; box-shadow:0 4px 15px rgba(245,158,11,0.3); transition:0.3s;">
            <i class="fas fa-check-circle"></i> {{ __('messages.approve_pending') }}
            <span style="background:rgba(255,255,255,0.2); padding:2px 10px; border-radius:50px; font-size:0.75rem;">{{ $pendingRegistrations }}</span>
        </a>
    @endif
</div>

{{-- =============================================================
    CHARTS ROW 1: Monthly Registrations + Hostel Types
    ============================================================= --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:18px; margin-bottom:18px;">
    <div style="background:#fff; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 12px 0; font-size:0.9rem; font-weight:600; color:#0f172a;">
            <i class="fas fa-chart-line" style="color:#0EA5E9; margin-right:8px;"></i>
            {{ __('messages.monthly_registrations') }}
        </h4>
        @if($hasMonthlyData)
            <div style="position:relative; height:180px;">
                <canvas id="monthlyRegistrationsChart" style="height:180px; width:100%;"></canvas>
            </div>
        @else
            <div style="display:flex; align-items:center; justify-content:center; height:180px; color:#94a3b8; font-size:0.9rem; flex-direction:column; gap:6px;">
                <i class="fas fa-chart-simple" style="font-size:2rem; color:#cbd5e1;"></i>
                <span>{{ __('messages.no_data_available') }}</span>
            </div>
        @endif
    </div>
    <div style="background:#fff; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 12px 0; font-size:0.9rem; font-weight:600; color:#0f172a;">
            <i class="fas fa-chart-pie" style="color:#8B5CF6; margin-right:8px;"></i>
            {{ __('messages.hostel_types') }}
        </h4>
        @if($hasTypeData)
            <div style="position:relative; height:180px;">
                <canvas id="typeDistributionChart" style="height:180px; width:100%;"></canvas>
            </div>
        @else
            <div style="display:flex; align-items:center; justify-content:center; height:180px; color:#94a3b8; font-size:0.9rem; flex-direction:column; gap:6px;">
                <i class="fas fa-chart-pie" style="font-size:2rem; color:#cbd5e1;"></i>
                <span>{{ __('messages.no_data_available') }}</span>
            </div>
        @endif
    </div>
</div>

{{-- =============================================================
    CHARTS ROW 2: Status Distribution + Revenue Trend
    ============================================================= --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:18px; margin-bottom:18px;">
    <div style="background:#fff; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 12px 0; font-size:0.9rem; font-weight:600; color:#0f172a;">
            <i class="fas fa-chart-bar" style="color:#F59E0B; margin-right:8px;"></i>
            {{ __('messages.registration_status') }}
        </h4>
        @if($hasStatusData)
            <div style="position:relative; height:180px;">
                <canvas id="statusDistributionChart" style="height:180px; width:100%;"></canvas>
            </div>
        @else
            <div style="display:flex; align-items:center; justify-content:center; height:180px; color:#94a3b8; font-size:0.9rem; flex-direction:column; gap:6px;">
                <i class="fas fa-chart-bar" style="font-size:2rem; color:#cbd5e1;"></i>
                <span>{{ __('messages.no_data_available') }}</span>
            </div>
        @endif
    </div>
    <div style="background:#fff; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 12px 0; font-size:0.9rem; font-weight:600; color:#0f172a;">
            <i class="fas fa-money-bill-wave" style="color:#22C55E; margin-right:8px;"></i>
            {{ __('messages.monthly_revenue') }}
        </h4>
        @if($hasRevenueData)
            <div style="position:relative; height:180px;">
                <canvas id="monthlyRevenueChart" style="height:180px; width:100%;"></canvas>
            </div>
        @else
            <div style="display:flex; align-items:center; justify-content:center; height:180px; color:#94a3b8; font-size:0.9rem; flex-direction:column; gap:6px;">
                <i class="fas fa-chart-line" style="font-size:2rem; color:#cbd5e1;"></i>
                <span>{{ __('messages.no_data_available') }}</span>
            </div>
        @endif
    </div>
</div>

{{-- =============================================================
    RECENT ACTIVITIES (3 Columns)
    ============================================================= --}}
<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:18px; margin-bottom:18px;">
    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 10px 0; font-size:0.8rem; font-weight:600; color:#0f172a; display:flex; align-items:center; gap:6px;">
            <i class="fas fa-file-alt" style="color:#0EA5E9;"></i>
            {{ __('messages.recent_registrations') }}
            <span style="margin-left:auto; font-size:0.65rem; font-weight:400; color:#94a3b8;">
                <a href="{{ route('admin.registrations.index') }}" style="color:#0EA5E9; text-decoration:none;">{{ __('messages.view_all') }}</a>
            </span>
        </h4>
        @forelse($recentRegistrations ?? [] as $reg)
            <div style="padding:6px 0; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:500; font-size:0.78rem; color:#0f172a;">{{ $reg->hostel_name ?? 'N/A' }}</div>
                    <div style="font-size:0.6rem; color:#94a3b8;">{{ $reg->created_at ? $reg->created_at->diffForHumans() : 'N/A' }}</div>
                </div>
                <span style="font-size:0.6rem; padding:1px 8px; border-radius:50px; font-weight:500; background:
                    @if($reg->status == 'pending') #fef3c7; color:#92400e;
                    @elseif($reg->status == 'approved') #dcfce7; color:#166534;
                    @elseif($reg->status == 'active') #dbeafe; color:#1e40af;
                    @elseif($reg->status == 'rejected') #fee2e2; color:#991b1b;
                    @else #f1f5f9; color:#475569; @endif">
                    {{ ucfirst($reg->status ?? 'N/A') }}
                </span>
            </div>
        @empty
            <div style="color:#94a3b8; font-size:0.8rem; text-align:center; padding:15px 0;">
                <i class="fas fa-inbox" style="display:block; font-size:1.2rem; color:#cbd5e1; margin-bottom:4px;"></i>
                {{ __('messages.no_recent_registrations') }}
            </div>
        @endforelse
    </div>

    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 10px 0; font-size:0.8rem; font-weight:600; color:#0f172a; display:flex; align-items:center; gap:6px;">
            <i class="fas fa-credit-card" style="color:#22C55E;"></i>
            {{ __('messages.recent_payments') }}
            <span style="margin-left:auto; font-size:0.65rem; font-weight:400; color:#94a3b8;">
                <a href="{{ route('admin.payments.index') }}" style="color:#0EA5E9; text-decoration:none;">{{ __('messages.view_all') }}</a>
            </span>
        </h4>
        @forelse($recentPayments ?? [] as $payment)
            <div style="padding:6px 0; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:500; font-size:0.78rem; color:#0f172a;">{{ $payment->registration->hostel_name ?? 'N/A' }}</div>
                    <div style="font-size:0.6rem; color:#94a3b8;">{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : 'N/A' }}</div>
                </div>
                <div style="font-weight:600; color:#22C55E; font-size:0.78rem;">NPR {{ number_format($payment->amount ?? 0, 0) }}</div>
            </div>
        @empty
            <div style="color:#94a3b8; font-size:0.8rem; text-align:center; padding:15px 0;">
                <i class="fas fa-inbox" style="display:block; font-size:1.2rem; color:#cbd5e1; margin-bottom:4px;"></i>
                {{ __('messages.no_recent_payments') }}
            </div>
        @endforelse
    </div>

    <div style="background:#fff; border-radius:10px; padding:14px 16px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 10px 0; font-size:0.8rem; font-weight:600; color:#0f172a; display:flex; align-items:center; gap:6px;">
            <i class="fas fa-certificate" style="color:#8B5CF6;"></i>
            {{ __('messages.recent_certificates') }}
            <span style="margin-left:auto; font-size:0.65rem; font-weight:400; color:#94a3b8;">
                <a href="{{ route('admin.certificate.index') }}" style="color:#0EA5E9; text-decoration:none;">{{ __('messages.view_all') }}</a>
            </span>
        </h4>
        @forelse($recentCertificates ?? [] as $cert)
            <div style="padding:6px 0; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:500; font-size:0.78rem; color:#0f172a;">{{ $cert->certificate_number ?? 'N/A' }}</div>
                    <div style="font-size:0.6rem; color:#94a3b8;">
                        {{ $cert->issued_date ? \Carbon\Carbon::parse($cert->issued_date)->format('Y-m-d') : 'N/A' }}
                    </div>
                </div>
                <span style="font-size:0.6rem; background:#eef2ff; color:#4338ca; padding:1px 8px; border-radius:50px; font-weight:500;">
                    {{ __('messages.generated') }}
                </span>
            </div>
        @empty
            <div style="color:#94a3b8; font-size:0.8rem; text-align:center; padding:15px 0;">
                <i class="fas fa-inbox" style="display:block; font-size:1.2rem; color:#cbd5e1; margin-bottom:4px;"></i>
                {{ __('messages.no_recent_certificates') }}
            </div>
        @endforelse
    </div>
</div>

@endsection

@push('styles')
<style>
    .stat-card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08) !important;
        transition: 0.2s ease;
    }
    .stat-card-hover {
        transition: 0.2s ease;
    }
    @media (max-width: 768px) {
        .dashboard-charts-grid {
            grid-template-columns: 1fr !important;
        }
        .dashboard-recents-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Helper: safe monthly data
    function safeMonthly(data, labelKey, valueKey, defaultLabels, defaultValues) {
        if (!data || !Array.isArray(data) || data.length === 0) {
            return { labels: defaultLabels, values: defaultValues };
        }
        return {
            labels: data.map(item => item[labelKey] || 'N/A'),
            values: data.map(item => item[valueKey] || 0)
        };
    }

    // =============================================================
    // 1. MONTHLY REGISTRATIONS (Line Chart)
    // =============================================================
    @if($hasMonthlyData)
    const monthlyData = @json($monthlyRegistrations ?? []);
    const monthlyDefaultLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const monthlyDefaultValues = Array(12).fill(0);
    const monthly = safeMonthly(monthlyData, 'label', 'count', monthlyDefaultLabels, monthlyDefaultValues);
    const monthlyCtx = document.getElementById('monthlyRegistrationsChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: monthly.labels.length ? monthly.labels : monthlyDefaultLabels,
                datasets: [{
                    label: '{{ __('messages.registrations') }}',
                    data: monthly.values.length ? monthly.values : monthlyDefaultValues,
                    borderColor: '#0EA5E9',
                    backgroundColor: 'rgba(14,165,233,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0EA5E9',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    borderWidth: 2.5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }
    @endif

    // =============================================================
    // 2. HOSTEL TYPES (Doughnut Chart) - FIXED!
    // =============================================================
    @if($hasTypeData)
    const typeData = @json($typeDistribution ?? []);
    const typeKeys = Object.keys(typeData);
    const typeValues = Object.values(typeData);
    const typeLabels = typeKeys.map(k => k.charAt(0).toUpperCase() + k.slice(1));
    const typeColorsMap = {
        'boys': '#3B82F6',
        'girls': '#EC4899',
        'co-ed': '#8B5CF6'
    };
    const typeColors = typeKeys.map(key => typeColorsMap[key] || '#94a3b8');
    const typeCtx = document.getElementById('typeDistributionChart');
    if (typeCtx) {
        new Chart(typeCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: typeLabels,
                datasets: [{
                    data: typeValues,
                    backgroundColor: typeColors,
                    borderWidth: 2.5,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom', 
                        labels: { 
                            padding: 12, 
                            usePointStyle: true, 
                            pointStyle: 'circle', 
                            font: { size: 11, weight: '500' },
                            color: '#0f172a'
                        } 
                    }
                },
                cutout: '60%'
            }
        });
    }
    @endif

    // =============================================================
    // 3. REGISTRATION STATUS (Bar Chart) - FIXED!
    // =============================================================
    @if($hasStatusData)
    const statusData = @json($statusDistribution ?? []);
    const statusKeys = Object.keys(statusData);
    const statusValues = Object.values(statusData);
    
    // 🔥 FIX: Clean labels - remove any extra leading characters
    const statusLabels = statusKeys.map(k => {
        let clean = k;
        if (k.length > 1 && k[0] === k[1]) {
            clean = k.substring(1); // Remove first duplicate character
        }
        return clean.charAt(0).toUpperCase() + clean.slice(1);
    });
    
    const statusColorsMap = {
        'pending': '#F59E0B',
        'approved': '#22C55E',
        'active': '#3B82F6',
        'rejected': '#EF4444',
        'duplicate': '#8B5CF6',
        'awaiting_payment': '#F59E0B',
        'inspection': '#8B5CF6',
        'completed': '#10B981',
        'scheduled': '#F59E0B',
        'cancelled': '#EF4444'
    };
    
    const statusColors = statusKeys.map(key => {
        let cleanKey = key;
        if (key.length > 1 && key[0] === key[1]) {
            cleanKey = key.substring(1);
        }
        return statusColorsMap[cleanKey] || '#94a3b8';
    });
    
    const statusCtx = document.getElementById('statusDistributionChart');
    if (statusCtx) {
        new Chart(statusCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: '{{ __('messages.registrations') }}',
                    data: statusValues,
                    backgroundColor: statusColors,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' registrations';
                            }
                        }
                    }
                },
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1 },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
    @endif

    // =============================================================
    // 4. MONTHLY REVENUE (Line Chart)
    // =============================================================
    @if($hasRevenueData)
    const revenueData = @json($monthlyRevenue ?? []);
    const revenueDefaultLabels = ['Jan','Feb','Mar','Apr','May','Jun'];
    const revenueDefaultValues = [0, 0, 0, 0, 0, 0];
    const revenue = safeMonthly(revenueData, 'label', 'total', revenueDefaultLabels, revenueDefaultValues);
    const revenueCtx = document.getElementById('monthlyRevenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: revenue.labels.length ? revenue.labels : revenueDefaultLabels,
                datasets: [{
                    label: '{{ __('messages.revenue') }} (NPR)',
                    data: revenue.values.length ? revenue.values : revenueDefaultValues,
                    borderColor: '#22C55E',
                    backgroundColor: 'rgba(34,197,94,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#22C55E',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    borderWidth: 2.5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: function(value) { return 'NPR ' + value.toLocaleString(); } }
                    }
                }
            }
        });
    }
    @endif

});
</script>
@endpush