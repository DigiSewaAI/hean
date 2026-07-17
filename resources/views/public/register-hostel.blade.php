@extends('layouts.public')

@section('title', 'Hostel Registration - HEAN')

@section('content')
<div class="container py-5" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div style="margin-bottom:24px;">
                <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0;">
                    <i class="fas fa-hotel me-2" style="color:#0EA5E9;"></i> Hostel Registration
                </h2>
                <p style="color:#64748b; margin-top:4px; font-size:0.95rem;">
                    Please fill all required fields to register your hostel
                </p>
            </div>

            <div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">

                @if($errors->any())
                    <div class="alert alert-danger" style="padding:12px 20px; border-radius:12px; background:#fef2f2; border-left:4px solid #dc2626; margin-bottom:24px;">
                        <i class="fas fa-exclamation-circle" style="color:#dc2626; margin-right:8px;"></i>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('register.hostel.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                    @csrf

                    {{-- ===== Section 1: Hostel Information ===== --}}
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
                        <h4 style="margin:0 0 16px 0; color:#0EA5E9;">
                            <i class="fas fa-building me-2"></i> Hostel Information
                        </h4>
                        <div class="row g-3">
                            {{-- Hostel Name (Nepali) --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hostel_name" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Hostel Name (Nepali) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="hostel_name" id="hostel_name" value="{{ old('hostel_name') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('hostel_name') is-invalid @enderror"
                                           placeholder="e.g. सूर्योदय ब्वाइज होस्टेल" required>
                                    @error('hostel_name') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Hostel Name (English) --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hostel_name_english" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Hostel Name (English) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="hostel_name_english" id="hostel_name_english" value="{{ old('hostel_name_english') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('hostel_name_english') is-invalid @enderror"
                                           placeholder="e.g. Suryoday Boys Hostel" required>
                                    @error('hostel_name_english') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- ✅ 8.1: Block / Building Name --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="block_name" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        ब्लक / भवन नाम <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
                                    </label>
                                    <input type="text" name="block_name" id="block_name" value="{{ old('block_name') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('block_name') is-invalid @enderror"
                                           placeholder="जस्तै: Block A, Main Building">
                                    @error('block_name') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                    <small style="color:#64748b; font-size:0.75rem;">यदि एउटै ठेगानामा धेरै ब्लक छन् भने छुट्याउन प्रयोग गर्नुहोस्।</small>
                                </div>
                            </div>

                            {{-- Local Registration Number --}}
<div class="col-md-12">
    <div class="form-group">
        <label for="local_registration_number" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            {{ __('messages.local_registration_number') }} <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="text" name="local_registration_number" id="local_registration_number"
               value="{{ old('local_registration_number') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
               class="form-control @error('local_registration_number') is-invalid @enderror"
               placeholder="{{ __('messages.placeholder_local_registration_number') }}">
        @error('local_registration_number')
            <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
        @enderror
        <small style="color:#64748b; font-size:0.75rem;">
            <i class="fas fa-info-circle"></i>
            {{ __('messages.help_local_registration_number') }}
        </small>
    </div>
</div>

                            {{-- Type --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hostel_type" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Type <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="hostel_type" id="hostel_type"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select @error('hostel_type') is-invalid @enderror" required>
                                        <option value="">Select</option>
                                        <option value="boys" {{ old('hostel_type')=='boys'?'selected':'' }}>Boys</option>
                                        <option value="girls" {{ old('hostel_type')=='girls'?'selected':'' }}>Girls</option>
                                        <option value="co-ed" {{ old('hostel_type')=='co-ed'?'selected':'' }}>Co-Ed</option>
                                    </select>
                                    @error('hostel_type') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Capacity --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="capacity" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Total Beds (Capacity) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('capacity') is-invalid @enderror" min="1" required>
                                    @error('capacity') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Rooms --}}
    <div class="col-md-3">
    <div class="form-group">
        <label for="rooms" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            Total Rooms <span style="color:#dc2626;">*</span>
        </label>
        <input type="number" name="rooms" id="rooms" value="{{ old('rooms') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
               class="form-control @error('rooms') is-invalid @enderror" min="1" required>
        @error('rooms') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
        <small style="color:#64748b; font-size:0.75rem;">Total number of rooms in the hostel.</small>
    </div>
</div>

                            {{-- Established Year --}}
                            <div class="col-md-3">
    <div class="form-group">
        <label for="established_year" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            Established Year <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="number" name="established_year" id="established_year" value="{{ old('established_year') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
               class="form-control @error('established_year') is-invalid @enderror" min="1900" max="{{ date('Y') }}">
        @error('established_year') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
    </div>
</div>

                            {{-- Contact --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Contact Number <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('contact_number') is-invalid @enderror" required>
                                    @error('contact_number') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                    {{-- ✅ 8.2: Contact helper message --}}
                                    <small style="color:#64748b; font-size:0.75rem;">
                                        <i class="fas fa-info-circle"></i> 
                                        सम्पर्क नम्बर सञ्चारको लागि हो। एउटै नम्बर धेरै होस्टलको लागि प्रयोग गर्न सकिन्छ।
                                    </small>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-4">
    <div class="form-group">
        <label for="email" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            Email Address <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
               class="form-control @error('email') is-invalid @enderror">
        @error('email') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
        <small style="color:#64748b; font-size:0.75rem;">
            <i class="fas fa-info-circle"></i> 
            इमेल सञ्चार र प्रमाणीकरणको लागि हो। एउटै इमेल धेरै होस्टलको लागि प्रयोग गर्न सकिन्छ।
        </small>
    </div>
</div>

                            {{-- Website (Optional) --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="website" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
    वेबसाइट <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
</label>
                                    <input type="url" name="website" id="website" value="{{ old('website') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('website') is-invalid @enderror" placeholder="https://example.com">
                                    @error('website') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Description (Optional) --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
    विवरण <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
</label>
                                    <textarea name="description" id="description" rows="3"
                                              style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== Section 2: Owner / Manager Information ===== --}}
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #10B981;">
                        <h4 style="margin:0 0 16px 0; color:#10B981;">
                            <i class="fas fa-user-tie me-2"></i> Owner / Manager Information
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="owner_name" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Full Name <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('owner_name') is-invalid @enderror" required>
                                    @error('owner_name') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
    <div class="form-group">
        <label for="pan" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            PAN Number <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="text" name="pan" id="pan" value="{{ old('pan') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
               class="form-control @error('pan') is-invalid @enderror" placeholder="e.g. 123456789">
        @error('pan') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
        <small style="color:#64748b; font-size:0.75rem;">
            <i class="fas fa-info-circle"></i> 
            PAN नम्बर केवल प्रमाणीकरणको लागि हो। एउटै PAN मा धेरै होस्टल दर्ता गर्न सकिन्छ।
        </small>
    </div>
</div>
                        </div>
                    </div>

                    {{-- ===== Section 3: Address (Dynamic Dropdowns) ===== --}}
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #8B5CF6;">
                        <h4 style="margin:0 0 16px 0; color:#8B5CF6;">
                            <i class="fas fa-map-marker-alt me-2"></i> Address
                        </h4>
                        <div class="row g-3">
                            {{-- Province --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Province <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="province" id="province"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select @error('province') is-invalid @enderror" required>
                                        <option value="">Select Province</option>
                                        @foreach(\App\Models\Province::orderBy('name')->get() as $prov)
                                            <option value="{{ $prov->id }}" {{ old('province')==$prov->id?'selected':'' }}>{{ $prov->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- District --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="district" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        District <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="district" id="district"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select @error('district') is-invalid @enderror" required>
                                        <option value="">Select District</option>
                                    </select>
                                    @error('district') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Municipality --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="municipality" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Municipality <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="municipality" id="municipality"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select @error('municipality') is-invalid @enderror" required>
                                        <option value="">Select Municipality</option>
                                    </select>
                                    @error('municipality') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Ward --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ward" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Ward <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="number" name="ward" id="ward" value="{{ old('ward') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('ward') is-invalid @enderror" min="1" max="32" required>
                                    @error('ward') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Street / Tole --}}
                            <div class="col-md-5">
    <div class="form-group">
        <label for="street" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            Street / Tole <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="text" name="street" id="street" value="{{ old('street') }}"
               style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
               class="form-control @error('street') is-invalid @enderror">
        @error('street') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
    </div>
</div>

                            {{-- Landmark (Optional) --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="landmark" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
    स्थलचिन्ह <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
</label>
                                    <input type="text" name="landmark" id="landmark" value="{{ old('landmark') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('landmark') is-invalid @enderror" placeholder="e.g. Near Bus Park">
                                    @error('landmark') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== Section 4: Documents ===== --}}
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #F59E0B;">
                        <h4 style="margin:0 0 16px 0; color:#F59E0B;">
                            <i class="fas fa-file-upload me-2"></i> Documents
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
    <div class="form-group">
        <label for="documents_registration_certificate" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            Business Registration Certificate <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="file" name="documents[registration_certificate]" id="documents_registration_certificate"
               style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
               class="form-control @error('documents.registration_certificate') is-invalid @enderror"
               accept=".pdf,.jpg,.jpeg,.png">
        @error('documents.registration_certificate') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
    </div>
</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_citizenship_copy" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Citizenship Copy (Owner) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="file" name="documents[citizenship_copy]" id="documents_citizenship_copy"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control @error('documents.citizenship_copy') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png" required>
                                    @error('documents.citizenship_copy') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
    <div class="form-group">
        <label for="documents_pan_certificate" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            PAN Certificate <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="file" name="documents[pan_certificate]" id="documents_pan_certificate"
               style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
               class="form-control @error('documents.pan_certificate') is-invalid @enderror"
               accept=".pdf,.jpg,.jpeg,.png">
        @error('documents.pan_certificate') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
    </div>
</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_signboard" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Signboard / Hostel Building Image <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="file" name="documents[signboard]" id="documents_signboard"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control @error('documents.signboard') is-invalid @enderror"
                                           accept=".jpg,.jpeg,.png" required>
                                    @error('documents.signboard') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                    <small style="color:#64748b; font-size:0.75rem;">Clear photo of the hostel signboard or building.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_other_documents" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
    अन्य सहायक कागजातहरू <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
</label>
                                    <input type="file" name="documents[other_documents]" id="documents_other_documents"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control @error('documents.other_documents') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    @error('documents.other_documents') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <small style="color:#64748b; display:block; margin-top:8px; font-size:0.75rem;">
                            <i class="fas fa-info-circle"></i> 
                            Accepted formats: PDF, JPG, JPEG, PNG (max 2MB each)
                        </small>
                    </div>

{{-- Municipality Certificate (Optional) --}}
<div class="col-md-6">
    <div class="form-group">
        <label for="documents_municipality" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
            Municipality Certificate <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
        </label>
        <input type="file" name="documents[municipality]" id="documents_municipality"
               style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
               class="form-control @error('documents.municipality') is-invalid @enderror"
               accept=".pdf,.jpg,.jpeg,.png">
        @error('documents.municipality') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
    </div>
</div>

                    {{-- ===== Section 5: Payment (Optional) ===== --}}
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #EF4444;">
                        <h4 style="margin:0 0 16px 0; color:#EF4444;">
    <i class="fas fa-credit-card me-2"></i> भुक्तानी <span style="font-size:0.85rem; font-weight:400; color:#64748b;">(वैकल्पिक)</span>
</h4>
                        <div class="alert alert-info" style="background:#f0f9ff; border-left:4px solid #0EA5E9; padding:12px 16px; border-radius:8px; margin-bottom:16px;">
                            <i class="fas fa-info-circle" style="color:#0EA5E9; margin-right:8px;"></i>
                            If you have already made payment, fill in the details below. Otherwise, you can pay later.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_method" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
    भुक्तानी विधि <span style="color:#64748b; font-weight:400;">(वैकल्पिक)</span>
</label>
                                    <select name="payment_method" id="payment_method"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select @error('payment_method') is-invalid @enderror">
                                        <option value="">Select</option>
                                        <option value="bank" {{ old('payment_method')=='bank'?'selected':'' }}>Bank Transfer</option>
                                        <option value="esewa" {{ old('payment_method')=='esewa'?'selected':'' }}>eSewa</option>
                                        <option value="khalti" {{ old('payment_method')=='khalti'?'selected':'' }}>Khalti</option>
                                    </select>
                                    @error('payment_method') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="transaction_id" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Transaction ID
                                    </label>
                                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('transaction_id') is-invalid @enderror">
                                    @error('transaction_id') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_amount" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Amount (NPR)
                                    </label>
                                    <input type="number" name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('payment_amount') is-invalid @enderror" step="0.01">
                                    @error('payment_amount') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_date" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Payment Date
                                    </label>
                                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('payment_date') is-invalid @enderror">
                                    @error('payment_date') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank_name" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Bank Name
                                    </label>
                                    <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('bank_name') is-invalid @enderror">
                                    @error('bank_name') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank_account" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Bank Account Number
                                    </label>
                                    <input type="text" name="bank_account" id="bank_account" value="{{ old('bank_account') }}"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control @error('bank_account') is-invalid @enderror">
                                    @error('bank_account') <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; gap:12px; margin-top:20px;">
                        <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                            <i class="fas fa-save"></i> Submit Registration
                        </button>
                        <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Dynamic Dropdowns =====
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const municipalitySelect = document.getElementById('municipality');

        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            districtSelect.innerHTML = '<option value="">Select District</option>';
            municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
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
                    });
            }
        });

        districtSelect.addEventListener('change', function() {
            const districtId = this.value;
            municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
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
                    });
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