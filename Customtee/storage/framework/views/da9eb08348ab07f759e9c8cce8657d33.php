<div class="modal fade" id="modalYeuCauHoanTra" tabindex="-1" aria-labelledby="modalYeuCauHoanTraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle bg-amber-100 text-amber-800 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-arrow-counterclockwise fs-5"></i>
                    </span>
                    <div>
                        <h5 class="modal-title fw-bold fs-5 text-slate-900" id="modalYeuCauHoanTraLabel">
                            Yêu cầu Trả hàng / Hoàn tiền
                        </h5>
                        <div class="fs-8 text-muted">Đơn hàng #<?php echo e($donHang->ma_don_hang); ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?php echo e(route('order.return.request', $donHang->id)); ?>" method="POST"
                enctype="multipart/form-data" id="formYeuCauHoanTra">
                <?php echo csrf_field(); ?>

                <div class="modal-body px-4 py-3">
                    <?php
                        $isOnlineCancelRefund = $donHang->phuong_thuc_thanh_toan === 'vnpay'
                            && $donHang->trang_thai === 'da_huy'
                            && $donHang->trang_thai_thanh_toan === 'da_thanh_toan';
                        $isDeliveredReturn = $donHang->trang_thai === 'da_giao' && !empty($donHang->da_nhan_hang_at);
                        $requiresFullReturn = $isOnlineCancelRefund || $isDeliveredReturn;
                    ?>

                    <?php if($isOnlineCancelRefund): ?>
                        <div class="p-3 rounded-3 bg-sky-50 border border-sky-200 text-sky-900 fs-8 mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Đơn hàng chưa giao:</strong> Hệ thống sẽ hoàn trả toàn bộ số tiền bạn đã thanh toán qua VNPay (bao gồm cả phí ship nếu có).
                        </div>
                    <?php elseif($isDeliveredReturn): ?>
                        <div class="p-3 rounded-3 bg-amber-50 border border-amber-200 text-amber-900 fs-8 mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Đơn hàng đã nhận:</strong> Số tiền hoàn dựa trên giá trị hàng hóa thực tế đã thanh toán (không hoàn lại phí vận chuyển theo chính sách).
                        </div>
                    <?php endif; ?>

                    <?php if(!$requiresFullReturn): ?>
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-8 text-slate-800 mb-2">
                                Chọn sản phẩm & số lượng muốn hoàn trả <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex flex-column gap-2">
                                <?php $__currentLoopData = $donHang->chiTietDonHangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chiTiet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="p-3 rounded-3 border border-slate-200 bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?php echo e($chiTiet->sanPham->hinh_anh_chinh ? asset('storage/' . $chiTiet->sanPham->hinh_anh_chinh) : 'https://via.placeholder.com/56'); ?>"
                                                alt="" class="rounded-3 border border-slate-200 object-fit-cover" width="56" height="56">
                                            <div>
                                                <div class="fw-bold text-slate-900 fs-8"><?php echo e($chiTiet->sanPham->ten_san_pham); ?></div>
                                                <?php if($chiTiet->bienThe): ?>
                                                    <div class="fs-8 text-muted">
                                                        Phân loại: <?php echo e($chiTiet->bienThe->color->ten_mau ?? '—'); ?> / <?php echo e($chiTiet->bienThe->size->ten_kich_thuoc ?? '—'); ?>

                                                    </div>
                                                <?php endif; ?>
                                                <div class="fs-8 text-slate-500 mt-0.5">
                                                    Đã mua: <strong><?php echo e($chiTiet->so_luong); ?></strong> × <?php echo e(number_format($chiTiet->don_gia, 0, ',', '.')); ?> ₫
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chi_tiet_ids[]"
                                                    value="<?php echo e($chiTiet->id); ?>" id="chiTiet<?php echo e($chiTiet->id); ?>"
                                                    data-max="<?php echo e($chiTiet->so_luong); ?>">
                                                <label class="form-check-label fs-8 fw-medium" for="chiTiet<?php echo e($chiTiet->id); ?>">Chọn trả</label>
                                            </div>
                                            <div class="input-group input-group-sm" style="width: 110px;">
                                                <span class="input-group-text bg-slate-50 fs-8">SL</span>
                                                <input type="number" name="so_luong[<?php echo e($chiTiet->id); ?>]"
                                                    class="form-control so-luong-input text-center fs-8" min="1"
                                                    max="<?php echo e($chiTiet->so_luong); ?>" value="1" disabled>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php elseif($isDeliveredReturn): ?>
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-8 text-slate-800 mb-2">Sản phẩm hoàn trả toàn bộ</label>
                            <div class="d-flex flex-column gap-2">
                                <?php $__currentLoopData = $donHang->chiTietDonHangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chiTiet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="p-2-5 rounded-3 border border-slate-200 bg-slate-50 d-flex align-items-center justify-content-between gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?php echo e($chiTiet->sanPham->hinh_anh_chinh ? asset('storage/' . $chiTiet->sanPham->hinh_anh_chinh) : 'https://via.placeholder.com/48'); ?>"
                                                alt="" class="rounded-2 border border-slate-200 object-fit-cover" width="48" height="48">
                                            <div>
                                                <div class="fw-bold text-slate-900 fs-8"><?php echo e($chiTiet->sanPham->ten_san_pham); ?></div>
                                                <?php if($chiTiet->bienThe): ?>
                                                    <div class="fs-8 text-muted">
                                                        <?php echo e($chiTiet->bienThe->color->ten_mau ?? '—'); ?> / <?php echo e($chiTiet->bienThe->size->ten_kich_thuoc ?? '—'); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="fs-8 text-muted">
                                            Số lượng: <strong class="text-slate-800"><?php echo e($chiTiet->so_luong); ?></strong>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($isOnlineCancelRefund): ?>
                        <input type="hidden" name="ly_do" value="<?php echo e(old('ly_do', $donHang->ly_do_yeu_cau_huy ?? '')); ?>">
                    <?php else: ?>
                        <div class="mb-4">
                            <label for="ly_do" class="form-label fw-bold fs-8 text-slate-800 mb-1">
                                Lý do khiếu nại / hoàn tiền <span class="text-danger">*</span>
                            </label>
                            <textarea name="ly_do" id="ly_do" class="form-control rounded-3 fs-8" rows="3" required
                                placeholder="Vui lòng mô tả chi tiết lý do (sản phẩm lỗi, rách chỉ, không đúng size/màu, sai mô tả...)"><?php echo e(old('ly_do')); ?></textarea>
                            <?php if(isset($errors) && $errors->has('ly_do')): ?>
                                <div class="text-danger small mt-1"><?php echo e($errors->first('ly_do')); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(!$isOnlineCancelRefund): ?>
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-8 text-slate-800 mb-1">Hình ảnh minh chứng thực tế</label>
                            <input type="file" name="hinh_anh[]" id="hinhAnhInput" class="form-control rounded-3 fs-8" accept="image/*" multiple>
                            <small class="text-muted fs-8 d-block mt-1">Định dạng JPG, PNG. Chụp rõ tem mác hoặc vị trí bị lỗi (tối đa 5 ảnh).</small>
                            <div id="previewContainer" class="mt-2 row g-2"></div>
                            <?php if(isset($errors) && $errors->has('hinh_anh.*')): ?>
                                <div class="text-danger small mt-1"><?php echo e($errors->first('hinh_anh.*')); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-8 text-slate-800 mb-2">Thông tin tài khoản nhận tiền hoàn</label>

                        <div class="btn-group w-100 mb-3" role="group">
                            <input type="radio" class="btn-check" name="refund_method" id="method_upload" value="upload" checked>
                            <label class="btn btn-outline-dark fs-8 py-2 fw-medium" for="method_upload">
                                <i class="bi bi-qr-code-scan me-1"></i> Tải ảnh mã QR / Thông tin TK
                            </label>

                            <input type="radio" class="btn-check" name="refund_method" id="method_manual" value="manual">
                            <label class="btn btn-outline-dark fs-8 py-2 fw-medium" for="method_manual">
                                <i class="bi bi-pencil-square me-1"></i> Nhập số tài khoản ngân hàng
                            </label>
                        </div>

                        <div id="upload_section">
                            <label class="form-label fw-semibold fs-8 text-slate-700 mb-1">Tải ảnh QR hoặc thông tin ngân hàng</label>
                            <input type="file" name="hinh_tai_khoan[]" id="hinhTaiKhoanInput" class="form-control rounded-3 fs-8"
                                accept="image/*" multiple>
                            <small class="text-muted fs-8 d-block mt-1">
                                Chụp màn hình mã QR nhận tiền hoặc thông tin tài khoản ngân hàng của bạn.
                            </small>
                            <div id="previewTaiKhoanContainer" class="mt-2 row g-2"></div>
                            <?php if(isset($errors) && $errors->has('hinh_tai_khoan.*')): ?>
                                <div class="text-danger small mt-1"><?php echo e($errors->first('hinh_tai_khoan.*')); ?></div>
                            <?php endif; ?>
                        </div>

                        <div id="manual_section" class="d-none">
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-8 text-slate-700 mb-1">Tên ngân hàng <span class="text-danger">*</span></label>
                                    <input type="text" name="ngan_hang" class="form-control rounded-3 fs-8"
                                        placeholder="Ví dụ: MB Bank, Vietcombank, Techcombank...">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-8 text-slate-700 mb-1">Số tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="so_tai_khoan" class="form-control rounded-3 fs-8"
                                        placeholder="Nhập số tài khoản nhận tiền">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-8 text-slate-700 mb-1">Tên chủ tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="ten_chu_tk" class="form-control rounded-3 fs-8"
                                        placeholder="Họ và tên (chữ hoa không dấu)">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-8 text-slate-700 mb-1">Chi nhánh (không bắt buộc)</label>
                                    <input type="text" name="chi_nhanh" class="form-control rounded-3 fs-8"
                                        placeholder="Ví dụ: Hà Nội, TP.HCM...">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 fs-8 fw-medium" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fs-8 fw-semibold" id="btnSubmitHoanTra">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Gửi yêu cầu hoàn tiền
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\client\Order\components\refund-request-modal.blade.php ENDPATH**/ ?>