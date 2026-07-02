@extends('layouts.admin')

@section('title', __('messages.invoices') . ' - HEAN Admin')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">
            <i class="fas fa-file-invoice text-primary"></i>
            {{ __('messages.invoices') }}
        </h2>
        <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('messages.create_invoice') }}
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.invoices.index') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('messages.search_invoices') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">{{ __('messages.all_statuses') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('messages.status_pending') }}</option>
                        <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>{{ __('messages.status_partial') }}</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>{{ __('messages.status_paid') }}</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>{{ __('messages.status_overdue') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}" placeholder="{{ __('messages.from_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}" placeholder="{{ __('messages.to_date') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> {{ __('messages.filter') }}
                    </button>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> {{ __('messages.clear') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.invoice_number') }}</th>
                            <th>{{ __('messages.registration') }}</th>
                            <th>{{ __('messages.amount') }}</th>
                            <th>{{ __('messages.issued_date') }}</th>
                            <th>{{ __('messages.due_date') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th class="text-center">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                            <td>
                                @if($invoice->registration)
                                    <a href="{{ route('admin.registrations.show', $invoice->registration) }}">
                                        {{ $invoice->registration->hostel_name ?? $invoice->registration->registration_number }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('messages.not_available') }}</span>
                                @endif
                            </td>
                            <td>NPR {{ number_format($invoice->amount, 2) }}</td>
                            <td>{{ $invoice->issued_date ? $invoice->issued_date->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'secondary',
                                        'partial' => 'warning',
                                        'paid'    => 'success',
                                        'overdue' => 'danger',
                                    ];
                                    $color = $statusColors[$invoice->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">
                                    {{ __('messages.status_' . $invoice->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-sm btn-info" title="{{ __('messages.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn btn-sm btn-success" title="{{ __('messages.download') }}">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                {{ __('messages.no_invoices_found') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div>
                {{ __('messages.showing') }} {{ $invoices->firstItem() ?? 0 }} - {{ $invoices->lastItem() ?? 0 }}
                {{ __('messages.of') }} {{ $invoices->total() }}
            </div>
            <div>
                {{ $invoices->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th { white-space: nowrap; }
    .badge { font-size: 0.8rem; padding: 0.35rem 0.75rem; }
    .btn-sm i { font-size: 0.85rem; }
</style>
@endpush