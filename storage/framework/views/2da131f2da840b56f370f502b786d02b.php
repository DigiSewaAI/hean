

<?php $__env->startSection('title', __('messages.receipts') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:1200px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2 style="margin:0;"><i class="fas fa-receipt" style="color:#F59E0B;"></i> <?php echo e(__('messages.receipts')); ?></h2>
    </div>

    
    <div style="background:#fff; border-radius:8px; padding:16px; margin-bottom:20px; border:1px solid #e2e8f0;">
        <form method="GET" action="<?php echo e(route('admin.receipts.index')); ?>" style="display:flex; gap:12px; flex-wrap:wrap; align-items:end;">
            <div style="flex:1; min-width:200px;">
                <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b;"><?php echo e(__('messages.search')); ?></label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('messages.search_receipts')); ?>" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
            </div>
            <div style="flex:1; min-width:200px;">
                <label style="display:block; font-weight:600; font-size:0.8rem; color:#64748b;"><?php echo e(__('messages.registration')); ?></label>
                <select name="registration_id" style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
                    <option value=""><?php echo e(__('messages.all_registrations')); ?></option>
                    <?php $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($reg->id); ?>" <?php echo e(request('registration_id') == $reg->id ? 'selected' : ''); ?>><?php echo e($reg->hostel_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" style="background:#0EA5E9; color:#fff; padding:8px 20px; border:none; border-radius:6px; cursor:pointer; font-weight:600;"><i class="fas fa-filter"></i> <?php echo e(__('messages.filter')); ?></button>
                <a href="<?php echo e(route('admin.receipts.index')); ?>" style="background:#e2e8f0; color:#475569; padding:8px 20px; border-radius:6px; text-decoration:none; font-weight:600;"><i class="fas fa-times"></i> <?php echo e(__('messages.clear')); ?></a>
            </div>
        </form>
    </div>

    
    <div style="background:#fff; border-radius:8px; border:1px solid #e2e8f0; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
            <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                <tr>
                    <th style="padding:10px 12px; text-align:left;">#</th>
                    <th style="padding:10px 12px; text-align:left;"><?php echo e(__('messages.receipt_number')); ?></th>
                    <th style="padding:10px 12px; text-align:left;"><?php echo e(__('messages.registration')); ?></th>
                    <th style="padding:10px 12px; text-align:left;"><?php echo e(__('messages.invoice')); ?></th>
                    <th style="padding:10px 12px; text-align:left;"><?php echo e(__('messages.amount')); ?></th>
                    <th style="padding:10px 12px; text-align:left;"><?php echo e(__('messages.issued_date')); ?></th>
                    <th style="padding:10px 12px; text-align:center;"><?php echo e(__('messages.actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $registration = $receipt->payment?->registration;
                    $invoice = $receipt->payment?->invoice;
                ?>
                <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="padding:10px 12px;"><?php echo e($loop->iteration); ?></td>
                    <td style="padding:10px 12px; font-weight:600;"><?php echo e($receipt->receipt_number); ?></td>
                    <td style="padding:10px 12px;">
                        <?php if($registration): ?>
                            <a href="<?php echo e(route('admin.registrations.show', $registration)); ?>" style="color:#0EA5E9; text-decoration:none;">
                                <?php echo e($registration->hostel_name ?? $registration->registration_number); ?>

                            </a>
                        <?php else: ?>
                            <span style="color:#94a3b8;"><?php echo e(__('messages.not_available')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:10px 12px;">
                        <?php if($invoice): ?>
                            <a href="<?php echo e(route('admin.invoices.show', $invoice)); ?>" style="color:#0EA5E9; text-decoration:none;">
                                <?php echo e($invoice->invoice_number); ?>

                            </a>
                        <?php else: ?>
                            <span style="color:#94a3b8;"><?php echo e(__('messages.not_available')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:10px 12px; font-weight:500;">NPR <?php echo e(number_format($receipt->amount, 2)); ?></td>
                    <td style="padding:10px 12px;"><?php echo e($receipt->issued_date ? $receipt->issued_date->format('Y-m-d') : 'N/A'); ?></td>
                    <td style="padding:10px 12px; text-align:center;">
                        <a href="<?php echo e(route('admin.receipts.show', $receipt)); ?>" style="background:#0EA5E9; color:#fff; padding:4px 12px; border-radius:4px; text-decoration:none; font-size:0.8rem;"><i class="fas fa-eye"></i></a>
                        <a href="<?php echo e(route('admin.receipts.download', $receipt)); ?>" style="background:#22C55E; color:#fff; padding:4px 12px; border-radius:4px; text-decoration:none; font-size:0.8rem;"><i class="fas fa-download"></i></a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" style="padding:30px; text-align:center; color:#94a3b8;"><?php echo e(__('messages.no_receipts_found')); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px; display:flex; justify-content:space-between; align-items:center;">
        <span style="color:#64748b; font-size:0.85rem;">
            <?php echo e(__('messages.showing')); ?> <?php echo e($receipts->firstItem() ?? 0); ?> - <?php echo e($receipts->lastItem() ?? 0); ?> <?php echo e(__('messages.of')); ?> <?php echo e($receipts->total()); ?>

        </span>
        <?php echo e($receipts->appends(request()->query())->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/receipts/index.blade.php ENDPATH**/ ?>