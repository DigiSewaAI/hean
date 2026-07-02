

<?php $__env->startSection('title', $hostel->name_nepali . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-hotel me-2" style="color:#0EA5E9;"></i> <?php echo e($hostel->name_nepali); ?>

    </h2>
    <a href="<?php echo e(route('admin.hostels.index')); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
        <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back')); ?>

    </a>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">

    
    <div>
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-info-circle"></i> <?php echo e(__('messages.details')); ?>

            </div>
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.hostel_name_nepali')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->name_nepali); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.hostel_name_english')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->name_english ?? __('messages.not_available')); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.type')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e(ucfirst($hostel->type ?? __('messages.not_available'))); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.capacity')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->capacity ?? __('messages.not_available')); ?> <?php echo e(__('messages.beds')); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.rooms')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->rooms ?? __('messages.not_available')); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.operator_name')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->operator_name); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.contact')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->contact); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.district')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->district); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.municipality')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->municipality); ?></p></div>
                <div><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.ward')); ?></label><p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($hostel->ward); ?></p></div>
                <div style="grid-column:1/-1;"><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.street')); ?></label><p style="color:#475569; margin:2px 0 0;"><?php echo e($hostel->street ?? __('messages.not_available')); ?></p></div>
                <?php if($hostel->description): ?>
                    <div style="grid-column:1/-1;"><label style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.description')); ?></label><p style="color:#475569; margin:2px 0 0;"><?php echo e($hostel->description); ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div>
        
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="background:linear-gradient(135deg, #8B5CF6, #7C3AED); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-image"></i> <?php echo e(__('messages.image')); ?>

            </div>
            <div style="padding:20px; text-align:center;">
                <?php if($hostel->image): ?>
                    <img src="<?php echo e(asset('storage/'.$hostel->image)); ?>" alt="<?php echo e($hostel->name_nepali); ?>" style="max-width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                <?php else: ?>
                    <div style="padding:30px;">
                        <i class="fas fa-image" style="font-size:3rem; color:#cbd5e1;"></i>
                        <p style="color:#94a3b8; margin-top:8px;"><?php echo e(__('messages.no_image')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="background:linear-gradient(135deg, #1E293B, #0F172A); color:#fff; padding:14px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-toggle-on"></i> <?php echo e(__('messages.status')); ?>

            </div>
            <div style="padding:20px; display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#f8fafc; border-radius:8px;">
                    <span style="font-weight:500; color:#1e293b;"><?php echo e(__('messages.approved')); ?></span>
                    <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; <?php echo e($hostel->approved ? 'background:#dcfce7; color:#166534;' : 'background:#fef3c7; color:#92400e;'); ?>">
                        <?php echo e($hostel->approved ? '✅ ' . __('messages.yes') : '❌ ' . __('messages.no')); ?>

                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#f8fafc; border-radius:8px;">
                    <span style="font-weight:500; color:#1e293b;"><?php echo e(__('messages.featured')); ?></span>
                    <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; <?php echo e($hostel->featured ? 'background:#dcfce7; color:#166534;' : 'background:#f8fafc; color:#94a3b8;'); ?>">
                        <?php echo e($hostel->featured ? '⭐ ' . __('messages.yes') : '—'); ?>

                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#f8fafc; border-radius:8px;">
                    <span style="font-weight:500; color:#1e293b;"><?php echo e(__('messages.visible')); ?></span>
                    <span style="padding:2px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; <?php echo e($hostel->visible ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;'); ?>">
                        <?php echo e($hostel->visible ? '👁️ ' . __('messages.yes') : '🚫 ' . __('messages.no')); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/hostels/show.blade.php ENDPATH**/ ?>