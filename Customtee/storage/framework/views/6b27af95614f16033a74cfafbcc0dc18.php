<?php $__env->startSection('AdminContent'); ?>

<div class="container-fluid" style="margin-top: 10px;">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 font-weight-bold">Quản lý biến thể sản phẩm</h2>
    <div>
        <a href="<?php echo e(route('admin.san-pham.index')); ?>" class="btn btn-outline-secondary shadow-sm px-3 mr-2">
            <i class="fa fa-arrow-left"></i> Danh sách sản phẩm
        </a>
        
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success shadow-sm"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php
    // Reset chỉ xóa lọc biến thể, giữ lại lọc theo sản phẩm (nếu có)
    $resetUrl = route('variants.index', array_filter(['san_pham_id' => $selectedProductId], function ($v) {
        return $v !== null && $v !== '';
    }));

    $khoFilter = request('kho_filter', 'all');
?>

<div class="card shadow-lg border-0">
    <div class="card-body p-0">

        <?php $__empty_1 = true; $__currentLoopData = $sanPhams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="border-bottom">

            
            <div class="d-flex justify-content-between align-items-center p-4 bg-white">

                <div class="d-flex align-items-center">
                    <img src="<?php echo e($sp->hinh_anh_chinh ? asset('storage/' . $sp->hinh_anh_chinh) : asset('img/shop_01.jpg')); ?>"
                         width="120" height="120"
                         style="object-fit:cover; border-radius:10px;"
                         class="shadow-sm mr-3">

                    <div>
                        <div class="font-weight-bold" style="font-size: 18px;">
                            <?php echo e($sp->ten_san_pham); ?>

                        </div>

                        <div class="text-muted small">
                            Danh mục: <?php echo e($sp->danhMuc->ten_danh_muc ?? '-'); ?>

                        </div>

                        <div class="mt-1">
                            <span class="badge badge-info px-3 py-1">
                                <?php echo e($sp->variants->count()); ?> biến thể
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    
                    <?php if($loop->first): ?>
                        <form method="get" action="<?php echo e(route('variants.index')); ?>" style="display:inline;">
                            <input type="hidden" name="san_pham_id" value="<?php echo e($selectedProductId); ?>">
                            <div class="dropup" style="display:inline-block; margin-right:8px;">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    title="Lọc nâng cao"
                                >
                                    <i class="fas fa-filter"></i> Lọc
                                </button>

                                <div class="dropdown-menu p-2" style="min-width: 460px; padding: 12px 16px; left: 0; right: auto;">
                                    <div onclick="event.stopPropagation()">
                                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                                            <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:90px;">màu/size</label>
                                            <select name="mau_sac_id" class="form-control form-control-sm" style="flex:1; min-width:0;">
                                                <option value="">Tất cả</option>
                                                <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($c->id); ?>" <?php echo e(request('mau_sac_id') == $c->id ? 'selected' : ''); ?>>
                                                        <?php echo e($c->ten_mau); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <select name="kich_thuoc_id" class="form-control form-control-sm" style="flex:1; min-width:0;">
                                                <option value="">Tất cả</option>
                                                <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($s->id); ?>" <?php echo e(request('kich_thuoc_id') == $s->id ? 'selected' : ''); ?>>
                                                        <?php echo e($s->ten_kich_thuoc); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="form-group mb-1" style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                                            <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:90px;">Trạng thái</label>
                                            <select name="trang_thai" class="form-control form-control-sm" style="flex:1;">
                                                <option value="">Tất cả</option>
                                                <option value="1" <?php echo e(request('trang_thai') === '1' ? 'selected' : ''); ?>>Hiện</option>
                                                <option value="0" <?php echo e(request('trang_thai') === '0' ? 'selected' : ''); ?>>Ẩn</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-1" style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                                            <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:90px;">Giảm giá</label>
                                            <select name="km_filter" class="form-control form-control-sm" style="flex:1;">
                                                <option value="all" <?php echo e(request('km_filter', 'all') === 'all' ? 'selected' : ''); ?>>Tất cả</option>
                                                <option value="dang_giam" <?php echo e(request('km_filter') === 'dang_giam' ? 'selected' : ''); ?>>Đang giảm giá</option>
                                            </select>
                                        </div>

                                        <hr style="opacity:.2; margin: 8px 0;">

                                        <div class="form-group mb-1" style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                                            <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:90px;">Kho</label>
                                            <select name="kho_filter" class="form-control form-control-sm" style="flex:1;">
                                                <option value="all" <?php echo e($khoFilter === 'all' ? 'selected' : ''); ?>>Tất cả</option>
                                                <option value="het_hang" <?php echo e($khoFilter === 'het_hang' ? 'selected' : ''); ?>>=0 hết hàng</option>
                                                <option value="gan_het" <?php echo e($khoFilter === 'gan_het' ? 'selected' : ''); ?>>&lt;10 gần hết</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-1" style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                                            <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:90px;">Min/Max</label>
                                            <div style="display:flex; gap:10px; flex:1;">
                                                <input type="number"
                                                       name="kho_min"
                                                       class="form-control form-control-sm"
                                                       min="0"
                                                       step="1"
                                                       placeholder="Từ"
                                                       value="<?php echo e(request('kho_min')); ?>"
                                                       style="flex:1;">
                                                <input type="number"
                                                       name="kho_max"
                                                       class="form-control form-control-sm"
                                                       min="0"
                                                       step="1"
                                                       placeholder="Đến"
                                                       value="<?php echo e(request('kho_max')); ?>"
                                                       style="flex:1;">
                                            </div>
                                        </div>

                                        <hr style="opacity:.2; margin: 8px 0;">

                                        <div class="form-group mb-1" style="display:flex; align-items:center; gap:12px; margin-bottom:6px;">
                                            <label class="small text-muted" style="margin-bottom:0; white-space:nowrap; width:90px;">Giá Min/Max</label>
                                            <div style="display:flex; gap:10px; flex:1;">
                                                <input type="number" name="gia_min" class="form-control form-control-sm" min="0" step="1" placeholder="Từ" value="<?php echo e(request('gia_min')); ?>" style="flex:1;">
                                                <input type="number" name="gia_max" class="form-control form-control-sm" min="0" step="1" placeholder="Đến" value="<?php echo e(request('gia_max')); ?>" style="flex:1;">
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2 mt-1">
                                            <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
                                            <a href="<?php echo e($resetUrl); ?>" class="btn btn-sm btn-outline-secondary" title="Xóa lọc nâng cao">Xóa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>

                    <?php if($sp->variants->count() > 0): ?>
                        <a href="<?php echo e(route('variants.edit', $sp->variants->first()->id)); ?>"
                           class="btn btn-warning btn-sm shadow px-3 mr-2">
                            <i class="fa fa-edit"></i> Sửa biến thể
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('variants.create', ['san_pham_id' => $sp->id])); ?>"
                       class="btn btn-success btn-sm shadow px-3">
                        <i class="fa fa-plus-circle"></i> Thêm biến thể
                    </a>
                </div>

            </div>

            
            <?php if($sp->variants->count() > 0): ?>
            <div class="table-responsive px-3 pb-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Màu</th>
                            <th>Size</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th>Trạng thái</th>
                            <th width="150">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $sp->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($v->color->ten_mau ?? '-'); ?></td>
                            <td><?php echo e($v->size->ten_kich_thuoc ?? '-'); ?></td>
                            <td class="font-weight-bold text-danger">
                                <?php echo e(number_format($v->gia ?? 0)); ?>đ
                            </td>
                            <td><?php echo e($v->so_luong); ?></td>
                            <td>
                                <?php if($v->trang_thai): ?>
                                    <span class="badge badge-success px-3">Hiện</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary px-3 width">Ẩn</span>
                                <?php endif; ?>
                            </td>
                                     <td>
                                          

                                <form action="<?php echo e(route('variants.delete', $v->id)); ?>"
                                      method="POST"
                                      style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Xóa biến thể này?')">
                                            <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="p-4 text-center text-muted small">
                <?php if(!empty($hasVariantFilters)): ?>
                    Không có biến thể phù hợp bộ lọc —
                    <a href="<?php echo e($resetUrl); ?>" class="font-weight-bold">Xóa bộ lọc</a>
                <?php else: ?>
                    Chưa có biến thể —
                    <a href="<?php echo e(route('variants.create', ['san_pham_id' => $sp->id])); ?>" class="font-weight-bold">
                        Thêm biến thể đầu tiên
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-info m-4">
            <?php if(!empty($hasVariantFilters)): ?>
                Không có biến thể phù hợp bộ lọc.
            <?php else: ?>
                Chưa có biến thể nào.
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/admin/variants/index.blade.php ENDPATH**/ ?>