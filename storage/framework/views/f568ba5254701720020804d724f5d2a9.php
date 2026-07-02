

<?php $__env->startSection('title', __('messages.inspection') . ' #' . $inspection->id . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:1000px; margin:0 auto;">

    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
        <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-clipboard-check" style="color:#8B5CF6;"></i>
            <?php echo e(__('messages.inspection')); ?> #<?php echo e($inspection->id); ?>

            <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
                <?php echo e($inspection->created_at ? $inspection->created_at->format('M d, Y') : __('messages.not_available')); ?>

            </span>
        </h2>
        <div>
            <a href="<?php echo e(route('admin.registrations.show', $inspection->registration_id)); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
                <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back_to_registration')); ?>

            </a>
        </div>
    </div>

    
    <div style="margin-bottom:20px;">
        <?php
            $statusColors = [
                'scheduled' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'completed' => ['bg' => '#dcfce7', 'text' => '#166534'],
                'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            ];
            $colors = $statusColors[$inspection->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
        ?>
        <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.9rem; background:<?php echo e($colors['bg']); ?>; color:<?php echo e($colors['text']); ?>;">
            <span style="width:10px; height:10px; border-radius:50%; display:inline-block; background:<?php echo e($colors['text']); ?>;"></span>
            <?php echo e(__('messages.status_' . $inspection->status)); ?>

        </span>
    </div>

    
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
            <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-info-circle" style="color:#8B5CF6;"></i> <?php echo e(__('messages.inspection_details')); ?>

            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.inspector')); ?></span>
                    <br><strong style="color:#0f172a;"><?php echo e($inspection->inspector->name ?? 'N/A'); ?></strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.scheduled_date')); ?></span>
                    <br><strong style="color:#0f172a;"><?php echo e($inspection->scheduled_date ?? 'N/A'); ?></strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.status')); ?></span>
                    <br>
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.8rem; font-weight:600; background:<?php echo e($colors['bg']); ?>; color:<?php echo e($colors['text']); ?>;">
                        <?php echo e(__('messages.status_' . $inspection->status)); ?>

                    </span>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.completed_date')); ?></span>
                    <br><strong style="color:#0f172a;"><?php echo e($inspection->completed_date ? $inspection->completed_date->format('Y-m-d') : 'N/A'); ?></strong>
                </div>
                <?php if($inspection->remarks): ?>
                <div style="grid-column:1/-1;">
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.remarks')); ?></span>
                    <br><span style="color:#0f172a;"><?php echo e($inspection->remarks); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
            <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-file-alt" style="color:#0EA5E9;"></i> <?php echo e(__('messages.registration')); ?>

            </h4>
            <?php if($inspection->registration): ?>
                <p style="margin:4px 0; font-weight:600; color:#0f172a;"><?php echo e($inspection->registration->hostel_name ?? $inspection->registration->registration_number); ?></p>
                <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                    <i class="fas fa-hashtag"></i> <?php echo e($inspection->registration->registration_number); ?>

                </p>
                <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                    <i class="fas fa-map-marker-alt"></i> <?php echo e($inspection->registration->district); ?>, <?php echo e($inspection->registration->municipality); ?>

                </p>
                <a href="<?php echo e(route('admin.registrations.show', $inspection->registration)); ?>" style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem; margin-top:8px;">
                    <i class="fas fa-eye"></i> <?php echo e(__('messages.view_registration')); ?>

                </a>
            <?php else: ?>
                <p style="color:#94a3b8;"><?php echo e(__('messages.not_available')); ?></p>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if(!empty($checklist) && is_array($checklist)): ?>
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
        <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-list" style="color:#8B5CF6;"></i> <?php echo e(__('messages.inspection_checklist')); ?>

        </h4>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
            <?php $__currentLoopData = $checklist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Get the label from criteriaLabels array
                    $label = $criteriaLabels[$key] ?? 'Criteria ' . $key;
                    // Get remark for this item
                    $remark = $checklistRemarks[$key] ?? null;
                ?>
                <div style="display:flex; align-items:center; gap:8px; padding:6px 12px; background:#f8fafc; border-radius:6px;">
                    <span style="font-weight:600; color:#0f172a; min-width:20px;"><?php echo e($loop->iteration); ?>.</span>
                    <span style="flex:1; color:#475569; font-size:0.85rem;"><?php echo e($label); ?></span>
                    <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                        <?php if($value == 'yes'): ?> background:#dcfce7; color:#166534;
                        <?php elseif($value == 'no'): ?> background:#fee2e2; color:#991b1b;
                        <?php else: ?> background:#f1f5f9; color:#475569; <?php endif; ?>">
                        <?php echo e(ucfirst($value)); ?>

                    </span>
                    <?php if($remark): ?>
                        <span style="font-size:0.65rem; color:#64748b; margin-left:4px;" title="<?php echo e($remark); ?>">
                            <i class="fas fa-comment"></i>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    
    <?php
        $photos = $inspection->photos ? json_decode($inspection->photos, true) : [];
    ?>
    <?php if(!empty($photos) && is_array($photos)): ?>
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-top:24px;">
        <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-camera" style="color:#F59E0B;"></i> <?php echo e(__('messages.inspection_photos')); ?>

        </h4>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(150px, 1fr)); gap:12px;">
            <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="border-radius:8px; overflow:hidden; border:1px solid #e2e8f0;">
                    <img src="<?php echo e(asset('storage/' . $photo)); ?>" alt="Inspection Photo" style="width:100%; height:120px; object-fit:cover;">
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    
    <div style="margin-top:24px; background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:16px 20px; display:flex; gap:12px; flex-wrap:wrap;">
        <a href="<?php echo e(route('admin.registrations.show', $inspection->registration_id)); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#0EA5E9; color:#fff; padding:8px 24px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.85rem;">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back_to_registration')); ?>

        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/inspections/view.blade.php ENDPATH**/ ?>