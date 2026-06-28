@extends('layouts.admin')

@section('title', 'Registration #' . $registration->id . ' - HEAN Admin')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-0" style="color: #0f172a;">
                <i class="fas fa-file-alt text-primary me-2" style="color: #0EA5E9 !important;"></i>
                Registration #{{ $registration->id }}
            </h1>
            <span class="text-muted">
                <i class="far fa-calendar-alt me-1"></i>
                {{ $registration->created_at ? $registration->created_at->format('M d, Y') : 'N/A' }}
            </span>
        </div>
        <div>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Status Badge -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span class="badge rounded-pill px-3 py-2 fs-6
                            @if($registration->status == 'approved') bg-success
                            @elseif($registration->status == 'rejected') bg-danger
                            @elseif($registration->status == 'inspection') bg-warning text-dark
                            @else bg-secondary @endif">
                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                            {{ ucfirst($registration->status) }}
                        </span>
                        <span class="text-muted">
                            <i class="far fa-clock me-1"></i>
                            {{ $registration->submitted_at ? $registration->submitted_at->diffForHumans() : 'Not submitted' }}
                        </span>
                        <span class="text-muted">|</span>
                        <span class="text-muted">
                            <i class="fas fa-tag me-1"></i>
                            Source: <span class="fw-semibold">{{ ucfirst($registration->source ?? 'N/A') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- ===== LEFT COLUMN ===== -->
        <div class="col-lg-7">

            <!-- Registration Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3" style="background: linear-gradient(135deg, #0EA5E9, #3B82F6) !important;">
                    <i class="fas fa-info-circle me-2"></i> Registration Details
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Hostel Name</label>
                                <p class="fw-semibold mb-0 fs-5">{{ $registration->hostel_name ?? $registration->hostel->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Capacity</label>
                                <p class="mb-0">{{ $registration->capacity ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Contact Number</label>
                                <p class="mb-0">{{ $registration->contact_number ?? $registration->contact ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">PAN Number</label>
                                <p class="mb-0">{{ $registration->pan ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Hostel Type</label>
                                <p class="mb-0">{{ ucfirst($registration->hostel_type ?? 'N/A') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Established Year</label>
                                <p class="mb-0">{{ $registration->established_year ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Email Address</label>
                                <p class="mb-0">{{ $registration->email ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Registration #</label>
                                <p class="mb-0">{{ $registration->registration_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @if($registration->description)
                        <div class="mt-3">
                            <label class="text-muted text-uppercase small fw-bold d-block">Description</label>
                            <p class="mb-0">{{ $registration->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Address Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-secondary text-white py-3" style="background: linear-gradient(135deg, #64748B, #475569) !important;">
                    <i class="fas fa-map-marker-alt me-2"></i> Address Details
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Province</label>
                                <p class="mb-0">{{ $registration->province ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">District</label>
                                <p class="mb-0 fw-semibold">{{ $registration->district ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Municipality</label>
                                <p class="mb-0">{{ $registration->municipality ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Ward Number</label>
                                <p class="mb-0">{{ $registration->ward ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Street / Tole</label>
                                <p class="mb-0">{{ $registration->street ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted text-uppercase small fw-bold d-block">Landmark</label>
                                <p class="mb-0">{{ $registration->landmark ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN ===== -->
        <div class="col-lg-5">

            <!-- Owner Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white py-3" style="background: linear-gradient(135deg, #22C55E, #16A34A) !important;">
                    <i class="fas fa-user-circle me-2"></i> Owner Details
                </div>
                <div class="card-body text-center">
                    @if($registration->owner)
                        <div class="mb-3">
                            <div class="avatar-circle bg-primary text-white mx-auto" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: bold; background: #0EA5E9 !important;">
                                {{ substr($registration->owner->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="text-start">
                            <div class="mb-2">
                                <label class="text-muted text-uppercase small fw-bold d-block">Full Name</label>
                                <p class="fw-semibold mb-0 fs-5">{{ $registration->owner->name }}</p>
                            </div>
                            <div class="mb-2">
                                <label class="text-muted text-uppercase small fw-bold d-block">Email Address</label>
                                <p class="mb-0"><a href="mailto:{{ $registration->owner->email }}" class="text-decoration-none">{{ $registration->owner->email }}</a></p>
                            </div>
                            <div class="mb-2">
                                <label class="text-muted text-uppercase small fw-bold d-block">Contact Number</label>
                                <p class="mb-0">{{ $registration->owner->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-2">
                                <label class="text-muted text-uppercase small fw-bold d-block">Citizenship Number</label>
                                <p class="mb-0">{{ $registration->owner->citizenship_number ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-0">
                                <label class="text-muted text-uppercase small fw-bold d-block">PAN Number</label>
                                <p class="mb-0">{{ $registration->owner->pan ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="py-4">
                            <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No owner linked to this registration.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white py-3" style="background: linear-gradient(135deg, #06B6D4, #0891B2) !important;">
                    <i class="fas fa-chart-simple me-2"></i> Quick Stats
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <i class="fas fa-file-alt text-primary fs-2"></i>
                                <div class="fw-bold fs-4">{{ $registration->documents?->count() ?? 0 }}</div>
                                <small class="text-muted">Documents</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <i class="fas fa-credit-card text-success fs-2"></i>
                                <div class="fw-bold fs-4">{{ $registration->payments?->count() ?? 0 }}</div>
                                <small class="text-muted">Payments</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <i class="fas fa-receipt text-warning fs-2"></i>
                                <div class="fw-bold fs-4">{{ $registration->invoices?->count() ?? 0 }}</div>
                                <small class="text-muted">Invoices</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <i class="fas fa-certificate text-danger fs-2"></i>
                                <div class="fw-bold fs-4">{{ $registration->certificates?->count() ?? 0 }}</div>
                                <small class="text-muted">Certificates</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ACTIONS SECTION ===== -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white py-3" style="background: linear-gradient(135deg, #1E293B, #0F172A) !important;">
                    <i class="fas fa-tools me-2"></i> Actions
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        @if($registration->status == 'pending')
                            <form action="{{ route('admin.registrations.approve', $registration) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <i class="fas fa-check-circle me-2"></i> Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger rounded-pill px-4">
                                    <i class="fas fa-times-circle me-2"></i> Reject
                                </button>
                            </form>
                        @endif

                        <button type="button" class="btn btn-info rounded-pill px-4" data-bs-toggle="collapse" data-bs-target="#inspectorForm">
                            <i class="fas fa-user-check me-2"></i> Assign Inspector
                        </button>

                        <button type="button" class="btn btn-warning rounded-pill px-4" data-bs-toggle="collapse" data-bs-target="#invoiceForm">
                            <i class="fas fa-file-invoice me-2"></i> Generate Invoice
                        </button>
                    </div>

                    <!-- Inspector Assignment Form -->
                    <div class="collapse mt-4" id="inspectorForm">
                        <div class="card card-body border-0 bg-light">
                            <form action="{{ route('admin.inspections.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="registration_id" value="{{ $registration->id }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="inspector_id" class="form-label fw-bold">Inspector</label>
                                        <select name="inspector_id" id="inspector_id" class="form-select" required>
                                            <option value="">Select Inspector</option>
                                            @foreach($inspectors ?? [] as $inspector)
                                                <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="scheduled_date" class="form-label fw-bold">Scheduled Date</label>
                                        <input type="date" name="scheduled_date" id="scheduled_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                            <i class="fas fa-calendar-plus me-2"></i> Assign & Schedule
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Invoice Generation Form -->
                    <div class="collapse mt-4" id="invoiceForm">
                        <div class="card card-body border-0 bg-light">
                            <form action="{{ route('admin.invoices.generate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="registration_id" value="{{ $registration->id }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="amount" class="form-label fw-bold">Amount (NPR)</label>
                                        <input type="number" name="amount" id="amount" class="form-control" step="0.01" required placeholder="e.g. 1500">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="due_date" class="form-label fw-bold">Due Date</label>
                                        <input type="date" name="due_date" id="due_date" class="form-control">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-warning w-100 rounded-pill">
                                            <i class="fas fa-file-invoice me-2"></i> Generate Invoice
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== DOCUMENTS, PAYMENTS, INSPECTIONS, DUPLICATE ===== -->
    <div class="row mt-4 g-4">

        <!-- Documents -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #0EA5E9, #3B82F6) !important; color: white;">
                    <i class="fas fa-file-pdf me-2"></i> Documents
                </div>
                <div class="card-body">
                    @if($registration->documents?->count())
                        <div class="list-group list-group-flush">
                            @foreach($registration->documents as $doc)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file text-primary me-2"></i>
                                        <span class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $doc->type)) }}</span>
                                        <br>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i> {{ $doc->created_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <a href="{{ route('admin.documents.download', $doc->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No documents uploaded.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payments -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #22C55E, #16A34A) !important; color: white;">
                    <i class="fas fa-credit-card me-2"></i> Payments
                </div>
                <div class="card-body">
                    @if($registration->payments?->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Method</th>
                                        <th>Transaction</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registration->payments as $payment)
                                        <tr>
                                            <td><span class="badge bg-info">{{ ucfirst($payment->method) }}</span></td>
                                            <td>{{ $payment->transaction_id }}</td>
                                            <td class="text-end fw-bold">NPR {{ number_format($payment->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No payments recorded.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Inspections -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #F59E0B, #D97706) !important; color: white;">
                    <i class="fas fa-clipboard-check me-2"></i> Inspections
                </div>
                <div class="card-body">
                    @if($registration->inspections?->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Scheduled</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registration->inspections as $inspection)
                                        <tr>
                                            <td>{{ $inspection->scheduled_date }}</td>
                                            <td>
                                                <span class="badge bg-{{ $inspection->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($inspection->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $inspection->remarks ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No inspections scheduled.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Duplicate Reviews -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #EF4444, #DC2626) !important; color: white;">
                    <i class="fas fa-copy me-2"></i> Duplicate Reviews
                </div>
                <div class="card-body">
                    @if($registration->duplicateReviews?->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Reviewed By</th>
                                        <th>Duplicate?</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registration->duplicateReviews as $review)
                                        <tr>
                                            <td>{{ $review->reviewedBy->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $review->is_duplicate ? 'danger' : 'success' }}">
                                                    {{ $review->is_duplicate ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>{{ $review->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-copy fa-4x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Not reviewed for duplicates.</p>
                        </div>
                    @endif

                    <div class="mt-3 d-flex gap-2">
                        <form action="{{ route('admin.duplicate.review', $registration) }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_duplicate" value="0">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <i class="fas fa-check me-2"></i> Not Duplicate
                            </button>
                        </form>
                        <form action="{{ route('admin.duplicate.review', $registration) }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_duplicate" value="1">
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <i class="fas fa-exclamation-triangle me-2"></i> Mark as Duplicate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Inline Styles for Polish -->
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
    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        margin: 0 auto;
        background: #0EA5E9 !important;
        color: white !important;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
        padding: 12px 0;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .btn {
        transition: all 0.2s ease;
    }
    .btn:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .badge {
        font-weight: 500;
        padding: 0.4rem 0.8rem;
    }
    .bg-light {
        background-color: #f8fafc !important;
    }
    .text-muted {
        color: #64748b !important;
    }
    .fs-5 { font-size: 1.25rem; }
    .fs-4 { font-size: 1.5rem; }
    .fs-6 { font-size: 1rem; }
</style>
@endsection