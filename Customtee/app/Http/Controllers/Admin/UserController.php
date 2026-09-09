<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users with search and filter.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('role')) {
            $roleName = $request->role;
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        $users = $query->latest()->paginate(12)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user / staff.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'status' => 'required|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự trở lên.',
            'roles.required' => 'Vui lòng chọn ít nhất một vai trò.',
        ]);

        $rolesSelected = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        $isAdminRole = in_array('super_admin', $rolesSelected) || in_array('admin', $rolesSelected) || in_array('warehouse', $rolesSelected) || in_array('order_staff', $rolesSelected);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $isAdminRole ? 'admin' : 'client',
            'status' => (int) $request->status,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản người dùng thành công!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'status' => 'required|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã tồn tại.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự trở lên.',
            'roles.required' => 'Vui lòng chọn ít nhất một vai trò.',
        ]);

        // Bảo vệ tài khoản Super Admin chính không bị tước quyền super_admin hoặc bị khóa
        $isSuperAdminUser = $user->hasRole('super_admin') || $user->email === 'superadmin@customtee.vn';
        $rolesSelected = Role::whereIn('id', $request->roles)->pluck('name')->toArray();

        if ($isSuperAdminUser && !in_array('super_admin', $rolesSelected)) {
            return back()->withInput()->with('error', 'Không thể tước vai trò Super Admin của tài khoản quản trị tối cao!');
        }

        if ($isSuperAdminUser && (int) $request->status === 0) {
            return back()->withInput()->with('error', 'Không thể khóa tài khoản Super Admin!');
        }

        $isAdminRole = in_array('super_admin', $rolesSelected) || in_array('admin', $rolesSelected) || in_array('warehouse', $rolesSelected) || in_array('order_staff', $rolesSelected);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = (int) $request->status;
        $user->role = $isAdminRole ? 'admin' : 'client';

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', "Cập nhật tài khoản [{$user->name}] thành công!");
    }

    /**
     * Toggle active/locked status of user.
     */
    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('super_admin') || $user->email === 'superadmin@customtee.vn') {
            return redirect()->back()->with('error', 'Không thể khóa tài khoản Super Admin!');
        }

        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Bạn không thể tự khóa tài khoản của chính mình!');
        }

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        $action = $user->status == 1 ? 'Mở khóa' : 'Khóa';
        return redirect()->back()->with('success', "{$action} tài khoản [{$user->name}] thành công!");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('super_admin') || $user->email === 'superadmin@customtee.vn') {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản Super Admin!');
        }

        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản người dùng thành công!');
    }
}

