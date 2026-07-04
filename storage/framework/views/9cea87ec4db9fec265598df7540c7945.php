

<?php $__env->startSection('title', __('messages.new_registration_title') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>

<?php if($errors->any()): ?>
    <div style="background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
        <ul style="margin:0; padding-left:20px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-plus-circle me-2" style="color:#0EA5E9;"></i> <?php echo e(__('messages.new_registration_title')); ?>

    </h2>
    <a href="<?php echo e(route('admin.registrations.index')); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back')); ?>

    </a>
</div>

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <form action="<?php echo e(route('admin.registrations.store')); ?>" method="POST" enctype="multipart/form-data" class="dashboard-form">
        <?php echo csrf_field(); ?>

        
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
            <h4 style="margin:0 0 16px 0; color:#0EA5E9;">
                <i class="fas fa-building me-2"></i> <?php echo e(__('messages.hostel_information')); ?>

            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="hostel_name"><?php echo e(__('messages.hostel_name_nepali')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="hostel_name" id="hostel_name" value="<?php echo e(old('hostel_name')); ?>" placeholder="<?php echo e(__('messages.placeholder_hostel_name_nepali')); ?>" required>
                </div>
                <div class="form-group">
                    <label for="hostel_name_english"><?php echo e(__('messages.hostel_name_english')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="hostel_name_english" id="hostel_name_english" value="<?php echo e(old('hostel_name_english')); ?>" placeholder="<?php echo e(__('messages.placeholder_hostel_name_english')); ?>" required>
                </div>
            </div>

            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="hostel_type"><?php echo e(__('messages.type')); ?> <span style="color:#dc2626;">*</span></label>
                    <select name="hostel_type" id="hostel_type" required>
                        <option value=""><?php echo e(__('messages.select')); ?></option>
                        <option value="boys" <?php echo e(old('hostel_type')=='boys'?'selected':''); ?>><?php echo e(__('messages.boys')); ?></option>
                        <option value="girls" <?php echo e(old('hostel_type')=='girls'?'selected':''); ?>><?php echo e(__('messages.girls')); ?></option>
                        <option value="co-ed" <?php echo e(old('hostel_type')=='co-ed'?'selected':''); ?>><?php echo e(__('messages.co_ed')); ?></option>
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_select_type')); ?></small>
                </div>
                <div class="form-group">
                    <label for="established_year"><?php echo e(__('messages.established_year')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="established_year" id="established_year" value="<?php echo e(old('established_year')); ?>" min="1900" max="<?php echo e(date('Y')); ?>" required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_established_year')); ?></small>
                </div>
            </div>

            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="pan"><?php echo e(__('messages.pan_number')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="pan" id="pan" value="<?php echo e(old('pan')); ?>" placeholder="<?php echo e(__('messages.placeholder_pan')); ?>" required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_pan_block')); ?></small>
                </div>
                <div class="form-group">
                    
                </div>
            </div>

            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="capacity"><?php echo e(__('messages.total_beds')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="capacity" id="capacity" value="<?php echo e(old('capacity', 0)); ?>" min="0" required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_total_beds')); ?></small>
                </div>
                <div class="form-group">
                    <label for="rooms"><?php echo e(__('messages.total_rooms')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="rooms" id="rooms" value="<?php echo e(old('rooms', 0)); ?>" min="0" required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_total_rooms')); ?></small>
                </div>
            </div>
        </div>

        
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #10B981;">
            <h4 style="margin:0 0 16px 0; color:#10B981;">
                <i class="fas fa-user-tie me-2"></i> <?php echo e(__('messages.owner_applicant_information')); ?>

            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="operator_name"><?php echo e(__('messages.full_name')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="operator_name" id="operator_name" value="<?php echo e(old('operator_name')); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email"><?php echo e(__('messages.email_address')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('messages.placeholder_email')); ?>" required>
                </div>
            </div>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="contact"><?php echo e(__('messages.contact_number')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="contact" id="contact" value="<?php echo e(old('contact')); ?>" required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_contact_duplicate_check')); ?></small>
                </div>
                <div class="form-group">
                    <label for="website"><?php echo e(__('messages.website_optional')); ?></label>
                    <input type="url" name="website" id="website" value="<?php echo e(old('website')); ?>" placeholder="<?php echo e(__('messages.placeholder_website')); ?>">
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_website')); ?></small>
                </div>
            </div>
        </div>

        
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #8B5CF6;">
            <h4 style="margin:0 0 16px 0; color:#8B5CF6;">
                <i class="fas fa-map-marker-alt me-2"></i> <?php echo e(__('messages.address')); ?>

            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="province"><?php echo e(__('messages.province')); ?> <span style="color:#dc2626;">*</span></label>
                    <select name="province" id="province" required>
                        <option value=""><?php echo e(__('messages.select_province')); ?></option>
                        <?php $__currentLoopData = \App\Models\Province::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prov->id); ?>" <?php echo e(old('province')==$prov->id?'selected':''); ?>><?php echo e($prov->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_select_province')); ?></small>
                </div>
                <div class="form-group">
                    <label for="district"><?php echo e(__('messages.district')); ?> <span style="color:#dc2626;">*</span></label>
                    <select name="district" id="district" required>
                        <option value=""><?php echo e(__('messages.select_district')); ?></option>
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_select_district')); ?></small>
                </div>
                <div class="form-group">
                    <label for="municipality"><?php echo e(__('messages.municipality')); ?> <span style="color:#dc2626;">*</span></label>
                    <select name="municipality" id="municipality" required>
                        <option value=""><?php echo e(__('messages.select_municipality')); ?></option>
                    </select>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_select_municipality')); ?></small>
                </div>
            </div>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="ward"><?php echo e(__('messages.ward_number')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="ward" id="ward" value="<?php echo e(old('ward')); ?>" min="1" max="32" required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_ward_number')); ?></small>
                </div>
                <div class="form-group">
                    <label for="street"><?php echo e(__('messages.street_tole')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="street" id="street" value="<?php echo e(old('street')); ?>" required>
                </div>
                <div class="form-group">
                    <label for="landmark"><?php echo e(__('messages.landmark_optional')); ?></label>
                    <input type="text" name="landmark" id="landmark" value="<?php echo e(old('landmark')); ?>" placeholder="<?php echo e(__('messages.placeholder_landmark')); ?>">
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_landmark')); ?></small>
                </div>
            </div>
            <div class="form-group">
                <label for="description"><?php echo e(__('messages.description_facilities_optional')); ?></label>
                <textarea name="description" id="description" rows="3"><?php echo e(old('description')); ?></textarea>
            </div>
        </div>

        
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #F59E0B;">
            <h4 style="margin:0 0 16px 0; color:#F59E0B;">
                <i class="fas fa-file-upload me-2"></i> <?php echo e(__('messages.documents')); ?>

            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div class="form-group">
                    <label for="document_pan"><?php echo e(__('messages.pan_certificate')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[pan]" id="document_pan" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <div class="form-group">
                    <label for="document_citizenship"><?php echo e(__('messages.citizenship_copy')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[citizenship]" id="document_citizenship" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <div class="form-group">
                    <label for="document_license"><?php echo e(__('messages.business_registration_certificate')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[license]" id="document_license" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <div class="form-group">
                    <label for="document_municipality"><?php echo e(__('messages.municipality_certificate')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[municipality]" id="document_municipality" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <div class="form-group" style="grid-column:1/2;">
                    <label for="document_photos"><?php echo e(__('messages.hostel_photos')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[photos]" id="document_photos" accept=".jpg,.jpeg,.png" multiple required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_hostel_photos')); ?></small>
                </div>
                <div class="form-group" style="grid-column:2/3;">
                    <label for="document_signboard"><?php echo e(__('messages.signboard_building_image')); ?> <span style="color:#dc2626;">*</span></label>
                    <input type="file" name="documents[signboard]" id="document_signboard" accept=".jpg,.jpeg,.png" required>
                    <small style="color:#64748b; font-size:0.75rem;"><?php echo e(__('messages.help_signboard_image')); ?></small>
                </div>
                <div class="form-group" style="grid-column:1/3;">
                    <label for="document_additional"><?php echo e(__('messages.additional_documents_optional')); ?></label>
                    <input type="file" name="documents[additional]" id="document_additional" accept=".jpg,.jpeg,.png,.pdf" multiple>
                </div>
            </div>
            <small style="color:#64748b; display:block; margin-top:8px; font-size:0.75rem;">
                <i class="fas fa-info-circle"></i> 
                <?php echo e(__('messages.help_allowed_formats')); ?>

            </small>
        </div>

        
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #EF4444;">
            <h4 style="margin:0 0 16px 0; color:#EF4444;">
                <i class="fas fa-credit-card me-2"></i> <?php echo e(__('messages.payment_status')); ?>

            </h4>
            <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label for="payment_status"><?php echo e(__('messages.payment_status')); ?> <span style="color:#dc2626;">*</span></label>
                    <select name="payment_status" id="payment_status" required>
                        <option value="pending" selected><?php echo e(__('messages.payment_pending')); ?></option>
                        <option value="submitted"><?php echo e(__('messages.payment_submitted')); ?></option>
                        <option value="verified"><?php echo e(__('messages.payment_verified')); ?></option>
                        <option value="rejected"><?php echo e(__('messages.payment_rejected')); ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_method"><?php echo e(__('messages.payment_method_optional')); ?></label>
                    <select name="payment_method" id="payment_method">
                        <option value=""><?php echo e(__('messages.select')); ?></option>
                        <option value="bank"><?php echo e(__('messages.payment_bank_transfer')); ?></option>
                        <option value="qr"><?php echo e(__('messages.payment_qr_scan')); ?></option>
                        <option value="cash"><?php echo e(__('messages.payment_cash_front_desk')); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="payment_transaction_id"><?php echo e(__('messages.transaction_id_optional')); ?></label>
                <input type="text" name="payment_transaction_id" id="payment_transaction_id" value="<?php echo e(old('payment_transaction_id')); ?>" placeholder="<?php echo e(__('messages.placeholder_transaction_id')); ?>">
            </div>
        </div>

        
        <input type="hidden" name="source" value="admin">

        
        <div style="display:flex; gap:12px; margin-top:20px;">
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                <i class="fas fa-save"></i> <?php echo e(__('messages.register')); ?>

            </button>
            <a href="<?php echo e(route('admin.registrations.index')); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;"><?php echo e(__('messages.cancel')); ?></a>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Dynamic Dropdowns =====
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const municipalitySelect = document.getElementById('municipality');

        // Load districts on province change
        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            districtSelect.innerHTML = '<option value="">' + '<?php echo e(__("messages.select_district")); ?>' + '</option>';
            municipalitySelect.innerHTML = '<option value="">' + '<?php echo e(__("messages.select_municipality")); ?>' + '</option>';
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
                    .catch(() => {
                        // Fallback: if API fails, show nothing
                    });
            }
        });

        // Load municipalities on district change
        districtSelect.addEventListener('change', function() {
            const districtId = this.value;
            municipalitySelect.innerHTML = '<option value="">' + '<?php echo e(__("messages.select_municipality")); ?>' + '</option>';
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

        // Trigger change on page load if old values exist
        if (provinceSelect.value) {
            provinceSelect.dispatchEvent(new Event('change'));
            if (districtSelect.value) {
                districtSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/registrations/create.blade.php ENDPATH**/ ?>