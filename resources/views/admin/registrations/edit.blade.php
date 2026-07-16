@extends('layouts.admin')

@section('title', __('messages.edit_registration') . ' - ' . ($registration->registration_number ?? '#'.$registration->id) . ' - HEAN Admin')

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

{{-- ===== HEADER ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
    <i class="fas fa-edit" style="color:#F59E0B;"></i>
    {{ __('messages.edit_registration') }}
    <span style="font-weight:700; color:#0EA5E9;">
        {{ $registration->registration_number ?? '#'.$registration->id }}
    </span>
        <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
            {{ $registration->created_at ? $registration->created_at->format('M d, Y') : __('messages.not_available') }}
        </span>
    </h2>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <a href="{{ route('admin.registrations.show', $registration) }}" 
           style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
        </a>
    </div>
</div>

{{-- ===== MAIN CARD ===== --}}
<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04); border:1px solid #e2e8f0;">

    <form action="{{ route('admin.registrations.update', $registration) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ============================================================ --}}
        {{-- SECTION 1: HOSTEL INFORMATION --}}
        {{-- ============================================================ --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
            <h4 style="margin:0 0 16px 0; color:#0EA5E9; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-building"></i> {{ __('messages.hostel_information') }}
            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.hostel_name_nepali') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="hostel_name" value="{{ old('hostel_name', $registration->hostel_name) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" required>
                </div>
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.hostel_name_english') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="hostel_name_english" value="{{ old('hostel_name_english', $registration->hostel_name_english) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" required>
                </div>
            </div>

            {{-- Local Registration Number --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:12px;">
    <div style="grid-column: span 2;">
        <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">
            {{ __('messages.local_registration_number') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="text" name="local_registration_number"
               value="{{ old('local_registration_number', $registration->local_registration_number) }}"
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

            {{-- ✅ 8.1: Block / Building Name --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:12px;">
                <div style="grid-column: span 2;">
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">ब्लक / भवन नाम <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
                    <input type="text" name="block_name" value="{{ old('block_name', $registration->block_name) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" 
                           placeholder="जस्तै: Block A, Main Building">
                    @error('block_name')
                        <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                    <small style="color:#64748b; font-size:0.75rem;">यदि एउटै ठेगानामा धेरै ब्लक छन् भने छुट्याउन प्रयोग गर्नुहोस्।</small>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:16px; margin-top:12px;">
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.type') }} <span style="color:#dc2626;">*</span></label>
                    <select name="hostel_type" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;" required>
                        <option value="boys" {{ old('hostel_type', $registration->hostel_type) == 'boys' ? 'selected' : '' }}>Boys</option>
                        <option value="girls" {{ old('hostel_type', $registration->hostel_type) == 'girls' ? 'selected' : '' }}>Girls</option>
                        <option value="co-ed" {{ old('hostel_type', $registration->hostel_type) == 'co-ed' ? 'selected' : '' }}>Co-Ed</option>
                    </select>
                </div>
                <div>
    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.established_year') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="number" name="established_year" value="{{ old('established_year', $registration->established_year) }}" 
           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" min="1900" max="{{ date('Y') }}">
</div>
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.total_beds') }} <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', $registration->capacity) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" min="0" required>
                </div>
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.total_rooms') }} <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="rooms" value="{{ old('rooms', $registration->rooms) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" min="0" required>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-top:12px;">
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.contact_number') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="contact" value="{{ old('contact', $registration->contact) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" required>
                    {{-- ✅ 8.2: Contact helper message --}}
                    <small style="color:#64748b; font-size:0.75rem;">
                        <i class="fas fa-info-circle"></i> 
                        सम्पर्क नम्बर सञ्चारको लागि हो। एउटै नम्बर धेरै होस्टलको लागि प्रयोग गर्न सकिन्छ।
                    </small>
                </div>
                <div>
    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.email_address') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="email" name="email" value="{{ old('email', $registration->email) }}" 
           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;">
    <small style="color:#64748b; font-size:0.75rem;">
        <i class="fas fa-info-circle"></i> 
        इमेल सञ्चार र प्रमाणीकरणको लागि हो। एउटै इमेल धेरै होस्टलको लागि प्रयोग गर्न सकिन्छ।
    </small>
</div>
                <div>
<label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">वेबसाइट <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>                    <input type="url" name="website" value="{{ old('website', $registration->website) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" placeholder="https://example.com">
                </div>
            </div>
            <div style="margin-top:12px;">
<label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">विवरण / सुविधाहरू <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>                <textarea name="description" rows="3" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s; resize:vertical;">{{ old('description', $registration->description) }}</textarea>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- SECTION 2: OWNER INFORMATION --}}
        {{-- ============================================================ --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #10B981;">
            <h4 style="margin:0 0 16px 0; color:#10B981; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-user-tie"></i> {{ __('messages.owner_applicant_information') }}
            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.full_name') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="operator_name" value="{{ old('operator_name', $registration->operator_name) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" required>
                </div>
                <div>
    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.pan_number') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="text" name="pan" value="{{ old('pan', $registration->pan) }}" 
           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;">
    <small style="color:#64748b; font-size:0.75rem;">
        <i class="fas fa-info-circle"></i> 
        PAN नम्बर केवल प्रमाणीकरणको लागि हो। एउटै PAN मा धेरै होस्टल दर्ता गर्न सकिन्छ।
    </small>
</div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- SECTION 3: ADDRESS --}}
        {{-- ============================================================ --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #8B5CF6;">
            <h4 style="margin:0 0 16px 0; color:#8B5CF6; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-map-marker-alt"></i> {{ __('messages.address') }}
            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.province') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="province" value="{{ old('province', $registration->province) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" required>
                </div>
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.district') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="district" value="{{ old('district', $registration->district) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" required>
                </div>
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.municipality') }} <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="municipality" value="{{ old('municipality', $registration->municipality) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" required>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-top:12px;">
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.ward_number') }} <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="ward" value="{{ old('ward', $registration->ward) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" min="1" max="32" required>
                </div>
                <div>
    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.street_tole') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>
    <input type="text" name="street" value="{{ old('street', $registration->street) }}" 
           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;">
</div>
                <div>
<label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">स्थलचिन्ह <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span></label>                    <input type="text" name="landmark" value="{{ old('landmark', $registration->landmark) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s;" placeholder="e.g. Near Bus Park">
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- SECTION 4: STATUS & REGISTRATION NUMBER --}}
        {{-- ============================================================ --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #EF4444;">
            <h4 style="margin:0 0 16px 0; color:#EF4444; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-flag"></i> {{ __('messages.status_registration') }}
            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.status') }} <span style="color:#dc2626;">*</span></label>
                    <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;" required>
                        <option value="pending" {{ old('status', $registration->status) == 'pending' ? 'selected' : '' }}>{{ __('messages.status_pending') }}</option>
                        <option value="approved" {{ old('status', $registration->status) == 'approved' ? 'selected' : '' }}>{{ __('messages.status_approved') }}</option>
                        <option value="active" {{ old('status', $registration->status) == 'active' ? 'selected' : '' }}>{{ __('messages.status_active') }}</option>
                        <option value="rejected" {{ old('status', $registration->status) == 'rejected' ? 'selected' : '' }}>{{ __('messages.status_rejected') }}</option>
                        <option value="duplicate" {{ old('status', $registration->status) == 'duplicate' ? 'selected' : '' }}>{{ __('messages.status_duplicate') }}</option>
                        <option value="awaiting_payment" {{ old('status', $registration->status) == 'awaiting_payment' ? 'selected' : '' }}>{{ __('messages.status_awaiting_payment') }}</option>
                    </select>
                </div>
                <div>
                    <label style="font-weight:600; color:#1e293b; font-size:0.85rem; display:block; margin-bottom:4px;">{{ __('messages.registration_number') }}</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number', $registration->registration_number) }}" 
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; transition:0.3s; background:#f1f5f9;" readonly>
                    <small style="color:#94a3b8; font-size:0.7rem;">{{ __('messages.registration_number_readonly') }}</small>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- SUBMIT BUTTONS --}}
        {{-- ============================================================ --}}
        <div style="display:flex; gap:12px; margin-top:20px; padding-top:20px; border-top:1px solid #e2e8f0;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:12px 32px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                <i class="fas fa-save"></i> {{ __('messages.update') }}
            </button>
            <a href="{{ route('admin.registrations.show', $registration) }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:12px 32px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">
                <i class="fas fa-times"></i> {{ __('messages.cancel') }}
            </a>
        </div>

    </form>
</div>

@endsection