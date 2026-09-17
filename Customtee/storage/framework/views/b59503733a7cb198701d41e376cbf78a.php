<?php $__env->startSection('AdminContent'); ?>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            DANH SÁCH MÃ GIẢM GIÁ (VOUCHERS)
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <a href="<?php echo e(route('admin.vouchers.create')); ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Thêm Voucher mới
                </a>
            </div>
            <div class="col-sm-7 text-right">
                <form action="<?php echo e(route('admin.vouchers.index')); ?>" method="GET" class="form-inline" style="display:inline-flex; gap:6px; align-items:center;">
                    <input
                        type="text"
                        name="q"
                        value="<?php echo e($keyword ?? request('q')); ?>"
                        class="form-control input-sm"
                        placeholder="Tìm mã voucher..."
                    >
                    <button type="submit" class="btn btn-sm btn-default">
                        <i class="fa fa-search"></i> Lọc
                    </button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Loại giảm</th>
                        <th>Giá trị</th>
                        <th>Số lượng</th>
                        <th>Đã dùng</th>
                        <th>Hạn dùng</th>
                        <th style="width:150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><b class="text-primary"><?php echo e($v->ma); ?></b></td>
                            <td><?php echo e($v->loai == 'tien_mat' ? 'Tiền mặt' : 'Phần trăm'); ?></td>
                            <td>
                                <?php echo e(number_format($v->gia_tri)); ?><?php echo e($v->loai == 'phan_tram' ? '%' : 'đ'); ?>

                            </td>
                            <td><?php echo e($v->so_luong); ?></td>
                            <td><?php echo e($v->da_su_dung); ?></td>
                            <td>
                                <small>
                                    Từ: <?php echo e(date('d/m/Y', strtotime($v->bat_dau))); ?><br>
                                    Đến: <?php echo e(date('d/m/Y', strtotime($v->ket_thuc))); ?>

                                </small>
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="<?php echo e(route('admin.vouchers.edit', $v->id)); ?>" class="btn btn-xs btn-warning" title="Sửa">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>

                                    <form action="<?php echo e(route('admin.vouchers.destroy', $v->id)); ?>" method="POST" style="margin:0;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mã <?php echo e($v->ma); ?> này không?')" title="Xóa">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Không có voucher phù hợp bộ lọc.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <?php echo e($vouchers->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\admin\vouchers\index.blade.php ENDPATH**/ ?>