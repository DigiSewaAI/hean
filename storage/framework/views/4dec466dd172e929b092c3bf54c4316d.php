

<?php $__env->startSection('title', __('messages.admin_registrations_title') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0;"><?php echo e(__('messages.admin_registrations_title')); ?></h2>
    <a href="<?php echo e(route('admin.registrations.create')); ?>" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> <?php echo e(__('messages.new_registration')); ?>

    </a>
</div>

<div class="table-container" style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;">#</th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.hostel')); ?></th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.district')); ?></th>
                <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.status')); ?></th>
                <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                // ✅ Fix: Determine actual status to display
                $displayStatus = $reg->status;
                if ($reg->status === 'approved') {
                    // Check if invoice exists and is not paid
                    $hasInvoice = $reg->invoices->isNotEmpty();
                    if ($hasInvoice) {
                        $latestInvoice = $reg->invoices->sortByDesc('id')->first();
                        if ($latestInvoice && $latestInvoice->status !== 'paid') {
                            $displayStatus = 'awaiting_payment';
                        }
                    }
                }
                $statusColorMap = [
                    'pending'          => ['bg' => '#e2e8f0', 'text' => '#475569'],
                    'approved'         => ['bg' => '#dcfce7', 'text' => '#166534'],
                    'awaiting_payment' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'active'           => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                    'expired'          => ['bg' => '#f1f5f9', 'text' => '#64748b'],
                    'rejected'         => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                    'duplicate'        => ['bg' => '#fce4ec', 'text' => '#880e4f'],
                    'inspection'       => ['bg' => '#fef3c7', 'text' => '#92400e'],
                ];
                $colors = $statusColorMap[$displayStatus] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
            ?>
            <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                <td style="padding:12px 16px; font-weight:600; color:#0f172a;"><?php echo e($reg->id); ?></td>
                <td style="padding:12px 16px; font-weight:500; color:#0f172a;">
                    <?php echo e($reg->hostel_name_english ?: $reg->hostel_name); ?>

                    <?php if($reg->hostel_name_english && $reg->hostel_name && $reg->hostel_name_english != $reg->hostel_name): ?>
                        <br><span style="font-size:0.7rem; color:#94a3b8;"><?php echo e($reg->hostel_name); ?></span>
                    <?php endif; ?>
                </td>
                <td style="padding:12px 16px; color:#475569;"><?php echo e($reg->district ?? __('messages.not_available')); ?></td>
                <td style="padding:12px 16px;">
                    <span style="padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600; background:<?php echo e($colors['bg']); ?>; color:<?php echo e($colors['text']); ?>;">
                        <?php echo e(__('messages.status_' . $displayStatus)); ?>

                    </span>
                </td>
                <td style="padding:12px 16px; text-align:center;">
                    <a href="<?php echo e(route('admin.registrations.show', $reg)); ?>" style="display:inline-block; padding:6px 14px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border-radius:6px; text-decoration:none; font-size:0.75rem; font-weight:600; transition:0.2s;">
                        <i class="fas fa-eye"></i> <?php echo e(__('messages.view_details')); ?>

                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                    <i class="fas fa-file-alt" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                    <?php echo e(__('messages.no_registrations')); ?>

                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="margin-top:24px; display:flex; justify-content:center;">
    <?php echo e($registrations->links()); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/registrations/index.blade.php ENDPATH**/ ?>