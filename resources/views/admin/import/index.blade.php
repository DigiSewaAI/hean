@extends('layouts.admin')

@section('title', __('messages.import_title'))

@section('content')
<div class="container-fluid py-4">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold mb-0" style="color: #0f172a;">
            <i class="fas fa-cloud-upload-alt me-2" style="color: #0EA5E9;"></i>
            {{ __('messages.import_title') }}
        </h1>
        <span class="text-muted" style="font-size: 0.85rem;">
            <i class="far fa-clock me-1"></i>
            {{ now()->format('M d, Y H:i') }}
        </span>
    </div>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('messages.close') }}"></button>
        </div>
    @endif

    {{-- ===== MAIN CARD ===== --}}
    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">

        {{-- Card Header --}}
        <div class="card-header py-4" style="background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: #fff; border: none;">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="fas fa-file-import"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size: 1.2rem;">{{ __('messages.import_title') }}</h5>
                    <small style="opacity: 0.8;">CSV / Excel फाइलबाट डाटा आयात गर्नुहोस्</small>
                </div>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="card-body" style="padding: 2rem 2.5rem;">

            {{-- Info Alert --}}
            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start gap-3" style="border-radius: 12px; background: #fffbeb; border-left: 5px solid #F59E0B;">
                <i class="fas fa-lightbulb text-warning fs-4 mt-1"></i>
                <div>
                    <strong class="d-block" style="color: #92400e;">{{ __('messages.import_placeholder') }}</strong>
                    <small style="color: #78350f;">कृपया सही ढाँचाको फाइल मात्र अपलोड गर्नुहोस्।</small>
                </div>
            </div>

            {{-- Upload Form --}}
            <form action="{{ route('admin.import.prepare') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf

                <div class="row g-4 align-items-end">

                    {{-- File Input --}}
                    <div class="col-md-8">
                        <label for="file" class="form-label fw-semibold" style="color: #1e293b; font-size: 0.9rem;">
                            <i class="fas fa-file-csv me-1" style="color: #0EA5E9;"></i>
                            {{ __('messages.upload_csv_excel') }}
                        </label>
                        <div class="position-relative">
                            <input type="file" class="form-control form-control-lg" id="file" name="file" accept=".csv,.xlsx,.xls"
                                   style="padding: 14px 18px; border-radius: 14px; border: 2px dashed #d1d5db; background: #fafbfc; transition: 0.3s; cursor: pointer;">
                            <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">
                                <i class="fas fa-info-circle me-1"></i>
                                समर्थित फार्म्याट: .csv, .xlsx, .xls | अधिकतम 10MB
                            </small>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-md-4">
                        <button type="submit" class="btn w-100 btn-lg rounded-pill"
                                style="background: linear-gradient(135deg, #0EA5E9, #3B82F6); 
                                       color: #fff; border: none; 
                                       padding: 14px 20px; 
                                       font-weight: 600; 
                                       font-size: 1rem;
                                       box-shadow: 0 6px 20px rgba(14,165,233,0.35); 
                                       transition: all 0.3s ease;">
                            <i class="fas fa-upload me-2"></i> {{ __('messages.prepare_import') }}
                        </button>
                    </div>

                </div>
            </form>

            {{-- Extra Help / Tip --}}
            <div class="mt-4 pt-3 border-top" style="border-color: #e2e8f0 !important;">
                <div class="d-flex flex-wrap align-items-center gap-4 text-muted" style="font-size: 0.85rem;">
                    <span><i class="fas fa-check-circle text-success me-1"></i> सजिलो र छिटो</span>
                    <span><i class="fas fa-shield-alt text-primary me-1"></i> सुरक्षित अपलोड</span>
                    <span><i class="fas fa-database text-warning me-1"></i> ठूलो डाटा पनि समर्थन</span>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Optional: Extra CSS for better visual --}}
@push('styles')
<style>
    .form-control[type="file"]:hover {
        border-color: #0EA5E9 !important;
        background: #f0f9ff !important;
    }
    .form-control[type="file"]:focus {
        border-color: #0EA5E9;
        box-shadow: 0 0 0 4px rgba(14,165,233,0.15);
    }
    .btn-primary-gradient {
        background: linear-gradient(135deg, #0EA5E9, #3B82F6);
        border: none;
        box-shadow: 0 6px 20px rgba(14,165,233,0.35);
        transition: all 0.3s ease;
    }
    .btn-primary-gradient:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(14,165,233,0.5) !important;
        background: linear-gradient(135deg, #0EA5E9, #2563EB);
    }
    .card {
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-3px);
    }
</style>
@endpush
@endsection