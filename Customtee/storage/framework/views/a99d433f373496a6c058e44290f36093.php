<?php $__env->startSection('AdminContent'); ?>

<div class="container">

    <h2 class="mb-4">Danh sách bình luận</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Sản phẩm</th>
                <th>Biến thể</th>
                <th>Nội dung</th>
                <th>Số sao</th>
                <th>Trạng thái</th>
                <th>Trang chủ</th>
                <th>Ngày</th>
                <th width="260">Hành động</th>
            </tr>
        </thead>

        <tbody>

        <?php $__currentLoopData = $binhLuans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>
                <td><?php echo e($bl->id); ?></td>

                <td><?php echo e($bl->user->name ?? 'N/A'); ?></td>

                <td><?php echo e($bl->sanPham->ten_san_pham ?? 'N/A'); ?></td>

                <td>
                    <?php if($bl->bienThe): ?>
                        <?php if($bl->bienThe->color): ?>
                            <span class="d-inline-flex align-items-center gap-1">
                                <span class="border rounded" style="width:16px;height:16px;background-color:<?php echo e($bl->bienThe->color->ma_mau ?? '#ccc'); ?>;"></span>
                                <?php echo e($bl->bienThe->color->ten_mau ?? '—'); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($bl->bienThe->size): ?>
                            <span class="ms-2 text-muted">/ <?php echo e($bl->bienThe->size->ten_kich_thuoc ?? '—'); ?></span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>

                <td><?php echo e($bl->noi_dung); ?></td>

                <td>
                    <?php for($i=1; $i<=5; $i++): ?>
                        <?php if($i <= $bl->so_sao): ?>
                            ⭐
                        <?php else: ?>
                            ☆
                        <?php endif; ?>
                    <?php endfor; ?>
                </td>

                <td>
                    <?php if($bl->trang_thai): ?>
                        <span class="badge bg-success">Hiển thị</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Ẩn</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if($bl->hien_thi_trang_chu): ?>
                        <span class="badge bg-primary">Hiển thị trang chủ</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Không hiển thị</span>
                    <?php endif; ?>
                </td>

                <td><?php echo e($bl->created_at->format('d/m/Y')); ?></td>

                <td>
                    <a href="<?php echo e(route('admin.binh-luan.toggle',$bl->id)); ?>"
                       class="btn btn-warning btn-sm mb-1">
                        Ẩn/Hiện
                    </a>
                    <a href="<?php echo e(route('admin.binh-luan.toggle-home',$bl->id)); ?>"
                       class="btn btn-info btn-sm mb-1 <?php echo e(!$bl->trang_thai ? 'disabled' : ''); ?>"
                       <?php if(!$bl->trang_thai): ?> aria-disabled="true" <?php endif; ?>>
                        Hiển thị trang chủ
                    </a>
                </td>
            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>

    </table>

    
    <?php echo e($binhLuans->links()); ?>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\admin\binh-luan\index.blade.php ENDPATH**/ ?>