

<?php $__env->startSection('title', __('messages.registration_title') . ' #' . $registration->id . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>


<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-size:1.5rem; font-weight:700; color:#0f172a; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-alt" style="color:#0EA5E9;"></i>
            <?php echo e(__('messages.registration')); ?> #<?php echo e($registration->id); ?>

            <span style="font-size:0.8rem; font-weight:400; color:#64748b; margin-left:8px;">
                <?php echo e($registration->created_at ? $registration->created_at->format('M d, Y') : __('messages.not_available')); ?>

            </span>
        </h2>
    </div>
    <div>
        <a href="<?php echo e(route('admin.registrations.index')); ?>" style="display:inline-flex; align-items:center; gap:6px; background:#e2e8f0; color:#1e293b; padding:8px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.3s;">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.back_to_list')); ?>

        </a>
    </div>
</div>


<?php if(session('success')): ?>
    <div style="background:#f0fdf4; border-left:4px solid #16a34a; padding:12px 18px; border-radius:8px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;"></i>
        <span style="color:#14532d;"><?php echo e(session('success')); ?></span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left:auto; background:none; border:none; color:#94a3b8; cursor:pointer; font-size:1.2rem;">&times;</button>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div style="background:#fef2f2; border-left:4px solid #dc2626; padding:12px 18px; border-radius:8px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;"></i>
        <span style="color:#7f1d1d;"><?php echo e(session('error')); ?></span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left:auto; background:none; border:none; color:#94a3b8; cursor:pointer; font-size:1.2rem;">&times;</button>
    </div>
<?php endif; ?>




<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px; margin-bottom:24px;">
    
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
        <div style="display:flex; flex-wrap:wrap; align-items:center; gap:16px; margin-bottom:12px;">
            <?php
                // Determine actual status for display
                $displayStatus = $registration->status;
                if ($registration->status === 'approved') {
                    $hasInvoice = $registration->invoices->isNotEmpty();
                    if ($hasInvoice) {
                        $latestInvoice = $registration->invoices->sortByDesc('id')->first();
                        if ($latestInvoice && $latestInvoice->status !== 'paid') {
                            $displayStatus = 'awaiting_payment';
                        }
                    }
                }
                $statusColorMap = [
                    'pending' => ['bg' => '#e2e8f0', 'text' => '#475569'],
                    'approved' => ['bg' => '#dcfce7', 'text' => '#166534'],
                    'awaiting_payment' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'active' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                    'expired' => ['bg' => '#f1f5f9', 'text' => '#64748b'],
                    'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                    'duplicate' => ['bg' => '#fce4ec', 'text' => '#880e4f'],
                    'inspection' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                ];
                $colors = $statusColorMap[$displayStatus] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
            ?>
            <span style="display:inline-flex; align-items:center; gap:8px; padding:6px 18px; border-radius:50px; font-weight:600; font-size:0.85rem; background:<?php echo e($colors['bg']); ?>; color:<?php echo e($colors['text']); ?>;">
                <span style="width:8px; height:8px; border-radius:50%; display:inline-block; background:<?php echo e($colors['text']); ?>;"></span>
                <?php echo e(__('messages.status_' . $displayStatus)); ?>

            </span>
            <span style="color:#64748b; font-size:0.85rem;">
                <i class="far fa-clock"></i> <?php echo e($registration->submitted_at ? $registration->submitted_at->diffForHumans() : __('messages.not_submitted')); ?>

            </span>
            <span style="color:#94a3b8;">|</span>
            <span style="color:#64748b; font-size:0.85rem;">
                <i class="fas fa-tag"></i> <?php echo e(__('messages.source')); ?>: <strong><?php echo e(ucfirst($registration->source ?? 'N/A')); ?></strong>
            </span>
        </div>

        
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; padding-top:12px; border-top:1px solid #e2e8f0;">
            <div>
    <span style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.hostel_name')); ?></span>
    <p style="font-weight:600; color:#0f172a; margin:2px 0 0;">
        <?php if($registration->hostel_name_english): ?>
            <?php echo e($registration->hostel_name_english); ?>

            <br><span style="font-weight:400; color:#64748b; font-size:0.85rem;"><?php echo e($registration->hostel_name ?? 'N/A'); ?></span>
        <?php else: ?>
            <?php echo e($registration->hostel_name ?? 'N/A'); ?>

        <?php endif; ?>
    </p>
</div>
            <div>
                <span style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.hostel_type')); ?></span>
                <p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e(ucfirst($registration->hostel_type ?? 'N/A')); ?></p>
            </div>
            <div>
                <span style="font-size:0.7rem; text-transform:uppercase; color:#94a3b8; font-weight:600;"><?php echo e(__('messages.district')); ?></span>
                <p style="font-weight:600; color:#0f172a; margin:2px 0 0;"><?php echo e($registration->district ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>

    
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px;">
        <div style="font-weight:600; color:#0f172a; font-size:0.85rem; margin-bottom:8px;"><?php echo e(__('messages.workflow_status')); ?></div>
        <?php
            $hasInvoice = $registration->invoices->isNotEmpty();
            $hasPayment = $registration->payments->isNotEmpty();
            $paymentVerified = $hasPayment && $registration->payments->where('status', 'verified')->isNotEmpty();
            $hasReceipt = $registration->receipts->isNotEmpty();
            $isActive = $registration->status === 'active';
            $isAwaitingPayment = $displayStatus === 'awaiting_payment';
            $steps = [
                '📋 Registration' => true,
                '📄 Invoice' => $hasInvoice,
                '💳 Payment' => $hasPayment,
                '🧾 Receipt' => $hasReceipt,
                '✅ Active' => $isActive,
            ];
            // Determine which step is current (active)
            $activeStep = 'Registration';
            if ($isActive) $activeStep = 'Active';
            elseif ($hasReceipt) $activeStep = 'Receipt';
            elseif ($paymentVerified) $activeStep = 'Payment'; // or 'Verified'
            elseif ($hasPayment) $activeStep = 'Payment';
            elseif ($hasInvoice) $activeStep = 'Invoice';
        ?>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $completed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isActiveStep = ($label == $activeStep);
                ?>
                <span style="padding:4px 12px; border-radius:50px; font-size:0.75rem; font-weight:600; 
                    <?php echo e($completed ? ($isActiveStep ? 'background:#3b82f6; color:#fff;' : 'background:#dcfce7; color:#166534;') : 'background:#f1f5f9; color:#94a3b8;'); ?>

                    <?php echo e($isActiveStep ? 'border:2px solid #1e3a8a;' : ''); ?>

                ">
                    <?php echo e($label); ?>

                </span>
                <?php if(!$loop->last): ?> <span style="color:#cbd5e1;">→</span> <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div style="margin-top:8px; font-size:0.8rem; color:#64748b;">
            <?php if($isActive): ?>
                ✅ <?php echo e(__('messages.registration_active')); ?>

            <?php elseif($isAwaitingPayment): ?>
                ⏳ <?php echo e(__('messages.awaiting_payment')); ?>

            <?php elseif($hasInvoice && !$paymentVerified): ?>
                💰 <?php echo e(__('messages.payment_pending')); ?>

            <?php elseif($displayStatus === 'pending'): ?>
                📝 <?php echo e(__('messages.awaiting_approval')); ?>

            <?php else: ?>
                <?php echo e(__('messages.status_' . $displayStatus)); ?>

            <?php endif; ?>
        </div>
    </div>
</div>




<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:20px; margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:12px;">
        <h4 style="margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-chart-pie" style="color:#0EA5E9;"></i> <?php echo e(__('messages.financial_summary')); ?>

        </h4>
        <?php if($registration->invoices->isNotEmpty()): ?>
            <a href="<?php echo e(route('admin.invoices.show', $registration->invoices->sortByDesc('id')->first())); ?>" 
               style="display:inline-flex; align-items:center; gap:6px; background:#0EA5E9; color:#fff; padding:6px 16px; border-radius:50px; text-decoration:none; font-size:0.8rem; font-weight:500;">
                <i class="fas fa-arrow-right"></i> <?php echo e(__('messages.view_finance')); ?>

            </a>
        <?php endif; ?>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px;">
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;"><?php echo e(__('messages.invoices')); ?></div>
            <div style="font-weight:700; font-size:1.3rem; color:#0f172a;"><?php echo e($registration->invoices?->count() ?? 0); ?></div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;"><?php echo e(__('messages.total_invoiced')); ?></div>
            <div style="font-weight:700; font-size:1.3rem; color:#0f172a;">NPR <?php echo e(number_format($totalInvoiced ?? 0, 2)); ?></div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;"><?php echo e(__('messages.total_paid')); ?></div>
            <div style="font-weight:700; font-size:1.3rem; color:#22C55E;">NPR <?php echo e(number_format($totalPaid ?? 0, 2)); ?></div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;"><?php echo e(__('messages.outstanding')); ?></div>
            <div style="font-weight:700; font-size:1.3rem; color:#EF4444;">NPR <?php echo e(number_format($outstanding ?? 0, 2)); ?></div>
        </div>
        <div style="text-align:center; background:#f8fafc; padding:12px; border-radius:8px;">
            <div style="font-size:0.7rem; color:#94a3b8; text-transform:uppercase;"><?php echo e(__('messages.latest_receipt')); ?></div>
            <?php if($latestReceipt): ?>
                <a href="<?php echo e(route('admin.receipts.download', $latestReceipt)); ?>" style="font-weight:700; color:#0EA5E9; text-decoration:none; font-size:0.9rem;">
                    <?php echo e($latestReceipt->receipt_number); ?>

                </a>
            <?php else: ?>
                <span style="color:#94a3b8;"><?php echo e(__('messages.none')); ?></span>
            <?php endif; ?>
        </div>
    </div>

    
    <?php
        $nextAction = '';
        $nextActionLink = null;
        if ($registration->status === 'pending') {
            $nextAction = 'Approve this registration';
            // No link, admin can click approve button
        } elseif ($displayStatus === 'approved' && !$hasInvoice) {
            $nextAction = 'Generate an invoice';
            $nextActionLink = '#invoiceForm';
        } elseif ($displayStatus === 'awaiting_payment' && $hasInvoice) {
            $invoice = $registration->invoices->sortByDesc('id')->first();
            if ($invoice && $invoice->status !== 'paid') {
                $nextAction = 'Add payment for invoice ' . $invoice->invoice_number;
                $nextActionLink = route('admin.payments.create', ['invoice_id' => $invoice->id]);
            } else {
                $nextAction = 'Verify the pending payment';
                // Find pending payment
                $pendingPayment = $registration->payments->where('status', 'pending')->first();
                if ($pendingPayment) {
                    $nextActionLink = route('admin.payments.show', $pendingPayment);
                }
            }
        } elseif ($registration->status === 'active') {
            $nextAction = 'Registration is active. Valid until ' . ($registration->valid_until ? $registration->valid_until->format('Y-m-d') : 'N/A');
        } else {
            $nextAction = 'No action required';
        }
    ?>
    <div style="margin-top:12px; padding-top:12px; border-top:1px solid #e2e8f0;">
        <div style="display:flex; align-items:center; gap:8px; font-size:0.9rem;">
            <span style="font-weight:600; color:#0f172a;"><?php echo e(__('messages.next_action')); ?>:</span>
            <?php if($nextActionLink): ?>
                <a href="<?php echo e($nextActionLink); ?>" style="color:#0EA5E9; text-decoration:none; font-weight:500;">
                    <?php echo e($nextAction); ?>

                </a>
            <?php else: ?>
                <span style="color:#64748b;"><?php echo e($nextAction); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>




<?php
    $latestInvoice = $registration->invoices->sortByDesc('id')->first();
    $hasInvoice = $registration->invoices->isNotEmpty();
    $canGenerateInvoice = $registration->status === 'approved' && !$hasInvoice;
?>

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-file-invoice"></i> <?php echo e(__('messages.invoices')); ?>

        <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">(<?php echo e($registration->invoices?->count() ?? 0); ?>)</span>
        <?php if($canGenerateInvoice): ?>
            <button type="button" onclick="document.getElementById('invoiceForm').style.display='block'" 
                style="margin-left:auto; background:rgba(255,255,255,0.2); color:#fff; border:1px solid rgba(255,255,255,0.3); padding:4px 16px; border-radius:50px; font-weight:600; font-size:0.75rem; cursor:pointer;">
                <i class="fas fa-plus"></i> <?php echo e(__('messages.generate_invoice')); ?>

            </button>
        <?php endif; ?>
    </div>
    <div style="padding:16px;">
        <?php if($hasInvoice): ?>
            <?php $__currentLoopData = $registration->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <div>
                    <a href="<?php echo e(route('admin.invoices.show', $invoice)); ?>" style="font-weight:600; color:#0EA5E9; text-decoration:none;">
                        <?php echo e($invoice->invoice_number); ?>

                    </a>
                    <span style="font-size:0.75rem; color:#94a3b8; margin-left:8px;"><?php echo e(__('messages.type')); ?>: <?php echo e(__('messages.invoice_type_'.$invoice->invoice_type)); ?></span>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <span style="font-weight:700;">NPR <?php echo e(number_format($invoice->amount, 2)); ?></span>
                    <span style="font-size:0.7rem; padding:2px 10px; border-radius:50px; font-weight:600; 
                        <?php if($invoice->status == 'paid'): ?> background:#dcfce7; color:#166534;
                        <?php elseif($invoice->status == 'partial'): ?> background:#fef3c7; color:#92400e;
                        <?php elseif($invoice->status == 'overdue'): ?> background:#fee2e2; color:#991b1b;
                        <?php else: ?> background:#e2e8f0; color:#475569; <?php endif; ?>">
                        <?php echo e(__('messages.status_'.$invoice->status)); ?>

                    </span>
                    <div style="display:flex; gap:4px;">
                        <a href="<?php echo e(route('admin.invoices.show', $invoice)); ?>" style="background:#0EA5E9; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if($invoice->pdf_path): ?>
                            <a href="<?php echo e(route('admin.invoices.download', $invoice)); ?>" style="background:#22C55E; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                                <i class="fas fa-download"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div style="text-align:center; padding:20px; color:#94a3b8;"><?php echo e(__('messages.no_invoices')); ?></div>
        <?php endif; ?>
    </div>
</div>




<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #22C55E, #16A34A); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-credit-card"></i> <?php echo e(__('messages.payments')); ?>

        <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">(<?php echo e($registration->payments?->count() ?? 0); ?>)</span>
        <?php if($hasInvoice && $latestInvoice && $latestInvoice->status !== 'paid'): ?>
            <a href="<?php echo e(url('/admin/payments/create?invoice_id=' . $latestInvoice->id)); ?>" 
   style="display:inline-flex; align-items:center; gap:6px; background:#F59E0B; color:#fff; padding:8px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.85rem;">
    <i class="fas fa-plus-circle"></i> <?php echo e(__('messages.add_payment')); ?>

</a>
        <?php endif; ?>
    </div>
    <div style="padding:16px;">
        <?php if($registration->payments?->count()): ?>
            <?php $__currentLoopData = $registration->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <div>
                    <span style="font-weight:500;"><?php echo e(ucfirst($payment->method)); ?></span>
                    <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;"><?php echo e($payment->transaction_id ?? 'N/A'); ?></span>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <span style="font-weight:600;">NPR <?php echo e(number_format($payment->amount, 2)); ?></span>
                    <span style="font-size:0.65rem; padding:2px 10px; border-radius:50px; font-weight:600; 
                        <?php if($payment->status == 'verified'): ?> background:#dcfce7; color:#166534;
                        <?php elseif($payment->status == 'pending'): ?> background:#fef3c7; color:#92400e;
                        <?php else: ?> background:#fee2e2; color:#991b1b; <?php endif; ?>
                    ">
                        <?php echo e(__('messages.status_'.$payment->status)); ?>

                    </span>
                    <a href="<?php echo e(route('admin.payments.show', $payment)); ?>" style="background:#0EA5E9; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div style="text-align:center; padding:12px; color:#94a3b8; font-size:0.85rem;"><?php echo e(__('messages.no_payments_recorded')); ?></div>
        <?php endif; ?>
    </div>
</div>




<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-receipt"></i> <?php echo e(__('messages.receipts')); ?>

        <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">(<?php echo e($registration->receipts?->count() ?? 0); ?>)</span>
    </div>
    <div style="padding:16px;">
        <?php if($registration->receipts?->count()): ?>
            <?php $__currentLoopData = $registration->receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e2e8f0;">
                <div>
                    <span style="font-weight:500;"><?php echo e($receipt->receipt_number); ?></span>
                    <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;"><?php echo e($receipt->issued_date->format('Y-m-d')); ?></span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="font-weight:600;">NPR <?php echo e(number_format($receipt->amount, 2)); ?></span>
                    <a href="<?php echo e(route('admin.receipts.show', $receipt)); ?>" style="background:#0EA5E9; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?php echo e(route('admin.receipts.download', $receipt)); ?>" style="background:#22C55E; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div style="text-align:center; padding:12px; color:#94a3b8; font-size:0.85rem;"><?php echo e(__('messages.no_receipts')); ?></div>
        <?php endif; ?>
    </div>
</div>




<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">

    
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #64748B, #475569); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-file-pdf"></i> <?php echo e(__('messages.documents')); ?>

            <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">(<?php echo e($registration->documents?->count() ?? 0); ?>)</span>
        </div>
        <div style="padding:16px;">
            <?php if($registration->documents?->count()): ?>
                <?php $__currentLoopData = $registration->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #e2e8f0;">
                        <div>
                            <span style="font-weight:500;"><?php echo e(ucfirst(str_replace('_', ' ', $doc->type))); ?></span>
                            <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;"><?php echo e($doc->created_at->format('M d, Y')); ?></span>
                        </div>
                        <a href="<?php echo e(route('admin.documents.download', $doc->id)); ?>" style="background:#0EA5E9; color:#fff; padding:2px 12px; border-radius:50px; text-decoration:none; font-size:0.7rem; font-weight:600;">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div style="text-align:center; padding:20px; color:#94a3b8; font-size:0.85rem;"><?php echo e(__('messages.no_documents_uploaded')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-clipboard-check"></i> <?php echo e(__('messages.inspections')); ?>

            <span style="font-size:0.8rem; font-weight:400; opacity:0.8;">(<?php echo e($registration->inspections?->count() ?? 0); ?>)</span>
        </div>
        <div style="padding:16px;">
            <?php if($registration->inspections?->count()): ?>
                <?php $__currentLoopData = $registration->inspections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #e2e8f0;">
                        <div>
                            <span style="font-weight:500;"><?php echo e($inspection->scheduled_date); ?></span>
                            <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;"><?php echo e($inspection->remarks ?? __('messages.no_remarks')); ?></span>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                                <?php if($inspection->status == 'completed'): ?> background:#dcfce7; color:#166534;
                                <?php else: ?> background:#fef3c7; color:#92400e; <?php endif; ?>">
                                <?php echo e(__('messages.status_' . $inspection->status)); ?>

                            </span>
                            <?php if($inspection->status == 'completed'): ?>
                                <a href="#" style="background:#8B5CF6; color:#fff; padding:2px 10px; border-radius:50px; text-decoration:none; font-size:0.65rem; font-weight:600;">
                                    <i class="fas fa-eye"></i> <?php echo e(__('messages.view')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div style="text-align:center; padding:20px; color:#94a3b8; font-size:0.85rem;"><?php echo e(__('messages.no_inspections_scheduled')); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
    <div style="background:linear-gradient(135deg, #EF4444, #DC2626); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-copy"></i> <?php echo e(__('messages.duplicate_reviews')); ?>

    </div>
    <div style="padding:16px;">
        <?php
            $hasReview = $registration->duplicateReviews?->isNotEmpty();
        ?>
        <?php if($hasReview): ?>
            <?php $__currentLoopData = $registration->duplicateReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #e2e8f0;">
                    <div>
                        <span style="font-weight:500;"><?php echo e($review->reviewedBy->name ?? __('messages.not_available')); ?></span>
                        <span style="font-size:0.7rem; color:#94a3b8; margin-left:8px;"><?php echo e($review->notes ?? __('messages.no_notes')); ?></span>
                    </div>
                    <span style="padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; 
                        <?php if($review->is_duplicate): ?> background:#fee2e2; color:#991b1b;
                        <?php else: ?> background:#dcfce7; color:#166534; <?php endif; ?>">
                        <?php echo e($review->is_duplicate ? __('messages.yes') : __('messages.no')); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div style="text-align:center; padding:12px; color:#94a3b8; font-size:0.85rem;"><?php echo e(__('messages.no_duplicate_reviews')); ?></div>
        <?php endif; ?>

        <div style="margin-top:12px; display:flex; gap:8px;">
            <?php if(!$hasReview): ?>
                <form action="<?php echo e(route('admin.duplicate.review', $registration)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="is_duplicate" value="0">
                    <button type="submit" style="background:#22C55E; color:#fff; border:none; padding:4px 16px; border-radius:50px; font-weight:600; font-size:0.75rem; cursor:pointer;">
                        <i class="fas fa-check"></i> <?php echo e(__('messages.not_duplicate')); ?>

                    </button>
                </form>
                <form action="<?php echo e(route('admin.duplicate.review', $registration)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="is_duplicate" value="1">
                    <button type="submit" style="background:#EF4444; color:#fff; border:none; padding:4px 16px; border-radius:50px; font-weight:600; font-size:0.75rem; cursor:pointer;">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo e(__('messages.mark_as_duplicate')); ?>

                    </button>
                </form>
            <?php else: ?>
                <span style="color:#94a3b8; font-size:0.8rem;"><?php echo e(__('messages.review_completed')); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>




<div style="margin-top:24px;">
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #1E293B, #0F172A); color:#fff; padding:12px 20px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-tools"></i> <?php echo e(__('messages.actions')); ?>

        </div>
        <div style="padding:16px; display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px;">

            
            <div>
                <h5 style="margin:0 0 8px 0; font-size:0.85rem; color:#0EA5E9;"><?php echo e(__('messages.finance')); ?></h5>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    <?php if($hasInvoice && $latestInvoice): ?>
                        <a href="<?php echo e(route('admin.invoices.show', $latestInvoice)); ?>" style="display:inline-flex; align-items:center; gap:4px; background:#0EA5E9; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                            <i class="fas fa-eye"></i> <?php echo e(__('messages.view_invoice')); ?>

                        </a>
                        <?php if($latestInvoice->status !== 'paid'): ?>
                            <a href="<?php echo e(route('admin.payments.create', ['invoice_id' => $latestInvoice->id])); ?>" style="display:inline-flex; align-items:center; gap:4px; background:#F59E0B; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                                <i class="fas fa-plus"></i> <?php echo e(__('messages.add_payment')); ?>

                            </a>
                        <?php endif; ?>
                    <?php elseif($canGenerateInvoice): ?>
                        <button type="button" onclick="document.getElementById('invoiceForm').style.display='block'" style="display:inline-flex; align-items:center; gap:4px; background:#8B5CF6; color:#fff; border:none; padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; cursor:pointer;">
                            <i class="fas fa-file-invoice"></i> <?php echo e(__('messages.generate_invoice')); ?>

                        </button>
                    <?php endif; ?>
                </div>
            </div>

            
            <div>
                <h5 style="margin:0 0 8px 0; font-size:0.85rem; color:#06B6D4;"><?php echo e(__('messages.inspection')); ?></h5>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    <?php
                        $hasCompletedInspection = $registration->inspections->where('status', 'completed')->isNotEmpty();
                    ?>
                    <?php if($hasCompletedInspection): ?>
    <?php
        $completedInspection = $registration->inspections->where('status', 'completed')->first();
    ?>
    <?php if($completedInspection): ?>
        <a href="<?php echo e(route('admin.inspections.view', $completedInspection)); ?>" style="display:inline-flex; align-items:center; gap:4px; background:#8B5CF6; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
            <i class="fas fa-eye"></i> <?php echo e(__('messages.view_inspection')); ?>

        </a>
    <?php endif; ?>
<?php endif; ?>
                </div>
            </div>

            
            <div>
                <h5 style="margin:0 0 8px 0; font-size:0.85rem; color:#64748B;"><?php echo e(__('messages.management')); ?></h5>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    <?php if($registration->status === 'pending'): ?>
                        <form action="<?php echo e(route('admin.registrations.approve', $registration)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" style="display:inline-flex; align-items:center; gap:4px; background:#22C55E; color:#fff; border:none; padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; cursor:pointer;">
                                <i class="fas fa-check"></i> <?php echo e(__('messages.approve')); ?>

                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.registrations.reject', $registration)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" style="display:inline-flex; align-items:center; gap:4px; background:#EF4444; color:#fff; border:none; padding:4px 14px; border-radius:50px; font-size:0.75rem; font-weight:600; cursor:pointer;">
                                <i class="fas fa-times"></i> <?php echo e(__('messages.reject')); ?>

                            </button>
                        </form>
                    <?php endif; ?>
                    <a href="<?php echo e(route('admin.registrations.edit', $registration)); ?>" style="display:inline-flex; align-items:center; gap:4px; background:#F59E0B; color:#fff; padding:4px 14px; border-radius:50px; text-decoration:none; font-size:0.75rem; font-weight:600;">
                        <i class="fas fa-edit"></i> <?php echo e(__('messages.edit')); ?>

                    </a>
                </div>
            </div>

        </div>

        
        <div id="inspectorForm" style="display:none; background:#f8fafc; border-radius:12px; padding:16px; margin:0 16px 16px 16px;">
            <form action="<?php echo e(route('admin.registrations.assignInspector', $registration)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;"><?php echo e(__('messages.inspector')); ?> <span style="color:#dc2626;">*</span></label>
                        <select name="inspector_id" required style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#fff;">
                            <option value=""><?php echo e(__('messages.select_inspector')); ?></option>
                            <?php $__empty_1 = true; $__currentLoopData = $inspectors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($inspector->id); ?>"><?php echo e($inspector->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <option value="" disabled><?php echo e(__('messages.no_inspectors_available')); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;"><?php echo e(__('messages.scheduled_date')); ?> <span style="color:#dc2626;">*</span></label>
                        <input type="date" name="scheduled_date" required style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;"><?php echo e(__('messages.remarks_optional')); ?></label>
                        <input type="text" name="remarks" placeholder="<?php echo e(__('messages.remarks_placeholder_schedule')); ?>" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                </div>
                <div style="margin-top:12px; text-align:right;">
                    <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.8rem; cursor:pointer; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
                        <i class="fas fa-calendar-plus"></i> <?php echo e(__('messages.assign_and_schedule')); ?>

                    </button>
                </div>
            </form>
        </div>

        
        <?php if($canGenerateInvoice): ?>
        <div id="invoiceForm" style="display:none; background:#f8fafc; border-radius:12px; padding:16px; margin:0 16px 16px 16px;">
            <form action="<?php echo e(route('admin.invoices.generate')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="registration_id" value="<?php echo e($registration->id); ?>">
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;"><?php echo e(__('messages.invoice_type')); ?> <span style="color:#dc2626;">*</span></label>
                        <select name="invoice_type" required style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#fff;">
                            <option value="new_registration"><?php echo e(__('messages.invoice_type_new_registration')); ?></option>
                            <option value="renewal"><?php echo e(__('messages.invoice_type_renewal')); ?></option>
                            <option value="membership_fee"><?php echo e(__('messages.invoice_type_membership_fee')); ?></option>
                            <option value="inspection_fee"><?php echo e(__('messages.invoice_type_inspection_fee')); ?></option>
                            <option value="certificate_fee"><?php echo e(__('messages.invoice_type_certificate_fee')); ?></option>
                            <option value="penalty"><?php echo e(__('messages.invoice_type_penalty')); ?></option>
                            <option value="other"><?php echo e(__('messages.invoice_type_other')); ?></option>
                        </select>
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;"><?php echo e(__('messages.amount_npr')); ?> <span style="color:#dc2626;">*</span></label>
                        <input type="number" name="amount" step="0.01" required placeholder="0.00" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                    <div>
                        <label style="font-weight:600; color:#1e293b; font-size:0.8rem; display:block; margin-bottom:4px;"><?php echo e(__('messages.due_date')); ?></label>
                        <input type="date" name="due_date" style="width:100%; padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem;">
                    </div>
                </div>
                <div style="margin-top:12px; text-align:right;">
                    <button type="submit" style="background:linear-gradient(135deg, #F59E0B, #D97706); color:#fff; border:none; padding:6px 20px; border-radius:50px; font-weight:600; font-size:0.8rem; cursor:pointer; box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                        <i class="fas fa-file-invoice"></i> <?php echo e(__('messages.generate_invoice')); ?>

                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/registrations/show.blade.php ENDPATH**/ ?>