<?php echo $__env->make('client.layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $selectedDanhMucs = $selectedDanhMucs ?? collect((array) request()->input('danh_muc', []))->map(fn($id) => (int) $id)->all();
    $selectedSizes = collect((array) request()->input('size', []))->map(fn($id) => (int) $id)->all();
    $selectedColors = collect((array) request()->input('color', []))->map(fn($id) => (int) $id)->all();
    $selectedSort = request('sort');
    $hasAnyFilter = !empty($selectedDanhMucs)
        || !empty($selectedSizes)
        || !empty($selectedColors)
        || request()->filled('min_price')
        || request()->filled('max_price')
        || !empty($selectedSort)
        || !empty($tuKhoa);
?>

<!-- Main Shop Page Container -->
<div class="shop-page bg-white text-dark pb-5">

    <!-- Breadcrumb & Header Section -->
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb shop-breadcrumb mb-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(url('/')); ?>" class="text-decoration-none text-muted small">
                        <i class="bi bi-house-door me-1"></i>Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark small fw-medium" aria-current="page">
                    <?php if(!empty($tuKhoa)): ?>
                        Tìm kiếm: "<?php echo e($tuKhoa); ?>"
                    <?php elseif(!empty($selectedDanhMucs) && count($selectedDanhMucs) === 1): ?>
                        <?php
                            $currentCat = $danhMucs->firstWhere('id', $selectedDanhMucs[0]);
                        ?>
                        <?php echo e($currentCat->ten_danh_muc ?? 'Cửa hàng'); ?>

                    <?php else: ?>
                        Cửa hàng thời trang
                    <?php endif; ?>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Shop Hero / Banner Strip -->
    <div class="container mb-4">
        <div class="shop-hero-banner reveal p-4 p-md-5 rounded-4 bg-light border border-light-subtle position-relative overflow-hidden">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-dark text-white px-3 py-1-5 rounded-pill fw-normal fs-8 letter-spacing-wide mb-2">
                        Bộ Sưu Tập 2026
                    </span>
                    <h1 class="fw-bold text-dark mb-2 display-6">
                        <?php if(!empty($tuKhoa)): ?>
                            Kết quả tìm kiếm cho: "<?php echo e($tuKhoa); ?>"
                        <?php elseif(!empty($selectedDanhMucs) && count($selectedDanhMucs) === 1): ?>
                            <?php echo e($currentCat->ten_danh_muc ?? 'Sản Phẩm Cao Cấp'); ?>

                        <?php else: ?>
                            Tất Cả Sản Phẩm
                        <?php endif; ?>
                    </h1>
                    <p class="text-muted fs-7 mb-0" style="max-width: 600px;">
                        Khám phá các thiết kế áo thun may đo chuẩn form, chất liệu cotton thoáng mát và phong cách tối giản thời thượng.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="container">
        <div class="row g-4">

            <!-- FILTER SIDEBAR (Desktop Sticky + Mobile Drawer) -->
            <div class="col-lg-3">

                <!-- Mobile Backdrop Overlay -->
                <div class="shop-filter-backdrop d-lg-none" id="shopFilterBackdrop"></div>

                <!-- Filter Panel -->
                <aside class="shop-filter-sidebar" id="shopFilterSidebar">
                    <div class="shop-filter-inner reveal reveal-left p-3 p-lg-4 rounded-4 bg-white border border-light-subtle shadow-xs">

                        <!-- Mobile Drawer Header -->
                        <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom border-light-subtle d-lg-none">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-funnel"></i> Bộ lọc sản phẩm
                            </h6>
                            <button type="button" class="btn-close" id="closeFilterMobileBtn" aria-label="Đóng bộ lọc"></button>
                        </div>

                        <form action="<?php echo e(url('/Shop')); ?>" method="get" id="shopFilterForm">
                            <?php if(!empty($tuKhoa)): ?>
                                <input type="hidden" name="q" value="<?php echo e($tuKhoa); ?>">
                            <?php endif; ?>

                            <!-- 1. CATEGORIES -->
                            <div class="filter-section mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="filter-title fw-bold text-dark fs-7 mb-0">Danh mục</h6>
                                </div>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-1 category-filter-list">
                                    <li>
                                        <?php
                                            $allQuery = request()->except(['danh_muc', 'page']);
                                            $allUrl = url('/Shop') . ($allQuery ? '?' . http_build_query($allQuery) : '');
                                        ?>
                                        <a href="<?php echo e($allUrl); ?>"
                                           data-ajax-link="true"
                                           class="category-filter-item d-flex justify-content-between align-items-center py-2 px-2-5 rounded-3 text-decoration-none <?php echo e(empty($selectedDanhMucs) ? 'active' : ''); ?>">
                                            <span class="fs-7">Tất cả sản phẩm</span>
                                            <i class="bi bi-chevron-right fs-8"></i>
                                        </a>
                                    </li>
                                    <?php $__currentLoopData = $danhMucsTree ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rootCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make('client.partials.shop-category-item', [
                                            'category' => $rootCategory,
                                            'depth' => 0,
                                            'selectedDanhMucs' => $selectedDanhMucs
                                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>

                            <hr class="border-light-subtle my-3">

                            <!-- 2. PRICE RANGE -->
                            <div class="filter-section mb-4">
                                <h6 class="filter-title fw-bold text-dark fs-7 mb-2">Khoảng giá (₫)</h6>
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <label for="min_price" class="form-label fs-8 text-muted mb-1">Từ</label>
                                        <input type="number"
                                               id="min_price"
                                               name="min_price"
                                               min="0"
                                               step="1000"
                                               class="form-control form-control-sm rounded-2 fs-7"
                                               value="<?php echo e(request('min_price')); ?>"
                                               placeholder="<?php echo e($minPrice ? number_format($minPrice, 0, ',', '.') : '0'); ?>">
                                    </div>
                                    <div class="col-6">
                                        <label for="max_price" class="form-label fs-8 text-muted mb-1">Đến</label>
                                        <input type="number"
                                               id="max_price"
                                               name="max_price"
                                               min="0"
                                               step="1000"
                                               class="form-control form-control-sm rounded-2 fs-7"
                                               value="<?php echo e(request('max_price')); ?>"
                                               placeholder="<?php echo e($maxPrice ? number_format($maxPrice, 0, ',', '.') : 'Tối đa'); ?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark btn-sm w-100 rounded-2 py-1-5 fs-7 fw-medium">
                                    Áp dụng giá
                                </button>
                            </div>

                            <hr class="border-light-subtle my-3">

                            <!-- 3. SIZES (Styled Tiles) -->
                            <div class="filter-section mb-4">
                                <h6 class="filter-title fw-bold text-dark fs-7 mb-2">Kích thước</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $isSizeChecked = in_array((int) $size->id, $selectedSizes, true);
                                        ?>
                                        <label class="size-filter-label cursor-pointer mb-0">
                                            <input type="checkbox"
                                                   class="d-none size-filter-checkbox"
                                                   name="size[]"
                                                   value="<?php echo e($size->id); ?>"
                                                   <?php echo e($isSizeChecked ? 'checked' : ''); ?>>
                                            <span class="size-filter-tile rounded-3 px-3 py-1-5 fs-7 fw-medium d-inline-flex align-items-center justify-content-center">
                                                <?php echo e($size->ten_kich_thuoc); ?>

                                            </span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <hr class="border-light-subtle my-3">

                            <!-- 4. COLORS (Styled Swatches) -->
                            <div class="filter-section mb-4">
                                <h6 class="filter-title fw-bold text-dark fs-7 mb-2">Màu sắc</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $isColorChecked = in_array((int) $color->id, $selectedColors, true);
                                        ?>
                                        <label class="color-filter-label cursor-pointer mb-0">
                                            <input type="checkbox"
                                                   class="d-none color-filter-checkbox"
                                                   name="color[]"
                                                   value="<?php echo e($color->id); ?>"
                                                   <?php echo e($isColorChecked ? 'checked' : ''); ?>>
                                            <span class="color-filter-pill rounded-pill px-2-5 py-1 d-inline-flex align-items-center gap-2 border">
                                                <span class="color-swatch-circle" style="background-color: <?php echo e($color->ma_mau ?? '#000000'); ?>;"></span>
                                                <span class="color-filter-name fs-8"><?php echo e($color->ten_mau); ?></span>
                                            </span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Hidden Sort Input to preserve sort on filter change -->
                            <?php if(!empty($selectedSort)): ?>
                                <input type="hidden" name="sort" value="<?php echo e($selectedSort); ?>">
                            <?php endif; ?>

                            <!-- RESET FILTER BUTTON -->
                            <?php if($hasAnyFilter): ?>
                                <div class="pt-2">
                                    <a href="<?php echo e(url('/Shop') . (!empty($tuKhoa) ? '?q=' . urlencode($tuKhoa) : '')); ?>"
                                       class="btn btn-outline-secondary btn-sm w-100 rounded-3 py-2 fs-7 d-flex align-items-center justify-content-center gap-2"
                                       data-ajax-link="true">
                                        <i class="bi bi-x-circle"></i> Xóa tất cả bộ lọc
                                    </a>
                                </div>
                            <?php endif; ?>

                        </form>

                    </div>
                </aside>
            </div>

            <!-- RIGHT: MAIN PRODUCT GRID & TOOLBAR -->
            <div class="col-lg-9" id="shopContent">
                <!-- Toolbar (Search + Sort + Results Count + Mobile Filter Trigger) -->
                <div class="shop-toolbar reveal p-3 rounded-4 bg-light border border-light-subtle mb-4" id="shopToolbar">
                    <div class="row g-3 align-items-center justify-content-between">

                        <!-- Left: Results count & Mobile Trigger -->
                        <div class="col-12 col-md-5 d-flex align-items-center gap-2">
                            <!-- Mobile Filter Drawer Toggle Button -->
                            <button type="button" class="btn btn-dark btn-sm rounded-3 py-2 px-3 d-lg-none d-inline-flex align-items-center gap-2 flex-shrink-0" id="openFilterMobileBtn">
                                <i class="bi bi-funnel"></i>
                                <span>Bộ lọc</span>
                                <?php if($hasAnyFilter): ?>
                                    <span class="badge bg-white text-dark rounded-pill px-1-5 py-0-5 fs-8">!</span>
                                <?php endif; ?>
                            </button>

                            <div class="text-muted fs-7">
                                Hiển thị <strong class="text-dark"><?php echo e($sanPhams->total()); ?></strong> sản phẩm
                            </div>
                        </div>

                        <!-- Right: Search Bar & Sort Dropdown -->
                        <div class="col-12 col-md-7">
                            <div class="d-flex align-items-center gap-2 justify-content-md-end flex-wrap flex-sm-nowrap">

                                <!-- Search Form -->
                                <form action="<?php echo e(url('/Shop')); ?>" method="get" class="flex-grow-1 flex-sm-grow-0" id="shopSearchForm" style="min-width: 200px;">
                                    <?php $__currentLoopData = request()->except(['q', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(is_array($value)): ?>
                                            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($item); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="q" class="form-control rounded-start-3 border-secondary-subtle"
                                               placeholder="Tìm sản phẩm..."
                                               value="<?php echo e(old('q', $tuKhoa ?? request('q'))); ?>"
                                               aria-label="Tìm kiếm">
                                        <button type="submit" class="btn btn-dark rounded-end-3 px-3" aria-label="Tìm kiếm">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Sort Dropdown -->
                                <div class="sort-select-wrapper flex-shrink-0">
                                    <select class="form-select form-select-sm rounded-3 border-secondary-subtle fs-7 fw-medium" id="shopSortSelect" aria-label="Sắp xếp sản phẩm">
                                        <option value="" <?php echo e(empty($selectedSort) ? 'selected' : ''); ?>>Mặc định</option>
                                        <option value="new" <?php echo e($selectedSort === 'new' ? 'selected' : ''); ?>>Mới nhất</option>
                                        <option value="price_asc" <?php echo e($selectedSort === 'price_asc' ? 'selected' : ''); ?>>Giá tăng dần</option>
                                        <option value="price_desc" <?php echo e($selectedSort === 'price_desc' ? 'selected' : ''); ?>>Giá giảm dần</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- Active Filter Tags Chips -->
                <?php if($hasAnyFilter): ?>
                    <div class="shop-active-filters d-flex flex-wrap align-items-center gap-2 mb-4" id="shopActiveFilters">
                        <span class="fs-8 text-muted fw-medium me-1">Đang lọc theo:</span>

                        <?php if(!empty($tuKhoa)): ?>
                            <a class="active-filter-chip chip-pop-in"
                               data-ajax-link="true"
                               href="<?php echo e(request()->fullUrlWithQuery(['q' => null, 'page' => null])); ?>">
                                Từ khóa: "<?php echo e($tuKhoa); ?>" <i class="bi bi-x"></i>
                            </a>
                        <?php endif; ?>

                        <?php $__currentLoopData = $danhMucs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $danhMuc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array((int) $danhMuc->id, $selectedDanhMucs, true)): ?>
                                <a class="active-filter-chip chip-pop-in"
                                   data-ajax-link="true"
                                   href="<?php echo e(request()->fullUrlWithQuery(['danh_muc' => array_values(array_diff($selectedDanhMucs, [(int) $danhMuc->id])), 'page' => null])); ?>">
                                    <?php echo e($danhMuc->ten_danh_muc); ?> <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array((int) $size->id, $selectedSizes, true)): ?>
                                <a class="active-filter-chip chip-pop-in"
                                   data-ajax-link="true"
                                   href="<?php echo e(request()->fullUrlWithQuery(['size' => array_values(array_diff($selectedSizes, [(int) $size->id])), 'page' => null])); ?>">
                                    Size <?php echo e($size->ten_kich_thuoc); ?> <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array((int) $color->id, $selectedColors, true)): ?>
                                <a class="active-filter-chip chip-pop-in"
                                   data-ajax-link="true"
                                   href="<?php echo e(request()->fullUrlWithQuery(['color' => array_values(array_diff($selectedColors, [(int) $color->id])), 'page' => null])); ?>">
                                    Màu <?php echo e($color->ten_mau); ?> <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if(request()->filled('min_price') || request()->filled('max_price')): ?>
                            <a class="active-filter-chip chip-pop-in"
                               data-ajax-link="true"
                               href="<?php echo e(request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null, 'page' => null])); ?>">
                                Giá: <?php echo e(number_format((int) request('min_price', 0), 0, ',', '.')); ?>đ - <?php echo e(request('max_price') ? number_format((int) request('max_price'), 0, ',', '.') . 'đ' : 'Tối đa'); ?> <i class="bi bi-x"></i>
                            </a>
                        <?php endif; ?>

                        <?php if(!empty($selectedSort)): ?>
                            <a class="active-filter-chip chip-pop-in"
                               data-ajax-link="true"
                               href="<?php echo e(request()->fullUrlWithQuery(['sort' => null, 'page' => null])); ?>">
                                Sắp xếp: <?php echo e($selectedSort === 'price_asc' ? 'Giá tăng dần' : ($selectedSort === 'price_desc' ? 'Giá giảm dần' : 'Mới nhất')); ?> <i class="bi bi-x"></i>
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo e(url('/Shop') . (!empty($tuKhoa) ? '?q=' . urlencode($tuKhoa) : '')); ?>"
                           class="text-decoration-none text-danger small ms-2 fw-medium fs-8"
                           data-ajax-link="true">
                            Xóa hết
                        </a>
                    </div>
                <?php endif; ?>

                <!-- PRODUCT GRID -->
                <div class="row row-cols-2 row-cols-md-3 g-3 g-md-4" id="shopProductsGrid">
                    <?php $__empty_1 = true; $__currentLoopData = $sanPhams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col reveal stagger-<?php echo e((($loop->iteration - 1) % 6) + 1); ?>">
                            <div class="card clean-product-card h-100 border-0 rounded-3 overflow-hidden bg-transparent">

                                <!-- Image Showcase Frame -->
                                <div class="clean-product-thumb-box position-relative rounded-3 overflow-hidden bg-light border border-light-subtle">
                                    <!-- Badges -->
                                    <div class="position-absolute top-0 start-0 m-2 z-2">
                                        <span class="badge bg-dark text-white px-2 py-1 rounded-pill fw-normal fs-8">
                                            Chính hãng
                                        </span>
                                    </div>

                                    <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>" class="d-block w-100 h-100">
                                        <img class="clean-product-thumb w-100 h-100"
                                             src="<?php echo e($sp->hinh_anh_chinh ? asset('storage/' . $sp->hinh_anh_chinh) : asset('img/shop_01.jpg')); ?>"
                                             loading="lazy"
                                             decoding="async"
                                             alt="<?php echo e($sp->ten_san_pham); ?>">
                                    </a>

                                    <!-- Quick Detail Hover Action Button -->
                                    <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                       class="quick-view-overlay-btn btn btn-dark btn-sm rounded-pill position-absolute bottom-0 start-50 translate-middle-x mb-3 opacity-0 text-nowrap px-3 shadow-sm">
                                        Xem chi tiết
                                    </a>
                                </div>

                                <!-- Product Info -->
                                <div class="card-body p-2 pt-3 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="text-muted fs-8 text-uppercase d-block mb-1 tracking-wider">
                                            <?php echo e($sp->category->ten_danh_muc ?? 'Fashion'); ?>

                                        </span>
                                        <a href="<?php echo e(route('sanpham.chitiet', $sp->slug)); ?>"
                                           class="clean-product-title text-decoration-none text-dark fw-medium d-block fs-7 mb-2 text-truncate-2">
                                            <?php echo e($sp->ten_san_pham); ?>

                                        </a>
                                    </div>
                                    <div class="clean-product-price fw-bold text-dark fs-7">
                                        <?php if($sp->variants_min_gia): ?>
                                            <?php echo e(number_format($sp->variants_min_gia, 0, ',', '.')); ?> ₫
                                        <?php else: ?>
                                            Liên hệ
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <!-- Empty State -->
                        <div class="col-12 text-center py-5 my-4">
                            <div class="text-muted mb-3 fs-1">
                                <i class="bi bi-search"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Không tìm thấy sản phẩm nào</h5>
                            <p class="text-muted fs-7 mb-4" style="max-width: 420px; margin: 0 auto;">
                                Hãy thử thay đổi từ khóa tìm kiếm hoặc bỏ bớt các tiêu chí lọc để xem thêm các mẫu áo khác.
                            </p>
                            <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-dark rounded-3 px-4 py-2 fs-7 fw-semibold" data-ajax-link="true">
                                Xem tất cả sản phẩm
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- PAGINATION -->
                <div class="row mt-5 reveal reveal-fade" id="shopPaginationWrap">
                    <div class="col-12 d-flex justify-content-center">
                        <?php echo e($sanPhams->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- VALUE PROPOSITIONS STRIP (Thay thế Our Brands) -->
    <div class="container mt-5 pt-4">
        <div class="p-4 p-md-5 rounded-4 bg-light border border-light-subtle">
            <div class="row g-4 text-center text-md-start">
                <div class="col-12 col-sm-6 col-lg-3 reveal stagger-1">
                    <div class="d-flex align-items-center gap-3 justify-content-center justify-content-md-start">
                        <div class="rounded-circle bg-white p-3 border border-light-subtle shadow-xs text-dark fs-5">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 fs-7">100% Cotton Cao Cấp</h6>
                            <p class="text-muted small mb-0">Chất vải tự nhiên thoáng mát</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 reveal stagger-2">
                    <div class="d-flex align-items-center gap-3 justify-content-center justify-content-md-start">
                        <div class="rounded-circle bg-white p-3 border border-light-subtle shadow-xs text-dark fs-5">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 fs-7">Đổi Hàng Tận Nơi 3 Ngày</h6>
                            <p class="text-muted small mb-0">Hỗ trợ đổi size nhanh gọn</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 reveal stagger-3">
                    <div class="d-flex align-items-center gap-3 justify-content-center justify-content-md-start">
                        <div class="rounded-circle bg-white p-3 border border-light-subtle shadow-xs text-dark fs-5">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 fs-7">Giao Hàng Toàn Quốc</h6>
                            <p class="text-muted small mb-0">Kiểm tra trước khi trả tiền</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 reveal stagger-4">
                    <div class="d-flex align-items-center gap-3 justify-content-center justify-content-md-start">
                        <div class="rounded-circle bg-white p-3 border border-light-subtle shadow-xs text-dark fs-5">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 fs-7">Hỗ Trợ Tận Tâm 24/7</h6>
                            <p class="text-muted small mb-0">Tư vấn chuẩn size chuẩn form</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- SHOP STYLES (Đồng bộ 100% với Product Detail) -->
<?php echo $__env->make('client.layout.motion-system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<style>
    /* Typography Utilities */
    .fs-7 { font-size: 0.875rem !important; }
    .fs-8 { font-size: 0.775rem !important; }
    .py-0-5 { padding-top: 0.125rem !important; padding-bottom: 0.125rem !important; }
    .py-1-5 { padding-top: 0.375rem !important; padding-bottom: 0.375rem !important; }
    .px-1-5 { padding-left: 0.375rem !important; padding-right: 0.375rem !important; }
    .px-2-5 { padding-left: 0.625rem !important; padding-right: 0.625rem !important; }
    .letter-spacing-wide { letter-spacing: 0.05em; }
    .tracking-wider { letter-spacing: 0.08em; }
    .cursor-pointer { cursor: pointer; }

    /* Breadcrumb */
    .shop-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #cbd5e1;
        font-weight: 300;
        padding: 0 0.5rem;
    }

    /* Category Filter List & Accordion */
    .category-filter-item {
        color: #475569;
        transition: all 0.2s ease;
        position: relative;
    }
    .category-filter-item:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .category-filter-item.active {
        background-color: #0f172a;
        color: #ffffff !important;
        font-weight: 600;
    }
    .category-filter-item.active .category-link {
        color: #ffffff !important;
        font-weight: 600;
    }
    .category-filter-item.active .btn-cat-toggle {
        color: #ffffff !important;
    }
    .category-filter-item.active .btn-cat-toggle:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .category-link {
        color: inherit;
        outline: none;
    }
    .btn-cat-toggle {
        background: transparent;
        border: none;
        padding: 2px 6px;
        margin-left: 4px;
        border-radius: 4px;
        color: #64748b;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-cat-toggle:hover {
        background-color: rgba(15, 23, 42, 0.08);
        color: #0f172a;
    }
    .btn-cat-toggle i {
        display: inline-block;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-cat-toggle.is-open i {
        transform: rotate(180deg);
    }

    /* Subcategory container with elegant tree guide line */
    .category-sublist {
        margin-top: 2px;
        margin-bottom: 3px;
        margin-left: 12px;
        padding-left: 10px;
        border-left: 2px solid #e2e8f0;
    }
    .category-sublist .category-filter-item {
        padding-top: 0.35rem !important;
        padding-bottom: 0.35rem !important;
    }

    /* Size Filter Tiles */
    .size-filter-tile {
        min-width: 44px;
        height: 38px;
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #0f172a;
        transition: all 0.2s ease;
    }
    .size-filter-tile:hover {
        border-color: #0f172a;
        background-color: #f8fafc;
    }
    .size-filter-checkbox:checked + .size-filter-tile {
        background-color: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
    }

    /* Color Filter Pills */
    .color-filter-pill {
        background-color: #ffffff;
        border-color: #e2e8f0 !important;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .color-filter-pill:hover {
        border-color: #0f172a !important;
        background-color: #f8fafc;
    }
    .color-filter-checkbox:checked + .color-filter-pill {
        border-color: #0f172a !important;
        background-color: #0f172a;
        color: #ffffff;
    }
    .color-swatch-circle {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.15);
    }
    .color-filter-checkbox:checked + .color-filter-pill .color-swatch-circle {
        box-shadow: 0 0 0 2px #ffffff;
    }

    /* Active Filter Chips */
    .active-filter-chip {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }
    .active-filter-chip:hover {
        background-color: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    /* Product Cards */
    .clean-product-thumb-box {
        aspect-ratio: 3 / 4;
        background-color: #f8fafc;
    }
    .clean-product-thumb {
        object-fit: cover;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .clean-product-card:hover .clean-product-thumb {
        transform: scale(1.05);
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
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.45rem;
    }

    /* Loading Overlay */
    .shop-loading {
        opacity: 0.55;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }

    /* Mobile Filter Drawer Styles */
    @media (max-width: 991.98px) {
        .shop-filter-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 320px;
            max-width: 85vw;
            z-index: 1060;
            background: #ffffff;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .shop-filter-sidebar.is-open {
            transform: translateX(0);
        }
        .shop-filter-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1055;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .shop-filter-backdrop.is-visible {
            opacity: 1;
            pointer-events: auto;
        }
    }

    @media (min-width: 992px) {
        .shop-filter-sidebar {
            position: sticky;
            top: 85px;
        }
    }
</style>

<!-- JAVASCRIPT LOGIC (100% Preserved AJAX Navigation & Mobile Drawer) -->
<script>
    (function () {
        let loading = false;

        const setLoading = (isLoading) => {
            loading = isLoading;
            const sidebar = document.getElementById('shopFilterSidebar');
            const content = document.getElementById('shopContent');
            if (sidebar) sidebar.classList.toggle('shop-loading', isLoading);
            if (content) content.classList.toggle('shop-loading', isLoading);
        };

        const updateFromHtml = (html, nextUrl, pushState = true) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const nextSidebar = doc.getElementById('shopFilterSidebar');
            const nextContent = doc.getElementById('shopContent');
            const currentSidebar = document.getElementById('shopFilterSidebar');
            const currentContent = document.getElementById('shopContent');

            if (!nextSidebar || !nextContent || !currentSidebar || !currentContent) {
                window.location.href = nextUrl;
                return;
            }

            currentSidebar.outerHTML = nextSidebar.outerHTML;
            currentContent.outerHTML = nextContent.outerHTML;

            if (pushState) {
                window.history.pushState({}, '', nextUrl);
            }

            closeMobileDrawer();
            bindAjaxEvents();
        };

        const ajaxNavigate = async (nextUrl, pushState = true) => {
            if (loading) return;
            setLoading(true);
            try {
                const response = await fetch(nextUrl, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await response.text();
                updateFromHtml(html, nextUrl, pushState);
            } catch (e) {
                window.location.href = nextUrl;
            } finally {
                setLoading(false);
            }
        };

        const buildUrlFromForm = (form) => {
            const action = form.getAttribute('action') || window.location.pathname;
            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (const [key, value] of formData.entries()) {
                if (value !== null && String(value).trim() !== '') {
                    params.append(key, value);
                }
            }
            params.delete('page');

            const query = params.toString();
            return query ? `${action}?${query}` : action;
        };

        function openMobileDrawer() {
            const sidebar = document.getElementById('shopFilterSidebar');
            const backdrop = document.getElementById('shopFilterBackdrop');
            if (sidebar) sidebar.classList.add('is-open');
            if (backdrop) backdrop.classList.add('is-visible');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileDrawer() {
            const sidebar = document.getElementById('shopFilterSidebar');
            const backdrop = document.getElementById('shopFilterBackdrop');
            if (sidebar) sidebar.classList.remove('is-open');
            if (backdrop) backdrop.classList.remove('is-visible');
            document.body.style.overflow = '';
        }

        function bindAjaxEvents() {
            const filterForm = document.getElementById('shopFilterForm');
            const searchForm = document.getElementById('shopSearchForm');
            const paginationWrap = document.getElementById('shopPaginationWrap');
            const ajaxLinks = document.querySelectorAll('a[data-ajax-link="true"]');
            const sortSelect = document.getElementById('shopSortSelect');

            // Mobile drawer buttons
            const openBtn = document.getElementById('openFilterMobileBtn');
            const closeBtn = document.getElementById('closeFilterMobileBtn');
            const backdrop = document.getElementById('shopFilterBackdrop');

            if (openBtn) openBtn.addEventListener('click', openMobileDrawer);
            if (closeBtn) closeBtn.addEventListener('click', closeMobileDrawer);
            if (backdrop) backdrop.addEventListener('click', closeMobileDrawer);

            if (filterForm) {
                filterForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    ajaxNavigate(buildUrlFromForm(filterForm));
                });

                const autoSubmitInputs = filterForm.querySelectorAll('input[type="checkbox"]');
                autoSubmitInputs.forEach((input) => {
                    input.addEventListener('change', () => {
                        ajaxNavigate(buildUrlFromForm(filterForm));
                    });
                });
            }

            if (searchForm) {
                searchForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    ajaxNavigate(buildUrlFromForm(searchForm));
                });
            }

            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    const sortVal = this.value;
                    const url = new URL(window.location.href);
                    if (sortVal) {
                        url.searchParams.set('sort', sortVal);
                    } else {
                        url.searchParams.delete('sort');
                    }
                    url.searchParams.delete('page');
                    ajaxNavigate(url.toString());
                });
            }

            if (paginationWrap) {
                paginationWrap.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        ajaxNavigate(this.href);
                        const content = document.getElementById('shopContent');
                        if (content) {
                            content.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                });
            }

            ajaxLinks.forEach((link) => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    ajaxNavigate(this.href);
                });
            });

            // Category accordion dropdown toggles
            const catToggles = document.querySelectorAll('.btn-cat-toggle');
            catToggles.forEach((btn) => {
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    const targetId = this.getAttribute('data-target');
                    if (!targetId) return;
                    const sublist = document.querySelector(targetId);
                    if (sublist) {
                        const isOpen = this.classList.contains('is-open');
                        if (isOpen) {
                            if (window.jQuery) {
                                $(sublist).slideUp(200);
                            } else {
                                sublist.style.display = 'none';
                            }
                            this.classList.remove('is-open');
                        } else {
                            if (window.jQuery) {
                                $(sublist).slideDown(200);
                            } else {
                                sublist.style.display = 'block';
                            }
                            this.classList.add('is-open');
                        }
                    }
                });
            });

            // Re-initialize motion system for new DOM elements
            if (window.MotionSystem) {
                var shopContent = document.getElementById('shopContent');
                if (shopContent) {
                    // Stagger-reveal product cards immediately after AJAX (user is already viewing)
                    window.MotionSystem.staggerRevealImmediate(shopContent, '.reveal:not(.is-revealed)', 30, 60);
                }
                // Re-observe any other reveal elements (sidebar, pagination)
                var sidebar = document.getElementById('shopFilterSidebar');
                if (sidebar) {
                    sidebar.querySelectorAll('.reveal:not(.is-revealed)').forEach(function(el) {
                        el.classList.add('is-revealed');
                    });
                }
            }
        }

        window.addEventListener('popstate', () => {
            ajaxNavigate(window.location.href, false);
        });

        document.addEventListener('DOMContentLoaded', bindAjaxEvents);
        bindAjaxEvents();
    })();
</script>

<?php echo $__env->make('client.layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('client.layout.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/client/Shop.blade.php ENDPATH**/ ?>