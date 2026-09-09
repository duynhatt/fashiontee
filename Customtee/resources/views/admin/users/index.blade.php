@extends('admin.layout.AdminLayout')

@section('AdminContent')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
            <span>QUẢN LÝ TÀI KHOẢN NGƯỜI DÙNG & VAI TRÒ</span>
            @can('users.create')
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">
                <i class="fa fa-user-plus"></i> Thêm tài khoản mới
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

        <!-- Bộ lọc & Tìm kiếm -->
        <div class="row w3-res-tb" style="padding: 15px 15px 5px 15px;">
            <div class="col-sm-12">
                <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                    <div class="form-group">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control input-sm" placeholder="Tìm tên, email, SĐT..." style="min-width: 220px;">
                    </div>
                    <div class="form-group">
                        <select name="role" class="form-control input-sm">
                            <option value="">-- Tất cả vai trò --</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}" {{ request('role') == $r->name ? 'selected' : '' }}>
                                    {{ $r->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-filter"></i> Lọc dữ liệu
                    </button>
                    @if(request()->hasAny(['keyword', 'role']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-default">
                            <i class="fa fa-refresh"></i> Đặt lại
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="table-responsive" style="padding: 15px;">
            <table class="table table-striped table-hover b-t b-light">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Họ tên</th>
                        <th>Email & SĐT</th>
                        <th>Vai trò (Roles)</th>
                        <th class="text-center">Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th style="width: 180px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                @if($user->hasRole('super_admin'))
                                    <span class="label label-danger" style="margin-left: 5px;">Super Admin</span>
                                @endif
                            </td>
                            <td>
                                <div><i class="fa fa-envelope-o text-muted"></i> {{ $user->email }}</div>
                                @if($user->phone)
                                    <div><small class="text-muted"><i class="fa fa-phone"></i> {{ $user->phone }}</small></div>
                                @endif
                            </td>
                            <td>
                                @forelse($user->roles as $role)
                                    @php
                                        $badgeClass = match($role->name) {
                                            'super_admin' => 'label-danger',
                                            'admin' => 'label-primary',
                                            'warehouse' => 'label-warning',
                                            'order_staff' => 'label-info',
                                            default => 'label-default',
                                        };
                                    @endphp
                                    <span class="label {{ $badgeClass }}" style="font-size: 11px; margin-right: 4px; display: inline-block; margin-bottom: 2px;">
                                        {{ $role->display_name }}
                                    </span>
                                @empty
                                    <span class="text-muted">Chưa gán vai trò</span>
                                @endforelse
                            </td>
                            <td class="text-center">
                                @if($user->status == 1)
                                    <span class="label label-success">Hoạt động</span>
                                @else
                                    <span class="label label-default">Đã khóa</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</small>
                            </td>
                            <td class="text-center">
                                <div style="display: inline-flex; gap: 5px; align-items: center;">
                                    @can('users.update')
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-xs btn-primary" title="Sửa thông tin & vai trò">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>

                                    @if(!$user->hasRole('super_admin') && auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-xs {{ $user->status == 1 ? 'btn-warning' : 'btn-success' }}" title="{{ $user->status == 1 ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}">
                                            <i class="fa {{ $user->status == 1 ? 'fa-ban' : 'fa-check' }}"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan

                                    @can('users.delete')
                                    @if(!$user->hasRole('super_admin') && auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng [{{ $user->name }}]?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" title="Xóa tài khoản">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 30px;">
                                Không tìm thấy người dùng nào phù hợp.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel-footer" style="background: #fafafa;">
            <div class="row">
                <div class="col-sm-6 text-muted">
                    Hiển thị {{ $users->firstItem() ?? 0 }} đến {{ $users->lastItem() ?? 0 }} trong tổng số {{ $users->total() }} tài khoản
                </div>
                <div class="col-sm-6 text-right">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

