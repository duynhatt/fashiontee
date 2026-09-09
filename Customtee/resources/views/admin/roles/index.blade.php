@extends('admin.layout.AdminLayout')

@section('AdminContent')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
            <span>QUẢN LÝ VAI TRÒ & PHÂN QUYỀN (RBAC)</span>
            @can('roles.manage')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i> Thêm vai trò mới
            </a>
            @endcan
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin: 15px 15px 0 15px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="margin: 15px 15px 0 15px;">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive" style="padding: 15px;">
            <table class="table table-striped table-hover b-t b-light">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Mã vai trò (Slug)</th>
                        <th>Tên hiển thị</th>
                        <th>Mô tả</th>
                        <th class="text-center">Người dùng</th>
                        <th class="text-center">Quyền hạn</th>
                        <th style="width: 180px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <code>{{ $role->name }}</code>
                            </td>
                            <td>
                                <strong>{{ $role->display_name }}</strong>
                                @if($role->name === 'super_admin')
                                    <span class="label label-danger" style="margin-left: 5px;">Tối cao (Bypass)</span>
                                @endif
                            </td>
                            <td>{{ $role->description ?? 'Chưa có mô tả' }}</td>
                            <td class="text-center">
                                <span class="badge bg-info" style="font-size: 13px;">{{ $role->users_count }}</span>
                            </td>
                            <td class="text-center">
                                @if($role->name === 'super_admin')
                                    <span class="label label-primary" style="font-size: 12px;">Toàn quyền (Tất cả)</span>
                                @else
                                    <span class="badge bg-success" style="font-size: 13px;">{{ $role->permissions_count }} quyền</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($role->name === 'super_admin')
                                    <span class="text-muted"><i class="fa fa-lock"></i> Đã khóa bảo vệ</span>
                                @else
                                    @can('roles.manage')
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-xs btn-primary" title="Chỉnh sửa quyền">
                                            <i class="fa fa-pencil"></i> Sửa quyền
                                        </a>
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vai trò [{{ $role->display_name }}]?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" {{ $role->users_count > 0 ? 'disabled title="Đang có người dùng giữ vai trò này"' : 'title="Xóa vai trò"' }}>
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

