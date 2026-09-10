
<div class="mini-cart-backdrop" id="miniCartBackdrop" onclick="window.closeMiniCartDrawer()"></div>


<div class="mini-cart-drawer" id="miniCartDrawer" aria-hidden="true">
    
    <div class="mini-cart-header border-bottom py-3 px-3 d-flex justify-content-between align-items-center bg-light">
        <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-0 fs-6">
            <i class="fa fa-shopping-bag text-success"></i> Giỏ hàng của bạn
            <span class="badge bg-success rounded-pill" id="drawerCartBadge">0</span>
        </h5>
        <button type="button" class="btn-close" onclick="window.closeMiniCartDrawer()" aria-label="Đóng"></button>
    </div>

    
    <div class="mini-cart-body d-flex flex-column" id="miniCartBody">
        <!-- Loading spinner -->
        <div id="drawerCartLoading" class="text-center py-5">
            <div class="spinner-border text-success" role="status" style="width: 2.2rem; height: 2.2rem;">
                <span class="visually-hidden">Đang tải...</span>
            </div>
            <p class="text-muted small mt-2 mb-0">Đang tải giỏ hàng...</p>
        </div>

        <!-- Khách chưa đăng nhập -->
        <div id="drawerCartGuest" class="d-none text-center py-5 px-4 my-auto">
            <div class="mb-3">
                <i class="bi bi-person-lock text-muted" style="font-size: 3.2rem;"></i>
            </div>
            <h6 class="fw-bold text-dark mb-2">Vui lòng đăng nhập</h6>
            <p class="text-muted small mb-4">Đăng nhập tài khoản để xem giỏ hàng và thanh toán nhanh chóng hơn.</p>
            <div class="d-grid gap-2">
                <a href="<?php echo e(route('login')); ?>" class="btn btn-success fw-semibold">
                    <i class="fa fa-sign-in-alt me-1"></i> Đăng nhập ngay
                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-secondary">
                    Tạo tài khoản mới
                </a>
            </div>
        </div>

        <!-- Giỏ hàng trống -->
        <div id="drawerCartEmpty" class="d-none text-center py-5 px-4 my-auto">
            <div class="mb-3">
                <i class="bi bi-cart-x text-muted" style="font-size: 3.2rem;"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Giỏ hàng đang trống</h6>
            <p class="text-muted small mb-4">Hãy chọn những mẫu áo yêu thích để thêm vào giỏ nhé!</p>
            <a href="<?php echo e(url('/Shop')); ?>" class="btn btn-success px-4 rounded-pill" onclick="window.closeMiniCartDrawer()">
                <i class="fa fa-shopping-cart me-1"></i> Khám phá sản phẩm
            </a>
        </div>

        <!-- Danh sách sản phẩm -->
        <div id="drawerCartItems" class="p-3 flex-grow-1" style="display: none;">
            <!-- Render items động qua JS -->
        </div>
    </div>

    
    <div class="mini-cart-footer border-top p-3 bg-light" id="drawerCartFooter" style="display: none;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted fw-semibold">Tạm tính:</span>
            <span class="fw-bold text-success fs-5" id="drawerCartSubtotal">0 ₫</span>
        </div>
        <div class="d-grid gap-2">
            <a href="<?php echo e(route('gio-hang.index')); ?>" class="btn btn-outline-success fw-semibold py-2">
                <i class="fa fa-cart-arrow-down me-1"></i> Xem chi tiết giỏ hàng
            </a>
            <a href="<?php echo e(route('dat-hang')); ?>" class="btn btn-success fw-semibold py-2 shadow-sm">
                Tiến hành thanh toán <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<style>
    /* Nền mờ Backdrop */
    .mini-cart-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.55);
        z-index: 9998;
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

    /* Container Drawer trượt từ bên phải */
    .mini-cart-drawer {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 390px !important;
        max-width: 90vw !important;
        height: 100vh !important;
        background-color: #fff !important;
        z-index: 9999 !important;
        box-shadow: -5px 0 25px rgba(0, 0, 0, 0.18) !important;
        transform: translateX(100%) !important;
        visibility: hidden !important;
        pointer-events: none !important;
        transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), visibility 0.3s !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .mini-cart-drawer.open {
        transform: translateX(0) !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    .mini-cart-body {
        flex: 1 1 auto;
        overflow-y: auto;
    }

    /* Item trong giỏ hàng */
    .mini-cart-drawer .drawer-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1px solid #f0f0f0;
        position: relative;
        transition: background 0.2s;
    }
    .mini-cart-drawer .drawer-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .mini-cart-drawer .drawer-item-img {
        width: 62px;
        height: 62px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eaeaea;
        flex-shrink: 0;
    }
    .mini-cart-drawer .drawer-item-info {
        flex-grow: 1;
        min-width: 0;
    }
    .mini-cart-drawer .drawer-item-title {
        font-size: 0.88rem;
        font-weight: 600;
        color: #212529;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 3px;
    }
    .mini-cart-drawer .drawer-item-title:hover {
        color: #198754;
    }
    .mini-cart-drawer .drawer-item-variant {
        font-size: 0.76rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 3px;
    }
    .mini-cart-drawer .drawer-color-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
    }
    .mini-cart-drawer .drawer-item-price {
        font-size: 0.84rem;
        font-weight: 600;
        color: #198754;
    }
    .mini-cart-drawer .drawer-btn-remove {
        background: transparent;
        border: none;
        color: #dc3545;
        font-size: 0.85rem;
        padding: 4px 8px;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
        border-radius: 4px;
    }
    .mini-cart-drawer .drawer-btn-remove:hover {
        opacity: 1;
        background-color: #fee2e2;
    }
</style>

<script>
    (function() {
        const drawer = document.getElementById('miniCartDrawer');
        const backdrop = document.getElementById('miniCartBackdrop');

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

        // Đóng khi bấm phím Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) {
                window.closeMiniCartDrawer();
            }
        });

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

        window.loadMiniCartData = function() {
            const loading = document.getElementById('drawerCartLoading');
            const guest = document.getElementById('drawerCartGuest');
            const empty = document.getElementById('drawerCartEmpty');
            const itemsContainer = document.getElementById('drawerCartItems');
            const footer = document.getElementById('drawerCartFooter');
            const subtotalEl = document.getElementById('drawerCartSubtotal');

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
                    return;
                }

                window.updateCartBadgeCount(data.total_items || data.total_qty || 0);

                if (!data.items || data.items.length === 0) {
                    empty.classList.remove('d-none');
                    return;
                }

                // Render items
                let html = '';
                data.items.forEach(item => {
                    const colorHtml = item.color ? `
                        <span class="d-inline-flex align-items-center gap-1">
                            ${item.color_code ? `<span class="drawer-color-dot" style="background-color: ${item.color_code}"></span>` : ''}
                            ${item.color}
                        </span>` : '';
                    const sizeHtml = item.size ? `<span class="badge bg-light text-dark border">${item.size}</span>` : '';
                    const variantDivider = (colorHtml && sizeHtml) ? '<span class="text-muted">•</span>' : '';

                    html += `
                        <div class="drawer-item" id="drawer-item-${item.id}">
                            <img src="${item.image}" alt="${item.name}" class="drawer-item-img">
                            <div class="drawer-item-info">
                                <a href="${item.url}" class="drawer-item-title" title="${item.name}">${item.name}</a>
                                <div class="drawer-item-variant">
                                    ${colorHtml}
                                    ${variantDivider}
                                    ${sizeHtml}
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="drawer-item-price">
                                        ${item.so_luong} × ${item.don_gia_formatted}
                                    </span>
                                    <button type="button" class="drawer-btn-remove" onclick="window.removeDrawerItem(${item.id})" title="Xóa món này">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                itemsContainer.innerHTML = html;
                itemsContainer.style.display = 'block';

                subtotalEl.textContent = data.subtotal_formatted || '0 ₫';
                footer.style.display = 'block';
            })
            .catch(err => {
                loading.style.display = 'none';
                empty.classList.remove('d-none');
            });
        };

        window.removeDrawerItem = function(itemId) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) return;

            const itemEl = document.getElementById(`drawer-item-${itemId}`);
            if (itemEl) {
                itemEl.style.opacity = '0.4';
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
                    if (typeof window.showClientToast === 'function') {
                        window.showClientToast('Đã xóa sản phẩm khỏi giỏ hàng.', 'success');
                    }
                    window.loadMiniCartData();
                } else {
                    if (itemEl) itemEl.style.opacity = '1';
                    if (typeof window.showClientToast === 'function') {
                        window.showClientToast(data.message || 'Không thể xóa sản phẩm.', 'error');
                    }
                }
            })
            .catch(() => {
                if (itemEl) itemEl.style.opacity = '1';
            });
        };
    })();
</script>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/client/layout/mini-cart-drawer.blade.php ENDPATH**/ ?>