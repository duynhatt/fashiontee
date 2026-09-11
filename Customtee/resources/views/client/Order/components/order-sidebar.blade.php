@php
    $effectiveTrangThai = $donHang->trang_thai;
    if ((bool) $donHang->yeu_cau_huy && in_array($donHang->trang_thai, ['dang_xu_ly', 'cho_duyet_huy'], true)) {
        $effectiveTrangThai = 'dang_yeu_cau_huy';
    }
    if ($effectiveTrangThai === 'da_giao' && !empty($donHang->da_nhan_hang_at)) {
        $effectiveTrangThai = 'da_nhan_hang';
    }

    $isPendingCancelRequest = (bool) $donHang->yeu_cau_huy
        && in_array($donHang->trang_thai, ['dang_xu_ly', 'cho_duyet_huy'], true);
    $cancelRequestAttempts = (int) ($donHang->so_lan_yeu_cau_huy ?? 0);
    $canCancel = ($donHang->trang_thai === 'cho_xac_nhan')
        || ($donHang->trang_thai === 'dang_xu_ly' && !$isPendingCancelRequest && $cancelRequestAttempts < 2);

    $yeuCauHoanTien = $donHang->refunds()->latest()->first();
    $refundAttempts = $yeuCauHoanTien ? (int) ($yeuCauHoanTien->so_lan_yeu_cau ?? 1) : 0;
    $canCreateNewRefund = !$yeuCauHoanTien || ($yeuCauHoanTien->trang_thai === 'da_tu_choi' && $refundAttempts < 2);

    $isOnlineCancelRefund = $donHang->phuong_thuc_thanh_toan === 'vnpay'
        && $donHang->trang_thai === 'da_huy'
        && $donHang->trang_thai_thanh_toan === 'da_thanh_toan';

    $isDeliveredReturn = in_array($donHang->phuong_thuc_thanh_toan, ['cod', 'vnpay'], true)
        && $donHang->trang_thai === 'da_giao'
        && !empty($donHang->da_giao_at)
        && !empty($donHang->da_nhan_hang_at);

    $mocDaGiao = $donHang->da_giao_at;
    $conTrongThoiHanDaGiao = $isDeliveredReturn && $mocDaGiao && \Carbon\Carbon::parse($mocDaGiao)->addDays(3)->isFuture();
    $showRefundButton = ($isOnlineCancelRefund || $conTrongThoiHanDaGiao) && $canCreateNewRefund;
@endphp

<div class="order-sidebar-sticky" style="position: sticky; top: 90px;">
    {{-- CARD HÀNH ĐỘNG CHÍNH (SMART ACTION HUB) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-bottom border-slate-100 py-3 px-4">
            <h6 class="mb-0 fw-bold fs-15 text-slate-800 d-flex align-items-center gap-2">
                <i class="bi bi-lightning-charge text-primary"></i>
                <span>Thao tác đơn hàng</span>
            </h6>
        </div>
        <div class="card-body p-4 d-flex flex-column gap-2-5">
            {{-- THẺ HÀNH ĐỘNG CHÍNH (PRIMARY CTA) THEO NGỮ CẢNH --}}
            @if ($donHang->phuong_thuc_thanh_toan === 'vnpay' && $donHang->trang_thai_thanh_toan !== 'da_thanh_toan' && $donHang->trang_thai !== 'da_huy')
                <a href="{{ route('order.repay', $donHang->id) }}"
                    class="btn btn-danger rounded-3 py-2-5 px-4 fw-semibold fs-14 d-flex align-items-center justify-content-center gap-2 shadow-sm w-100">
                    <i class="bi bi-credit-card-2-front fs-6"></i>
                    <span>Thanh toán ngay với VNPay</span>
                </a>
            @elseif ($donHang->trang_thai === 'da_giao' && empty($donHang->da_nhan_hang_at))
                <form action="{{ route('order.received', $donHang->id) }}" method="POST" class="w-100 js-client-confirm-submit"
                    data-confirm-message="Bạn đã nhận được toàn bộ kiện hàng và hài lòng với chất lượng?">
                    @csrf
                    <input type="hidden" name="client_confirm_receive" value="1">
                    <button type="submit" class="btn btn-success rounded-3 py-2-5 px-4 fw-semibold fs-14 d-flex align-items-center justify-content-center gap-2 shadow-sm w-100">
                        <i class="bi bi-box-seam fs-6"></i>
                        <span>Đã nhận được hàng</span>
                    </button>
                </form>
            @elseif ($donHang->trang_thai === 'da_giao' && !empty($donHang->da_nhan_hang_at))
                <form action="{{ route('order.confirm', $donHang->id) }}" method="POST" class="w-100 js-client-confirm-submit"
                    data-confirm-message="Xác nhận hoàn thành đơn hàng? Sau bước này bạn có thể đánh giá sản phẩm.">
                    @csrf
                    <input type="hidden" name="client_confirm_complete" value="1">
                    <button type="submit" class="btn btn-dark rounded-3 py-2-5 px-4 fw-semibold fs-14 d-flex align-items-center justify-content-center gap-2 shadow-sm w-100">
                        <i class="bi bi-check2-circle fs-6"></i>
                        <span>Xác nhận hoàn thành</span>
                    </button>
                </form>
            @elseif (in_array($donHang->trang_thai, ['da_hoan_thanh', 'da_huy'], true))
                <button type="button" class="btn btn-dark rounded-3 py-2-5 px-4 fw-semibold fs-14 d-flex align-items-center justify-content-center gap-2 shadow-sm w-100 js-reorder-btn"
                    data-order-id="{{ $donHang->id }}"
                    onclick="window.reorderOrder({{ $donHang->id }}, this)">
                    <i class="bi bi-arrow-repeat fs-6"></i>
                    <span>Mua lại đơn hàng này</span>
                </button>
            @endif

            {{-- CÁC NÚT PHỤ: HỦY ĐƠN / TRẢ HÀNG HOÀN TIỀN --}}
            @if ($showRefundButton)
                <button type="button" class="btn btn-outline-warning rounded-3 py-2 px-3 fs-13 fw-semibold d-flex align-items-center justify-content-center gap-2 w-100 text-amber-900 border-amber-300 bg-amber-50/50"
                    data-bs-toggle="modal" data-bs-target="#modalYeuCauHoanTra">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    <span>{{ $donHang->trang_thai === 'da_giao' ? 'Yêu cầu trả hàng / Hoàn tiền' : 'Yêu cầu hoàn tiền' }}</span>
                </button>
            @endif

            @if ($canCancel)
                <button type="button" class="btn btn-outline-danger rounded-3 py-2 px-3 fs-13 fw-semibold d-flex align-items-center justify-content-center gap-2 w-100"
                    data-bs-toggle="modal" data-bs-target="#modalHuyDon">
                    <i class="bi bi-x-circle"></i>
                    <span>{{ $donHang->trang_thai === 'dang_xu_ly' && $donHang->phuong_thuc_thanh_toan === 'vnpay' ? 'Gửi yêu cầu hủy đơn' : 'Hủy đơn hàng' }}</span>
                </button>
            @endif

            <a href="{{ route('contact') ?? '#' }}" class="btn btn-link text-slate-500 fs-13 text-decoration-none py-1 d-flex align-items-center justify-content-center gap-1-5 hover-text-primary">
                <i class="bi bi-headset"></i>
                <span>Cần hỗ trợ về đơn hàng này?</span>
            </a>
        </div>
    </div>

    {{-- CARD CHI TIẾT THANH TOÁN (FINANCIAL SUMMARY) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-bottom border-slate-100 py-3 px-4">
            <h6 class="mb-0 fw-bold fs-15 text-slate-800 d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-primary"></i>
                <span>Chi tiết thanh toán</span>
            </h6>
        </div>
        <div class="card-body p-4">
            {{-- 1. THÔNG TIN PHƯƠNG THỨC & TRẠNG THÁI (ĐẶT Ở TRÊN CÙNG) --}}
            <div class="d-flex flex-column gap-2 mb-3">
                <div class="d-flex justify-content-between align-items-center fs-14">
                    <span class="text-slate-500">Phương thức:</span>
                    <span class="fw-medium text-slate-800 d-inline-flex align-items-center gap-1-5">
                        @switch($donHang->phuong_thuc_thanh_toan)
                            @case('cod')
                                <i class="bi bi-cash-stack text-success"></i> COD (Tiền mặt)
                            @break
                            @case('vnpay')
                                <i class="bi bi-qr-code text-primary"></i> VNPay
                            @break
                            @case('momo')
                                <i class="bi bi-wallet2 text-danger"></i> MoMo
                            @break
                            @case('zalo_pay')
                                <i class="bi bi-wallet text-info"></i> ZaloPay
                            @break
                            @default
                                <i class="bi bi-credit-card text-primary"></i> Trực tuyến
                        @endswitch
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center fs-14">
                    <span class="text-slate-500">Trạng thái thanh toán:</span>
                    @if (
                        $donHang->trang_thai_thanh_toan === 'da_thanh_toan' ||
                        $donHang->trang_thai === 'da_hoan_thanh' ||
                        ($donHang->phuong_thuc_thanh_toan === 'cod' && $donHang->trang_thai === 'da_giao')
                    )
                        <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-pill px-2-5 py-1 fs-12 fw-semibold">
                            <i class="bi bi-check-circle me-1"></i> Đã thanh toán
                        </span>
                    @elseif($donHang->trang_thai_thanh_toan === 'that_bai')
                        <span class="badge bg-rose-50 text-rose-700 border border-rose-200 rounded-pill px-2-5 py-1 fs-12 fw-semibold">
                            <i class="bi bi-x-circle me-1"></i> Thất bại
                        </span>
                    @else
                        <span class="badge bg-amber-50 text-amber-700 border border-amber-200 rounded-pill px-2-5 py-1 fs-12 fw-semibold">
                            <i class="bi bi-clock me-1"></i> Chưa thanh toán
                        </span>
                    @endif
                </div>
            </div>

            <hr class="my-3 border-slate-200">

            {{-- 2. CÁC KHOẢN TÍNH TIỀN (TẠM TÍNH, GIẢM GIÁ, SHIP) --}}
            <div class="d-flex flex-column gap-2">
                <div class="d-flex justify-content-between align-items-center fs-14 text-slate-600">
                    <span>Tạm tính hàng hóa</span>
                    <span class="fw-medium text-slate-800">{{ number_format($donHang->tam_tinh, 0, ',', '.') }} ₫</span>
                </div>

                @if (!empty($donHang->tien_giam) && $donHang->tien_giam > 0)
                    <div class="d-flex justify-content-between align-items-center fs-14 text-rose-600">
                        <span class="d-inline-flex align-items-center gap-1">
                            <i class="bi bi-tag-fill"></i> Giảm giá khuyến mãi
                        </span>
                        <span class="fw-semibold">-{{ number_format($donHang->tien_giam, 0, ',', '.') }} ₫</span>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center fs-14 text-slate-600">
                    <span>Phí vận chuyển</span>
                    <span class="fw-medium text-slate-800">
                        @if (!empty($donHang->phi_van_chuyen) && $donHang->phi_van_chuyen > 0)
                            {{ number_format($donHang->phi_van_chuyen, 0, ',', '.') }} ₫
                        @else
                            <span class="text-emerald-600 fw-semibold">Miễn phí</span>
                        @endif
                    </span>
                </div>
            </div>

            <hr class="my-3 border-slate-200">

            {{-- 3. TỔNG THANH TOÁN (NẰM CUỐI CÙNG, LIỀN MẠCH, NỔI BẬT) --}}
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold fs-15 text-slate-900">Tổng thanh toán:</span>
                <span class="fw-bold fs-18 text-rose-600">{{ number_format($donHang->tong_tien, 0, ',', '.') }} ₫</span>
            </div>
        </div>
    </div>

    {{-- CARD THÔNG TIN GIAO HÀNG (SHIPPING INFO) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-bottom border-slate-100 py-3 px-4">
            <h6 class="mb-0 fw-bold fs-15 text-slate-800 d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt text-primary"></i>
                <span>Địa chỉ nhận hàng</span>
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="info-list-group">
                <div class="info-row">
                    <div class="info-icon-box">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Người nhận</div>
                        <div class="info-value">{{ $donHang->ten_nguoi_nhan }}</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon-box">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Số điện thoại</div>
                        <div class="info-value">{{ $donHang->so_dien_thoai_nhan_hang }}</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon-box">
                        <i class="bi bi-pin-map"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Địa chỉ nhận hàng</div>
                        <div class="info-value text-slate-700">{{ $donHang->dia_chi_chi_tiet }}</div>
                    </div>
                </div>

                @if ($donHang->ghi_chu)
                    <div class="info-row">
                        <div class="info-icon-box">
                            <i class="bi bi-chat-left-text"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Ghi chú đơn hàng</div>
                            <div class="info-value fst-italic text-slate-600 bg-slate-50 p-2-5 rounded-3 border border-slate-200 fs-13">
                                "{{ $donHang->ghi_chu }}"
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirm submit handler
    const confirmForms = document.querySelectorAll('.js-client-confirm-submit');
    confirmForms.forEach(f => {
        f.addEventListener('submit', function(e) {
            const msg = this.dataset.confirmMessage || 'Bạn có chắc chắn muốn thực hiện thao tác này?';
            if (!confirm(msg)) {
                e.preventDefault();
                return;
            }
            const receiveInput = this.querySelector('input[name="client_confirm_receive"]');
            if (receiveInput) receiveInput.value = '1';
            const completeInput = this.querySelector('input[name="client_confirm_complete"]');
            if (completeInput) completeInput.value = '1';
        });
    });

    // Reorder action handler
    window.reorderOrder = function(orderId, btn) {
        if (!orderId) return;

        const originalHtml = btn ? btn.innerHTML : '';
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
                    window.location.href = "{{ route('gio-hang.index') }}";
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
                btn.innerHTML = originalHtml;
            }
        });
    };

    window.reorderItems = window.reorderOrder;
});
</script>
