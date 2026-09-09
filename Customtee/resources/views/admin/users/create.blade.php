@extends('admin.layout.AdminLayout')

@section('AdminContent')
<div class="form-w3layouts">
    <div class="panel panel-default">
        <div class="panel-heading">THÊM TÀI KHOẢN MỚI</div>
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

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Họ và tên</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="VD: Nguyễn Văn A" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Địa chỉ Email</strong> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="VD: user@customtee.vn" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Số điện thoại</strong></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="VD: 0987654321">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>Mật khẩu ban đầu</strong> <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Trạng thái tài khoản</strong> <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hoạt động bình thường</option>
                            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Khóa tài khoản</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label><strong>Phân bổ Vai trò (Roles)</strong> <span class="text-danger">*</span></label>
                    <p class="text-muted" style="margin-bottom: 10px;">Một người dùng có thể đảm nhận nhiều vai trò trong hệ thống.</p>

                    <div class="row">
                        @foreach($roles as $role)
                            <div class="col-md-6" style="margin-bottom: 10px;">
                                <div class="checkbox" style="background: #f9f9f9; padding: 10px 15px; border: 1px solid #e3e3e3; border-radius: 4px;">
                                    <label style="cursor: pointer; font-weight: bold;">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                        {{ $role->display_name }} (<code>{{ $role->name }}</code>)
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
                        <i class="fa fa-save"></i> Tạo tài khoản
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

