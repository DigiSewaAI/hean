

<?php $__env->startSection('title', __('messages.inspection_select_title') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:900px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
            <i class="fas fa-search" style="color:#8B5CF6;"></i> <?php echo e(__('messages.inspection_select_heading')); ?>

        </h2>
        <a href="<?php echo e(route('admin.inspections.index')); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back')); ?>

        </a>
    </div>

    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
        <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('admin.inspections.create', $reg)); ?>" 
           style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; margin-bottom:10px; background:#f8fafc; border-radius:8px; text-decoration:none; color:#0f172a; border:1px solid #e2e8f0; transition:0.2s;">
            <div>
                <strong><?php echo e($reg->hostel_name); ?></strong>
                <span style="color:#64748b; font-size:0.85rem; margin-left:12px;"><?php echo e($reg->district); ?></span>
                <br>
                <span style="font-size:0.75rem; color:#94a3b8;">
                    <?php echo e(__('messages.registration_no')); ?> #<?php echo e($reg->id); ?> · <?php echo e($reg->created_at->format('Y-m-d')); ?>

                </span>
            </div>
            <span style="padding:4px 14px; border-radius:50px; font-size:0.7rem; font-weight:600;
                <?php if($reg->status == 'pending'): ?> background:#fef3c7; color:#92400e;
                <?php elseif($reg->status == 'inspection'): ?> background:#fef3c7; color:#92400e;
                <?php else: ?> background:#e2e8f0; color:#475569; <?php endif; ?>">
                <?php echo e(__('messages.status_' . $reg->status)); ?>

            </span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="text-align:center; padding:40px; color:#94a3b8;">
            <i class="fas fa-inbox" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:12px;"></i>
            <?php echo e(__('messages.no_inspection_applications')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/inspections/select.blade.php ENDPATH**/ ?>