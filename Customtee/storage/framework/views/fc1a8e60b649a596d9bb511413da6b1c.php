<?php $__env->startSection('AdminContent'); ?>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Danh sách liên hệ từ khách hàng
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người gửi</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th style="width:100px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($contacts) && $contacts->count() > 0): ?>
                        <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <strong><?php echo e($item->user_name ?? 'Khách vãng lai'); ?></strong><br>
                                <small><?php echo e($item->user_email ?? ''); ?></small>
                            </td>
                            <td><?php echo e($item->tieu_de); ?></td>
                            <td><?php echo e(\Illuminate\Support\Str::limit($item->noi_dung, 50)); ?></td>
                            <td><?php echo e(date('d/m/Y H:i', strtotime($item->created_at))); ?></td>
                            <td>
                                
                                <?php if($item->trang_thai == 'da_xu_ly'): ?>
                                    <span class="label label-success">Đã xác nhận</span>
                                <?php else: ?>
                                    <span class="label label-danger">Chờ xử lý</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <form action="<?php echo e(route('admin.lien-he.updateStatus', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        
                                        <button type="submit" class="btn btn-sm <?php echo e($item->trang_thai == 'da_xu_ly' ? 'btn-warning' : 'btn-primary'); ?>">
                                            <i class="fa <?php echo e($item->trang_thai == 'da_xu_ly' ? 'fa-refresh' : 'fa-check'); ?>"></i>
                                        </button>
                                    </form>

                                    <form action="<?php echo e(route('admin.lien-he.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Xóa liên hệ này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Chưa có liên hệ nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($contacts)): ?>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <?php echo e($contacts->links()); ?>

                </div>
            </div>
        </footer>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\admin\contact\index.blade.php ENDPATH**/ ?>