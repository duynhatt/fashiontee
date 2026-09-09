<?php $__env->startSection('AdminContent'); ?>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
            <span>QUẢN LÝ VAI TRÒ & PHÂN QUYỀN (RBAC)</span>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.manage')): ?>
            <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i> Thêm vai trò mới
            </a>
            <?php endif; ?>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success" style="margin: 15px 15px 0 15px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger" style="margin: 15px 15px 0 15px;">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="table-responsive" style="padding: 15px;">
            <table class="table table-striped table-hover b-t b-light">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Mã vai trò (Slug)</th>
                        <th>Tên hiển thị</th>
                        <th>Mô tả</th>
                        <th class="text-center">Người dùng</th>
                        <th class="text-center">Quyền hạn</th>
                        <th style="width: 180px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td>
                                <code><?php echo e($role->name); ?></code>
                            </td>
                            <td>
                                <strong><?php echo e($role->display_name); ?></strong>
                                <?php if($role->name === 'super_admin'): ?>
                                    <span class="label label-danger" style="margin-left: 5px;">Tối cao (Bypass)</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($role->description ?? 'Chưa có mô tả'); ?></td>
                            <td class="text-center">
                                <span class="badge bg-info" style="font-size: 13px;"><?php echo e($role->users_count); ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($role->name === 'super_admin'): ?>
                                    <span class="label label-primary" style="font-size: 12px;">Toàn quyền (Tất cả)</span>
                                <?php else: ?>
                                    <span class="badge bg-success" style="font-size: 13px;"><?php echo e($role->permissions_count); ?> quyền</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($role->name === 'super_admin'): ?>
                                    <span class="text-muted"><i class="fa fa-lock"></i> Đã khóa bảo vệ</span>
                                <?php else: ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.manage')): ?>
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>" class="btn btn-xs btn-primary" title="Chỉnh sửa quyền">
                                            <i class="fa fa-pencil"></i> Sửa quyền
                                        </a>
                                        <form action="<?php echo e(route('admin.roles.destroy', $role->id)); ?>" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vai trò [<?php echo e($role->display_name); ?>]?');" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-xs btn-danger" <?php echo e($role->users_count > 0 ? 'disabled title="Đang có người dùng giữ vai trò này"' : 'title="Xóa vai trò"'); ?>>
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>