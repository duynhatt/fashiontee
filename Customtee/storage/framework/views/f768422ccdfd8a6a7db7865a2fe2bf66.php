<?php $__env->startSection('AdminContent'); ?>

<div class="d-flex justify-content-between align-items-center" style="margin-bottom:20px;">
    <h3 class="mb-0">Thêm biến thể sản phẩm</h3>
    <a href="<?php echo e(route('admin.san-pham.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Danh sách sản phẩm
    </a>
</div>

<form action="<?php echo e(route('variants.store')); ?>" method="POST" style="max-width:1500px;">
    <?php echo csrf_field(); ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <div class="form-group">
        <label>Sản phẩm</label>
        <select name="san_pham_id" id="productSelect" class="form-control" required>
            <option value="">-- Chọn sản phẩm --</option>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>" <?php echo e((old('san_pham_id', $selectedProductId ?? '') == $p->id) ? 'selected' : ''); ?>><?php echo e($p->ten_san_pham); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div id="productInfo" class="product-info-box">
        <img id="productImage">
        <div><b>Tên:</b> <span id="productName"></span></div>
        <div><b>Danh mục:</b> <span id="productCategory"></span></div>
        <div><b>Mô tả:</b> <span id="productDesc"></span></div>
    </div>

    
    <div id="existingVariants" class="product-info-box" style="display:none;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="font-weight-bold">Biến thể hiện có</div>
            <div class="text-muted small" id="existingVariantsCount"></div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table table-sm table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>Giá</th>
                        <th>Giá KM</th>
                        <th>Kho</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody id="existingVariantsBody"></tbody>
            </table>
        </div>
    </div>

    <?php
        $oldVariants = old('variants', [
            [
                'mau_sac_id' => '',
                'kich_thuoc_id' => '',
                'gia' => '',
                'gia_khuyen_mai' => '',
                'so_luong' => '',
                'trang_thai' => '1',
            ]
        ]);
    ?>

    <div class="form-group">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <label class="mb-0">Danh sách biến thể</label>
            <div class="form-check mb-0">
                <input type="checkbox" id="enableAutoVariantsPage" class="form-check-input">
                <label class="form-check-label" for="enableAutoVariantsPage">Biến thể tự động</label>
            </div>
        </div>

        <div id="autoVariantPanelPage" class="border p-3 mb-3" style="display:none;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="font-weight-bold">Tự tạo biến thể từ màu & size</div>
                <button type="button" id="btnCloseAutoVariantPanelPage" class="btn btn-sm btn-outline-secondary">Đóng</button>
            </div>
            <div id="autoVariantPreviewInfoPage" class="text-muted small mb-3">
                Chọn màu và size để xem trước số biến thể.
            </div>
            <div class="row small">
                <div class="col-md-6">
                    <div class="font-weight-bold mb-1">Màu sắc</div>
                    <div class="border p-2" style="max-height:140px; overflow:auto;">
                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input auto-variant-color-page" type="checkbox" value="<?php echo e($c->id); ?>" id="autoColorPage_<?php echo e($c->id); ?>">
                                <label class="form-check-label" for="autoColorPage_<?php echo e($c->id); ?>"><?php echo e($c->ten_mau); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="font-weight-bold mb-1">Kích thước</div>
                    <div class="border p-2" style="max-height:140px; overflow:auto;">
                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input auto-variant-size-page" type="checkbox" value="<?php echo e($s->id); ?>" id="autoSizePage_<?php echo e($s->id); ?>">
                                <label class="form-check-label" for="autoSizePage_<?php echo e($s->id); ?>"><?php echo e($s->ten_kich_thuoc); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="font-weight-bold mb-1">Giá chung</div>
                    <input type="number" id="autoVariantGiaChungPage" class="form-control form-control-sm" min="0" placeholder="Ví dụ: 10000">
                    <div class="text-muted small mt-2">Gán cho mọi biến thể</div>
                </div>
                <div class="col-md-6">
                    <div class="font-weight-bold mb-1">Số lượng chung</div>
                    <input type="number" id="autoVariantSoLuongChungPage" class="form-control form-control-sm" min="0" placeholder="Ví dụ: 10">
                    <div class="text-muted small mt-2">Gán kho cho mọi biến thể</div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="button" id="btnGenerateAutoVariantsPage" class="btn btn-primary btn-sm">Tạo biến thể</button>
            </div>
        </div>

        <div class="row variant-header">
            <div class="col-md-3">Màu</div>
            <div class="col-md-2">Size</div>
            <div class="col-md-2">Giá</div>
            <div class="col-md-2">Giá KM</div>
            <div class="col-md-2">Số lượng</div>
            <div class="col-3">Trạng thái</div>
        </div>
        <div id="variantsContainer" data-next-index="<?php echo e(count($oldVariants)); ?>">
            <?php $__currentLoopData = $oldVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="variant-row" data-index="<?php echo e($index); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="variants[<?php echo e($index); ?>][mau_sac_id]" class="form-control form-control-sm" required>
                                <option value="">-- Chọn màu --</option>
                                <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->id); ?>" <?php echo e(($row['mau_sac_id'] ?? '') == $c->id ? 'selected' : ''); ?>><?php echo e($c->ten_mau); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="variants[<?php echo e($index); ?>][kich_thuoc_id]" class="form-control form-control-sm" required>
                                <option value="">-- Chọn size --</option>
                                <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>" <?php echo e(($row['kich_thuoc_id'] ?? '') == $s->id ? 'selected' : ''); ?>><?php echo e($s->ten_kich_thuoc); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variants[<?php echo e($index); ?>][gia]" class="form-control form-control-sm" value="<?php echo e($row['gia'] ?? ''); ?>" min="0" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variants[<?php echo e($index); ?>][gia_khuyen_mai]" class="form-control form-control-sm" value="<?php echo e($row['gia_khuyen_mai'] ?? ''); ?>" min="0">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variants[<?php echo e($index); ?>][so_luong]" class="form-control form-control-sm" value="<?php echo e($row['so_luong'] ?? ''); ?>" min="0" required>
                        </div>
                        <div class="col-md-1">
                            <select name="variants[<?php echo e($index); ?>][trang_thai]" class="form-control form-control-sm">
                                <option value="1" <?php echo e(($row['trang_thai'] ?? '1') == '1' ? 'selected' : ''); ?>>Hiện</option>
                                <option value="0" <?php echo e(($row['trang_thai'] ?? '1') == '0' ? 'selected' : ''); ?>>Ẩn</option>
                            </select>
                        </div>
                    </div>
                    <div class="row variant-actions">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-variant">Xóa dòng</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button type="button" id="addVariantRow" class="btn btn-outline-primary btn-sm">Thêm dòng biến thể</button>
    </div>

    <button type="submit" class="btn btn-primary">Thêm biến thể</button>
</form>



<style>
.form-group{
    margin-bottom:15px;
}
.product-info-box{
    display:none;
    margin:15px 0;
    padding:10px;
    border:1px solid #ddd;
    background:#f9f9f9;
}
#productImage{
    width:120px;
    margin-bottom:10px;
    border-radius:6px;
}
#variantsContainer .variant-row{
    padding:10px;
    border:1px dashed #ddd;
    margin-bottom:10px;
    background:#fcfcfc;
}
.variant-header{
    font-size:12px;
    color:#666;
    margin-bottom:6px;
}
.variant-header .col-md-1,
.variant-header .col-md-2,
.variant-header .col-md-3{
    padding-top:2px;
    padding-bottom:2px;
}
.variant-actions{
    margin-top:8px;
}
</style>



<script>
// Load thông tin sản phẩm nếu đã chọn sẵn
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('productSelect');
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }
});

// Lưu các cặp (màu + size) đã tồn tại của sản phẩm đang chọn
// để UI có thể bỏ qua các cặp trùng và tránh lỗi submit.
const existingVariantPairs = new Set();

document.getElementById('productSelect').addEventListener('change', function () {
    let productId = this.value;

    if (!productId) {
        document.getElementById('productInfo').style.display = 'none';
        document.getElementById('existingVariants').style.display = 'none';
        existingVariantPairs.clear();
        updateAutoVariantPreviewInfoPage();
        return;
    }

    fetch(`/admin/products/info/${productId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('productInfo').style.display = 'block';
            document.getElementById('productName').innerText = data.name || '';
            document.getElementById('productCategory').innerText = data.category || '';
            document.getElementById('productDesc').innerText = data.desc || '';
            document.getElementById('productImage').src = data.image ? '/storage/' + data.image : '<?php echo e(asset("img/shop_01.jpg")); ?>';
        });

    fetch(`/admin/variants/by-product/${productId}`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('existingVariants');
            const body = document.getElementById('existingVariantsBody');
            const count = document.getElementById('existingVariantsCount');
            const variants = Array.isArray(data.variants) ? data.variants : [];

            existingVariantPairs.clear();
            variants.forEach(variant => {
                if (variant.mau_sac_id != null && variant.kich_thuoc_id != null) {
                    existingVariantPairs.add(`${String(variant.mau_sac_id)}-${String(variant.kich_thuoc_id)}`);
                }
            });

            body.innerHTML = '';
            if (variants.length === 0) {
                body.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Chưa có biến thể</td></tr>';
                count.textContent = '';
            } else {
                count.textContent = variants.length + ' biến thể';
                variants.forEach(variant => {
                    const gia = variant.gia != null ? Number(variant.gia).toLocaleString('vi-VN') + 'đ' : '-';
                    const giaKm = variant.gia_khuyen_mai != null ? Number(variant.gia_khuyen_mai).toLocaleString('vi-VN') + 'đ' : '-';
                    const status = variant.trang_thai ? 'Hiện' : 'Ẩn';
                    const row = `
                        <tr>
                            <td>${variant.mau || '-'}</td>
                            <td>${variant.size || '-'}</td>
                            <td>${gia}</td>
                            <td>${giaKm}</td>
                            <td>${variant.so_luong ?? 0}</td>
                            <td>${status}</td>
                        </tr>
                    `;
                    body.insertAdjacentHTML('beforeend', row);
                });
            }

            container.style.display = 'block';
            updateAutoVariantPreviewInfoPage();
        });
});

const variantsContainer = document.getElementById('variantsContainer');
const addVariantRowBtn = document.getElementById('addVariantRow');

function notifyError(msg) {
    if (window.toastr && typeof toastr.error === 'function') {
        toastr.error(msg);
    } else {
        alert(msg);
    }
}

const enableAutoVariantsPage = document.getElementById('enableAutoVariantsPage');
const autoVariantPanelPage = document.getElementById('autoVariantPanelPage');
const btnCloseAutoVariantPanelPage = document.getElementById('btnCloseAutoVariantPanelPage');
const btnGenerateAutoVariantsPage = document.getElementById('btnGenerateAutoVariantsPage');

enableAutoVariantsPage.addEventListener('change', function () {
    if (this.checked) {
        autoVariantPanelPage.style.display = 'block';
        updateAutoVariantPreviewInfoPage();
        return;
    }

    autoVariantPanelPage.style.display = 'none';

    // Reset lựa chọn và input để lần bật sau sạch sẽ hơn
    document.getElementById('autoVariantGiaChungPage').value = '';
    document.getElementById('autoVariantSoLuongChungPage').value = '';
    autoVariantPanelPage.querySelectorAll('.auto-variant-color-page, .auto-variant-size-page').forEach(el => el.checked = false);
    updateAutoVariantPreviewInfoPage();
});

btnCloseAutoVariantPanelPage.addEventListener('click', function () {
    autoVariantPanelPage.style.display = 'none';
    enableAutoVariantsPage.checked = false;
});

function updateAutoVariantPreviewInfoPage() {
    const selectedColorIds = Array.from(autoVariantPanelPage.querySelectorAll('.auto-variant-color-page:checked'))
        .map(el => el.value);
    const selectedSizeIds = Array.from(autoVariantPanelPage.querySelectorAll('.auto-variant-size-page:checked'))
        .map(el => el.value);

    const colorCount = selectedColorIds.length;
    const sizeCount = selectedSizeIds.length;
    const total = colorCount * sizeCount;

    const previewEl = document.getElementById('autoVariantPreviewInfoPage');
    if (!previewEl) return;

    if (colorCount > 0 && sizeCount > 0) {
        // Nếu sản phẩm đã có biến thể thì chỉ tính các cặp (màu+size) chưa tồn tại.
        let duplicateCount = 0;
        if (existingVariantPairs.size > 0) {
            selectedColorIds.forEach(colorId => {
                selectedSizeIds.forEach(sizeId => {
                    const key = `${String(colorId)}-${String(sizeId)}`;
                    if (existingVariantPairs.has(key)) {
                        duplicateCount++;
                    }
                });
            });
        }

        const newCount = total - duplicateCount;
        if (duplicateCount > 0) {
            previewEl.textContent = `Sẽ tạo ${newCount} biến thể mới (bỏ qua ${duplicateCount} cặp đã tồn tại).`;
        } else {
            previewEl.textContent = `Sẽ tạo ${newCount} biến thể mới (${colorCount} màu x ${sizeCount} size).`;
        }
    } else {
        previewEl.textContent = 'Chọn màu và size để xem trước số biến thể.';
    }
}

autoVariantPanelPage.addEventListener('change', function (e) {
    if (e.target && (e.target.classList.contains('auto-variant-color-page') || e.target.classList.contains('auto-variant-size-page'))) {
        updateAutoVariantPreviewInfoPage();
    }
});

updateAutoVariantPreviewInfoPage();

btnGenerateAutoVariantsPage.addEventListener('click', function () {
    const selectedColorIds = Array.from(autoVariantPanelPage.querySelectorAll('.auto-variant-color-page:checked'))
        .map(el => el.value);
    const selectedSizeIds = Array.from(autoVariantPanelPage.querySelectorAll('.auto-variant-size-page:checked'))
        .map(el => el.value);

    const giaChungStr = document.getElementById('autoVariantGiaChungPage').value;
    const giaChung = giaChungStr !== '' ? parseFloat(giaChungStr) : NaN;

    const soLuongChungStr = document.getElementById('autoVariantSoLuongChungPage').value;
    const soLuongChung = soLuongChungStr !== '' ? parseInt(soLuongChungStr, 10) : 0;

    if (!selectedColorIds.length) {
        notifyError('Vui lòng chọn ít nhất 1 màu.');
        return;
    }
    if (!selectedSizeIds.length) {
        notifyError('Vui lòng chọn ít nhất 1 size.');
        return;
    }
    if (Number.isNaN(giaChung) || giaChung < 0) {
        notifyError('Vui lòng nhập giá chung hợp lệ.');
        return;
    }
    if (Number.isNaN(soLuongChung) || soLuongChung < 0) {
        notifyError('Vui lòng nhập số lượng chung hợp lệ.');
        return;
    }

    // Xoá các dòng cũ rồi sinh mới theo tích (màu x size)
    variantsContainer.innerHTML = '';
    variantsContainer.setAttribute('data-next-index', '0');

    let index = 0;
    let skipped = 0;
    selectedColorIds.forEach(colorId => {
        selectedSizeIds.forEach(sizeId => {
            const key = `${String(colorId)}-${String(sizeId)}`;
            if (existingVariantPairs.has(key)) {
                skipped++;
                return;
            }

            const wrap = document.createElement('div');
            wrap.innerHTML = buildVariantRow(index);
            const rowEl = wrap.firstElementChild;

            rowEl.querySelector(`select[name="variants[${index}][mau_sac_id]"]`).value = colorId;
            rowEl.querySelector(`select[name="variants[${index}][kich_thuoc_id]"]`).value = sizeId;
            rowEl.querySelector(`input[name="variants[${index}][gia]"]`).value = giaChung;
            // Giá KM để trống, số lượng mặc định 0.
            rowEl.querySelector(`input[name="variants[${index}][gia_khuyen_mai]"]`).value = '';
            rowEl.querySelector(`input[name="variants[${index}][so_luong]"]`).value = soLuongChung;

            variantsContainer.appendChild(rowEl);
            index++;
        });
    });

    variantsContainer.setAttribute('data-next-index', String(index));
    autoVariantPanelPage.style.display = 'none';

    if (skipped > 0 && window.toastr && typeof toastr.warning === 'function') {
        toastr.warning(`Bỏ qua ${skipped} cặp đã tồn tại.`);
    }
});

function buildVariantRow(index) {
    return `
        <div class="variant-row" data-index="${index}">
            <div class="row">
                <div class="col-md-3">
                    <select name="variants[${index}][mau_sac_id]" class="form-control form-control-sm" required>
                        <option value="">-- Chọn màu --</option>
                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->ten_mau); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="variants[${index}][kich_thuoc_id]" class="form-control form-control-sm" required>
                        <option value="">-- Chọn size --</option>
                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->ten_kich_thuoc); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="variants[${index}][gia]" class="form-control form-control-sm" min="0" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="variants[${index}][gia_khuyen_mai]" class="form-control form-control-sm" min="0">
                </div>
                <div class="col-md-2">
                    <input type="number" name="variants[${index}][so_luong]" class="form-control form-control-sm" min="0" required>
                </div>
                <div class="col-md-1">
                    <select name="variants[${index}][trang_thai]" class="form-control form-control-sm">
                        <option value="1">Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
            </div>
            <div class="row variant-actions">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-variant">Xóa dòng</button>
                </div>
            </div>
        </div>
    `;
}

addVariantRowBtn.addEventListener('click', function () {
    const currentIndex = parseInt(variantsContainer.getAttribute('data-next-index'), 10) || 0;
    variantsContainer.insertAdjacentHTML('beforeend', buildVariantRow(currentIndex));
    variantsContainer.setAttribute('data-next-index', String(currentIndex + 1));
});

variantsContainer.addEventListener('click', function (event) {
    const btn = event.target.closest('.remove-variant');
    if (!btn) return;

    const rows = variantsContainer.querySelectorAll('.variant-row');
    if (rows.length <= 1) {
        return;
    }
    btn.closest('.variant-row').remove();
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/variants/create.blade.php ENDPATH**/ ?>