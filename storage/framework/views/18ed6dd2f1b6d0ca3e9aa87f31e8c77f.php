

<?php $__env->startSection('title', __('messages.admin_dashboard') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="stats-grid">
    <div class="stat-card">
        <div class="num"><?php echo e($totalHostels ?? 0); ?></div>
        <div class="label"><?php echo e(__('messages.admin_total_hostels')); ?></div>
    </div>
    <div class="stat-card">
        <div class="num"><?php echo e($pendingRegistrations ?? 0); ?></div>
        <div class="label"><?php echo e(__('messages.admin_pending_registrations')); ?></div>
    </div>
    <div class="stat-card">
        <div class="num"><?php echo e($inspectionsPending ?? 0); ?></div>
        <div class="label"><?php echo e(__('messages.admin_inspections_pending')); ?></div>
    </div>
    <div class="stat-card">
        <div class="num"><?php echo e($members ?? 0); ?></div>
        <div class="label"><?php echo e(__('messages.admin_members')); ?></div>
    </div>
</div>

<!-- Chart placeholder -->
<div style="background:#fff; border-radius:16px; padding:30px; margin-top:30px; box-shadow:0 2px 12px rgba(0,0,0,0.04);">
    <h4><?php echo e(__('messages.monthly_registrations') ?? 'Monthly Registrations'); ?></h4>
    <canvas id="dashboardChart" height="100"></canvas>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: '<?php echo e(__('messages.registrations') ?? "Registrations"); ?>',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#f97316',
                    tension: 0.4
                }]
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>