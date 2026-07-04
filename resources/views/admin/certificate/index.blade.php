@extends('layouts.admin')

@section('title', __('messages.admin_certificate_title'))

@section('content')
<div class="container-fluid py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold mb-0" style="color: #0f172a;">
            <i class="fas fa-certificate me-2" style="color: #0EA5E9;"></i>
            {{ __('messages.admin_certificate_title') }}
        </h1>
        <span class="text-muted" style="font-size: 0.85rem;">
            <i class="far fa-clock me-1"></i>
            {{ now()->format('M d, Y H:i') }}
        </span>
    </div>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('messages.close') }}"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('messages.close') }}"></button>
        </div>
    @endif

    {{-- ===== GENERATE CERTIFICATE FORM ===== --}}
    <div class="card border-0 shadow-lg mb-4" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header py-3" style="background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: #fff; border: none;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-plus-circle fs-5"></i>
                <h5 class="fw-bold mb-0">{{ __('messages.generate_new_certificate') }}</h5>
            </div>
        </div>
        <div class="card-body" style="padding: 2rem;">
            <form action="{{ route('admin.certificate.generate') }}" method="POST">
                @csrf
                <div class="row g-4 align-items-end">
                    <div class="col-md-8">
                        <label for="registration_id" class="form-label fw-semibold" style="color: #1e293b; font-size: 0.9rem;">
                            <i class="fas fa-id-card me-1" style="color: #0EA5E9;"></i>
                            {{ __('messages.registration_id') }}
                        </label>
                        <select name="registration_id" id="registration_id" class="form-select form-select-lg" 
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 12px 16px; background: #f8fafc; transition: 0.3s;" required>
                            <option value="">{{ __('messages.select_registration') }}</option>
                            @foreach(\App\Models\Registration::with('hostel')->where('status', 'approved')->get() as $reg)
                                {{-- ✅ 8.3: दर्ता नम्बर (फलब्याक #ID) --}}
                                <option value="{{ $reg->id }}">
                                    {{ $reg->registration_number ?? '#'.$reg->id }} – {{ $reg->hostel->name ?? __('messages.not_available') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn w-100 btn-lg rounded-pill"
                                style="background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: #fff; border: none; padding: 14px 20px; font-weight: 600; box-shadow: 0 6px 20px rgba(14,165,233,0.35); transition: 0.3s;">
                            <i class="fas fa-certificate me-2"></i> {{ __('messages.generate_certificate') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== GENERATED CERTIFICATES LIST ===== --}}
    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header py-3" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: #fff; border: none;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list-ul fs-5"></i>
                <h5 class="fw-bold mb-0">{{ __('messages.generated_certificates') }}</h5>
                <span class="ms-auto badge bg-light text-dark rounded-pill px-3 py-2">
                    <i class="fas fa-file-alt me-1"></i> {{ $certificates->total() ?? 0 }}
                </span>
            </div>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            @if($certificates->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="border-radius: 12px; overflow: hidden;">
                        <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th style="padding: 12px 16px; font-weight: 600; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                    {{ __('messages.certificate_number') }}
                                </th>
                                <th style="padding: 12px 16px; font-weight: 600; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                    {{ __('messages.registration') }}
                                </th>
                                <th style="padding: 12px 16px; font-weight: 600; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                    {{ __('messages.hostel') }}
                                </th>
                                <th style="padding: 12px 16px; font-weight: 600; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                    {{ __('messages.issued_date') }}
                                </th>
                                <th style="padding: 12px 16px; text-align: center; font-weight: 600; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                    {{ __('messages.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $cert)
                            <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s;">
                                <td style="padding: 12px 16px; font-weight: 600; color: #0f172a;">
                                    <span style="background: #eef2ff; color: #4338ca; padding: 2px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600;">
                                        {{ $cert->certificate_number }}
                                    </span>
                                </td>
                                {{-- ✅ 8.3: दर्ता नम्बर (फलब्याक #ID) --}}
                                <td style="padding: 12px 16px; color: #1e293b;">
                                    {{ $cert->registration->registration_number ?? '#'.$cert->registration_id }}
                                </td>
                                <td style="padding: 12px 16px; color: #1e293b;">
                                    {{ $cert->registration->hostel->name ?? __('messages.not_available') }}
                                </td>
                                <td style="padding: 12px 16px; color: #475569;">
                                    <i class="far fa-calendar-alt me-1" style="color: #94a3b8;"></i>
                                    {{ $cert->issued_date ? \Carbon\Carbon::parse($cert->issued_date)->format('Y-m-d') : __('messages.not_available') }}
                                </td>
                                <td style="padding: 12px 16px; text-align: center;">
                                    <a href="{{ route('admin.certificates.download', $cert->id) }}" 
                                       class="btn btn-sm rounded-pill px-3"
                                       style="background: linear-gradient(135deg, #22C55E, #16A34A); color: #fff; border: none; font-weight: 600; font-size: 0.75rem; box-shadow: 0 2px 10px rgba(34,197,94,0.25); transition: 0.3s;">
                                        <i class="fas fa-download me-1"></i> {{ __('messages.download') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $certificates->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 40px 20px;">
                    <i class="fas fa-file-alt" style="font-size: 3rem; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                    <p style="color: #94a3b8; font-size: 0.95rem; margin: 0;">
                        {{ __('messages.no_certificates') }}
                    </p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- ===== EXTRA STYLES ===== --}}
@push('styles')
<style>
    .form-select:focus {
        border-color: #0EA5E9 !important;
        box-shadow: 0 0 0 4px rgba(14,165,233,0.12) !important;
        background: #fff !important;
    }
    .btn:hover {
        transform: scale(1.02);
    }
    .btn-primary:hover {
        box-shadow: 0 8px 25px rgba(14,165,233,0.45) !important;
    }
    .btn-success:hover {
        box-shadow: 0 8px 25px rgba(34,197,94,0.45) !important;
    }
    .card {
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .table tbody tr:hover {
        background: #f8fafc !important;
    }
    .pagination-wrapper .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination-wrapper .pagination .page-item .page-link {
        padding: 8px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        transition: 0.2s;
        font-weight: 500;
        font-size: 0.9rem;
        background: #fff;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover {
        background: #f1f5f9;
        border-color: #0EA5E9;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0EA5E9, #3B82F6);
        border-color: #0EA5E9;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush
@endsection