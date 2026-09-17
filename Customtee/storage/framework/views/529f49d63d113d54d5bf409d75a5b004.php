<?php $__env->startSection('AdminContent'); ?>
<div class="container-fluid" style="margin-top: 30px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary" data-toggle="modal" style="margin-bottom:20px;" data-target="#modalAdd">
            <i class="fas fa-plus"></i> Thêm kích thước
        </button>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Tên kích thước</th>
                        <th>Trạng thái</th>
                        <th width="15%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $kichThuocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $kt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><?php echo e($kt->ten_kich_thuoc); ?></td>
                        <td>
                            <?php if($kt->trang_thai): ?>
                            <span class="badge badge-success">Hiển thị</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-id="<?php echo e($kt->id); ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="<?php echo e($kt->id); ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4">Chưa có kích thước nào</td>
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
                    <h5 class="modal-title">Thêm kích thước</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên kích thước (S, M, L, 38, 39...) <span class="text-danger">*</span></label>
                        <input type="text" name="ten_kich_thuoc" class="form-control" required maxlength="50" placeholder="Ví dụ: S, M, L, XL">
                        <small class="text-muted">Tối đa 50 ký tự, không được trùng</small>
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
                    <h5 class="modal-title">Sửa kích thước</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên kích thước <span class="text-danger">*</span></label>
                        <input type="text" id="edit_ten_kich_thuoc" class="form-control" required maxlength="50" placeholder="Ví dụ: S, M, L, XL">
                        <small class="text-muted">Tối đa 50 ký tự, không được trùng</small>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select id="edit_trang_thai" class="form-control">
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
    $(function() {

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
            $.post("<?php echo e(route('admin.kich-thuoc.store')); ?>", $(this).serialize(), function(res) {
                if (res.status) {
                    toastr.success(res.message);
                    $('#modalAdd').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(res.message || 'Có lỗi xảy ra');
                }
            }).fail(function(xhr) {
                if (!showValidationErrors(xhr)) toastr.error('Lỗi kết nối server');
            });
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            $.get("<?php echo e(url('admin/kich-thuoc')); ?>/" + id, function(res) {
                if (res.status) {
                    $('#edit_id').val(res.data.id);
                    $('#edit_ten_kich_thuoc').val(res.data.ten_kich_thuoc);
                    $('#edit_trang_thai').val(res.data.trang_thai ? 1 : 0);
                    $('#modalEdit').modal('show');
                } else {
                    toastr.error('Không tìm thấy kích thước');
                }
            }).fail(() => toastr.error('Lỗi tải dữ liệu'));
        });

        $('#formEdit').submit(function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();

            $.ajax({
                url: "<?php echo e(url('admin/kich-thuoc')); ?>/" + id,
                type: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    _method: "PUT",
                    ten_kich_thuoc: $('#edit_ten_kich_thuoc').val(),
                    trang_thai: $('#edit_trang_thai').val(),
                },
                success: function(res) {
                    if (res.status) {
                        toastr.success(res.message || 'Cập nhật thành công!');
                        $('#modalEdit').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        toastr.error(res.message || 'Có lỗi xảy ra');
                    }
                },
                error: function(xhr) {
                    if (!showValidationErrors(xhr)) toastr.error('Lỗi kết nối server');
                }
            });
        });


        $('.btn-delete').click(function() {
            if (!confirm('Bạn có chắc muốn xóa kích thước này?')) return;
            let id = $(this).data('id');
            $.ajax({
                url: "<?php echo e(url('admin/kich-thuoc')); ?>/" + id,
                type: 'DELETE',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>"
                },
                success: function(res) {
                    if (res.status) {
                        toastr.success(res.message);
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        toastr.error(res.message || 'Không thể xóa');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else if (!showValidationErrors(xhr)) {
                        toastr.error('Lỗi khi xóa');
                    }
                }
            });
        });

    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.AdminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\admin\Size\list.blade.php ENDPATH**/ ?>