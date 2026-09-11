@include('client.layout.header')

<!-- Main My Orders Page Wrapper -->
<div class="fashion-orders-page bg-light-subtle py-4 py-md-5">
    <div class="container-xl px-3 px-lg-4">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb fashion-orders-breadcrumb mb-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-house-door me-1"></i>Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark small fw-medium" aria-current="page">
                    Đơn hàng của tôi
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1 tracking-tight">
                    Đơn hàng của tôi
                    @if(isset($donHangs) && $donHangs->total() > 0)
                        <span class="text-muted fw-normal fs-6">({{ $donHangs->total() }} đơn)</span>
                    @endif
                </h1>
               
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

        @php
            $statusTabs = [
                'cho_xac_nhan' => 'Chờ xác nhận',
                'dang_xu_ly' => 'Đang xử lý',
                'dang_giao' => 'Đang giao',
                'da_giao' => 'Đã giao',
                'da_nhan_hang' => 'Đã nhận hàng',
                'da_hoan_thanh' => 'Đã hoàn thành',
                'da_huy' => 'Đã hủy',
                'tra_hang' => 'Trả hàng / Hoàn tiền',
            ];
            $currentStatus = $currentStatus ?? request('trang_thai');
            $currentSearch = $tuKhoa ?? request('q');
        @endphp

        <!-- Search Bar & Status Tabs Bar -->
        <div class="card border-0 shadow-xs rounded-4 bg-white p-3 mb-4">
            <!-- Search Input -->
            <form action="{{ route('order') }}" method="GET" class="mb-3">
                @if($currentStatus)
                    <input type="hidden" name="trang_thai" value="{{ $currentStatus }}">
                @endif
                <div class="input-group fashion-order-search-group">
                    <span class="input-group-text bg-light border-0 ps-3 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="q" value="{{ $currentSearch }}"
                        class="form-control bg-light border-0 fs-7 py-2"
                        placeholder="Tìm kiếm theo mã đơn hàng (VD: FT-...) hoặc tên sản phẩm..."
                        autocomplete="off">
                    @if(!empty($currentSearch))
                        <a href="{{ route('order', array_filter(['trang_thai' => $currentStatus])) }}"
                            class="input-group-text bg-light border-0 text-muted px-3 text-decoration-none" title="Xóa tìm kiếm">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    @endif
                    <button class="btn btn-dark px-4 fw-semibold fs-8 rounded-end-3" type="submit">
                        Tìm kiếm
                    </button>
                </div>
            </form>

            <!-- Capsule Pills Navigation -->
            <div class="fashion-order-tabs-scroll-wrap">
                <ul class="nav fashion-order-nav-pills gap-2 flex-nowrap flex-md-wrap mb-0">
                    <li class="nav-item">
                        <a class="nav-link fashion-order-pill {{ empty($currentStatus) ? 'active' : '' }}"
                            href="{{ route('order', array_filter(['q' => $currentSearch])) }}">
                            Tất cả đơn
                        </a>
                    </li>
                    @foreach($statusTabs as $key => $label)
                        <li class="nav-item">
                            <a class="nav-link fashion-order-pill {{ $currentStatus === $key ? 'active' : '' }}"
                                href="{{ route('order', array_filter(['trang_thai' => $key, 'q' => $currentSearch])) }}">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if($donHangs->isEmpty())
            <!-- Empty State -->
            <div class="card border-0 shadow-xs rounded-4 text-center py-5 my-3 bg-white">
                <div class="card-body py-5 px-3">
                    <div class="fashion-empty-icon rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-inbox text-muted fs-3"></i>
                    </div>
                    @if(!empty($currentSearch) || !empty($currentStatus))
                        <h4 class="fw-bold text-dark mb-1 fs-5">Không tìm thấy đơn hàng nào</h4>
                        <p class="text-muted small mx-auto mb-4" style="max-width: 420px;">
                            Không có đơn hàng nào khớp với điều kiện tìm kiếm hoặc trạng thái đang lọc.
                        </p>
                        <a href="{{ route('order') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold fs-8">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Xem tất cả đơn hàng
                        </a>
                    @else
                        <h4 class="fw-bold text-dark mb-1 fs-5">Bạn chưa có đơn hàng nào</h4>
                        <p class="text-muted small mx-auto mb-4" style="max-width: 420px;">
                            Khám phá ngay các bộ sưu tập áo thun mới nhất của FashionTee và bắt đầu mua sắm!
                        </p>
                        <a href="{{ url('/Shop') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold fs-8 shadow-xs">
                            <i class="bi bi-bag-plus me-1"></i> Khám phá sản phẩm
                        </a>
                    @endif
                </div>
            </div>
        @else
            <!-- Order Cards List -->
            <div class="fashion-orders-list d-flex flex-column gap-3 mb-4">
                @foreach($donHangs as $donHang)
                    @php
                        // Tính toán hiển thị trạng thái chuẩn
                        $hienThiTrangThai =
                            ((bool) $donHang->yeu_cau_huy && in_array($donHang->trang_thai, ['dang_xu_ly', 'cho_duyet_huy'], true))
                            ? 'dang_yeu_cau_huy'
                            : ($donHang->trang_thai === 'da_giao' && !empty($donHang->da_nhan_hang_at)
                                ? 'da_nhan_hang'
                                : $donHang->trang_thai);

                        $statusConfig = [
                            'cho_xac_nhan' => ['Chờ xác nhận', 'warning', 'bi bi-clock-history'],
                            'dang_xu_ly' => ['Đang xử lý', 'info', 'bi bi-gear'],
                            'dang_yeu_cau_huy' => ['Đang yêu cầu hủy', 'warning', 'bi bi-hourglass-split'],
                            'cho_duyet_huy' => ['Chờ duyệt hủy', 'warning', 'bi bi-hourglass-split'],
                            'dang_giao' => ['Đang giao hàng', 'primary', 'bi bi-truck'],
                            'da_giao' => ['Đã giao hàng', 'info', 'bi bi-box-seam'],
                            'da_nhan_hang' => ['Đã nhận hàng', 'success', 'bi bi-check2-circle'],
                            'da_hoan_thanh' => ['Đã hoàn thành', 'success', 'bi bi-patch-check-fill'],
                            'da_huy' => ['Đã hủy', 'danger', 'bi bi-x-circle'],
                        ];
                        $st = $statusConfig[$hienThiTrangThai] ?? ['Không xác định', 'secondary', 'bi bi-question-circle'];
                        $latestRefund = $donHang->refunds ? $donHang->refunds->first() : null;

                        // Countdown 3 ngày đổi trả
                        $showReturnCountdown =
                            $donHang->trang_thai === 'da_giao'
                            && !$donHang->yeu_cau_tra
                            && !empty($donHang->da_giao_at);
                        $returnDeadlineTs = $showReturnCountdown
                            ? $donHang->da_giao_at->copy()->addDays(3)->getTimestampMs()
                            : null;

                        // Điều kiện hủy đơn
                        $canCancelDirect = $donHang->trang_thai === 'cho_xac_nhan' && !(bool)$donHang->yeu_cau_huy;
                        $canRequestCancel = $donHang->trang_thai === 'dang_xu_ly' && !(bool)$donHang->yeu_cau_huy && (int)($donHang->so_lan_yeu_cau_huy ?? 0) < 2;
                        $canCancel = $canCancelDirect || $canRequestCancel;

                        // Đơn có thể mua lại
                        $canReorder = in_array($donHang->trang_thai, ['da_hoan_thanh', 'da_huy'], true);
                    @endphp

                    <div class="card fashion-order-card border-0 shadow-2xs rounded-4 bg-white overflow-hidden">
                        <!-- Order Card Header -->
                        <div class="card-header bg-white border-bottom border-light-subtle py-3 px-3 px-sm-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center flex-wrap gap-2 gap-sm-3">
                                <span class="fw-bold text-dark fs-7 tracking-tight">
                                    Đơn hàng: <span class="text-primary font-monospace">#{{ $donHang->ma_don_hang }}</span>
                                </span>
                                <span class="text-muted fs-8">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $donHang->created_at->format('d/m/Y - H:i') }}
                                </span>
                                @if($showReturnCountdown)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill fs-9 py-1 px-2 js-return-countdown"
                                        data-deadline-ts="{{ $returnDeadlineTs }}">
                                        Còn -- ngày -- giờ để đổi trả
                                    </span>
                                @endif
                            </div>

                            <!-- Status Badge -->
                            <div>
                                @if($donHang->trang_thai !== 'da_hoan_thanh' && $latestRefund && $latestRefund->trang_thai === 'da_tu_choi')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1-5 fs-8 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-x-octagon"></i> Đã từ chối hoàn tiền
                                    </span>
                                @elseif($donHang->yeu_cau_tra)
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1-5 fs-8 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-arrow-counterclockwise"></i> Trả hàng / Hoàn tiền
                                    </span>
                                @else
                                    <span class="badge bg-{{ $st[1] }}-subtle text-{{ $st[1] }} border border-{{ $st[1] }}-subtle rounded-pill px-3 py-1-5 fs-8 d-inline-flex align-items-center gap-1">
                                        <i class="{{ $st[2] }}"></i> {{ $st[0] }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Card Body (Items List) -->
                        <div class="card-body p-3 px-sm-4">
                            @php
                                $allItems = $donHang->chiTietDonHangs;
                                $itemCount = $allItems->count();
                                $visibleItems = $allItems->take(2);
                                $hiddenItems = $allItems->slice(2);
                            @endphp

                            <div class="d-flex flex-column gap-2-5">
                                @foreach($visibleItems as $ct)
                                    <div class="fashion-order-item-row d-flex align-items-center gap-3 p-2 rounded-3 bg-light-subtle">
                                        <a href="{{ $ct->sanPham ? route('sanpham.chitiet', $ct->sanPham->slug) : '#' }}" class="flex-shrink-0">
                                            <img src="{{ $ct->sanPham && $ct->sanPham->hinh_anh_chinh ? asset('storage/' . $ct->sanPham->hinh_anh_chinh) : asset('img/default-avatar.png') }}"
                                                alt="{{ $ct->sanPham->ten_san_pham ?? 'Sản phẩm' }}"
                                                class="fashion-order-item-thumb rounded-3">
                                        </a>

                                        <div class="flex-grow-1 min-w-0">
                                            <a href="{{ $ct->sanPham ? route('sanpham.chitiet', $ct->sanPham->slug) : '#' }}"
                                                class="text-decoration-none text-dark fw-bold fs-7 text-truncate d-block mb-1 hover-primary">
                                                {{ $ct->sanPham->ten_san_pham ?? 'Sản phẩm không khả dụng' }}
                                            </a>
                                            <div class="d-flex align-items-center gap-1-5 flex-wrap fs-8 text-muted mb-1">
                                                @if($ct->bienThe && $ct->bienThe->color)
                                                    <span class="fashion-color-dot" style="background-color: {{ $ct->bienThe->color->ma_mau ?? '#ccc' }}"></span>
                                                    <span>{{ $ct->bienThe->color->ten_mau }}</span>
                                                @endif
                                                @if($ct->bienThe && $ct->bienThe->color && $ct->bienThe->size)
                                                    <span>•</span>
                                                @endif
                                                @if($ct->bienThe && $ct->bienThe->size)
                                                    <span class="badge bg-light text-dark border px-1-5 py-0-5 fs-9">Size {{ $ct->bienThe->size->ten_kich_thuoc }}</span>
                                                @endif
                                                <span class="badge bg-light text-muted border px-1-5 py-0-5 fs-9">x{{ $ct->so_luong }}</span>
                                            </div>
                                        </div>

                                        <div class="text-end flex-shrink-0">
                                            <div class="fw-bold text-dark fs-7">{{ number_format($ct->thanh_tien) }} ₫</div>
                                            <div class="text-muted fs-9">{{ number_format($ct->don_gia) }} ₫/cái</div>
                                        </div>
                                    </div>
                                @endforeach

                                @if($hiddenItems->isNotEmpty())
                                    <div class="collapse" id="collapseItems-{{ $donHang->id }}">
                                        <div class="d-flex flex-column gap-2-5 pt-2">
                                            @foreach($hiddenItems as $ct)
                                                <div class="fashion-order-item-row d-flex align-items-center gap-3 p-2 rounded-3 bg-light-subtle">
                                                    <a href="{{ $ct->sanPham ? route('sanpham.chitiet', $ct->sanPham->slug) : '#' }}" class="flex-shrink-0">
                                                        <img src="{{ $ct->sanPham && $ct->sanPham->hinh_anh_chinh ? asset('storage/' . $ct->sanPham->hinh_anh_chinh) : asset('img/default-avatar.png') }}"
                                                            alt="{{ $ct->sanPham->ten_san_pham ?? 'Sản phẩm' }}"
                                                            class="fashion-order-item-thumb rounded-3">
                                                    </a>
                                                    <div class="flex-grow-1 min-w-0">
                                                        <a href="{{ $ct->sanPham ? route('sanpham.chitiet', $ct->sanPham->slug) : '#' }}"
                                                            class="text-decoration-none text-dark fw-bold fs-7 text-truncate d-block mb-1 hover-primary">
                                                            {{ $ct->sanPham->ten_san_pham ?? 'Sản phẩm' }}
                                                        </a>
                                                        <div class="d-flex align-items-center gap-1-5 flex-wrap fs-8 text-muted mb-1">
                                                            @if($ct->bienThe && $ct->bienThe->color)
                                                                <span class="fashion-color-dot" style="background-color: {{ $ct->bienThe->color->ma_mau ?? '#ccc' }}"></span>
                                                                <span>{{ $ct->bienThe->color->ten_mau }}</span>
                                                            @endif
                                                            @if($ct->bienThe && $ct->bienThe->color && $ct->bienThe->size)
                                                                <span>•</span>
                                                            @endif
                                                            @if($ct->bienThe && $ct->bienThe->size)
                                                                <span class="badge bg-light text-dark border px-1-5 py-0-5 fs-9">Size {{ $ct->bienThe->size->ten_kich_thuoc }}</span>
                                                            @endif
                                                            <span class="badge bg-light text-muted border px-1-5 py-0-5 fs-9">x{{ $ct->so_luong }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end flex-shrink-0">
                                                        <div class="fw-bold text-dark fs-7">{{ number_format($ct->thanh_tien) }} ₫</div>
                                                        <div class="text-muted fs-9">{{ number_format($ct->don_gia) }} ₫/cái</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <button class="btn btn-link text-muted fs-8 text-decoration-none p-0 align-self-center mt-1"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseItems-{{ $donHang->id }}"
                                        aria-expanded="false" aria-controls="collapseItems-{{ $donHang->id }}"
                                        onclick="this.querySelector('.toggle-text').textContent = this.getAttribute('aria-expanded') === 'true' ? 'Thu gọn' : 'Xem thêm {{ $hiddenItems->count() }} sản phẩm khác'">
                                        <span class="toggle-text">Xem thêm {{ $hiddenItems->count() }} sản phẩm khác</span>
                                        <i class="bi bi-chevron-down ms-1 fs-9"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Order Card Footer (Summary & Actions) -->
                        <div class="card-footer bg-light-subtle border-top border-light-subtle py-3 px-3 px-sm-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                <!-- Payment & Total -->
                                <div class="d-flex flex-column gap-1">
                                    <div class="d-flex align-items-center gap-2 fs-8 text-muted">
                                        <span>
                                            <i class="bi bi-credit-card-2-front me-1"></i>
                                            {{ $donHang->phuong_thuc_thanh_toan === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán trực tuyến VNPay' }}
                                        </span>
                                        @if($donHang->trang_thai_thanh_toan === 'da_thanh_toan' || $donHang->trang_thai === 'da_hoan_thanh' || ($donHang->phuong_thuc_thanh_toan === 'cod' && $donHang->trang_thai === 'da_giao'))
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-9">Đã thanh toán</span>
                                        @elseif($donHang->trang_thai_thanh_toan === 'that_bai')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill fs-9">Thất bại</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fs-9">Chưa thanh toán</span>
                                        @endif
                                        @if($donHang->voucher_id)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-9">
                                                <i class="bi bi-ticket-perforated me-1"></i>Đã giảm voucher
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="text-muted fs-8">Tổng thanh toán:</span>
                                        <span class="fs-5 fw-extrabold text-success tracking-tight">
                                            {{ number_format($donHang->tong_tien) }} ₫
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-start justify-content-md-end">
                                    <!-- Nút Hủy đơn -->
                                    @if($canCancel)
                                        <button type="button" class="btn btn-outline-danger rounded-pill px-3 py-1-5 fs-8 fw-semibold d-inline-flex align-items-center gap-1"
                                            onclick="openCancelOrderModal({{ $donHang->id }}, '{{ $donHang->ma_don_hang }}', '{{ $donHang->trang_thai }}', '{{ $donHang->phuong_thuc_thanh_toan }}', '{{ $donHang->trang_thai_thanh_toan }}')">
                                            <i class="bi bi-x-circle"></i>
                                            {{ $donHang->trang_thai === 'dang_xu_ly' ? 'Yêu cầu hủy' : 'Hủy đơn hàng' }}
                                        </button>
                                    @endif

                                    <!-- Nút Thanh toán lại VNPay -->
                                    @if($donHang->phuong_thuc_thanh_toan === 'vnpay' && in_array($donHang->trang_thai_thanh_toan, ['chua_thanh_toan', 'that_bai'], true) && $donHang->trang_thai !== 'da_huy')
                                        <a href="{{ route('order.repay', $donHang->id) }}" class="btn btn-danger rounded-pill px-3 py-1-5 fs-8 fw-semibold d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-credit-card"></i> Thanh toán lại
                                        </a>
                                    @endif

                                    <!-- Nút Xác nhận nhận hàng -->
                                    @if($donHang->trang_thai === 'da_giao' && !$donHang->yeu_cau_tra && empty($donHang->da_nhan_hang_at))
                                        <form action="{{ route('order.received', $donHang->id) }}" method="POST" class="d-inline js-client-confirm-submit"
                                            data-confirm-message="Xác nhận bạn đã nhận được hàng đầy đủ và nguyên vẹn?" data-confirm-action="receive">
                                            @csrf
                                            <input type="hidden" name="client_confirm_receive" value="0" class="js-client-confirm-receive-flag">
                                            <button type="submit" class="btn btn-success rounded-pill px-3 py-1-5 fs-8 fw-semibold d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-box-seam"></i> Xác nhận nhận hàng
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Nút Xác nhận hoàn thành -->
                                    @if($donHang->trang_thai === 'da_giao' && !$donHang->yeu_cau_tra && !empty($donHang->da_nhan_hang_at))
                                        @php
                                            $confirmDeadlineTs = !empty($donHang->da_giao_at)
                                                ? $donHang->da_giao_at->copy()->addDays(3)->getTimestampMs()
                                                : null;
                                        @endphp
                                        <form action="{{ route('order.confirm', $donHang->id) }}" method="POST" class="d-inline js-client-confirm-submit"
                                            data-return-deadline-ts="{{ $confirmDeadlineTs }}" data-confirm-message="Xác nhận hoàn thành đơn hàng này?" data-confirm-action="complete">
                                            @csrf
                                            <input type="hidden" name="client_confirm_complete" value="0" class="js-client-confirm-complete-flag">
                                            <button type="submit" class="btn btn-success rounded-pill px-3 py-1-5 fs-8 fw-semibold d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-patch-check"></i> Hoàn thành đơn
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Nút Mua lại -->
                                    @if($canReorder)
                                        <button type="button" class="btn btn-dark rounded-pill px-3 py-1-5 fs-8 fw-semibold d-inline-flex align-items-center gap-1"
                                            onclick="reorderItems({{ $donHang->id }}, this)">
                                            <i class="bi bi-arrow-repeat"></i> Mua lại
                                        </button>
                                    @endif

                                    <!-- Nút Xem chi tiết -->
                                    <a href="{{ route('order.show', $donHang->id) }}" class="btn btn-outline-dark rounded-pill px-3 py-1-5 fs-8 fw-semibold d-inline-flex align-items-center gap-1">
                                        <span>Chi tiết</span>
                                        <i class="bi bi-arrow-right fs-9"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $donHangs->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>

{{-- Modal Xác Nhận Nhận Hàng / Hoàn Thành (Modern Minimalist) --}}
<div id="clientOrderConfirmModal" class="position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center d-none"
    style="z-index: 10500; background-color: rgba(15, 23, 42, 0.45); backdrop-filter: blur(4px);" role="dialog" aria-modal="true">
    <div class="card shadow-lg border-0 m-3 rounded-4" style="max-width: 440px; width: 100%;">
        <div class="card-header border-bottom border-light-subtle bg-white py-3 px-4 d-flex align-items-center gap-2 rounded-top-4">
            <div class="rounded-circle bg-success-subtle p-2 text-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-shield-check fs-6"></i>
            </div>
            <h5 class="fw-bold text-dark mb-0 fs-6" id="clientOrderConfirmTitle">Xác nhận đơn hàng</h5>
        </div>
        <div class="card-body p-4 text-dark fs-8" id="clientOrderConfirmBody"></div>
        <div class="card-footer bg-white border-0 d-flex gap-2 justify-content-end p-3 px-4 rounded-bottom-4">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1-5 fs-8" id="clientOrderConfirmCancel">Đóng</button>
            <button type="button" class="btn btn-success rounded-pill px-4 py-1-5 fs-8 fw-semibold" id="clientOrderConfirmOk">Xác nhận</button>
        </div>
    </div>
</div>

{{-- Modal Hủy Đơn Hàng (Modern Minimalist) --}}
<div id="cancelOrderModal" class="position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center d-none"
    style="z-index: 10500; background-color: rgba(15, 23, 42, 0.45); backdrop-filter: blur(4px);" role="dialog" aria-modal="true">
    <div class="card shadow-lg border-0 m-3 rounded-4" style="max-width: 460px; width: 100%;">
        <form id="cancelOrderForm" method="POST">
            @csrf
            <div class="card-header border-bottom border-light-subtle bg-white py-3 px-4 d-flex align-items-center justify-content-between rounded-top-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger-subtle p-2 text-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-x-circle fs-6"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0 fs-6" id="cancelOrderModalTitle">Hủy đơn hàng</h5>
                </div>
                <button type="button" class="btn-close shadow-none fs-8" onclick="closeCancelOrderModal()"></button>
            </div>
            <div class="card-body p-4">
                <p class="fs-8 text-muted mb-3" id="cancelOrderModalDesc">
                    Bạn có chắc chắn muốn hủy đơn hàng <strong id="cancelOrderCodeText" class="text-dark">#FT-...</strong>?
                </p>
                <div id="cancelReasonWrapper" class="d-none mb-3">
                    <label class="form-label fs-8 fw-semibold text-dark mb-1">Lý do hủy đơn <span class="text-danger">*</span></label>
                    <textarea name="ly_do_yeu_cau_huy" id="cancelReasonInput" class="form-control fs-8 rounded-3" rows="3"
                        placeholder="Vui lòng cho FashionTee biết lý do bạn muốn hủy đơn hàng này..."></textarea>
                    <div class="form-text fs-9 text-muted mt-1">Lý do sẽ được gửi đến đội ngũ quản trị để duyệt hủy nhanh nhất.</div>
                </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex gap-2 justify-content-end p-3 px-4 rounded-bottom-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1-5 fs-8" onclick="closeCancelOrderModal()">Đóng</button>
                <button type="submit" class="btn btn-danger rounded-pill px-4 py-1-5 fs-8 fw-semibold" id="cancelOrderSubmitBtn">Đồng ý hủy đơn</button>
            </div>
        </form>
    </div>
</div>

@include('client.layout.footer')
@include('client.layout.scripts')

<style>
    /* ============================================================
       FASHIONTEE MY ORDERS STYLES — MODERN MINIMALIST
       ============================================================ */
    .fashion-orders-page {
        min-height: 80vh;
    }
    .fs-7 { font-size: 0.875rem !important; }
    .fs-8 { font-size: 0.785rem !important; }
    .fs-9 { font-size: 0.715rem !important; }
    .tracking-tight { letter-spacing: -0.02em; }
    .shadow-xs { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05) !important; }
    .shadow-2xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important; }
    .hover-primary:hover { color: #198754 !important; }

    /* Breadcrumb */
    .fashion-orders-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #cbd5e1;
        font-weight: 300;
        padding: 0 0.5rem;
    }

    /* Search input group */
    .fashion-order-search-group {
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
        background: #f8fafc;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .fashion-order-search-group:focus-within {
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
    }
    .fashion-order-search-group input:focus {
        box-shadow: none;
        background: transparent;
    }

    /* Capsule Pill Navigation */
    .fashion-order-tabs-scroll-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .fashion-order-tabs-scroll-wrap::-webkit-scrollbar {
        display: none;
    }
    .fashion-order-pill {
        color: #64748b !important;
        font-weight: 600;
        font-size: 0.82rem;
        padding: 7px 16px !important;
        border-radius: 999px !important;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        white-space: nowrap;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .fashion-order-pill:hover {
        color: #0f172a !important;
        background: #f1f5f9 !important;
        border-color: #cbd5e1;
    }
    .fashion-order-pill.active {
        color: #ffffff !important;
        background: #0f172a !important;
        border-color: #0f172a !important;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.18);
    }

    /* Order Card */
    .fashion-order-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .fashion-order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -4px rgba(15, 23, 42, 0.08) !important;
    }
    .fashion-order-item-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }
    .fashion-color-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
    }
    .fashion-empty-icon {
        width: 64px;
        height: 64px;
    }
</style>

<script>
(function() {
    // 1. Modal Confirm Nhận hàng / Hoàn thành
    function openClientOrderConfirm(message, onConfirm) {
        const modal = document.getElementById('clientOrderConfirmModal');
        const body = document.getElementById('clientOrderConfirmBody');
        const okBtn = document.getElementById('clientOrderConfirmOk');
        const cancelBtn = document.getElementById('clientOrderConfirmCancel');
        if (!modal || !body || !okBtn || !cancelBtn) {
            if (window.confirm(message)) onConfirm();
            return;
        }

        body.innerHTML = message;
        modal.classList.remove('d-none');
        modal.classList.add('d-flex');

        function close() {
            modal.classList.add('d-none');
            modal.classList.remove('d-flex');
            okBtn.removeEventListener('click', handleOk);
            cancelBtn.removeEventListener('click', close);
        }

        function handleOk() {
            close();
            onConfirm();
        }

        okBtn.addEventListener('click', handleOk);
        cancelBtn.addEventListener('click', close);
    }

    function bindOrderConfirmForms() {
        const formatCountdown = (deadlineTs) => {
            const msLeft = Math.max(0, deadlineTs - Date.now());
            const totalMinutes = Math.floor(msLeft / 60000);
            const days = Math.floor(totalMinutes / (24 * 60));
            const hours = Math.floor((totalMinutes % (24 * 60)) / 60);
            const minutes = totalMinutes % 60;
            return `${days} ngày ${String(hours).padStart(2, '0')} giờ ${String(minutes).padStart(2, '0')} phút`;
        };

        document.querySelectorAll('form.js-client-confirm-submit').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const actionType = form.getAttribute('data-confirm-action') || 'complete';
                const completeFlagInput = form.querySelector('.js-client-confirm-complete-flag');
                const receiveFlagInput = form.querySelector('.js-client-confirm-receive-flag');

                if (actionType === 'complete' && completeFlagInput && completeFlagInput.value !== '1') {
                    e.preventDefault();
                }
                if (actionType === 'receive' && receiveFlagInput && receiveFlagInput.value !== '1') {
                    e.preventDefault();
                }

                if (form.getAttribute('data-confirmed') === '1') {
                    form.removeAttribute('data-confirmed');
                    return;
                }
                e.preventDefault();

                const defaultMsg = form.getAttribute('data-confirm-message') || 'Bạn có chắc chắn muốn thực hiện thao tác này?';
                const deadlineTs = Number(form.getAttribute('data-return-deadline-ts') || 0);
                const countdownText = deadlineTs
                    ? `Bạn còn <strong>${formatCountdown(deadlineTs)}</strong> để gửi yêu cầu hoàn tiền/trả hàng nếu có vấn đề phát sinh.`
                    : '';
                const warningText = actionType === 'receive'
                    ? '<i class="bi bi-info-circle-fill me-1 text-primary"></i><span>Chính sách 3 ngày hoàn tiền/trả hàng được tính từ thời điểm đơn đã giao.</span>'
                    : '<i class="bi bi-exclamation-triangle-fill me-1 text-warning"></i><span>Lưu ý: Sau khi xác nhận hoàn thành, đơn hàng sẽ đóng và không thể gửi yêu cầu hoàn tiền/trả hàng nữa.</span>';

                const msg = `
                    <div class="fw-bold mb-2 text-dark fs-7">${defaultMsg}</div>
                    ${countdownText ? `<div class="p-2 mb-2 bg-light rounded-3 border text-dark fs-8">${countdownText}</div>` : ''}
                    <div class="p-2 bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-3 fs-9 d-flex align-items-start gap-1">${warningText}</div>
                `;

                openClientOrderConfirm(msg, function() {
                    if (actionType === 'complete' && completeFlagInput) completeFlagInput.value = '1';
                    if (actionType === 'receive' && receiveFlagInput) receiveFlagInput.value = '1';
                    form.setAttribute('data-confirmed', '1');
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                });
            });
        });
    }

    // 2. Countdown Đổi trả 3 ngày
    function bindReturnCountdowns() {
        const els = document.querySelectorAll('.js-return-countdown[data-deadline-ts]');
        if (!els.length) return;

        const formatLeft = (msLeft) => {
            const totalMinutes = Math.max(0, Math.floor(msLeft / 60000));
            const days = Math.floor(totalMinutes / (24 * 60));
            const hours = Math.floor((totalMinutes % (24 * 60)) / 60);
            const minutes = totalMinutes % 60;
            return `${days} ngày ${String(hours).padStart(2, '0')} giờ ${String(minutes).padStart(2, '0')} phút`;
        };

        const tick = () => {
            const now = Date.now();
            els.forEach((el) => {
                const deadlineTs = Number(el.dataset.deadlineTs || 0);
                if (!deadlineTs) return;

                const msLeft = deadlineTs - now;
                if (msLeft <= 0) {
                    el.textContent = 'Đã hết hạn đổi trả (3 ngày)';
                    el.className = 'badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill fs-9 py-1 px-2';
                    return;
                }
                el.textContent = `Còn ${formatLeft(msLeft)} để đổi trả`;
            });
        };

        tick();
        setInterval(tick, 30000);
    }

    // 3. Modal Hủy Đơn Hàng
    const cancelModal = document.getElementById('cancelOrderModal');
    const cancelForm = document.getElementById('cancelOrderForm');
    const cancelReasonWrapper = document.getElementById('cancelReasonWrapper');
    const cancelReasonInput = document.getElementById('cancelReasonInput');
    const cancelOrderCodeText = document.getElementById('cancelOrderCodeText');
    const cancelOrderModalTitle = document.getElementById('cancelOrderModalTitle');
    const cancelOrderModalDesc = document.getElementById('cancelOrderModalDesc');
    const cancelOrderSubmitBtn = document.getElementById('cancelOrderSubmitBtn');

    window.openCancelOrderModal = function(orderId, orderCode, status, paymentMethod, paymentStatus) {
        if (!cancelModal || !cancelForm) return;

        cancelForm.action = `/order/${orderId}/cancel`;
        cancelOrderCodeText.textContent = `#${orderCode}`;

        // Kiểm tra xem có cần nhập lý do hủy không
        const skipReasonForUnpaidOnline = paymentMethod === 'vnpay' && status === 'cho_xac_nhan' && paymentStatus !== 'da_thanh_toan';
        const skipReasonForPaidOnlineChoXacNhan = paymentMethod === 'vnpay' && status === 'cho_xac_nhan' && paymentStatus === 'da_thanh_toan';
        const skipReasonCodChoXacNhan = paymentMethod === 'cod' && status === 'cho_xac_nhan';
        const needReason = !(skipReasonForUnpaidOnline || skipReasonForPaidOnlineChoXacNhan || skipReasonCodChoXacNhan);

        if (status === 'dang_xu_ly') {
            cancelOrderModalTitle.textContent = 'Gửi yêu cầu hủy đơn hàng';
            cancelOrderModalDesc.innerHTML = `Đơn hàng <strong>#${orderCode}</strong> đang được xử lý. Bạn có thể gửi yêu cầu hủy để Admin duyệt (tối đa 2 lần).`;
            cancelOrderSubmitBtn.textContent = 'Gửi yêu cầu hủy';
            cancelReasonWrapper.classList.remove('d-none');
            if (cancelReasonInput) cancelReasonInput.required = true;
        } else {
            cancelOrderModalTitle.textContent = 'Xác nhận hủy đơn hàng';
            cancelOrderModalDesc.innerHTML = `Bạn có chắc chắn muốn hủy đơn hàng <strong>#${orderCode}</strong>? Thao tác này không thể hoàn tác.`;
            cancelOrderSubmitBtn.textContent = 'Xác nhận hủy đơn';
            if (needReason) {
                cancelReasonWrapper.classList.remove('d-none');
                if (cancelReasonInput) cancelReasonInput.required = true;
            } else {
                cancelReasonWrapper.classList.add('d-none');
                if (cancelReasonInput) cancelReasonInput.required = false;
            }
        }

        cancelModal.classList.remove('d-none');
        cancelModal.classList.add('d-flex');
    };

    window.closeCancelOrderModal = function() {
        if (!cancelModal) return;
        cancelModal.classList.add('d-none');
        cancelModal.classList.remove('d-flex');
        if (cancelReasonInput) cancelReasonInput.value = '';
    };

    // 4. Mua Lại (Re-order)
    window.reorderItems = function(orderId, btn) {
        if (!orderId) return;

        const originalText = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang thêm...';
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch(`/order/${orderId}/reorder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof window.updateCartBadgeCount === 'function' && data.total_cart_items !== undefined) {
                    window.updateCartBadgeCount(data.total_cart_items);
                }
                if (typeof window.showClientToast === 'function') {
                    window.showClientToast(data.message || 'Đã thêm sản phẩm vào giỏ hàng!', 'success');
                }
                if (typeof window.openMiniCartDrawer === 'function') {
                    window.openMiniCartDrawer();
                } else {
                    window.location.href = '{{ route("gio-hang.index") }}';
                }
            } else {
                if (typeof window.showClientToast === 'function') {
                    window.showClientToast(data.message || 'Không thể thêm sản phẩm vào giỏ hàng.', 'error');
                } else {
                    alert(data.message || 'Không thể thêm sản phẩm vào giỏ hàng.');
                }
            }
        })
        .catch(err => {
            console.error('Reorder error:', err);
            if (typeof window.showClientToast === 'function') {
                window.showClientToast('Có lỗi xảy ra khi thêm vào giỏ hàng.', 'error');
            } else {
                alert('Có lỗi xảy ra khi thêm vào giỏ hàng.');
            }
        })
        .finally(() => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    };

    window.reorderOrder = window.reorderItems;

    document.addEventListener('DOMContentLoaded', function() {
        bindOrderConfirmForms();
        bindReturnCountdowns();
    });
})();
</script>