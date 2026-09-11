@include('client.layout.header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<main class="order-detail-page bg-slate-50 py-4 py-lg-5" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-xxl-10">

                {{-- THÔNG TIN TIÊU ĐỀ & BREADCRUMB --}}
                @include('client.Order.components.order-header', ['donHang' => $donHang])

                {{-- BỐ CỤC 2 CỘT HIỆN ĐẠI --}}
                <div class="row g-4">
                    {{-- CỘT TRÁI (COL-LG-8): TIẾN TRÌNH + SẢN PHẨM + ĐÁNH GIÁ --}}
                    <div class="col-lg-8">
                        @include('client.Order.components.order-status', ['donHang' => $donHang])

                        @include('client.Order.components.order-products', ['donHang' => $donHang])
                    </div>

                    {{-- CỘT PHẢI (COL-LG-4): STICKY SIDEBAR + ACTION HUB --}}
                    <div class="col-lg-4">
                        @include('client.Order.components.order-sidebar', ['donHang' => $donHang])
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

{{-- MODAL YÊU CẦU HOÀN TIỀN / TRẢ HÀNG --}}
@include('client.Order.components.refund-request-modal', ['donHang' => $donHang])

<style>
    /* ================= DESIGN SYSTEM TOKENS ================= */
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
        --emerald-500: #10b981;
        --emerald-600: #059669;
    }

    .order-detail-page {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        font-size: 14px;
        line-height: 1.5;
        color: #1e293b;
    }

    .bg-slate-50 { background-color: #f8fafc !important; }
    .bg-slate-100 { background-color: #f1f5f9 !important; }
    .text-slate-400 { color: #94a3b8 !important; }
    .text-slate-500 { color: #64748b !important; }
    .text-slate-600 { color: #475569 !important; }
    .text-slate-700 { color: #334155 !important; }
    .text-slate-800 { color: #1e293b !important; }
    .text-slate-900 { color: #0f172a !important; }
    .border-slate-100 { border-color: #f1f5f9 !important; }
    .border-slate-200 { border-color: #e2e8f0 !important; }

    /* Tailwind-like utility colors */
    .bg-emerald-50 { background-color: #ecfdf5 !important; }
    .text-emerald-700 { color: #047857 !important; }
    .text-emerald-800 { color: #065f46 !important; }
    .border-emerald-200 { border-color: #a7f3d0 !important; }

    .bg-amber-50 { background-color: #fffbeb !important; }
    .text-amber-700 { color: #b45309 !important; }
    .text-amber-800 { color: #92400e !important; }
    .text-amber-900 { color: #78350f !important; }
    .border-amber-200 { border-color: #fde68a !important; }

    .bg-rose-50 { background-color: #fff1f2 !important; }
    .text-rose-600 { color: #e11d48 !important; }
    .text-rose-700 { color: #be123c !important; }
    .text-rose-900 { color: #881337 !important; }
    .border-rose-200 { border-color: #fecdd3 !important; }

    .bg-sky-50 { background-color: #f0f9ff !important; }
    .text-sky-700 { color: #0369a1 !important; }
    .text-sky-900 { color: #0c4a6e !important; }
    .border-sky-200 { border-color: #bae6fd !important; }

    .bg-teal-50 { background-color: #f0fdfa !important; }
    .text-teal-700 { color: #0f766e !important; }
    .border-teal-200 { border-color: #99f6e4 !important; }

    .bg-indigo-50 { background-color: #eef2ff !important; }
    .text-indigo-700 { color: #4338ca !important; }
    .border-indigo-200 { border-color: #c7d2fe !important; }

    /* Font sizes đồng đều, chuẩn mực */
    .fs-12 { font-size: 12px !important; }
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .fs-15 { font-size: 15px !important; }
    .fs-16 { font-size: 16px !important; }
    .fs-18 { font-size: 18px !important; }
    .fs-20 { font-size: 20px !important; }

    /* Giữ tương thích các class cũ nhưng quy về chuẩn đều đặn */
    .fs-8 { font-size: 13px !important; }
    .fs-9 { font-size: 12px !important; }

    .gap-1-5 { gap: 0.375rem !important; }
    .gap-2-5 { gap: 0.625rem !important; }
    .p-2-5 { padding: 0.625rem !important; }
    .p-3-5 { padding: 0.875rem !important; }
    .shadow-2xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }

    .order-detail-page .card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
    }

    .order-detail-page .card-header {
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 14px 20px !important;
        background-color: #ffffff !important;
    }

    .order-detail-page .card-body {
        padding: 20px !important;
    }

    .hover-text-primary:hover {
        color: #0f172a !important;
        text-decoration: underline !important;
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Structured info rows */
    .info-list-group {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-icon-box {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }

    .info-content {
        flex: 1;
        min-width: 0;
    }

    .info-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 2px;
        font-weight: 500;
        line-height: 1.2;
    }

    .info-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 500;
        line-height: 1.5;
        word-break: break-word;
    }

    /* Table alignment */
    .order-table th, .order-table td {
        vertical-align: middle !important;
    }

    /* ================= TIMELINE STEPPER ================= */
    .timeline-stepper {
        position: relative;
        padding: 10px 0;
    }

    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .stepper-step {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .stepper-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 22px;
        left: 50%;
        width: 100%;
        height: 3px;
        background-color: #e2e8f0;
        z-index: 1;
        transition: background-color 0.3s ease;
    }

    .stepper-step.step-completed:not(:last-child)::after {
        background-color: #10b981;
    }

    .step-node-container {
        position: relative;
        z-index: 3;
    }

    .step-node {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        background-color: #f1f5f9;
        color: #94a3b8;
        border: 2px solid #e2e8f0;
    }

    /* Step đã hoàn thành */
    .stepper-step.step-completed .step-node {
        background-color: #ecfdf5;
        color: #059669;
        border-color: #10b981;
    }

    .stepper-step.step-completed .step-title {
        color: #059669;
    }

    /* Step hiện tại đang hoạt động */
    .stepper-step.step-current .step-node {
        background-color: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        box-shadow: 0 0 0 5px rgba(15, 23, 42, 0.15);
        animation: pulseStep 2s infinite;
    }

    .stepper-step.step-current .step-title {
        color: #0f172a;
        font-weight: 700;
    }

    /* Step chờ tới lượt */
    .stepper-step.step-pending .step-title {
        color: #94a3b8;
    }

    @keyframes pulseStep {
        0% { box-shadow: 0 0 0 0 rgba(15, 23, 42, 0.25); }
        70% { box-shadow: 0 0 0 8px rgba(15, 23, 42, 0); }
        100% { box-shadow: 0 0 0 0 rgba(15, 23, 42, 0); }
    }

    .step-title {
        font-size: 0.8125rem;
        margin-top: 6px;
    }

    /* Responsive stepper trên màn hình nhỏ */
    @media (max-width: 576px) {
        .step-node {
            width: 36px;
            height: 36px;
            font-size: 0.95rem;
        }
        .stepper-step:not(:last-child)::after {
            top: 18px;
        }
        .step-title {
            font-size: 0.7rem;
        }
        .step-subtitle {
            display: none;
        }
    }

    /* Interactive star rating */
    .interactive-star-rating .star-btn {
        text-decoration: none;
        transition: transform 0.15s ease;
    }
    .interactive-star-rating .star-btn:hover {
        transform: scale(1.2);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý Checkbox & Số lượng trong Modal Hoàn trả
        const checkboxes = document.querySelectorAll('input[name="chi_tiet_ids[]"]');
        checkboxes.forEach(checkbox => {
            const inputSoLuong = checkbox.closest('.d-flex')?.querySelector('.so-luong-input');
            if (!inputSoLuong) return;
            checkbox.addEventListener('change', function() {
                inputSoLuong.disabled = !this.checked;
                inputSoLuong.value = this.checked ? 1 : '';
            });
            inputSoLuong.addEventListener('input', function() {
                let val = parseInt(this.value) || 1;
                const max = parseInt(this.max) || 999;
                if (val < 1) val = 1;
                if (val > max) val = max;
                this.value = val;
            });
        });

        // Setup image preview
        setupImagePreview('hinhAnhInput', 'previewContainer', 5, 'Bạn chỉ được tải lên tối đa 5 ảnh minh chứng.');
        setupImagePreview('hinhTaiKhoanInput', 'previewTaiKhoanContainer', 5, 'Bạn chỉ được tải lên tối đa 5 ảnh thông tin tài khoản.');

        // Form Submit guard
        const form = document.getElementById('formYeuCauHoanTra');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (form.dataset.submitting === '1') {
                    e.preventDefault();
                    return;
                }

                const hasReturnItemSelection = document.querySelectorAll('input[name="chi_tiet_ids[]"]').length > 0;
                const checkedCount = document.querySelectorAll('input[name="chi_tiet_ids[]"]:checked').length;
                if (hasReturnItemSelection && checkedCount === 0) {
                    e.preventDefault();
                    alert('Vui lòng chọn ít nhất một sản phẩm để hoàn trả.');
                    return;
                }

                form.dataset.submitting = '1';
                form.querySelectorAll('button[type="submit"]').forEach((btn) => {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang gửi...';
                });
            });
        }

        function setupImagePreview(inputId, containerId, maxFiles, alertMessage) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(containerId);
            if (!input || !container) return;

            input.addEventListener('change', function() {
                container.innerHTML = '';
                const files = this.files;
                if (files.length > maxFiles) {
                    alert(alertMessage);
                    this.value = '';
                    return;
                }
                Array.from(files).forEach((file, index) => {
                    if (!file.type.startsWith('image/')) {
                        alert('File không phải ảnh: ' + file.name);
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-4 col-sm-3 position-relative';
                        col.innerHTML = `
                            <div class="border rounded-3 overflow-hidden position-relative bg-light" style="height: 80px;">
                                <img src="${e.target.result}" class="w-100 h-100 object-fit-cover" alt="Preview">
                                <button type="button" class="btn btn-sm btn-dark rounded-circle position-absolute top-0 end-0 m-1 d-flex align-items-center justify-content-center remove-preview" 
                                        data-index="${index}" style="width: 22px; height: 22px; padding: 0;">
                                    <i class="bi bi-x fs-6"></i>
                                </button>
                            </div>
                            <small class="d-block text-muted text-truncate mt-1 fs-9 text-center">${file.name}</small>
                        `;
                        container.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
            });

            container.addEventListener('click', function(e) {
                const btn = e.target.closest('.remove-preview');
                if (btn) btn.closest('.col-4')?.remove();
            });
        }

        // Toggle phương thức nhận hoàn tiền (Upload QR vs Nhập tay)
        const methodUpload = document.getElementById('method_upload');
        const methodManual = document.getElementById('method_manual');
        const uploadSection = document.getElementById('upload_section');
        const manualSection = document.getElementById('manual_section');
        const uploadInput = document.getElementById('hinhTaiKhoanInput');
        const manualInputs = manualSection ? manualSection.querySelectorAll('input[name="ngan_hang"], input[name="so_tai_khoan"], input[name="chi_nhanh"], input[name="ten_chu_tk"]') : [];

        if (methodUpload && methodManual) {
            function toggleRefundMethod() {
                if (methodUpload.checked) {
                    uploadSection.classList.remove('d-none');
                    manualSection.classList.add('d-none');
                    if (uploadInput) {
                        uploadInput.disabled = false;
                        uploadInput.required = true;
                    }
                    manualInputs.forEach((input) => {
                        input.disabled = true;
                        input.required = false;
                    });
                } else {
                    uploadSection.classList.add('d-none');
                    manualSection.classList.remove('d-none');
                    if (uploadInput) {
                        uploadInput.disabled = true;
                        uploadInput.required = false;
                        uploadInput.value = '';
                    }
                    manualInputs.forEach((input) => {
                        input.disabled = false;
                        if (input.name !== 'chi_nhanh') {
                            input.required = true;
                        }
                    });
                }
            }

            methodUpload.addEventListener('change', toggleRefundMethod);
            methodManual.addEventListener('change', toggleRefundMethod);
            toggleRefundMethod();
        }
    });
</script>

@include('client.layout.footer')
@include('client.layout.scripts')
