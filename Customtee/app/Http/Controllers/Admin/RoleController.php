<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|alpha_dash|unique:roles,name',
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => 'Vui lòng nhập mã vai trò (slug).',
            'name.unique' => 'Mã vai trò này đã tồn tại.',
            'name.alpha_dash' => 'Mã vai trò chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
            'display_name.required' => 'Vui lòng nhập tên hiển thị vai trò.',
        ]);

        $role = Role::create([
            'name' => strtolower($request->name),
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Tạo vai trò mới thành công!');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        if ($role->name === 'super_admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Vai trò Super Admin là tối cao và được bảo vệ, không thể chỉnh sửa.');
        }

        $permissions = Permission::all()->groupBy('group');
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'super_admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Vai trò Super Admin là tối cao và được bảo vệ, không thể chỉnh sửa.');
        }

        $request->validate([
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'display_name.required' => 'Vui lòng nhập tên hiển thị vai trò.',
        ]);

        $role->update([
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', "Cập nhật vai trò [{$role->display_name}] thành công!");
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::withCount('users')->findOrFail($id);

        if ($role->name === 'super_admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Không thể xóa vai trò Super Admin!');
        }

        if ($role->users_count > 0) {
            return redirect()->route('admin.roles.index')->with('error', "Không thể xóa vai trò [{$role->display_name}] vì đang có {$role->users_count} người dùng đảm nhiệm.");
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Xóa vai trò thành công!');
    }
}

