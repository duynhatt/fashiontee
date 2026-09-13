<?php $__env->startSection('AdminContent'); ?>
    <div class="container-fluid" style="margin-top: 30px;">

        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" data-toggle="modal" style="margin-bottom:20px;" data-target="#modalAdd">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </button>
        </div>
<style>
#modalAdd .modal-dialog{
    
    width: 1269px;
}
   .form-group{
    margin-bottom:1px;
    
}
        #variantsSection .variant-row select[name$="[trang_thai]"] {
            min-width: 60px;
        }

        .card {
            border-radius: 10px;
        }

        .form-control {
            border-radius: 6px;
        }

        .btn {
            border-radius: 6px;
        }

        .input-group-text {
            border-radius: 6px 0 0 6px;
        }
    </style>
        
        <div class="card shadow">
            <div class="card-body">
                
                <form method="GET" action="<?php echo e(route('admin.san-pham.index')); ?>" class="mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Tên sản phẩm</label>
                                    <input type="text" name="keyword" class="form-control"
                                        placeholder="Nhập tên sản phẩm..."
                                        value="<?php echo e(request('keyword')); ?>">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold">Danh mục</label>
                                    <select name="danh_muc_id" class="form-control">
                                        <option value="">Tất cả danh mục</option>
                                        <?php $__currentLoopData = $danhMucs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dm->id); ?>"
                                                <?php echo e(request('danh_muc_id') == $dm->id ? 'selected' : ''); ?>>
                                                <?php echo e($dm->display_name ?? $dm->ten_danh_muc); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold">Trạng thái</label>
                                    <select name="trang_thai" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="1" <?php echo e(request('trang_thai') === '1' ? 'selected' : ''); ?>>Hiển thị</option>
                                        <option value="0" <?php echo e(request('trang_thai') === '0' ? 'selected' : ''); ?>>Ẩn</option>
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex flex-column">
                                    <label class="font-weight-bold invisible">Action</label>
                                    <div class="d-flex flex-grow-1">
                                        <button class="btn btn-primary w-50 mr-2">
                                            <i class="fas fa-search"></i> Tìm
                                        </button>
                                        <a href="<?php echo e(route('admin.san-pham.index')); ?>" class="btn btn-outline-secondary w-50">
                                            <i class="fas fa-undo"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>

                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th width="18%">Danh mục</th>
                            
                            <th>Trạng thái</th>
                            <th width="15%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sanPhams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($key + 1); ?></td>
                                <td>
                                    <?php if($sp->hinh_anh_chinh): ?>
                                        <img src="<?php echo e(asset('storage/' . $sp->hinh_anh_chinh)); ?>"
                                            alt="<?php echo e($sp->ten_san_pham); ?>"
                                            style="max-width:60px; height:auto; border-radius:4px;">
                                    <?php else: ?>
                                        <span class="text-muted">Chưa có ảnh</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo e($sp->ten_san_pham); ?></td>
                                <td class="text-left" style="padding-left: 15px; vertical-align: middle;">
                                    <?php if($sp->danhMuc): ?>
                                        <?php
                                            $ancestors = $sp->danhMuc->getAncestors();
                                        ?>
                                        <?php if($ancestors->isNotEmpty()): ?>
                                            <div class="text-muted" style="font-size: 11px; margin-bottom: 2px;">
                                                <?php $__currentLoopData = $ancestors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span><?php echo e($anc->ten_danh_muc); ?></span> <i class="fas fa-angle-right text-muted mx-1" style="font-size: 9px;"></i>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <strong class="text-dark" style="font-size: 13px;">
                                                <i class="fas fa-tag text-info mr-1" style="font-size: 11px;"></i><?php echo e($sp->danhMuc->ten_danh_muc); ?>

                                            </strong>
                                        <?php else: ?>
                                            <strong class="text-dark" style="font-size: 13px;">
                                                <i class="fas fa-folder text-warning mr-1" style="font-size: 12px;"></i><?php echo e($sp->danhMuc->ten_danh_muc); ?>

                                            </strong>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($sp->trang_thai): ?>
                                        <span class="badge badge-success">Hiển thị</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('variants.create', ['san_pham_id' => $sp->id])); ?>"
                                        class="btn btn-sm btn-info" title="Thêm biến thể">
                                        <i class="fas fa-palette"></i>
                                    </a>
                                    <a href="<?php echo e(route('variants.index', ['san_pham_id' => $sp->id])); ?>"
                                        class="btn btn-sm btn-secondary" title="Xem biến thể">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <button class="btn btn-sm btn-warning btn-edit" data-id="<?php echo e($sp->id); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="<?php echo e($sp->id); ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">Chưa có sản phẩm nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    
    <div class="modal fade" id="modalAdd">
        <div class="modal-dialog modal-lg">
            <form id="formAdd" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm sản phẩm mới</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="ten_san_pham" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Danh mục <span class="text-danger">*</span></label>
                                    <select name="danh_muc_id" class="form-control" required>
                                        <option value="">--- Chọn danh mục ---</option>
                                        <?php $__currentLoopData = $danhMucs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dm->id); ?>"><?php echo e($dm->display_name ?? $dm->ten_danh_muc); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả ngắn</label>
                                    <textarea name="mo_ta_ngan" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả chi tiết</label>
                                    <textarea name="mo_ta_chi_tiet" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chất liệu vải</label>
                                            <input type="text" name="chat_lieu" class="form-control" placeholder="VD: 100% Cotton Compact 2 chiều">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kiểu dáng</label>
                                            <input type="text" name="kieu_dang" class="form-control" placeholder="VD: Regular Fit / Oversize">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Điểm nổi bật (Mỗi dòng 1 ý)</label>
                                    <textarea name="diem_noi_bat" class="form-control" rows="3" placeholder="Chất liệu sợi dệt tự nhiên thoáng mát&#10;Đường kim mũi chỉ may chần 2 kim&#10;Màu nhuộm an toàn bền màu"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Hướng dẫn bảo quản</label>
                                    <textarea name="huong_dan_bao_quan" class="form-control" rows="2" placeholder="Giặt ở nhiệt độ thường, lộn trái áo khi giặt, không ủi trực tiếp lên hình in..."></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>Hình ảnh chính</label>
                                    <input type="file" name="hinh_anh_chinh" class="form-control-file" accept="image/*">
                                    <small class="form-text text-muted">jpg, png, gif - tối đa 2MB</small>
                                </div>

                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="trang_thai" class="form-control">
                                        <option value="1" selected>Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="mb-0">Biến thể ban đầu</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check mb-0">
                                        <input type="checkbox" id="enableInitialVariants" class="form-check-input">
                                        <label class="form-check-label" for="enableInitialVariants">Có biến thể ban đầu</label>
                                    </div>
                                    <div class="form-check mb-0 ml-3">
                                        <input type="checkbox" id="enableAutoVariants" class="form-check-input">
                                        <label class="form-check-label" for="enableAutoVariants">Biến thể tự động</label>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div id="variantsSection" class="form-group" style="display:none;">
                            <div id="autoVariantPanel" class="border p-3 mb-3" style="display:none;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="font-weight-bold">Tự tạo biến thể từ màu & size</div>
                                    <button type="button" id="btnCloseAutoVariantPanel" class="btn btn-sm btn-outline-secondary">Đóng</button>
                                </div>
                                <div id="autoVariantPreviewInfo" class="text-muted small mb-3">
                                    Chọn màu và size để xem trước số biến thể.
                                </div>
                                <div class="row small">
                                    <div class="col-md-6">
                                        <div class="font-weight-bold mb-1">Màu sắc</div>
                                        <div class="border p-2" style="max-height:140px; overflow:auto;">
                                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="form-check">
                                                    <input class="form-check-input auto-variant-color" type="checkbox" value="<?php echo e($c->id); ?>" id="autoColor_<?php echo e($c->id); ?>">
                                                    <label class="form-check-label" for="autoColor_<?php echo e($c->id); ?>"><?php echo e($c->ten_mau); ?></label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="font-weight-bold mb-1">Kích thước</div>
                                        <div class="border p-2" style="max-height:140px; overflow:auto;">
                                            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="form-check">
                                                    <input class="form-check-input auto-variant-size" type="checkbox" value="<?php echo e($s->id); ?>" id="autoSize_<?php echo e($s->id); ?>">
                                                    <label class="form-check-label" for="autoSize_<?php echo e($s->id); ?>"><?php echo e($s->ten_kich_thuoc); ?></label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="font-weight-bold mb-1">Giá</div>
                                        <input type="number" id="autoVariantGiaChung" class="form-control form-control-sm" min="0" placeholder="Ví dụ: 10000">
                                        <div class="text-muted small mt-2"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="font-weight-bold mb-1">Số lượng</div>
                                        <input type="number" id="autoVariantSoLuongChung" class="form-control form-control-sm" min="0" placeholder="Ví dụ: 10">
                                        <div class="text-muted small mt-2"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" id="btnGenerateAutoVariants" class="btn btn-primary btn-sm">Tạo biến thể</button>
                                </div>
                            </div>

                            <div class="row small text-muted mb-2">
                                <div class="col-md-3">Màu</div>
                                <div class="col-md-2">Size</div>
                                <div class="col-md-2">Giá</div>
                                <div class="col-md-2">Giá KM</div>
                                <div class="col-md-2">Số lượng</div>
                                <div class="col-md-1">Trạng thái</div>
                            </div>
                            <div id="productVariantsContainer" data-next-index="1">
                                <div class="variant-row" data-index="0">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="variants[0][mau_sac_id]" class="form-control form-control-sm"
                                                disabled>
                                                <option value="">-- Chọn màu --</option>
                                                <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->ten_mau); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="variants[0][kich_thuoc_id]" class="form-control form-control-sm"
                                                disabled>
                                                <option value="">-- Chọn size --</option>
                                                <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->ten_kich_thuoc); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="variants[0][gia]"
                                                class="form-control form-control-sm" min="0" disabled>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="variants[0][gia_khuyen_mai]"
                                                class="form-control form-control-sm" min="0" disabled>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="variants[0][so_luong]"
                                                class="form-control form-control-sm" min="0" disabled>
                                        </div>
                                        <div class="col-md-1">
                                            <select name="variants[0][trang_thai]" class="form-control form-control-sm"
                                                disabled>
                                                <option value="1">Hiện</option>
                                                <option value="0">Ẩn</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12 text-right">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger remove-variant">Xóa dòng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addVariantRow" class="btn btn-outline-primary btn-sm mt-2">Thêm
                                dòng biến thể</button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog modal-lg">
            <form id="formEdit" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh sửa sản phẩm</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_ten_san_pham" name="ten_san_pham"
                                        class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Danh mục <span class="text-danger">*</span></label>
                                    <select id="edit_danh_muc_id" name="danh_muc_id" class="form-control" required>
                                        <option value="">--- Chọn danh mục ---</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả ngắn</label>
                                    <textarea id="edit_mo_ta_ngan" name="mo_ta_ngan" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả chi tiết</label>
                                    <textarea id="edit_mo_ta_chi_tiet" name="mo_ta_chi_tiet" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chất liệu vải</label>
                                            <input type="text" id="edit_chat_lieu" name="chat_lieu" class="form-control" placeholder="VD: 100% Cotton Compact 2 chiều">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kiểu dáng</label>
                                            <input type="text" id="edit_kieu_dang" name="kieu_dang" class="form-control" placeholder="VD: Regular Fit / Oversize">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Điểm nổi bật (Mỗi dòng 1 ý)</label>
                                    <textarea id="edit_diem_noi_bat" name="diem_noi_bat" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Hướng dẫn bảo quản</label>
                                    <textarea id="edit_huong_dan_bao_quan" name="huong_dan_bao_quan" class="form-control" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>Hình ảnh hiện tại</label>
                                    <div id="current_image" class="mb-2"></div>
                                    <label>Thay hình ảnh mới (nếu muốn)</label>
                                    <input type="file" name="hinh_anh_chinh" class="form-control-file"
                                        accept="image/*">
                                </div>

                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select id="edit_trang_thai" name="trang_thai" class="form-control">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function() {
            function setVariantsEnabled(isEnabled) {
                $('#variantsSection').toggle(isEnabled);
                $('#variantsSection').find('select, input').prop('disabled', !isEnabled);
                $('#variantsSection').find(
                        'select[name$="[mau_sac_id]"], select[name$="[kich_thuoc_id]"], input[name$="[gia]"], input[name$="[so_luong]"]'
                        )
                    .prop('required', isEnabled);
            }

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
                    <div class="row mt-2">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-variant">Xóa dòng</button>
                        </div>
                    </div>
                </div>
            `;
            }

            $('#enableInitialVariants').on('change', function() {
                const enabled = $(this).is(':checked');
                setVariantsEnabled(enabled);
                if (!enabled) {
                    $('#autoVariantPanel').hide();
                    $('#enableAutoVariants').prop('checked', false);
                    $('#autoVariantGiaChung').val('');
                    $('#autoVariantSoLuongChung').val('');
                    $('#autoVariantPanel .auto-variant-color').prop('checked', false);
                    $('#autoVariantPanel .auto-variant-size').prop('checked', false);
                    $('#autoVariantPreviewInfo').text('Chọn màu và size để xem trước số biến thể.');
                }
            });

            $('#enableAutoVariants').on('change', function() {
                if ($(this).is(':checked')) {
                    // Khi bật "Biến thể tự động" thì tự bật phần biến thể ban đầu.
                    $('#enableInitialVariants').prop('checked', true);
                    setVariantsEnabled(true);
                    $('#autoVariantPanel').show();
                    updateAutoVariantPreviewInfo();
                } else {
                    $('#autoVariantPanel').hide();
                    $('#autoVariantGiaChung').val('');
                    $('#autoVariantSoLuongChung').val('');
                    $('#autoVariantPanel .auto-variant-color').prop('checked', false);
                    $('#autoVariantPanel .auto-variant-size').prop('checked', false);
                    $('#autoVariantPreviewInfo').text('Chọn màu và size để xem trước số biến thể.');
                }
            });

            $('#btnCloseAutoVariantPanel').on('click', function() {
                $('#autoVariantPanel').hide();
                $('#enableAutoVariants').prop('checked', false);
            });

            function updateAutoVariantPreviewInfo() {
                const colorCount = $('#autoVariantPanel .auto-variant-color:checked').length;
                const sizeCount = $('#autoVariantPanel .auto-variant-size:checked').length;
                const total = colorCount * sizeCount;

                if (colorCount > 0 && sizeCount > 0) {
                    $('#autoVariantPreviewInfo').text(`Sẽ tạo ${total} biến thể (${colorCount} màu x ${sizeCount} size).`);
                } else {
                    $('#autoVariantPreviewInfo').text('Chọn màu và size để xem trước số biến thể.');
                }
            }

            $('#autoVariantPanel').on('change', '.auto-variant-color, .auto-variant-size', function() {
                updateAutoVariantPreviewInfo();
            });

            updateAutoVariantPreviewInfo();

            $('#btnGenerateAutoVariants').on('click', function() {
                const container = $('#productVariantsContainer');
                const selectedColorIds = $('#autoVariantPanel .auto-variant-color:checked').map(function() {
                    return $(this).val();
                }).get();
                const selectedSizeIds = $('#autoVariantPanel .auto-variant-size:checked').map(function() {
                    return $(this).val();
                }).get();

                const giaChungStr = $('#autoVariantGiaChung').val();
                const giaChung = giaChungStr !== '' ? parseFloat(giaChungStr) : NaN;

                const soLuongChungStr = $('#autoVariantSoLuongChung').val();
                const soLuongChung = soLuongChungStr !== '' ? parseInt(soLuongChungStr, 10) : 0;

                if (!selectedColorIds.length) {
                    toastr.error('Vui lòng chọn ít nhất 1 màu.');
                    return;
                }
                if (!selectedSizeIds.length) {
                    toastr.error('Vui lòng chọn ít nhất 1 size.');
                    return;
                }
                if (Number.isNaN(giaChung) || giaChung < 0) {
                    toastr.error('Vui lòng nhập giá chung hợp lệ.');
                    return;
                }
                if (Number.isNaN(soLuongChung) || soLuongChung < 0) {
                    toastr.error('Vui lòng nhập số lượng chung hợp lệ.');
                    return;
                }

                // Xoá các dòng cũ rồi sinh mới theo tích (màu x size)
                container.html('');
                container.attr('data-next-index', 0);

                let index = 0;
                selectedColorIds.forEach(colorId => {
                    selectedSizeIds.forEach(sizeId => {
                        const $row = $(buildVariantRow(index));
                        $row.find(`select[name="variants[${index}][mau_sac_id]"]`).val(colorId);
                        $row.find(`select[name="variants[${index}][kich_thuoc_id]"]`).val(sizeId);
                        $row.find(`input[name="variants[${index}][gia]"]`).val(giaChung);
                        // Giá KM để trống, số lượng gán mặc định 0.
                        $row.find(`input[name="variants[${index}][gia_khuyen_mai]"]`).val('');
                        $row.find(`input[name="variants[${index}][so_luong]"]`).val(soLuongChung);
                        container.append($row);
                        index++;
                    });
                });

                container.attr('data-next-index', index);
                setVariantsEnabled(true);
                $('#autoVariantPanel').hide();
            });

            $('#addVariantRow').on('click', function() {
                const container = $('#productVariantsContainer');
                const currentIndex = parseInt(container.attr('data-next-index'), 10) || 0;
                container.append(buildVariantRow(currentIndex));
                container.attr('data-next-index', currentIndex + 1);
            });

            $('#productVariantsContainer').on('click', '.remove-variant', function() {
                const rows = $('#productVariantsContainer .variant-row');
                if (rows.length <= 1) {
                    return;
                }
                $(this).closest('.variant-row').remove();
            });

            $('#modalAdd').on('hidden.bs.modal', function() {
                const container = $('#productVariantsContainer');
                container.html(buildVariantRow(0));
                container.attr('data-next-index', 1);
                $('#enableInitialVariants').prop('checked', false);
                $('#enableAutoVariants').prop('checked', false);
                setVariantsEnabled(false);
                $('#autoVariantPanel').hide();
                $('#autoVariantGiaChung').val('');
                $('#autoVariantSoLuongChung').val('');
                $('#autoVariantPanel .auto-variant-color').prop('checked', false);
                $('#autoVariantPanel .auto-variant-size').prop('checked', false);
                $('#autoVariantPreviewInfo').text('Chọn màu và size để xem trước số biến thể.');
            });

            setVariantsEnabled(false);

            $('#formAdd').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "<?php echo e(route('admin.san-pham.store')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.message || 'Thêm sản phẩm thành công!');
                            $('#modalAdd').modal('hide');
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            toastr.error(res.message || 'Có lỗi xảy ra');
                        }
                    },
                    error: function() {
                        toastr.error('Lỗi kết nối server');
                    }
                });
            });

            $('.btn-edit').click(function() {
                let id = $(this).data('id');

                $.get("<?php echo e(url('admin/san-pham')); ?>/" + id + "/edit", function(res) {
                    if (res.status) {
                        let sp = res.data;

                        $('#edit_id').val(sp.id);
                        $('#edit_ten_san_pham').val(sp.ten_san_pham);
                        $('#edit_mo_ta_ngan').val(sp.mo_ta_ngan);
                        $('#edit_mo_ta_chi_tiet').val(sp.mo_ta_chi_tiet);
                        $('#edit_chat_lieu').val(sp.chat_lieu || '');
                        $('#edit_kieu_dang').val(sp.kieu_dang || '');
                        $('#edit_diem_noi_bat').val(sp.diem_noi_bat || '');
                        $('#edit_huong_dan_bao_quan').val(sp.huong_dan_bao_quan || '');
                        $('#edit_trang_thai').val(sp.trang_thai ? 1 : 0);
                        $('#edit_cho_phep_thiet_ke').prop('checked', sp.cho_phep_thiet_ke);

                        let select = $('#edit_danh_muc_id');
                        select.empty();
                        select.append('<option value="">--- Chọn danh mục ---</option>');
                        res.danh_mucs.forEach(dm => {
                            let option =
                                `<option value="${dm.id}" ${dm.id == sp.danh_muc_id ? 'selected' : ''}>${dm.display_name || dm.ten_danh_muc}</option>`;
                            select.append(option);
                        });

                        let imgHtml = sp.hinh_anh_chinh ?
                            `<img src="<?php echo e(asset('storage')); ?>/${sp.hinh_anh_chinh}" style="max-width:140px; border-radius:6px;">` :
                            '<span class="text-muted">Chưa có ảnh</span>';
                        $('#current_image').html(imgHtml);

                        $('#modalEdit').modal('show');
                    } else {
                        toastr.error('Không tìm thấy sản phẩm');
                    }
                }).fail(() => toastr.error('Lỗi tải thông tin sản phẩm'));
            });

            $('#formEdit').submit(function(e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: "<?php echo e(url('admin/san-pham')); ?>/" + id,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.message || 'Cập nhật thành công!');
                            $('#modalEdit').modal('hide');
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            toastr.error(res.message || 'Có lỗi khi cập nhật');
                        }
                    },
                    error: function() {
                        toastr.error('Lỗi kết nối server');
                    }
                });
            });

            $('.btn-delete').click(function() {
                if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;

                let id = $(this).data('id');

                $.ajax({
                    url: "<?php echo e(url('admin/san-pham')); ?>/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.message || 'Xóa sản phẩm thành công!');
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            toastr.error(res.message || 'Không thể xóa sản phẩm');
                        }
                    },
                    error: function() {
                        toastr.error('Lỗi khi xóa');
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/Product/list.blade.php ENDPATH**/ ?>