

<?php $__env->startSection('title', __('messages.admin_committee_title') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2><?php echo e(__('messages.committee_members')); ?></h2>
    <a href="<?php echo e(route('admin.committee.create')); ?>" class="btn btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; transition:0.3s;">
        <i class="fas fa-plus"></i> <?php echo e(__('messages.add_new_member')); ?>

    </a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo e(__('messages.name')); ?></th>
                <th><?php echo e(__('messages.position')); ?></th>
                <th><?php echo e(__('messages.published')); ?></th>
                <th><?php echo e(__('messages.order')); ?></th>
                <th><?php echo e(__('messages.actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($member->id); ?></td>
                <td>
                    <?php if($member->image): ?>
                        <img src="<?php echo e(asset('storage/'.$member->image)); ?>" style="width:32px; height:32px; border-radius:50%; object-fit:cover; margin-right:8px;">
                    <?php endif; ?>
                    <?php echo e($member->name); ?>

                </td>
                <td><?php echo e($member->position); ?></td>
                <td>
                    <span style="color:<?php echo e($member->is_published ? '#10B981' : '#dc2626'); ?>;">
                        <?php echo e($member->is_published ? '✅' : '❌'); ?>

                    </span>
                </td>
                <td><?php echo e($member->order ?? 0); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.committee.edit', $member)); ?>" class="btn-action btn-primary-sm" style="background:#0EA5E9; color:#fff; padding:4px 12px; border-radius:6px; text-decoration:none; font-size:0.75rem; display:inline-block;"><?php echo e(__('messages.edit')); ?></a>
                    <form action="<?php echo e(route('admin.committee.destroy', $member)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-action btn-danger-sm" style="background:#ef4444; color:#fff; padding:4px 12px; border-radius:6px; border:none; font-size:0.75rem; cursor:pointer;" onclick="return confirm('<?php echo e(__('messages.confirm_delete_member')); ?>')"><?php echo e(__('messages.delete')); ?></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;"><?php echo e(__('messages.no_members_found')); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo e($members->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/committee/index.blade.php ENDPATH**/ ?>