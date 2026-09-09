@extends('admin.layout.AdminLayout')

@section('AdminContent')
<div class="form-w3layouts">
    <div class="panel panel-default">
        <div class="panel-heading">THÊM VAI TRÒ & THIẾT LẬP QUYỀN MỚI</div>
        <div class="panel-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Mã vai trò (Slug)</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="VD: content_editor, accountant" required>
                        <small class="text-muted">Chỉ chứa chữ thường, số và dấu gạch dưới (VD: `inventory_manager`)</small>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Tên hiển thị</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="display_name" class="form-control" value="{{ old('display_name') }}" placeholder="VD: Quản lý Nội dung, Kế toán..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Mô tả vai trò</strong></label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Mô tả tóm tắt nhiệm vụ của vai trò này...">{{ old('description') }}</textarea>
                </div>

                <hr>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin: 0; font-weight: bold; color: #333;">DANH SÁCH QUYỀN HẠN (PERMISSIONS)</h4>
                    <label style="cursor: pointer; font-weight: bold; color: #2a80b9;">
                        <input type="checkbox" id="check-all-permissions" style="margin-right: 5px;"> Chọn tất cả hệ thống
                    </label>
                </div>

                @php
                    $groupLabels = [
                        'system' => ['title' => 'Cửa ngõ Hệ thống', 'color' => '#673ab7'],
                        'reports' => ['title' => 'Báo cáo & Thống kê', 'color' => '#009688'],
                        'products' => ['title' => 'Sản phẩm', 'color' => '#3f51b5'],
                        'categories' => ['title' => 'Danh mục', 'color' => '#2196f3'],
                        'attributes' => ['title' => 'Thuộc tính (Màu, Size)', 'color' => '#03a9f4'],
                        'inventory' => ['title' => 'Tồn kho & Biến thể', 'color' => '#ff9800'],
                        'orders' => ['title' => 'Đơn hàng & Đổi trả', 'color' => '#e91e63'],
                        'vouchers' => ['title' => 'Mã khuyến mãi (Voucher)', 'color' => '#9c27b0'],
                        'reviews' => ['title' => 'Đánh giá & Bình luận', 'color' => '#4caf50'],
                        'contacts' => ['title' => 'Tin nhắn Liên hệ', 'color' => '#00bcd4'],
                        'users' => ['title' => 'Tài khoản người dùng', 'color' => '#f44336'],
                        'roles' => ['title' => 'Vai trò & Phân quyền', 'color' => '#d32f2f'],
                    ];
                @endphp

                <div class="row">
                    @foreach($permissions as $group => $perms)
                        @php
                            $groupInfo = $groupLabels[$group] ?? ['title' => ucfirst($group), 'color' => '#607d8b'];
                        @endphp
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <div class="panel" style="border: 1px solid #ddd; border-top: 3px solid {{ $groupInfo['color'] }}; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                <div class="panel-heading" style="background: #fafafa; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="color: #333;">{{ $groupInfo['title'] }}</strong>
                                    <label style="margin: 0; font-size: 12px; cursor: pointer; color: #666;">
                                        <input type="checkbox" class="check-group" data-group="{{ $group }}"> Chọn nhóm
                                    </label>
                                </div>
                                <div class="panel-body" style="padding: 12px 15px;">
                                    @foreach($perms as $perm)
                                        <div class="checkbox" style="margin-top: 6px; margin-bottom: 6px;">
                                            <label style="cursor: pointer;">
                                                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="perm-checkbox group-{{ $group }}" {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <strong>{{ $perm->display_name }}</strong>
                                                <small class="text-muted" style="display: block; margin-left: 20px;"><code>{{ $perm->name }}</code> - {{ $perm->description }}</small>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Lưu vai trò mới
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check all system permissions
    const checkAll = document.getElementById('check-all-permissions');
    const allCheckboxes = document.querySelectorAll('.perm-checkbox');
    const groupCheckboxes = document.querySelectorAll('.check-group');

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            allCheckboxes.forEach(cb => cb.checked = checkAll.checked);
            groupCheckboxes.forEach(cb => cb.checked = checkAll.checked);
        });
    }

    // Check by group
    groupCheckboxes.forEach(gcb => {
        const group = gcb.getAttribute('data-group');
        const items = document.querySelectorAll('.group-' + group);

        // Update initial state
        const allChecked = Array.from(items).every(i => i.checked);
        gcb.checked = allChecked && items.length > 0;

        gcb.addEventListener('change', function() {
            items.forEach(i => i.checked = gcb.checked);
        });

        items.forEach(i => {
            i.addEventListener('change', function() {
                gcb.checked = Array.from(items).every(item => item.checked);
            });
        });
    });
});
</script>
@endsection

