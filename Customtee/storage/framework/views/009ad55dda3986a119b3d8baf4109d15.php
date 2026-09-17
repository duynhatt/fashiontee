<?php echo $__env->make('client.layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Google Fonts: Plus Jakarta Sans for Ultra-Modern High-Fashion Aesthetics -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- 0. ANNOUNCEMENT TICKER MARQUEE -->
<div class="fashion-marquee bg-dark text-white py-2 overflow-hidden position-relative border-bottom border-secondary border-opacity-25">
    <div class="fashion-marquee-inner d-flex align-items-center">
        <div class="fashion-marquee-content d-flex align-items-center gap-4 text-nowrap fs-8 fw-medium">
            <span><i class="bi bi-truck text-success me-1"></i> MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC CHO ĐƠN TỪ 299K</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-arrow-counterclockwise text-warning me-1"></i> ĐỔI TRẢ HÀNG TẬN NHÀ TRONG 3 NGÀY</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-tag-fill text-danger me-1"></i> TẶNG VOUCHER ĐẾN 50K CHO ĐƠN HÀNG MỚI</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-patch-check-fill text-info me-1"></i> 100% COTTON COMPACT CAO CẤP CHỐNG BAI XÙ</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-shield-check text-success me-1"></i> ĐỒNG KIỂM TRA HÀNG KHI THANH TOÁN</span>
            <span class="marquee-bullet">•</span>
        </div>
        <div class="fashion-marquee-content d-flex align-items-center gap-4 text-nowrap fs-8 fw-medium" aria-hidden="true">
            <span><i class="bi bi-truck text-success me-1"></i> MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC CHO ĐƠN TỪ 299K</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-arrow-counterclockwise text-warning me-1"></i> ĐỔI TRẢ HÀNG TẬN NHÀ TRONG 3 NGÀY</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-tag-fill text-danger me-1"></i> TẶNG VOUCHER ĐẾN 50K CHO ĐƠN HÀNG MỚI</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-patch-check-fill text-info me-1"></i> 100% COTTON COMPACT CAO CẤP CHỐNG BAI XÙ</span>
            <span class="marquee-bullet">•</span>
            <span><i class="bi bi-shield-check text-success me-1"></i> ĐỒNG KIỂM TRA HÀNG KHI THANH TOÁN</span>
            <span class="marquee-bullet">•</span>
        </div>
    </div>
</div>

<!-- Main Homepage Container -->
<div class="homepage-wrapper bg-white text-dark pb-5">

    <!-- 1. EDITORIAL HERO LOOKBOOK CAROUSEL -->
    <section class="hero-section position-relative overflow-hidden">
        <div id="homepageHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5500">
            <!-- Indicators -->
            <div class="carousel-indicators mb-3 mb-md-4">
                <button type="button" data-bs-target="#homepageHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#homepageHeroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#homepageHeroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <!-- Carousel Inner -->
            <div class="carousel-inner">

                <!-- SLIDE 1 -->
                <div class="carousel-item active">
                    <div class="container py-4 py-lg-5">
                        <div class="row align-items-center g-4 g-lg-5 min-vh-lg-65 py-3">
                            <div class="col-12 col-lg-6 order-2 order-lg-1">
                                <div class="hero-content pe-lg-4">
                                    <div class="d-flex align-items-center gap-2 mb-3 hero-entrance hero-entrance-1">
                                        <span class="badge hero-pill-badge px-3 py-1-5 rounded-pill fw-semibold fs-8 letter-spacing-wide d-inline-flex align-items-center gap-1-5">
                                            <span class="pulse-live-dot"></span>
                                            BỘ SƯU TẬP 2026
                                        </span>
                                        <span class="text-muted fs-8 fw-medium d-none d-sm-inline">Xu Hướng Thời Thượng</span>
                                    </div>
                                    <h1 class="display-4 fw-extrabold text-dark mb-3 hero-headline hero-entrance hero-entrance-2">
                                        Thời Trang Tối Giản.<br class="d-none d-sm-inline">
                                        <span class="text-gradient-dark">Chất Lượng Đích Thực.</span>
                                    </h1>
                                    <p class="text-secondary fs-6 mb-4 hero-subtext hero-entrance hero-entrance-2" style="max-width: 520px;">
                                        Khám phá các thiết kế áo thun may đo chuẩn form dáng người Việt, sợi dệt compact 100% cotton thoáng mát và bền bỉ theo thời gian.
                                    </p>
                                    <div class="d-flex flex-wrap gap-3 hero-actions hero-entrance hero-entrance-3 mb-4">
                                        <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-dark btn-lg rounded-3 px-4 py-3 fs-7 fw-semibold d-inline-flex align-items-center gap-2 btn-elevate">
                                            <span>Khám phá ngay</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                        <a href="<?php echo e(url('/Shop?sort=new')); ?>" class="btn btn-outline-dark btn-lg rounded-3 px-4 py-3 fs-7 fw-semibold btn-elevate">
                                            Hàng mới về
                                        </a>
                                    </div>

                                    <!-- Quick Hero Stats -->
                                    <div class="hero-stats-strip d-flex align-items-center gap-4 pt-3 border-top border-light-subtle hero-entrance hero-entrance-3">
                                        <div>
                                            <div class="fw-bold text-dark fs-6">50K+</div>
                                            <div class="text-muted fs-8">Khách hàng tin chọn</div>
                                        </div>
                                        <div class="vr bg-secondary opacity-25"></div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-1">
                                                <span>4.9</span>
                                                <i class="bi bi-star-fill text-warning fs-8"></i>
                                            </div>
                                            <div class="text-muted fs-8">2,400+ đánh giá</div>
                                        </div>
                                        <div class="vr bg-secondary opacity-25"></div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">100%</div>
                                            <div class="text-muted fs-8">Cotton tự nhiên</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 order-1 order-lg-2">
                                <div class="hero-media-wrapper hero-entrance-media position-relative rounded-4 overflow-hidden bg-light border border-light-subtle shadow-sm">
                                    <div class="ratio ratio-4x3 ratio-lg-1x1">
                                        <img src="<?php echo e(asset('img/banner1.jpg')); ?>" class="w-100 h-100 object-fit-cover hero-img-zoom" alt="FashionTee Lookbook 2026" fetchpriority="high">
                                    </div>
                                    <!-- Floating Trust Chip 1 -->
                                    <div class="position-absolute bottom-0 start-0 m-3 m-md-4 p-2-5 px-3 rounded-3 bg-white bg-opacity-95 backdrop-blur border border-light-subtle shadow-md d-flex align-items-center gap-2-5 hero-float-chip">
                                        <div class="rounded-circle bg-dark text-white p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:34px;height:34px;">
                                            <i class="bi bi-patch-check-fill fs-7 text-success"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-8">100% Cotton Compact</div>
                                            <div class="text-muted fs-9">Chuẩn form • Chống xù lông</div>
                                        </div>
                                    </div>
                                    <!-- Floating Tag 2 -->
                                    <div class="position-absolute top-0 end-0 m-3 m-md-4 p-2 px-3 rounded-pill bg-dark text-white shadow-sm fs-8 fw-semibold hero-badge-float">
                                        <i class="bi bi-fire text-danger me-1"></i> Best Seller 2026
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 2 -->
                <div class="carousel-item">
                    <div class="container py-4 py-lg-5">
                        <div class="row align-items-center g-4 g-lg-5 min-vh-lg-65 py-3">
                            <div class="col-12 col-lg-6 order-2 order-lg-1">
                                <div class="hero-content pe-lg-4">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="badge hero-pill-badge px-3 py-1-5 rounded-pill fw-semibold fs-8 letter-spacing-wide d-inline-flex align-items-center gap-1-5">
                                            <span class="pulse-live-dot bg-info"></span>
                                            DAILY ESSENTIALS
                                        </span>
                                        <span class="text-muted fs-8 fw-medium d-none d-sm-inline">Phong Cách Thường Nhật</span>
                                    </div>
                                    <h1 class="display-4 fw-extrabold text-dark mb-3 hero-headline">
                                        Phong Cách Năng Động.<br class="d-none d-sm-inline">
                                        <span class="text-gradient-dark">Tự Tin Tỏa Sáng.</span>
                                    </h1>
                                    <p class="text-secondary fs-6 mb-4 hero-subtext" style="max-width: 520px;">
                                        Định hình phong cách thường nhật với những gam màu trung tính thanh lịch, đường may tỉ mỉ và dễ dàng phối cùng mọi trang phục.
                                    </p>
                                    <div class="d-flex flex-wrap gap-3 hero-actions mb-4">
                                        <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-dark btn-lg rounded-3 px-4 py-3 fs-7 fw-semibold d-inline-flex align-items-center gap-2 btn-elevate">
                                            <span>Xem bộ sưu tập</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                        <a href="<?php echo e(url('/Contact')); ?>" class="btn btn-outline-dark btn-lg rounded-3 px-4 py-3 fs-7 fw-semibold btn-elevate">
                                            Tư vấn chọn size
                                        </a>
                                    </div>

                                    <div class="hero-stats-strip d-flex align-items-center gap-4 pt-3 border-top border-light-subtle">
                                        <div>
                                            <div class="fw-bold text-dark fs-6">250 GSM</div>
                                            <div class="text-muted fs-8">Định lượng vải dày dặn</div>
                                        </div>
                                        <div class="vr bg-secondary opacity-25"></div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">Rib 2x2</div>
                                            <div class="text-muted fs-8">Bo cổ chống bai dão</div>
                                        </div>
                                        <div class="vr bg-secondary opacity-25"></div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">03 Ngày</div>
                                            <div class="text-muted fs-8">Đổi size miễn phí</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 order-1 order-lg-2">
                                <div class="hero-media-wrapper position-relative rounded-4 overflow-hidden bg-light border border-light-subtle shadow-sm">
                                    <div class="ratio ratio-4x3 ratio-lg-1x1">
                                        <img src="<?php echo e(asset('img/banner_img_07.jpg')); ?>" class="w-100 h-100 object-fit-cover hero-img-zoom" alt="FashionTee Lifestyle" loading="lazy">
                                    </div>
                                    <div class="position-absolute bottom-0 start-0 m-3 m-md-4 p-2-5 px-3 rounded-3 bg-white bg-opacity-95 backdrop-blur border border-light-subtle shadow-md d-flex align-items-center gap-2-5 hero-float-chip">
                                        <div class="rounded-circle bg-dark text-white p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:34px;height:34px;">
                                            <i class="bi bi-truck fs-7 text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-8">Giao Hàng Toàn Quốc</div>
                                            <div class="text-muted fs-9">Kiểm tra hàng trước khi nhận</div>
                                        </div>
                                    </div>
                                    <div class="position-absolute top-0 end-0 m-3 m-md-4 p-2 px-3 rounded-pill bg-dark text-white shadow-sm fs-8 fw-semibold hero-badge-float">
                                        <i class="bi bi-stars text-warning me-1"></i> New Season Drop
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 3 -->
                <div class="carousel-item">
                    <div class="container py-4 py-lg-5">
                        <div class="row align-items-center g-4 g-lg-5 min-vh-lg-65 py-3">
                            <div class="col-12 col-lg-6 order-2 order-lg-1">
                                <div class="hero-content pe-lg-4">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="badge hero-pill-badge px-3 py-1-5 rounded-pill fw-semibold fs-8 letter-spacing-wide d-inline-flex align-items-center gap-1-5">
                                            <span class="pulse-live-dot bg-warning"></span>
                                            PREMIUM FABRIC
                                        </span>
                                        <span class="text-muted fs-8 fw-medium d-none d-sm-inline">Công Nghệ May Tinh Xảo</span>
                                    </div>
                                    <h1 class="display-4 fw-extrabold text-dark mb-3 hero-headline">
                                        Chất Liệu Cao Cấp.<br class="d-none d-sm-inline">
                                        <span class="text-gradient-dark">Bền Bỉ Cùng Năm Tháng.</span>
                                    </h1>
                                    <p class="text-secondary fs-6 mb-4 hero-subtext" style="max-width: 520px;">
                                        Định lượng vải dày dặn vừa phải, bo cổ dệt rib giữ form chuẩn xác sau nhiều lần giặt. Hỗ trợ đổi trả trong 3 ngày tận nơi nếu có lỗi.
                                    </p>
                                    <div class="d-flex flex-wrap gap-3 hero-actions mb-4">
                                        <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-dark btn-lg rounded-3 px-4 py-3 fs-7 fw-semibold d-inline-flex align-items-center gap-2 btn-elevate">
                                            <span>Mua sắm ngay</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                        <a href="<?php echo e(url('/Shop?sort=new')); ?>" class="btn btn-outline-dark btn-lg rounded-3 px-4 py-3 fs-7 fw-semibold btn-elevate">
                                            Sản phẩm hot
                                        </a>
                                    </div>

                                    <div class="hero-stats-strip d-flex align-items-center gap-4 pt-3 border-top border-light-subtle">
                                        <div>
                                            <div class="fw-bold text-dark fs-6">Đổi tận nơi</div>
                                            <div class="text-muted fs-8">Shipper lấy hàng tại nhà</div>
                                        </div>
                                        <div class="vr bg-secondary opacity-25"></div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">Mềm mịn</div>
                                            <div class="text-muted fs-8">Kháng khuẩn & khử mùi</div>
                                        </div>
                                        <div class="vr bg-secondary opacity-25"></div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">Chuẩn form</div>
                                            <div class="text-muted fs-8">Đủ kích thước S - XXL</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 order-1 order-lg-2">
                                <div class="hero-media-wrapper position-relative rounded-4 overflow-hidden bg-light border border-light-subtle shadow-sm">
                                    <div class="ratio ratio-4x3 ratio-lg-1x1">
                                        <img src="<?php echo e(asset('img/banner_img_05.jpg')); ?>" class="w-100 h-100 object-fit-cover hero-img-zoom" alt="FashionTee Fabric Quality" loading="lazy">
                                    </div>
                                    <div class="position-absolute bottom-0 start-0 m-3 m-md-4 p-2-5 px-3 rounded-3 bg-white bg-opacity-95 backdrop-blur border border-light-subtle shadow-md d-flex align-items-center gap-2-5 hero-float-chip">
                                        <div class="rounded-circle bg-dark text-white p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:34px;height:34px;">
                                            <i class="bi bi-arrow-counterclockwise fs-7 text-warning"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-8">Đổi Trả Trong 3 Ngày</div>
                                            <div class="text-muted fs-9">Miễn phí nếu phát sinh lỗi</div>
                                        </div>
                                    </div>
                                    <div class="position-absolute top-0 end-0 m-3 m-md-4 p-2 px-3 rounded-pill bg-dark text-white shadow-sm fs-8 fw-semibold hero-badge-float">
                                        <i class="bi bi-gem text-info me-1"></i> Premium Craft
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Controls -->
            <button class="carousel-control-prev hero-carousel-btn hero-carousel-btn--prev d-none d-md-flex" type="button" data-bs-target="#homepageHeroCarousel" data-bs-slide="prev" aria-label="Slide trước">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="carousel-control-next hero-carousel-btn hero-carousel-btn--next d-none d-md-flex" type="button" data-bs-target="#homepageHeroCarousel" data-bs-slide="next" aria-label="Slide sau">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </section>

    <!-- 2. VALUE PROPOSITIONS STRIP (4 Cam Kết Cốt Lõi) -->
    <section class="py-4 border-top border-bottom border-light-subtle bg-light">
        <div class="container">
            <div class="row g-3 g-lg-4 text-center text-md-start">
                <div class="col-6 col-lg-3 reveal stagger-1">
                    <div class="value-prop-card p-3 rounded-3 bg-white border border-light-subtle shadow-xs d-flex align-items-center gap-3 h-100">
                        <div class="value-prop-icon rounded-circle bg-emerald-light text-success p-2-5 d-flex align-items-center justify-content-center flex-shrink-0">
                            <i class="bi bi-shield-check fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0 fs-7">100% Cotton Compact</h6>
                            <p class="text-muted fs-8 mb-0 d-none d-sm-block">Sợi dệt mịn màng, chống bai xù</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 reveal stagger-2">
                    <div class="value-prop-card p-3 rounded-3 bg-white border border-light-subtle shadow-xs d-flex align-items-center gap-3 h-100">
                        <div class="value-prop-icon rounded-circle bg-amber-light text-warning p-2-5 d-flex align-items-center justify-content-center flex-shrink-0">
                            <i class="bi bi-arrow-counterclockwise fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0 fs-7">Đổi Hàng Tận Nơi 3 Ngày</h6>
                            <p class="text-muted fs-8 mb-0 d-none d-sm-block">Hỗ trợ đổi size nhanh gọn tại nhà</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 reveal stagger-3">
                    <div class="value-prop-card p-3 rounded-3 bg-white border border-light-subtle shadow-xs d-flex align-items-center gap-3 h-100">
                        <div class="value-prop-icon rounded-circle bg-blue-light text-primary p-2-5 d-flex align-items-center justify-content-center flex-shrink-0">
                            <i class="bi bi-truck fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0 fs-7">Giao Hàng Toàn Quốc</h6>
                            <p class="text-muted fs-8 mb-0 d-none d-sm-block">Đồng kiểm tra hàng trước khi nhận</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 reveal stagger-4">
                    <div class="value-prop-card p-3 rounded-3 bg-white border border-light-subtle shadow-xs d-flex align-items-center gap-3 h-100">
                        <div class="value-prop-icon rounded-circle bg-purple-light text-purple p-2-5 d-flex align-items-center justify-content-center flex-shrink-0">
                            <i class="bi bi-headset fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0 fs-7">Hỗ Trợ Tận Tâm 24/7</h6>
                            <p class="text-muted fs-8 mb-0 d-none d-sm-block">Tư vấn chuẩn size, form dáng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. EXCLUSIVE VOUCHER COUPON CARDS (Săn Voucher Ưu Đãi) -->
    <section class="py-5 bg-white border-bottom border-light-subtle">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4 reveal">
                <div>
                    <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill fw-semibold fs-8 mb-2 d-inline-block">
                        <i class="bi bi-ticket-perforated-fill me-1"></i> ƯU ĐÃI ĐỘC QUYỀN
                    </span>
                    <h2 class="fw-bold text-dark mb-0 fs-3">Mã Giảm Giá Hôm Nay</h2>
                </div>
                <span class="text-muted fs-7">Bấm sao chép mã và áp dụng ngay ở bước thanh toán</span>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 g-md-4">
                <?php if(isset($vouchers) && $vouchers->isNotEmpty()): ?>
                    <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col reveal stagger-<?php echo e($loop->iteration); ?>">
                            <div class="coupon-ticket p-3 rounded-3 bg-light border border-dashed border-2 position-relative h-100 d-flex flex-column justify-content-between">
                                <div class="coupon-notch coupon-notch-left"></div>
                                <div class="coupon-notch coupon-notch-right"></div>
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-dark text-white px-2 py-1 rounded fs-8 fw-semibold"><?php echo e($v->ma); ?></span>
                                        <small class="text-danger fw-bold fs-8">
                                            <?php if($v->loai === 'phan_tram'): ?>
                                                Giảm <?php echo e((int)$v->gia_tri); ?>%
                                            <?php else: ?>
                                                Giảm <?php echo e(number_format($v->gia_tri, 0, ',', '.')); ?>đ
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    <h6 class="fw-bold text-dark fs-7 mb-1"><?php echo e($v->ten ?? 'Ưu đãi mua sắm'); ?></h6>
                                    <p class="text-muted fs-8 mb-2 text-truncate-2">
                                        <?php if($v->don_hang_toi_thieu > 0): ?>
                                            Đơn từ <?php echo e(number_format($v->don_hang_toi_thieu, 0, ',', '.')); ?>đ
                                        <?php else: ?>
                                            Áp dụng mọi đơn hàng
                                        <?php endif; ?>
                                        <?php if($v->giam_toi_da > 0): ?>
                                            • Tối đa <?php echo e(number_format($v->giam_toi_da, 0, ',', '.')); ?>đ
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="pt-2 border-top border-light-subtle d-flex justify-content-between align-items-center">
                                    <span class="text-muted fs-9">
                                        <?php if($v->ket_thuc): ?>
                                            HSD: <?php echo e(\Carbon\Carbon::parse($v->ket_thuc)->format('d/m/Y')); ?>

                                        <?php else: ?>
                                            Số lượng có hạn
                                        <?php endif; ?>
                                    </span>
                                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 fs-8 fw-medium btn-copy-coupon" data-code="<?php echo e($v->ma); ?>">
                                        <i class="bi bi-clipboard me-1"></i> Sao chép
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <!-- Default Curated Vouchers if database has none -->
                    <div class="col reveal stagger-1">
                        <div class="coupon-ticket p-3 rounded-3 bg-light border border-dashed border-2 position-relative h-100 d-flex flex-column justify-content-between">
                            <div class="coupon-notch coupon-notch-left"></div>
                            <div class="coupon-notch coupon-notch-right"></div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-dark text-white px-2 py-1 rounded fs-8 fw-semibold">FREESHIP</span>
                                    <small class="text-success fw-bold fs-8">Miễn phí ship</small>
                                </div>
                                <h6 class="fw-bold text-dark fs-7 mb-1">Miễn Phí Vận Chuyển</h6>
                                <p class="text-muted fs-8 mb-2">Áp dụng cho đơn hàng từ 299.000đ trên toàn quốc.</p>
                            </div>
                            <div class="pt-2 border-top border-light-subtle d-flex justify-content-between align-items-center">
                                <span class="text-muted fs-9">Hiệu lực hôm nay</span>
                                <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 fs-8 fw-medium btn-copy-coupon" data-code="FREESHIP">
                                    <i class="bi bi-clipboard me-1"></i> Sao chép
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col reveal stagger-2">
                        <div class="coupon-ticket p-3 rounded-3 bg-light border border-dashed border-2 position-relative h-100 d-flex flex-column justify-content-between">
                            <div class="coupon-notch coupon-notch-left"></div>
                            <div class="coupon-notch coupon-notch-right"></div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-dark text-white px-2 py-1 rounded fs-8 fw-semibold">TEE20K</span>
                                    <small class="text-danger fw-bold fs-8">Giảm 20.000đ</small>
                                </div>
                                <h6 class="fw-bold text-dark fs-7 mb-1">Đơn Hàng Đầu Tiên</h6>
                                <p class="text-muted fs-8 mb-2">Dành cho khách hàng mới mua sắm tại website.</p>
                            </div>
                            <div class="pt-2 border-top border-light-subtle d-flex justify-content-between align-items-center">
                                <span class="text-muted fs-9">Số lượng có hạn</span>
                                <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 fs-8 fw-medium btn-copy-coupon" data-code="TEE20K">
                                    <i class="bi bi-clipboard me-1"></i> Sao chép
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col reveal stagger-3">
                        <div class="coupon-ticket p-3 rounded-3 bg-light border border-dashed border-2 position-relative h-100 d-flex flex-column justify-content-between">
                            <div class="coupon-notch coupon-notch-left"></div>
                            <div class="coupon-notch coupon-notch-right"></div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-dark text-white px-2 py-1 rounded fs-8 fw-semibold">VIP10</span>
                                    <small class="text-danger fw-bold fs-8">Giảm 10%</small>
                                </div>
                                <h6 class="fw-bold text-dark fs-7 mb-1">Hội Viên Thân Thiết</h6>
                                <p class="text-muted fs-8 mb-2">Giảm ngay 10% tối đa 50K cho đơn từ 399.000đ.</p>
                            </div>
                            <div class="pt-2 border-top border-light-subtle d-flex justify-content-between align-items-center">
                                <span class="text-muted fs-9">Hiệu lực tháng này</span>
                                <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 fs-8 fw-medium btn-copy-coupon" data-code="VIP10">
                                    <i class="bi bi-clipboard me-1"></i> Sao chép
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col reveal stagger-4">
                        <div class="coupon-ticket p-3 rounded-3 bg-light border border-dashed border-2 position-relative h-100 d-flex flex-column justify-content-between">
                            <div class="coupon-notch coupon-notch-left"></div>
                            <div class="coupon-notch coupon-notch-right"></div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-dark text-white px-2 py-1 rounded fs-8 fw-semibold">COMBO50</span>
                                    <small class="text-danger fw-bold fs-8">Giảm 50.000đ</small>
                                </div>
                                <h6 class="fw-bold text-dark fs-7 mb-1">Combo Tiết Kiệm</h6>
                                <p class="text-muted fs-8 mb-2">Áp dụng khi mua từ 2 áo thun bất kỳ trong BST.</p>
                            </div>
                            <div class="pt-2 border-top border-light-subtle d-flex justify-content-between align-items-center">
                                <span class="text-muted fs-9">Đang áp dụng</span>
                                <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 fs-8 fw-medium btn-copy-coupon" data-code="COMBO50">
                                    <i class="bi bi-clipboard me-1"></i> Sao chép
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 4. SHOP BY CATEGORY (Danh mục nổi bật) -->
    <?php if($danhMucs->isNotEmpty()): ?>
        <section class="py-5 bg-white">
            <div class="container py-2">
                <div class="d-flex justify-content-between align-items-end mb-4 reveal">
                    <div>
                        <span class="text-uppercase text-muted fs-8 fw-semibold tracking-wider d-block mb-1">BỘ SƯU TẬP CHỦ ĐẠO</span>
                        <h2 class="fw-bold text-dark mb-0 fs-3">Khám Phá Theo Phong Cách</h2>
                    </div>
                    <a href="<?php echo e(url('/Shop')); ?>" class="text-decoration-none text-dark fw-semibold fs-7 d-none d-sm-inline-flex align-items-center gap-1 hover-underline">
                        <span>Tất cả danh mục</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="row row-cols-2 row-cols-lg-4 g-3 g-lg-4">
                    <?php $__currentLoopData = $danhMucs->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col reveal stagger-<?php echo e($loop->iteration); ?>">
                            <a href="<?php echo e(url('/Shop?danh_muc=' . $dm->id)); ?>" class="category-card-link text-decoration-none group d-block h-100">
                                <div class="category-card rounded-4 overflow-hidden bg-light border border-light-subtle position-relative shadow-xs">
                                    <div class="category-thumb-box position-relative overflow-hidden">
                                        <img src="<?php echo e($dm->hinh_anh ? asset('storage/' . $dm->hinh_anh) : asset('img/shop_01.jpg')); ?>"
                                             class="w-100 h-100 category-thumb object-fit-cover"
                                             alt="<?php echo e($dm->ten_danh_muc); ?>"
                                             loading="lazy"
                                             decoding="async">
                                        <div class="position-absolute top-0 start-0 m-3 z-2">
                                            <span class="badge bg-white bg-opacity-90 text-dark px-2-5 py-1 rounded-pill fw-semibold fs-9 shadow-xs backdrop-blur">
                                                Khám phá
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-white d-flex justify-content-between align-items-center border-top border-light-subtle">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-7 category-title"><?php echo e($dm->ten_danh_muc); ?></h6>
                                            <span class="text-muted fs-8">Xem sản phẩm</span>
                                        </div>
                                        <div class="category-arrow-circle rounded-circle d-flex align-items-center justify-content-center text-dark bg-light border border-light-subtle">
                                            <i class="bi bi-arrow-up-right fs-8"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 5. NEW ARRIVALS (Sản phẩm mới nhất - Lookbook Card 3:4) -->
    <section class="py-5 bg-light border-top border-bottom border-light-subtle">
        <div class="container py-2">
            <div class="d-flex justify-content-between align-items-end mb-4 reveal">
                <div>
                    <span class="text-uppercase text-muted fs-8 fw-semibold tracking-wider d-block mb-1">HÀNG MỚI VỀ 2026</span>
                    <h2 class="fw-bold text-dark mb-0 fs-3">Sản Phẩm Mới Nhất</h2>
                </div>
                <a href="<?php echo e(url('/Shop?sort=new')); ?>" class="text-decoration-none text-dark fw-semibold fs-7 d-none d-sm-inline-flex align-items-center gap-1 hover-underline">
                    <span>Xem tất cả (<?php echo e($sanPhamsMoiNhat->count()); ?>)</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Product Grid: 5 columns on desktop, exactly like Shop -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 g-md-4">
                <?php $__empty_1 = true; $__currentLoopData = $sanPhamsMoiNhat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $giaGoc = $sp->variants_min_gia ?? null;
                        $giaKm = $sp->variants_min_gia_khuyen_mai ?? null;
                        $phanTramGiam = null;
                        if ($giaGoc && $giaKm && $giaKm < $giaGoc && $giaGoc > 0) {
                            $phanTramGiam = (int) round(100 - (($giaKm / $giaGoc) * 100));
                        }
                        $colors = $sp->variants ? $sp->variants->pluck('color')->filter()->unique('id') : collect();
                    ?>
                    <div class="col reveal stagger-<?php echo e($loop->iteration); ?>">
                        <div class="card clean-product-card h-100 border-0 rounded-3 overflow-hidden bg-white shadow-xs">
                            <!-- Image Frame 3:4 -->
                            <div class="clean-product-thumb-box position-relative rounded-top overflow-hidden bg-light border-bottom border-light-subtle">
                                <!-- Status Badges -->
                                <div class="position-absolute top-0 start-0 m-2 z-2 d-flex flex-column gap-1">
                                    <span class="badge bg-dark text-white px-2 py-1 rounded-pill fw-semibold fs-9">
                                        Mới
                                    </span>
                                    <?php if($phanTramGiam): ?>
                                        <span class="badge bg-danger text-white px-2 py-1 rounded-pill fw-bold fs-9">
                                            -<?php echo e($phanTramGiam); ?>%
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Wishlist Button -->
                                <button type="button" class="btn-wishlist position-absolute top-0 end-0 m-2 z-2 border-0 rounded-circle d-flex align-items-center justify-content-center" data-id="<?php echo e($sp->id); ?>" title="Yêu thích">
                                    <i class="bi bi-heart"></i>
                                </button>

                                <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>" class="d-block w-100 h-100">
                                    <img class="clean-product-thumb w-100 h-100"
                                         src="<?php echo e($sp->hinh_anh_chinh ? asset('storage/' . $sp->hinh_anh_chinh) : asset('img/shop_01.jpg')); ?>"
                                         loading="lazy"
                                         decoding="async"
                                         alt="<?php echo e($sp->ten_san_pham); ?>">
                                </a>

                                <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                   class="quick-view-overlay-btn btn btn-dark btn-sm rounded-pill position-absolute bottom-0 start-50 translate-middle-x mb-3 opacity-0 text-nowrap px-3 shadow-sm">
                                    <i class="bi bi-eye me-1"></i> Xem chi tiết
                                </a>
                            </div>

                            <!-- Info -->
                            <div class="card-body p-2-5 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted fs-8 text-uppercase tracking-wider">
                                            <?php echo e($sp->category->ten_danh_muc ?? 'Fashion'); ?>

                                        </span>
                                        <?php if($colors->isNotEmpty()): ?>
                                            <div class="color-swatches-mini d-flex align-items-center gap-1">
                                                <?php $__currentLoopData = $colors->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="swatch-dot" style="background-color: <?php echo e($c->ma_mau ?? '#ccc'); ?>;" title="<?php echo e($c->ten_mau ?? ''); ?>"></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($colors->count() > 3): ?>
                                                    <span class="fs-9 text-muted">+<?php echo e($colors->count() - 3); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                       class="clean-product-title text-decoration-none text-dark fw-semibold d-block fs-7 mb-2 text-truncate-2"
                                       title="<?php echo e($sp->ten_san_pham); ?>">
                                        <?php echo e($sp->ten_san_pham); ?>

                                    </a>
                                </div>

                                <div>
                                    <div class="d-flex align-items-center gap-1 mb-1 fs-9 text-muted">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span class="fw-semibold text-dark">5.0</span>
                                        <span>(120+)</span>
                                    </div>

                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="clean-product-price fw-bold text-dark fs-7">
                                            <?php if($giaKm): ?>
                                                <?php echo e(number_format($giaKm, 0, ',', '.')); ?> ₫
                                            <?php elseif($giaGoc): ?>
                                                <?php echo e(number_format($giaGoc, 0, ',', '.')); ?> ₫
                                            <?php else: ?>
                                                Liên hệ
                                            <?php endif; ?>
                                        </span>
                                        <?php if($giaKm && $giaGoc && $giaKm < $giaGoc): ?>
                                            <small class="text-muted text-decoration-line-through fs-8">
                                                <?php echo e(number_format($giaGoc, 0, ',', '.')); ?> ₫
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Chưa có sản phẩm mới nào.</p>
                        <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-dark rounded-3 px-4 py-2 fs-7">Khám phá cửa hàng</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($sanPhamsMoiNhat->isNotEmpty()): ?>
                <div class="text-center mt-5 reveal">
                    <a href="<?php echo e(url('/Shop?sort=new')); ?>" class="btn btn-outline-dark rounded-3 px-5 py-2-5 fs-7 fw-semibold btn-elevate">
                        Xem tất cả sản phẩm mới <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- 6. BRAND STORY & FABRIC TECHNOLOGY (Tuyên Ngôn & Công Nghệ Sợi Vải) -->
    <section class="py-5 bg-white">
        <div class="container py-2">
            <div class="brand-story-banner rounded-4 p-4 p-md-5 bg-dark text-white position-relative overflow-hidden shadow-lg">
                <div class="ambient-glow position-absolute top-0 end-0"></div>

                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-12 col-lg-7 position-relative z-2 reveal reveal-left">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-white text-dark px-3 py-1-5 rounded-pill fw-semibold fs-8 letter-spacing-wide">
                                FASHIONTEE PHILOSOPHY
                            </span>
                            <span class="text-white-50 fs-8">May đo chuẩn tỉ lệ</span>
                        </div>
                        <h2 class="display-6 fw-bold text-white mb-3">
                            Thời trang không cần phô trương.<br>
                            <span class="text-white-50">Sự tinh tế bắt đầu từ chất vải.</span>
                        </h2>
                        <p class="text-white-50 fs-7 mb-4" style="max-width: 540px; line-height: 1.75;">
                            Mỗi chiếc áo thun tại FashionTee đều được chắt lọc từ nguồn sợi bông compact tự nhiên, ứng dụng kỹ thuật may giấu đường chỉ và bo cổ rib 2x2 chống bai dão, đem lại sự êm ái tối đa trong từng cử động thường nhật.
                        </p>

                        <div class="row row-cols-2 g-3 mb-4">
                            <div class="col">
                                <div class="d-flex align-items-start gap-2-5">
                                    <div class="rounded-circle bg-white bg-opacity-10 p-2 d-flex align-items-center justify-content-center flex-shrink-0 text-success">
                                        <i class="bi bi-check2-circle fs-6"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-white fs-8 mb-1">Cotton Compact 250 GSM</h6>
                                        <p class="text-white-50 fs-9 mb-0">Dày dặn, không lộ viền, mềm mịn</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-start gap-2-5">
                                    <div class="rounded-circle bg-white bg-opacity-10 p-2 d-flex align-items-center justify-content-center flex-shrink-0 text-warning">
                                        <i class="bi bi-shield-lock fs-6"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-white fs-8 mb-1">Bo Cổ Rib 2x2 Spandex</h6>
                                        <p class="text-white-50 fs-9 mb-0">Chống bai dão sau 100 lần giặt</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-start gap-2-5">
                                    <div class="rounded-circle bg-white bg-opacity-10 p-2 d-flex align-items-center justify-content-center flex-shrink-0 text-info">
                                        <i class="bi bi-droplet fs-6"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-white fs-8 mb-1">Nhuộm Hoạt Tính Bền Màu</h6>
                                        <p class="text-white-50 fs-9 mb-0">An toàn cho da, không thôi màu</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-start gap-2-5">
                                    <div class="rounded-circle bg-white bg-opacity-10 p-2 d-flex align-items-center justify-content-center flex-shrink-0 text-primary">
                                        <i class="bi bi-person-check fs-6"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-white fs-8 mb-1">Form Regular Tôn Dáng</h6>
                                        <p class="text-white-50 fs-9 mb-0">Chuẩn số đo vóc dáng người Việt</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-light rounded-3 px-4 py-3 fs-7 fw-bold text-dark d-inline-flex align-items-center gap-2 btn-elevate">
                                <span>Khám phá bộ sưu tập</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="<?php echo e(url('/Contact')); ?>" class="btn btn-outline-light rounded-3 px-4 py-3 fs-7 fw-medium btn-elevate">
                                Liên hệ thương hiệu
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 position-relative z-2 text-center text-lg-end reveal reveal-right">
                        <div class="brand-story-image-wrap rounded-4 overflow-hidden d-inline-block border border-light border-opacity-25 shadow-2xl position-relative">
                            <img src="<?php echo e(asset('img/banner_img_02.jpg')); ?>" class="img-fluid w-100 object-fit-cover" alt="FashionTee Story" loading="lazy">
                            <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark-bottom text-start">
                                <span class="badge bg-white text-dark px-2-5 py-1 rounded-pill fw-bold fs-9 mb-1">Craftsmanship</span>
                                <div class="text-white fw-semibold fs-8">Tỉ mỉ trên từng đường kim mũi chỉ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. CURATED SHOWCASE: SEGMENTED TABS (Bán Chạy & Đang Giảm Giá) -->
    <section class="py-5 bg-light border-top border-bottom border-light-subtle">
        <div class="container py-2">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4 reveal">
                <div>
                    <span class="text-uppercase text-muted fs-8 fw-semibold tracking-wider d-block mb-1">BỘ SƯU TẬP ĐẶC BIỆT</span>
                    <h2 class="fw-bold text-dark mb-0 fs-3">Thịnh Hành & Ưu Đãi</h2>
                </div>

                <ul class="nav nav-pills showcase-pills bg-white p-1-5 rounded-pill border border-light-subtle shadow-xs" id="curatedShowcaseTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link showcase-pill-link active rounded-pill px-3 py-1-5 fs-7 fw-semibold"
                                id="hot-tab" data-bs-toggle="pill" data-bs-target="#hot-pane"
                                type="button" role="tab" aria-controls="hot-pane" aria-selected="true">
                            <i class="bi bi-fire text-danger me-1"></i> Bán chạy
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link showcase-pill-link rounded-pill px-3 py-1-5 fs-7 fw-semibold"
                                id="sale-tab" data-bs-toggle="pill" data-bs-target="#sale-pane"
                                type="button" role="tab" aria-controls="sale-pane" aria-selected="false">
                            <i class="bi bi-percent text-success me-1"></i> Đang giảm giá
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="curatedShowcaseTabContent">

                <!-- TAB 1: BÁN CHẠY (Top Hot) -->
                <div class="tab-pane fade show active" id="hot-pane" role="tabpanel" aria-labelledby="hot-tab" tabindex="0">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                        <?php $__empty_1 = true; $__currentLoopData = $sanPhamsHot; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $giaGoc = $sp->variants_min_gia ?? null;
                                $giaKm = $sp->variants_min_gia_khuyen_mai ?? null;
                                $phanTramGiam = null;
                                if ($giaGoc && $giaKm && $giaKm < $giaGoc && $giaGoc > 0) {
                                    $phanTramGiam = (int) round(100 - (($giaKm / $giaGoc) * 100));
                                }
                                $colors = $sp->variants ? $sp->variants->pluck('color')->filter()->unique('id') : collect();
                            ?>
                            <div class="col reveal stagger-<?php echo e($loop->iteration); ?>">
                                <div class="card clean-product-card h-100 border-0 rounded-3 overflow-hidden bg-white shadow-xs">
                                    <div class="clean-product-thumb-box position-relative rounded-top overflow-hidden bg-light border-bottom border-light-subtle">
                                        <div class="position-absolute top-0 start-0 m-2 z-2 d-flex flex-column gap-1">
                                            <span class="badge bg-danger text-white px-2 py-1 rounded-pill fw-semibold fs-9">
                                                <i class="bi bi-fire me-1"></i>Hot
                                            </span>
                                            <?php if($phanTramGiam): ?>
                                                <span class="badge bg-dark text-white px-2 py-1 rounded-pill fw-bold fs-9">
                                                    -<?php echo e($phanTramGiam); ?>%
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <button type="button" class="btn-wishlist position-absolute top-0 end-0 m-2 z-2 border-0 rounded-circle d-flex align-items-center justify-content-center" data-id="<?php echo e($sp->id); ?>" title="Yêu thích">
                                            <i class="bi bi-heart"></i>
                                        </button>

                                        <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>" class="d-block w-100 h-100">
                                            <img class="clean-product-thumb w-100 h-100"
                                                 src="<?php echo e($sp->hinh_anh_chinh ? asset('storage/' . $sp->hinh_anh_chinh) : asset('img/shop_01.jpg')); ?>"
                                                 loading="lazy"
                                                 decoding="async"
                                                 alt="<?php echo e($sp->ten_san_pham); ?>">
                                        </a>

                                        <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                           class="quick-view-overlay-btn btn btn-dark btn-sm rounded-pill position-absolute bottom-0 start-50 translate-middle-x mb-3 opacity-0 text-nowrap px-3 shadow-sm">
                                            <i class="bi bi-eye me-1"></i> Xem chi tiết
                                        </a>
                                    </div>

                                    <div class="card-body p-2-5 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="text-muted fs-8 text-uppercase tracking-wider">
                                                    <?php echo e($sp->category->ten_danh_muc ?? 'Fashion'); ?>

                                                </span>
                                                <?php if($colors->isNotEmpty()): ?>
                                                    <div class="color-swatches-mini d-flex align-items-center gap-1">
                                                        <?php $__currentLoopData = $colors->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="swatch-dot" style="background-color: <?php echo e($c->ma_mau ?? '#ccc'); ?>;" title="<?php echo e($c->ten_mau ?? ''); ?>"></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                               class="clean-product-title text-decoration-none text-dark fw-semibold d-block fs-7 mb-2 text-truncate-2"
                                               title="<?php echo e($sp->ten_san_pham); ?>">
                                                <?php echo e($sp->ten_san_pham); ?>

                                            </a>
                                        </div>

                                        <div>
                                            <div class="d-flex align-items-center gap-1 mb-1 fs-9 text-muted">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <span class="fw-semibold text-dark">5.0</span>
                                                <span class="text-success ms-1"><i class="bi bi-check-circle-fill"></i> Đang bán chạy</span>
                                            </div>

                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="clean-product-price fw-bold text-dark fs-7">
                                                    <?php if($giaKm): ?>
                                                        <?php echo e(number_format($giaKm, 0, ',', '.')); ?> ₫
                                                    <?php elseif($giaGoc): ?>
                                                        <?php echo e(number_format($giaGoc, 0, ',', '.')); ?> ₫
                                                    <?php else: ?>
                                                        Liên hệ
                                                    <?php endif; ?>
                                                </span>
                                                <?php if($giaKm && $giaGoc && $giaKm < $giaGoc): ?>
                                                    <small class="text-muted text-decoration-line-through fs-8">
                                                        <?php echo e(number_format($giaGoc, 0, ',', '.')); ?> ₫
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Chưa có sản phẩm bán chạy.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- TAB 2: ĐANG GIẢM GIÁ (Sale) -->
                <div class="tab-pane fade" id="sale-pane" role="tabpanel" aria-labelledby="sale-tab" tabindex="0">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                        <?php $__empty_1 = true; $__currentLoopData = $sanPhamsGiamGia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $giaGoc = $sp->variants_min_gia ?? null;
                                $giaKm = $sp->variants_min_gia_khuyen_mai ?? null;
                                $phanTramGiam = null;
                                if ($giaGoc && $giaKm && $giaKm < $giaGoc && $giaGoc > 0) {
                                    $phanTramGiam = (int) round(100 - (($giaKm / $giaGoc) * 100));
                                }
                                $colors = $sp->variants ? $sp->variants->pluck('color')->filter()->unique('id') : collect();
                            ?>
                            <div class="col reveal stagger-<?php echo e($loop->iteration); ?>">
                                <div class="card clean-product-card h-100 border-0 rounded-3 overflow-hidden bg-white shadow-xs">
                                    <div class="clean-product-thumb-box position-relative rounded-top overflow-hidden bg-light border-bottom border-light-subtle">
                                        <div class="position-absolute top-0 start-0 m-2 z-2">
                                            <?php if($phanTramGiam): ?>
                                                <span class="badge bg-danger text-white px-2 py-1 rounded-pill fw-bold fs-9">
                                                    -<?php echo e($phanTramGiam); ?>%
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger text-white px-2 py-1 rounded-pill fw-bold fs-9">
                                                    Sale
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <button type="button" class="btn-wishlist position-absolute top-0 end-0 m-2 z-2 border-0 rounded-circle d-flex align-items-center justify-content-center" data-id="<?php echo e($sp->id); ?>" title="Yêu thích">
                                            <i class="bi bi-heart"></i>
                                        </button>

                                        <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>" class="d-block w-100 h-100">
                                            <img class="clean-product-thumb w-100 h-100"
                                                 src="<?php echo e($sp->hinh_anh_chinh ? asset('storage/' . $sp->hinh_anh_chinh) : asset('img/shop_01.jpg')); ?>"
                                                 loading="lazy"
                                                 decoding="async"
                                                 alt="<?php echo e($sp->ten_san_pham); ?>">
                                        </a>

                                        <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                           class="quick-view-overlay-btn btn btn-dark btn-sm rounded-pill position-absolute bottom-0 start-50 translate-middle-x mb-3 opacity-0 text-nowrap px-3 shadow-sm">
                                            <i class="bi bi-eye me-1"></i> Xem chi tiết
                                        </a>
                                    </div>

                                    <div class="card-body p-2-5 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="text-muted fs-8 text-uppercase tracking-wider">
                                                    <?php echo e($sp->category->ten_danh_muc ?? 'Fashion'); ?>

                                                </span>
                                                <?php if($colors->isNotEmpty()): ?>
                                                    <div class="color-swatches-mini d-flex align-items-center gap-1">
                                                        <?php $__currentLoopData = $colors->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="swatch-dot" style="background-color: <?php echo e($c->ma_mau ?? '#ccc'); ?>;" title="<?php echo e($c->ten_mau ?? ''); ?>"></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                               class="clean-product-title text-decoration-none text-dark fw-semibold d-block fs-7 mb-2 text-truncate-2"
                                               title="<?php echo e($sp->ten_san_pham); ?>">
                                                <?php echo e($sp->ten_san_pham); ?>

                                            </a>
                                        </div>

                                        <div>
                                            <div class="d-flex align-items-center gap-1 mb-1 fs-9 text-muted">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <span class="fw-semibold text-dark">5.0</span>
                                                <span class="text-danger ms-1 fw-medium"><i class="bi bi-tag-fill"></i> Giá ưu đãi</span>
                                            </div>

                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="clean-product-price fw-bold text-danger fs-7">
                                                    <?php if($giaKm): ?>
                                                        <?php echo e(number_format($giaKm, 0, ',', '.')); ?> ₫
                                                    <?php elseif($giaGoc): ?>
                                                        <?php echo e(number_format($giaGoc, 0, ',', '.')); ?> ₫
                                                    <?php else: ?>
                                                        Liên hệ
                                                    <?php endif; ?>
                                                </span>
                                                <?php if($giaKm && $giaGoc && $giaKm < $giaGoc): ?>
                                                    <small class="text-muted text-decoration-line-through fs-8">
                                                        <?php echo e(number_format($giaGoc, 0, ',', '.')); ?> ₫
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Hiện chưa có sản phẩm giảm giá.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="text-center mt-5">
                <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-dark rounded-3 px-5 py-2-5 fs-7 fw-semibold btn-elevate">
                    Khám phá toàn bộ cửa hàng <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 8. FEATURED CUSTOMER REVIEWS (Đánh Giá Nổi Bật) -->
    <?php if($danhGias->isNotEmpty()): ?>
        <section class="py-5 bg-white">
            <div class="container py-2">
                <div class="d-flex justify-content-between align-items-end mb-4 reveal">
                    <div>
                        <span class="text-uppercase text-muted fs-8 fw-semibold tracking-wider d-block mb-1">TRẢI NGHIỆM KHÁCH HÀNG</span>
                        <h2 class="fw-bold text-dark mb-0 fs-3">Đánh Giá Thực Tế</h2>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn swiper-arrow-btn swiper-prev rounded-circle d-flex align-items-center justify-content-center" aria-label="Đánh giá trước">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn swiper-arrow-btn swiper-next rounded-circle d-flex align-items-center justify-content-center" aria-label="Đánh giá sau">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="swiper mySwiper reveal reveal-scale">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $danhGias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide h-auto">
                                <div class="review-home-card p-4 rounded-4 bg-light border border-light-subtle h-100 d-flex flex-column justify-content-between position-relative shadow-xs">
                                    <div class="review-watermark position-absolute top-0 end-0 p-3 opacity-10 pe-none">
                                        <i class="bi bi-quote fs-1 text-dark"></i>
                                    </div>

                                    <div>
                                        <div class="text-warning mb-3 d-flex align-items-center gap-1 fs-7">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi bi-star<?php echo e($i <= $dg->so_sao ? '-fill' : ''); ?>"></i>
                                            <?php endfor; ?>
                                        </div>

                                        <p class="review-home-quote text-secondary fs-7 lh-lg mb-4">
                                            "<?php echo e($dg->noi_dung); ?>"
                                        </p>
                                    </div>

                                    <div class="d-flex align-items-center gap-2-5 pt-3 border-top border-light-subtle">
                                        <div class="review-home-avatar rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold fs-8">
                                            <?php echo e(mb_substr($dg->user->name ?? 'K', 0, 1, 'UTF-8')); ?>

                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-7 d-flex align-items-center gap-1">
                                                <span><?php echo e($dg->user->name ?? 'Khách hàng'); ?></span>
                                                <i class="bi bi-patch-check-fill text-success fs-8" title="Đã mua hàng và xác thực"></i>
                                            </div>
                                            <div class="text-muted fs-8">Khách hàng xác thực</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 9. STREET STYLE LOOKBOOK (#FashionTeeDaily) -->
    <section class="py-5 bg-light border-top border-bottom border-light-subtle">
        <div class="container py-2">
            <div class="text-center mb-4 reveal">
                <span class="text-uppercase text-muted fs-8 fw-semibold tracking-wider d-block mb-1">CỘNG ĐỒNG FASHIONTEE</span>
                <h2 class="fw-bold text-dark mb-1 fs-3">Gợi Ý Phối Đồ #FashionTeeDaily</h2>
                <p class="text-muted fs-7 mb-0">Theo dõi @fashiontee trên mạng xã hội để cập nhật những outfit tối giản thời thượng</p>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
                <div class="col reveal stagger-1">
                    <div class="lookbook-grid-item rounded-3 overflow-hidden position-relative ratio ratio-1x1 bg-white border border-light-subtle">
                        <img src="<?php echo e(asset('img/shop_01.jpg')); ?>" class="w-100 h-100 object-fit-cover lookbook-img" alt="FashionTee Street Style" loading="lazy">
                        <div class="lookbook-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-40 opacity-0">
                            <i class="bi bi-instagram fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col reveal stagger-2">
                    <div class="lookbook-grid-item rounded-3 overflow-hidden position-relative ratio ratio-1x1 bg-white border border-light-subtle">
                        <img src="<?php echo e(asset('img/shop_02.jpg')); ?>" class="w-100 h-100 object-fit-cover lookbook-img" alt="FashionTee Street Style" loading="lazy">
                        <div class="lookbook-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-40 opacity-0">
                            <i class="bi bi-instagram fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col reveal stagger-3">
                    <div class="lookbook-grid-item rounded-3 overflow-hidden position-relative ratio ratio-1x1 bg-white border border-light-subtle">
                        <img src="<?php echo e(asset('img/shop_03.jpg')); ?>" class="w-100 h-100 object-fit-cover lookbook-img" alt="FashionTee Street Style" loading="lazy">
                        <div class="lookbook-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-40 opacity-0">
                            <i class="bi bi-instagram fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col reveal stagger-4">
                    <div class="lookbook-grid-item rounded-3 overflow-hidden position-relative ratio ratio-1x1 bg-white border border-light-subtle">
                        <img src="<?php echo e(asset('img/shop_04.jpg')); ?>" class="w-100 h-100 object-fit-cover lookbook-img" alt="FashionTee Street Style" loading="lazy">
                        <div class="lookbook-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-40 opacity-0">
                            <i class="bi bi-instagram fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col reveal stagger-5 d-none d-lg-block">
                    <div class="lookbook-grid-item rounded-3 overflow-hidden position-relative ratio ratio-1x1 bg-white border border-light-subtle">
                        <img src="<?php echo e(asset('img/shop_05.jpg')); ?>" class="w-100 h-100 object-fit-cover lookbook-img" alt="FashionTee Street Style" loading="lazy">
                        <div class="lookbook-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-40 opacity-0">
                            <i class="bi bi-instagram fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. VIP NEWSLETTER CLUB (Gia Nhập Hội Viên) -->
    <section class="py-5 bg-white">
        <div class="container py-2">
            <div class="newsletter-card rounded-4 p-4 p-md-5 bg-light border border-light-subtle text-center position-relative overflow-hidden">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6 reveal">
                        <div class="rounded-circle bg-dark text-white p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                            <i class="bi bi-envelope-check fs-5"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-2 fs-4">Gia Nhập FashionTee Club</h3>
                        <p class="text-secondary fs-7 mb-4">
                            Đăng ký nhận thông báo để nhận ngay voucher giảm 10% cho đơn hàng đầu tiên cùng những ưu đãi đặc quyền dành riêng cho bạn.
                        </p>

                        <form id="newsletterHomeForm" class="d-flex flex-column flex-sm-row gap-2 justify-content-center" onsubmit="event.preventDefault(); window.handleNewsletterSubscribe(this);">
                            <input type="email" class="form-control rounded-3 px-3 py-2-5 fs-7 border-light-subtle shadow-xs" placeholder="Nhập địa chỉ email của bạn..." required autocomplete="email">
                            <button type="submit" class="btn btn-dark rounded-3 px-4 py-2-5 fs-7 fw-semibold text-nowrap btn-elevate">
                                Đăng ký nhận mã
                            </button>
                        </form>
                        <small class="text-muted fs-9 mt-2 d-block">Cam kết bảo mật thông tin • Có thể hủy đăng ký bất kỳ lúc nào</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- BACK TO TOP BUTTON -->
<button type="button" id="backToTopBtn" class="back-to-top-btn shadow-sm rounded-circle d-flex align-items-center justify-content-center pe-auto" aria-label="Cuộn lên đầu trang">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- AI CHATBOT WIDGET (Preserved 100% Logic, Redesigned Modern Minimalist) -->
<button class="ai-chat-toggle shadow-sm" id="aiChatToggle" type="button" aria-label="Mở trợ lý FashionTee AI">
    <i class="bi bi-chat-dots-fill"></i>
    <span class="d-none d-sm-inline ms-1">FashionTee AI</span>
</button>

<div class="ai-chat-box rounded-4 overflow-hidden border border-light-subtle shadow-lg" id="aiChatBox">
    <div class="ai-chat-header bg-dark text-white px-3 py-2-5 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-white text-dark p-1 d-flex align-items-center justify-content-center" style="width:26px;height:26px;">
                <i class="bi bi-robot fs-8"></i>
            </div>
            <div>
                <strong class="fs-7 d-block">FashionTee AI</strong>
                <span class="fs-9 text-white-50">Trợ lý tư vấn size & sản phẩm</span>
            </div>
        </div>
        <button type="button" id="aiChatClose" class="btn-close btn-close-white" aria-label="Đóng"></button>
    </div>
    <div class="ai-chat-body p-3 bg-light" id="aiChatBody">
        <div class="ai-msg bot">Xin chào! Mình là trợ lý FashionTee. Bạn cần tư vấn chọn size hay tìm mẫu áo nào hôm nay?</div>
    </div>
    <form class="ai-chat-form p-2-5 bg-white border-top border-light-subtle d-flex gap-2" id="aiChatForm">
        <input type="text" id="aiChatInput" class="form-control form-control-sm rounded-3 fs-7" placeholder="Nhập câu hỏi của bạn..." maxlength="1000" required autocomplete="off">
        <button type="submit" class="btn btn-dark btn-sm rounded-3 px-3">
            <i class="bi bi-send"></i>
        </button>
    </form>
</div>

<!-- TOAST CONTAINER FOR VOUCHER & WISHLIST -->
<div class="position-fixed bottom-0 start-50 translate-middle-x p-3 z-9999 pe-none" style="z-index: 1080;">
    <div id="homepageActionToast" class="toast align-items-center text-white bg-dark border-0 rounded-3 shadow-lg pe-auto" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 fs-8 py-2-5 px-3">
                <i id="homepageToastIcon" class="bi bi-check-circle-fill text-success fs-6"></i>
                <span id="homepageToastMsg">Đã sao chép mã ưu đãi!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
        </div>
    </div>
</div>

<!-- MOTION SYSTEM -->
<?php echo $__env->make('client.layout.motion-system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- HOMEPAGE STYLES (Minimalist Clean Tech-Retail) -->
<style>
    /* Global Typography Override for Ultra-Clean Editorial Feel */
    .homepage-wrapper, .fashion-marquee, .ai-chat-box, .ai-chat-toggle {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    /* Typography Utilities */
    .fs-7 { font-size: 0.875rem !important; }
    .fs-8 { font-size: 0.775rem !important; }
    .fs-9 { font-size: 0.7rem !important; }
    .py-1-5 { padding-top: 0.375rem !important; padding-bottom: 0.375rem !important; }
    .py-2-5 { padding-top: 0.625rem !important; padding-bottom: 0.625rem !important; }
    .p-1-5 { padding: 0.375rem !important; }
    .p-2-5 { padding: 0.625rem !important; }
    .gap-1-5 { gap: 0.375rem !important; }
    .gap-2-5 { gap: 0.625rem !important; }
    .fw-extrabold { font-weight: 800 !important; }
    .letter-spacing-wide { letter-spacing: 0.06em; }
    .tracking-wider { letter-spacing: 0.08em; }
    .backdrop-blur { backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); }
    .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .shadow-md { box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }

    /* Palette accents */
    .bg-emerald-light { background-color: #ecfdf5; }
    .bg-amber-light { background-color: #fffbeb; }
    .bg-blue-light { background-color: #eff6ff; }
    .bg-purple-light { background-color: #faf5ff; }
    .text-purple { color: #7e22ce; }

    /* Marquee Banner */
    .fashion-marquee {
        white-space: nowrap;
        user-select: none;
    }
    .fashion-marquee-inner {
        display: flex;
        width: max-content;
        animation: marqueeScroll 35s linear infinite;
    }
    .fashion-marquee:hover .fashion-marquee-inner {
        animation-play-state: paused;
    }
    .marquee-bullet {
        color: #64748b;
        font-size: 1.1rem;
    }
    @keyframes marqueeScroll {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* Hero Section */
    .hero-headline {
        line-height: 1.15;
        letter-spacing: -0.025em;
    }
    .text-gradient-dark {
        background: linear-gradient(135deg, #0f172a 0%, #475569 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero-pill-badge {
        background-color: #0f172a;
        color: #ffffff;
    }
    .pulse-live-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseLiveDot 2s infinite;
    }
    @keyframes pulseLiveDot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .hero-media-wrapper {
        transition: transform 0.4s ease;
    }
    .hero-img-zoom {
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .hero-media-wrapper:hover .hero-img-zoom {
        transform: scale(1.03);
    }
    .hero-float-chip {
        transition: transform 0.3s ease;
    }
    .hero-media-wrapper:hover .hero-float-chip {
        transform: translateY(-4px);
    }
    .hero-badge-float {
        backdrop-filter: blur(6px);
        background: rgba(15, 23, 42, 0.85);
    }

    .hero-carousel-btn {
        width: 46px;
        height: 46px;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        color: #0f172a;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.85;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .hero-carousel-btn:hover {
        background: #0f172a;
        color: #ffffff;
        opacity: 1;
        transform: translateY(-50%) scale(1.05);
    }
    .hero-carousel-btn--prev { left: 1.5rem; }
    .hero-carousel-btn--next { right: 1.5rem; }

    #homepageHeroCarousel .carousel-indicators [data-bs-target] {
        width: 24px;
        height: 3px;
        border-radius: 2px;
        background-color: #0f172a;
        opacity: 0.25;
        transition: all 0.25s ease;
        border: none;
    }
    #homepageHeroCarousel .carousel-indicators .active {
        width: 44px;
        opacity: 1;
        background-color: #0f172a;
    }

    /* Elevate Buttons */
    .btn-elevate {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    /* Value Proposition Cards */
    .value-prop-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .value-prop-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px -4px rgba(0,0,0,0.08);
        border-color: #cbd5e1 !important;
    }
    .value-prop-icon {
        width: 42px;
        height: 42px;
    }

    /* Coupon Tickets */
    .coupon-ticket {
        border-color: #cbd5e1 !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .coupon-ticket:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px -4px rgba(0,0,0,0.08);
        border-color: #0f172a !important;
    }
    .coupon-notch {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        background-color: #ffffff;
        border-radius: 50%;
        border: 1px solid #cbd5e1;
    }
    .coupon-notch-left {
        left: -8px;
        border-left: none;
    }
    .coupon-notch-right {
        right: -8px;
        border-right: none;
    }

    /* Category Cards */
    .category-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .category-card-link:hover .category-card {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px -6px rgba(0, 0, 0, 0.1);
    }
    .category-thumb-box {
        aspect-ratio: 4 / 5;
    }
    .category-thumb {
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .category-card-link:hover .category-thumb {
        transform: scale(1.06);
    }
    .category-arrow-circle {
        width: 32px;
        height: 32px;
        transition: all 0.25s ease;
    }
    .category-card-link:hover .category-arrow-circle {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #0f172a !important;
        transform: rotate(45deg);
    }

    /* Product Cards */
    .clean-product-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .clean-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -6px rgba(0,0,0,0.09) !important;
    }
    .clean-product-thumb-box {
        aspect-ratio: 3 / 4;
        background-color: #f8fafc;
    }
    .clean-product-thumb {
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .clean-product-card:hover .clean-product-thumb {
        transform: scale(1.06);
    }
    .quick-view-overlay-btn {
        transition: opacity 0.25s ease, transform 0.25s ease;
        transform: translate(-50%, 8px);
        font-weight: 500;
    }
    .clean-product-card:hover .quick-view-overlay-btn {
        opacity: 1 !important;
        transform: translate(-50%, 0);
    }
    .btn-wishlist {
        width: 30px;
        height: 30px;
        background: rgba(255, 255, 255, 0.9);
        color: #64748b;
        transition: all 0.2s ease;
        backdrop-filter: blur(4px);
    }
    .btn-wishlist:hover, .btn-wishlist.active {
        background: #ffffff;
        color: #ef4444;
        transform: scale(1.1);
    }
    .btn-wishlist.active i::before {
        content: "\F415"; /* bi-heart-fill */
    }

    /* Mini color swatches */
    .swatch-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 1px solid #cbd5e1;
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.45rem;
    }

    /* Ambient Glow on Brand Banner */
    .ambient-glow {
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(15, 23, 42, 0) 70%);
        pointer-events: none;
    }
    .bg-gradient-dark-bottom {
        background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0) 100%);
    }

    /* Segmented Pill Tabs */
    .showcase-pill-link {
        color: #64748b;
        background: transparent;
        transition: all 0.2s ease;
    }
    .showcase-pill-link:hover {
        color: #0f172a;
    }
    .showcase-pill-link.active {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    /* Reviews */
    .review-home-card {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .review-home-card:hover {
        border-color: #cbd5e1 !important;
        box-shadow: 0 8px 20px -4px rgba(0,0,0,0.06);
    }
    .review-home-avatar {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
    }
    .swiper-arrow-btn {
        width: 40px;
        height: 40px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #0f172a;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .swiper-arrow-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    /* Lookbook Instagram grid */
    .lookbook-img {
        transition: transform 0.5s ease;
    }
    .lookbook-grid-item:hover .lookbook-img {
        transform: scale(1.08);
    }
    .lookbook-overlay {
        transition: opacity 0.3s ease;
    }
    .lookbook-grid-item:hover .lookbook-overlay {
        opacity: 1 !important;
    }

    /* Back to Top Button */
    .back-to-top-btn {
        position: fixed;
        right: 22px;
        bottom: 78px;
        width: 42px;
        height: 42px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #0f172a;
        font-size: 1rem;
        z-index: 1030;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
    }
    .back-to-top-btn.show {
        opacity: 1;
        visibility: visible;
    }
    .back-to-top-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        transform: translateY(-3px);
    }

    /* AI Chat Widget */
    .ai-chat-toggle {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 1040;
        border: 1.5px solid #0f172a;
        border-radius: 999px;
        padding: 10px 18px;
        background: #0f172a;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.25s ease;
    }
    .ai-chat-toggle:hover {
        background: #1e293b;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
    }
    .ai-chat-box {
        position: fixed;
        right: 20px;
        bottom: 75px;
        width: min(92vw, 360px);
        max-height: 70vh;
        background: #fff;
        z-index: 1050;
        display: none;
    }
    .ai-chat-body {
        height: 340px;
        overflow-y: auto;
    }
    .ai-msg {
        margin-bottom: 8px;
        padding: 8px 12px;
        border-radius: 12px;
        max-width: 85%;
        font-size: 0.825rem;
        line-height: 1.45;
    }
    .ai-msg.user {
        margin-left: auto;
        background: #0f172a;
        color: #fff;
    }
    .ai-msg.bot {
        margin-right: auto;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
    }
</style>

<!-- HOMEPAGE JAVASCRIPT LOGIC -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Toast Notification Helper
        const toastEl = document.getElementById('homepageActionToast');
        const toastMsg = document.getElementById('homepageToastMsg');
        const toastIcon = document.getElementById('homepageToastIcon');
        const bsToast = toastEl ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

        function showHomepageToast(msg, iconClass = 'bi-check-circle-fill text-success') {
            if (!bsToast) return;
            if (toastMsg) toastMsg.textContent = msg;
            if (toastIcon) toastIcon.className = `bi ${iconClass} fs-6`;
            bsToast.show();
        }

        // 2. Copy Coupon Code to Clipboard
        document.querySelectorAll('.btn-copy-coupon').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                if (!code) return;

                navigator.clipboard.writeText(code).then(() => {
                    const originalHtml = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check2"></i> Đã chép';
                    this.classList.replace('btn-dark', 'btn-success');

                    showHomepageToast(`Đã sao chép mã ưu đãi "${code}"! Áp dụng ở giỏ hàng.`, 'bi-ticket-perforated-fill text-success');

                    setTimeout(() => {
                        this.innerHTML = originalHtml;
                        this.classList.replace('btn-success', 'btn-dark');
                    }, 2500);
                }).catch(() => {
                    showHomepageToast(`Mã ưu đãi của bạn: ${code}`, 'bi-info-circle-fill text-info');
                });
            });
        });

        // 3. Wishlist Heart Interaction with LocalStorage
        const savedWishlist = JSON.parse(localStorage.getItem('fashiontee_wishlist') || '[]');
        document.querySelectorAll('.btn-wishlist').forEach(function(btn) {
            const id = btn.getAttribute('data-id');
            if (savedWishlist.includes(id)) {
                btn.classList.add('active');
            }

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let list = JSON.parse(localStorage.getItem('fashiontee_wishlist') || '[]');
                const currentId = this.getAttribute('data-id');

                if (list.includes(currentId)) {
                    list = list.filter(item => item !== currentId);
                    this.classList.remove('active');
                    showHomepageToast('Đã xóa khỏi danh sách yêu thích', 'bi-heart text-secondary');
                } else {
                    list.push(currentId);
                    this.classList.add('active');
                    showHomepageToast('Đã lưu vào danh sách yêu thích!', 'bi-heart-fill text-danger');
                }
                localStorage.setItem('fashiontee_wishlist', JSON.stringify(list));
            });
        });

        // 4. Back to Top Button
        const backToTopBtn = document.getElementById('backToTopBtn');
        if (backToTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 350) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            });

            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // 5. Initialize Reviews Swiper
        if (typeof Swiper !== 'undefined') {
            new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                navigation: {
                    nextEl: ".swiper-next",
                    prevEl: ".swiper-prev",
                },
                breakpoints: {
                    640: { slidesPerView: 2, spaceBetween: 20 },
                    1024: { slidesPerView: 3, spaceBetween: 24 }
                }
            });
        }

        // 6. VIP Newsletter Submission
        window.handleNewsletterSubscribe = function(form) {
            const input = form.querySelector('input[type="email"]');
            if (!input || !input.value) return;

            showHomepageToast('Cảm ơn bạn! Mã voucher VIP10 đã được gửi đến email.', 'bi-gift-fill text-success');
            input.value = '';
        };

        // 7. AI Chatbot Logic (100% Preserved)
        (function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const toggleBtn = document.getElementById('aiChatToggle');
            const closeBtn = document.getElementById('aiChatClose');
            const chatBox = document.getElementById('aiChatBox');
            const chatBody = document.getElementById('aiChatBody');
            const chatForm = document.getElementById('aiChatForm');
            const chatInput = document.getElementById('aiChatInput');

            if (!toggleBtn || !chatBox) return;

            function appendMessage(type, text) {
                const msg = document.createElement('div');
                msg.className = 'ai-msg ' + type;
                msg.textContent = text;
                chatBody.appendChild(msg);
                chatBody.scrollTop = chatBody.scrollHeight;
            }

            toggleBtn.addEventListener('click', function() {
                const showing = chatBox.style.display === 'block';
                chatBox.style.display = showing ? 'none' : 'block';
                if (!showing && chatInput) {
                    chatInput.focus();
                }
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    chatBox.style.display = 'none';
                });
            }

            if (chatForm && chatInput) {
                chatForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const text = chatInput.value.trim();
                    if (!text) return;

                    appendMessage('user', text);
                    chatInput.value = '';
                    chatInput.disabled = true;
                    appendMessage('bot', 'Đang trả lời...');

                    try {
                        const response = await fetch("<?php echo e(route('chatbot.message')); ?>", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ message: text })
                        });

                        const data = await response.json();
                        const typingNode = chatBody.lastElementChild;
                        if (typingNode && typingNode.textContent === 'Đang trả lời...') {
                            typingNode.remove();
                        }

                        if (!response.ok || !data.status) {
                            appendMessage('bot', data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
                        } else {
                            appendMessage('bot', data.reply || 'Mình chưa có câu trả lời phù hợp.');
                        }
                    } catch (error) {
                        const typingNode = chatBody.lastElementChild;
                        if (typingNode && typingNode.textContent === 'Đang trả lời...') {
                            typingNode.remove();
                        }
                        appendMessage('bot', 'Không kết nối được máy chủ, vui lòng thử lại.');
                    } finally {
                        chatInput.disabled = false;
                        chatInput.focus();
                    }
                });
            }
        })();
    });
</script>

<?php echo $__env->make('client.layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('client.layout.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\client\Home.blade.php ENDPATH**/ ?>