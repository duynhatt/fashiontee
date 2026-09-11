<!-- ==============================================
     MODERN LUXURY FOOTER - FASHIONTEE
     ============================================== -->
<footer class="modern-footer text-light pt-5" id="fashiontee_footer">

    <!-- 1. VALUE PROPS / SERVICE REASSURANCE BAR -->
    <div class="footer-perks-section pb-5 mb-4 border-bottom border-secondary-subtle border-opacity-10">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4 footer-perk-card h-100">
                        <div class="footer-perk-icon-wrap rounded-circle d-flex align-items-center justify-content-center text-success flex-shrink-0">
                            <i class="bi bi-truck fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-1 fs-7">Giao hàng toàn quốc</h6>
                            <p class="text-muted fs-8 mb-0">Miễn phí cho đơn từ 300K</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4 footer-perk-card h-100">
                        <div class="footer-perk-icon-wrap rounded-circle d-flex align-items-center justify-content-center text-primary flex-shrink-0">
                            <i class="bi bi-arrow-repeat fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-1 fs-7">Đổi hàng trong 3 ngày</h6>
                            <p class="text-muted fs-8 mb-0">Hỗ trợ đổi size tận nơi</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4 footer-perk-card h-100">
                        <div class="footer-perk-icon-wrap rounded-circle d-flex align-items-center justify-content-center text-warning flex-shrink-0">
                            <i class="bi bi-patch-check fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-1 fs-7">Chất lượng cam kết</h6>
                            <p class="text-muted fs-8 mb-0">Cotton 100% & in bền màu</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4 footer-perk-card h-100">
                        <div class="footer-perk-icon-wrap rounded-circle d-flex align-items-center justify-content-center text-danger flex-shrink-0">
                            <i class="bi bi-headset fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-1 fs-7">Hỗ trợ chu đáo</h6>
                            <p class="text-muted fs-8 mb-0">Hotline & Zalo 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. MAIN FOOTER CONTENT COLUMNS -->
    <div class="container pb-5">
        <div class="row g-4 g-lg-5">

            <!-- Column 1: Brand Info & Contacts -->
            <div class="col-12 col-lg-4">
                <div class="footer-brand-block mb-3">
                    <a href="<?php echo e(url('/')); ?>" class="text-decoration-none d-inline-flex align-items-center gap-1 mb-3">
                        <span class="fw-bold fs-3 text-white tracking-tight">Fashion<span class="text-success">Tee</span></span>
                    </a>
                    <p class="footer-text-muted fs-7 lh-lg mb-4">
                        Thương hiệu thời trang Unisex & Áo thun in theo yêu cầu tiên phong. Tự hào mang đến phong cách trẻ trung, chất liệu thoáng mát và trải nghiệm mua sắm hiện đại nhất.
                    </p>

                    <div class="d-flex flex-column gap-2 mb-4 fs-7">
                        <div class="d-flex align-items-start gap-2-5">
                            <i class="bi bi-geo-alt text-success mt-0-5 fs-6"></i>
                            <span class="footer-text-muted">Hà Nội, Việt Nam</span>
                        </div>
                        <div class="d-flex align-items-center gap-2-5">
                            <i class="bi bi-telephone text-success fs-6"></i>
                            <a href="tel:19008888" class="footer-link text-white fw-semibold">1900 8888</a>
                            <span class="footer-text-muted fs-8">(08:30 - 22:00)</span>
                        </div>
                        <div class="d-flex align-items-center gap-2-5">
                            <i class="bi bi-envelope text-success fs-6"></i>
                            <a href="mailto:support@fashiontee.vn" class="footer-link footer-text-muted">support@fashiontee.vn</a>
                        </div>
                    </div>

                    <!-- Social Channels -->
                    <div class="d-flex align-items-center gap-2">
                        <a href="https://facebook.com/" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://instagram.com/" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://tiktok.com/" target="_blank" rel="noopener" class="footer-social-btn" aria-label="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="https://youtube.com/" target="_blank" rel="noopener" class="footer-social-btn" aria-label="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2: Products & Collections -->
            <div class="col-6 col-md-4 col-lg-2">
                <h6 class="footer-column-title text-white text-uppercase fw-bold fs-7 mb-3 tracking-wider">
                    Sản phẩm
                </h6>
                <ul class="list-unstyled footer-link-list mb-0 fs-7 d-flex flex-column gap-2-5">
                    <li><a href="<?php echo e(url('/Shop')); ?>" class="footer-link">Tất cả sản phẩm</a></li>
                    <?php
                        $footerCategories = \App\Models\Category::hienThi()->take(5)->get();
                    ?>
                    <?php $__currentLoopData = $footerCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(url('/Shop?danh_muc[]=' . $cat->id)); ?>" class="footer-link">
                                <?php echo e($cat->ten_danh_muc); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(url('/Shop?sort=best_seller')); ?>" class="footer-link">Sản phẩm bán chạy</a></li>
                </ul>
            </div>

            <!-- Column 3: Customer Support -->
            <div class="col-6 col-md-4 col-lg-2">
                <h6 class="footer-column-title text-white text-uppercase fw-bold fs-7 mb-3 tracking-wider">
                    Chăm sóc KH
                </h6>
                <ul class="list-unstyled footer-link-list mb-0 fs-7 d-flex flex-column gap-2-5">
                    <li><a href="<?php echo e(url('/Shop')); ?>" class="footer-link">Hướng dẫn chọn size</a></li>
                    <li><a href="<?php echo e(url('/Contact')); ?>" class="footer-link">Chính sách đổi trả</a></li>
                    <li><a href="<?php echo e(url('/Contact')); ?>" class="footer-link">Chính sách vận chuyển</a></li>
                    <li><a href="<?php echo e(url('/Contact')); ?>" class="footer-link">Chính sách bảo mật</a></li>
                    <?php if(auth()->guard()->check()): ?>
                        <li><a href="<?php echo e(route('order')); ?>" class="footer-link text-success fw-medium">Đơn hàng của tôi</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo e(url('/login')); ?>" class="footer-link">Đăng nhập / Đăng ký</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo e(url('/Contact')); ?>" class="footer-link">Liên hệ & Góp ý</a></li>
                </ul>
            </div>

            <!-- Column 4: Newsletter & Payment Partners -->
            <div class="col-12 col-md-4 col-lg-4">
                <div class="p-3-5 p-md-4 rounded-4 footer-newsletter-box border border-secondary-subtle border-opacity-15">
                    <h6 class="footer-column-title text-white text-uppercase fw-bold fs-7 mb-2 tracking-wider d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-paper-heart text-success"></i>
                        <span>Đăng ký nhận ưu đãi</span>
                    </h6>
                    <p class="footer-text-muted fs-8 lh-base mb-3">
                        Đăng ký email để nhận ngay mã giảm giá <strong>10%</strong> cho đơn hàng đầu tiên và thông tin bộ sưu tập mới nhất.
                    </p>

                    <form onsubmit="event.preventDefault(); window.showClientToast ? window.showClientToast('Cảm ơn bạn đã đăng ký nhận tin!', 'success') : alert('Đăng ký thành công!'); this.reset();" class="mb-4">
                        <div class="input-group footer-subscribe-group">
                            <input type="email" class="form-control rounded-start-pill ps-3 fs-8 footer-subscribe-input"
                                   placeholder="Nhập địa chỉ email của bạn..." required aria-label="Email nhận tin">
                            <button class="btn btn-success rounded-end-pill px-3 fs-8 fw-semibold d-inline-flex align-items-center gap-1 shadow-none" type="submit">
                                <span>Đăng ký</span>
                                <i class="bi bi-arrow-right-short fs-6"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Payment Badges -->
                    <div>
                        <span class="text-uppercase footer-text-muted fs-9 fw-semibold tracking-wider d-block mb-2">
                            Phương thức thanh toán
                        </span>
                        <div class="d-flex flex-wrap align-items-center gap-1-5">
                            <span class="badge footer-pay-badge"><i class="bi bi-cash-stack me-1"></i>COD</span>
                            <span class="badge footer-pay-badge"><i class="bi bi-qr-code me-1"></i>VNPAY</span>
                            <span class="badge footer-pay-badge"><i class="bi bi-wallet2 me-1"></i>MoMo</span>
                            <span class="badge footer-pay-badge"><i class="bi bi-credit-card me-1"></i>Visa / Master</span>
                            <span class="badge footer-pay-badge"><i class="bi bi-bank me-1"></i>Banking</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 3. BOTTOM COPYRIGHT & LEGAL BAR -->
    <div class="footer-bottom-bar py-3 border-top border-secondary-subtle border-opacity-10">
        <div class="container">
            <div class="row align-items-center g-2 text-center text-md-start">
                <div class="col-12 col-md-6">
                    <p class="footer-text-muted small mb-0">
                        &copy; <?php echo e(date('Y')); ?> <strong class="text-white">FashionTee</strong>. Bản quyền thuộc về FashionTee Studio.
                    </p>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <div class="d-inline-flex flex-wrap justify-content-center justify-content-md-end gap-3 small footer-text-muted">
                        <a href="<?php echo e(url('/Contact')); ?>" class="footer-legal-link">Điều khoản</a>
                        <a href="<?php echo e(url('/Contact')); ?>" class="footer-legal-link">Bảo mật</a>
                        <a href="<?php echo e(url('/Contact')); ?>" class="footer-legal-link">Hợp tác kinh doanh</a>
                        <span class="text-secondary-emphasis d-none d-sm-inline">• Thiết kế tại Việt Nam 🇻🇳</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>

<!-- FOOTER MODERN STYLES -->
<style>
    .modern-footer {
        background: #0b0f19;
        color: #94a3b8;
        font-family: inherit;
        position: relative;
        overflow: hidden;
    }

    .footer-text-muted {
        color: #94a3b8 !important;
    }

    .footer-perk-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.07);
        transition: all 0.25s ease;
    }

    .footer-perk-card:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.14);
        transform: translateY(-2px);
    }

    .footer-perk-icon-wrap {
        width: 46px;
        height: 46px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .footer-link {
        color: #94a3b8 !important;
        text-decoration: none !important;
        display: inline-block;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .footer-link:hover {
        color: #ffffff !important;
        transform: translateX(4px);
    }

    .footer-social-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        text-decoration: none !important;
        transition: all 0.25s ease;
    }

    .footer-social-btn:hover {
        background: #198754;
        border-color: #198754;
        color: #ffffff !important;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.35);
    }

    .footer-newsletter-box {
        background: rgba(255, 255, 255, 0.025);
    }

    .footer-subscribe-group .footer-subscribe-input {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }

    .footer-subscribe-group .footer-subscribe-input::placeholder {
        color: #64748b;
    }

    .footer-subscribe-group .footer-subscribe-input:focus {
        background: rgba(255, 255, 255, 0.09);
        border-color: #198754;
        color: #ffffff;
        box-shadow: none;
    }

    .footer-pay-badge {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #cbd5e1;
        font-weight: 500;
        font-size: 0.72rem;
        padding: 5px 9px;
        border-radius: 6px;
    }

    .footer-legal-link {
        color: #64748b !important;
        text-decoration: none !important;
        transition: color 0.2s ease;
    }

    .footer-legal-link:hover {
        color: #94a3b8 !important;
        text-decoration: underline !important;
    }

    .footer-bottom-bar {
        background: #070a10;
    }

    .gap-2-5 {
        gap: 0.65rem !important;
    }

    .fs-9 {
        font-size: 0.7rem !important;
    }
</style>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/client/layout/footer.blade.php ENDPATH**/ ?>