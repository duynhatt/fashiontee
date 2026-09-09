<?php echo $__env->make('client.layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container my-4">
    <nav aria-label="breadcrumb" class="product-breadcrumb">
        <ol class="breadcrumb bg-transparent px-0 mb-0">
            <li class="breadcrumb-item">
                <a href="<?php echo e(url('/')); ?>" class="text-decoration-none">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(url('/Shop')); ?>" class="text-decoration-none">
                    <?php echo e($sanPham->category->ten_danh_muc ?? 'Danh mục'); ?>

                </a>
            </li>
            <li class="breadcrumb-item active fw-semibold text-dark" aria-current="page"><?php echo e($sanPham->ten_san_pham); ?>

            </li>
        </ol>
    </nav>
</div>

<div class="container my-5">
    <div class="row g-5">

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="ratio ratio-1x1 bg-light product-main-media">
                    <img src="<?php echo e(asset('storage/' . $sanPham->hinh_anh_chinh)); ?>" class="product-main-img w-100 h-100"
                        width="800" height="800" style="object-fit: contain;" alt="<?php echo e($sanPham->ten_san_pham); ?>"
                        fetchpriority="high" decoding="async">
                </div>
            </div>
            <!-- Album -->
        </div>

        <div class="col-lg-7">
            <h1 class="fw-bold mb-2"><?php echo e($sanPham->ten_san_pham); ?></h1>

            <div class="mb-3 d-flex align-items-center">
                <div class="text-warning me-2 fs-5">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= floor($avgRating)): ?>
                            ★
                        <?php else: ?>
                            ☆
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <span class="text-muted">
                    <?php echo e($avgRating); ?>/5 (<?php echo e($totalRating); ?> đánh giá)
                </span>
            </div>

            <div class="mb-4">
                <h3 class="d-inline fw-bold text-danger me-3" id="gia-hien-tai">
                    <?php echo e($priceRange); ?>

                </h3>

                <span class="text-muted text-decoration-line-through fs-5 d-none" id="gia-goc"></span>
                <span class="badge bg-danger ms-2 d-none" id="phan-tram-giam"></span>
            </div>

            <p class="text-secondary mb-4 lead" style="word-break: break-word;">
                <?php echo e($sanPham->mo_ta_ngan); ?>

            </p>

            <div class="mb-4">
                <label class="fw-semibold d-block mb-2">Màu sắc:</label>
                <div class="d-flex flex-wrap gap-2" id="color-options">
                    <?php $__currentLoopData = $sanPham->variants->unique('mau_sac_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" class="btn btn-outline-secondary btn-sm color-btn rounded-pill px-3 d-inline-flex align-items-center gap-2"
                            data-color-id="<?php echo e($variant->mau_sac_id); ?>"
                            data-color-name="<?php echo e($variant->color->ten_mau ?? ''); ?>">
                            <span class="color-swatch-dot" style="background-color: <?php echo e($variant->color->ma_mau ?? '#ccc'); ?>;"></span>
                            <span><?php echo e($variant->color->ten_mau); ?></span>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="fw-semibold mb-0">Kích thước:</label>
                    <button type="button" class="btn btn-link p-0 text-success text-decoration-none small d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#sizeGuideModal">
                        <i class="bi bi-rulers"></i> Hướng dẫn chọn size
                    </button>
                </div>
                <div class="d-flex flex-wrap gap-2" id="size-options">
                    <?php $__currentLoopData = $sanPham->variants->unique('kich_thuoc_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" class="btn btn-outline-secondary btn-sm size-btn px-3"
                            data-size-id="<?php echo e($variant->kich_thuoc_id); ?>"
                            data-size-name="<?php echo e($variant->size->ten_kich_thuoc ?? ''); ?>">
                            <?php echo e($variant->size->ten_kich_thuoc); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mb-4">
                <label class="fw-semibold me-3">Số lượng:</label>
                <div class="input-group w-50 w-md-25">
                    <button class="btn btn-outline-secondary" type="button" id="btn-decrease">-</button>
                    <input type="number" class="form-control text-center" id="quantity" min="1" value="1"
                        max="999">
                    <button class="btn btn-outline-secondary" type="button" id="btn-increase">+</button>
                </div>
                <small class="text-muted d-block mt-2" id="ton-kho-info">
                    <?php if($totalStock > 0): ?>
                        Còn <?php echo e($totalStock); ?> sản phẩm (tổng tất cả)
                    <?php else: ?>
                        Hết hàng
                    <?php endif; ?>
                </small>
            </div>

            <div class="d-flex flex-wrap gap-3 mb-4">
                <button class="btn btn-success btn-lg px-5" id="btn-add-to-cart">
                    <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ hàng
                </button>

                <button class="btn btn-outline-danger btn-lg px-5" id="btn-buy-now">
                    <i class="fas fa-bolt me-2"></i> Mua ngay
                </button>
            </div>

            <div class="border-top pt-4">
                <h5 class="mb-3">Thông tin sản phẩm</h5>
                <div class="row g-3">
                    <div class="col-6 col-md-4">
                        <strong>Danh mục:</strong><br>
                        <?php echo e($sanPham->category->ten_danh_muc ?? '—'); ?>

                    </div>
                    <div class="col-6 col-md-4">
                        <strong>Tình trạng:</strong><br>
                        <span class="text-success"><?php echo e($totalStock > 0 ? 'Còn hàng' : 'Hết hàng'); ?></span>
                    </div>
                    <div class="col-6 col-md-4">
                        <strong>đổi trả:</strong><br>
                         3 ngày nếu có lỗi
                    </div>
                </div>
            </div>
            <style>
                .product-description {
                    white-space: normal;
                    word-break: break-word;
                    overflow-wrap: break-word;

                }
            </style>
            <?php if($sanPham->mo_ta_chi_tiet): ?>
                <div class="mt-5">
                    <h5 class="mb-3">Mô tả chi tiết</h5>
                    <div class="product-description">
                        <?php echo nl2br(e($sanPham->mo_ta_chi_tiet)); ?>

                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-5">
                <h4 class="fw-bold mb-4">Đánh giá sản phẩm</h4>

                <?php if($danhGias->count() > 0): ?>

                    <?php $__currentLoopData = $danhGias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border rounded p-3 mb-3 shadow-sm">

                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <strong><?php echo e($dg->user->name ?? 'Khách hàng'); ?></strong>
                                    <?php if($dg->bienThe): ?>
                                        <div class="small text-muted d-flex align-items-center gap-1">
                                            <?php if($dg->bienThe->color): ?>
                                                <span class="border rounded"
                                                    style="width:14px;height:14px;background-color:<?php echo e($dg->bienThe->color->ma_mau ?? '#ccc'); ?>;"></span>
                                                <span><?php echo e($dg->bienThe->color->ten_mau ?? '—'); ?></span>
                                            <?php endif; ?>
                                            <?php if($dg->bienThe->size): ?>
                                                <span>/ <?php echo e($dg->bienThe->size->ten_kich_thuoc); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <small class="text-muted">
                                    <?php echo e($dg->created_at->format('d/m/Y')); ?>

                                </small>
                            </div>

                            
                            <div class="text-warning mb-2">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= $dg->so_sao): ?>
                                        ⭐
                                    <?php else: ?>
                                        ☆
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>

                            <p class="mb-0 text-secondary">
                                <?php echo e($dg->noi_dung); ?>

                            </p>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <div class="mt-4">
                        <?php echo e($danhGias->links('pagination::bootstrap-5')); ?>

                    </div>
                <?php else: ?>
                    <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>

                <?php endif; ?>
            </div>

        </div>
    </div>

    <?php
        $relatedSlides = $sanPhamCungDanhMuc->chunk(4);
    ?>
    <?php if($sanPhamCungDanhMuc->isNotEmpty()): ?>
        <div class="row mt-5 pt-4 border-top">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Sản phẩm có liên quan</h4>
                    </div>
                </div>
                <div class="related-carousel d-flex align-items-center gap-2 gap-md-3">
                    <button type="button"
                        class="btn related-carousel-nav related-carousel-prev flex-shrink-0 rounded-circle p-2 p-md-3 shadow-sm"
                        aria-controls="relatedCarouselViewport" aria-label="Xem nhóm trước" disabled>
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <div class="related-carousel-viewport flex-grow-1" id="relatedCarouselViewport" role="region"
                        aria-roledescription="carousel" aria-label="Sản phẩm cùng danh mục" tabindex="0">
                        <div class="related-carousel-track">
                            <?php $__currentLoopData = $relatedSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slideGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="related-carousel-slide flex-shrink-0">
                                    <div class="row g-3 row-cols-2 row-cols-md-4">
                                        <?php $__currentLoopData = $slideGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spLienQuan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col">
                                                <div
                                                    class="card product-wap related-product-card h-100 border-0 shadow-sm">
                                                    <div class="card border-0">
                                                        <a href="<?php echo e(route('sanpham.chitiet', $spLienQuan->slug)); ?>"
                                                            class="d-block related-product-img-link">
                                                            <img class="card-img rounded-0 related-product-thumb"
                                                                src="<?php echo e($spLienQuan->hinh_anh_chinh ? asset('storage/' . $spLienQuan->hinh_anh_chinh) : asset('img/shop_01.jpg')); ?>"
                                                                width="400" height="533" loading="lazy"
                                                                decoding="async"
                                                                alt="<?php echo e($spLienQuan->ten_san_pham); ?>">
                                                        </a>
                                                        <div
                                                            class="card-img-overlay product-overlay d-flex align-items-center justify-content-center">
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <a class="btn btn-success text-white"
                                                                        href="<?php echo e(route('sanpham.chitiet', $spLienQuan->slug)); ?>"
                                                                        title="Xem chi tiết">
                                                                        <i class="far fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-body py-3 px-3">
                                                        <a href="<?php echo e(route('sanpham.chitiet', $spLienQuan->slug)); ?>"
                                                            class="h6 text-decoration-none product-title d-block text-dark small mb-2">
                                                            <?php echo e($spLienQuan->ten_san_pham); ?>

                                                        </a>
                                                        <p class="mb-0 text-success fw-semibold small related-price">
                                                            <?php if($spLienQuan->variants_min_gia): ?>
                                                                <?php echo e(number_format($spLienQuan->variants_min_gia, 0, ',', '.')); ?>

                                                                đ
                                                            <?php else: ?>
                                                                Liên hệ
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <button type="button"
                        class="btn related-carousel-nav related-carousel-next flex-shrink-0 rounded-circle p-2 p-md-3 shadow-sm"
                        aria-controls="relatedCarouselViewport" aria-label="Xem nhóm sau"
                        <?php if($relatedSlides->count() <= 1): ?> disabled <?php endif; ?>>
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
                <?php if($relatedSlides->count() > 1): ?>
                    <p class="text-center text-muted small mt-3 mb-0 related-carousel-counter" aria-live="polite">
                        <span class="related-carousel-current">1</span> / <span
                            class="related-carousel-total"><?php echo e($relatedSlides->count()); ?></span>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .product-wap {
        display: flex;
        flex-direction: column;
    }

    .product-wap .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-wap .product-title {
        min-height: 48px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-product-card {
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .related-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12) !important;
    }

    /* Grid: mỗi slide = 100% khung ngay từ đầu, tránh ảnh bung kích thước gốc trước khi JS chạy */
    .related-carousel-viewport {
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: 100%;
        grid-auto-rows: minmax(0, auto);
        align-items: start;
        scroll-snap-type: x mandatory;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        outline: none;
    }

    .related-carousel-viewport::-webkit-scrollbar {
        height: 6px;
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

    .related-product-img-link {
        position: relative;
        overflow: hidden;
        aspect-ratio: 3 / 4;
        background-color: #f8f9fa;
        border-bottom: 1px solid #edf0f2;
    }

    .related-product-thumb {
        width: 100%;
        height: 100%;
        max-width: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.35s ease;
    }

    .related-product-card:hover .related-product-thumb {
        transform: scale(1.04);
    }

    .related-price {
        font-size: 15px;
        letter-spacing: 0.1px;
    }

    .related-carousel-nav {
        width: 46px;
        height: 46px;
        border: none;
        background: linear-gradient(135deg, #28a745 0%, #198754 100%);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(25, 135, 84, 0.3);
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .related-carousel-nav:hover {
        background: linear-gradient(135deg, #23a242 0%, #157347 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 14px 26px rgba(25, 135, 84, 0.35);
    }

    .related-carousel-nav i {
        font-size: 14px;
    }

    .related-carousel-nav:disabled {
        background: #cfe9d8;
        color: #ffffff;
        box-shadow: none;
        transform: none;
        opacity: 1;
        cursor: not-allowed;
    }

    .product-breadcrumb {
        padding: 1rem 0;
        border-bottom: 0px solid #eee;
    }

    .product-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: #6c757d;
        font-weight: 500;
    }

    .product-breadcrumb .breadcrumb a {
        font-size: 1.05rem;
        font-weight: 500;
        color: #6c757d;
    }

    .product-breadcrumb .breadcrumb a:hover {
        color: #198754;
        text-decoration: none;
    }

    .product-breadcrumb .breadcrumb-item.active {
        font-size: 1.2rem;
        color: #212529;
    }

    .product-main-img {
        transition: transform 0.3s ease;
    }

    .product-main-media {
        border: 1px solid #555555;
        border-radius: 6px;
    }

    .product-main-media:hover .product-main-img {
        transform: scale(1.03);
    }

    .btn.active {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }

    .color-btn {
        transition: all 0.2s ease;
        border: 1.5px solid #dee2e6;
        background: #fff;
        color: #212529;
    }

    .color-btn:hover:not(:disabled) {
        border-color: #198754;
        color: #198754;
    }

    .color-btn.active {
        background-color: #e8f5e9 !important;
        color: #198754 !important;
        border-color: #198754 !important;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.2);
        font-weight: 600;
    }

    .color-swatch-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
    }

    .size-btn {
        min-width: 48px;
        transition: all 0.2s ease;
        border: 1.5px solid #dee2e6;
        background: #fff;
        color: #212529;
    }

    .size-btn:hover:not(:disabled) {
        border-color: #198754;
        color: #198754;
    }

    .size-btn.active {
        background-color: #198754 !important;
        color: #fff !important;
        border-color: #198754 !important;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.2);
        font-weight: 600;
    }

    /* Out of stock effect */
    .color-btn.is-out-of-stock,
    .size-btn.is-out-of-stock {
        opacity: 0.45 !important;
        cursor: not-allowed !important;
        background-color: #f8f9fa !important;
        border-color: #ced4da !important;
        border-style: dashed !important;
        position: relative;
    }

    .size-btn.is-out-of-stock::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 6px;
        right: 6px;
        height: 1.5px;
        background-color: #dc3545;
        transform: rotate(-25deg);
        pointer-events: none;
    }

    .product-description {
        line-height: 1.8;
    }
</style>

<!-- Modal Hướng dẫn chọn size áo -->
<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title d-flex align-items-center gap-2" id="sizeGuideModalLabel">
                    <i class="bi bi-rulers"></i> Bảng hướng dẫn chọn kích cỡ áo (Size Chart)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">
                    <i class="bi bi-info-circle me-1"></i> Bảng thông số kích thước mang tính chất tham khảo chuẩn theo vóc dáng người Việt. Nếu bạn thích mặc dáng suông hoặc oversize thoải mái, hãy chọn tăng thêm 1 size.
                </p>

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-lines-fill text-success me-2"></i>1. Bảng quy đổi theo Chiều cao & Cân nặng</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
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
                                <td><span class="badge bg-secondary fs-6 px-3">S</span></td>
                                <td>1m50 - 1m60</td>
                                <td>45 - 53 kg</td>
                                <td>Vừa vặn (Regular)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary fs-6 px-3">M</span></td>
                                <td>1m60 - 1m68</td>
                                <td>54 - 62 kg</td>
                                <td>Vừa vặn (Regular)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary fs-6 px-3">L</span></td>
                                <td>1m68 - 1m75</td>
                                <td>63 - 72 kg</td>
                                <td>Thoải mái (Comfort)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary fs-6 px-3">XL</span></td>
                                <td>1m75 - 1m82</td>
                                <td>73 - 82 kg</td>
                                <td>Thoải mái (Comfort)</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary fs-6 px-3">XXL</span></td>
                                <td>1m80 - 1m90</td>
                                <td>83 - 95 kg</td>
                                <td>Rộng rãi (Oversize)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-aspect-ratio text-success me-2"></i>2. Thông số chi tiết sản phẩm (cm)</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
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

                <div class="bg-light p-3 rounded-3 border">
                    <h6 class="fw-bold mb-2 text-dark"><i class="bi bi-lightbulb text-warning me-2"></i>Mẹo chọn size chuẩn xác:</h6>
                    <ul class="text-muted small mb-0 ps-3">
                        <li class="mb-1"><strong>Dài áo:</strong> Đo từ điểm cao nhất của vai xuôi thẳng xuống lai áo.</li>
                        <li class="mb-1"><strong>Rộng ngực:</strong> Đo ngang nách áo từ nách trái sang nách phải.</li>
                        <li>Nếu chiều cao ở size L nhưng cân nặng ở size M, hãy ưu tiên chọn theo <strong>chiều cao</strong> để áo không bị ngắn.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Đã hiểu</button>
            </div>
        </div>
    </div>
</div>

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

        const allVariants = <?php echo json_encode($variantsForJs); ?>;

        let selectedColor = null;
        let selectedSize = null;
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
                updateStockStates();
                updateVariantInfo();
            });
        });

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

        // Người dùng gõ tay số lượng
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
                giaGoc.classList.add('d-none');
                phanTramGiam.classList.add('d-none');
                tonKhoInfo.innerHTML =
                    '<?php echo e($totalStock > 0 ? "Còn $totalStock sản phẩm (tổng tất cả)" : 'Hết hàng'); ?>';
                quantityInput.disabled = false;
                addToCartBtn.disabled = false;
                buyNowBtn.disabled = false;
                return;
            }

            fetch(
                    `/api/product-variant?product_id=<?php echo e($sanPham->id); ?>&color=${selectedColor}&size=${selectedSize}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.variant) {
                        currentVariantId = data.variant.id || null;
                        currentStock = parseInt(data.variant.so_luong, 10) || 0;
                        const giaBan = data.variant.gia_khuyen_mai || data.variant.gia;
                        giaHienTai.textContent = new Intl.NumberFormat('vi-VN').format(giaBan) + ' ₫';

                        if (data.variant.gia_khuyen_mai && data.variant.gia_khuyen_mai < data.variant.gia) {
                            giaGoc.textContent = new Intl.NumberFormat('vi-VN').format(data.variant.gia) +
                                ' ₫';
                            const percent = Math.round(100 - (data.variant.gia_khuyen_mai / data.variant
                                .gia * 100));
                            phanTramGiam.textContent = `-${percent}%`;
                            giaGoc.classList.remove('d-none');
                            phanTramGiam.classList.remove('d-none');
                        } else {
                            giaGoc.classList.add('d-none');
                            phanTramGiam.classList.add('d-none');
                        }

                        tonKhoInfo.textContent = `Còn ${currentStock} sản phẩm`;

                        // Cập nhật giới hạn số lượng theo tồn kho
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
                        tonKhoInfo.textContent = 'Hết hàng';
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

        // Nếu được chuyển từ checkout về, có thể kèm theo `color_id`/`size_id`
        // để tự chọn lại đúng biến thể.
        const params = new URLSearchParams(window.location.search);
        const preColorId = params.get('color_id');
        const preSizeId = params.get('size_id');
        if (preColorId && preSizeId) {
            selectedColor = preColorId;
            selectedSize = preSizeId;

            colorButtons.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.colorId == preColorId);
            });
            sizeButtons.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.sizeId == preSizeId);
            });

            updateVariantInfo();
        }

        addToCartBtn.addEventListener('click', function() {
            if (!selectedColor || !selectedSize) {
                showClientToast('Vui lòng chọn màu sắc và kích thước!', 'warning');
                return;
            }
            if (!currentVariantId) {
                showClientToast('Vui lòng chọn lại màu và kích thước.', 'warning');
                return;
            }
            let qty = parseInt(quantityInput.value, 10) || 1;
            qty = Math.max(1, qty);
            if (currentStock !== null) {
                if (qty > currentStock) {
                    showClientToast('Số lượng tối đa có thể mua là ' + currentStock, 'warning');
                    qty = currentStock;
                }
            }
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                showClientToast('Phiên đăng nhập hết hạn. Vui lòng tải lại trang.', 'error');
                return;
            }
            addToCartBtn.disabled = true;
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
                        if (data.cart_count !== undefined && typeof window.updateCartBadgeCount === 'function') {
                            window.updateCartBadgeCount(data.cart_count);
                        }
                        if (typeof window.openMiniCartDrawer === 'function') {
                            window.openMiniCartDrawer();
                        }
                    } else {
                        const errors = data.errors ? Object.values(data.errors).flat() : [];
                        const msg = errors.length ? errors.join('\n') : (data.message ||
                            'Có lỗi xảy ra.');
                        showClientToast(msg, 'error');
                    }
                })
                .catch(() => showClientToast('Có lỗi xảy ra. Vui lòng thử lại.', 'error'))
                .finally(() => {
                    addToCartBtn.disabled = false;
                });
        });

        buyNowBtn.addEventListener('click', function() {
            if (!selectedColor || !selectedSize) {
                showClientToast('Vui lòng chọn màu sắc và kích thước!', 'warning');
                return;
            }
            if (!currentVariantId) {
                showClientToast('Vui lòng chọn lại màu và kích thước.', 'warning');
                return;
            }
            let qty = parseInt(quantityInput.value, 10) || 1;
            qty = Math.max(1, qty);
            if (currentStock !== null) {
                if (qty > currentStock) {
                    showClientToast('Số lượng tối đa có thể mua là ' + currentStock, 'warning');
                    qty = currentStock;
                }
            }
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                showClientToast('Phiên đăng nhập hết hạn. Vui lòng tải lại trang.', 'error');
                return;
            }
            buyNowBtn.disabled = true;
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
                        const msg = errors.length ? errors.join('\n') : (data.message ||
                            'Có lỗi xảy ra.');
                        showClientToast(msg, 'error');
                    }
                })
                .catch(() => showClientToast('Có lỗi xảy ra. Vui lòng thử lại.', 'error'))
                .finally(() => {
                    buyNowBtn.disabled = false;
                });
        });

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
                prevBtn.disabled = left <= 2;
                nextBtn.disabled = left >= maxS - 2;

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
            }, {
                passive: true
            });

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