<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Danh sách Permissions theo nhóm
        $permissions = [
            // Hệ thống
            [
                'name' => 'admin.access',
                'display_name' => 'Truy cập trang Quản trị (Admin)',
                'group' => 'system',
                'description' => 'Cho phép truy cập vào khu vực quản trị hệ thống'
            ],
            // Báo cáo & Thống kê
            [
                'name' => 'reports.view',
                'display_name' => 'Xem báo cáo & doanh thu',
                'group' => 'reports',
                'description' => 'Xem biểu đồ, thống kê doanh thu và báo cáo tổng quan'
            ],
            // Sản phẩm
            [
                'name' => 'products.view',
                'display_name' => 'Xem sản phẩm',
                'group' => 'products',
                'description' => 'Xem danh sách và chi tiết các sản phẩm'
            ],
            [
                'name' => 'products.create',
                'display_name' => 'Thêm mới sản phẩm',
                'group' => 'products',
                'description' => 'Tạo mới sản phẩm vào hệ thống'
            ],
            [
                'name' => 'products.update',
                'display_name' => 'Chỉnh sửa sản phẩm',
                'group' => 'products',
                'description' => 'Cập nhật thông tin, hình ảnh và giá sản phẩm'
            ],
            [
                'name' => 'products.delete',
                'display_name' => 'Xóa sản phẩm',
                'group' => 'products',
                'description' => 'Xóa sản phẩm khỏi hệ thống'
            ],
            // Danh mục
            [
                'name' => 'categories.view',
                'display_name' => 'Xem danh mục',
                'group' => 'categories',
                'description' => 'Xem danh sách các danh mục sản phẩm'
            ],
            [
                'name' => 'categories.create',
                'display_name' => 'Thêm mới danh mục',
                'group' => 'categories',
                'description' => 'Tạo mới danh mục sản phẩm'
            ],
            [
                'name' => 'categories.update',
                'display_name' => 'Chỉnh sửa danh mục',
                'group' => 'categories',
                'description' => 'Cập nhật thông tin danh mục sản phẩm'
            ],
            [
                'name' => 'categories.delete',
                'display_name' => 'Xóa danh mục',
                'group' => 'categories',
                'description' => 'Xóa danh mục sản phẩm'
            ],
            // Thuộc tính (Màu sắc, Kích thước)
            [
                'name' => 'attributes.view',
                'display_name' => 'Xem thuộc tính',
                'group' => 'attributes',
                'description' => 'Xem danh sách màu sắc và kích thước'
            ],
            [
                'name' => 'attributes.create',
                'display_name' => 'Thêm thuộc tính',
                'group' => 'attributes',
                'description' => 'Tạo mới màu sắc hoặc kích thước'
            ],
            [
                'name' => 'attributes.update',
                'display_name' => 'Chỉnh sửa thuộc tính',
                'group' => 'attributes',
                'description' => 'Cập nhật thông tin màu sắc hoặc kích thước'
            ],
            [
                'name' => 'attributes.delete',
                'display_name' => 'Xóa thuộc tính',
                'group' => 'attributes',
                'description' => 'Xóa màu sắc hoặc kích thước'
            ],
            // Tồn kho & Biến thể
            [
                'name' => 'inventory.view',
                'display_name' => 'Xem biến thể & tồn kho',
                'group' => 'inventory',
                'description' => 'Xem danh sách biến thể, số lượng tồn và giá trị kho'
            ],
            [
                'name' => 'inventory.update',
                'display_name' => 'Cập nhật biến thể & tồn kho',
                'group' => 'inventory',
                'description' => 'Thêm mới, sửa số lượng tồn và cập nhật giá biến thể'
            ],
            // Đơn hàng & Hoàn trả
            [
                'name' => 'orders.view',
                'display_name' => 'Xem đơn hàng',
                'group' => 'orders',
                'description' => 'Xem danh sách và chi tiết đơn đặt hàng'
            ],
            [
                'name' => 'orders.update',
                'display_name' => 'Cập nhật đơn hàng',
                'group' => 'orders',
                'description' => 'Thay đổi trạng thái, duyệt hủy đơn và xử lý giao nhận'
            ],
            [
                'name' => 'orders.refund',
                'display_name' => 'Xử lý hoàn trả / hoàn tiền',
                'group' => 'orders',
                'description' => 'Duyệt, từ chối và hoàn tiền các yêu cầu đổi trả'
            ],
            // Khuyến mãi / Voucher
            [
                'name' => 'vouchers.view',
                'display_name' => 'Xem voucher',
                'group' => 'vouchers',
                'description' => 'Xem danh sách các mã khuyến mãi'
            ],
            [
                'name' => 'vouchers.create',
                'display_name' => 'Thêm mới voucher',
                'group' => 'vouchers',
                'description' => 'Tạo mới mã giảm giá'
            ],
            [
                'name' => 'vouchers.update',
                'display_name' => 'Chỉnh sửa voucher',
                'group' => 'vouchers',
                'description' => 'Cập nhật hạn mức, thời gian và giá trị voucher'
            ],
            [
                'name' => 'vouchers.delete',
                'display_name' => 'Xóa voucher',
                'group' => 'vouchers',
                'description' => 'Xóa mã giảm giá khỏi hệ thống'
            ],
            // Đánh giá / Bình luận
            [
                'name' => 'reviews.view',
                'display_name' => 'Xem đánh giá',
                'group' => 'reviews',
                'description' => 'Xem đánh giá, bình luận từ khách hàng'
            ],
            [
                'name' => 'reviews.manage',
                'display_name' => 'Quản lý đánh giá',
                'group' => 'reviews',
                'description' => 'Ẩn/hiện bình luận, ghim hiển thị trang chủ'
            ],
            // Liên hệ
            [
                'name' => 'contacts.view',
                'display_name' => 'Xem liên hệ',
                'group' => 'contacts',
                'description' => 'Xem tin nhắn liên hệ gửi từ khách hàng'
            ],
            [
                'name' => 'contacts.manage',
                'display_name' => 'Xử lý liên hệ',
                'group' => 'contacts',
                'description' => 'Đổi trạng thái liên hệ, phản hồi và xóa'
            ],
            // Tài khoản người dùng
            [
                'name' => 'users.view',
                'display_name' => 'Xem tài khoản người dùng',
                'group' => 'users',
                'description' => 'Xem danh sách tài khoản khách hàng và nhân viên'
            ],
            [
                'name' => 'users.create',
                'display_name' => 'Tạo tài khoản nhân viên',
                'group' => 'users',
                'description' => 'Tạo tài khoản nhân viên mới'
            ],
            [
                'name' => 'users.update',
                'display_name' => 'Chỉnh sửa & Gán vai trò người dùng',
                'group' => 'users',
                'description' => 'Cập nhật thông tin, gán vai trò và khóa tài khoản'
            ],
            [
                'name' => 'users.delete',
                'display_name' => 'Xóa người dùng',
                'group' => 'users',
                'description' => 'Xóa tài khoản người dùng khỏi hệ thống'
            ],
            // Vai trò & Phân quyền
            [
                'name' => 'roles.view',
                'display_name' => 'Xem vai trò & quyền hạn',
                'group' => 'roles',
                'description' => 'Xem danh sách vai trò và bảng phân quyền'
            ],
            [
                'name' => 'roles.manage',
                'display_name' => 'Quản lý vai trò & cấp quyền',
                'group' => 'roles',
                'description' => 'Tạo, sửa vai trò và phân bổ quyền hạn (Dành riêng cho Super Admin)'
            ],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name']],
                [
                    'display_name' => $perm['display_name'],
                    'group' => $perm['group'],
                    'description' => $perm['description'],
                ]
            );
        }

        // 2. Khởi tạo 5 Roles chuẩn
        $rolesData = [
            'super_admin' => [
                'display_name' => 'Quản trị viên tối cao (Super Admin)',
                'description' => 'Toàn quyền điều hành toàn bộ hệ thống, quản lý phân quyền và nhân sự',
            ],
            'admin' => [
                'display_name' => 'Quản trị viên (Admin)',
                'description' => 'Quản lý kinh doanh, sản phẩm, đơn hàng, khách hàng và xem báo cáo',
            ],
            'warehouse' => [
                'display_name' => 'Nhân viên kho (Warehouse)',
                'description' => 'Quản lý kiểm đếm số lượng tồn kho, danh mục và biến thể sản phẩm',
            ],
            'order_staff' => [
                'display_name' => 'Nhân viên đơn hàng (Order Staff)',
                'description' => 'Tiếp nhận, duyệt trạng thái đơn hàng, xử lý đổi trả và hỗ trợ khách hàng',
            ],
            'customer' => [
                'display_name' => 'Khách hàng (Customer)',
                'description' => 'Người mua sắm, đặt hàng và đánh giá sản phẩm trên website',
            ],
        ];

        $createdRoles = [];
        foreach ($rolesData as $name => $data) {
            $createdRoles[$name] = Role::updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => $data['display_name'],
                    'description' => $data['description'],
                ]
            );
        }

        // 3. Gán Permissions cho các Roles
        // super_admin: Nhận tất cả permissions
        $allPermissions = Permission::all();
        $createdRoles['super_admin']->permissions()->sync($allPermissions->pluck('id'));

        // admin: Nhận tất cả ngoại trừ roles.manage
        $adminPermissions = Permission::whereNotIn('name', ['roles.manage'])->pluck('id');
        $createdRoles['admin']->permissions()->sync($adminPermissions);

        // warehouse: Kho & biến thể + xem sản phẩm, thuộc tính, danh mục
        $warehousePermissions = Permission::whereIn('name', [
            'admin.access',
            'inventory.view',
            'inventory.update',
            'products.view',
            'categories.view',
            'attributes.view',
        ])->pluck('id');
        $createdRoles['warehouse']->permissions()->sync($warehousePermissions);

        // order_staff: Đơn hàng + đổi trả + xem sản phẩm/kho + liên hệ
        $orderStaffPermissions = Permission::whereIn('name', [
            'admin.access',
            'orders.view',
            'orders.update',
            'orders.refund',
            'products.view',
            'inventory.view',
            'contacts.view',
            'contacts.manage',
        ])->pluck('id');
        $createdRoles['order_staff']->permissions()->sync($orderStaffPermissions);

        // customer: Không cấp quyền admin
        $createdRoles['customer']->permissions()->sync([]);

        // 4. Chuyển đổi an toàn dữ liệu người dùng hiện có
        $existingUsers = User::all();
        foreach ($existingUsers as $user) {
            if ($user->role === 'admin') {
                $user->assignRole('admin');
            } else {
                $user->assignRole('customer');
            }
        }

        // 5. Tạo tài khoản super_admin chuyên dụng
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@customtee.vn'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('Admin@123456'),
                'role' => 'admin',
                'status' => 1,
            ]
        );
        $superAdmin->assignRole('super_admin');

        $this->command->info('RBAC System initialized successfully!');
        $this->command->info('- Super Admin Account: superadmin@customtee.vn / Admin@123456');
    }
}

