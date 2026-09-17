<?php $__env->startSection('AdminContent'); ?>
<div class="form-w3layouts">
    <section class="panel">
        <header class="panel-heading">CHỈNH SỬA VOUCHER</header>
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
            <form action="<?php echo e(route('admin.vouchers.update', $voucher->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="form-group">
                    <label>Mã Voucher</label>
                    <input type="text" name="ma" class="form-control" value="<?php echo e(old('ma', $voucher->ma)); ?>" maxlength="50" required>
                    <?php $__errorArgs = ['ma'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Loại</label>
                        <select name="loai" id="voucher-loai" class="form-control">
                            <option value="tien_mat" <?php echo e(old('loai', $voucher->loai) == 'tien_mat' ? 'selected' : ''); ?>>Tiền mặt (đ)</option>
                            <option value="phan_tram" <?php echo e(old('loai', $voucher->loai) == 'phan_tram' ? 'selected' : ''); ?>>Phần trăm (%)</option>
                        </select>
                        <?php $__errorArgs = ['loai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Giá trị giảm</label>
                        <input type="number" name="gia_tri" class="form-control" min="1" max="999999999999" value="<?php echo e(old('gia_tri', (int) $voucher->gia_tri)); ?>" required>
                        <?php $__errorArgs = ['gia_tri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Đơn hàng tối thiểu (đ)</label>
                        <input type="number" name="don_hang_toi_thieu" class="form-control" min="0" max="999999999999" value="<?php echo e(old('don_hang_toi_thieu', $voucher->don_hang_toi_thieu)); ?>" placeholder="VD: 100000 – đơn từ 100k mới áp dụng">
                        <?php $__errorArgs = ['don_hang_toi_thieu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 form-group" id="giam-toi-da-wrap" style="display: <?php echo e($voucher->loai == 'phan_tram' ? 'block' : 'none'); ?>;">
                        <label>Giảm tối đa (đ)</label>
                        <input type="number" name="giam_toi_da" class="form-control" min="0" max="999999999999" value="<?php echo e(old('giam_toi_da', $voucher->giam_toi_da)); ?>" placeholder="VD: 50000">
                        <small class="text-muted">Chỉ áp dụng cho loại Giảm theo % (VD: giảm 10%, tối đa 50.000đ).</small>
                        <?php $__errorArgs = ['giam_toi_da'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Ngày bắt đầu</label>
                        <input type="datetime-local" name="bat_dau" class="form-control" value="<?php echo e(old('bat_dau', date('Y-m-d\TH:i', strtotime($voucher->bat_dau)))); ?>" required>
                        <?php $__errorArgs = ['bat_dau'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Ngày kết thúc</label>
                        <input type="datetime-local" name="ket_thuc" class="form-control" value="<?php echo e(old('ket_thuc', date('Y-m-d\TH:i', strtotime($voucher->ket_thuc)))); ?>" required>
                        <?php $__errorArgs = ['ket_thuc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Số lượng</label>
                    <input type="number" name="so_luong" class="form-control" min="1" max="2147483647" value="<?php echo e(old('so_luong', $voucher->so_luong)); ?>" required>
                    <small class="text-muted">Số lượng không được nhỏ hơn số lượt đã dùng hiện tại (<?php echo e($voucher->da_su_dung); ?>).</small>
                    <?php $__errorArgs = ['so_luong'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label>Giới hạn mỗi khách (lần)</label>
                    <input
                        type="number"
                        name="max_per_user"
                        class="form-control"
                        min="1"
                        max="255"
                        value="<?php echo e(old('max_per_user', $voucher->max_per_user)); ?>"
                        placeholder="VD: 2"
                    >
                    <?php $__errorArgs = ['max_per_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <button type="submit" class="btn btn-info">Cập nhật thay đổi</button>
                <a href="<?php echo e(route('admin.vouchers.index')); ?>" class="btn btn-default">Quay lại</a>
            </form>
        </div>
    </section>
</div>
<script>
(function() {
    var loai = document.getElementById('voucher-loai');
    var wrap = document.getElementById('giam-toi-da-wrap');
    function toggle() {
        wrap.style.display = loai.value === 'phan_tram' ? 'block' : 'none';
    }
    loai.addEventListener('change', toggle);
    toggle();
})();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\admin\vouchers\edit.blade.php ENDPATH**/ ?>