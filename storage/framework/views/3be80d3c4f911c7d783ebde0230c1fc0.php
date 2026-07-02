


<?php $__env->startSection('title', __('messages.invoice') . ' #' . $invoice->invoice_number . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:1200px; margin:0 auto;">

    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
        <h2 style="font-size:1.8rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-invoice" style="color:#0EA5E9;"></i>
            <?php echo e(__('messages.invoice')); ?> #<?php echo e($invoice->invoice_number); ?>

            <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
                <?php echo e($invoice->issued_date ? $invoice->issued_date->format('M d, Y') : __('messages.not_available')); ?>

            </span>
        </h2>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <a href="<?php echo e(route('admin.invoices.index')); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
                <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back_to_list')); ?>

            </a>
            <?php if($invoice->pdf_path): ?>
                <a href="<?php echo e(route('admin.invoices.download', $invoice)); ?>" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; box-shadow:0 4px 15px rgba(34,197,94,0.3);">
                    <i class="fas fa-download"></i> <?php echo e(__('messages.download_pdf')); ?>

                </a>
            <?php endif; ?>
        </div>
    </div>

    
    <div style="margin-bottom:20px;">
        <?php
            $statusColors = [
                'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'partial' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'paid'    => ['bg' => '#dcfce7', 'text' => '#166534'],
                'overdue' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            ];
            $colors = $statusColors[$invoice->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
        ?>
        <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.9rem; background:<?php echo e($colors['bg']); ?>; color:<?php echo e($colors['text']); ?>;">
            <span style="width:10px; height:10px; border-radius:50%; display:inline-block; background:<?php echo e($colors['text']); ?>;"></span>
            <?php echo e(__('messages.status_' . $invoice->status)); ?>

        </span>
    </div>

    
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
            <h4 style="margin:0 0 16px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-info-circle" style="color:#0EA5E9;"></i> <?php echo e(__('messages.invoice_details')); ?>

            </h4>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.invoice_number')); ?></span>
                    <br><strong style="color:#0f172a;"><?php echo e($invoice->invoice_number); ?></strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.amount')); ?></span>
                    <br><strong style="color:#0f172a; font-size:1.2rem;">NPR <?php echo e(number_format($invoice->amount, 2)); ?></strong>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.issued_date')); ?></span>
                    <br><?php echo e($invoice->issued_date ? $invoice->issued_date->format('Y-m-d H:i') : 'N/A'); ?>

                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.due_date')); ?></span>
                    <br>
                    <?php echo e($invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A'); ?>

                    <?php if($invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid'): ?>
                        <span style="background:#fee2e2; color:#991b1b; padding:2px 8px; border-radius:50px; font-size:0.7rem; font-weight:600; margin-left:6px;"><?php echo e(__('messages.overdue')); ?></span>
                    <?php endif; ?>
                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.invoice_type')); ?></span>
                    <br><?php echo e(__('messages.invoice_type_' . $invoice->invoice_type)); ?>

                </div>
                <div>
                    <span style="font-weight:600; color:#475569;"><?php echo e(__('messages.status')); ?></span>
                    <br>
                    <span style="padding:4px 14px; border-radius:50px; font-size:0.8rem; font-weight:600; background:<?php echo e($colors['bg']); ?>; color:<?php echo e($colors['text']); ?>;">
                        <?php echo e(__('messages.status_' . $invoice->status)); ?>

                    </span>
                </div>
            </div>
        </div>

        
        <div>

            
            <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:16px;">
                <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-file-alt" style="color:#0EA5E9;"></i> <?php echo e(__('messages.registration')); ?>

                </h4>
                <?php if($invoice->registration): ?>
                    <p style="margin:4px 0; font-weight:600; color:#0f172a;"><?php echo e($invoice->registration->hostel_name ?? $invoice->registration->registration_number); ?></p>
                    <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                        <i class="fas fa-hashtag"></i> <?php echo e($invoice->registration->registration_number); ?>

                    </p>
                    <p style="margin:4px 0; color:#64748b; font-size:0.85rem;">
                        <i class="fas fa-map-marker-alt"></i> <?php echo e($invoice->registration->district); ?>, <?php echo e($invoice->registration->municipality); ?>

                    </p>
                    <a href="<?php echo e(route('admin.registrations.show', $invoice->registration)); ?>" style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem; margin-top:8px;">
                        <i class="fas fa-eye"></i> <?php echo e(__('messages.view_registration')); ?>

                    </a>
                <?php else: ?>
                    <p style="color:#94a3b8;"><?php echo e(__('messages.not_available')); ?></p>
                <?php endif; ?>
            </div>

            
            <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
                <h4 style="margin:0 0 12px 0; border-bottom:1px solid #e2e8f0; padding-bottom:8px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-credit-card" style="color:#22C55E;"></i> <?php echo e(__('messages.payments')); ?>

                </h4>
                <?php
                    $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');
                    $balance = $invoice->amount - $totalPaid;
                ?>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; text-align:center; margin-bottom:12px;">
                    <div style="background:#f8fafc; padding:12px; border-radius:8px;">
                        <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;"><?php echo e(__('messages.total_paid')); ?></div>
                        <div style="font-weight:700; font-size:1.3rem; color:#22C55E;">NPR <?php echo e(number_format($totalPaid, 2)); ?></div>
                    </div>
                    <div style="background:#f8fafc; padding:12px; border-radius:8px;">
                        <div style="font-size:0.75rem; color:#94a3b8; text-transform:uppercase;"><?php echo e(__('messages.outstanding')); ?></div>
                        <div style="font-weight:700; font-size:1.3rem; color:#EF4444;">NPR <?php echo e(number_format(max(0, $balance), 2)); ?></div>
                    </div>
                </div>

                <?php if($invoice->payments->count()): ?>
                    <div style="max-height:200px; overflow-y:auto;">
                        <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                                <div>
                                    <span style="font-weight:500;"><?php echo e(ucfirst($payment->method)); ?></span>
                                    <span style="font-size:0.75rem; color:#94a3b8; margin-left:8px;"><?php echo e($payment->transaction_id ?? 'N/A'); ?></span>
                                </div>
                                <div>
                                    <span style="font-weight:600;">NPR <?php echo e(number_format($payment->amount, 2)); ?></span>
                                    <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                                        <?php if($payment->status == 'verified'): ?> background:#dcfce7; color:#166534;
                                        <?php elseif($payment->status == 'pending'): ?> background:#fef3c7; color:#92400e;
                                        <?php else: ?> background:#f1f5f9; color:#475569; <?php endif; ?>
                                    ">
                                        <?php echo e(__('messages.status_'.$payment->status)); ?>

                                    </span>
                                    <?php if($payment->status == 'verified' && $payment->receipts->isNotEmpty()): ?>
                                        <a href="<?php echo e(route('admin.receipts.download', $payment->receipts->first())); ?>" 
                                           style="margin-left:4px; background:#F59E0B; color:#fff; padding:2px 8px; border-radius:50px; text-decoration:none; font-size:0.6rem; font-weight:600;">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p style="text-align:center; color:#94a3b8; padding:12px 0;"><?php echo e(__('messages.no_payments_recorded')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
<div style="margin-top:24px; background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:16px 20px; display:flex; gap:12px; flex-wrap:wrap;">
    <?php if($invoice->pdf_path): ?>
        <a href="<?php echo e(route('admin.invoices.download', $invoice)); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#22C55E; color:#fff; padding:8px 24px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.85rem; box-shadow:0 4px 15px rgba(34,197,94,0.3);">
            <i class="fas fa-file-pdf"></i> <?php echo e(__('messages.download_pdf')); ?>

        </a>
    <?php endif; ?>

    
<?php if($invoice->status !== 'paid'): ?>
    <form action="<?php echo e(route('admin.payments.create')); ?>" method="GET" style="display:inline;">
        <input type="hidden" name="invoice_id" value="<?php echo e($invoice->id); ?>">
        <button type="submit" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:8px 24px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
            <i class="fas fa-plus-circle"></i> <?php echo e(__('messages.add_payment')); ?>

        </button>
    </form>
<?php endif; ?>
    <?php if($invoice->registration): ?>
        <a href="<?php echo e(route('admin.registrations.show', $invoice->registration)); ?>" 
           style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 24px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem;">
            <i class="fas fa-arrow-right"></i> <?php echo e(__('messages.go_to_registration')); ?>

        </a>
    <?php endif; ?>
</div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/invoices/show.blade.php ENDPATH**/ ?>