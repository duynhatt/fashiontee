@extends('admin.layout.AdminLayout')

@section('AdminContent')
<div class="form-w3layouts">
    <div class="panel panel-default">
        <div class="panel-heading">CHỈNH SỬA TÀI KHOẢN & VAI TRÒ: <strong>{{ $user->name }}</strong></div>
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

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Họ và tên</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Địa chỉ Email</strong> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Số điện thoại</strong></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Mật khẩu mới</strong></label>
                        <input type="password" name="password" class="form-control" placeholder="Để trống nếu không muốn đổi mật khẩu">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Trạng thái tài khoản</strong> <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" {{ $user->hasRole('super_admin') ? 'disabled' : '' }}>
                            <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Hoạt động bình thường</option>
                            <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Khóa tài khoản</option>
                        </select>
                        @if($user->hasRole('super_admin'))
                            <input type="hidden" name="status" value="1">
                            <small class="text-muted">Tài khoản Super Admin không thể bị khóa.</small>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label><strong>Phân bổ Vai trò (Roles)</strong> <span class="text-danger">*</span></label>
                    <p class="text-muted" style="margin-bottom: 10px;">Đánh dấu vào vai trò bạn muốn gán cho tài khoản này.</p>

                    <div class="row">
                        @foreach($roles as $role)
                            @php
                                $isChecked = in_array($role->id, old('roles', $userRoles));
                                $isSuperAdminRoleOnSuperUser = $role->name === 'super_admin' && ($user->hasRole('super_admin') || $user->email === 'superadmin@customtee.vn');
                            @endphp
                            <div class="col-md-6" style="margin-bottom: 10px;">
                                <div class="checkbox" style="background: #f9f9f9; padding: 10px 15px; border: 1px solid #e3e3e3; border-radius: 4px;">
                                    <label style="cursor: pointer; font-weight: bold;">
                                        @if($isSuperAdminRoleOnSuperUser)
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" checked onclick="return false;">
                                            {{ $role->display_name }} (<code>{{ $role->name }}</code>)
                                            <span class="label label-danger">Khóa bảo vệ</span>
                                        @else
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $isChecked ? 'checked' : '' }}>
                                            {{ $role->display_name }} (<code>{{ $role->name }}</code>)
                                        @endif
                                        <small class="text-muted" style="display: block; font-weight: normal; margin-top: 4px;">
                                            {{ $role->description }}
                                        </small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Cập nhật thông tin & vai trò
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

