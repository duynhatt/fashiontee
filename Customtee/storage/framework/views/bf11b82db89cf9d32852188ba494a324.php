<!DOCTYPE html>
<html lang="en">

<head>
    <title>FASHION</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- ICON -->
    <link rel="apple-touch-icon" href="<?php echo e(asset('img/apple-icon.png')); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('img/favicon.ico')); ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/templatemo.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONT -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">

    <link rel="stylesheet" href="<?php echo e(asset('css/fontawesome.min.css')); ?>">


</head>

<body>
    <style>
        .custom-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 250px;
            max-width: 320px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            animation: slideIn 0.4s ease;
        }

        .custom-toast.success {
            background: #28a745;
        }

        .custom-toast.error {
            background: #dc3545;
        }

        .custom-toast.warning {
            background: #ffc107;
            color: #212529;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-out {
            animation: fadeOut 0.5s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(50px);
            }
        }
    </style>


    <!-- Floating Island Header -->
    <header class="fashion-floating-header-wrapper position-sticky w-100" id="fashionFloatingHeader">
        <div class="container-xl px-2 px-sm-3 px-lg-4">
            <nav class="navbar navbar-expand-lg fashion-floating-navbar py-2 px-3 px-lg-4" id="fashionFloatingNavbar">
                <div class="container-fluid px-0 d-flex justify-content-between align-items-center">

                    <!-- Brand Logo -->
                    <a class="navbar-brand d-flex align-items-center gap-1 text-decoration-none py-1" href="<?php echo e(url('/')); ?>">
                        <span class="fashion-brand-logo fw-extrabold fs-4 tracking-tight">FASHION<span class="text-success">NIGGA</span></span>
                    </a>

                    <!-- Mobile Toggler Button -->
                    <button class="navbar-toggler border-0 shadow-none p-1-5 rounded-circle" type="button" data-bs-toggle="collapse"
                        data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation" id="fashionNavbarToggler">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Nav Links & Actions -->
                    <div class="collapse navbar-collapse flex-grow-1" id="templatemo_main_nav">
                        <!-- Navigation Menu (Centered) -->
                        <ul class="navbar-nav mx-auto d-flex align-items-lg-center gap-1 py-2 py-lg-0 fashion-menu-list">
                            <li class="nav-item">
                                <a class="nav-link fashion-nav-pill <?php echo e(request()->is('/') ? 'active' : ''); ?>" href="<?php echo e(url('/')); ?>">
                                    Trang chủ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fashion-nav-pill <?php echo e(request()->is('Shop*') || request()->is('san-pham*') ? 'active' : ''); ?>" href="<?php echo e(url('/Shop')); ?>">
                                    Cửa hàng
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fashion-nav-pill <?php echo e(request()->is('Contact*') ? 'active' : ''); ?>" href="<?php echo e(url('/Contact')); ?>">
                                    Liên hệ
                                </a>
                            </li>
                        </ul>

                        <!-- Action Icons & Auth -->
                        <div class="d-flex align-items-center gap-2 pt-3 pt-lg-0 border-top border-light-subtle border-top-lg-0">

                            <!-- Mobile Quick Search Bar (Inside drawer) -->
                            <div class="d-lg-none w-100 mb-3">
                                <form action="<?php echo e(url('/Shop')); ?>" method="get">
                                    <div class="position-relative w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded-pill fs-7 ps-3 border-light-subtle" id="inputMobileSearch" name="q"
                                                value="<?php echo e(request('q')); ?>" placeholder="Tìm áo thun..." autocomplete="off">
                                            <button class="btn btn-dark rounded-pill px-3 ms-1" type="submit" aria-label="Tìm kiếm">
                                                <i class="fa fa-fw fa-search"></i>
                                            </button>
                                        </div>
                                        <div id="liveSearchResultsMobile" class="live-search-dropdown shadow-lg rounded-3 border d-none">
                                            <div id="liveSearchContentMobile"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Desktop Search Trigger Modal -->
                            <a class="nav-icon-circle d-none d-lg-inline-flex align-items-center justify-content-center text-decoration-none" href="#" data-bs-toggle="modal"
                                data-bs-target="#templatemo_search" title="Tìm kiếm">
                                <i class="fa fa-fw fa-search text-dark"></i>
                            </a>

                            <!-- Mini-Cart Drawer Trigger -->
                            <?php
                                $headerCartCount = auth()->check()
                                    ? \App\Models\GioHang::where('nguoi_dung_id', auth()->id())
                                        ->dangTrongGio()
                                        ->whereNotNull('bien_the_id')
                                        ->count()
                                    : 0;
                            ?>
                            <a class="nav-icon-circle position-relative d-inline-flex align-items-center justify-content-center text-decoration-none"
                                href="javascript:void(0)"
                                onclick="window.openMiniCartDrawer(); return false;"
                                title="Giỏ hàng">
                                <i class="fa fa-fw fa-shopping-bag text-dark"></i>
                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger header-cart-badge <?php echo e($headerCartCount > 0 ? '' : 'd-none'); ?>">
                                    <?php echo e($headerCartCount > 99 ? '99+' : $headerCartCount); ?>

                                </span>
                            </a>

                            <!-- User Auth Links / Profile Dropdown -->
                            <?php if(auth()->guard()->guest()): ?>
                                <div class="d-flex align-items-center gap-1-5 ms-1">
                                    <a class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1-5 fw-semibold fs-8" href="<?php echo e(url('/login')); ?>">
                                        Đăng nhập
                                    </a>
                                    <a class="btn btn-sm btn-dark rounded-pill px-3 py-1-5 fw-semibold fs-8 d-none d-sm-inline-block" href="<?php echo e(url('/register')); ?>">
                                        Đăng ký
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="dropdown ms-1">
                                    <a class="user-pill-btn d-flex align-items-center gap-2 text-decoration-none dropdown-toggle rounded-pill p-1 pe-2-5" href="#"
                                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="<?php echo e(auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/default-avatar.png')); ?>"
                                            class="rounded-circle border border-2 border-white shadow-xs" width="34" height="34" style="object-fit: cover">
                                        <span class="fw-semibold fs-8 text-dark d-none d-md-inline text-truncate" style="max-width: 120px;">
                                            <?php echo e(auth()->user()->name); ?>

                                        </span>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border border-light-subtle rounded-3 p-2 mt-2" aria-labelledby="userDropdown">
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2 fs-8 fw-medium" href="<?php echo e(route('profile')); ?>">
                                                <i class="fa fa-user text-muted me-2"></i> Thông tin cá nhân
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2 fs-8 fw-medium" href="<?php echo e(route('order')); ?>">
                                                <i class="fa fa-box text-muted me-2"></i> Đơn hàng của tôi
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form method="POST" action="<?php echo e(url('/logout')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button class="dropdown-item rounded-2 py-2 fs-8 fw-medium text-danger" type="submit">
                                                    <i class="fa fa-sign-out-alt me-2"></i> Đăng xuất
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </nav>
        </div>
    </header>
    <!-- Close Header -->

    <?php if(session('success')): ?>
        <div class="custom-toast success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="custom-toast error">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Search Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(url('/Shop')); ?>" method="get" class="modal-content modal-body border-0 p-0">
                <div class="position-relative w-100">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control form-control-lg" id="inputModalSearch" name="q"
                            value="<?php echo e(request('q')); ?>" placeholder="Nhập tên sản phẩm cần tìm..." autocomplete="off">
                        <button type="submit" class="input-group-text bg-success text-light px-4">
                            <i class="fa fa-fw fa-search text-white"></i>
                        </button>
                    </div>
                    <!-- Live Search Dropdown -->
                    <div id="liveSearchResults" class="live-search-dropdown shadow-lg rounded-3 border d-none">
                        <div id="liveSearchContent"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <?php echo $__env->make('client.layout.mini-cart-drawer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        /* ============================================================
           FLOATING ISLAND HEADER & SOFT CAPSULE PILL HOVER
           ============================================================ */
        @keyframes levitateFloat {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03);
            }
            50% {
                transform: translateY(-4px) rotate(0.12deg);
                box-shadow: 0 18px 40px -10px rgba(15, 23, 42, 0.14), 0 6px 12px -2px rgba(15, 23, 42, 0.05);
            }
        }

        @keyframes levitateFloatScrolled {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                box-shadow: 0 14px 35px -8px rgba(15, 23, 42, 0.12), 0 4px 8px -2px rgba(15, 23, 42, 0.04);
            }
            50% {
                transform: translateY(-5px) rotate(-0.15deg);
                box-shadow: 0 24px 48px -10px rgba(15, 23, 42, 0.18), 0 8px 16px -2px rgba(15, 23, 42, 0.06);
            }
        }

        @keyframes headerWobble {
            0%   { transform: translateY(0) scale(1); }
            20%  { transform: translateY(-3px) scale(1.008) rotate(-0.35deg); }
            40%  { transform: translateY(-1px) scale(1.005) rotate(0.3deg); }
            60%  { transform: translateY(-2.5px) scale(1.006) rotate(-0.15deg); }
            80%  { transform: translateY(-2px) scale(1.005) rotate(0.08deg); }
            100% { transform: translateY(-2px) scale(1.005) rotate(0deg); }
        }

        @keyframes pillJiggle {
            0%   { transform: scale(1) translateY(0); }
            30%  { transform: scale(1.06) translateY(-2px) rotate(-1.2deg); }
            60%  { transform: scale(1.03) translateY(-1px) rotate(0.9deg); }
            100% { transform: scale(1.04) translateY(-1px) rotate(0deg); }
        }

        @keyframes iconJiggle {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25%      { transform: rotate(-12deg) scale(1.18); }
            50%      { transform: rotate(12deg) scale(1.2); }
            75%      { transform: rotate(-6deg) scale(1.12); }
        }

        @keyframes logoJiggle {
            0%, 100% { transform: scale(1) rotate(0deg); }
            30%      { transform: scale(1.05) rotate(-1.5deg); }
            60%      { transform: scale(1.03) rotate(1deg); }
        }

        .fashion-floating-header-wrapper {
            position: sticky;
            top: 6px;
            top: 6px !important;
            padding-top: 18px;
            padding-bottom: 8px;
            z-index: 1040;
            pointer-events: none;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), top 0.3s ease;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), top 0.3s ease, padding 0.3s ease;
        }

        .fashion-floating-navbar {
            pointer-events: auto;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 999px;
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03);
            animation: levitateFloat 4s ease-in-out infinite;
            will-change: transform, box-shadow;
            transition: background 0.3s ease, border-color 0.3s ease, padding 0.3s ease;
        }

        /* Hover on navbar triggers gentle spring wobble */
        .fashion-floating-navbar:hover {
            animation: headerWobble 0.7s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            box-shadow: 0 20px 42px -10px rgba(15, 23, 42, 0.16), 0 6px 14px -2px rgba(15, 23, 42, 0.05);
        }

        /* Scrolled state: stronger levitation bobbing */
        /* Scrolled state: comfortable offset from top of window */
        .fashion-floating-header-wrapper.is-scrolled {
            top: 14px !important;
            padding-top: 10px;
            padding-bottom: 6px;
        }

        .fashion-floating-header-wrapper.is-scrolled .fashion-floating-navbar {
            background: rgba(255, 255, 255, 0.96);
            border-color: rgba(203, 213, 225, 0.95);
            animation: levitateFloatScrolled 3.5s ease-in-out infinite;
            padding-top: 6px !important;
            padding-bottom: 6px !important;
        }

        .fashion-floating-header-wrapper.is-scrolled .fashion-floating-navbar:hover {
            animation: headerWobble 0.7s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        /* Mobile expanded state: pause bobbing to keep menu steady */
        .fashion-floating-navbar.is-expanded {
            border-radius: 24px !important;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.15);
            animation: none !important;
            transform: none !important;
        }

        /* Brand Logo */
        .fashion-brand-logo {
            letter-spacing: -0.02em;
            color: #0f172a;
            display: inline-block;
            transition: transform 0.2s ease;
        }
        .navbar-brand:hover .fashion-brand-logo {
            animation: logoJiggle 0.5s ease-in-out;
        }

        /* Soft Capsule Pill Menu */
        .fashion-menu-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .fashion-nav-pill {
            color: #475569 !important;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 18px !important;
            border-radius: 999px;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            text-decoration: none;
            display: inline-block;
        }

        /* Soft Capsule Hover + Jiggle */
        .fashion-nav-pill:hover {
            background-color: rgba(15, 23, 42, 0.06) !important;
            color: #0f172a !important;
            animation: pillJiggle 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        /* Active Pill */
        .fashion-nav-pill.active {
            background-color: #0f172a !important;
            color: #ffffff !important;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.18);
        }
        .fashion-nav-pill.active:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        /* Icon Circles */
        .nav-icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #0f172a;
            background: transparent;
            transition: all 0.2s ease;
        }
        .nav-icon-circle:hover {
            background-color: rgba(15, 23, 42, 0.06);
            color: #0f172a;
        }
        .nav-icon-circle:hover i {
            animation: iconJiggle 0.45s ease-in-out;
            display: inline-block;
        }

        /* User Profile Pill */
        .user-pill-btn {
            background: rgba(15, 23, 42, 0.04);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.2s ease;
        }
        .user-pill-btn:hover {
            background: rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
            transform: scale(1.02);
        }

        /* Cart Badge */
        .header-cart-badge {
            font-size: 0.68rem;
            padding: 3px 6px;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
        }

        @media (prefers-reduced-motion: reduce) {
            .fashion-floating-navbar {
                animation: none !important;
                transform: none !important;
            }
            .fashion-nav-pill:hover,
            .navbar-brand:hover .fashion-brand-logo,
            .nav-icon-circle:hover i {
                animation: none !important;
            }
        }

        .live-search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            z-index: 1060;
            max-height: 420px;
            overflow-y: auto;
            margin-top: 4px;
        }
        .live-search-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid #f2f2f2;
            transition: background 0.15s;
        }
        .live-search-item:last-child {
            border-bottom: none;
        }
        .live-search-item:hover {
            background-color: #f8f9fa;
        }
        .live-search-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #eee;
            flex-shrink: 0;
        }
        .live-search-info {
            flex-grow: 1;
            min-width: 0;
        }
        .live-search-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #212529;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 2px;
        }
        .live-search-category {
            font-size: 0.75rem;
            color: #6c757d;
        }
        .live-search-price {
            font-size: 0.88rem;
            font-weight: 700;
            color: #198754;
            text-align: right;
            white-space: nowrap;
        }
        .live-search-footer {
            padding: 10px;
            text-align: center;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }
        .live-search-footer a {
            font-size: 0.85rem;
            font-weight: 600;
            color: #198754;
            text-decoration: none;
        }
        .live-search-footer a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        // Global Client Toast Notification
        window.showClientToast = function(message, type) {
            if (!message) return;
            type = type === 'error' ? 'error' : (type === 'warning' ? 'warning' : 'success');
            const el = document.createElement('div');
            el.className = 'custom-toast ' + type;
            el.setAttribute('role', 'alert');
            el.style.whiteSpace = 'pre-wrap';
            el.textContent = message;
            document.body.appendChild(el);
            setTimeout(function() {
                el.classList.add('fade-out');
                setTimeout(() => {
                    if (el.parentNode) el.remove();
                }, 500);
            }, type === 'error' ? 5000 : 3500);
        };

        setTimeout(function() {
            const toasts = document.querySelectorAll('.custom-toast');
            toasts.forEach(function(toast) {
                toast.classList.add('fade-out');
                setTimeout(() => toast.remove(), 500);
            });
        }, 3000);

        // Live Search Handler
        function initLiveSearch(inputId, resultsId, contentId) {
            const input = document.getElementById(inputId);
            const results = document.getElementById(resultsId);
            const content = document.getElementById(contentId);
            if (!input || !results || !content) return;

            let debounceTimer = null;

            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
            }

            input.addEventListener('input', function() {
                const q = this.value.trim();
                clearTimeout(debounceTimer);

                if (q.length < 1) {
                    results.classList.add('d-none');
                    content.innerHTML = '';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    content.innerHTML = `
                        <div class="p-3 text-center text-muted small">
                            <span class="spinner-border spinner-border-sm text-success me-2" role="status"></span>
                            Đang tìm sản phẩm...
                        </div>
                    `;
                    results.classList.remove('d-none');

                    fetch(`/api/search/suggest?q=${encodeURIComponent(q)}`)
                        .then(r => r.json())
                        .then(res => {
                            if (!res.success || !res.data || res.data.length === 0) {
                                content.innerHTML = `
                                    <div class="p-3 text-center text-muted small">
                                        <i class="fa fa-info-circle me-1"></i> Không tìm thấy sản phẩm nào khớp với "<strong>${escapeHtml(q)}</strong>"
                                    </div>
                                `;
                                return;
                            }

                            let html = '<div class="live-search-list">';
                            res.data.forEach(item => {
                                html += `
                                    <a href="${item.url}" class="live-search-item">
                                        <img src="${item.image}" alt="${escapeHtml(item.name)}" class="live-search-thumb">
                                        <div class="live-search-info">
                                            <div class="live-search-title">${escapeHtml(item.name)}</div>
                                            <div class="live-search-category"><i class="fa fa-tag me-1"></i>${escapeHtml(item.category_name)}</div>
                                        </div>
                                        <div class="live-search-price">${item.price_formatted}</div>
                                    </a>
                                `;
                            });
                            html += '</div>';

                            if (res.total > 0) {
                                html += `
                                    <div class="live-search-footer">
                                        <a href="<?php echo e(url('/Shop')); ?>?q=${encodeURIComponent(q)}">
                                            Xem tất cả ${res.total} sản phẩm <i class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                `;
                            }

                            content.innerHTML = html;
                        })
                        .catch(() => {
                            content.innerHTML = `
                                <div class="p-3 text-center text-danger small">
                                    Lỗi khi tìm kiếm. Vui lòng thử lại.
                                </div>
                            `;
                        });
                }, 280);
            });

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !results.contains(e.target)) {
                    results.classList.add('d-none');
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    results.classList.add('d-none');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initLiveSearch('inputModalSearch', 'liveSearchResults', 'liveSearchContent');
            initLiveSearch('inputMobileSearch', 'liveSearchResultsMobile', 'liveSearchContentMobile');

            // Floating Header Scroll & Mobile Expand Listeners
            (function() {
                const headerWrapper = document.getElementById('fashionFloatingHeader');
                const navbarEl = document.getElementById('fashionFloatingNavbar');
                const mainNavCollapse = document.getElementById('templatemo_main_nav');

                if (headerWrapper && navbarEl) {
                    function handleScroll() {
                        if (window.scrollY > 30) {
                            headerWrapper.classList.add('is-scrolled');
                        } else {
                            headerWrapper.classList.remove('is-scrolled');
                        }
                    }

                    window.addEventListener('scroll', handleScroll, { passive: true });
                    handleScroll();

                    if (mainNavCollapse) {
                        mainNavCollapse.addEventListener('show.bs.collapse', function () {
                            navbarEl.classList.add('is-expanded');
                        });
                        mainNavCollapse.addEventListener('hide.bs.collapse', function () {
                            navbarEl.classList.remove('is-expanded');
                        });
                    }
                }
            })();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/client/layout/header.blade.php ENDPATH**/ ?>