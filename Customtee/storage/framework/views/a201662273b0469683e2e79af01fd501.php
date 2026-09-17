<?php $__env->startSection('AdminContent'); ?>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
            <span>QUẢN LÝ TÀI KHOẢN NGƯỜI DÙNG & VAI TRÒ</span>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.create')): ?>
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-sm btn-success">
                <i class="fa fa-user-plus"></i> Thêm tài khoản mới
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

        <!-- Bộ lọc & Tìm kiếm -->
        <div class="row w3-res-tb" style="padding: 15px 15px 5px 15px;">
            <div class="col-sm-12">
                <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="form-inline" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                    <div class="form-group">
                        <input type="text" name="keyword" value="<?php echo e(request('keyword')); ?>" class="form-control input-sm" placeholder="Tìm tên, email, SĐT..." style="min-width: 220px;">
                    </div>
                    <div class="form-group">
                        <select name="role" class="form-control input-sm">
                            <option value="">-- Tất cả vai trò --</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($r->name); ?>" <?php echo e(request('role') == $r->name ? 'selected' : ''); ?>>
                                    <?php echo e($r->display_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-filter"></i> Lọc dữ liệu
                    </button>
                    <?php if(request()->hasAny(['keyword', 'role'])): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-default">
                            <i class="fa fa-refresh"></i> Đặt lại
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="table-responsive" style="padding: 15px;">
            <table class="table table-striped table-hover b-t b-light">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Họ tên</th>
                        <th>Email & SĐT</th>
                        <th>Vai trò (Roles)</th>
                        <th class="text-center">Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th style="width: 180px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($user->id); ?></td>
                            <td>
                                <strong><?php echo e($user->name); ?></strong>
                                <?php if($user->hasRole('super_admin')): ?>
                                    <span class="label label-danger" style="margin-left: 5px;">Super Admin</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div><i class="fa fa-envelope-o text-muted"></i> <?php echo e($user->email); ?></div>
                                <?php if($user->phone): ?>
                                    <div><small class="text-muted"><i class="fa fa-phone"></i> <?php echo e($user->phone); ?></small></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $__empty_2 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <?php
                                        $badgeClass = match($role->name) {
                                            'super_admin' => 'label-danger',
                                            'admin' => 'label-primary',
                                            'warehouse' => 'label-warning',
                                            'order_staff' => 'label-info',
                                            default => 'label-default',
                                        };
                                    ?>
                                    <span class="label <?php echo e($badgeClass); ?>" style="font-size: 11px; margin-right: 4px; display: inline-block; margin-bottom: 2px;">
                                        <?php echo e($role->display_name); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span class="text-muted">Chưa gán vai trò</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($user->status == 1): ?>
                                    <span class="label label-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="label label-default">Đã khóa</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted"><?php echo e($user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A'); ?></small>
                            </td>
                            <td class="text-center">
                                <div style="display: inline-flex; gap: 5px; align-items: center;">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.update')): ?>
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-xs btn-primary" title="Sửa thông tin & vai trò">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>

                                    <?php if(!$user->hasRole('super_admin') && auth()->id() !== $user->id): ?>
                                    <form action="<?php echo e(route('admin.users.toggle-status', $user->id)); ?>" method="POST" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-xs <?php echo e($user->status == 1 ? 'btn-warning' : 'btn-success'); ?>" title="<?php echo e($user->status == 1 ? 'Khóa tài khoản' : 'Mở khóa tài khoản'); ?>">
                                            <i class="fa <?php echo e($user->status == 1 ? 'fa-ban' : 'fa-check'); ?>"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.delete')): ?>
                                    <?php if(!$user->hasRole('super_admin') && auth()->id() !== $user->id): ?>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng [<?php echo e($user->name); ?>]?');" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-xs btn-danger" title="Xóa tài khoản">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 30px;">
                                Không tìm thấy người dùng nào phù hợp.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="panel-footer" style="background: #fafafa;">
            <div class="row">
                <div class="col-sm-6 text-muted">
                    Hiển thị <?php echo e($users->firstItem() ?? 0); ?> đến <?php echo e($users->lastItem() ?? 0); ?> trong tổng số <?php echo e($users->total()); ?> tài khoản
                </div>
                <div class="col-sm-6 text-right">
                    <?php echo e($users->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\admin\users\index.blade.php ENDPATH**/ ?>