<?php $__env->startSection('AdminContent'); ?>
<div class="form-w3layouts">
    <div class="panel panel-default">
        <div class="panel-heading">CHỈNH SỬA VAI TRÒ & PHÂN QUYỀN: <strong><?php echo e($role->display_name); ?></strong></div>
        <div class="panel-body">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0; padding-left: 18px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.roles.update', $role->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Mã vai trò (Slug)</strong></label>
                        <input type="text" class="form-control" value="<?php echo e($role->name); ?>" disabled>
                        <small class="text-muted">Mã định danh không thể thay đổi sau khi tạo</small>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Tên hiển thị</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="display_name" class="form-control" value="<?php echo e(old('display_name', $role->display_name)); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Mô tả vai trò</strong></label>
                    <textarea name="description" class="form-control" rows="2"><?php echo e(old('description', $role->description)); ?></textarea>
                </div>

                <hr>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin: 0; font-weight: bold; color: #333;">DANH SÁCH QUYỀN HẠN (PERMISSIONS)</h4>
                    <label style="cursor: pointer; font-weight: bold; color: #2a80b9;">
                        <input type="checkbox" id="check-all-permissions" style="margin-right: 5px;"> Chọn tất cả hệ thống
                    </label>
                </div>

                <?php
                    $groupLabels = [
                        'system' => ['title' => 'Cửa ngõ Hệ thống', 'color' => '#673ab7'],
                        'reports' => ['title' => 'Báo cáo & Thống kê', 'color' => '#009688'],
                        'products' => ['title' => 'Sản phẩm', 'color' => '#3f51b5'],
                        'categories' => ['title' => 'Danh mục', 'color' => '#2196f3'],
                        'attributes' => ['title' => 'Thuộc tính (Màu, Size)', 'color' => '#03a9f4'],
                        'inventory' => ['title' => 'Tồn kho & Biến thể', 'color' => '#ff9800'],
                        'orders' => ['title' => 'Đơn hàng & Đổi trả', 'color' => '#e91e63'],
                        'vouchers' => ['title' => 'Mã khuyến mãi (Voucher)', 'color' => '#9c27b0'],
                        'reviews' => ['title' => 'Đánh giá & Bình luận', 'color' => '#4caf50'],
                        'contacts' => ['title' => 'Tin nhắn Liên hệ', 'color' => '#00bcd4'],
                        'users' => ['title' => 'Tài khoản người dùng', 'color' => '#f44336'],
                        'roles' => ['title' => 'Vai trò & Phân quyền', 'color' => '#d32f2f'],
                    ];
                ?>

                <div class="row">
                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $groupInfo = $groupLabels[$group] ?? ['title' => ucfirst($group), 'color' => '#607d8b'];
                        ?>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <div class="panel" style="border: 1px solid #ddd; border-top: 3px solid <?php echo e($groupInfo['color']); ?>; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                <div class="panel-heading" style="background: #fafafa; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="color: #333;"><?php echo e($groupInfo['title']); ?></strong>
                                    <label style="margin: 0; font-size: 12px; cursor: pointer; color: #666;">
                                        <input type="checkbox" class="check-group" data-group="<?php echo e($group); ?>"> Chọn nhóm
                                    </label>
                                </div>
                                <div class="panel-body" style="padding: 12px 15px;">
                                    <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $isChecked = in_array($perm->id, old('permissions', $rolePermissions));
                                        ?>
                                        <div class="checkbox" style="margin-top: 6px; margin-bottom: 6px;">
                                            <label style="cursor: pointer;">
                                                <input type="checkbox" name="permissions[]" value="<?php echo e($perm->id); ?>" class="perm-checkbox group-<?php echo e($group); ?>" <?php echo e($isChecked ? 'checked' : ''); ?>>
                                                <strong><?php echo e($perm->display_name); ?></strong>
                                                <small class="text-muted" style="display: block; margin-left: 20px;"><code><?php echo e($perm->name); ?></code> - <?php echo e($perm->description); ?></small>
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Cập nhật quyền vai trò
                    </button>
                    <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('check-all-permissions');
    const allCheckboxes = document.querySelectorAll('.perm-checkbox');
    const groupCheckboxes = document.querySelectorAll('.check-group');

    // Init check all state
    if (checkAll) {
        checkAll.checked = Array.from(allCheckboxes).every(cb => cb.checked);
        checkAll.addEventListener('change', function() {
            allCheckboxes.forEach(cb => cb.checked = checkAll.checked);
            groupCheckboxes.forEach(cb => cb.checked = checkAll.checked);
        });
    }

    // Check by group
    groupCheckboxes.forEach(gcb => {
        const group = gcb.getAttribute('data-group');
        const items = document.querySelectorAll('.group-' + group);

        // Update initial group state
        const allChecked = Array.from(items).every(i => i.checked);
        gcb.checked = allChecked && items.length > 0;

        gcb.addEventListener('change', function() {
            items.forEach(i => i.checked = gcb.checked);
            if (checkAll) {
                checkAll.checked = Array.from(allCheckboxes).every(cb => cb.checked);
            }
        });

        items.forEach(i => {
            i.addEventListener('change', function() {
                gcb.checked = Array.from(items).every(item => item.checked);
                if (checkAll) {
                    checkAll.checked = Array.from(allCheckboxes).every(cb => cb.checked);
                }
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/roles/edit.blade.php ENDPATH**/ ?>