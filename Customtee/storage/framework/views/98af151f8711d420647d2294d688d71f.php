<?php $__env->startSection('AdminContent'); ?>
<div class="form-w3layouts">
    <div class="panel panel-default">
        <div class="panel-heading">CHỈNH SỬA TÀI KHOẢN & VAI TRÒ: <strong><?php echo e($user->name); ?></strong></div>
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

            <form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Họ và tên</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Địa chỉ Email</strong> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Số điện thoại</strong></label>
                        <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $user->phone)); ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Mật khẩu mới</strong></label>
                        <input type="password" name="password" class="form-control" placeholder="Để trống nếu không muốn đổi mật khẩu">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Trạng thái tài khoản</strong> <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" <?php echo e($user->hasRole('super_admin') ? 'disabled' : ''); ?>>
                            <option value="1" <?php echo e(old('status', $user->status) == 1 ? 'selected' : ''); ?>>Hoạt động bình thường</option>
                            <option value="0" <?php echo e(old('status', $user->status) == 0 ? 'selected' : ''); ?>>Khóa tài khoản</option>
                        </select>
                        <?php if($user->hasRole('super_admin')): ?>
                            <input type="hidden" name="status" value="1">
                            <small class="text-muted">Tài khoản Super Admin không thể bị khóa.</small>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label><strong>Phân bổ Vai trò (Roles)</strong> <span class="text-danger">*</span></label>
                    <p class="text-muted" style="margin-bottom: 10px;">Đánh dấu vào vai trò bạn muốn gán cho tài khoản này.</p>

                    <div class="row">
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isChecked = in_array($role->id, old('roles', $userRoles));
                                $isSuperAdminRoleOnSuperUser = $role->name === 'super_admin' && ($user->hasRole('super_admin') || $user->email === 'superadmin@customtee.vn');
                            ?>
                            <div class="col-md-6" style="margin-bottom: 10px;">
                                <div class="checkbox" style="background: #f9f9f9; padding: 10px 15px; border: 1px solid #e3e3e3; border-radius: 4px;">
                                    <label style="cursor: pointer; font-weight: bold;">
                                        <?php if($isSuperAdminRoleOnSuperUser): ?>
                                            <input type="checkbox" name="roles[]" value="<?php echo e($role->id); ?>" checked onclick="return false;">
                                            <?php echo e($role->display_name); ?> (<code><?php echo e($role->name); ?></code>)
                                            <span class="label label-danger">Khóa bảo vệ</span>
                                        <?php else: ?>
                                            <input type="checkbox" name="roles[]" value="<?php echo e($role->id); ?>" <?php echo e($isChecked ? 'checked' : ''); ?>>
                                            <?php echo e($role->display_name); ?> (<code><?php echo e($role->name); ?></code>)
                                        <?php endif; ?>
                                        <small class="text-muted" style="display: block; font-weight: normal; margin-top: 4px;">
                                            <?php echo e($role->description); ?>

                                        </small>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Cập nhật thông tin & vai trò
                    </button>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\admin\users\edit.blade.php ENDPATH**/ ?>