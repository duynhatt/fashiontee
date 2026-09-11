<?php $__env->startSection('AdminContent'); ?>
<style>
    /* Tổng quan bảng cây */
    .table-category-tree {
        margin-bottom: 0;
        background-color: #fff;
    }
    .table-category-tree thead th {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        border-bottom: 2px solid #cbd5e1 !important;
        vertical-align: middle !important;
        padding: 12px 8px !important;
    }
    .table-category-tree td {
        vertical-align: middle !important;
        border-top: 1px solid #e2e8f0 !important;
        padding: 10px 8px !important;
    }

    /* Dòng danh mục cha */
    .root-category-row {
        background-color: #ffffff;
        transition: background-color 0.15s ease;
    }
    .root-category-row:hover {
        background-color: #f8fafc;
    }
    .root-category-row td {
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }

    /* Dòng danh mục con */
    .child-category-row {
        background-color: #f8fafc;
        transition: background-color 0.15s ease;
    }
    .child-category-row:hover {
        background-color: #f1f5f9;
    }
    .child-category-row.hidden-row {
        display: none !important;
    }
    .child-category-row td {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
        border-top: 1px dashed #e2e8f0 !important;
    }

    /* Nút toggle mở rộng cây */
    .btn-tree-toggle {
        width: 26px;
        height: 26px;
        padding: 0;
        line-height: 24px;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        cursor: pointer;
        display: inline-block;
        text-align: center;
        transition: all 0.2s ease;
        margin-right: 6px;
    }
    .btn-tree-toggle:hover {
        background: #e2e8f0;
        color: #0f172a;
        border-color: #94a3b8;
    }
    .btn-tree-toggle .tree-icon {
        font-size: 11px;
        transition: transform 0.2s ease;
    }
    .btn-tree-toggle.is-open {
        background-color: #e0f2fe;
        border-color: #7dd3fc;
        color: #0284c7;
    }
    .btn-tree-toggle.is-open .tree-icon {
        transform: rotate(90deg);
    }

    /* Huy hiệu đếm mục con */
    .subcat-count-badge {
        cursor: pointer;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 12px;
        background-color: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
        border: 1px solid #bae6fd;
        display: inline-block;
        margin-left: 6px;
        transition: all 0.15s ease;
    }
    .subcat-count-badge:hover {
        background-color: #bae6fd;
        color: #0284c7;
    }

    /* Badge trạng thái */
    .status-badge-active {
        background-color: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    .status-badge-hidden {
        background-color: #f1f5f9;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    /* Ảnh thumbnail */
    .category-thumbnail {
        width: 52px;
        height: 36px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
    }
    .category-thumbnail-child {
        width: 44px;
        height: 30px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    /* Ký hiệu nhánh cây */
    .tree-branch-symbol {
        color: #94a3b8;
        font-family: Consolas, "Courier New", monospace;
        font-size: 14px;
        font-weight: bold;
        margin-right: 6px;
        user-select: none;
    }

    /* Nhóm nút hành động */
    .btn-action-sm {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        margin: 0 2px;
        display: inline-block;
    }
    .btn-action-xs {
        padding: 2px 6px;
        font-size: 11px;
        border-radius: 4px;
        margin: 0 1px;
        display: inline-block;
    }
</style>

<div class="container-fluid" style="margin-top: 25px;">

    
    <form method="GET" action="<?php echo e(route('admin.danh-muc.index')); ?>" class="mb-4">
        <div class="panel panel-default" style="border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div class="panel-body" style="padding: 15px 20px;">
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-2">
                        <label class="font-weight-bold text-dark">Tên danh mục</label>
                        <input type="text" name="keyword" class="form-control"
                            placeholder="Tìm kiếm danh mục..."
                            value="<?php echo e(request('keyword')); ?>" style="border-radius: 6px;">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-2">
                        <label class="font-weight-bold text-dark">Trạng thái</label>
                        <select name="trang_thai" class="form-control" style="border-radius: 6px;">
                            <option value="">Tất cả</option>
                            <option value="1" <?php echo e(request('trang_thai') === '1' ? 'selected' : ''); ?>>Hiển thị</option>
                            <option value="0" <?php echo e(request('trang_thai') === '0' ? 'selected' : ''); ?>>Ẩn</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-12 mb-2">
                        <label class="font-weight-bold" style="visibility: hidden; display: block;">Hành động</label>
                        <div style="display: flex; gap: 8px;">
                            <button type="submit" class="btn btn-primary font-weight-bold" style="flex: 1; border-radius: 6px;">
                                <i class="fas fa-search mr-1"></i> Tìm
                            </button>
                            <a href="<?php echo e(route('admin.danh-muc.index')); ?>" class="btn btn-default" style="flex: 1; border-radius: 6px; border: 1px solid #cbd5e1;">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
        <div>
            <button class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#modalAdd" onclick="$('#formAdd')[0].reset(); $('#modalAdd select[name=\'parent_id\']').val('');" style="border-radius: 6px; padding: 7px 16px;">
                <i class="fas fa-plus mr-1"></i> Thêm danh mục mới
            </button>
        </div>
        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <button type="button" class="btn btn-default btn-sm font-weight-bold" id="btnExpandAll" style="border: 1px solid #cbd5e1; border-radius: 6px;">
                <i class="fas fa-angle-double-down text-info mr-1"></i> Mở rộng tất cả
            </button>
            <button type="button" class="btn btn-default btn-sm font-weight-bold" id="btnCollapseAll" style="border: 1px solid #cbd5e1; border-radius: 6px;">
                <i class="fas fa-angle-double-up text-muted mr-1"></i> Thu gọn tất cả
            </button>
            <span class="text-muted small" style="background: #f8fafc; padding: 5px 12px; border-radius: 15px; border: 1px solid #e2e8f0; font-size: 12px;">
                Tổng: <strong class="text-primary"><?php echo e($totalRoots ?? count($danhMucs)); ?></strong> gốc • <strong class="text-info"><?php echo e($totalSubcategories ?? 0); ?></strong> mục con
            </span>
        </div>
    </div>

    
    <div class="panel panel-default" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center table-category-tree">
                <thead>
                    <tr>
                        <th width="4%">#</th>
                        <th width="32%" class="text-left" style="padding-left: 15px !important;">Tên danh mục</th>
                        <th width="15%">Slug</th>
                        <th width="11%">Ảnh</th>
                        <th width="10%">Số sản phẩm</th>
                        <th width="12%">Trạng thái</th>
                        <th width="16%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $danhMucs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $descendants = $dm->descendants_list ?? [];
                        $childCount = count($descendants);
                    ?>
                    
                    <tr class="root-category-row" id="row-cat-<?php echo e($dm->id); ?>">
                        <td class="text-center font-weight-bold text-muted"><?php echo e($key + 1); ?></td>
                        <td class="text-left" style="padding-left: 15px !important;">
                            <div style="display: flex; align-items: center;">
                                <?php if($childCount > 0): ?>
                                    <button type="button" class="btn-tree-toggle <?php echo e(request('keyword') ? 'is-open' : ''); ?>" 
                                            data-id="<?php echo e($dm->id); ?>"
                                            title="Nhấn để xem <?php echo e($childCount); ?> danh mục con">
                                        <i class="fas fa-chevron-right tree-icon"></i>
                                    </button>
                                <?php else: ?>
                                    <span style="display: inline-block; width: 26px; margin-right: 6px; text-align: center; color: #cbd5e1;">
                                        <i class="fas fa-minus" style="font-size: 10px;"></i>
                                    </span>
                                <?php endif; ?>

                                <i class="fas fa-folder text-warning" style="font-size: 18px; margin-right: 8px;"></i>

                                <span class="font-weight-bold text-dark category-name-toggle" data-id="<?php echo e($dm->id); ?>" style="font-size: 14.5px; cursor: pointer;" title="Nhấn để mở / đóng danh mục con"><?php echo e($dm->ten_danh_muc); ?></span>

                                <?php if($childCount > 0): ?>
                                    <span class="subcat-count-badge" 
                                          data-id="<?php echo e($dm->id); ?>" 
                                          title="Nhấn để mở / đóng <?php echo e($childCount); ?> danh mục con">
                                        <?php echo e($childCount); ?> mục con
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-light border text-muted" style="margin-left: 6px; font-weight: normal; font-size: 10px;">
                                        Gốc (Cấp 1)
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="text-center"><code><?php echo e($dm->slug); ?></code></td>
                        <td class="text-center">
                            <img src="<?php echo e($dm->hinh_anh ? asset('storage/' . $dm->hinh_anh) : asset('img/shop_01.jpg')); ?>"
                                 alt="<?php echo e($dm->ten_danh_muc); ?>"
                                 class="category-thumbnail">
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-primary" style="font-size: 12px; padding: 4px 9px;">
                                <?php echo e($dm->san_phams_count); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <?php if($dm->trang_thai == 1): ?>
                                <span class="status-badge-active">Hiển thị</span>
                            <?php else: ?>
                                <span class="status-badge-hidden">Ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-action-sm" onclick="openAddSubcategory(<?php echo e($dm->id); ?>)" title="Thêm danh mục con vào đây">
                                <i class="fas fa-plus mr-1"></i> Con
                            </button>
                            <button type="button" class="btn btn-warning btn-action-sm btn-edit" data-id="<?php echo e($dm->id); ?>" title="Sửa danh mục">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-action-sm btn-delete" data-id="<?php echo e($dm->id); ?>" title="Xóa danh mục">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    
                    <?php $__currentLoopData = $descendants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cIdx => $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="child-category-row child-of-<?php echo e($dm->id); ?> <?php echo e(request('keyword') ? '' : 'hidden-row'); ?>">
                        <td class="text-center text-muted" style="font-size: 11px;">
                            <?php echo e($key + 1); ?>.<?php echo e($cIdx + 1); ?>

                        </td>
                        <td class="text-left" style="padding-left: <?php echo e(15 + ($child->depth * 24)); ?>px !important;">
                            <div style="display: flex; align-items: center;">
                                <span class="tree-branch-symbol">└──</span>
                                <i class="fas fa-tag text-info" style="font-size: 12px; margin-right: 6px;"></i>
                                <span class="text-dark font-weight-bold" style="font-size: 13.5px;"><?php echo e($child->ten_danh_muc); ?></span>
                                <?php if($child->depth > 1): ?>
                                    <span class="badge badge-light border text-muted ml-1" style="font-size: 10px;">Cấp <?php echo e($child->depth + 1); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="text-center"><code><?php echo e($child->slug); ?></code></td>
                        <td class="text-center">
                            <img src="<?php echo e($child->hinh_anh ? asset('storage/' . $child->hinh_anh) : asset('img/shop_01.jpg')); ?>"
                                 alt="<?php echo e($child->ten_danh_muc); ?>"
                                 class="category-thumbnail-child">
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-secondary" style="font-size: 11px; padding: 3px 7px;">
                                <?php echo e($child->san_phams_count); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <?php if($child->trang_thai == 1): ?>
                                <span class="status-badge-active" style="font-size: 10.5px; padding: 2px 7px;">Hiển thị</span>
                            <?php else: ?>
                                <span class="status-badge-hidden" style="font-size: 10.5px; padding: 2px 7px;">Ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-action-xs" onclick="openAddSubcategory(<?php echo e($child->id); ?>)" title="Thêm danh mục con cấp tiếp theo" style="border: 1px solid #cbd5e1;">
                                <i class="fas fa-plus text-primary"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-action-xs btn-edit" data-id="<?php echo e($child->id); ?>" title="Sửa mục con">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-action-xs btn-delete" data-id="<?php echo e($child->id); ?>" title="Xóa mục con">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div style="padding: 30px 0;">
                                <i class="fas fa-folder-open text-muted" style="font-size: 40px; margin-bottom: 12px; display: block; color: #94a3b8;"></i>
                                <p class="text-muted mb-0 font-weight-bold">Không tìm thấy danh mục nào phù hợp.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div class="modal fade" id="modalAdd">
    <div class="modal-dialog">
        <form id="formAdd">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="ten_danh_muc" class="form-control" required maxlength="255" placeholder="Nhập tên danh mục">
                        <small class="text-muted">Tối đa 255 ký tự, không được trùng với danh mục khác</small>
                    </div>

                    <div class="form-group">
                        <label>Danh mục cha</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Là danh mục gốc (Cấp 1) --</option>
                            <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pCat->id); ?>"><?php echo e($pCat->display_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="text-muted">Chọn nếu muốn tạo danh mục con thuộc danh mục cha</small>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="mo_ta" class="form-control" rows="3" maxlength="1000" placeholder="Mô tả danh mục (tùy chọn)"></textarea>
                        <small class="text-muted">Tối đa 1000 ký tự</small>
                    </div>

                    <div class="form-group">
                        <label>Ảnh danh mục</label>
                        <input type="file" name="hinh_anh" class="form-control-file" accept="image/*">
                        <small class="text-muted">JPG/PNG/WebP, tối đa 2MB (tùy chọn)</small>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="trang_thai" class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form id="formEdit">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="ten_danh_muc" id="edit_ten_danh_muc" class="form-control" required maxlength="255" placeholder="Nhập tên danh mục">
                        <small class="text-muted">Tối đa 255 ký tự, không được trùng với danh mục khác</small>
                    </div>

                    <div class="form-group">
                        <label>Danh mục cha</label>
                        <select name="parent_id" id="edit_parent_id" class="form-control">
                            <option value="">-- Là danh mục gốc (Cấp 1) --</option>
                        </select>
                        <small class="text-muted">Không thể chọn chính nó hoặc các danh mục con làm cha</small>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="mo_ta" id="edit_mo_ta" class="form-control" rows="3" maxlength="1000" placeholder="Mô tả danh mục (tùy chọn)"></textarea>
                        <small class="text-muted">Tối đa 1000 ký tự</small>
                    </div>

                    <div class="form-group">
                        <label>Ảnh danh mục</label>
                        <div class="mb-2">
                            <img
                                id="edit_category_image_preview"
                                src="<?php echo e(asset('img/shop_01.jpg')); ?>"
                                alt="Ảnh danh mục"
                                style="width: 130px; height: 80px; object-fit: cover; border-radius: 6px;"
                            >
                        </div>
                        <input type="file" id="edit_hinh_anh" name="hinh_anh" class="form-control-file" accept="image/*">
                        <small class="text-muted">Tùy chọn (nếu không chọn sẽ giữ ảnh cũ)</small>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="trang_thai" id="edit_trang_thai" class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Mở nhanh modal thêm con cho danh mục cha tương ứng
    window.openAddSubcategory = function(parentId) {
        $('#formAdd')[0].reset();
        $('#modalAdd select[name="parent_id"]').val(parentId);
        $('#modalAdd').modal('show');
    };

    $(function() {

        // Toggle mở rộng / thu gọn từng cây danh mục cha
        $(document).on('click', '.btn-tree-toggle, .subcat-count-badge, .category-name-toggle', function(e) {
            e.stopPropagation();
            let catId = $(this).data('id');
            let toggleBtn = $('#row-cat-' + catId + ' .btn-tree-toggle');
            let childRows = $('.child-of-' + catId);

            if (childRows.hasClass('hidden-row')) {
                childRows.removeClass('hidden-row');
                toggleBtn.addClass('is-open');
            } else {
                childRows.addClass('hidden-row');
                toggleBtn.removeClass('is-open');
            }
        });

        // Mở rộng tất cả
        $('#btnExpandAll').click(function() {
            $('.child-category-row').removeClass('hidden-row');
            $('.btn-tree-toggle').addClass('is-open');
        });

        // Thu gọn tất cả
        $('#btnCollapseAll').click(function() {
            $('.child-category-row').addClass('hidden-row');
            $('.btn-tree-toggle').removeClass('is-open');
        });

        // Hiển thị lỗi validation từ server (422)
        function showValidationErrors(xhr) {
            if (xhr.status === 422 && xhr.responseJSON) {
                const data = xhr.responseJSON;
                if (data.errors) {
                    Object.keys(data.errors).forEach(function(field) {
                        toastr.error(data.errors[field][0]);
                    });
                    return true;
                }
                if (data.message) {
                    toastr.error(data.message);
                    return true;
                }
            }
            return false;
        }

        $('#formAdd').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "<?php echo e(route('admin.danh-muc.store')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status) {
                        toastr.success(res.message || 'Thêm danh mục thành công!');
                        $('#modalAdd').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        toastr.error(res.message || 'Có lỗi xảy ra khi thêm danh mục');
                    }
                },
                error: function(xhr) {
                    if (!showValidationErrors(xhr)) {
                        toastr.error('Lỗi kết nối server');
                    }
                }
            });
        });

        // Hỗ trợ click nút sửa cả trên dòng cha lẫn trong menu dropdown con
        $(document).on('click', '.btn-edit', function(e) {
            e.stopPropagation();
            let id = $(this).data('id');

            $.get("<?php echo e(url('admin/danh-muc')); ?>/" + id, function(res) {
                if (res.status) {
                    $('#edit_id').val(res.data.id);
                    $('#edit_ten_danh_muc').val(res.data.ten_danh_muc);
                    $('#edit_mo_ta').val(res.data.mo_ta);
                    $('#edit_trang_thai').val(res.data.trang_thai);

                    // Đổ danh sách danh mục cha hợp lệ
                    let parentSelect = $('#edit_parent_id');
                    parentSelect.empty();
                    parentSelect.append('<option value="">-- Là danh mục gốc (Cấp 1) --</option>');
                    if (res.available_parents && res.available_parents.length > 0) {
                        res.available_parents.forEach(function(item) {
                            let isSelected = (res.data.parent_id && item.id == res.data.parent_id) ? 'selected' : '';
                            parentSelect.append(`<option value="${item.id}" ${isSelected}>${item.display_name}</option>`);
                        });
                    }

                    const placeholderImg = '<?php echo e(asset('img/shop_01.jpg')); ?>';
                    const storageBase = '<?php echo e(asset('storage')); ?>';
                    $('#edit_category_image_preview').attr(
                        'src',
                        res.data.hinh_anh ? (storageBase + '/' + res.data.hinh_anh) : placeholderImg
                    );

                    $('#modalEdit').modal('show');
                } else {
                    toastr.error('Không tìm thấy danh mục');
                }
            }).fail(function() {
                toastr.error('Lỗi khi tải thông tin danh mục');
            });
        });

        $('#formEdit').submit(function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();

            let formData = new FormData($('#formEdit')[0]);
            // Laravel update route expects PUT; use method spoof to keep multipart upload ổn định.
            formData.append('_method', 'PUT');

            $.ajax({
                url: "<?php echo e(url('admin/danh-muc')); ?>/" + id,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status) {
                        toastr.success(res.message || 'Cập nhật thành công!');
                        $('#modalEdit').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        toastr.error(res.message || 'Có lỗi khi cập nhật');
                    }
                },
                error: function(xhr) {
                    if (!showValidationErrors(xhr)) {
                        toastr.error('Lỗi kết nối server');
                    }
                }
            });
        });

        // Hỗ trợ click nút xóa cả trên dòng cha lẫn trong menu dropdown con
        $(document).on('click', '.btn-delete', function(e) {
            e.stopPropagation();
            if (!confirm('Bạn có chắc muốn xóa danh mục này?')) return;

            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo e(url('admin/danh-muc')); ?>/" + id,
                type: 'DELETE',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>"
                },
                success: function(res) {
                    if (res.status) {
                        toastr.success(res.message || 'Xóa danh mục thành công!');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        toastr.error(res.message || 'Không thể xóa danh mục');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else if (!showValidationErrors(xhr)) {
                        toastr.error('Lỗi khi xóa danh mục');
                    }
                }
            });
        });

    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/Category/list.blade.php ENDPATH**/ ?>