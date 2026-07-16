@extends('layouts.admin')

@section('title', __('messages.new_registration_title') . ' - HEAN Admin')

@section('content')
{{-- ===== ERROR MESSAGES ===== --}}
@if ($errors->any())
    <div style="background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-plus-circle me-2" style="color:#0EA5E9;"></i> {{ __('messages.new_registration_title') }}
    </h2>
    <a href="{{ route('admin.registrations.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.registrations.store') }}" method="POST" enctype="multipart/form-data" class="dashboard-form">
        @csrf

        {{-- ===== Section 1: Hostel Details ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
            <h4 style="margin:0 0 16px 0; color:#0EA5E9;">
                <i class="fas fa-building me-2"></i> {{ __('messages.hostel_information') }}
            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="hostel_name">{{ __('messages.hostel_name_nepali') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="hostel_name" id="hostel_name" value="{{ old('hostel_name') }}" placeholder="{{ __('messages.placeholder_hostel_name_nepali') }}" required>
                </div>
                <div class="form-group">
                    <label for="hostel_name_english">{{ __('messages.hostel_name_english') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="hostel_name_english" id="hostel_name_english" value="{{ old('hostel_name_english') }}" placeholder="{{ __('messages.placeholder_hostel_name_english') }}" required>
                </div>
            </div>

            {{-- ✅ 8.1: Block / Building Name --}}
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group" style="grid-column: span 2;">
                    <label for="block_name">ब्लक / भवन नाम <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
                    <input type="text" name="block_name" id="block_name" value="{{ old('block_name') }}" placeholder="जस्तै: Block A, Main Building">
                    @error('block_name')
                        <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                    <small style="color:#64748b; font-size:0.75rem;">यदि एउटै ठेगानामा धेरै ब्लक छन् भने छुट्याउन प्रयोग गर्नुहोस्।</small>
                </div>
            </div>

            {{-- Local Registration Number --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:12px;">
    <div style="grid-column: span 2;">
        <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">
            {{ __('messages.local_registration_number') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="text" name="local_registration_number"
value="{{ old('local_registration_number') }}"
               placeholder="{{ __('messages.placeholder_local_registration_number') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;">
        @error('local_registration_number')
            <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
        @enderror
        <small style="color:#64748b; font-size:0.75rem;">
            <i class="fas fa-info-circle"></i>
            {{ __('messages.help_local_registration_number') }}
        </small>
    </div>
</div>

            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="hostel_type">{{ __('messages.type') }} <span style="color:#dc2626;">*</span></label>
                    <select name="hostel_type" id="hostel_type" required>
                        <option value="">{{ __('messages.select') }}</option>
                        <option value="boys" {{ old('hostel_type')=='boys'?'selected':'' }}>{{ __('messages.boys') }}</option>
                        <option value="girls" {{ old('hostel_type')=='girls'?'selected':'' }}>{{ __('messages.girls') }}</option>
                        <option value="co-ed" {{ old('hostel_type')=='co-ed'?'selected':'' }}>{{ __('messages.co_ed') }}</option>
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_select_type') }}</small>
                </div>
                <div class="form-group">
    <label for="established_year">{{ __('messages.established_year') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="number" name="established_year" id="established_year" value="{{ old('established_year') }}" min="1900" max="{{ date('Y') }}">
    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_established_year') }}</small>
</div>
            </div>

            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
    <label for="pan">{{ __('messages.pan_number') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="text" name="pan" id="pan" value="{{ old('pan') }}" placeholder="{{ __('messages.placeholder_pan') }}">
    <small style="color:#64748b; font-size:0.75rem;">
        <i class="fas fa-info-circle"></i> 
        PAN नम्बर केवल प्रमाणीकरणको लागि हो। एउटै PAN मा धेरै होस्टल दर्ता गर्न सकिन्छ।
    </small>
</div>
                <div class="form-group">
                    {{-- Registration Number will be auto-generated --}}
                </div>
            </div>

            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="capacity">{{ __('messages.total_beds') }} <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 0) }}" min="0" required>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_total_beds') }}</small>
                </div>
                <div class="form-group">
                    <label for="rooms">{{ __('messages.total_rooms') }} <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="rooms" id="rooms" value="{{ old('rooms', 0) }}" min="0" required>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_total_rooms') }}</small>
                </div>
            </div>
        </div>

        {{-- ===== Section 2: Owner Details ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #10B981;">
            <h4 style="margin:0 0 16px 0; color:#10B981;">
                <i class="fas fa-user-tie me-2"></i> {{ __('messages.owner_applicant_information') }}
            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="operator_name">{{ __('messages.full_name') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="operator_name" id="operator_name" value="{{ old('operator_name') }}" required>
                </div>
                <div class="form-group">
    <label for="email">{{ __('messages.email_address') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('messages.placeholder_email') }}">
    <small style="color:#64748b; font-size:0.75rem;">
        <i class="fas fa-info-circle"></i> 
        इमेल सञ्चार र प्रमाणीकरणको लागि हो। एउटै इमेल धेरै होस्टलको लागि प्रयोग गर्न सकिन्छ।
    </small>
</div>
            </div>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="contact">{{ __('messages.contact_number') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact') }}" required>
                    {{-- ✅ 8.2: Contact helper message --}}
                    <small style="color:#64748b; font-size:0.75rem;">
                        <i class="fas fa-info-circle"></i> 
                        सम्पर्क नम्बर सञ्चारको लागि हो। एउटै नम्बर धेरै होस्टलको लागि प्रयोग गर्न सकिन्छ।
                    </small>
                </div>
                <div class="form-group">
                    <label for="website">वेबसाइट <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
                    <input type="url" name="website" id="website" value="{{ old('website') }}" placeholder="{{ __('messages.placeholder_website') }}">
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_website') }}</small>
                </div>
            </div>
        </div>

        {{-- ===== Section 3: Address (Dynamic Dropdowns) ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #8B5CF6;">
            <h4 style="margin:0 0 16px 0; color:#8B5CF6;">
                <i class="fas fa-map-marker-alt me-2"></i> {{ __('messages.address') }}
            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="province">{{ __('messages.province') }} <span style="color:#dc2626;">*</span></label>
                    <select name="province" id="province" required>
                        <option value="">{{ __('messages.select_province') }}</option>
                        @foreach(\App\Models\Province::orderBy('name')->get() as $prov)
                            <option value="{{ $prov->id }}" {{ old('province')==$prov->id?'selected':'' }}>{{ $prov->name }}</option>
                        @endforeach
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_select_province') }}</small>
                </div>
                <div class="form-group">
                    <label for="district">{{ __('messages.district') }} <span style="color:#dc2626;">*</span></label>
                    <select name="district" id="district" required>
                        <option value="">{{ __('messages.select_district') }}</option>
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_select_district') }}</small>
                </div>
                <div class="form-group">
                    <label for="municipality">{{ __('messages.municipality') }} <span style="color:#dc2626;">*</span></label>
                    <select name="municipality" id="municipality" required>
                        <option value="">{{ __('messages.select_municipality') }}</option>
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_select_municipality') }}</small>
                </div>
            </div>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="ward">{{ __('messages.ward_number') }} <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="ward" id="ward" value="{{ old('ward') }}" min="1" max="32" required>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_ward_number') }}</small>
                </div>
                <div class="form-group">
    <label for="street">{{ __('messages.street_tole') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="text" name="street" id="street" value="{{ old('street') }}">
</div>
                <div class="form-group">
                    <label for="landmark">स्थलचिन्ह <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
                    <input type="text" name="landmark" id="landmark" value="{{ old('landmark') }}" placeholder="{{ __('messages.placeholder_landmark') }}">
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_landmark') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="description">विवरण / सुविधाहरू <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
                <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- ===== Section 4: Documents ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #F59E0B;">
            <h4 style="margin:0 0 16px 0; color:#F59E0B;">
                <i class="fas fa-file-upload me-2"></i> {{ __('messages.documents') }}
            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div class="form-group">
    <label for="document_pan">{{ __('messages.pan_certificate') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="file" name="documents[pan]" id="document_pan" accept=".jpg,.jpeg,.png,.pdf">
</div>
                <div class="form-group">
                    <label for="document_citizenship">{{ __('messages.citizenship_copy') }} <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[citizenship]" id="document_citizenship" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <div class="form-group">
    <label for="document_license">{{ __('messages.business_registration_certificate') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="file" name="documents[license]" id="document_license" accept=".jpg,.jpeg,.png,.pdf">
</div>
                <div class="form-group">
    <label for="document_municipality">{{ __('messages.municipality_certificate') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="file" name="documents[municipality]" id="document_municipality" accept=".jpg,.jpeg,.png,.pdf">
</div>
                
                <div class="form-group" style="grid-column:2/3;">
                    <label for="document_signboard">{{ __('messages.signboard_building_image') }} <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[signboard]" id="document_signboard" accept=".jpg,.jpeg,.png" required>
                    <small style="color:#64748b; font-size:0.75rem;">{{ __('messages.help_signboard_image') }}</small>
                </div>
                <div class="form-group" style="grid-column:1/3;">
                    <label for="document_additional">{{ __('messages.additional_documents_optional') }}</label>
                    <input type="file" name="documents[additional]" id="document_additional" accept=".jpg,.jpeg,.png,.pdf" multiple>
                </div>
            </div>
            <small style="color:#64748b; display:block; margin-top:8px; font-size:0.75rem;">
                <i class="fas fa-info-circle"></i> 
                {{ __('messages.help_allowed_formats') }}
            </small>
        </div>

        {{-- ===== Section 5: Payment Status ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #EF4444;">
            <h4 style="margin:0 0 16px 0; color:#EF4444;">
                <i class="fas fa-credit-card me-2"></i> {{ __('messages.payment_status') }}
            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="payment_status">{{ __('messages.payment_status') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
<select name="payment_status" id="payment_status">
                        <option value="pending" selected>{{ __('messages.payment_pending') }}</option>
                        <option value="submitted">{{ __('messages.payment_submitted') }}</option>
                        <option value="verified">{{ __('messages.payment_verified') }}</option>
                        <option value="rejected">{{ __('messages.payment_rejected') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_method">भुक्तानी विधि <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
                    <select name="payment_method" id="payment_method">
                        <option value="">{{ __('messages.select') }}</option>
                        <option value="bank">{{ __('messages.payment_bank_transfer') }}</option>
                        <option value="qr">{{ __('messages.payment_qr_scan') }}</option>
                        <option value="cash">{{ __('messages.payment_cash_front_desk') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
<label for="payment_transaction_id">कारोबार ID <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>                <input type="text" name="payment_transaction_id" id="payment_transaction_id" value="{{ old('payment_transaction_id') }}" placeholder="{{ __('messages.placeholder_transaction_id') }}">
            </div>
        </div>

        {{-- ===== Section 6: Source (hidden) ===== --}}
        <input type="hidden" name="source" value="admin">

        {{-- ===== Submit Buttons ===== --}}
        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> {{ __('messages.register') }}
            </button>
            <a href="{{ route('admin.registrations.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const municipalitySelect = document.getElementById('municipality');

        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            districtSelect.innerHTML = '<option value="">' + '{{ __("messages.select_district") }}' + '</option>';
            municipalitySelect.innerHTML = '<option value="">' + '{{ __("messages.select_municipality") }}' + '</option>';
            if (provinceId) {
                fetch(`/api/districts/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.id;
                            option.textContent = district.name;
                            districtSelect.appendChild(option);
                        });
                    })
                    .catch(() => {});
            }
        });

        districtSelect.addEventListener('change', function() {
            const districtId = this.value;
            municipalitySelect.innerHTML = '<option value="">' + '{{ __("messages.select_municipality") }}' + '</option>';
            if (districtId) {
                fetch(`/api/municipalities/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(municipality => {
                            const option = document.createElement('option');
                            option.value = municipality.id;
                            option.textContent = municipality.name;
                            municipalitySelect.appendChild(option);
                        });
                    })
                    .catch(() => {});
            }
        });

        if (provinceSelect.value) {
            provinceSelect.dispatchEvent(new Event('change'));
            if (districtSelect.value) {
                districtSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
@endpush
@endsection