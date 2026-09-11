<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden order-products-card">
    <div class="card-header bg-white border-bottom border-slate-100 py-3 px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-primary bg-primary-subtle" style="width: 30px; height: 30px;">
                <i class="bi bi-bag-check fs-6"></i>
            </span>
            <h5 class="mb-0 fw-bold fs-15 text-slate-800">
                Sản phẩm trong đơn ({{ $donHang->chiTietDonHangs->count() }})
            </h5>
        </div>
        <span class="fs-13 text-slate-500">Tổng {{ $donHang->chiTietDonHangs->sum('so_luong') }} món</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 order-table">
                <thead class="bg-slate-50 text-slate-600 fs-13 border-bottom border-slate-200">
                    <tr>
                        <th class="ps-4 py-3 fw-semibold">Sản phẩm</th>
                        <th class="text-center py-3 fw-semibold" style="width: 100px;">Số lượng</th>
                        <th class="text-end py-3 fw-semibold" style="width: 130px;">Đơn giá</th>
                        <th class="text-end pe-4 py-3 fw-semibold" style="width: 140px;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($donHang->chiTietDonHangs as $chiTiet)
                        <tr class="order-product-row">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative flex-shrink-0">
                                        <img src="{{ $chiTiet->sanPham->hinh_anh_chinh ? asset('storage/' . $chiTiet->sanPham->hinh_anh_chinh) : 'https://via.placeholder.com/64' }}"
                                            alt="{{ $chiTiet->sanPham->ten_san_pham }}" class="rounded-3 border border-slate-200 product-thumb-img"
                                            width="64" height="64" style="object-fit: cover;">
                                    </div>
                                    <div class="product-info min-w-0">
                                        <a href="{{ $chiTiet->sanPham ? route('sanpham.chitiet', $chiTiet->sanPham->slug) : '#' }}" class="fw-semibold text-slate-900 text-decoration-none hover-text-primary text-truncate-2 fs-14 mb-1 d-block">
                                            {{ $chiTiet->sanPham->ten_san_pham }}
                                        </a>

                                        @if ($chiTiet->bienThe)
                                            <div class="d-inline-flex align-items-center gap-1-5 px-2-5 py-0-5 rounded-pill bg-slate-100 text-slate-600 fs-12 border border-slate-200 mt-1">
                                                @if ($chiTiet->bienThe->color)
                                                    <span class="rounded-circle border border-slate-300 flex-shrink-0"
                                                        style="width: 10px; height: 10px; background-color: {{ $chiTiet->bienThe->color->ma_mau ?? '#ccc' }};"></span>
                                                    <span>{{ $chiTiet->bienThe->color->ten_mau ?? '—' }}</span>
                                                @endif
                                                @if ($chiTiet->bienThe->size)
                                                    <span class="text-slate-400">/</span>
                                                    <span class="fw-medium">{{ $chiTiet->bienThe->size->ten_kich_thuoc }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center py-3 align-middle">
                                <span class="fw-medium text-slate-700 fs-14">
                                    ×{{ $chiTiet->so_luong }}
                                </span>
                            </td>
                            <td class="text-end py-3 text-slate-600 fs-14 align-middle">
                                {{ number_format($chiTiet->don_gia, 0, ',', '.') }} ₫
                            </td>
                            <td class="text-end pe-4 py-3 fw-bold text-slate-900 fs-14 align-middle">
                                {{ number_format($chiTiet->thanh_tien, 0, ',', '.') }} ₫
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- KHU VỰC ĐÁNH GIÁ SẢN PHẨM (KHI ĐƠN ĐÃ HOÀN THÀNH) --}}
@if ($donHang->trang_thai === 'da_hoan_thanh')
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden order-reviews-card">
        <div class="card-header bg-white border-bottom border-slate-100 py-3 px-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-amber-500 bg-amber-50" style="width: 32px; height: 32px;">
                    <i class="bi bi-star-fill fs-6"></i>
                </span>
                <div>
                    <h5 class="mb-0 fw-bold fs-6 text-slate-800">Đánh giá sản phẩm</h5>
                    <div class="fs-8 text-muted">Chia sẻ trải nghiệm sử dụng của bạn để nhận điểm tích lũy</div>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="d-flex flex-column gap-3">
                @foreach ($donHang->chiTietDonHangs as $chiTiet)
                    @php
                        $daDanhGia = \App\Models\BinhLuan::where('user_id', auth()->id())
                            ->where('san_pham_id', $chiTiet->sanPham->id)
                            ->where('don_hang_id', $donHang->id)
                            ->where('bien_the_id', $chiTiet->bien_the_id)
                            ->exists();
                    @endphp

                    <div class="p-3-5 rounded-4 border border-slate-200/80 bg-slate-50/50 review-item-box">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $chiTiet->sanPham->hinh_anh_chinh ? asset('storage/' . $chiTiet->sanPham->hinh_anh_chinh) : 'https://via.placeholder.com/56' }}"
                                width="56" height="56" class="rounded-3 border border-slate-200 object-fit-cover flex-shrink-0" alt="">
                            <div class="min-w-0">
                                <h6 class="fw-bold text-slate-900 fs-8 mb-1 text-truncate">{{ $chiTiet->sanPham->ten_san_pham }}</h6>
                                @if ($chiTiet->bienThe)
                                    <div class="fs-8 text-muted d-flex align-items-center gap-1-5">
                                        @if ($chiTiet->bienThe->color)
                                            <span class="rounded-circle border" style="width:10px;height:10px;background-color:{{ $chiTiet->bienThe->color->ma_mau ?? '#ccc' }};"></span>
                                            <span>{{ $chiTiet->bienThe->color->ten_mau ?? '—' }}</span>
                                        @endif
                                        @if ($chiTiet->bienThe->size)
                                            <span class="text-slate-300">/</span>
                                            <span>Size {{ $chiTiet->bienThe->size->ten_kich_thuoc }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($daDanhGia)
                            <div class="p-3 rounded-3 bg-emerald-50 border border-emerald-200 text-emerald-800 d-flex align-items-center gap-2 fs-8">
                                <i class="bi bi-patch-check-fill fs-5 text-emerald-600"></i>
                                <div>
                                    <strong class="d-block">Bạn đã đánh giá sản phẩm này</strong>
                                    <span class="text-emerald-700">Cảm ơn bạn đã đóng góp phản hồi quý giá cho cộng đồng người mua!</span>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('binh-luan.store') }}" method="POST" class="review-form"
                                data-product-id="{{ $chiTiet->sanPham->id }}" data-variant-id="{{ $chiTiet->bien_the_id }}" data-order-id="{{ $donHang->id }}">
                                @csrf
                                <input type="hidden" name="san_pham_id" value="{{ $chiTiet->sanPham->id }}">
                                <input type="hidden" name="bien_the_id" value="{{ $chiTiet->bien_the_id }}">
                                <input type="hidden" name="don_hang_id" value="{{ $donHang->id }}">
                                <input type="hidden" name="so_sao" value="5" class="star-rating-input">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold fs-8 text-slate-700 mb-1 d-block">Đánh giá chất lượng:</label>
                                    <div class="interactive-star-rating d-inline-flex align-items-center gap-1" data-current-rating="5">
                                        <button type="button" class="btn btn-link p-0 text-amber-400 star-btn" data-value="1" title="1 sao - Rất tệ"><i class="bi bi-star-fill fs-5"></i></button>
                                        <button type="button" class="btn btn-link p-0 text-amber-400 star-btn" data-value="2" title="2 sao - Chưa tốt"><i class="bi bi-star-fill fs-5"></i></button>
                                        <button type="button" class="btn btn-link p-0 text-amber-400 star-btn" data-value="3" title="3 sao - Bình thường"><i class="bi bi-star-fill fs-5"></i></button>
                                        <button type="button" class="btn btn-link p-0 text-amber-400 star-btn" data-value="4" title="4 sao - Hài lòng"><i class="bi bi-star-fill fs-5"></i></button>
                                        <button type="button" class="btn btn-link p-0 text-amber-400 star-btn" data-value="5" title="5 sao - Tuyệt vời"><i class="bi bi-star-fill fs-5"></i></button>
                                        <span class="rating-text ms-2 fs-8 text-amber-600 fw-semibold">Tuyệt vời (5 sao)</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold fs-8 text-slate-700 mb-1">Nhận xét chi tiết:</label>
                                    <textarea name="noi_dung" class="form-control rounded-3 fs-8" rows="3"
                                        placeholder="Chất liệu vải thế nào? Form áo có vừa vặn không? Hãy chia sẻ cảm nhận thực tế nhé..."></textarea>
                                </div>

                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <button class="btn btn-dark rounded-pill px-4 py-2 fs-8 fw-semibold d-inline-flex align-items-center gap-2" type="submit">
                                        <i class="bi bi-send-fill"></i>
                                        <span>Gửi đánh giá</span>
                                    </button>
                                </div>
                                <div class="mt-2 alert-message" style="display: none;"></div>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Interactive Star Rating
        const starWrappers = document.querySelectorAll('.interactive-star-rating');
        const starLabels = {
            1: 'Rất tệ (1 sao)',
            2: 'Chưa hài lòng (2 sao)',
            3: 'Bình thường (3 sao)',
            4: 'Hài lòng (4 sao)',
            5: 'Tuyệt vời (5 sao)'
        };

        starWrappers.forEach(wrapper => {
            const starBtns = wrapper.querySelectorAll('.star-btn');
            const hiddenInput = wrapper.closest('form').querySelector('.star-rating-input');
            const textSpan = wrapper.querySelector('.rating-text');

            const setStars = (val) => {
                starBtns.forEach(btn => {
                    const btnVal = parseInt(btn.dataset.value);
                    const icon = btn.querySelector('i');
                    if (btnVal <= val) {
                        icon.className = 'bi bi-star-fill fs-5 text-amber-400';
                    } else {
                        icon.className = 'bi bi-star fs-5 text-slate-300';
                    }
                });
                if (textSpan) textSpan.textContent = starLabels[val] || `${val} sao`;
            };

            starBtns.forEach(btn => {
                btn.addEventListener('mouseenter', () => {
                    setStars(parseInt(btn.dataset.value));
                });
                btn.addEventListener('click', () => {
                    const val = parseInt(btn.dataset.value);
                    wrapper.dataset.currentRating = val;
                    if (hiddenInput) hiddenInput.value = val;
                    setStars(val);
                });
            });

            wrapper.addEventListener('mouseleave', () => {
                setStars(parseInt(wrapper.dataset.currentRating || 5));
            });
        });

        // AJAX Review Submission
        const forms = document.querySelectorAll('.review-form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const alertDiv = this.querySelector('.alert-message');

                submitBtn.disabled = true;
                const originalBtnContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Đang gửi...';

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return null;
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data) return;

                    if (data.success) {
                        const reviewBox = form.closest('.review-item-box');
                        form.remove();
                        if (reviewBox) {
                            const successNotice = document.createElement('div');
                            successNotice.className = 'p-3 rounded-3 bg-emerald-50 border border-emerald-200 text-emerald-800 d-flex align-items-center gap-2 fs-8 mt-2';
                            successNotice.innerHTML = `
                                <i class="bi bi-patch-check-fill fs-5 text-emerald-600"></i>
                                <div>
                                    <strong class="d-block">Bạn đã đánh giá sản phẩm này</strong>
                                    <span class="text-emerald-700">${data.message || 'Cảm ơn phản hồi của bạn!'}</span>
                                </div>
                            `;
                            reviewBox.appendChild(successNotice);
                        }
                    } else if (data.error) {
                        alertDiv.className = 'mt-2 alert-message alert alert-danger py-2 px-3 fs-8 rounded-3';
                        alertDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i> ' + data.error;
                        alertDiv.style.display = 'block';
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnContent;
                    }
                })
                .catch(error => {
                    window.location.reload();
                });
            });
        });
    });
    </script>
@endif
