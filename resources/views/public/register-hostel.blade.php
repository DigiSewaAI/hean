@extends('layouts.public')

@section('title', 'Register Hostel - HEAN')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-hotel me-2"></i> Hostel Registration
                    </h4>
                    <small class="text-white-50">Please fill all required fields to register your hostel</small>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> Please correct the errors below.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('register.hostel.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Section 1: Hostel Information -->
                        <div class="section mb-4">
                            <h5 class="border-bottom pb-2 text-primary"><i class="fas fa-building me-2"></i> Hostel Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Hostel Name <span class="text-danger">*</span></label>
                                    <input type="text" name="hostel_name" class="form-control @error('hostel_name') is-invalid @enderror" value="{{ old('hostel_name') }}" required>
                                    @error('hostel_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Type <span class="text-danger">*</span></label>
                                    <select name="hostel_type" class="form-select @error('hostel_type') is-invalid @enderror" required>
                                        <option value="">Select</option>
                                        <option value="boys" {{ old('hostel_type')=='boys'?'selected':'' }}>Boys</option>
                                        <option value="girls" {{ old('hostel_type')=='girls'?'selected':'' }}>Girls</option>
                                        <option value="co-ed" {{ old('hostel_type')=='co-ed'?'selected':'' }}>Co-Ed</option>
                                    </select>
                                    @error('hostel_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Capacity (beds) <span class="text-danger">*</span></label>
                                    <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity') }}" min="1" required>
                                    @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Established Year <span class="text-danger">*</span></label>
                                    <input type="number" name="established_year" class="form-control @error('established_year') is-invalid @enderror" value="{{ old('established_year') }}" min="1900" max="{{ date('Y') }}" required>
                                    @error('established_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}" required>
                                    @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Website</label>
                                    <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                                    @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Owner Information -->
                        <div class="section mb-4">
                            <h5 class="border-bottom pb-2 text-success"><i class="fas fa-user-tie me-2"></i> Owner / Manager Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" value="{{ old('owner_name') }}" required>
                                    @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">PAN Number</label>
                                    <input type="text" name="pan" class="form-control @error('pan') is-invalid @enderror" value="{{ old('pan') }}">
                                    @error('pan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Registration Number</label>
                                    <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ old('registration_number') }}">
                                    @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Address -->
                        <div class="section mb-4">
                            <h5 class="border-bottom pb-2 text-info"><i class="fas fa-map-marker-alt me-2"></i> Address</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Province <span class="text-danger">*</span></label>
                                    <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province') }}" required>
                                    @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">District <span class="text-danger">*</span></label>
                                    <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}" required>
                                    @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Municipality <span class="text-danger">*</span></label>
                                    <input type="text" name="municipality" class="form-control @error('municipality') is-invalid @enderror" value="{{ old('municipality') }}" required>
                                    @error('municipality') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Ward <span class="text-danger">*</span></label>
                                    <input type="text" name="ward" class="form-control @error('ward') is-invalid @enderror" value="{{ old('ward') }}" required>
                                    @error('ward') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">Street / Tole</label>
                                    <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}">
                                    @error('street') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Landmark</label>
                                    <input type="text" name="landmark" class="form-control @error('landmark') is-invalid @enderror" value="{{ old('landmark') }}">
                                    @error('landmark') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Documents -->
                        <div class="section mb-4">
                            <h5 class="border-bottom pb-2 text-warning"><i class="fas fa-file-upload me-2"></i> Documents</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Registration Certificate <span class="text-danger">*</span></label>
                                    <input type="file" name="documents[registration_certificate]" class="form-control @error('documents.registration_certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                    @error('documents.registration_certificate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Citizenship Copy (Owner) <span class="text-danger">*</span></label>
                                    <input type="file" name="documents[citizenship_copy]" class="form-control @error('documents.citizenship_copy') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                    @error('documents.citizenship_copy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">PAN Certificate</label>
                                    <input type="file" name="documents[pan_certificate]" class="form-control @error('documents.pan_certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                    @error('documents.pan_certificate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Other Supporting Documents</label>
                                    <input type="file" name="documents[other_documents]" class="form-control @error('documents.other_documents') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                    @error('documents.other_documents') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <small class="text-muted">Accepted formats: PDF, JPG, JPEG, PNG (max 2MB each)</small>
                        </div>

                        <!-- Section 5: Payment -->
                        <div class="section mb-4">
                            <h5 class="border-bottom pb-2 text-danger"><i class="fas fa-credit-card me-2"></i> Payment (Optional)</h5>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> If you have already made payment, fill in the details below. Otherwise, you can pay later.
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Payment Method</label>
                                    <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                                        <option value="">Select</option>
                                        <option value="bank" {{ old('payment_method')=='bank'?'selected':'' }}>Bank Transfer</option>
                                        <option value="esewa" {{ old('payment_method')=='esewa'?'selected':'' }}>eSewa</option>
                                        <option value="khalti" {{ old('payment_method')=='khalti'?'selected':'' }}>Khalti</option>
                                    </select>
                                    @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Transaction ID</label>
                                    <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" value="{{ old('transaction_id') }}">
                                    @error('transaction_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Amount (NPR)</label>
                                    <input type="number" name="payment_amount" class="form-control @error('payment_amount') is-invalid @enderror" value="{{ old('payment_amount') }}" step="0.01">
                                    @error('payment_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Payment Date</label>
                                    <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}">
                                    @error('payment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}">
                                    @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Bank Account Number</label>
                                    <input type="text" name="bank_account" class="form-control @error('bank_account') is-invalid @enderror" value="{{ old('bank_account') }}">
                                    @error('bank_account') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i> Submit Registration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection