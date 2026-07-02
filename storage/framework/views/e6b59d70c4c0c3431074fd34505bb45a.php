

<?php $__env->startSection('title', __('messages.admin_inspections_title') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;">
        <i class="fas fa-clipboard-list me-2" style="color:#8B5CF6;"></i> <?php echo e(__('messages.inspections')); ?>

    </h2>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        
        <a href="<?php echo e(route('admin.inspections.select')); ?>" 
           style="display:inline-flex; align-items:center; gap:8px; 
                  background:linear-gradient(135deg, #8B5CF6, #6366F1); 
                  color:#fff; padding:10px 24px; border-radius:50px; 
                  text-decoration:none; font-weight:600; font-size:0.9rem; 
                  box-shadow:0 4px 15px rgba(139,92,246,0.3); 
                  transition:0.3s;">
            <i class="fas fa-plus"></i> <?php echo e(__('messages.new_inspection')); ?>

        </a>
        
        <a href="<?php echo e(route('admin.registrations.index')); ?>" 
           style="display:inline-flex; align-items:center; gap:6px; 
                  background:#e2e8f0; color:#1e293b; padding:8px 18px; 
                  border-radius:50px; text-decoration:none; font-weight:500; 
                  font-size:0.85rem; transition:0.3s;">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back')); ?>

        </a>
    </div>
</div>

<div style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:16px;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569;">#</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569;"><?php echo e(__('messages.hostel')); ?></th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569;"><?php echo e(__('messages.inspector')); ?></th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569;"><?php echo e(__('messages.date')); ?></th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569;"><?php echo e(__('messages.status')); ?></th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569;"><?php echo e(__('messages.actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $inspections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td style="padding:12px 16px;"><?php echo e($inspection->id); ?></td>
                <td style="padding:12px 16px; font-weight:500;">
                    <?php echo e($inspection->registration->hostel_name ?? __('messages.not_available')); ?>

                    <br><small style="color:#94a3b8;"><?php echo e($inspection->registration->district ?? ''); ?></small>
                </td>
                <td style="padding:12px 16px;"><?php echo e($inspection->inspector->name ?? __('messages.not_available')); ?></td>
                <td style="padding:12px 16px;">
                    <?php if($inspection->completed_date): ?>
                        <?php echo e($inspection->completed_date->format('Y-m-d')); ?>

                    <?php elseif($inspection->scheduled_date): ?>
                        <?php echo e($inspection->scheduled_date->format('Y-m-d')); ?>

                    <?php else: ?>
                        <?php echo e(__('messages.not_available')); ?>

                    <?php endif; ?>
                </td>
                <td style="padding:12px 16px;">
                    <span style="padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;
                        <?php if($inspection->status == 'completed'): ?> background:#dcfce7; color:#166534;
                        <?php elseif($inspection->status == 'scheduled'): ?> background:#fef3c7; color:#92400e;
                        <?php elseif($inspection->status == 'cancelled'): ?> background:#fee2e2; color:#991b1b;
                        <?php else: ?> background:#e2e8f0; color:#475569; <?php endif; ?>">
                        <?php echo e(__('messages.status_' . $inspection->status)); ?>

                    </span>
                </td>
                <td style="padding:12px 16px; text-align:center;">
                    <a href="<?php echo e(route('admin.registrations.show', $inspection->registration_id)); ?>" 
                       style="padding:6px 14px; background:#0EA5E9; color:#fff; border-radius:6px; 
                              text-decoration:none; font-size:0.75rem;">
                        <i class="fas fa-eye"></i> <?php echo e(__('messages.view_details')); ?>

                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-clipboard-list" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    <?php echo e(__('messages.no_inspections_found')); ?>

                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div style="margin-top:16px;">
        <?php echo e($inspections->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/inspections/index.blade.php ENDPATH**/ ?>