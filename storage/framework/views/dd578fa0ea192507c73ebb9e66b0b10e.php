

<?php $__env->startSection('title', 'Hostel Registration - HEAN'); ?>

<?php $__env->startSection('content'); ?>
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

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger" style="padding:12px 20px; border-radius:12px; background:#fef2f2; border-left:4px solid #dc2626; margin-bottom:24px;">
                        <i class="fas fa-exclamation-circle" style="color:#dc2626; margin-right:8px;"></i>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div><?php echo e($error); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('register.hostel.store')); ?>" method="POST" enctype="multipart/form-data" id="registrationForm">
                    <?php echo csrf_field(); ?>

                    
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #0EA5E9;">
                        <h4 style="margin:0 0 16px 0; color:#0EA5E9;">
                            <i class="fas fa-building me-2"></i> Hostel Information
                        </h4>
                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hostel_name" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Hostel Name (Nepali) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="hostel_name" id="hostel_name" value="<?php echo e(old('hostel_name')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['hostel_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="e.g. सूर्योदय ब्वाइज होस्टेल" required>
                                    <?php $__errorArgs = ['hostel_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hostel_name_english" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Hostel Name (English) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="hostel_name_english" id="hostel_name_english" value="<?php echo e(old('hostel_name_english')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['hostel_name_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="e.g. Suryoday Boys Hostel" required>
                                    <?php $__errorArgs = ['hostel_name_english'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hostel_type" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Type <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="hostel_type" id="hostel_type"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select <?php $__errorArgs = ['hostel_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select</option>
                                        <option value="boys" <?php echo e(old('hostel_type')=='boys'?'selected':''); ?>>Boys</option>
                                        <option value="girls" <?php echo e(old('hostel_type')=='girls'?'selected':''); ?>>Girls</option>
                                        <option value="co-ed" <?php echo e(old('hostel_type')=='co-ed'?'selected':''); ?>>Co-Ed</option>
                                    </select>
                                    <?php $__errorArgs = ['hostel_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="capacity" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Total Beds (Capacity) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="number" name="capacity" id="capacity" value="<?php echo e(old('capacity')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1" required>
                                    <?php $__errorArgs = ['capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rooms" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Total Rooms <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="number" name="rooms" id="rooms" value="<?php echo e(old('rooms')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['rooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1" required>
                                    <?php $__errorArgs = ['rooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small style="color:#64748b; font-size:0.75rem;">Total number of rooms in the hostel.</small>
                                </div>
                            </div>

                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="established_year" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Established Year <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="number" name="established_year" id="established_year" value="<?php echo e(old('established_year')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['established_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1900" max="<?php echo e(date('Y')); ?>" required>
                                    <?php $__errorArgs = ['established_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Contact Number <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="contact_number" id="contact_number" value="<?php echo e(old('contact_number')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Email Address <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="website" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Website <span style="color:#64748b; font-weight:400;">(Optional)</span>
                                    </label>
                                    <input type="url" name="website" id="website" value="<?php echo e(old('website')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="https://example.com">
                                    <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Description <span style="color:#64748b; font-weight:400;">(Optional)</span>
                                    </label>
                                    <textarea name="description" id="description" rows="3"
                                              style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                              class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
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
                                    <input type="text" name="owner_name" id="owner_name" value="<?php echo e(old('owner_name')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['owner_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pan" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        PAN Number <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="pan" id="pan" value="<?php echo e(old('pan')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['pan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. 123456789" required>
                                    <?php $__errorArgs = ['pan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small style="color:#64748b; font-size:0.75rem;">PAN matching applications will be blocked automatically.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #8B5CF6;">
                        <h4 style="margin:0 0 16px 0; color:#8B5CF6;">
                            <i class="fas fa-map-marker-alt me-2"></i> Address
                        </h4>
                        <div class="row g-3">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Province <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="province" id="province"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select <?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select Province</option>
                                        <?php $__currentLoopData = \App\Models\Province::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($prov->id); ?>" <?php echo e(old('province')==$prov->id?'selected':''); ?>><?php echo e($prov->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="district" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        District <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="district" id="district"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select <?php $__errorArgs = ['district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select District</option>
                                    </select>
                                    <?php $__errorArgs = ['district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="municipality" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Municipality <span style="color:#dc2626;">*</span>
                                    </label>
                                    <select name="municipality" id="municipality"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select <?php $__errorArgs = ['municipality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select Municipality</option>
                                    </select>
                                    <?php $__errorArgs = ['municipality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ward" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Ward <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="number" name="ward" id="ward" value="<?php echo e(old('ward')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['ward'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1" max="32" required>
                                    <?php $__errorArgs = ['ward'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="street" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Street / Tole <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="text" name="street" id="street" value="<?php echo e(old('street')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['street'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['street'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="landmark" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Landmark <span style="color:#64748b; font-weight:400;">(Optional)</span>
                                    </label>
                                    <input type="text" name="landmark" id="landmark" value="<?php echo e(old('landmark')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['landmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. Near Bus Park">
                                    <?php $__errorArgs = ['landmark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #F59E0B;">
                        <h4 style="margin:0 0 16px 0; color:#F59E0B;">
                            <i class="fas fa-file-upload me-2"></i> Documents
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_registration_certificate" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Registration Certificate <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="file" name="documents[registration_certificate]" id="documents_registration_certificate"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control <?php $__errorArgs = ['documents.registration_certificate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png" required>
                                    <?php $__errorArgs = ['documents.registration_certificate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_citizenship_copy" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Citizenship Copy (Owner) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="file" name="documents[citizenship_copy]" id="documents_citizenship_copy"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control <?php $__errorArgs = ['documents.citizenship_copy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png" required>
                                    <?php $__errorArgs = ['documents.citizenship_copy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_pan_certificate" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        PAN Certificate <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="file" name="documents[pan_certificate]" id="documents_pan_certificate"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control <?php $__errorArgs = ['documents.pan_certificate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png" required>
                                    <?php $__errorArgs = ['documents.pan_certificate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_signboard" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Signboard / Hostel Building Image <span style="color:#dc2626;">*</span>
                                    </label>
                                    <input type="file" name="documents[signboard]" id="documents_signboard"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control <?php $__errorArgs = ['documents.signboard'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".jpg,.jpeg,.png" required>
                                    <?php $__errorArgs = ['documents.signboard'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small style="color:#64748b; font-size:0.75rem;">Clear photo of the hostel signboard or building.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_other_documents" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Other Supporting Documents <span style="color:#64748b; font-weight:400;">(Optional)</span>
                                    </label>
                                    <input type="file" name="documents[other_documents]" id="documents_other_documents"
                                           style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:8px;"
                                           class="form-control <?php $__errorArgs = ['documents.other_documents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <?php $__errorArgs = ['documents.other_documents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        <small style="color:#64748b; display:block; margin-top:8px; font-size:0.75rem;">
                            <i class="fas fa-info-circle"></i> 
                            Accepted formats: PDF, JPG, JPEG, PNG (max 2MB each)
                        </small>
                    </div>

                    
                    <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:24px; border-left:4px solid #EF4444;">
                        <h4 style="margin:0 0 16px 0; color:#EF4444;">
                            <i class="fas fa-credit-card me-2"></i> Payment <span style="font-size:0.85rem; font-weight:400; color:#64748b;">(Optional)</span>
                        </h4>
                        <div class="alert alert-info" style="background:#f0f9ff; border-left:4px solid #0EA5E9; padding:12px 16px; border-radius:8px; margin-bottom:16px;">
                            <i class="fas fa-info-circle" style="color:#0EA5E9; margin-right:8px;"></i>
                            If you have already made payment, fill in the details below. Otherwise, you can pay later.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_method" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Payment Method
                                    </label>
                                    <select name="payment_method" id="payment_method"
                                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem; background:#fff;"
                                            class="form-select <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Select</option>
                                        <option value="bank" <?php echo e(old('payment_method')=='bank'?'selected':''); ?>>Bank Transfer</option>
                                        <option value="esewa" <?php echo e(old('payment_method')=='esewa'?'selected':''); ?>>eSewa</option>
                                        <option value="khalti" <?php echo e(old('payment_method')=='khalti'?'selected':''); ?>>Khalti</option>
                                    </select>
                                    <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="transaction_id" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Transaction ID
                                    </label>
                                    <input type="text" name="transaction_id" id="transaction_id" value="<?php echo e(old('transaction_id')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['transaction_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['transaction_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_amount" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Amount (NPR)
                                    </label>
                                    <input type="number" name="payment_amount" id="payment_amount" value="<?php echo e(old('payment_amount')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['payment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" step="0.01">
                                    <?php $__errorArgs = ['payment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_date" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Payment Date
                                    </label>
                                    <input type="date" name="payment_date" id="payment_date" value="<?php echo e(old('payment_date')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank_name" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Bank Name
                                    </label>
                                    <input type="text" name="bank_name" id="bank_name" value="<?php echo e(old('bank_name')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank_account" style="font-weight:600; color:#1e293b; margin-bottom:4px; display:block;">
                                        Bank Account Number
                                    </label>
                                    <input type="text" name="bank_account" id="bank_account" value="<?php echo e(old('bank_account')); ?>"
                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.95rem;"
                                           class="form-control <?php $__errorArgs = ['bank_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['bank_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:0.8rem; margin-top:4px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; gap:12px; margin-top:20px;">
                        <button type="submit" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 28px; border:none; border-radius:50px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                            <i class="fas fa-save"></i> Submit Registration
                        </button>
                        <a href="<?php echo e(route('home')); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:10px 28px; border-radius:50px; text-decoration:none; font-weight:500; transition:0.3s;">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
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

        // Load municipalities on district change
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

        // Trigger change if there's old value (to load districts/municipalities on page load)
        if (provinceSelect.value) {
            provinceSelect.dispatchEvent(new Event('change'));
            // Also trigger district if district value exists
            if (districtSelect.value) {
                districtSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/public/register-hostel.blade.php ENDPATH**/ ?>