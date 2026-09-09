<?php $__env->startSection('AdminContent'); ?>
<div class="container-fluid" style="margin-bottom: 120px;">

    <div class="row mb-3">
        <div class="col">
            <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</h4>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="card shadow mb-3">
        <div class="card-body py-2">
            <div
                class="align-items-center"
                style="display:flex; justify-content:space-between; align-items:center; flex-wrap:nowrap; gap:8px;"
            >
                <form
                    method="get"
                    action="<?php echo e(route('admin.don-hang.index')); ?>"
                    class="form-inline"
                    style="display:flex; align-items:center; flex-wrap:nowrap; gap:8px;"
                >
                    <label class="mr-0 mb-0">Trạng thái:</label>
                    <select
                        name="trang_thai"
                        class="form-control form-control-sm"
                        style="min-width: 115px;"
                        onchange="this.form.submit()"
                    >
                        <option value="">Tất cả</option>
                        <?php $__currentLoopData = [
                            'cho_xac_nhan' => 'Chờ xác nhận',
                            'dang_xu_ly' => 'Đang xử lý',
                            'dang_yeu_cau_huy' => 'Yêu cầu hủy',
                            'dang_giao' => 'Đang giao',
                            'da_giao' => 'Đã giao',
                            'da_nhan_hang' => 'Đã nhận hàng',
                            'da_huy' => 'Đã hủy',
                            // Bộ lọc bổ sung
                            'da_hoan_thanh' => 'Đã hoàn thành',
                            'tra_hang' => 'Trả hàng',
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(request('trang_thai') === $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    
                    <input
                        type="text"
                        name="q"
                        class="form-control form-control-sm"
                        style="width: 145px;"
                        value="<?php echo e(request('q')); ?>"
                        placeholder="Mã/SĐT"
                    >
                    <button type="submit" class="btn btn-sm btn-primary px-3" title="Tìm kiếm">
                        <i class="fas fa-search"></i>
                    </button>

                    
                    <div class="dropdown" style="display:flex; align-items:center; width:auto; flex:0 0 auto; white-space:nowrap;">
                        <button
                            type="button"
                            class="btn btn-sm btn-primary dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            title="Lọc nâng cao"
                        >
                            <i class="fas fa-filter"></i>
                        </button>

                        <div
                            class="dropdown-menu p-3"
                            style="min-width: 420px; padding: 18px 22px; left: 50%; right: auto; transform: translateX(-50%);"
                        >
                            <div onclick="event.stopPropagation()">
                                <div class="form-group mb-2" style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                    <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:125px;">TT thanh toán</label>
                                    <select
                                        name="trang_thai_thanh_toan"
                                        class="form-control form-control-sm"
                                        style="flex:1;"
                                    >
                                        <option value="">Tất cả</option>
                                        <?php $__currentLoopData = [
                                            'da_thanh_toan' => 'Đã thanh toán',
                                            'that_bai' => 'Thất bại',
                                            'chua_thanh_toan' => 'Chưa thanh toán',
                                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>" <?php echo e(request('trang_thai_thanh_toan') === $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group mb-2" style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                    <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:125px;">PT thanh toán</label>
                                    <select
                                        name="phuong_thuc_thanh_toan"
                                        class="form-control form-control-sm"
                                        style="flex:1;"
                                    >
                                        <option value="">Tất cả</option>
                                        <?php $__currentLoopData = [
                                            'cod' => 'COD',
                                            'vnpay' => 'VNPAY',
                                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>" <?php echo e(request('phuong_thuc_thanh_toan') === $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group mb-2" style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                    <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:125px;">TT hoàn tiền</label>
                                    <select
                                        name="refund_trang_thai"
                                        class="form-control form-control-sm"
                                        style="flex:1;"
                                    >
                                        <option value="">Tất cả</option>
                                        <?php $__currentLoopData = [
                                            'cho_xu_ly' => 'Chờ xử lý',
                                            'da_chap_nhan' => 'Đã chấp nhận',
                                            'da_tu_choi' => 'Đã từ chối',
                                            'da_hoan_tien' => 'Đã hoàn tiền',
                                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>" <?php echo e(request('refund_trang_thai') === $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group mb-2" style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                    <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:125px;">Thời gian đặt đơn</label>
                                    <div style="display:flex; gap:10px; flex:1;">
                                        <input
                                            type="date"
                                            name="ngay_tu"
                                            class="form-control form-control-sm"
                                            style="flex:1; min-width:140px;"
                                            value="<?php echo e(request('ngay_tu')); ?>"
                                        >
                                        <input
                                            type="date"
                                            name="ngay_den"
                                            class="form-control form-control-sm"
                                            style="flex:1; min-width:140px;"
                                            value="<?php echo e(request('ngay_den')); ?>"
                                        >
                                    </div>
                                </div>

                                <div class="form-group mb-2" style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                    <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:125px;">Khoảng tiền (VND)</label>
                                    <div style="display:flex; gap:10px; flex:1;">
                                        <input
                                            type="number"
                                            name="tong_tien_min"
                                            class="form-control form-control-sm"
                                            min="0"
                                            step="1000"
                                            placeholder="Từ"
                                            style="flex:1; min-width:150px;"
                                            value="<?php echo e(request('tong_tien_min')); ?>"
                                        >
                                        <input
                                            type="number"
                                            name="tong_tien_max"
                                            class="form-control form-control-sm"
                                            min="0"
                                            step="1000"
                                            placeholder="Đến"
                                            style="flex:1; min-width:150px;"
                                            value="<?php echo e(request('tong_tien_max')); ?>"
                                        >
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
                                    <?php
                                        $resetParams = array_filter([
                                            'trang_thai' => request('trang_thai'),
                                            'q' => request('q'),
                                        ]);
                                        $resetUrl = route('admin.don-hang.index');
                                        if (!empty($resetParams)) {
                                            $resetUrl .= '?' . http_build_query($resetParams);
                                        }
                                    ?>
                                    <a
                                        href="<?php echo e($resetUrl); ?>"
                                        class="btn btn-sm btn-outline-secondary"
                                        title="Xóa lọc nâng cao"
                                    >
                                        Xóa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="text-muted small">
                    Tổng: <strong><?php echo e($donHangs->total()); ?></strong> đơn
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th width="4%">#</th>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>TT thanh toán</th>
                        <th>PT thanh toán</th>
                        <th>Trạng thái</th>
                        <th width="12%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
<?php $__empty_1 = true; $__currentLoopData = $donHangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $donHang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo e($donHangs->firstItem() + $index); ?></td>
                        <td class="align-middle">
                            <strong><?php echo e($donHang->ma_don_hang); ?></strong>
                            <br>
                            <small class="text-muted">
                                <i class="far fa-clock mr-1"></i><?php echo e($donHang->created_at->format('d/m/Y H:i')); ?>

                            </small>
                        </td>
                        <td class="align-middle">
                            <?php echo e($donHang->ten_nguoi_nhan ?? $donHang->nguoiDung->name ?? '—'); ?>

                            <?php if($donHang->nguoiDung): ?>
                                <br><small class="text-muted"><?php echo e($donHang->nguoiDung->email ?? ''); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-right align-middle"><?php echo e(number_format($donHang->tong_tien, 0, ',', '.')); ?> ₫</td>
                        <td class="text-center align-middle">
                            <?php
                                $paymentBadge = match ($donHang->trang_thai_thanh_toan) {
                                    'da_thanh_toan' => ['class' => 'success', 'text' => 'Đã thanh toán'],
                                    'that_bai' => ['class' => 'danger', 'text' => 'Thanh toán thất bại'],
                                    default => ['class' => 'warning', 'text' => 'Chưa thanh toán'],
                                };
                            ?>
                            <span class="badge badge-<?php echo e($paymentBadge['class']); ?>"><?php echo e($paymentBadge['text']); ?></span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-light border">
                                <?php echo e($donHang->phuong_thuc_thanh_toan === 'cod' ? 'COD' : strtoupper($donHang->phuong_thuc_thanh_toan)); ?>

                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <?php
                                $latestRefund = $donHang->refunds->first();
                                $refundBadgeMap = [
                                    'cho_xu_ly' => [
                                        'warning',
                                        $donHang->trang_thai === \App\Models\DonHang::TRANG_THAI_DA_GIAO
                                            ? 'Yêu cầu trả hàng hoàn tiền'
                                            : 'Yêu cầu hoàn tiền',
                                    ],
                                    'da_chap_nhan' => ['primary', 'Đã chấp nhận hoàn tiền'],
                                    'da_tu_choi' => ['danger', 'Đã từ chối hoàn tiền'],
                                    'da_hoan_tien' => ['info', 'Đã hoàn tiền'],
                                ];
                                $orderBadgeMap = [
                                    'cho_xac_nhan' => ['warning', \App\Models\DonHang::tenTrangThai('cho_xac_nhan')],
                                    'dang_xu_ly' => ['info', \App\Models\DonHang::tenTrangThai('dang_xu_ly')],
                                    'cho_duyet_huy' => ['warning', \App\Models\DonHang::tenTrangThai('cho_duyet_huy')],
                                    'dang_giao' => ['primary', \App\Models\DonHang::tenTrangThai('dang_giao')],
                                    'da_giao' => ['success', \App\Models\DonHang::tenTrangThai('da_giao')],
                                    'da_nhan_hang' => ['primary', 'Đã nhận hàng'],
                                    'da_hoan_thanh' => ['success', \App\Models\DonHang::tenTrangThai('da_hoan_thanh')],
                                    'da_huy' => ['danger', \App\Models\DonHang::tenTrangThai('da_huy')],
                                ];

                                $isPendingCancelRequest =
                                    (bool) $donHang->yeu_cau_huy
                                    && in_array($donHang->trang_thai, ['dang_xu_ly', 'cho_duyet_huy'], true);

                                $displayStatus = $orderBadgeMap[$donHang->trang_thai] ?? ['secondary', 'Không xác định'];
                                if ($isPendingCancelRequest) {
                                    $displayStatus = ['warning', 'Yêu cầu hủy'];
                                } elseif ($latestRefund && isset($refundBadgeMap[$latestRefund->trang_thai])) {
                                    $displayStatus = $refundBadgeMap[$latestRefund->trang_thai];
                                } elseif (
                                    $donHang->trang_thai === \App\Models\DonHang::TRANG_THAI_DA_GIAO
                                    && !empty($donHang->da_nhan_hang_at)
                                ) {
                                    $displayStatus = $orderBadgeMap['da_nhan_hang'];
                                }
                            ?>
                            <div>
                                <span class="badge badge-<?php echo e($displayStatus[0]); ?>">
                                    <?php echo e($displayStatus[1]); ?>

                                </span>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center flex-wrap gap-1">
                                <a href="<?php echo e(route('admin.don-hang.show', $donHang)); ?>" class="btn btn-sm btn-info" title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Chưa có đơn hàng nào.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if($donHangs->hasPages()): ?>
                <div class="d-flex justify-content-center mt-2">
                    <?php echo e($donHangs->links('pagination::bootstrap-4')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/don-hang/index.blade.php ENDPATH**/ ?>