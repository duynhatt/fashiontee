


<button type="button" class="fashion-side-cart-trigger d-flex flex-column align-items-center justify-content-center"
    id="floatingSideCartTrigger" onclick="window.openMiniCartDrawer()" title="Xem giỏ hàng" aria-label="Mở giỏ hàng">
    <div class="position-relative d-flex align-items-center justify-content-center">
        <i class="bi bi-bag-check fs-5"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger header-cart-badge <?php echo e(isset($headerCartCount) && $headerCartCount > 0 ? '' : 'd-none'); ?>" id="floatingSideCartBadge">
            <?php echo e(isset($headerCartCount) && $headerCartCount > 99 ? '99+' : ($headerCartCount ?? 0)); ?>

        </span>
    </div>
    <span class="fashion-side-cart-label mt-1">Giỏ</span>
</button>


<div class="mini-cart-backdrop" id="miniCartBackdrop" onclick="window.closeMiniCartDrawer()"></div>


<div class="mini-cart-drawer" id="miniCartDrawer" aria-hidden="true" role="dialog" aria-modal="true">

    
    <div class="mini-cart-header border-bottom d-flex justify-content-between align-items-center bg-white">
        <div class="d-flex align-items-center gap-2">
            <div class="mini-cart-header-icon rounded-circle bg-light d-flex align-items-center justify-content-center text-dark">
                <i class="bi bi-bag-check fs-6"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-0 fs-6 tracking-tight d-flex align-items-center gap-1-5">
                    Giỏ hàng của bạn
                    <span class="badge bg-dark text-white rounded-pill fs-8 fw-normal px-2 py-0-5" id="drawerCartBadge">0</span>
                </h5>
            </div>
        </div>
        <button type="button" class="btn-close shadow-none fs-8 p-2 rounded-circle" onclick="window.closeMiniCartDrawer()" aria-label="Đóng"></button>
    </div>

    
    <div class="mini-cart-freeship bg-light border-bottom" id="drawerFreeshipBox">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <span class="fs-8 fw-semibold text-dark d-flex align-items-center gap-1">
                <i class="bi bi-truck text-success fs-7"></i> Ưu đãi Freeship
            </span>
            <span class="fs-9 fw-bold text-success" id="drawerFreeshipBadge">Mốc 500.000 ₫</span>
        </div>
        <div class="progress rounded-pill mb-1" style="height: 5px; background-color: #e2e8f0;">
            <div class="progress-bar bg-success rounded-pill transition-all" id="drawerFreeshipProgressBar"
                role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p class="fs-9 text-muted mb-0" id="drawerFreeshipStatusText">
            Đang tính toán ưu đãi giao hàng...
        </p>
    </div>

    
    <div class="mini-cart-body" id="miniCartBody">

        <!-- Loading spinner -->
        <div id="drawerCartLoading" class="text-center py-5 my-auto">
            <div class="spinner-border text-dark spinner-border-sm" role="status">
                <span class="visually-hidden">Đang tải...</span>
            </div>
            <p class="text-muted small mt-2 mb-0 fs-8">Đang đồng bộ giỏ hàng...</p>
        </div>

        <!-- Khách chưa đăng nhập -->
        <div id="drawerCartGuest" class="d-none text-center py-5 px-3 my-auto">
            <div class="mini-cart-state-icon rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-person-lock text-muted fs-4"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1 fs-6">Đăng nhập tài khoản</h6>
            <p class="text-muted fs-8 mb-3">Đăng nhập để xem giỏ hàng đã lưu và đồng bộ thanh toán trên mọi thiết bị.</p>
            <div class="d-grid gap-2">
                <a href="<?php echo e(route('login')); ?>" class="btn btn-dark rounded-pill fw-semibold py-2 fs-8">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập ngay
                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-dark rounded-pill fw-semibold py-2 fs-8">
                    Tạo tài khoản mới
                </a>
            </div>
        </div>

        <!-- Giỏ hàng trống -->
        <div id="drawerCartEmpty" class="d-none text-center py-5 px-3 my-auto">
            <div class="mini-cart-state-icon rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-bag-x text-muted fs-4"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1 fs-6">Giỏ hàng đang trống</h6>
            <p class="text-muted fs-8 mb-3">Chưa có sản phẩm nào được chọn. Hãy khám phá các mẫu áo thun mới nhất nhé!</p>
            <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold fs-8" onclick="window.closeMiniCartDrawer()">
                <i class="bi bi-bag-plus me-1"></i> Khám phá sản phẩm
            </a>
        </div>

        <!-- Danh sách sản phẩm trong giỏ -->
        <div id="drawerCartItems" class="p-3" style="display: none;">
            <!-- Render động các sản phẩm qua JavaScript -->
        </div>

    </div>

    
    <div class="mini-cart-footer border-top bg-white" id="drawerCartFooter" style="display: none;">
        <div class="d-flex justify-content-between align-items-baseline mb-2-5">
            <span class="text-muted fs-8 fw-medium">Tạm tính hàng hoá:</span>
            <span class="fw-bold text-success fs-6 tracking-tight" id="drawerCartSubtotal">0 ₫</span>
        </div>
        <div class="d-grid gap-2">
            <a href="<?php echo e(route('dat-hang')); ?>" class="btn btn-dark rounded-pill py-2 fw-bold fs-7 shadow-xs d-flex align-items-center justify-content-center gap-1-5">
                <span>Tiến hành thanh toán</span>
                <i class="bi bi-arrow-right fs-7"></i>
            </a>
            <a href="<?php echo e(route('gio-hang.index')); ?>" class="btn btn-outline-dark rounded-pill py-1-5 fw-semibold fs-8" onclick="window.closeMiniCartDrawer()">
                <i class="bi bi-cart3 me-1"></i> Xem giỏ hàng đầy đủ
            </a>
        </div>
    </div>

</div>

<style>
    /* ============================================================
       FLOATING SIDE CART TRIGGER (Nút Tab Mép Phải)
       ============================================================ */
    .fashion-side-cart-trigger {
        position: fixed;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1035;
        background: #0f172a;
        color: #ffffff;
        border: none;
        border-radius: 999px 0 0 999px;
        padding: 10px 8px 10px 12px;
        box-shadow: -4px 0 20px rgba(15, 23, 42, 0.22);
        cursor: pointer;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), background 0.2s ease, box-shadow 0.2s ease;
    }
    .fashion-side-cart-trigger:hover {
        background: #1e293b;
        transform: translateY(-50%) translateX(-4px);
        box-shadow: -6px 0 25px rgba(15, 23, 42, 0.3);
    }
    .fashion-side-cart-trigger:active {
        transform: translateY(-50%) translateX(0);
    }
    .fashion-side-cart-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        line-height: 1;
    }

    /* ============================================================
       MINI-CART BACKDROP & DRAWER (Khóa chiều cao 100vh chuẩn tuyệt đối)
       ============================================================ */
    .mini-cart-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .mini-cart-backdrop.show {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .mini-cart-drawer {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 380px !important;
        max-width: 100vw !important;
        height: 100vh !important;
        height: 100dvh !important;
        max-height: 100vh !important;
        max-height: 100dvh !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
        background-color: #ffffff !important;
        z-index: 1055 !important;
        box-shadow: -8px 0 35px rgba(15, 23, 42, 0.16) !important;
        transform: translateX(100%) !important;
        visibility: hidden !important;
        pointer-events: none !important;
        transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.32s !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .mini-cart-drawer.open {
        transform: translateX(0) !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    /* 3 Khối flexbox chuẩn 100vh */
    .mini-cart-header {
        flex: 0 0 auto !important;
        padding: 12px 16px !important;
    }
    .mini-cart-freeship {
        flex: 0 0 auto !important;
        padding: 10px 16px !important;
    }
    .mini-cart-body {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        max-height: 100% !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
    }
    .mini-cart-footer {
        flex: 0 0 auto !important;
        margin-top: auto !important;
        padding: 14px 16px !important;
        background: #ffffff !important;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.04) !important;
    }

    .mini-cart-header-icon {
        width: 32px;
        height: 32px;
    }
    .mini-cart-state-icon {
        width: 56px;
        height: 56px;
    }

    /* Item trong drawer */
    .mini-cart-drawer .drawer-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
        position: relative;
        transition: all 0.2s ease;
    }
    .mini-cart-drawer .drawer-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .mini-cart-drawer .drawer-item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #f1f5f9;
        flex-shrink: 0;
    }
    .mini-cart-drawer .drawer-item-info {
        flex-grow: 1;
        min-width: 0;
    }
    .mini-cart-drawer .drawer-item-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: #0f172a;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 2px;
        transition: color 0.15s;
    }
    .mini-cart-drawer .drawer-item-title:hover {
        color: #198754;
    }
    .mini-cart-drawer .drawer-color-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
    }
    .mini-cart-drawer .drawer-btn-remove {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 0.8rem;
        padding: 3px;
        cursor: pointer;
        transition: all 0.15s;
        border-radius: 4px;
        line-height: 1;
    }
    .mini-cart-drawer .drawer-btn-remove:hover {
        color: #dc3545;
        background-color: #fee2e2;
    }

    /* Stepper mini trong drawer */
    .drawer-stepper {
        display: inline-flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        background: #ffffff;
        padding: 1px 3px;
    }
    .drawer-stepper-btn {
        width: 20px;
        height: 20px;
        border: none;
        background: transparent;
        color: #0f172a;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
    }
    .drawer-stepper-btn:hover:not(:disabled) {
        background-color: #f1f5f9;
    }
    .drawer-stepper-btn:active:not(:disabled) {
        transform: scale(0.9);
    }
    .drawer-stepper-btn:disabled {
        color: #cbd5e1;
        cursor: not-allowed;
    }
    .drawer-stepper-input {
        width: 26px;
        border: none;
        background: transparent;
        text-align: center;
        font-size: 0.78rem;
        font-weight: 700;
        color: #0f172a;
        padding: 0;
        outline: none;
    }
    .drawer-stepper-input::-webkit-outer-spin-button,
    .drawer-stepper-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .drawer-item-removing {
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.25s ease;
    }
</style>

<script>
(function() {
    const FREESHIP_THRESHOLD = 500000;

    const drawer = document.getElementById('miniCartDrawer');
    const backdrop = document.getElementById('miniCartBackdrop');

    function formatMoney(n) {
        return new Intl.NumberFormat('vi-VN').format(n) + ' ₫';
    }

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    // Mở Drawer
    window.openMiniCartDrawer = function() {
        if (drawer) {
            drawer.classList.add('open');
            drawer.setAttribute('aria-hidden', 'false');
        }
        if (backdrop) {
            backdrop.classList.add('show');
        }
        document.body.style.overflow = 'hidden';
        window.loadMiniCartData();
    };

    // Đóng Drawer
    window.closeMiniCartDrawer = function() {
        if (drawer) {
            drawer.classList.remove('open');
            drawer.setAttribute('aria-hidden', 'true');
        }
        if (backdrop) {
            backdrop.classList.remove('show');
        }
        document.body.style.overflow = '';
    };

    // Đóng khi bấm Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) {
            window.closeMiniCartDrawer();
        }
    });

    // Đồng bộ số lượng badge giỏ hàng trên toàn trang
    window.updateCartBadgeCount = function(count) {
        const num = parseInt(count, 10) || 0;
        document.querySelectorAll('.header-cart-badge').forEach(el => {
            el.textContent = num > 99 ? '99+' : num;
            if (num > 0) {
                el.classList.remove('d-none');
            } else {
                el.classList.add('d-none');
            }
        });
        const drawerBadge = document.getElementById('drawerCartBadge');
        if (drawerBadge) {
            drawerBadge.textContent = num;
        }
    };

    // Cập nhật thanh Freeship trong Drawer
    function updateDrawerFreeship(subtotal) {
        const progressBar = document.getElementById('drawerFreeshipProgressBar');
        const statusText = document.getElementById('drawerFreeshipStatusText');
        if (!progressBar || !statusText) return;

        if (subtotal <= 0) {
            progressBar.style.width = '0%';
            statusText.innerHTML = 'Thêm sản phẩm để nhận ưu đãi <strong>Freeship</strong>';
        } else if (subtotal >= FREESHIP_THRESHOLD) {
            progressBar.style.width = '100%';
            statusText.innerHTML = '🎉 Đơn hàng đã đạt <strong>Miễn phí vận chuyển toàn quốc!</strong>';
        } else {
            const percent = Math.min(100, Math.round((subtotal / FREESHIP_THRESHOLD) * 100));
            const remaining = FREESHIP_THRESHOLD - subtotal;
            progressBar.style.width = percent + '%';
            statusText.innerHTML = `Mua thêm <strong>${formatMoney(remaining)}</strong> để được <strong>Freeship</strong>`;
        }
    }

    // Tải dữ liệu giỏ hàng từ API
    window.loadMiniCartData = function() {
        const loading = document.getElementById('drawerCartLoading');
        const guest = document.getElementById('drawerCartGuest');
        const empty = document.getElementById('drawerCartEmpty');
        const itemsContainer = document.getElementById('drawerCartItems');
        const footer = document.getElementById('drawerCartFooter');
        const subtotalEl = document.getElementById('drawerCartSubtotal');
        const freeshipBox = document.getElementById('drawerFreeshipBox');

        if (!loading || !itemsContainer) return;

        loading.style.display = 'block';
        guest.classList.add('d-none');
        empty.classList.add('d-none');
        itemsContainer.style.display = 'none';
        footer.style.display = 'none';

        fetch('<?php echo e(route('api.cart.drawer-data')); ?>', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            loading.style.display = 'none';

            if (!data.logged_in) {
                guest.classList.remove('d-none');
                window.updateCartBadgeCount(0);
                if (freeshipBox) freeshipBox.style.display = 'none';
                return;
            }

            if (freeshipBox) freeshipBox.style.display = 'block';
            window.updateCartBadgeCount(data.total_items || data.total_qty || 0);
            updateDrawerFreeship(data.subtotal || 0);

            if (!data.items || data.items.length === 0) {
                empty.classList.remove('d-none');
                return;
            }

            // Render từng món hàng
            let html = '';
            data.items.forEach(item => {
                const colorHtml = item.color ? `
                    <span class="d-inline-flex align-items-center gap-1">
                        ${item.color_code ? `<span class="drawer-color-dot" style="background-color: ${item.color_code}"></span>` : ''}
                        ${item.color}
                    </span>` : '';
                const sizeHtml = item.size ? `<span class="badge bg-light text-dark border px-1-5 py-0-5 fs-9">Size ${item.size}</span>` : '';
                const variantDivider = (colorHtml && sizeHtml) ? '<span class="text-muted fs-9">•</span>' : '';
                const maxStock = item.max_stock || 99;

                html += `
                    <div class="drawer-item" id="drawer-item-${item.id}">
                        <a href="${item.url}" class="flex-shrink-0">
                            <img src="${item.image}" alt="${item.name}" class="drawer-item-img">
                        </a>
                        <div class="drawer-item-info">
                            <div class="d-flex justify-content-between align-items-start gap-1 mb-1">
                                <a href="${item.url}" class="drawer-item-title" title="${item.name}">${item.name}</a>
                                <button type="button" class="drawer-btn-remove" onclick="window.removeDrawerItem(${item.id})" title="Xóa món">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-1 mb-1-5 fs-9 text-muted">
                                ${colorHtml}
                                ${variantDivider}
                                ${sizeHtml}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success fs-8 drawer-item-price" id="drawer-item-price-${item.id}">
                                    ${item.thanh_tien_formatted}
                                </span>

                                <!-- Stepper mini -->
                                <div class="drawer-stepper" data-item-id="${item.id}" data-max="${maxStock}">
                                    <button type="button" class="drawer-stepper-btn" onclick="window.updateDrawerQty(${item.id}, -1)" ${item.so_luong <= 1 ? 'disabled' : ''} aria-label="Giảm">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="drawer-stepper-input" id="drawer-qty-input-${item.id}" value="${item.so_luong}" readonly>
                                    <button type="button" class="drawer-stepper-btn" onclick="window.updateDrawerQty(${item.id}, 1)" ${item.so_luong >= maxStock ? 'disabled' : ''} aria-label="Tăng">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            itemsContainer.innerHTML = html;
            itemsContainer.style.display = 'block';

            if (subtotalEl) subtotalEl.textContent = data.subtotal_formatted || '0 ₫';
            footer.style.display = 'block';
        })
        .catch(err => {
            loading.style.display = 'none';
            empty.classList.remove('d-none');
        });
    };

    // Cập nhật số lượng trực tiếp trong Drawer qua AJAX
    window.updateDrawerQty = function(itemId, change) {
        const input = document.getElementById(`drawer-qty-input-${itemId}`);
        if (!input) return;

        let currentQty = parseInt(input.value, 10) || 1;
        let newQty = currentQty + change;
        if (newQty < 1) return;

        input.value = newQty;

        fetch(`<?php echo e(url("/gio-hang")); ?>/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ so_luong: newQty })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Cập nhật lại toàn bộ giỏ hàng drawer
                window.loadMiniCartData();

                // Nếu đang đứng ở trang giỏ hàng chính thì đồng bộ luôn
                const cartPageQtyInput = document.querySelector(`.cart-item-row[data-item-id="${itemId}"] .qty-input`);
                if (cartPageQtyInput) {
                    cartPageQtyInput.value = data.so_luong;
                    const cell = document.querySelector(`.cart-item-row[data-item-id="${itemId}"] .thanh-tien-cell`);
                    if (cell) {
                        cell.setAttribute('data-value', data.thanh_tien);
                        cell.textContent = formatMoney(data.thanh_tien);
                    }
                    if (typeof refreshTotals === 'function') refreshTotals();
                }
            } else {
                input.value = currentQty;
                alert(data.message || 'Không thể cập nhật số lượng.');
            }
        })
        .catch(() => {
            input.value = currentQty;
            alert('Lỗi cập nhật số lượng. Vui lòng thử lại.');
        });
    };

    // Xóa món nhanh từ Drawer
    window.removeDrawerItem = function(itemId) {
        const token = getCsrfToken();
        if (!token) return;

        const itemEl = document.getElementById(`drawer-item-${itemId}`);
        if (itemEl) {
            itemEl.classList.add('drawer-item-removing');
        }

        fetch(`/api/cart/quick-remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (itemEl) itemEl.remove();
                window.loadMiniCartData();

                // Nếu đang ở trang giỏ hàng chính thì xóa dòng tương ứng
                const cartPageRows = document.querySelectorAll(`[data-item-id="${itemId}"]`);
                cartPageRows.forEach(r => r.remove());
                if (typeof refreshTotals === 'function') refreshTotals();

                if (typeof window.showClientToast === 'function') {
                    window.showClientToast('Đã xóa sản phẩm khỏi giỏ hàng.', 'success');
                }
            } else {
                if (itemEl) itemEl.classList.remove('drawer-item-removing');
                alert(data.message || 'Không thể xóa sản phẩm.');
            }
        })
        .catch(() => {
            if (itemEl) itemEl.classList.remove('drawer-item-removing');
            alert('Lỗi khi xóa sản phẩm. Vui lòng thử lại.');
        });
    };
})();
</script><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\client\layout\mini-cart-drawer.blade.php ENDPATH**/ ?>