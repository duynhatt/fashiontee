<!DOCTYPE html>
<html lang="en">

<head>
    <title>FashionTee</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ICON -->
    <link rel="apple-touch-icon" href="{{ asset('img/apple-icon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONT -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">

    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">


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


    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="{{ url('/') }}">
                FashionTee
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between"
                id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
<a class="nav-link" href="{{ url('/') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/Shop') }}">Cửa hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/Contact') }}">Liên hệ</a>
                        </li>
                    </ul>
                </div>

                <div class="navbar align-self-center d-flex">

                    <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                        <form action="{{ url('/Shop') }}" method="get">
                            <div class="position-relative w-100">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputMobileSearch" name="q"
                                        value="{{ request('q') }}" placeholder="Tìm sản phẩm..." autocomplete="off">
                                    <button class="input-group-text" type="submit">
                                        <i class="fa fa-fw fa-search"></i>
                                    </button>
                                </div>
                                <div id="liveSearchResultsMobile" class="live-search-dropdown shadow-lg rounded-3 border d-none">
                                    <div id="liveSearchContentMobile"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal"
                        data-bs-target="#templatemo_search" title="Tìm kiếm">
                        <i class="fa fa-fw fa-search text-dark mr-2"></i>
                    </a>

                    {{-- Icon Giỏ hàng mở Mini-Cart Drawer --}}
                    @php
                        $headerCartCount = auth()->check()
                            ? \App\Models\GioHang::where('nguoi_dung_id', auth()->id())
                                ->dangTrongGio()
                                ->whereNotNull('bien_the_id')
                                ->count()
                            : 0;
                    @endphp
                    <a class="nav-icon position-relative text-decoration-none"
                        href="javascript:void(0)"
                        onclick="window.openMiniCartDrawer(); return false;"
                        title="Giỏ hàng">
                        <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-danger header-cart-badge {{ $headerCartCount > 0 ? '' : 'd-none' }}">
                            {{ $headerCartCount > 99 ? '99+' : $headerCartCount }}
                        </span>
                    </a>

                    <!-- Auth Links -->
@guest
                        <a class="btn btn-outline-success me-2" href="{{ url('/login') }}">Đăng nhập</a>
                        <a class="btn btn-outline-primary me-2" href="{{ url('/register') }}">Đăng ký</a>
                    @else
                        <div class="dropdown">
                            <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#"
                                id="userDropdown" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/default-avatar.png') }}"
                                    class="rounded-circle me-2" width="50" height="50" style="object-fit: cover">
                                {{ auth()->user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <!-- Thông tin cá nhân -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fa fa-user me-2"></i> Thông tin cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('order') }}">
                                        <i class="fa fa-user me-2"></i> Đơn hàng của tôi
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <!-- Đăng xuất -->
                                <li>
                                    <form method="POST" action="{{ url('/logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fa fa-sign-out-alt me-2"></i> Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest






                </div>
            </div>

        </div>
    </nav>
    <!-- Close Header -->

    @if (session('success'))
        <div class="custom-toast success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="custom-toast error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/Shop') }}" method="get" class="modal-content modal-body border-0 p-0">
                <div class="position-relative w-100">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control form-control-lg" id="inputModalSearch" name="q"
                            value="{{ request('q') }}" placeholder="Nhập tên sản phẩm cần tìm..." autocomplete="off">
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

    {{-- Include Mini-Cart Drawer --}}
    @include('client.layout.mini-cart-drawer')

    <style>
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
                                        <a href="{{ url('/Shop') }}?q=${encodeURIComponent(q)}">
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
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>