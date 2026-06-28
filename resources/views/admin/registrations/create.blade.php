@extends('layouts.admin')

@section('title', 'नयाँ दर्ता - HEAN Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">नयाँ दर्ता</h2>
    <a href="{{ route('admin.registrations.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> फिर्ता
    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="{{ route('admin.registrations.store') }}" method="POST" enctype="multipart/form-data" class="dashboard-form">
        @csrf

        {{-- ===== Section 1: Hostel Details ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
            <h4 style="margin:0 0 16px 0; color:#0EA5E9;">🏨 होस्टेल विवरण</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="name_nepali">होस्टेल नाम (नेपाली) <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="name_nepali" id="name_nepali" value="{{ old('name_nepali') }}" required>
                </div>
                <div class="form-group">
                    <label for="name_english">होस्टेल नाम (अंग्रेजी)</label>
                    <input type="text" name="name_english" id="name_english" value="{{ old('name_english') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="pan">PAN नम्बर</label>
                    <input type="text" name="pan" id="pan" value="{{ old('pan') }}" placeholder="जस्तै: 123456789">
                    <small style="color:#64748b; font-size:0.75rem;">PAN मिल्ने आवेदन स्वतः ब्लक हुनेछ।</small>
                </div>
                <div class="form-group">
                    <label for="registration_number">दर्ता नम्बर</label>
                    <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number') }}" placeholder="जस्तै: HEAN-2025-001">
                    <small style="color:#64748b; font-size:0.75rem;">दर्ता नम्बर मिल्ने आवेदन स्वतः ब्लक हुनेछ।</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="capacity">कुल बेड संख्या <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 0) }}" min="0" required>
                    <small style="color:#64748b; font-size:0.75rem;">होस्टेलमा रहन सक्ने कुल विद्यार्थी/व्यक्ति संख्या।</small>
                </div>
                <div class="form-group">
                    <label for="rooms">कुल कोठा संख्या</label>
                    <input type="number" name="rooms" id="rooms" value="{{ old('rooms', 0) }}" min="0">
                    <small style="color:#64748b; font-size:0.75rem;">वैकल्पिक, कोठाको संख्या।</small>
                </div>
            </div>
        </div>

        {{-- ===== Section 2: Owner Details ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #10B981;">
            <h4 style="margin:0 0 16px 0; color:#10B981;">👤 सञ्चालक / आवेदक विवरण</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="operator_name">सञ्चालकको नाम <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="operator_name" id="operator_name" value="{{ old('operator_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="operator_email">इमेल</label>
                    <input type="email" name="operator_email" id="operator_email" value="{{ old('operator_email') }}" placeholder="operator@email.com">
                </div>
            </div>
            <div class="form-group">
                <label for="contact">सम्पर्क नम्बर <span style="color:#dc2626;">*</span></label>
                <input type="text" name="contact" id="contact" value="{{ old('contact') }}" required>
                <small style="color:#64748b; font-size:0.75rem;">यो नम्बर पहिले नै प्रयोग भएको छ भने warning देखिनेछ।</small>
            </div>
        </div>

        {{-- ===== Section 3: Address ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #8B5CF6;">
            <h4 style="margin:0 0 16px 0; color:#8B5CF6;">📍 होस्टेलको ठेगाना</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="district">जिल्ला <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="district" id="district" value="{{ old('district') }}" required>
                </div>
                <div class="form-group">
                    <label for="municipality">नगरपालिका <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="municipality" id="municipality" value="{{ old('municipality') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="ward">वडा <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="ward" id="ward" value="{{ old('ward') }}" required>
                </div>
                <div class="form-group">
                    <label for="street">सडक / टोल</label>
                    <input type="text" name="street" id="street" value="{{ old('street') }}">
                </div>
            </div>
            <div class="form-group">
                <label for="description">विवरण / सुविधाहरू</label>
                <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- ===== Section 4: Documents Upload ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #F59E0B;">
            <h4 style="margin:0 0 16px 0; color:#F59E0B;">📎 कागजातहरू (अधिकतम ८ फाइल)</h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div class="form-group">
                    <label for="document_pan">PAN प्रमाण</label>
                    <input type="file" name="documents[pan]" id="document_pan" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="form-group">
                    <label for="document_citizenship">नागरिकता</label>
                    <input type="file" name="documents[citizenship]" id="document_citizenship" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="form-group">
                    <label for="document_license">व्यवसाय दर्ता प्रमाण</label>
                    <input type="file" name="documents[license]" id="document_license" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="form-group">
                    <label for="document_municipality">नगरपालिका प्रमाण</label>
                    <input type="file" name="documents[municipality]" id="document_municipality" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="form-group" style="grid-column:1/2;">
                    <label for="document_photos">होस्टेल फोटोहरू</label>
                    <input type="file" name="documents[photos]" id="document_photos" accept=".jpg,.jpeg,.png" multiple>
                </div>
                <div class="form-group" style="grid-column:2/3;">
                    <label for="document_additional">अतिरिक्त कागजात</label>
                    <input type="file" name="documents[additional]" id="document_additional" accept=".jpg,.jpeg,.png,.pdf" multiple>
                </div>
            </div>
            <small style="color:#64748b; display:block; margin-top:8px; font-size:0.75rem;">
                <i class="fas fa-info-circle"></i> 
                अनुमति दिइएका फार्म्याट: JPG, JPEG, PNG, PDF | अधिकतम ८ फाइल
            </small>
        </div>

        {{-- ===== Section 5: Payment Status (Admin) ===== --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #EF4444;">
            <h4 style="margin:0 0 16px 0; color:#EF4444;">💰 भुक्तानी स्थिति</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="payment_status">भुक्तानी स्थिति</label>
                    <select name="payment_status" id="payment_status">
                        <option value="pending" selected>पेन्डिङ</option>
                        <option value="submitted">पेश गरिएको</option>
                        <option value="verified">प्रमाणित</option>
                        <option value="rejected">अस्वीकृत</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_method">भुक्तानी माध्यम</label>
                    <select name="payment_method" id="payment_method">
                        <option value="">छान्नुहोस्</option>
                        <option value="bank">बैंक स्थानान्तरण</option>
                        <option value="qr">QR स्क्यान</option>
                        <option value="cash">नगद (फ्रन्ट डेस्क)</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="payment_transaction_id">Transaction ID</label>
                <input type="text" name="payment_transaction_id" id="payment_transaction_id" value="{{ old('payment_transaction_id') }}" placeholder="यदि भुक्तानी भएको छ भने Transaction ID">
            </div>
        </div>

        {{-- ===== Section 6: Source (hidden) ===== --}}
        <input type="hidden" name="source" value="admin">

        {{-- ===== Submit Buttons ===== --}}
        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> दर्ता गर्नुहोस्
            </button>
            <a href="{{ route('admin.registrations.index') }}" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">रद्द गर्नुहोस्</a>
        </div>
    </form>
</div>
@endsection