

<?php $__env->startSection('title', __('messages.admin_hostels_title') . ' - HEAN Admin'); ?>

<?php $__env->startSection('content'); ?>


<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#0EA5E9; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-hotel" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;"><?php echo e($totalHostels ?? $hostels->total()); ?></div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;"><?php echo e(__('messages.total_hostels')); ?></div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#22C55E; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-check-circle" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;"><?php echo e($approvedCount ?? $hostels->where('approved', true)->count()); ?></div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;"><?php echo e(__('messages.approved')); ?></div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#F59E0B; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-star" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;"><?php echo e($featuredCount ?? $hostels->where('featured', true)->count()); ?></div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;"><?php echo e(__('messages.featured')); ?></div>
        </div>
    </div>
    <div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px;">
        <div style="background:#8B5CF6; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; color:#fff;">
            <i class="fas fa-eye" style="font-size:1.2rem;"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:700; color:#0f172a;"><?php echo e($visibleCount ?? $hostels->where('visible', true)->count()); ?></div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.03em;"><?php echo e(__('messages.visible')); ?></div>
        </div>
    </div>
</div>


<div style="background:#fff; border-radius:12px; padding:16px 20px; border:1px solid #e2e8f0; margin-bottom:24px;">
    <form action="<?php echo e(route('admin.hostels.index')); ?>" method="GET" id="filterForm">
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">

            
            <div style="flex:2; min-width:200px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">
                    <i class="fas fa-search" style="color:#0EA5E9;"></i> <?php echo e(__('messages.search')); ?>

                </label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('messages.search_placeholder_hostel')); ?>" 
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; transition:0.2s;">
            </div>

            
            <div style="flex:1; min-width:140px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;"><?php echo e(__('messages.status')); ?></label>
                <select name="status" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value=""><?php echo e(__('messages.all')); ?></option>
                    <option value="approved" <?php echo e(request('status')=='approved'?'selected':''); ?>><?php echo e(__('messages.status_approved')); ?></option>
                    <option value="pending" <?php echo e(request('status')=='pending'?'selected':''); ?>><?php echo e(__('messages.status_pending')); ?></option>
                    <option value="rejected" <?php echo e(request('status')=='rejected'?'selected':''); ?>><?php echo e(__('messages.status_rejected')); ?></option>
                </select>
            </div>

            
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;"><?php echo e(__('messages.featured')); ?></label>
                <select name="featured" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value=""><?php echo e(__('messages.all')); ?></option>
                    <option value="1" <?php echo e(request('featured')=='1'?'selected':''); ?>><?php echo e(__('messages.featured')); ?></option>
                    <option value="0" <?php echo e(request('featured')=='0'?'selected':''); ?>><?php echo e(__('messages.normal')); ?></option>
                </select>
            </div>

            
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;"><?php echo e(__('messages.visibility')); ?></label>
                <select name="visible" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value=""><?php echo e(__('messages.all')); ?></option>
                    <option value="1" <?php echo e(request('visible')=='1'?'selected':''); ?>><?php echo e(__('messages.visible')); ?></option>
                    <option value="0" <?php echo e(request('visible')=='0'?'selected':''); ?>><?php echo e(__('messages.hidden')); ?></option>
                </select>
            </div>

            
            <div style="flex:1; min-width:120px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;"><?php echo e(__('messages.type')); ?></label>
                <select name="type" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value=""><?php echo e(__('messages.all')); ?></option>
                    <option value="boys" <?php echo e(request('type')=='boys'?'selected':''); ?>><?php echo e(__('messages.boys')); ?></option>
                    <option value="girls" <?php echo e(request('type')=='girls'?'selected':''); ?>><?php echo e(__('messages.girls')); ?></option>
                    <option value="co-ed" <?php echo e(request('type')=='co-ed'?'selected':''); ?>><?php echo e(__('messages.co_ed')); ?></option>
                </select>
            </div>

            
            <div style="flex:1; min-width:130px;">
                <label style="font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;"><?php echo e(__('messages.sort_by')); ?></label>
                <select name="sort" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; background:#f8fafc; cursor:pointer;">
                    <option value="latest" <?php echo e(request('sort')=='latest'?'selected':''); ?>><?php echo e(__('messages.sort_latest')); ?></option>
                    <option value="oldest" <?php echo e(request('sort')=='oldest'?'selected':''); ?>><?php echo e(__('messages.sort_oldest')); ?></option>
                    <option value="name_asc" <?php echo e(request('sort')=='name_asc'?'selected':''); ?>><?php echo e(__('messages.sort_name_asc')); ?></option>
                    <option value="name_desc" <?php echo e(request('sort')=='name_desc'?'selected':''); ?>><?php echo e(__('messages.sort_name_desc')); ?></option>
                    <option value="district_asc" <?php echo e(request('sort')=='district_asc'?'selected':''); ?>><?php echo e(__('messages.sort_district_asc')); ?></option>
                    <option value="capacity_desc" <?php echo e(request('sort')=='capacity_desc'?'selected':''); ?>><?php echo e(__('messages.sort_capacity_desc')); ?></option>
                    <option value="capacity_asc" <?php echo e(request('sort')=='capacity_asc'?'selected':''); ?>><?php echo e(__('messages.sort_capacity_asc')); ?></option>
                </select>
            </div>

            
            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <button type="submit" style="background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; border:none; padding:10px 22px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.25);">
                    <i class="fas fa-filter"></i> <?php echo e(__('messages.filter')); ?>

                </button>
                <a href="<?php echo e(route('admin.hostels.index')); ?>" style="background:#e2e8f0; color:#1e293b; padding:10px 18px; border-radius:50px; text-decoration:none; font-weight:500; font-size:0.85rem; transition:0.2s; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-undo"></i> <?php echo e(__('messages.reset')); ?>

                </a>
            </div>
        </div>
    </form>
</div>


<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
    <div style="font-size:0.9rem; color:#64748b;">
        <i class="fas fa-info-circle"></i> 
        <?php echo e(__('messages.showing_hostels', ['total' => $hostels->total(), 'from' => $hostels->firstItem() ?? 0, 'to' => $hostels->lastItem() ?? 0])); ?>

    </div>
    <a href="<?php echo e(route('admin.hostels.create')); ?>" style="display:inline-flex; align-items:center; gap:8px; background:#0EA5E9; color:#fff; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.3s; box-shadow:0 4px 15px rgba(14,165,233,0.3);">
        <i class="fas fa-plus-circle"></i> <?php echo e(__('messages.add_new')); ?>

    </a>
</div>


<div class="table-container" style="overflow-x:auto; background:#fff; border-radius:12px; border:1px solid #e2e8f0;">
    
<form action="<?php echo e(route('admin.test.bulk')); ?>" method="POST" onsubmit="return confirmBulkAction();">
    <?php echo csrf_field(); ?>

            <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
            <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                <tr>
                    <th style="padding:12px 16px; text-align:left; width:40px;">
                        <input type="checkbox" id="selectAll" style="accent-color:#0EA5E9; width:16px; height:16px; cursor:pointer;">
                    </th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.hostel')); ?></th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.district')); ?></th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.type')); ?></th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.capacity')); ?></th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.status')); ?></th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.featured')); ?></th>
                    <th style="padding:12px 16px; text-align:left; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.visible')); ?></th>
                    <th style="padding:12px 16px; text-align:center; font-weight:600; color:#475569; text-transform:uppercase; font-size:0.75rem; letter-spacing:0.03em;"><?php echo e(__('messages.actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $hostels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hostel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom:1px solid #e2e8f0; transition:background 0.15s;" class="hover:bg-gray-50">
                    <td style="padding:12px 16px; text-align:center;">
                        <input type="checkbox" name="ids[]" value="<?php echo e($hostel->id); ?>" class="rowCheckbox" style="accent-color:#0EA5E9; width:16px; height:16px; cursor:pointer;">
                    </td>
                    <td style="padding:12px 16px; font-weight:500; color:#0f172a;">
                        <?php echo e($hostel->name_english ?: $hostel->name_nepali); ?>

                        <?php if($hostel->name_english && $hostel->name_nepali && $hostel->name_english != $hostel->name_nepali): ?>
                            <br><span style="font-size:0.7rem; color:#94a3b8;"><?php echo e($hostel->name_nepali); ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:12px 16px; color:#475569;"><?php echo e($hostel->district); ?></td>
                    <td style="padding:12px 16px;">
                        <span style="background:rgba(14,165,233,0.1); color:#0EA5E9; padding:2px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                            <?php echo e(__($hostel->type ? 'messages.type_' . $hostel->type : 'messages.not_available')); ?>

                        </span>
                    </td>
                    <td style="padding:12px 16px; font-weight:600; color:#0f172a;"><?php echo e($hostel->capacity ?? 0); ?></td>
                    <td style="padding:12px 16px;">
                        <?php if($hostel->approved): ?>
                            <span style="background:#dcfce7; color:#166534; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                                <i class="fas fa-check-circle" style="font-size:0.65rem;"></i> <?php echo e(__('messages.status_approved')); ?>

                            </span>
                        <?php else: ?>
                            <span style="background:#fef3c7; color:#92400e; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;">
                                <i class="fas fa-clock" style="font-size:0.65rem;"></i> <?php echo e(__('messages.status_pending')); ?>

                            </span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:12px 16px; text-align:center;">
                        <?php if($hostel->featured): ?>
                            <span style="color:#F59E0B; font-size:1.1rem;" title="<?php echo e(__('messages.featured')); ?>">⭐</span>
                        <?php else: ?>
                            <span style="color:#cbd5e1; font-size:0.9rem;">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:12px 16px; text-align:center;">
                        <?php if($hostel->visible): ?>
                            <span style="color:#0EA5E9; font-size:1.1rem;" title="<?php echo e(__('messages.visible')); ?>">👁️</span>
                        <?php else: ?>
                            <span style="color:#94a3b8; font-size:1rem;" title="<?php echo e(__('messages.hidden')); ?>">🚫</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:12px 16px; text-align:center; white-space:nowrap;">
                        <a href="<?php echo e(route('admin.hostels.show', $hostel)); ?>" style="display:inline-block; padding:4px 10px; background:#0EA5E9; color:#fff; border-radius:6px; text-decoration:none; font-size:0.7rem; font-weight:600; margin-right:4px; transition:0.2s;" title="<?php echo e(__('messages.view')); ?>">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('admin.hostels.edit', $hostel)); ?>" style="display:inline-block; padding:4px 10px; background:#F59E0B; color:#fff; border-radius:6px; text-decoration:none; font-size:0.7rem; font-weight:600; margin-right:4px; transition:0.2s;" title="<?php echo e(__('messages.edit')); ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('admin.hostels.destroy', $hostel)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('<?php echo e(__('messages.confirm_delete_hostel')); ?>')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" style="padding:4px 10px; background:#EF4444; color:#fff; border:none; border-radius:6px; font-size:0.7rem; font-weight:600; cursor:pointer; transition:0.2s;" title="<?php echo e(__('messages.delete')); ?>">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" style="padding:40px 16px; text-align:center; color:#94a3b8;">
                        <i class="fas fa-hotel" style="font-size:2rem; display:block; margin-bottom:8px; color:#cbd5e1;"></i>
                        <?php echo e(__('messages.no_hostels_found')); ?>

                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        
        <?php if($hostels->count() > 0): ?>
        <div style="padding:12px 16px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; flex-wrap:wrap; align-items:center; gap:12px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-weight:600; color:#475569; font-size:0.85rem;"><?php echo e(__('messages.selected')); ?>:</span>
                <select name="bulk_action" id="bulkAction" style="padding:8px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.85rem; background:#fff; cursor:pointer;">
                    <option value=""><?php echo e(__('messages.choose_action')); ?></option>
                    <option value="approve"><?php echo e(__('messages.bulk_approve')); ?></option>
                    <option value="reject"><?php echo e(__('messages.bulk_reject')); ?></option>
                    <option value="feature"><?php echo e(__('messages.bulk_feature')); ?></option>
                    <option value="unfeature"><?php echo e(__('messages.bulk_unfeature')); ?></option>
                    <option value="hide"><?php echo e(__('messages.bulk_hide')); ?></option>
                    <option value="show"><?php echo e(__('messages.bulk_show')); ?></option>
                    <option value="delete"><?php echo e(__('messages.bulk_delete')); ?></option>
                </select>
                <button type="submit" style="background:#0EA5E9; color:#fff; border:none; padding:8px 20px; border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer; transition:0.2s; box-shadow:0 2px 10px rgba(14,165,233,0.2);">
                    <i class="fas fa-check"></i> <?php echo e(__('messages.apply')); ?>

                </button>
            </div>
            <div style="margin-left:auto; font-size:0.8rem; color:#94a3b8;">
                <span id="selectedCount">0</span> <?php echo e(__('messages.items_selected')); ?>

            </div>
        </div>
        <?php endif; ?>
    </form>
</div>


<div style="margin-top:24px; display:flex; justify-content:center;">
    <?php echo e($hostels->appends(request()->query())->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Table row hover effect */
    tbody tr:hover {
        background: #f8fafc;
    }

    /* Pagination custom style */
    .pagination-wrapper .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination-wrapper .pagination .page-item .page-link {
        padding: 8px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        color: #1e293b;
        text-decoration: none;
        transition: 0.2s;
        font-weight: 500;
        font-size: 0.9rem;
        background: #fff;
    }
    .pagination-wrapper .pagination .page-item .page-link:hover {
        background: #f1f5f9;
        border-color: #0EA5E9;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0EA5E9, #3B82F6);
        border-color: #0EA5E9;
        color: #fff;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== SELECT ALL =====
        const selectAll = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');
        const selectedCount = document.getElementById('selectedCount');

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.rowCheckbox:checked').length;
            if (selectedCount) selectedCount.textContent = checked;
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedCount();
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                updateSelectedCount();
                if (!this.checked && selectAll) {
                    selectAll.checked = false;
                }
                if (selectAll) {
                    const allChecked = Array.from(rowCheckboxes).every(c => c.checked);
                    selectAll.checked = allChecked;
                }
            });
        });

        updateSelectedCount();
    });

    // ✅ बल्क एक्शन कन्फर्मेसन
    function confirmBulkAction() {
        const action = document.getElementById('bulkAction').value;
        const checked = document.querySelectorAll('.rowCheckbox:checked');
        
        if (checked.length === 0) {
            alert('<?php echo e(__('messages.select_at_least_one')); ?>');
            return false;
        }
        if (action === '') {
            alert('<?php echo e(__('messages.choose_action_first')); ?>');
            return false;
        }
        if (action === 'delete') {
            return confirm('<?php echo e(__('messages.confirm_bulk_delete')); ?>');
        } else {
            let confirmMsg = '<?php echo e(__('messages.confirm_bulk_action')); ?>'.replace(':action', action);
            return confirm(confirmMsg);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hean\resources\views/admin/hostels/index.blade.php ENDPATH**/ ?>