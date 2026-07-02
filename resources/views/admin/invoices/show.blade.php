@extends('layouts.admin')

@section('title', __('messages.invoice') . ' #' . $invoice->invoice_number . ' - HEAN Admin')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">
            <i class="fas fa-file-invoice text-primary"></i>
            {{ __('messages.invoice') }} #{{ $invoice->invoice_number }}
            <span class="text-muted fs-6 fw-normal ms-2">
                {{ $invoice->issued_date ? $invoice->issued_date->format('M d, Y') : __('messages.not_available') }}
            </span>
        </h2>
        <div>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_list') }}
            </a>
            <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn btn-success">
                <i class="fas fa-download"></i> {{ __('messages.download_pdf') }}
            </a>
        </div>
    </div>

    {{-- Status Badge --}}
    <div class="mb-4">
        @php
            $statusColors = [
                'pending' => 'secondary',
                'partial' => 'warning',
                'paid'    => 'success',
                'overdue' => 'danger',
            ];
            $color = $statusColors[$invoice->status] ?? 'secondary';
        @endphp
        <span class="badge bg-{{ $color }} fs-6 py-2 px-4">
            {{ __('messages.status_' . $invoice->status) }}
        </span>
    </div>

    <div class="row">
        {{-- Invoice Details --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-info-circle"></i> {{ __('messages.invoice_details') }}
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width:40%;">{{ __('messages.invoice_number') }}</th>
                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.amount') }}</th>
                            <td><strong class="text-primary">NPR {{ number_format($invoice->amount, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.issued_date') }}</th>
                            <td>{{ $invoice->issued_date ? $invoice->issued_date->format('Y-m-d H:i') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.due_date') }}</th>
                            <td>
                                {{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}
                                @if($invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid')
                                    <span class="badge bg-danger ms-2">{{ __('messages.overdue') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.invoice_type') }}</th>
                            <td>{{ __('messages.invoice_type_' . $invoice->invoice_type) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.status') }}</th>
                            <td>
                                <span class="badge bg-{{ $color }}">
                                    {{ __('messages.status_' . $invoice->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Registration & Payments Summary --}}
        <div class="col-md-6">
            {{-- Registration Info --}}
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-file-alt"></i> {{ __('messages.registration') }}
                </div>
                <div class="card-body">
                    @if($invoice->registration)
                        <p class="mb-1"><strong>{{ $invoice->registration->hostel_name ?? $invoice->registration->registration_number }}</strong></p>
                        <p class="mb-1 text-muted small">
                            <i class="fas fa-hashtag"></i> {{ $invoice->registration->registration_number }}
                        </p>
                        <p class="mb-0 text-muted small">
                            <i class="fas fa-map-marker-alt"></i> {{ $invoice->registration->district }}, {{ $invoice->registration->municipality }}
                        </p>
                        <a href="{{ route('admin.registrations.show', $invoice->registration) }}" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-eye"></i> {{ __('messages.view_registration') }}
                        </a>
                    @else
                        <p class="text-muted">{{ __('messages.not_available') }}</p>
                    @endif
                </div>
            </div>

            {{-- Payment Summary --}}
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-credit-card"></i> {{ __('messages.payments') }}
                </div>
                <div class="card-body">
                    @php
                        $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');
                        $balance = $invoice->amount - $totalPaid;
                    @endphp
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="small text-muted">{{ __('messages.total_paid') }}</div>
                            <div class="h5 text-success">NPR {{ number_format($totalPaid, 2) }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">{{ __('messages.outstanding') }}</div>
                            <div class="h5 text-danger">NPR {{ number_format(max(0, $balance), 2) }}</div>
                        </div>
                    </div>
                    @if($invoice->payments->count())
                        <hr>
                        <div class="small">
                            @foreach($invoice->payments as $payment)
                                <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                    <span>{{ $payment->method }} ({{ $payment->transaction_id ?? 'N/A' }})</span>
                                    <span class="fw-bold {{ $payment->status == 'verified' ? 'text-success' : 'text-muted' }}">
                                        NPR {{ number_format($payment->amount, 2) }}
                                        <span class="badge bg-{{ $payment->status == 'verified' ? 'success' : 'secondary' }}">
                                            {{ __('messages.status_'.$payment->status) }}
                                        </span>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">{{ __('messages.no_payments_recorded') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Actions --}}
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex gap-3 flex-wrap">
                    <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> {{ __('messages.download_pdf') }}
                    </a>
                    @if($invoice->status !== 'paid')
                        <a href="{{ route('admin.payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> {{ __('messages.add_payment') }}
                        </a>
                    @endif
                    @if($invoice->registration)
                        <a href="{{ route('admin.registrations.show', $invoice->registration) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right"></i> {{ __('messages.go_to_registration') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .badge { font-size: 0.85rem; padding: 0.4rem 0.8rem; }
    .table-borderless th { color: #6c757d; font-weight: 600; }
    .table-borderless td { font-weight: 500; }
    .btn i { margin-right: 4px; }
</style>
@endpush