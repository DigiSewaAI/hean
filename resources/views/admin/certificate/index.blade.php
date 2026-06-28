@extends('layouts.admin')

@section('title', __('messages.admin_certificate_title'))

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('messages.admin_certificate_title') }}</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Generate Certificate Form -->
    <div class="card mb-4">
        <div class="card-header">Generate New Certificate</div>
        <div class="card-body">
            <form action="{{ route('admin.certificate.generate') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <label for="registration_id" class="form-label">Registration ID</label>
                        <select name="registration_id" id="registration_id" class="form-select" required>
                            <option value="">Select a registration</option>
                            @foreach(\App\Models\Registration::with('hostel')->where('status', 'approved')->get() as $reg)
                                <option value="{{ $reg->id }}">
                                    #{{ $reg->id }} – {{ $reg->hostel->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Generate Certificate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- List of Generated Certificates -->
    <div class="card">
        <div class="card-header">Generated Certificates</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Certificate #</th>
                        <th>Registration</th>
                        <th>Hostel</th>
                        <th>Issued Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $cert)
                    <tr>
                        <td>{{ $cert->certificate_number }}</td>
                        <td>#{{ $cert->registration_id }}</td>
                        <td>{{ $cert->registration->hostel->name ?? 'N/A' }}</td>
                        <td>{{ $cert->issued_date->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.certificates.download', $cert->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">No certificates generated yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $certificates->links() }}
        </div>
    </div>
</div>
@endsection