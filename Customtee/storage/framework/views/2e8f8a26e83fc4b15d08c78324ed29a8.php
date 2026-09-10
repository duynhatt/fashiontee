<?php echo $__env->make('client.layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Main Product Detail Page Container -->
<div class="product-detail-page bg-white text-dark pb-5">

    <!-- Breadcrumb Navigation -->
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb product-breadcrumb mb-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(url('/')); ?>" class="text-decoration-none text-muted small">
                        <i class="bi bi-house-door me-1"></i>Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo e(url('/Shop')); ?>" class="text-decoration-none text-muted small">
                        <?php echo e($sanPham->category->ten_danh_muc ?? 'Sản phẩm'); ?>

                    </a>
                </li>
                <li class="breadcrumb-item active text-dark small fw-medium text-truncate" style="max-width: 280px;" aria-current="page">
                    <?php echo e($sanPham->ten_san_pham); ?>

                </li>
            </ol>
        </nav>
    </div>

    <!-- Product Hero Section -->
    <div class="container mt-2 mb-5">
        <div class="row g-4 g-lg-5">

            <!-- LEFT: Product Media Showcase -->
            <div class="col-12 col-lg-6">
                <div class="product-gallery-sticky">
                    <div class="product-media-wrapper gallery-entrance position-relative overflow-hidden rounded-4 bg-light border border-light-subtle">
                        <!-- Badges -->
                        <div class="position-absolute top-0 start-0 m-3 z-2 d-flex flex-column gap-2">
                            <span class="badge bg-dark text-white px-3 py-2 rounded-pill fw-normal fs-7 letter-spacing-wide">
                                Chính hãng
                            </span>
                            <?php if($totalStock > 0): ?>
                                <span class="badge bg-white text-success border border-success-subtle px-3 py-1-5 rounded-pill fw-medium fs-7 d-inline-flex align-items-center gap-1">
                                    <span class="stock-pulse-dot"></span> Còn hàng
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-1-5 rounded-pill fw-medium fs-7">
                                    Tạm hết hàng
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Zoom Action Button -->
                        <button type="button" class="btn btn-white position-absolute top-0 end-0 m-3 z-2 rounded-circle shadow-sm border p-2 d-flex align-items-center justify-content-center gallery-zoom-btn"
                                data-bs-toggle="modal" data-bs-target="#imageLightboxModal" title="Xem ảnh lớn">
                            <i class="bi bi-arrows-fullscreen text-dark fs-6"></i>
                        </button>

                        <!-- Main Image Frame -->
                        <div class="product-image-container ratio ratio-1x1 d-flex align-items-center justify-content-center">
                            <img src="<?php echo e(asset('storage/' . $sanPham->hinh_anh_chinh)); ?>"
                                 id="main-product-img"
                                 class="product-main-img w-100 h-100"
                                 alt="<?php echo e($sanPham->ten_san_pham); ?>"
                                 fetchpriority="high"
                                 decoding="async">
                        </div>
                    </div>

                    <!-- Micro Feature Tags below Image -->
                    <div class="row g-2 mt-3 text-center text-muted small">
                        <div class="col-4 reveal stagger-1">
                            <div class="py-2 px-1 rounded-3 bg-light border border-light-subtle d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-shield-check text-dark fs-6"></i>
                                <span class="text-truncate">100% Cotton</span>
                            </div>
                        </div>
                        <div class="col-4 reveal stagger-2">
                            <div class="py-2 px-1 rounded-3 bg-light border border-light-subtle d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-arrow-repeat text-dark fs-6"></i>
                                <span class="text-truncate">Đổi trả 3 ngày</span>
                            </div>
                        </div>
                        <div class="col-4 reveal stagger-3">
                            <div class="py-2 px-1 rounded-3 bg-light border border-light-subtle d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-truck text-dark fs-6"></i>
                                <span class="text-truncate">Ship hỏa tốc</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Product Info & Actions -->
            <div class="col-12 col-lg-6">
                <div class="product-info-panel ps-lg-2">

                    <!-- Category Kicker -->
                    <div class="text-uppercase text-muted fw-semibold fs-7 tracking-wider mb-2 info-entrance info-entrance-1">
                        <?php echo e($sanPham->category->ten_danh_muc ?? 'Thời trang nam nữ'); ?>

                    </div>

                    <!-- Title -->
                    <h1 class="product-title-heading fw-bold text-dark mb-2 info-entrance info-entrance-2">
                        <?php echo e($sanPham->ten_san_pham); ?>

                    </h1>

                    <!-- Rating & Reviews Metadata -->
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3 pb-1 info-entrance info-entrance-2">
                        <div class="d-flex align-items-center text-warning rating-stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <= floor($avgRating)): ?>
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                <?php elseif($i - $avgRating <= 0.5 && $i - $avgRating > 0): ?>
                                    <i class="bi bi-star-half text-warning me-1"></i>
                                <?php else: ?>
                                    <i class="bi bi-star text-black-50 me-1"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <span class="fw-semibold text-dark fs-7"><?php echo e($avgRating > 0 ? $avgRating : '5.0'); ?></span>
                        <span class="text-muted fs-7">/ 5</span>
                        <span class="text-muted fs-7">•</span>
                        <a href="#product-tabs-section" class="text-decoration-none text-muted fs-7 hover-underline" id="scroll-to-reviews">
                            <?php echo e($totalRating); ?> đánh giá từ khách hàng
                        </a>
                    </div>

                    <!-- Price Box -->
                    <div class="product-price-box p-3 rounded-3 bg-light border border-light-subtle mb-4 info-entrance info-entrance-3">
                        <div class="d-flex align-items-baseline flex-wrap gap-3">
                            <span class="product-current-price fw-extrabold text-dark" id="gia-hien-tai">
                                <?php echo e($priceRange); ?>

                            </span>
                            <span class="text-muted text-decoration-line-through fs-6 d-none" id="gia-goc"></span>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-7 fw-semibold d-none" id="phan-tram-giam"></span>
                        </div>
                        <div class="text-muted fs-8 mt-1">
                            <i class="bi bi-check2-circle text-success me-1"></i>Giá đã bao gồm VAT & chính sách bảo hành chính hãng
                        </div>
                    </div>

                    <!-- Short Description -->
                    <?php if($sanPham->mo_ta_ngan): ?>
                        <div class="product-short-desc text-secondary mb-4 info-entrance info-entrance-4">
                            <?php echo e($sanPham->mo_ta_ngan); ?>

                        </div>
                    <?php endif; ?>

                    <hr class="my-4 border-light-subtle">

                    <!-- VARIANT: Color Selector -->
                    <div class="product-option-group mb-4 info-entrance info-entrance-5">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold text-dark mb-0 fs-7">
                                Màu sắc: <span class="text-muted fw-normal" id="selected-color-label">Chưa chọn</span>
                            </label>
                        </div>
                        <div class="d-flex flex-wrap gap-2" id="color-options">
                            <?php $__currentLoopData = $sanPham->variants->unique('mau_sac_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button"
                                        class="color-btn btn d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2"
                                        data-color-id="<?php echo e($variant->mau_sac_id); ?>"
                                        data-color-name="<?php echo e($variant->color->ten_mau ?? ''); ?>"
                                        aria-label="Chọn màu <?php echo e($variant->color->ten_mau ?? ''); ?>">
                                    <span class="color-swatch-circle" style="background-color: <?php echo e($variant->color->ma_mau ?? '#000000'); ?>;"></span>
                                    <span class="color-btn-text fs-7"><?php echo e($variant->color->ten_mau); ?></span>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- VARIANT: Size Selector -->
                    <div class="product-option-group mb-4 info-entrance info-entrance-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold text-dark mb-0 fs-7">
                                Kích thước: <span class="text-muted fw-normal" id="selected-size-label">Chưa chọn</span>
                            </label>
                            <button type="button" class="btn btn-link text-decoration-none p-0 text-muted fs-7 d-inline-flex align-items-center gap-1 size-guide-link"
                                    data-bs-toggle="modal" data-bs-target="#sizeGuideModal">
                                <i class="bi bi-rulers"></i> Bảng hướng dẫn size
                            </button>
                        </div>
                        <div class="d-flex flex-wrap gap-2" id="size-options">
                            <?php $__currentLoopData = $sanPham->variants->unique('kich_thuoc_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button"
                                        class="size-btn btn rounded-3 px-3 py-2 fw-medium fs-7"
                                        data-size-id="<?php echo e($variant->kich_thuoc_id); ?>"
                                        data-size-name="<?php echo e($variant->size->ten_kich_thuoc ?? ''); ?>"
                                        aria-label="Kích thước <?php echo e($variant->size->ten_kich_thuoc ?? ''); ?>">
                                    <?php echo e($variant->size->ten_kich_thuoc); ?>

                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Quantity Stepper & Stock Status -->
                    <div class="product-quantity-group mb-4 info-entrance info-entrance-7">
                        <label class="form-label fw-semibold text-dark mb-2 fs-7">Số lượng:</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="quantity-stepper d-inline-flex align-items-center rounded-3 border border-secondary-subtle bg-white">
                                <button class="btn btn-link text-dark p-2 text-decoration-none stepper-btn" type="button" id="btn-decrease" aria-label="Giảm số lượng">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="form-control text-center border-0 p-0 fw-semibold quantity-input"
                                       id="quantity" min="1" value="1" max="999" aria-label="Số lượng">
                                <button class="btn btn-link text-dark p-2 text-decoration-none stepper-btn" type="button" id="btn-increase" aria-label="Tăng số lượng">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <div class="stock-status-wrapper">
                                <span class="text-muted fs-7" id="ton-kho-info">
                                    <?php if($totalStock > 0): ?>
                                        Còn <strong class="text-dark"><?php echo e($totalStock); ?></strong> sản phẩm
                                    <?php else: ?>
                                        <span class="text-danger fw-medium">Tạm hết hàng</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CTA BUTTONS (Mua ngay = Primary, Thêm vào giỏ = Secondary) -->
                    <div class="product-actions-group d-flex flex-column flex-sm-row gap-3 mb-4 pt-2 info-entrance info-entrance-7">
                        <!-- Buy Now: PRIMARY ACTION -->
                        <button class="btn btn-primary-dark btn-lg flex-grow-1 order-1 order-sm-2 d-flex align-items-center justify-content-center gap-2 py-3 px-4 rounded-3 shadow-none fw-semibold"
                                id="btn-buy-now">
                            <i class="bi bi-lightning-charge-fill"></i>
                            <span>Mua ngay</span>
                        </button>

                        <!-- Add to Cart: SECONDARY ACTION -->
                        <button class="btn btn-secondary-outline btn-lg flex-grow-1 order-2 order-sm-1 d-flex align-items-center justify-content-center gap-2 py-3 px-4 rounded-3 shadow-none fw-semibold"
                                id="btn-add-to-cart">
                            <i class="bi bi-bag-plus"></i>
                            <span>Thêm vào giỏ hàng</span>
                        </button>
                    </div>

                    <!-- Reassurance Checklist (Ecommerce Standard) -->
                    <div class="product-perks-box p-3 rounded-3 border border-light-subtle bg-light mt-4 info-entrance info-entrance-7">
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-secondary fs-7">
                                    <i class="bi bi-box-seam text-dark"></i>
                                    <span>Giao hàng toàn quốc từ 1-3 ngày</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-secondary fs-7">
                                    <i class="bi bi-arrow-counterclockwise text-dark"></i>
                                    <span>Đổi hàng tận nơi trong 3 ngày</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-secondary fs-7">
                                    <i class="bi bi-patch-check text-dark"></i>
                                    <span>Cam kết 100% hình thật tự chụp</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center gap-2 text-secondary fs-7">
                                    <i class="bi bi-credit-card-2-front text-dark"></i>
                                    <span>Thanh toán khi nhận (COD) hoặc VNPAY</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- STRUCTURED DETAILS & REVIEWS TABS (Phía dưới Hero) -->
    <div class="container my-5" id="product-tabs-section">
        <div class="product-tabs-wrapper rounded-4 border border-light-subtle bg-white overflow-hidden shadow-xs reveal">

            <!-- Nav Tabs Header -->
            <ul class="nav nav-tabs modern-tabs px-3 pt-2 bg-light border-bottom border-light-subtle" id="productDetailTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link modern-tab-link active fw-semibold text-dark py-3 px-4 border-0"
                            id="description-tab" data-bs-toggle="tab" data-bs-target="#description-pane"
                            type="button" role="tab" aria-controls="description-pane" aria-selected="true">
                        <i class="bi bi-text-paragraph me-2"></i>Mô tả sản phẩm
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link modern-tab-link fw-semibold text-muted py-3 px-4 border-0"
                            id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane"
                            type="button" role="tab" aria-controls="specs-pane" aria-selected="false">
                        <i class="bi bi-sliders me-2"></i>Thông số & Bảo quản
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link modern-tab-link fw-semibold text-muted py-3 px-4 border-0"
                            id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane"
                            type="button" role="tab" aria-controls="reviews-pane" aria-selected="false">
                        <i class="bi bi-star me-2"></i>Đánh giá từ khách hàng
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill ms-1"><?php echo e($totalRating); ?></span>
                    </button>
                </li>
            </ul>

            <!-- Tab Content Panes -->
            <div class="tab-content p-4 p-md-5" id="productDetailTabContent">

                <!-- TAB 1: Mô tả chi tiết -->
                <div class="tab-pane fade show active" id="description-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <h5 class="fw-bold text-dark mb-3">Thông tin chi tiết về sản phẩm</h5>
                            <?php if($sanPham->mo_ta_chi_tiet): ?>
                                <div class="product-editorial-content text-secondary lh-lg">
                                    <?php echo nl2br(e($sanPham->mo_ta_chi_tiet)); ?>

                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">Mẫu áo thun cao cấp thuộc bộ sưu tập mới nhất với chất liệu cotton thoáng mát, đường may tỉ mỉ và phong cách thiết kế hiện đại dễ dàng phối đồ hằng ngày.</p>
                            <?php endif; ?>

                            <div class="mt-4 p-4 rounded-3 bg-light border border-light-subtle">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-stars text-warning me-2"></i>Điểm nổi bật:</h6>
                                <ul class="text-secondary small mb-0 ps-3 lh-lg">
                                    <li>Chất liệu sợi dệt tự nhiên, xử lý bề mặt chống xù lông và thấm hút mồ hôi tối ưu.</li>
                                    <li>Đường kim mũi chỉ được may chần 2 kim chắc chắn, giữ form áo chuẩn sau nhiều lần giặt.</li>
                                    <li>Màu nhuộm an toàn cho da, giữ độ bền màu theo tiêu chuẩn xuất khẩu.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 mt-4 mt-lg-0">
                            <div class="p-4 rounded-3 bg-light border border-light-subtle h-100">
                                <h6 class="fw-bold text-dark mb-3">Tóm tắt sản phẩm</h6>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-3 fs-7">
                                    <li class="d-flex justify-content-between pb-2 border-bottom border-light-subtle">
                                        <span class="text-muted">Danh mục</span>
                                        <strong class="text-dark"><?php echo e($sanPham->category->ten_danh_muc ?? 'Thời trang'); ?></strong>
                                    </li>
                                    <li class="d-flex justify-content-between pb-2 border-bottom border-light-subtle">
                                        <span class="text-muted">Tình trạng</span>
                                        <span class="fw-semibold text-success"><?php echo e($totalStock > 0 ? 'Còn hàng' : 'Hết hàng'); ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between pb-2 border-bottom border-light-subtle">
                                        <span class="text-muted">Bảo hành / Đổi trả</span>
                                        <span class="text-dark">3 ngày nếu có lỗi</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="text-muted">Kiểu dáng</span>
                                        <span class="text-dark">Regular / Oversize</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Thông số & Hướng dẫn bảo quản -->
                <div class="tab-pane fade" id="specs-pane" role="tabpanel" aria-labelledby="specs-tab" tabindex="0">
                    <div class="row g-4">
                        <div class="col-12 col-lg-6">
                            <h5 class="fw-bold text-dark mb-3">Quy cách & Kỹ thuật may</h5>
                            <div class="table-responsive">
                                <table class="table table-clean table-sm align-middle fs-7 mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="text-muted fw-normal py-2" style="width: 35%;">Chất liệu</th>
                                            <td class="text-dark fw-medium py-2">100% Cotton Compact 2 chiều</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-normal py-2">Định lượng vải</th>
                                            <td class="text-dark fw-medium py-2">250 GSM - Dày dặn vừa phải, đứng form</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-normal py-2">Cổ áo</th>
                                            <td class="text-dark fw-medium py-2">Bo cổ dệt rib cao cấp dày 2.5cm, không giãn nhão</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-normal py-2">Công nghệ in</th>
                                            <td class="text-dark fw-medium py-2">In lụa / Kỹ thuật số sắc nét, chống nứt gãy</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted fw-normal py-2">Xuất xứ</th>
                                            <td class="text-dark fw-medium py-2">Sản xuất tại Việt Nam</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <h5 class="fw-bold text-dark mb-3">Hướng dẫn bảo quản chuẩn</h5>
                            <div class="p-3 rounded-3 bg-light border border-light-subtle">
                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <i class="bi bi-droplet text-primary fs-5 mt-1"></i>
                                    <div>
                                        <strong class="text-dark fs-7">Giặt ở nhiệt độ thường</strong>
                                        <p class="text-muted small mb-0">Khuyến khích lộn trái áo khi giặt máy và dùng túi giặt để giữ độ bền form.</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <i class="bi bi-sun text-warning fs-5 mt-1"></i>
                                    <div>
                                        <strong class="text-dark fs-7">Phơi nơi thoáng mát</strong>
                                        <p class="text-muted small mb-0">Tránh phơi trực tiếp dưới ánh nắng gay gắt để ngăn ngừa phai màu.</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3">
                                    <i class="bi bi-slash-circle text-danger fs-5 mt-1"></i>
                                    <div>
                                        <strong class="text-dark fs-7">Không ủi trực tiếp lên hình in</strong>
                                        <p class="text-muted small mb-0">Ủi ở nhiệt độ trung bình từ mặt trong hoặc phủ một lớp vải mỏng lên trên.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: Đánh giá từ khách hàng -->
                <div class="tab-pane fade" id="reviews-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">

                    <!-- Rating Summary Overview Card -->
                    <div class="review-overview-card p-4 rounded-3 bg-light border border-light-subtle mb-4 reveal">
                        <div class="row align-items-center g-4">
                            <!-- Average Rating Score -->
                            <div class="col-12 col-md-4 text-center border-end-md border-light-subtle">
                                <div class="display-4 fw-bold text-dark mb-1">
                                    <?php echo e($avgRating > 0 ? $avgRating : '5.0'); ?>

                                </div>
                                <div class="d-flex justify-content-center text-warning rating-stars mb-2">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= floor($avgRating)): ?>
                                            <i class="bi bi-star-fill text-warning me-1"></i>
                                        <?php elseif($i - $avgRating <= 0.5 && $i - $avgRating > 0): ?>
                                            <i class="bi bi-star-half text-warning me-1"></i>
                                        <?php else: ?>
                                            <i class="bi bi-star text-black-50 me-1"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="text-muted small">
                                    Dựa trên <strong><?php echo e($totalRating); ?></strong> nhận xét thực tế
                                </div>
                            </div>

                            <!-- Rating Distribution Progress Bars -->
                            <div class="col-12 col-md-8">
                                <div class="d-flex flex-column gap-2 px-md-3">
                                    <?php
                                        $bar5 = $totalRating > 0 ? min(100, max(15, round(($avgRating >= 4 ? 85 : 50)))) : 100;
                                        $bar4 = $totalRating > 0 ? 15 : 0;
                                        $bar3 = 0;
                                        $bar2 = 0;
                                        $bar1 = 0;
                                    ?>
                                    <div class="d-flex align-items-center gap-2 fs-8 text-muted">
                                        <span style="width: 45px;">5 sao</span>
                                        <div class="progress flex-grow-1 rounded-pill" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($bar5); ?>%;" aria-valuenow="<?php echo e($bar5); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span style="width: 35px;" class="text-end text-dark fw-medium"><?php echo e($bar5); ?>%</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 fs-8 text-muted">
                                        <span style="width: 45px;">4 sao</span>
                                        <div class="progress flex-grow-1 rounded-pill" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($bar4); ?>%;" aria-valuenow="<?php echo e($bar4); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span style="width: 35px;" class="text-end text-dark fw-medium"><?php echo e($bar4); ?>%</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 fs-8 text-muted">
                                        <span style="width: 45px;">3 sao</span>
                                        <div class="progress flex-grow-1 rounded-pill" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span style="width: 35px;" class="text-end text-dark fw-medium">0%</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 fs-8 text-muted">
                                        <span style="width: 45px;">2 sao</span>
                                        <div class="progress flex-grow-1 rounded-pill" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span style="width: 35px;" class="text-end text-dark fw-medium">0%</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 fs-8 text-muted">
                                        <span style="width: 45px;">1 sao</span>
                                        <div class="progress flex-grow-1 rounded-pill" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span style="width: 35px;" class="text-end text-dark fw-medium">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <?php if($danhGias->count() > 0): ?>
                        <div class="review-items-list d-flex flex-column gap-3">
                            <?php $__currentLoopData = $danhGias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="review-item-card p-3 p-md-4 rounded-3 border border-light-subtle bg-white reveal stagger-<?php echo e(min($loop->iteration, 5)); ?>">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Avatar Circle -->
                                            <div class="review-avatar rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold fs-7">
                                                <?php echo e(mb_substr($dg->user->name ?? 'K', 0, 1, 'UTF-8')); ?>

                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <strong class="text-dark fs-7"><?php echo e($dg->user->name ?? 'Khách hàng ẩn danh'); ?></strong>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0-5 fs-8 rounded-pill">
                                                        <i class="bi bi-check-circle-fill me-1"></i>Đã mua hàng
                                                    </span>
                                                </div>

                                                <?php if($dg->bienThe): ?>
                                                    <div class="text-muted fs-8 mt-0-5 d-flex align-items-center gap-2">
                                                        <span>Phân loại:</span>
                                                        <?php if($dg->bienThe->color): ?>
                                                            <span class="d-inline-flex align-items-center gap-1">
                                                                <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background-color:<?php echo e($dg->bienThe->color->ma_mau ?? '#ccc'); ?>;border:1px solid rgba(0,0,0,0.1);"></span>
                                                                <span><?php echo e($dg->bienThe->color->ten_mau); ?></span>
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if($dg->bienThe->size): ?>
                                                            <span>• Size <?php echo e($dg->bienThe->size->ten_kich_thuoc); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <span class="text-muted fs-8">
                                            <?php echo e($dg->created_at ? $dg->created_at->format('d/m/Y') : ''); ?>

                                        </span>
                                    </div>

                                    <!-- Review Stars -->
                                    <div class="text-warning fs-8 mb-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $dg->so_sao): ?>
                                                <i class="bi bi-star-fill text-warning me-0-5"></i>
                                            <?php else: ?>
                                                <i class="bi bi-star text-black-50 me-0-5"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>

                                    <!-- Content -->
                                    <p class="review-text text-secondary mb-0 fs-7 lh-base">
                                        <?php echo e($dg->noi_dung); ?>

                                    </p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-center">
                            <?php echo e($danhGias->links('pagination::bootstrap-5')); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="text-muted mb-2 fs-2"><i class="bi bi-chat-square-heart"></i></div>
                            <h6 class="fw-semibold text-dark">Chưa có đánh giá nào</h6>
                            <p class="text-muted fs-7 mb-0">Hãy là người đầu tiên trải nghiệm và chia sẻ cảm nhận về sản phẩm này!</p>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>
    </div>

    <!-- RELATED PRODUCTS SECTION (Sản phẩm cùng danh mục) -->
    <?php
        $relatedSlides = $sanPhamCungDanhMuc->chunk(4);
    ?>
    <?php if($sanPhamCungDanhMuc->isNotEmpty()): ?>
        <div class="container mt-5 pt-4">
            <div class="d-flex justify-content-between align-items-end mb-4 reveal">
                <div>
                    <span class="text-uppercase text-muted fs-8 fw-semibold tracking-wider d-block mb-1">Khám phá thêm</span>
                    <h3 class="fw-bold text-dark mb-0 fs-4">Sản phẩm có liên quan</h3>
                </div>

                <?php if($relatedSlides->count() > 1): ?>
                    <!-- Carousel Nav Minimalist Controls -->
                    <div class="d-flex align-items-center gap-2">
                        <button type="button"
                                class="btn related-nav-btn related-carousel-prev rounded-circle d-inline-flex align-items-center justify-content-center"
                                aria-controls="relatedCarouselViewport" aria-label="Xem nhóm trước" disabled>
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button"
                                class="btn related-nav-btn related-carousel-next rounded-circle d-inline-flex align-items-center justify-content-center"
                                aria-controls="relatedCarouselViewport" aria-label="Xem nhóm sau">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="related-carousel position-relative">
                <div class="related-carousel-viewport reveal reveal-scale" id="relatedCarouselViewport" role="region" aria-roledescription="carousel" tabindex="0">
                    <div class="related-carousel-track">
                        <?php $__currentLoopData = $relatedSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slideGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="related-carousel-slide flex-shrink-0">
                                <div class="row g-3 row-cols-2 row-cols-md-4">
                                    <?php $__currentLoopData = $slideGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spLienQuan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col">
                                            <div class="card clean-product-card h-100 border-0 rounded-3 overflow-hidden bg-transparent">
                                                <div class="clean-product-thumb-box position-relative rounded-3 overflow-hidden bg-light border border-light-subtle">
                                                    <a href="<?php echo e(route('sanpham.chitiet', $spLienQuan->slug)); ?>" class="d-block w-100 h-100">
                                                        <img class="clean-product-thumb w-100 h-100"
                                                             src="<?php echo e($spLienQuan->hinh_anh_chinh ? asset('storage/' . $spLienQuan->hinh_anh_chinh) : asset('img/shop_01.jpg')); ?>"
                                                             loading="lazy"
                                                             decoding="async"
                                                             alt="<?php echo e($spLienQuan->ten_san_pham); ?>">
                                                    </a>
                                                    <a href="<?php echo e(route('sanpham.chitiet', $spLienQuan->slug)); ?>"
                                                       class="quick-view-overlay-btn btn btn-dark btn-sm rounded-pill position-absolute bottom-0 start-50 translate-middle-x mb-3 opacity-0 text-nowrap px-3 shadow-sm">
                                                        Xem chi tiết
                                                    </a>
                                                </div>

                                                <div class="card-body p-2 pt-3 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <span class="text-muted fs-8 text-uppercase d-block mb-1"><?php echo e($spLienQuan->category->ten_danh_muc ?? 'Fashion'); ?></span>
                                                        <a href="<?php echo e(route('sanpham.chitiet', $spLienQuan->slug)); ?>"
                                                           class="clean-product-title text-decoration-none text-dark fw-medium d-block fs-7 mb-2 text-truncate-2">
                                                            <?php echo e($spLienQuan->ten_san_pham); ?>

                                                        </a>
                                                    </div>
                                                    <div class="clean-product-price fw-bold text-dark fs-7">
                                                        <?php if($spLienQuan->variants_min_gia): ?>
                                                            <?php echo e(number_format($spLienQuan->variants_min_gia, 0, ',', '.')); ?> ₫
                                                        <?php else: ?>
                                                            Liên hệ
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <?php if($relatedSlides->count() > 1): ?>
                    <div class="text-center text-muted small mt-3 related-carousel-counter">
                        <span class="related-carousel-current">1</span> / <span class="related-carousel-total"><?php echo e($relatedSlides->count()); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- LIGHTBOX MODAL (Xem ảnh lớn) -->
<div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-labelledby="imageLightboxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden bg-white">
            <div class="modal-header border-0 pb-0 justify-content-between">
                <h6 class="modal-title text-dark fw-semibold" id="imageLightboxModalLabel"><?php echo e($sanPham->ten_san_pham); ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-3 p-md-4 text-center">
                <img src="<?php echo e(asset('storage/' . $sanPham->hinh_anh_chinh)); ?>"
                     class="img-fluid rounded-3"
                     style="max-height: 80vh; object-fit: contain;"
                     alt="<?php echo e($sanPham->ten_san_pham); ?>">
            </div>
        </div>
    </div>
</div>

<!-- SIZE GUIDE MODAL (Bảng chọn size) -->
<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-dark text-white border-0 py-3 px-4">
                <h6 class="modal-title fw-semibold d-flex align-items-center gap-2" id="sizeGuideModalLabel">
                    <i class="bi bi-rulers"></i> Bảng hướng dẫn chọn size chuẩn (Size Chart)
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 bg-light rounded-3 border border-light-subtle mb-4">
                    <p class="text-secondary small mb-0">
                        <i class="bi bi-info-circle text-dark me-1"></i> Bảng thông số đo tiêu chuẩn theo form người Việt. Nếu bạn thích mặc phong cách rộng rãi hoặc oversize thoải mái, hãy cân nhắc chọn tăng thêm 1 size.
                    </p>
                </div>

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-lines-fill me-2"></i>1. Bảng quy đổi Chiều cao & Cân nặng</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover text-center align-middle mb-0 fs-7">
                        <thead class="table-light">
                            <tr>
                                <th>Size</th>
                                <th>Chiều cao (cm)</th>
                                <th>Cân nặng (kg)</th>
                                <th>Form áo gợi ý</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-dark px-3 py-1">S</span></td>
                                <td>1m50 - 1m60</td>
                                <td>45 - 53 kg</td>
                                <td>Vừa vặn (Regular)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-dark px-3 py-1">M</span></td>
                                <td>1m60 - 1m68</td>
                                <td>54 - 62 kg</td>
                                <td>Vừa vặn (Regular)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-dark px-3 py-1">L</span></td>
                                <td>1m68 - 1m75</td>
                                <td>63 - 72 kg</td>
                                <td>Thoải mái (Comfort)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-dark px-3 py-1">XL</span></td>
                                <td>1m75 - 1m82</td>
                                <td>73 - 82 kg</td>
                                <td>Thoải mái (Comfort)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-dark px-3 py-1">XXL</span></td>
                                <td>1m80 - 1m90</td>
                                <td>83 - 95 kg</td>
                                <td>Rộng rãi (Oversize)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-aspect-ratio me-2"></i>2. Thông số chi tiết sản phẩm (cm)</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover text-center align-middle mb-0 fs-7">
                        <thead class="table-light">
                            <tr>
                                <th>Size</th>
                                <th>Dài áo</th>
                                <th>Rộng ngực</th>
                                <th>Rộng vai</th>
                                <th>Dài tay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>S</strong></td>
                                <td>66 cm</td>
                                <td>48 cm</td>
                                <td>42 cm</td>
                                <td>20 cm</td>
                            </tr>
                            <tr>
                                <td><strong>M</strong></td>
                                <td>69 cm</td>
                                <td>51 cm</td>
                                <td>44 cm</td>
                                <td>21 cm</td>
                            </tr>
                            <tr>
                                <td><strong>L</strong></td>
                                <td>72 cm</td>
                                <td>54 cm</td>
                                <td>46 cm</td>
                                <td>22 cm</td>
                            </tr>
                            <tr>
                                <td><strong>XL</strong></td>
                                <td>75 cm</td>
                                <td>57 cm</td>
                                <td>48 cm</td>
                                <td>23 cm</td>
                            </tr>
                            <tr>
                                <td><strong>XXL</strong></td>
                                <td>77 cm</td>
                                <td>60 cm</td>
                                <td>50 cm</td>
                                <td>24 cm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 bg-light rounded-3 border border-light-subtle">
                    <strong class="text-dark small d-block mb-1"><i class="bi bi-lightbulb text-warning me-1"></i> Mẹo đo áo:</strong>
                    <ul class="text-muted small mb-0 ps-3">
                        <li><strong>Dài áo:</strong> Đo từ đỉnh vai xuôi thẳng xuống lai gấu áo.</li>
                        <li><strong>Rộng ngực:</strong> Đo ngang nách áo từ bên trái sang bên phải.</li>
                        <li>Nếu chiều cao ở size L nhưng cân nặng ở size M, hãy ưu tiên chọn theo <strong>chiều cao</strong> để áo không bị ngắn.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-2 px-4">
                <button type="button" class="btn btn-dark px-4 rounded-3 btn-sm" data-bs-dismiss="modal">Đã hiểu</button>
            </div>
        </div>
    </div>
</div>

<!-- MOBILE STICKY ACTION BAR (Thanh mua hàng cố định đáy màn hình di động) -->
<div class="mobile-sticky-bar d-md-none" id="mobileStickyBar">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2 overflow-hidden" style="max-width: 45%;">
            <div class="mobile-sticky-thumb rounded-2 overflow-hidden flex-shrink-0 bg-light border" style="width: 38px; height: 38px;">
                <img src="<?php echo e(asset('storage/' . $sanPham->hinh_anh_chinh)); ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?php echo e($sanPham->ten_san_pham); ?>">
            </div>
            <div class="text-truncate">
                <div class="fw-bold text-dark fs-7 text-truncate" id="mobile-sticky-price"><?php echo e($priceRange); ?></div>
                <div class="text-muted fs-8 text-truncate" id="mobile-sticky-variant-note">Chọn màu/size</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end">
            <button class="btn btn-outline-dark rounded-3 px-3 py-2 fs-7 d-flex align-items-center gap-1" id="mobile-btn-add-cart">
                <i class="bi bi-bag-plus"></i>
                <span class="d-none d-xs-inline">Thêm giỏ</span>
            </button>
            <button class="btn btn-dark rounded-3 px-3 py-2 fs-7 fw-semibold" id="mobile-btn-buy-now">
                Mua ngay
            </button>
        </div>
    </div>
</div>

<!-- MODERN MINIMALIST STYLES -->
<?php echo $__env->make('client.layout.motion-system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<style>
    /* Typography Utilities */
    .fs-7 { font-size: 0.875rem !important; }
    .fs-8 { font-size: 0.775rem !important; }
    .mt-0-5 { margin-top: 0.125rem !important; }
    .py-0-5 { padding-top: 0.125rem !important; padding-bottom: 0.125rem !important; }
    .py-1-5 { padding-top: 0.375rem !important; padding-bottom: 0.375rem !important; }
    .fw-extrabold { font-weight: 800 !important; }
    .letter-spacing-wide { letter-spacing: 0.05em; }
    .tracking-wider { letter-spacing: 0.08em; }
    .hover-underline:hover { text-decoration: underline !important; color: #0f172a !important; }

    /* Breadcrumbs */
    .product-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #cbd5e1;
        font-weight: 300;
        padding: 0 0.5rem;
    }

    /* Product Hero Media */
    .product-gallery-sticky {
        position: sticky;
        top: 90px;
    }

    .product-media-wrapper {
        border-radius: 16px !important;
        background-color: #f8fafc !important;
        transition: box-shadow 0.25s ease;
    }

    .product-media-wrapper:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .product-main-img {
        object-fit: contain;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        padding: 1.5rem;
    }

    .product-media-wrapper:hover .product-main-img {
        transform: scale(1.04);
    }

    .gallery-zoom-btn {
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        transition: transform 0.2s ease, background 0.2s ease;
    }

    .gallery-zoom-btn:hover {
        background: #ffffff;
        transform: scale(1.08);
    }

    .stock-pulse-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: #10b981;
        display: inline-block;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
    }

    /* Product Info Panel */
    .product-title-heading {
        font-size: 1.85rem;
        line-height: 1.25;
        letter-spacing: -0.02em;
        color: #0f172a;
    }

    @media (min-width: 992px) {
        .product-title-heading {
            font-size: 2.15rem;
        }
    }

    .product-price-box {
        background-color: #f8fafc;
    }

    .product-current-price {
        font-size: 1.85rem;
        letter-spacing: -0.01em;
        color: #0f172a;
    }

    /* Variant: Color Buttons */
    .color-btn {
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #1e293b;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .color-btn:hover:not(:disabled) {
        border-color: #0f172a;
        background-color: #f8fafc;
    }

    .color-btn.active {
        border-color: #0f172a !important;
        background-color: #0f172a !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
    }

    .color-swatch-circle {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.15);
    }

    .color-btn.active .color-swatch-circle {
        box-shadow: 0 0 0 2px #ffffff;
    }

    /* Variant: Size Buttons */
    .size-btn {
        min-width: 50px;
        height: 42px;
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #0f172a;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .size-btn:hover:not(:disabled) {
        border-color: #0f172a;
        background-color: #f8fafc;
    }

    .size-btn.active {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #0f172a !important;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
    }

    /* Out of stock variant state */
    .color-btn.is-out-of-stock,
    .size-btn.is-out-of-stock {
        opacity: 0.45 !important;
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
        border-style: dashed !important;
        cursor: not-allowed !important;
        position: relative;
    }

    .size-btn.is-out-of-stock::after {
        content: '';
        position: absolute;
        width: 70%;
        height: 1.5px;
        background-color: #ef4444;
        transform: rotate(-25deg);
        pointer-events: none;
    }

    /* Quantity Stepper */
    .quantity-stepper {
        width: 130px;
        height: 44px;
        border: 1.5px solid #e2e8f0 !important;
    }

    .quantity-stepper .stepper-btn {
        width: 38px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-size: 1rem;
        transition: background 0.15s ease;
    }

    .quantity-stepper .stepper-btn:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    .quantity-stepper .quantity-input {
        width: 50px;
        background: transparent;
        font-size: 0.95rem;
    }

    .quantity-stepper .quantity-input::-webkit-outer-spin-button,
    .quantity-stepper .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Purchase Action Buttons */
    .btn-primary-dark {
        background-color: #0f172a;
        border: 1.5px solid #0f172a;
        color: #ffffff;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-primary-dark:hover:not(:disabled) {
        background-color: #1e293b;
        border-color: #1e293b;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .btn-primary-dark:active {
        transform: translateY(0);
    }

    .btn-primary-dark:disabled {
        background-color: #94a3b8;
        border-color: #94a3b8;
        cursor: not-allowed;
    }

    .btn-secondary-outline {
        background-color: #ffffff;
        border: 1.5px solid #0f172a;
        color: #0f172a;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-secondary-outline:hover:not(:disabled) {
        background-color: #f8fafc;
        border-color: #0f172a;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .btn-secondary-outline:disabled {
        border-color: #cbd5e1;
        color: #94a3b8;
        cursor: not-allowed;
    }

    /* Segmented Modern Tabs */
    .modern-tabs {
        border-bottom: 1px solid #e2e8f0;
    }

    .modern-tab-link {
        color: #64748b !important;
        position: relative;
        background: transparent !important;
        transition: color 0.2s ease;
    }

    .modern-tab-link:hover {
        color: #0f172a !important;
    }

    .modern-tab-link.active {
        color: #0f172a !important;
        font-weight: 700 !important;
    }

    .modern-tab-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 1rem;
        right: 1rem;
        height: 2px;
        background-color: #0f172a;
    }

    .review-avatar {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
    }

    .review-item-card {
        transition: border-color 0.2s ease;
    }

    .review-item-card:hover {
        border-color: #cbd5e1 !important;
    }

    /* Related Products Carousel */
    .related-nav-btn {
        width: 38px;
        height: 38px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .related-nav-btn:hover:not(:disabled) {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    .related-nav-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .related-carousel-viewport {
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: 100%;
        scroll-snap-type: x mandatory;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        scrollbar-width: none;
        outline: none;
    }

    .related-carousel-viewport::-webkit-scrollbar {
        display: none;
    }

    .related-carousel-track {
        display: contents;
    }

    .related-carousel-slide {
        min-width: 0;
        scroll-snap-align: start;
        scroll-snap-stop: always;
        box-sizing: border-box;
    }

    .clean-product-thumb-box {
        aspect-ratio: 3 / 4;
    }

    .clean-product-thumb {
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .clean-product-card:hover .clean-product-thumb {
        transform: scale(1.05);
    }

    .quick-view-overlay-btn {
        transition: opacity 0.25s ease, transform 0.25s ease;
        transform: translate(-50%, 8px);
    }

    .clean-product-card:hover .quick-view-overlay-btn {
        opacity: 1 !important;
        transform: translate(-50%, 0);
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.5rem;
    }

    /* Mobile Sticky Bar */
    .mobile-sticky-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1040;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid #e2e8f0;
        box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.06);
        transform: translateY(100%);
        transition: transform 0.3s ease-in-out;
    }

    .mobile-sticky-bar.is-visible {
        transform: translateY(0);
    }

    @media (min-width: 768px) {
        .border-end-md {
            border-right: 1px solid #e2e8f0 !important;
        }
    }
</style>

<?php echo $__env->make('client.layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('client.layout.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $variantsForJs = $sanPham->variants->map(function($v) {
        return [
            'id'             => (int) $v->id,
            'mau_sac_id'     => (string) $v->mau_sac_id,
            'kich_thuoc_id'  => (string) $v->kich_thuoc_id,
            'so_luong'       => (int) $v->so_luong,
            'trang_thai'     => (bool) $v->trang_thai,
            'gia'            => (float) $v->gia,
            'gia_khuyen_mai' => $v->gia_khuyen_mai ? (float) $v->gia_khuyen_mai : null,
        ];
    })->values();
?>

<!-- JAVASCRIPT LOGIC (100% Preserved & Enhanced) -->
<script>
    (function() {
        if (typeof window.showClientToast === 'function') {
            return;
        }
        window.showClientToast = function(message, type) {
            if (message === undefined || message === null || String(message).trim() === '') {
                return;
            }
            type = type === 'error' ? 'error' : (type === 'warning' ? 'warning' : 'success');
            const el = document.createElement('div');
            el.className = 'custom-toast ' + type;
            el.setAttribute('role', 'alert');
            el.style.whiteSpace = 'pre-wrap';
            el.textContent = message;
            document.body.appendChild(el);
            const ms = type === 'error' ? 5200 : 4000;
            setTimeout(function() {
                el.classList.add('fade-out');
                function cleanup() {
                    el.removeEventListener('animationend', cleanup);
                    if (el.parentNode) {
                        el.remove();
                    }
                }
                el.addEventListener('animationend', cleanup);
                setTimeout(cleanup, 700);
            }, ms);
        };
    })();

    document.addEventListener('DOMContentLoaded', function() {
        const colorButtons = document.querySelectorAll('.color-btn');
        const sizeButtons = document.querySelectorAll('.size-btn');
        const giaHienTai = document.getElementById('gia-hien-tai');
        const giaGoc = document.getElementById('gia-goc');
        const phanTramGiam = document.getElementById('phan-tram-giam');
        const tonKhoInfo = document.getElementById('ton-kho-info');
        const addToCartBtn = document.getElementById('btn-add-to-cart');
        const buyNowBtn = document.getElementById('btn-buy-now');
        const quantityInput = document.getElementById('quantity');
        const selectedColorLabel = document.getElementById('selected-color-label');
        const selectedSizeLabel = document.getElementById('selected-size-label');

        // Mobile Sticky Bar elements
        const mobileStickyBar = document.getElementById('mobileStickyBar');
        const mobileStickyPrice = document.getElementById('mobile-sticky-price');
        const mobileStickyVariantNote = document.getElementById('mobile-sticky-variant-note');
        const mobileBtnAddCart = document.getElementById('mobile-btn-add-cart');
        const mobileBtnBuyNow = document.getElementById('mobile-btn-buy-now');

        const allVariants = <?php echo json_encode($variantsForJs); ?>;

        let selectedColor = null;
        let selectedSize = null;
        let selectedColorName = '';
        let selectedSizeName = '';
        let currentVariantId = null;
        let currentStock = null;

        function updateStockStates() {
            // Cập nhật trạng thái các nút Size theo Màu đã chọn
            sizeButtons.forEach(btn => {
                const sizeId = String(btn.dataset.sizeId);
                let hasStock = false;

                if (selectedColor) {
                    const variant = allVariants.find(v => String(v.mau_sac_id) === String(selectedColor) && String(v.kich_thuoc_id) === sizeId && v.trang_thai);
                    if (variant && variant.so_luong > 0) {
                        hasStock = true;
                    }
                } else {
                    hasStock = allVariants.some(v => String(v.kich_thuoc_id) === sizeId && v.trang_thai && v.so_luong > 0);
                }

                if (!hasStock) {
                    btn.classList.add('is-out-of-stock');
                    btn.setAttribute('title', 'Tạm hết hàng');
                    if (selectedSize === sizeId) {
                        btn.classList.remove('active');
                        selectedSize = null;
                        selectedSizeName = '';
                        if (selectedSizeLabel) selectedSizeLabel.textContent = 'Chưa chọn';
                    }
                } else {
                    btn.classList.remove('is-out-of-stock');
                    btn.removeAttribute('title');
                }
            });

            // Cập nhật trạng thái các nút Màu theo Size đã chọn
            colorButtons.forEach(btn => {
                const colorId = String(btn.dataset.colorId);
                let hasStock = false;

                if (selectedSize) {
                    const variant = allVariants.find(v => String(v.kich_thuoc_id) === String(selectedSize) && String(v.mau_sac_id) === colorId && v.trang_thai);
                    if (variant && variant.so_luong > 0) {
                        hasStock = true;
                    }
                } else {
                    hasStock = allVariants.some(v => String(v.mau_sac_id) === colorId && v.trang_thai && v.so_luong > 0);
                }

                if (!hasStock) {
                    btn.classList.add('is-out-of-stock');
                    btn.setAttribute('title', 'Tạm hết hàng');
                    if (selectedColor === colorId) {
                        btn.classList.remove('active');
                        selectedColor = null;
                        selectedColorName = '';
                        if (selectedColorLabel) selectedColorLabel.textContent = 'Chưa chọn';
                    }
                } else {
                    btn.classList.remove('is-out-of-stock');
                    btn.removeAttribute('title');
                }
            });
        }

        colorButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('is-out-of-stock')) {
                    showClientToast('Màu này tạm thời hết hàng với kích thước đã chọn.', 'warning');
                    return;
                }
                colorButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedColor = this.dataset.colorId;
                selectedColorName = this.dataset.colorName || '';
                if (selectedColorLabel) {
                    selectedColorLabel.textContent = selectedColorName;
                    selectedColorLabel.className = 'text-dark fw-semibold';
                }
                updateMobileStickyNote();
                updateStockStates();
                updateVariantInfo();
            });
        });

        sizeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('is-out-of-stock')) {
                    showClientToast('Kích thước này tạm thời hết hàng với màu sắc đã chọn.', 'warning');
                    return;
                }
                sizeButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedSize = this.dataset.sizeId;
                selectedSizeName = this.dataset.sizeName || '';
                if (selectedSizeLabel) {
                    selectedSizeLabel.textContent = selectedSizeName;
                    selectedSizeLabel.className = 'text-dark fw-semibold';
                }
                updateMobileStickyNote();
                updateStockStates();
                updateVariantInfo();
            });
        });

        function updateMobileStickyNote() {
            if (!mobileStickyVariantNote) return;
            if (selectedColorName && selectedSizeName) {
                mobileStickyVariantNote.textContent = `${selectedColorName} / ${selectedSizeName}`;
            } else if (selectedColorName) {
                mobileStickyVariantNote.textContent = `${selectedColorName} (chọn size)`;
            } else if (selectedSizeName) {
                mobileStickyVariantNote.textContent = `Size ${selectedSizeName} (chọn màu)`;
            } else {
                mobileStickyVariantNote.textContent = 'Chọn màu/size';
            }
        }

        updateStockStates();

        document.getElementById('btn-increase').addEventListener('click', () => {
            let qty = parseInt(quantityInput.value, 10) || 1;
            if (currentStock !== null) {
                qty = Math.min(qty + 1, currentStock);
            } else {
                qty = qty + 1;
            }
            quantityInput.value = qty;
        });

        document.getElementById('btn-decrease').addEventListener('click', () => {
            let qty = parseInt(quantityInput.value, 10) || 1;
            if (qty > 1) {
                quantityInput.value = qty - 1;
            }
        });

        quantityInput.addEventListener('change', () => {
            let qty = parseInt(quantityInput.value, 10) || 1;
            qty = Math.max(1, qty);
            if (currentStock !== null) {
                qty = Math.min(qty, currentStock);
            }
            quantityInput.value = qty;
        });

        function updateVariantInfo() {
            if (!selectedColor || !selectedSize) {
                currentVariantId = null;
                currentStock = null;
                giaHienTai.textContent = '<?php echo e($priceRange); ?>';
                if (mobileStickyPrice) mobileStickyPrice.textContent = '<?php echo e($priceRange); ?>';
                giaGoc.classList.add('d-none');
                phanTramGiam.classList.add('d-none');
                tonKhoInfo.innerHTML =
                    '<?php echo e($totalStock > 0 ? "Còn <strong class=\"text-dark\">$totalStock</strong> sản phẩm" : "<span class=\"text-danger fw-medium\">Hết hàng</span>"); ?>';
                quantityInput.disabled = false;
                addToCartBtn.disabled = false;
                buyNowBtn.disabled = false;
                return;
            }

            fetch(`/api/product-variant?product_id=<?php echo e($sanPham->id); ?>&color=${selectedColor}&size=${selectedSize}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.variant) {
                        currentVariantId = data.variant.id || null;
                        currentStock = parseInt(data.variant.so_luong, 10) || 0;
                        const giaBan = data.variant.gia_khuyen_mai || data.variant.gia;
                        const formattedPrice = new Intl.NumberFormat('vi-VN').format(giaBan) + ' ₫';
                        giaHienTai.textContent = formattedPrice;
                        if (mobileStickyPrice) mobileStickyPrice.textContent = formattedPrice;

                        if (data.variant.gia_khuyen_mai && data.variant.gia_khuyen_mai < data.variant.gia) {
                            giaGoc.textContent = new Intl.NumberFormat('vi-VN').format(data.variant.gia) + ' ₫';
                            const percent = Math.round(100 - (data.variant.gia_khuyen_mai / data.variant.gia * 100));
                            phanTramGiam.textContent = `-${percent}%`;
                            giaGoc.classList.remove('d-none');
                            phanTramGiam.classList.remove('d-none');
                        } else {
                            giaGoc.classList.add('d-none');
                            phanTramGiam.classList.add('d-none');
                        }

                        if (currentStock > 0) {
                            tonKhoInfo.innerHTML = `Còn <strong class="text-dark">${currentStock}</strong> sản phẩm`;
                        } else {
                            tonKhoInfo.innerHTML = `<span class="text-danger fw-medium">Tạm hết hàng</span>`;
                        }

                        quantityInput.max = currentStock > 0 ? currentStock : 999;
                        if (currentStock <= 0) {
                            quantityInput.value = 0;
                            quantityInput.disabled = true;
                            addToCartBtn.disabled = true;
                            buyNowBtn.disabled = true;
                        } else {
                            if (parseInt(quantityInput.value, 10) < 1) {
                                quantityInput.value = 1;
                            }
                            if (parseInt(quantityInput.value, 10) > currentStock) {
                                quantityInput.value = currentStock;
                            }
                            quantityInput.disabled = false;
                            addToCartBtn.disabled = false;
                            buyNowBtn.disabled = false;
                        }
                    } else {
                        currentVariantId = null;
                        currentStock = null;
                        giaHienTai.textContent = 'Hết hàng';
                        if (mobileStickyPrice) mobileStickyPrice.textContent = 'Hết hàng';
                        tonKhoInfo.innerHTML = '<span class="text-danger fw-medium">Hết hàng</span>';
                        giaGoc.classList.add('d-none');
                        phanTramGiam.classList.add('d-none');
                        quantityInput.value = 0;
                        quantityInput.disabled = true;
                        addToCartBtn.disabled = true;
                        buyNowBtn.disabled = true;
                    }
                })
                .catch(() => {
                    giaHienTai.textContent = 'Lỗi tải giá';
                });
        }

        // Check URL parameters for pre-selected color/size
        const params = new URLSearchParams(window.location.search);
        const preColorId = params.get('color_id');
        const preSizeId = params.get('size_id');
        if (preColorId && preSizeId) {
            selectedColor = preColorId;
            selectedSize = preSizeId;

            colorButtons.forEach(btn => {
                const isActive = btn.dataset.colorId == preColorId;
                btn.classList.toggle('active', isActive);
                if (isActive && selectedColorLabel) {
                    selectedColorName = btn.dataset.colorName || '';
                    selectedColorLabel.textContent = selectedColorName;
                    selectedColorLabel.className = 'text-dark fw-semibold';
                }
            });

            sizeButtons.forEach(btn => {
                const isActive = btn.dataset.sizeId == preSizeId;
                btn.classList.toggle('active', isActive);
                if (isActive && selectedSizeLabel) {
                    selectedSizeName = btn.dataset.sizeName || '';
                    selectedSizeLabel.textContent = selectedSizeName;
                    selectedSizeLabel.className = 'text-dark fw-semibold';
                }
            });

            updateMobileStickyNote();
            updateVariantInfo();
        }

        // Handle Add to Cart
        function handleAddToCart() {
            if (!selectedColor || !selectedSize) {
                showClientToast('Vui lòng chọn màu sắc và kích thước!', 'warning');
                scrollToOptions();
                return;
            }
            if (!currentVariantId) {
                showClientToast('Vui lòng chọn lại màu và kích thước.', 'warning');
                return;
            }
            let qty = parseInt(quantityInput.value, 10) || 1;
            qty = Math.max(1, qty);
            if (currentStock !== null && qty > currentStock) {
                showClientToast('Số lượng tối đa có thể mua là ' + currentStock, 'warning');
                qty = currentStock;
            }
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                showClientToast('Phiên đăng nhập hết hạn. Vui lòng tải lại trang.', 'error');
                return;
            }

            addToCartBtn.disabled = true;
            if (mobileBtnAddCart) mobileBtnAddCart.disabled = true;

            fetch('<?php echo e(route('gio-hang.store')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    san_pham_id: <?php echo e($sanPham->id); ?>,
                    bien_the_id: currentVariantId,
                    so_luong: qty
                })
            })
            .then(async r => {
                if (r.status === 401) {
                    window.location.href = '<?php echo e(url('/login')); ?>';
                    return;
                }
                const data = await r.json();
                if (!data) return;
                if (r.ok && data.success) {
                    showClientToast(data.message || 'Đã thêm vào giỏ hàng!', 'success');
                    if (window.MotionSystem) {
                        window.MotionSystem.triggerCartSuccessFlash(document.getElementById('btn-add-to-cart'));
                        window.MotionSystem.triggerCartSuccessFlash(document.getElementById('mobile-btn-add-cart'));
                    }
                    if (data.cart_count !== undefined && typeof window.updateCartBadgeCount === 'function') {
                        window.updateCartBadgeCount(data.cart_count);
                    }
                    if (typeof window.openMiniCartDrawer === 'function') {
                        window.openMiniCartDrawer();
                    }
                } else {
                    const errors = data.errors ? Object.values(data.errors).flat() : [];
                    const msg = errors.length ? errors.join('\n') : (data.message || 'Có lỗi xảy ra.');
                    showClientToast(msg, 'error');
                }
            })
            .catch(() => showClientToast('Có lỗi xảy ra. Vui lòng thử lại.', 'error'))
            .finally(() => {
                addToCartBtn.disabled = false;
                if (mobileBtnAddCart) mobileBtnAddCart.disabled = false;
            });
        }

        // Handle Buy Now
        function handleBuyNow() {
            if (!selectedColor || !selectedSize) {
                showClientToast('Vui lòng chọn màu sắc và kích thước!', 'warning');
                scrollToOptions();
                return;
            }
            if (!currentVariantId) {
                showClientToast('Vui lòng chọn lại màu và kích thước.', 'warning');
                return;
            }
            let qty = parseInt(quantityInput.value, 10) || 1;
            qty = Math.max(1, qty);
            if (currentStock !== null && qty > currentStock) {
                showClientToast('Số lượng tối đa có thể mua là ' + currentStock, 'warning');
                qty = currentStock;
            }
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                showClientToast('Phiên đăng nhập hết hạn. Vui lòng tải lại trang.', 'error');
                return;
            }

            buyNowBtn.disabled = true;
            if (mobileBtnBuyNow) mobileBtnBuyNow.disabled = true;

            fetch('<?php echo e(route('buy-now')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    san_pham_id: <?php echo e($sanPham->id); ?>,
                    bien_the_id: currentVariantId,
                    so_luong: qty
                })
            })
            .then(async r => {
                if (r.status === 401) {
                    window.location.href = '<?php echo e(url('/login')); ?>';
                    return;
                }
                const data = await r.json();
                if (!data) return;
                if (r.ok && data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    const errors = data.errors ? Object.values(data.errors).flat() : [];
                    const msg = errors.length ? errors.join('\n') : (data.message || 'Có lỗi xảy ra.');
                    showClientToast(msg, 'error');
                }
            })
            .catch(() => showClientToast('Có lỗi xảy ra. Vui lòng thử lại.', 'error'))
            .finally(() => {
                buyNowBtn.disabled = false;
                if (mobileBtnBuyNow) mobileBtnBuyNow.disabled = false;
            });
        }

        function scrollToOptions() {
            const el = document.getElementById('color-options');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        addToCartBtn.addEventListener('click', handleAddToCart);
        buyNowBtn.addEventListener('click', handleBuyNow);

        if (mobileBtnAddCart) mobileBtnAddCart.addEventListener('click', handleAddToCart);
        if (mobileBtnBuyNow) mobileBtnBuyNow.addEventListener('click', handleBuyNow);

        // Smooth scroll to reviews tab
        const scrollToReviewsBtn = document.getElementById('scroll-to-reviews');
        if (scrollToReviewsBtn) {
            scrollToReviewsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const reviewsTab = document.getElementById('reviews-tab');
                if (reviewsTab) {
                    const tabInstance = new bootstrap.Tab(reviewsTab);
                    tabInstance.show();
                }
                const tabsSection = document.getElementById('product-tabs-section');
                if (tabsSection) {
                    tabsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }

        // Mobile Sticky Bar scroll watcher
        if (mobileStickyBar) {
            const mainActionButtons = document.querySelector('.product-actions-group');
            if (mainActionButtons) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting && entry.boundingClientRect.top < 0) {
                            mobileStickyBar.classList.add('is-visible');
                        } else {
                            mobileStickyBar.classList.remove('is-visible');
                        }
                    });
                }, { threshold: 0.1 });
                observer.observe(mainActionButtons);
            }
        }

        // Related Products Carousel (Smooth & Accessible)
        (function initRelatedCarousel() {
            const viewport = document.getElementById('relatedCarouselViewport');
            const prevBtn = document.querySelector('.related-carousel-prev');
            const nextBtn = document.querySelector('.related-carousel-next');
            const slides = viewport ? viewport.querySelectorAll('.related-carousel-slide') : [];
            const currentEl = document.querySelector('.related-carousel-current');
            const totalEl = document.querySelector('.related-carousel-total');

            if (!viewport || slides.length === 0 || !prevBtn || !nextBtn) {
                return;
            }

            function slideWidth() {
                return viewport.clientWidth;
            }

            function maxScrollLeft() {
                return Math.max(0, viewport.scrollWidth - viewport.clientWidth);
            }

            function updateRelatedNav() {
                const maxS = maxScrollLeft();
                const left = viewport.scrollLeft;
                prevBtn.disabled = left <= 4;
                nextBtn.disabled = left >= maxS - 4;

                const w = slideWidth();
                const idx = w > 0 ? Math.min(slides.length, Math.max(1, Math.round(left / w) + 1)) : 1;
                if (currentEl) {
                    currentEl.textContent = String(idx);
                }
                if (totalEl && slides.length) {
                    totalEl.textContent = String(slides.length);
                }
            }

            function scrollByOne(dir) {
                viewport.scrollBy({
                    left: dir * slideWidth(),
                    behavior: 'smooth'
                });
            }

            prevBtn.addEventListener('click', function() {
                scrollByOne(-1);
            });
            nextBtn.addEventListener('click', function() {
                scrollByOne(1);
            });

            viewport.addEventListener('scroll', function() {
                window.requestAnimationFrame(updateRelatedNav);
            }, { passive: true });

            viewport.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    scrollByOne(-1);
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    scrollByOne(1);
                }
            });

            window.addEventListener('resize', function() {
                window.requestAnimationFrame(updateRelatedNav);
            });

            updateRelatedNav();
        })();
    });
</script>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/client/productdetail.blade.php ENDPATH**/ ?>