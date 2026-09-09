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
                                                <?php echo e($dm->ten_danh_muc); ?>

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
                            <th>Danh mục</th>
                            
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
                                <td><?php echo e($sp->danhMuc->ten_danh_muc ?? '—'); ?></td>
                                <td>
                                    <?php if($sp->trang_thai): ?>
                                        <span class="badge badge-success">Hiển thị</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary btn-manage-images" data-id="<?php echo e($sp->id); ?>" title="Quản lý Album ảnh theo màu">
                                        <i class="fas fa-images"></i>
                                    </button>
                                    <button class="btn btn-sm btn-dark btn-manage-size-guide" data-id="<?php echo e($sp->id); ?>" title="Bảng kích cỡ (Size Guide)">
                                        <i class="fas fa-ruler-combined"></i>
                                    </button>
                                    <a href="<?php echo e(route('variants.create', ['san_pham_id' => $sp->id])); ?>"
                                        class="btn btn-sm btn-info" title="Thêm biến thể">
                                        <i class="fas fa-palette"></i>
                                    </a>
                                    <a href="<?php echo e(route('variants.index', ['san_pham_id' => $sp->id])); ?>"
                                        class="btn btn-sm btn-secondary" title="Xem biến thể">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <button class="btn btn-sm btn-warning btn-edit" data-id="<?php echo e($sp->id); ?>" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="<?php echo e($sp->id); ?>" title="Xóa">
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
                                            <option value="<?php echo e($dm->id); ?>"><?php echo e($dm->ten_danh_muc); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả ngắn</label>
                                    <textarea name="mo_ta_ngan" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả chi tiết</label>
                                    <textarea name="mo_ta_chi_tiet" class="form-control" rows="4"></textarea>
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
                                    <textarea id="edit_mo_ta_chi_tiet" name="mo_ta_chi_tiet" class="form-control" rows="4"></textarea>
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

    
    <div class="modal fade" id="modalManageImages" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-images mr-2"></i>Quản lý Album ảnh theo màu: <span id="galleryModalProductName" class="text-warning"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body p-4">
                    
                    <div class="card shadow-sm mb-4 border-0 bg-light">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-dark mb-3">
                                <i class="fas fa-cloud-upload-alt text-primary mr-1"></i> Tải ảnh mới lên Album
                            </h6>
                            <form id="formUploadGallery" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" id="gallery_product_id" name="san_pham_id">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="font-weight-bold small">Thuộc màu sắc:</label>
                                        <select id="galleryColorSelect" name="mau_sac_id" class="form-control">
                                            <option value="">Ảnh chung (Không theo màu)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="font-weight-bold small">Chọn hình ảnh (chọn một hoặc nhiều ảnh):</label>
                                        <input type="file" id="galleryFileInput" name="images[]" class="form-control-file" multiple accept="image/*" required>
                                        <small class="text-muted">Hỗ trợ JPG, PNG, WEBP. Tối đa 5MB mỗi ảnh.</small>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" id="btnUploadGallery" class="btn btn-success btn-block">
                                            <i class="fas fa-upload mr-1"></i> Tải ảnh lên
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <label class="font-weight-bold small mr-2 mb-0">Lọc xem ảnh:</label>
                            <select id="filterGalleryColor" class="form-control form-control-sm" style="width: 250px;">
                                <option value="all">Tất cả ảnh trong Album</option>
                            </select>
                        </div>
                        <span id="galleryCountInfo" class="badge badge-info p-2 font-weight-normal">0 ảnh</span>
                    </div>

                    
                    <div id="galleryContainer" class="row">
                        <div class="col-12 text-center py-4 text-muted">Đang tải danh sách ảnh...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalManageSizeGuide" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 1050px;">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-ruler-combined mr-2"></i>Bảng kích cỡ (Size Guide): <span id="sizeGuideModalProductName" class="text-warning"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        <i class="fas fa-info-circle mr-1"></i> Nhập thông số cụ thể cho từng kích thước của sản phẩm này. Khách hàng sẽ xem được các thông số này trong mục "Hướng dẫn chọn size" ở trang chi tiết sản phẩm.
                    </p>
                    <form id="formSizeGuide">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="size_guide_product_id" name="san_pham_id">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle mb-0" id="tableSizeGuide">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 8%;">Size</th>
                                        <th style="width: 12%;">Chiều cao min</th>
                                        <th style="width: 12%;">Chiều cao max</th>
                                        <th style="width: 11%;">Cân nặng min (kg)</th>
                                        <th style="width: 11%;">Cân nặng max (kg)</th>
                                        <th style="width: 10%;">Dài áo (cm)</th>
                                        <th style="width: 10%;">Rộng ngực (cm)</th>
                                        <th style="width: 10%;">Rộng vai (cm)</th>
                                        <th style="width: 16%;">Ghi chú form</th>
                                    </tr>
                                </thead>
                                <tbody id="sizeGuideTableBody">
                                    <tr>
                                        <td colspan="9" class="text-center py-3 text-muted">Đang tải dữ liệu...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary px-4" id="btnSaveSizeGuide">
                                <i class="fas fa-save mr-1"></i> Lưu thông số Size Guide
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
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
                        $('#edit_trang_thai').val(sp.trang_thai ? 1 : 0);
                        $('#edit_cho_phep_thiet_ke').prop('checked', sp.cho_phep_thiet_ke);

                        let select = $('#edit_danh_muc_id');
                        select.empty();
                        select.append('<option value="">--- Chọn danh mục ---</option>');
                        res.danh_mucs.forEach(dm => {
                            let option =
                                `<option value="${dm.id}" ${dm.id == sp.danh_muc_id ? 'selected' : ''}>${dm.ten_danh_muc}</option>`;
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
            // ================== QUẢN LÝ ALBUM ẢNH THEO MÀU ==================
            let currentGalleryImages = [];
            let currentGalleryColors = [];
            let currentGalleryProductId = null;

            $('.btn-manage-images').click(function() {
                const productId = $(this).data('id');
                currentGalleryProductId = productId;
                $('#gallery_product_id').val(productId);

                loadGalleryData(productId);
                $('#modalManageImages').modal('show');
            });

            function loadGalleryData(productId) {
                $('#galleryContainer').html('<div class="col-12 text-center py-4 text-muted"><i class="fas fa-spinner fa-spin mr-2"></i>Đang tải danh sách ảnh...</div>');

                $.get("<?php echo e(url('admin/san-pham')); ?>/" + productId + "/images", function(res) {
                    if (res.success) {
                        $('#galleryModalProductName').text(res.product.ten_san_pham);
                        currentGalleryImages = res.images || [];
                        currentGalleryColors = res.colors || [];

                        // Cập nhật dropdown chọn màu khi upload
                        let uploadColorHtml = '<option value="">Ảnh chung (Không theo màu)</option>';
                        let filterColorHtml = '<option value="all">Tất cả ảnh trong Album</option><option value="general">Ảnh chung (Không theo màu)</option>';

                        currentGalleryColors.forEach(function(c) {
                            uploadColorHtml += `<option value="${c.id}">${c.ten_mau}</option>`;
                            filterColorHtml += `<option value="${c.id}">Màu: ${c.ten_mau}</option>`;
                        });

                        $('#galleryColorSelect').html(uploadColorHtml);
                        $('#filterGalleryColor').html(filterColorHtml);

                        renderGalleryItems();
                    } else {
                        toastr.error('Không thể tải album ảnh.');
                    }
                }).fail(function() {
                    toastr.error('Lỗi kết nối khi tải album ảnh.');
                });
            }

            function renderGalleryItems() {
                const filterVal = $('#filterGalleryColor').val();
                let filtered = currentGalleryImages;

                if (filterVal === 'general') {
                    filtered = currentGalleryImages.filter(img => !img.mau_sac_id);
                } else if (filterVal !== 'all' && filterVal) {
                    filtered = currentGalleryImages.filter(img => String(img.mau_sac_id) === String(filterVal));
                }

                $('#galleryCountInfo').text(filtered.length + ' ảnh');

                if (filtered.length === 0) {
                    $('#galleryContainer').html(`
                        <div class="col-12 text-center py-5 text-muted">
                            <i class="fas fa-image fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <p class="mb-0">Chưa có ảnh nào ${filterVal !== 'all' ? 'cho màu này' : 'trong Album'}. Hãy tải ảnh lên ở khung phía trên!</p>
                        </div>
                    `);
                    return;
                }

                let html = '';
                filtered.forEach(function(img, idx) {
                    const colorBadge = img.mau_sac_id
                        ? `<span class="badge badge-light border d-inline-flex align-items-center" style="font-size: 11px;">
                             <span style="width: 10px; height: 10px; border-radius: 50%; background-color: ${img.ma_mau}; display: inline-block; margin-right: 4px; border: 1px solid #ccc;"></span>
                             ${img.ten_mau}
                           </span>`
                        : `<span class="badge badge-secondary" style="font-size: 11px;">Ảnh chung</span>`;

                    html += `
                        <div class="col-6 col-md-4 col-lg-3 mb-4 gallery-card-item" data-id="${img.id}">
                            <div class="card h-100 shadow-sm border rounded overflow-hidden">
                                <div class="position-relative bg-light text-center p-2" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                                    <img src="${img.url}" class="img-fluid" style="max-height: 160px; object-fit: contain;">
                                    <span class="position-absolute badge badge-dark" style="top: 8px; left: 8px; font-size: 11px; opacity: 0.85;">
                                        #${img.thu_tu || (idx + 1)}
                                    </span>
                                </div>
                                <div class="card-body p-2 d-flex flex-column justify-content-between">
                                    <div class="mb-2 text-center">
                                        ${colorBadge}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary btn-move-image" data-id="${img.id}" data-dir="up" title="Chuyển lên trước" ${idx === 0 ? 'disabled' : ''}>
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-move-image" data-id="${img.id}" data-dir="down" title="Chuyển ra sau" ${idx === filtered.length - 1 ? 'disabled' : ''}>
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-image" data-id="${img.id}" title="Xóa ảnh này">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#galleryContainer').html(html);
            }

            $('#filterGalleryColor').change(function() {
                renderGalleryItems();
            });

            // Tải ảnh lên
            $('#formUploadGallery').submit(function(e) {
                e.preventDefault();
                if (!currentGalleryProductId) return;

                const fileInput = document.getElementById('galleryFileInput');
                if (!fileInput.files || fileInput.files.length === 0) {
                    toastr.warning('Vui lòng chọn ít nhất một file ảnh.');
                    return;
                }

                let formData = new FormData(this);
                const btn = $('#btnUploadGallery');
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang tải lên...');

                $.ajax({
                    url: "<?php echo e(url('admin/san-pham')); ?>/" + currentGalleryProductId + "/images",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            toastr.success(res.message || 'Tải ảnh lên thành công!');
                            $('#galleryFileInput').val('');
                            loadGalleryData(currentGalleryProductId);
                        } else {
                            toastr.error(res.message || 'Có lỗi xảy ra khi tải ảnh.');
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Lỗi kết nối khi tải ảnh lên.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg);
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Tải ảnh lên');
                    }
                });
            });

            // Xóa ảnh
            $(document).on('click', '.btn-delete-image', function() {
                const imageId = $(this).data('id');
                if (!confirm('Bạn có chắc muốn xóa hình ảnh này khỏi Album?')) return;

                $.ajax({
                    url: "<?php echo e(url('admin/san-pham/images')); ?>/" + imageId,
                    type: "DELETE",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(res) {
                        if (res.success) {
                            toastr.success('Đã xóa ảnh.');
                            loadGalleryData(currentGalleryProductId);
                        } else {
                            toastr.error('Không thể xóa ảnh.');
                        }
                    },
                    error: function() {
                        toastr.error('Lỗi khi xóa ảnh.');
                    }
                });
            });

            // Đổi thứ tự ảnh (Move up / down)
            $(document).on('click', '.btn-move-image', function() {
                const imageId = $(this).data('id');
                const dir = $(this).data('dir');

                const idx = currentGalleryImages.findIndex(img => String(img.id) === String(imageId));
                if (idx === -1) return;

                const targetIdx = dir === 'up' ? idx - 1 : idx + 1;
                if (targetIdx < 0 || targetIdx >= currentGalleryImages.length) return;

                // Hoán đổi
                const temp = currentGalleryImages[idx];
                currentGalleryImages[idx] = currentGalleryImages[targetIdx];
                currentGalleryImages[targetIdx] = temp;

                renderGalleryItems();

                // Lưu thứ tự mới lên server
                const orderIds = currentGalleryImages.map(img => img.id);
                $.post("<?php echo e(url('admin/san-pham')); ?>/" + currentGalleryProductId + "/images/reorder", {
                    _token: "<?php echo e(csrf_token()); ?>",
                    order: orderIds
                }, function(res) {
                    if (!res.success) {
                        toastr.error('Không thể lưu thứ tự ảnh.');
                    }
                });
            });

            // ================== QUẢN LÝ BẢNG KÍCH THƯỚC (SIZE GUIDE) ==================
            let currentSizeGuideProductId = null;

            $('.btn-manage-size-guide').click(function() {
                const productId = $(this).data('id');
                currentSizeGuideProductId = productId;
                $('#size_guide_product_id').val(productId);

                $('#sizeGuideTableBody').html('<tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-spinner fa-spin mr-2"></i>Đang tải thông số kích cỡ...</td></tr>');
                $('#modalManageSizeGuide').modal('show');

                $.get("<?php echo e(url('admin/san-pham')); ?>/" + productId + "/size-guide", function(res) {
                    if (res.success) {
                        $('#sizeGuideModalProductName').text(res.product_name);
                        renderSizeGuideRows(res.sizes, res.guides);
                    } else {
                        toastr.error('Không thể tải dữ liệu kích thước.');
                    }
                }).fail(function() {
                    toastr.error('Lỗi kết nối khi tải kích thước.');
                });
            });

            function renderSizeGuideRows(sizes, guides) {
                if (!sizes || sizes.length === 0) {
                    $('#sizeGuideTableBody').html('<tr><td colspan="9" class="text-center py-4 text-muted">Sản phẩm này chưa có kích thước nào. Hãy thêm biến thể size trước!</td></tr>');
                    return;
                }

                let rowsHtml = '';
                sizes.forEach(function(size, index) {
                    const g = (guides && guides[size.id]) ? guides[size.id] : {};

                    rowsHtml += `
                        <tr>
                            <td class="font-weight-bold align-middle bg-light">
                                <span class="badge badge-secondary px-2 py-1" style="font-size: 14px;">${size.ten_kich_thuoc}</span>
                                <input type="hidden" name="guides[${index}][kich_thuoc_id]" value="${size.id}">
                            </td>
                            <td>
                                <input type="text" name="guides[${index}][chieu_cao_min]" class="form-control form-control-sm text-center" 
                                    placeholder="1m50" value="${g.chieu_cao_min || ''}">
                            </td>
                            <td>
                                <input type="text" name="guides[${index}][chieu_cao_max]" class="form-control form-control-sm text-center" 
                                    placeholder="1m60" value="${g.chieu_cao_max || ''}">
                            </td>
                            <td>
                                <input type="number" name="guides[${index}][can_nang_min]" class="form-control form-control-sm text-center" 
                                    placeholder="45" min="0" max="300" value="${g.can_nang_min || ''}">
                            </td>
                            <td>
                                <input type="number" name="guides[${index}][can_nang_max]" class="form-control form-control-sm text-center" 
                                    placeholder="53" min="0" max="300" value="${g.can_nang_max || ''}">
                            </td>
                            <td>
                                <input type="text" name="guides[${index}][dai_ao]" class="form-control form-control-sm text-center" 
                                    placeholder="66" value="${g.dai_ao || ''}">
                            </td>
                            <td>
                                <input type="text" name="guides[${index}][rong_nguc]" class="form-control form-control-sm text-center" 
                                    placeholder="48" value="${g.rong_nguc || ''}">
                            </td>
                            <td>
                                <input type="text" name="guides[${index}][rong_vai]" class="form-control form-control-sm text-center" 
                                    placeholder="42" value="${g.rong_vai || ''}">
                            </td>
                            <td>
                                <input type="text" name="guides[${index}][ghi_chu]" class="form-control form-control-sm text-center" 
                                    placeholder="Vừa vặn (Regular)" value="${g.ghi_chu || ''}">
                            </td>
                        </tr>
                    `;
                });

                $('#sizeGuideTableBody').html(rowsHtml);
            }

            $('#formSizeGuide').submit(function(e) {
                e.preventDefault();
                if (!currentSizeGuideProductId) return;

                const btn = $('#btnSaveSizeGuide');
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');

                $.ajax({
                    url: "<?php echo e(url('admin/san-pham')); ?>/" + currentSizeGuideProductId + "/size-guide",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.success) {
                            toastr.success(res.message || 'Lưu bảng kích cỡ thành công!');
                            $('#modalManageSizeGuide').modal('hide');
                        } else {
                            toastr.error(res.message || 'Có lỗi khi lưu bảng kích cỡ.');
                        }
                    },
                    error: function() {
                        toastr.error('Lỗi khi lưu bảng kích cỡ.');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu thông số Size Guide');
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/product/list.blade.php ENDPATH**/ ?>