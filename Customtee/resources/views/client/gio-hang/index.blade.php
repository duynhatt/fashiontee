@include('client.layout.header')

<!-- Main Cart Page Wrapper -->
<div class="fashion-cart-page bg-light-subtle py-4 py-md-5">
    <div class="container-xl px-3 px-lg-4">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb fashion-cart-breadcrumb mb-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-house-door me-1"></i>Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark small fw-medium" aria-current="page">
                    Giỏ hàng của bạn
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1 tracking-tight">
                    Giỏ hàng <span class="text-muted fw-normal fs-6">({{ $items->count() }} sản phẩm)</span>
                </h1>
                <p class="text-muted small mb-0">Quản lý và kiểm tra các món đồ thời trang của bạn trước khi thanh toán</p>
            </div>
            <a href="{{ url('/Shop') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1-5 fw-semibold d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-xs mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-xs mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($items->isEmpty())
            <!-- Empty Cart State -->
            <div class="card border-0 shadow-sm rounded-4 text-center py-5 my-3 bg-white" id="cartEmptyState">
                <div class="card-body py-5 px-3">
                    <div class="fashion-empty-cart-icon mb-4 mx-auto d-flex align-items-center justify-content-center">
                        <i class="bi bi-bag-x text-muted" style="font-size: 3.5rem;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Giỏ hàng của bạn đang trống</h4>
                    <p class="text-muted small mx-auto mb-4" style="max-width: 420px;">
                        Bạn chưa chọn sản phẩm nào vào giỏ hàng. Hãy khám phá ngay các bộ sưu tập áo thun mới nhất của FashionTee nhé!
                    </p>
                    <a href="{{ url('/Shop') }}" class="btn btn-dark rounded-pill px-4 py-2-5 fw-semibold shadow-xs">
                        <i class="bi bi-bag-plus me-1"></i> Khám phá bộ sưu tập
                    </a>
                </div>
            </div>
        @else
            <!-- Active Cart Container -->
            <div class="row g-4 align-items-start" id="cartActiveContainer">

                <!-- Left Column: Cart Items List (8 cols) -->
                <div class="col-lg-8">

                    <!-- Desktop Cart Table -->
                    <div class="card border-0 shadow-xs rounded-4 overflow-hidden bg-white mb-4 d-none d-md-block">
                        <div class="card-header bg-white border-bottom border-light-subtle py-3 px-4 d-flex align-items-center justify-content-between">
                            <div class="form-check fashion-checkbox-wrapper mb-0 d-flex align-items-center gap-2">
                                <input class="form-check-input custom-cart-check" type="checkbox" id="select-all" title="Chọn tất cả">
                                <label class="form-check-label fw-semibold text-dark fs-7 cursor-pointer" for="select-all">
                                    Chọn tất cả (<span id="totalItemsCount">{{ $items->count() }}</span> món)
                                </label>
                            </div>
                            <span class="text-muted small">Kéo sang phải hoặc xem chi tiết</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table fashion-cart-table align-middle mb-0">
                                <thead>
                                    <tr class="text-muted fs-8 text-uppercase border-bottom border-light-subtle">
                                        <th style="width: 44px" class="ps-4"></th>
                                        <th style="width: 90px">Sản phẩm</th>
                                        <th>Thông tin</th>
                                        <th class="text-center" style="width: 140px">Đơn giá</th>
                                        <th class="text-center" style="width: 150px">Số lượng</th>
                                        <th class="text-end" style="width: 130px">Thành tiền</th>
                                        <th style="width: 60px" class="text-center pe-4"></th>
                                    </tr>
                                </thead>
                                <tbody id="cartTableBody">
                                    @foreach($items as $item)
                                        @php
                                            $maxStock = $item->bienThe ? (int) $item->bienThe->so_luong : 0;
                                            $isOutOfStock = $maxStock < 1;
                                            $displayQty = $isOutOfStock ? 0 : $item->so_luong;
                                            $isChecked = !$isOutOfStock && $useSelection && isset($selectedSet[$item->id]);
                                        @endphp
                                        <tr data-item-id="{{ $item->id }}" class="cart-item-row {{ $isOutOfStock ? 'is-out-of-stock opacity-60' : '' }}">
                                            <!-- Checkbox -->
                                            <td class="ps-4">
                                                <div class="form-check fashion-checkbox-wrapper mb-0">
                                                    <input type="checkbox"
                                                        class="form-check-input custom-cart-check cart-item-checkbox"
                                                        data-item-id="{{ $item->id }}"
                                                        {{ $isOutOfStock ? 'disabled' : '' }}
                                                        {{ $isChecked ? 'checked' : '' }}>
                                                </div>
                                            </td>

                                            <!-- Thumbnail -->
                                            <td>
                                                <a href="{{ route('sanpham.chitiet', $item->sanPham->slug) }}" class="fashion-cart-thumb-link d-block position-relative">
                                                    <img src="{{ asset('storage/' . $item->sanPham->hinh_anh_chinh) }}"
                                                        alt="{{ $item->sanPham->ten_san_pham }}"
                                                        class="fashion-cart-thumb rounded-3">
                                                    @if($isOutOfStock)
                                                        <span class="badge bg-danger position-absolute top-50 start-50 translate-middle fs-9">Hết hàng</span>
                                                    @endif
                                                </a>
                                            </td>

                                            <!-- Product Title & Variant -->
                                            <td>
                                                <a href="{{ route('sanpham.chitiet', $item->sanPham->slug) }}" class="fashion-cart-title text-decoration-none text-dark fw-bold d-block mb-1">
                                                    {{ $item->sanPham->ten_san_pham }}
                                                </a>
                                                <div class="fashion-variant-pill d-inline-flex align-items-center gap-1-5 px-2 py-1 rounded-pill bg-light border border-light-subtle small">
                                                    @if($item->bienThe)
                                                        @if($item->bienThe->color)
                                                            <span class="fashion-color-dot" style="background-color: {{ $item->bienThe->color->ma_mau ?? '#cbd5e1' }}"></span>
                                                            <span class="text-dark fs-8">{{ $item->bienThe->color->ten_mau }}</span>
                                                        @endif
                                                        @if($item->bienThe->color && $item->bienThe->size)
                                                            <span class="text-muted">•</span>
                                                        @endif
                                                        @if($item->bienThe->size)
                                                            <span class="fw-semibold text-dark fs-8">Size {{ $item->bienThe->size->ten_kich_thuoc }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted fs-8">Tiêu chuẩn</span>
                                                    @endif
                                                </div>
                                                @if(!$isOutOfStock && $maxStock <= 5)
                                                    <div class="text-warning-emphasis fs-8 mt-1">
                                                        <i class="bi bi-clock-history me-1"></i>Chỉ còn {{ $maxStock }} sản phẩm
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Unit Price -->
                                            <td class="text-center">
                                                <span class="fw-semibold text-dark fs-7">{{ number_format($item->don_gia) }} ₫</span>
                                            </td>

                                            <!-- Quantity Stepper -->
                                            <td class="text-center">
                                                <div class="fashion-stepper d-inline-flex align-items-center justify-content-between rounded-pill border bg-white shadow-2xs"
                                                    data-item-id="{{ $item->id }}" data-max="{{ $maxStock }}">
                                                    <button type="button" class="fashion-stepper-btn btn-qty-minus rounded-circle"
                                                        {{ $isOutOfStock || $displayQty <= 1 ? 'disabled' : '' }} aria-label="Giảm">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" class="fashion-stepper-input text-center qty-input"
                                                        value="{{ $displayQty }}" min="{{ $isOutOfStock ? 0 : 1 }}" max="{{ $maxStock }}"
                                                        {{ $isOutOfStock ? 'disabled' : '' }} readonly>
                                                    <button type="button" class="fashion-stepper-btn btn-qty-plus rounded-circle"
                                                        {{ $isOutOfStock || $displayQty >= $maxStock ? 'disabled' : '' }} aria-label="Tăng">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>

                                            <!-- Subtotal -->
                                            <td class="text-end">
                                                <span class="fw-bold text-success fs-7 thanh-tien-cell" data-value="{{ (int) $item->thanh_tien }}">
                                                    {{ number_format($item->thanh_tien) }} ₫
                                                </span>
                                            </td>

                                            <!-- Action Remove -->
                                            <td class="text-center pe-4">
                                                <button type="button" class="btn btn-link text-muted p-2 fashion-btn-remove rounded-circle"
                                                    onclick="window.removeCartItem({{ $item->id }})" title="Xóa món này">
                                                    <i class="bi bi-trash3 fs-6"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Cart Cards (Shown only on < md screens) -->
                    <div class="d-md-none" id="cartMobileCards">
                        <!-- Mobile Select All Bar -->
                        <div class="card border-0 shadow-xs rounded-4 bg-white p-3 mb-3">
                            <div class="form-check fashion-checkbox-wrapper mb-0 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <input class="form-check-input custom-cart-check" type="checkbox" id="select-all-mobile" title="Chọn tất cả">
                                    <label class="form-check-label fw-semibold text-dark fs-7 cursor-pointer" for="select-all-mobile">
                                        Chọn tất cả
                                    </label>
                                </div>
                                <span class="badge bg-light text-muted border rounded-pill fs-8">
                                    <span class="mobile-total-count">{{ $items->count() }}</span> món
                                </span>
                            </div>
                        </div>

                        <!-- Mobile Cards Loop -->
                        @foreach($items as $item)
                            @php
                                $maxStock = $item->bienThe ? (int) $item->bienThe->so_luong : 0;
                                $isOutOfStock = $maxStock < 1;
                                $displayQty = $isOutOfStock ? 0 : $item->so_luong;
                                $isChecked = !$isOutOfStock && $useSelection && isset($selectedSet[$item->id]);
                            @endphp
                            <div class="card border-0 shadow-xs rounded-4 bg-white p-3 mb-3 cart-item-mobile-card cart-item-row {{ $isOutOfStock ? 'is-out-of-stock opacity-60' : '' }}"
                                data-item-id="{{ $item->id }}">
                                <div class="d-flex gap-3">
                                    <!-- Mobile Checkbox -->
                                    <div class="form-check fashion-checkbox-wrapper pt-2">
                                        <input type="checkbox"
                                            class="form-check-input custom-cart-check cart-item-checkbox"
                                            data-item-id="{{ $item->id }}"
                                            {{ $isOutOfStock ? 'disabled' : '' }}
                                            {{ $isChecked ? 'checked' : '' }}>
                                    </div>

                                    <!-- Mobile Thumbnail -->
                                    <div class="position-relative flex-shrink-0">
                                        <a href="{{ route('sanpham.chitiet', $item->sanPham->slug) }}">
                                            <img src="{{ asset('storage/' . $item->sanPham->hinh_anh_chinh) }}"
                                                alt="{{ $item->sanPham->ten_san_pham }}"
                                                class="fashion-cart-thumb-mobile rounded-3">
                                        </a>
                                        @if($isOutOfStock)
                                            <span class="badge bg-danger position-absolute top-50 start-50 translate-middle fs-9">Hết</span>
                                        @endif
                                    </div>

                                    <!-- Mobile Details -->
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex justify-content-between align-items-start gap-1">
                                            <a href="{{ route('sanpham.chitiet', $item->sanPham->slug) }}"
                                                class="fashion-cart-title text-decoration-none text-dark fw-bold d-block text-truncate mb-1 fs-7" style="max-width: 170px;">
                                                {{ $item->sanPham->ten_san_pham }}
                                            </a>
                                            <button type="button" class="btn btn-link text-muted p-1 fashion-btn-remove"
                                                onclick="window.removeCartItem({{ $item->id }})" title="Xóa món">
                                                <i class="bi bi-x-lg fs-7"></i>
                                            </button>
                                        </div>

                                        <!-- Variant -->
                                        <div class="fashion-variant-pill d-inline-flex align-items-center gap-1 px-2 py-0-5 rounded-pill bg-light border border-light-subtle small mb-2">
                                            @if($item->bienThe)
                                                @if($item->bienThe->color)
                                                    <span class="fashion-color-dot" style="background-color: {{ $item->bienThe->color->ma_mau ?? '#cbd5e1' }}"></span>
                                                    <span class="text-dark fs-9">{{ $item->bienThe->color->ten_mau }}</span>
                                                @endif
                                                @if($item->bienThe->color && $item->bienThe->size)
                                                    <span class="text-muted fs-9">•</span>
                                                @endif
                                                @if($item->bienThe->size)
                                                    <span class="fw-semibold text-dark fs-9">Size {{ $item->bienThe->size->ten_kich_thuoc }}</span>
                                                @endif
                                            @endif
                                        </div>

                                        <!-- Price & Stepper Row -->
                                        <div class="d-flex align-items-center justify-content-between mt-1">
                                            <span class="fw-bold text-success fs-7 thanh-tien-cell" data-value="{{ (int) $item->thanh_tien }}">
                                                {{ number_format($item->thanh_tien) }} ₫
                                            </span>

                                            <!-- Mobile Stepper -->
                                            <div class="fashion-stepper d-inline-flex align-items-center justify-content-between rounded-pill border bg-white shadow-2xs"
                                                data-item-id="{{ $item->id }}" data-max="{{ $maxStock }}">
                                                <button type="button" class="fashion-stepper-btn btn-qty-minus rounded-circle"
                                                    {{ $isOutOfStock || $displayQty <= 1 ? 'disabled' : '' }} aria-label="Giảm">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" class="fashion-stepper-input text-center qty-input"
                                                    value="{{ $displayQty }}" min="{{ $isOutOfStock ? 0 : 1 }}" max="{{ $maxStock }}"
                                                    {{ $isOutOfStock ? 'disabled' : '' }} readonly>
                                                <button type="button" class="fashion-stepper-btn btn-qty-plus rounded-circle"
                                                    {{ $isOutOfStock || $displayQty >= $maxStock ? 'disabled' : '' }} aria-label="Tăng">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Right Column: Sticky Order Summary (4 cols) -->
                <div class="col-lg-4">
                    <div class="fashion-order-summary-card card border-0 shadow-xs rounded-4 bg-white p-4 position-sticky" style="top: 80px;">

                        <!-- Freeship Progress Bar Widget -->
                        <div class="fashion-freeship-box p-3 rounded-3 mb-4 border border-light-subtle bg-light">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fs-8 fw-semibold text-dark d-flex align-items-center gap-1-5" id="freeshipTitle">
                                    <i class="bi bi-truck text-success fs-6"></i> Ưu đãi vận chuyển
                                </span>
                                <span class="fs-9 fw-bold text-success" id="freeshipBadge">Mốc 500.000 ₫</span>
                            </div>
                            <div class="progress rounded-pill mb-2" style="height: 6px; background-color: #e2e8f0;">
                                <div class="progress-bar bg-success rounded-pill transition-all" id="freeshipProgressBar"
                                    role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="fs-8 text-muted mb-0" id="freeshipStatusText">
                                Đang tính toán ưu đãi giao hàng...
                            </p>
                        </div>

                        <!-- Summary Header -->
                        <h4 class="fw-bold text-dark fs-6 mb-3 pb-2 border-bottom border-light-subtle">
                            Tóm tắt đơn hàng
                        </h4>

                        <!-- Price Breakdown -->
                        <div class="d-flex justify-content-between align-items-center mb-2-5">
                            <span class="text-muted fs-7">Sản phẩm đã chọn:</span>
                            <span class="fw-semibold text-dark fs-7" id="summarySelectedCount">0 món</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2-5">
                            <span class="text-muted fs-7">Tạm tính hàng hoá:</span>
                            <span class="fw-semibold text-dark fs-7" id="summarySubtotal">0 ₫</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-7">Phí vận chuyển:</span>
                            <span class="fw-semibold text-success fs-7" id="summaryShipping">Tính khi đặt hàng</span>
                        </div>

                        <hr class="border-light-subtle my-3">

                        <!-- Grand Total -->
                        <div class="d-flex justify-content-between align-items-baseline mb-4">
                            <div>
                                <span class="fw-bold text-dark fs-6 d-block">Tổng thanh toán:</span>
                                <span class="text-muted fs-9">(Đã bao gồm VAT nếu có)</span>
                            </div>
                            <strong class="fs-4 fw-extrabold text-success tracking-tight" id="summaryTotal">
                                {{ number_format($tongTien) }} ₫
                            </strong>
                        </div>

                        <!-- Proceed to Checkout Button -->
                        <button type="button" id="btn-proceed-to-checkout"
                            class="btn btn-dark rounded-pill py-3 w-100 fw-bold fs-7 shadow-xs d-flex align-items-center justify-content-center gap-2 mb-3 fashion-checkout-btn">
                            <span>Tiến hành thanh toán</span>
                            <i class="bi bi-arrow-right fs-6"></i>
                        </button>

                        <a href="{{ url('/Shop') }}" class="btn btn-link text-muted text-decoration-none fs-8 text-center w-100 p-0 hover-underline">
                            <i class="bi bi-chevron-left"></i> Tiếp tục mua thêm sản phẩm
                        </a>

                        <!-- Trust Badges -->
                        <div class="border-top border-light-subtle pt-3 mt-4">
                            <div class="d-flex flex-column gap-2-5">
                                <div class="d-flex align-items-center gap-2-5">
                                    <div class="fashion-trust-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark">
                                        <i class="bi bi-arrow-repeat fs-7"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark fs-8">Đổi trả dễ dàng 30 ngày</div>
                                        <div class="text-muted fs-9">Miễn phí nếu có lỗi từ nhà sản xuất</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2-5">
                                    <div class="fashion-trust-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark">
                                        <i class="bi bi-shield-check fs-7"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark fs-8">Chính hãng 100% FashionTee</div>
                                        <div class="text-muted fs-9">Chất liệu sợi Cotton Organic cao cấp</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2-5">
                                    <div class="fashion-trust-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark">
                                        <i class="bi bi-lightning-charge fs-7"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark fs-8">Đóng gói & Giao hoả tốc</div>
                                        <div class="text-muted fs-9">Nhận hàng toàn quốc từ 2 - 4 ngày</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        @endif

    </div>
</div>

@include('client.layout.footer')
@include('client.layout.scripts')

<!-- SweetAlert2 for Elegant Modals -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ============================================================
       FASHIONTEE CART PAGE STYLES — MODERN MINIMALIST
       ============================================================ */
    .fashion-cart-page {
        min-height: 80vh;
    }
    .fs-7 { font-size: 0.875rem !important; }
    .fs-8 { font-size: 0.785rem !important; }
    .fs-9 { font-size: 0.715rem !important; }
    .tracking-tight { letter-spacing: -0.02em; }
    .shadow-xs { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05) !important; }
    .shadow-2xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important; }
    .transition-all { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .cursor-pointer { cursor: pointer; }

    /* Breadcrumb */
    .fashion-cart-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #cbd5e1;
        font-weight: 300;
        padding: 0 0.5rem;
    }

    /* Custom Round Checkbox */
    .custom-cart-check {
        width: 1.25rem !important;
        height: 1.25rem !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50% !important;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .custom-cart-check:checked {
        background-color: #0f172a !important;
        border-color: #0f172a !important;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.12);
    }
    .custom-cart-check:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    /* Thumbnails */
    .fashion-cart-thumb {
        width: 76px;
        height: 76px;
        object-fit: cover;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s ease;
    }
    .fashion-cart-thumb-link:hover .fashion-cart-thumb {
        transform: scale(1.04);
    }
    .fashion-cart-thumb-mobile {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid #f1f5f9;
    }

    /* Title */
    .fashion-cart-title {
        color: #0f172a;
        transition: color 0.15s ease;
    }
    .fashion-cart-title:hover {
        color: #198754;
    }

    /* Color Dot */
    .fashion-color-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15);
    }

    /* Stepper Capsule Pill */
    .fashion-stepper {
        padding: 3px 6px;
        gap: 2px;
        border-color: #e2e8f0 !important;
        background: #ffffff;
    }
    .fashion-stepper-btn {
        width: 28px;
        height: 28px;
        border: none;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .fashion-stepper-btn:hover:not(:disabled) {
        background-color: #f1f5f9;
        transform: scale(1.1);
    }
    .fashion-stepper-btn:active:not(:disabled) {
        transform: scale(0.92);
    }
    .fashion-stepper-btn:disabled {
        color: #cbd5e1;
        cursor: not-allowed;
    }
    .fashion-stepper-input {
        width: 40px;
        border: none;
        background: transparent;
        font-weight: 700;
        font-size: 0.88rem;
        color: #0f172a;
        padding: 0;
        outline: none;
    }
    /* Chrome/Safari remove number spinners */
    .fashion-stepper-input::-webkit-outer-spin-button,
    .fashion-stepper-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Remove Button */
    .fashion-btn-remove {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .fashion-btn-remove:hover {
        background-color: #fee2e2 !important;
        color: #dc3545 !important;
        transform: scale(1.1);
    }

    /* Checkout CTA Button */
    .fashion-checkout-btn {
        background: #0f172a;
        border: none;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .fashion-checkout-btn:hover {
        background: #1e293b;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25) !important;
    }
    .fashion-checkout-btn:active {
        transform: translateY(0);
    }

    /* Trust Icons */
    .fashion-trust-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
    }

    /* Row Slide Out Animation */
    .cart-row-removing {
        opacity: 0 !important;
        transform: translateX(40px) scale(0.96) !important;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }
</style>

<!-- Cart JavaScript Controller -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const FREESHIP_THRESHOLD = 500000; // Mốc 500.000 ₫ để Freeship

    const selectAllEl = document.getElementById('select-all');
    const selectAllMobileEl = document.getElementById('select-all-mobile');
    const summarySubtotalEl = document.getElementById('summarySubtotal');
    const summaryTotalEl = document.getElementById('summaryTotal');
    const summarySelectedCountEl = document.getElementById('summarySelectedCount');
    const summaryShippingEl = document.getElementById('summaryShipping');
    const freeshipProgressBar = document.getElementById('freeshipProgressBar');
    const freeshipStatusText = document.getElementById('freeshipStatusText');
    const freeshipBadge = document.getElementById('freeshipBadge');

    function formatMoney(num) {
        return new Intl.NumberFormat('vi-VN').format(num) + ' ₫';
    }

    // Lấy token CSRF
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    // Thu thập danh sách ID đã chọn
    function collectSelectedIds() {
        const checkedBoxes = Array.from(document.querySelectorAll('.cart-item-checkbox:checked'))
            .filter(cb => !cb.disabled);
        const uniqueIds = Array.from(new Set(checkedBoxes.map(cb => parseInt(cb.dataset.itemId, 10))))
            .filter(id => Number.isInteger(id));
        return uniqueIds;
    }

    // Cập nhật tính toán tiền & thanh Freeship
    function refreshTotals() {
        let total = 0;
        let checkedItemCount = 0;

        // Quét tất cả các dòng giỏ hàng (chỉ tính 1 lần theo data-item-id)
        const countedIds = new Set();
        document.querySelectorAll('.cart-item-row').forEach(row => {
            const itemId = row.dataset.itemId;
            if (!itemId || countedIds.has(itemId)) return;

            const checkbox = row.querySelector('.cart-item-checkbox');
            if (checkbox && checkbox.checked && !checkbox.disabled) {
                countedIds.add(itemId);
                checkedItemCount++;
                const cell = row.querySelector('.thanh-tien-cell');
                if (cell) {
                    const val = parseInt(cell.getAttribute('data-value'), 10) || 0;
                    total += val;
                }
            }
        });

        // Cập nhật hiển thị Summary
        if (summarySubtotalEl) summarySubtotalEl.textContent = formatMoney(total);
        if (summaryTotalEl) summaryTotalEl.textContent = formatMoney(total);
        if (summarySelectedCountEl) summarySelectedCountEl.textContent = checkedItemCount + ' món';

        // Cập nhật thanh Freeship
        if (freeshipProgressBar && freeshipStatusText) {
            if (total <= 0) {
                freeshipProgressBar.style.width = '0%';
                freeshipStatusText.innerHTML = 'Chọn sản phẩm để nhận ưu đãi <strong>Miễn phí vận chuyển</strong>';
                if (summaryShippingEl) summaryShippingEl.textContent = 'Tính khi đặt hàng';
            } else if (total >= FREESHIP_THRESHOLD) {
                freeshipProgressBar.style.width = '100%';
                freeshipProgressBar.classList.remove('bg-warning');
                freeshipProgressBar.classList.add('bg-success');
                freeshipStatusText.innerHTML = '🎉 Bạn đã đủ điều kiện nhận <strong>Miễn phí vận chuyển toàn quốc!</strong>';
                if (summaryShippingEl) summaryShippingEl.innerHTML = '<span class="text-success fw-bold">Miễn phí</span>';
            } else {
                const percent = Math.min(100, Math.round((total / FREESHIP_THRESHOLD) * 100));
                const remaining = FREESHIP_THRESHOLD - total;
                freeshipProgressBar.style.width = percent + '%';
                freeshipProgressBar.classList.remove('bg-warning');
                freeshipProgressBar.classList.add('bg-success');
                freeshipStatusText.innerHTML = `Mua thêm <strong>${formatMoney(remaining)}</strong> để được <strong>Freeship</strong>`;
                if (summaryShippingEl) summaryShippingEl.textContent = 'Tính khi đặt hàng';
            }
        }
    }

    // Đồng bộ checkbox Select All
    function syncSelectAllState() {
        const enabledBoxes = Array.from(document.querySelectorAll('.cart-item-checkbox:not(:disabled)'));
        if (enabledBoxes.length === 0) {
            if (selectAllEl) { selectAllEl.checked = false; selectAllEl.indeterminate = false; }
            if (selectAllMobileEl) { selectAllMobileEl.checked = false; selectAllMobileEl.indeterminate = false; }
            return;
        }

        const checkedBoxes = enabledBoxes.filter(cb => cb.checked);
        const isAll = checkedBoxes.length === enabledBoxes.length;
        const isIndeterminate = checkedBoxes.length > 0 && checkedBoxes.length < enabledBoxes.length;

        if (selectAllEl) {
            selectAllEl.checked = isAll;
            selectAllEl.indeterminate = isIndeterminate;
        }
        if (selectAllMobileEl) {
            selectAllMobileEl.checked = isAll;
            selectAllMobileEl.indeterminate = isIndeterminate;
        }
    }

    // Lưu danh sách ID đã chọn vào Session
    function syncSelectionToSession() {
        const token = getCsrfToken();
        if (!token) return;

        fetch('{{ route("gio-hang.selection") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ ids: collectSelectedIds() })
        }).catch(() => {});
    }

    // Khởi tạo trạng thái ban đầu
    refreshTotals();
    syncSelectAllState();

    // Event Listener cho Select All Desktop & Mobile
    [selectAllEl, selectAllMobileEl].forEach(btn => {
        if (!btn) return;
        btn.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.cart-item-checkbox:not(:disabled)').forEach(cb => {
                cb.checked = isChecked;
            });
            refreshTotals();
            syncSelectAllState();
            syncSelectionToSession();
        });
    });

    // Event Listener cho từng Checkbox sản phẩm
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('cart-item-checkbox')) {
            const itemId = e.target.dataset.itemId;
            const isChecked = e.target.checked;
            // Đồng bộ cả bản desktop và mobile của item đó
            document.querySelectorAll(`.cart-item-checkbox[data-item-id="${itemId}"]`).forEach(cb => {
                cb.checked = isChecked;
            });
            refreshTotals();
            syncSelectAllState();
            syncSelectionToSession();
        }
    });

    // Cập nhật số lượng qua Stepper (Tăng / Giảm)
    document.querySelectorAll('.fashion-stepper').forEach(stepper => {
        const itemId = stepper.dataset.itemId;
        let max = parseInt(stepper.dataset.max, 10) || 0;
        const input = stepper.querySelector('.qty-input');
        const btnMinus = stepper.querySelector('.btn-qty-minus');
        const btnPlus = stepper.querySelector('.btn-qty-plus');

        if (!itemId || max < 1) return;

        let debounceTimer = null;

        function sendUpdateQty(newQty) {
            // Tạm khóa các nút để chống spam click
            stepper.style.opacity = '0.6';
            btnMinus.disabled = true;
            btnPlus.disabled = true;

            fetch(`{{ url("/gio-hang") }}/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ so_luong: newQty })
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err; });
                }
                return res.json();
            })
            .then(data => {
                stepper.style.opacity = '1';
                if (data.success) {
                    // Cập nhật giá trị input trên cả desktop và mobile
                    document.querySelectorAll(`.fashion-stepper[data-item-id="${itemId}"] .qty-input`).forEach(inp => {
                        inp.value = data.so_luong;
                    });

                    // Cập nhật thành tiền
                    document.querySelectorAll(`tr[data-item-id="${itemId}"] .thanh-tien-cell, .cart-item-mobile-card[data-item-id="${itemId}"] .thanh-tien-cell`).forEach(cell => {
                        cell.setAttribute('data-value', data.thanh_tien);
                        cell.textContent = formatMoney(data.thanh_tien);
                    });

                    // Cập nhật trạng thái disabled của nút
                    document.querySelectorAll(`.fashion-stepper[data-item-id="${itemId}"]`).forEach(st => {
                        const m = st.querySelector('.btn-qty-minus');
                        const p = st.querySelector('.btn-qty-plus');
                        if (m) m.disabled = data.so_luong <= 1;
                        if (p) p.disabled = data.so_luong >= (data.max || max);
                    });

                    refreshTotals();

                    // Cập nhật badge giỏ hàng trên Header & Drawer
                    if (typeof window.loadMiniCartData === 'function') {
                        // Tải lại ngầm để badge header đồng bộ
                    }
                }
            })
            .catch(err => {
                stepper.style.opacity = '1';
                btnMinus.disabled = (parseInt(input.value, 10) <= 1);
                btnPlus.disabled = (parseInt(input.value, 10) >= max);

                const msg = err?.errors?.so_luong?.[0] || err?.message || 'Không thể cập nhật số lượng.';
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        text: msg,
                        confirmButtonColor: '#0f172a'
                    });
                } else {
                    alert(msg);
                }
            });
        }

        btnMinus.addEventListener('click', function() {
            let val = parseInt(input.value, 10) || 1;
            if (val > 1) {
                val--;
                input.value = val;
                btnMinus.disabled = (val <= 1);
                btnPlus.disabled = false;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => sendUpdateQty(val), 200);
            }
        });

        btnPlus.addEventListener('click', function() {
            let val = parseInt(input.value, 10) || 1;
            if (val < max) {
                val++;
                input.value = val;
                btnPlus.disabled = (val >= max);
                btnMinus.disabled = false;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => sendUpdateQty(val), 200);
            }
        });
    });

    // Xóa sản phẩm qua AJAX
    window.removeCartItem = function(itemId) {
        if (!window.Swal) {
            if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;
            executeRemove(itemId);
            return;
        }

        Swal.fire({
            title: 'Xóa sản phẩm?',
            text: 'Món đồ này sẽ được loại bỏ khỏi giỏ hàng của bạn.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Giữ lại',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg'
            }
        }).then(result => {
            if (result.isConfirmed) {
                executeRemove(itemId);
            }
        });
    };

    function executeRemove(itemId) {
        const rows = document.querySelectorAll(`tr[data-item-id="${itemId}"], .cart-item-mobile-card[data-item-id="${itemId}"]`);
        rows.forEach(r => r.classList.add('cart-row-removing'));

        fetch(`{{ url("/gio-hang") }}/${itemId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                rows.forEach(r => r.remove());

                // Cập nhật lại số lượng món trên tiêu đề
                const remainingDesktop = document.querySelectorAll('#cartTableBody tr[data-item-id]').length;
                const totalCountEl = document.getElementById('totalItemsCount');
                if (totalCountEl) totalCountEl.textContent = remainingDesktop;
                document.querySelectorAll('.mobile-total-count').forEach(el => el.textContent = remainingDesktop);

                refreshTotals();
                syncSelectAllState();
                syncSelectionToSession();

                // Cập nhật badge header
                if (typeof window.updateCartBadgeCount === 'function') {
                    window.updateCartBadgeCount(remainingDesktop);
                }

                // Nếu đã xóa hết sản phẩm -> Hiện Empty State
                if (remainingDesktop === 0) {
                    const activeContainer = document.getElementById('cartActiveContainer');
                    if (activeContainer) {
                        activeContainer.innerHTML = `
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 text-center py-5 my-3 bg-white" id="cartEmptyState">
                                    <div class="card-body py-5 px-3">
                                        <div class="fashion-empty-cart-icon mb-4 mx-auto d-flex align-items-center justify-content-center">
                                            <i class="bi bi-bag-x text-muted" style="font-size: 3.5rem;"></i>
                                        </div>
                                        <h4 class="fw-bold text-dark mb-2">Giỏ hàng của bạn đang trống</h4>
                                        <p class="text-muted small mx-auto mb-4" style="max-width: 420px;">
                                            Bạn chưa chọn sản phẩm nào vào giỏ hàng. Hãy khám phá ngay các bộ sưu tập áo thun mới nhất của FashionTee nhé!
                                        </p>
                                        <a href="{{ url('/Shop') }}" class="btn btn-dark rounded-pill px-4 py-2-5 fw-semibold shadow-xs">
                                            <i class="bi bi-bag-plus me-1"></i> Khám phá bộ sưu tập
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }

                // Toast thông báo
                if (typeof window.showClientToast === 'function') {
                    window.showClientToast('Đã xóa sản phẩm khỏi giỏ hàng.', 'success');
                }
            } else {
                rows.forEach(r => r.classList.remove('cart-row-removing'));
                alert(data.message || 'Không thể xóa sản phẩm.');
            }
        })
        .catch(() => {
            rows.forEach(r => r.classList.remove('cart-row-removing'));
            alert('Lỗi kết nối khi xóa sản phẩm. Vui lòng thử lại.');
        });
    }

    // Nút Tiến hành thanh toán
    document.getElementById('btn-proceed-to-checkout')?.addEventListener('click', function() {
        const selectedIds = collectSelectedIds();

        if (selectedIds.length === 0) {
            if (window.Swal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Chưa chọn sản phẩm',
                    text: 'Vui lòng chọn ít nhất một sản phẩm để tiến hành thanh toán.',
                    confirmButtonColor: '#0f172a',
                    confirmButtonText: 'Đã hiểu'
                });
            } else {
                alert('Vui lòng chọn ít nhất một sản phẩm để tiến hành thanh toán.');
            }
            return;
        }

        const queryString = new URLSearchParams({
            items: selectedIds.join(',')
        }).toString();

        window.location.href = '{{ route("dat-hang") }}?' + queryString;
    });
});
</script>