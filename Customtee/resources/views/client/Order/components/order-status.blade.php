@php
    $effectiveTrangThai = $donHang->trang_thai;
    if ((bool) $donHang->yeu_cau_huy && in_array($donHang->trang_thai, ['dang_xu_ly', 'cho_duyet_huy'], true)) {
        $effectiveTrangThai = 'dang_yeu_cau_huy';
    }
    if ($effectiveTrangThai === 'da_giao' && !empty($donHang->da_nhan_hang_at)) {
        $effectiveTrangThai = 'da_nhan_hang';
    }

    $yeuCauHoanTien = $donHang->refunds()->latest()->first();

    $refundStatusMap = [
        'cho_xu_ly'   => ['Chờ xác nhận', 'warning', 'bi-hourglass-split', 'Yêu cầu hoàn tiền/trả hàng đang chờ cửa hàng xác nhận.'],
        'da_chap_nhan' => ['Đã chấp nhận', 'info', 'bi-arrow-repeat', 'Cửa hàng đã duyệt, đang kiểm tra và xử lý hoàn tiền.'],
        'da_tu_choi'   => ['Đã từ chối', 'danger', 'bi-x-circle', 'Yêu cầu hoàn tiền/trả hàng đã bị từ chối.'],
        'da_hoan_tien' => ['Đã hoàn tiền', 'success', 'bi-check2-circle', 'Đã hoàn tất chuyển tiền hoàn cho bạn.'],
    ];
    $currentRefund = $yeuCauHoanTien ? ($refundStatusMap[$yeuCauHoanTien->trang_thai] ?? ['Đang xử lý', 'secondary', 'bi-info-circle', '']) : null;
    $refundAttempts = $yeuCauHoanTien ? (int) ($yeuCauHoanTien->so_lan_yeu_cau ?? 1) : 0;

    $isPendingCancelRequest = (bool) $donHang->yeu_cau_huy
        && in_array($donHang->trang_thai, ['dang_xu_ly', 'cho_duyet_huy'], true);
    $cancelRequestAttempts = (int) ($donHang->so_lan_yeu_cau_huy ?? 0);
@endphp

<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden order-status-card">
    <div class="card-header bg-white border-bottom border-slate-100 py-3 px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="status-header-icon rounded-circle d-inline-flex align-items-center justify-content-center text-primary bg-primary-subtle" style="width: 30px; height: 30px;">
                <i class="bi bi-clock-history fs-6"></i>
            </span>
            <h5 class="mb-0 fw-bold fs-15 text-slate-800">Tiến trình đơn hàng</h5>
        </div>
        <div class="fs-13 text-muted">
            @if ($effectiveTrangThai === 'da_hoan_thanh')
                <span class="text-emerald-600 fw-medium d-inline-flex align-items-center gap-1">
                    <i class="bi bi-check-circle-fill"></i> Đơn hàng đã hoàn thành
                </span>
            @elseif ($effectiveTrangThai === 'da_huy')
                <span class="text-rose-600 fw-medium d-inline-flex align-items-center gap-1">
                    <i class="bi bi-x-circle-fill"></i> Đơn hàng đã bị hủy
                </span>
            @else
                <span class="text-slate-500">Cập nhật theo thời gian thực</span>
            @endif
        </div>
    </div>

    <div class="card-body p-4">
        @if ($effectiveTrangThai === 'da_huy')
            {{-- BANNER ĐƠN HÀNG ĐÃ BỊ HỦY --}}
            <div class="p-3-5 rounded-3 bg-rose-50/80 border border-rose-200">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-rose-100 text-rose-600 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                        <i class="bi bi-x-lg fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold text-rose-900 fs-15 mb-0.5">Đơn hàng này đã bị hủy</h6>
                        <p class="fs-13 text-rose-700 mb-0">Đơn hàng đã kết thúc và không tiếp tục giao đến bạn.</p>
                        @if ($donHang->ly_do_huy_boi_admin)
                            <div class="p-2-5 rounded-3 bg-white border border-rose-200 fs-13 text-slate-800 mt-2-5">
                                <strong class="text-rose-800"><i class="bi bi-info-circle me-1"></i> Lý do từ cửa hàng:</strong>
                                <span>{{ $donHang->ly_do_huy_boi_admin }}</span>
                            </div>
                        @elseif ($donHang->ly_do_yeu_cau_huy)
                            <div class="p-2-5 rounded-3 bg-white border border-rose-200 fs-13 text-slate-800 mt-2-5">
                                <strong class="text-rose-800"><i class="bi bi-info-circle me-1"></i> Lý do hủy của bạn:</strong>
                                <span>{{ $donHang->ly_do_yeu_cau_huy }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        @elseif ($isPendingCancelRequest)
            {{-- BANNER ĐANG CHỜ PHÊ DUYỆT HỦY --}}
            <div class="p-3-5 rounded-3 bg-amber-50/80 border border-amber-200">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-amber-100 text-amber-700 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                        <i class="bi bi-hourglass-split fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold text-amber-900 fs-15 mb-0.5">Yêu cầu hủy đơn đang chờ quản trị viên duyệt</h6>
                        <p class="fs-13 text-amber-700 mb-0">Cửa hàng đang kiểm tra tình trạng đóng gói sản phẩm trước khi xác nhận hủy cho bạn.</p>
                        @if ($donHang->ly_do_yeu_cau_huy)
                            <div class="p-2-5 rounded-3 bg-white border border-amber-200 fs-13 text-slate-800 mt-2-5">
                                <strong class="text-amber-800">Lý do đã gửi:</strong>
                                <span>{{ $donHang->ly_do_yeu_cau_huy }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        @else
            {{-- TIMELINE STEPPER 5 BƯỚC --}}
            @php
                $steps = [
                    'cho_xac_nhan'  => ['label' => 'Đặt hàng', 'icon' => 'bi-file-earmark-text', 'sub' => 'Đã gửi đơn'],
                    'dang_xu_ly'   => ['label' => 'Đang chuẩn bị', 'icon' => 'bi-box-seam', 'sub' => 'Đóng gói hàng'],
                    'dang_giao'     => ['label' => 'Đang giao', 'icon' => 'bi-truck', 'sub' => 'Shipper vận chuyển'],
                    'da_nhan_hang'  => ['label' => 'Đã nhận hàng', 'icon' => 'bi-check2-circle', 'sub' => 'Đã tới bạn'],
                    'da_hoan_thanh' => ['label' => 'Hoàn tất', 'icon' => 'bi-patch-check', 'sub' => 'Thành công'],
                ];

                $orderHierarchy = [
                    'cho_xac_nhan'  => 1,
                    'dang_xu_ly'   => 2,
                    'cho_duyet_huy' => 2,
                    'dang_giao'     => 3,
                    'da_giao'       => 3,
                    'da_nhan_hang'  => 4,
                    'da_hoan_thanh' => 5,
                ];
                $currentStepLevel = $orderHierarchy[$effectiveTrangThai] ?? 1;
            @endphp

            <div class="timeline-stepper py-2">
                <div class="stepper-wrapper">
                    @php $i = 1; @endphp
                    @foreach ($steps as $key => $step)
                        @php
                            $isCompleted = $currentStepLevel > $i;
                            $isCurrent = $currentStepLevel === $i;
                            $isPending = $currentStepLevel < $i;
                        @endphp
                        <div class="stepper-step {{ $isCompleted ? 'step-completed' : '' }} {{ $isCurrent ? 'step-current' : '' }} {{ $isPending ? 'step-pending' : '' }}">
                            <div class="step-node-container">
                                <div class="step-node shadow-2xs">
                                    @if ($isCompleted)
                                        <i class="bi bi-check-lg fw-bold"></i>
                                    @else
                                        <i class="bi {{ $step['icon'] }}"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="step-content text-center mt-2">
                                <div class="step-title fw-semibold fs-13">{{ $step['label'] }}</div>
                                <div class="step-subtitle text-muted fs-12">{{ $step['sub'] }}</div>
                            </div>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
            </div>

            {{-- CÁC MỐC THỜI GIAN QUAN TRỌNG --}}
            @if ($donHang->da_giao_at || $donHang->da_nhan_hang_at)
                <div class="row g-2 mt-4 pt-3 border-top border-slate-100">
                    @if ($donHang->da_giao_at)
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2 p-2-5 rounded-3 bg-slate-50 border border-slate-200/60 fs-13">
                                <i class="bi bi-truck text-primary"></i>
                                <span class="text-slate-600">Giao hàng thành công:</span>
                                <strong class="text-slate-800">{{ $donHang->da_giao_at->format('H:i - d/m/Y') }}</strong>
                            </div>
                        </div>
                    @endif
                    @if ($donHang->da_nhan_hang_at)
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2 p-2-5 rounded-3 bg-slate-50 border border-slate-200/60 fs-13">
                                <i class="bi bi-box-seam text-emerald-600"></i>
                                <span class="text-slate-600">Thời gian nhận hàng:</span>
                                <strong class="text-slate-800">{{ $donHang->da_nhan_hang_at->format('H:i - d/m/Y') }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if ($donHang->ly_do_tu_choi_huy && in_array($donHang->trang_thai, ['dang_xu_ly', 'dang_giao'], true))
                <div class="alert alert-warning border border-warning-subtle rounded-3 p-3 mt-3 mb-0 fs-13">
                    <strong class="text-warning-emphasis"><i class="bi bi-exclamation-triangle me-1"></i> Từ chối yêu cầu hủy:</strong>
                    <span>{{ $donHang->ly_do_tu_choi_huy }}</span>
                </div>
            @endif
        @endif

        {{-- ==================== PHẦN THÔNG TIN HOÀN TIỀN/TRẢ HÀNG ==================== --}}
        @if ($yeuCauHoanTien && $currentRefund)
            <div class="mt-4 card border border-{{ $currentRefund[1] }}-subtle shadow-2xs rounded-3 overflow-hidden">
                <div class="card-header bg-{{ $currentRefund[1] }}-subtle text-{{ $currentRefund[1] }}-emphasis fw-semibold py-2 px-3 d-flex justify-content-between align-items-center fs-8">
                    <span class="d-inline-flex align-items-center gap-2">
                        <i class="bi {{ $currentRefund[2] }}"></i> Yêu cầu Hoàn tiền / Trả hàng
                    </span>
                    <span class="badge bg-{{ $currentRefund[1] }} rounded-pill">{{ $currentRefund[0] }}</span>
                </div>
                <div class="card-body p-3 fs-8">
                    <div class="row g-2">
                        <div class="col-sm-6 d-flex justify-content-between py-1 border-bottom border-slate-100">
                            <span class="text-muted">Số tiền hoàn dự kiến:</span>
                            <strong class="text-slate-900">{{ number_format($yeuCauHoanTien->so_tien_yeu_cau ?? 0, 0, ',', '.') }} ₫</strong>
                        </div>
                        @if ($yeuCauHoanTien->created_at)
                            <div class="col-sm-6 d-flex justify-content-between py-1 border-bottom border-slate-100">
                                <span class="text-muted">Thời gian gửi yêu cầu:</span>
                                <strong>{{ $yeuCauHoanTien->created_at->format('H:i - d/m/Y') }}</strong>
                            </div>
                        @endif
                    </div>
                    @if ($yeuCauHoanTien->ly_do)
                        <div class="mt-2 text-slate-700">
                            <span class="text-muted">Lý do:</span> {{ $yeuCauHoanTien->ly_do }}
                        </div>
                    @endif

                    @if ($yeuCauHoanTien->trang_thai === 'da_hoan_tien' && $yeuCauHoanTien->hinh_anh_xac_nhan)
                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill d-inline-flex align-items-center gap-1-5 px-3 py-1 fs-8"
                                data-bs-toggle="modal" data-bs-target="#refundProofModal{{ $yeuCauHoanTien->id }}">
                                <i class="bi bi-file-earmark-image"></i>
                                <span>Xem ảnh minh chứng chuyển khoản</span>
                            </button>
                        </div>

                        <div class="modal fade" id="refundProofModal{{ $yeuCauHoanTien->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <h6 class="modal-title fw-bold">Chứng từ hoàn tiền thành công</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-4">
                                        <a href="{{ asset('storage/' . $yeuCauHoanTien->hinh_anh_xac_nhan) }}" target="_blank" rel="noopener">
                                            <img src="{{ asset('storage/' . $yeuCauHoanTien->hinh_anh_xac_nhan) }}" alt="Ảnh minh chứng hoàn tiền" class="img-fluid rounded-3 shadow-sm" style="max-height: 500px;">
                                        </a>
                                        <div class="mt-2 text-muted fs-8">Nhấp vào ảnh để xem kích thước gốc</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mt-2 mb-0 fs-8">{{ $currentRefund[3] }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL HỦY ĐƠN HÀNG --}}
@php
    $canCancelOrder = $donHang->trang_thai === 'cho_xac_nhan'
        || ($donHang->trang_thai === 'dang_xu_ly' && !$isPendingCancelRequest && $cancelRequestAttempts < 2);
    $laYeuCauHuyOnline = $donHang->phuong_thuc_thanh_toan === 'vnpay' && $donHang->trang_thai === 'dang_xu_ly';
    $boQuaLyDoHuy = ($donHang->phuong_thuc_thanh_toan === 'vnpay' && $donHang->trang_thai === 'cho_xac_nhan')
        || ($donHang->phuong_thuc_thanh_toan === 'cod' && $donHang->trang_thai === 'cho_xac_nhan');
@endphp

@if ($canCancelOrder)
    <div class="modal fade" id="modalHuyDon" tabindex="-1" aria-labelledby="modalHuyDonLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <form action="{{ route('order.cancel', $donHang->id) }}" method="post">
                    @csrf
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle bg-rose-100 text-rose-600 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                <i class="bi bi-exclamation-triangle fs-5"></i>
                            </span>
                            <h5 class="modal-title fw-bold fs-5 text-slate-900" id="modalHuyDonLabel">
                                {{ $laYeuCauHuyOnline ? 'Yêu cầu hủy đơn hàng' : 'Xác nhận hủy đơn hàng' }}
                            </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body px-4 py-3">
                        @if ($laYeuCauHuyOnline)
                            <div class="p-3 rounded-3 bg-amber-50 border border-amber-200 text-amber-900 fs-8 mb-3">
                                <i class="bi bi-info-circle me-1"></i> Đơn hàng đang được chuẩn bị. Yêu cầu của bạn sẽ được gửi tới Admin xét duyệt và xử lý hoàn tiền theo quy định.
                            </div>
                        @else
                            <p class="text-muted fs-8 mb-3">
                                Bạn có chắc chắn muốn hủy đơn hàng <strong>#{{ $donHang->ma_don_hang }}</strong>? Thao tác này không thể hoàn tác.
                            </p>
                        @endif

                        @if (!$boQuaLyDoHuy)
                            <div class="mb-2">
                                <label for="ly_do_yeu_cau_huy" class="form-label fw-semibold fs-8 text-slate-800">
                                    Lý do hủy đơn <span class="text-danger">*</span>
                                </label>
                                <textarea name="ly_do_yeu_cau_huy" id="ly_do_yeu_cau_huy" class="form-control rounded-3 fs-8"
                                    rows="3" required maxlength="2000" placeholder="Vui lòng cho chúng tôi biết lý do hủy đơn của bạn...">{{ old('ly_do_yeu_cau_huy') }}</textarea>
                                @error('ly_do_yeu_cau_huy')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 fs-8 fw-medium" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 fs-8 fw-semibold">
                            {{ $laYeuCauHuyOnline ? 'Gửi yêu cầu hủy' : 'Xác nhận hủy' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (isset($errors) && $errors->has('ly_do_yeu_cau_huy'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var el = document.getElementById('modalHuyDon');
                if (el && window.bootstrap && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(el).show();
                }
            });
        </script>
    @endif
@endif
