<?php echo $__env->make('client.layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container py-5 text-center">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 600px;">
        <div class="card-body p-5">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            <h2 class="mt-4 fw-bold text-success">Đặt hàng thành công!</h2>
            <p class="lead mt-3">Cảm ơn bạn đã đặt hàng tại Customtee.</p>

            <div class="mt-4">
                <h5>Mã đơn hàng: <strong><?php echo e($donHang->ma_don_hang); ?></strong></h5>
                <p class="text-muted">Tổng tiền: <strong class="text-primary"><?php echo e(number_format($donHang->tong_tien)); ?>

                        ₫</strong></p>
                <p class="text-muted">Phương thức:
                    <?php echo e($donHang->phuong_thuc_thanh_toan === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'VNPAY'); ?>

                </p>
                <p class="text-muted">Trạng thái:
                    <span
                        class="badge 
        <?php echo e($donHang->trang_thai === 'cho_xac_nhan' ? 'bg-warning' : 'bg-info'); ?>">
                        <?php echo e($donHang->trang_thai === 'cho_xac_nhan' ? 'Chờ xác nhận' : 'Đang xử lý'); ?>

                    </span>
                </p>
            </div>

            <p class="mt-4">Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>

            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary btn-lg mt-3">Quay về trang chủ</a>
            <a href="<?php echo e(route('order')); ?>" class="btn btn-outline-primary mt-3">Xem đơn hàng của tôi</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(session('success')): ?>
            const successPopup = new bootstrap.Modal(document.getElementById('successPopup'), {
                backdrop: 'static',
                keyboard: true
            });
            successPopup.show();
        <?php endif; ?>
    });
</script>

<?php echo $__env->make('client.layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\client\Checkout\success.blade.php ENDPATH**/ ?>