<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb bg-transparent p-0 m-0 fs-13">
        <li class="breadcrumb-item">
            <a href="{{ route('order') }}" class="text-decoration-none text-muted d-inline-flex align-items-center gap-1 hover-text-primary">
                <i class="bi bi-bag-check"></i>
                <span>Đơn hàng của tôi</span>
            </a>
        </li>
        <li class="breadcrumb-item active text-slate-700 fw-medium" aria-current="page">
            Chi tiết #{{ $donHang->ma_don_hang }}
        </li>
    </ol>
</nav>

@php
    $canShowReturnCountdown =
        $donHang->trang_thai === \App\Models\DonHang::TRANG_THAI_DA_GIAO
        && !$donHang->yeu_cau_tra
        && !empty($donHang->da_giao_at);
    $returnDeadlineTs = $canShowReturnCountdown
        ? $donHang->da_giao_at->copy()->addDays(3)->getTimestampMs()
        : null;

    $effectiveStatus = $donHang->trang_thai;
    if ((bool)$donHang->yeu_cau_huy && in_array($donHang->trang_thai, ['dang_xu_ly', 'cho_duyet_huy'], true)) {
        $effectiveStatus = 'dang_yeu_cau_huy';
    } elseif ($effectiveStatus === 'da_giao' && !empty($donHang->da_nhan_hang_at)) {
        $effectiveStatus = 'da_nhan_hang';
    }

    $statusBadges = [
        'cho_xac_nhan'     => ['label' => 'Chờ xác nhận', 'class' => 'bg-amber-50 text-amber-700 border-amber-200', 'icon' => 'bi-clock-history'],
        'dang_xu_ly'      => ['label' => 'Đang xử lý', 'class' => 'bg-sky-50 text-sky-700 border-sky-200', 'icon' => 'bi-gear'],
        'dang_yeu_cau_huy' => ['label' => 'Đang yêu cầu hủy', 'class' => 'bg-orange-50 text-orange-700 border-orange-200', 'icon' => 'bi-hourglass-split'],
        'cho_duyet_huy'    => ['label' => 'Chờ duyệt hủy', 'class' => 'bg-orange-50 text-orange-700 border-orange-200', 'icon' => 'bi-hourglass-split'],
        'dang_giao'        => ['label' => 'Đang giao', 'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'icon' => 'bi-truck'],
        'da_giao'          => ['label' => 'Đã giao hàng', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'bi-check2-circle'],
        'da_nhan_hang'     => ['label' => 'Đã nhận hàng', 'class' => 'bg-teal-50 text-teal-700 border-teal-200', 'icon' => 'bi-box-seam'],
        'da_hoan_thanh'    => ['label' => 'Hoàn tất', 'class' => 'bg-emerald-50 text-emerald-800 border-emerald-300', 'icon' => 'bi-patch-check-fill'],
        'da_huy'           => ['label' => 'Đã hủy', 'class' => 'bg-rose-50 text-rose-700 border-rose-200', 'icon' => 'bi-x-circle'],
    ];
    $currentBadge = $statusBadges[$effectiveStatus] ?? ['label' => 'Đơn hàng', 'class' => 'bg-slate-100 text-slate-700 border-slate-200', 'icon' => 'bi-tag'];
@endphp

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 pb-3 mb-4 border-bottom border-slate-200">
    <div>
        <div class="d-flex flex-wrap align-items-center gap-2 mb-1-5">
            <h1 class="fs-20 fw-bold text-slate-900 mb-0">Đơn hàng #{{ $donHang->ma_don_hang }}</h1>
            <span class="order-status-pill {{ $currentBadge['class'] }} d-inline-flex align-items-center gap-1-5 px-3 py-1 rounded-pill fw-semibold fs-12 border">
                <i class="bi {{ $currentBadge['icon'] }}"></i>
                <span>{{ $currentBadge['label'] }}</span>
            </span>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2 text-slate-500 fs-13">
            <span class="d-inline-flex align-items-center gap-1">
                <i class="bi bi-calendar3"></i>
                <span>Đặt lúc {{ $donHang->created_at->format('H:i - d/m/Y') }}</span>
            </span>
            @if ($donHang->chiTietDonHangs)
                <span class="text-slate-300">•</span>
                <span>{{ $donHang->chiTietDonHangs->sum('so_luong') }} món hàng</span>
            @endif
        </div>
        @if ($canShowReturnCountdown)
            <div class="mt-2">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1-5 rounded-pill bg-amber-50 text-amber-800 border border-amber-200 fs-12 fw-medium"
                     id="returnCountdown" data-deadline-ts="{{ $returnDeadlineTs }}">
                    <i class="bi bi-hourglass-split text-amber-600"></i>
                    <span>Bạn còn -- ngày -- giờ -- phút để gửi yêu cầu trả hàng/hoàn tiền</span>
                </div>
            </div>
        @endif
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('order') }}" class="btn btn-outline-secondary rounded-pill px-3 py-1-5 fs-13 fw-medium d-inline-flex align-items-center gap-1-5 text-slate-700 bg-white shadow-2xs">
            <i class="bi bi-arrow-left"></i>
            <span>Quay lại</span>
        </a>
    </div>
</div>

@if ($canShowReturnCountdown)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownEl = document.getElementById('returnCountdown');
            if (!countdownEl) return;

            const textSpan = countdownEl.querySelector('span') || countdownEl;
            const deadlineTs = Number(countdownEl.dataset.deadlineTs || 0);
            if (!deadlineTs) return;

            const formatLeft = (msLeft) => {
                const totalMinutes = Math.max(0, Math.floor(msLeft / 60000));
                const days = Math.floor(totalMinutes / (24 * 60));
                const hours = Math.floor((totalMinutes % (24 * 60)) / 60);
                const minutes = totalMinutes % 60;
                return `${days} ngày ${String(hours).padStart(2, '0')} giờ ${String(minutes).padStart(2, '0')} phút`;
            };

            const tick = () => {
                const now = Date.now();
                const msLeft = deadlineTs - now;
                if (msLeft <= 0) {
                    textSpan.textContent = 'Đã hết thời hạn trả hàng/hoàn tiền (3 ngày).';
                    countdownEl.className = 'd-inline-flex align-items-center gap-2 px-3 py-1-5 rounded-pill bg-slate-100 text-slate-600 border border-slate-200 fs-8';
                    return false;
                }

                textSpan.textContent = `Bạn còn ${formatLeft(msLeft)} để gửi yêu cầu trả hàng/hoàn tiền`;
                return true;
            };

            if (!tick()) return;
            const timer = setInterval(() => {
                if (!tick()) clearInterval(timer);
            }, 30000);
        });
    </script>
@endif
