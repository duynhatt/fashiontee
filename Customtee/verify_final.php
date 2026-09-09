<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

echo "=== KIỂM TRA TOÀN DIỆN CUỐI CÙNG ===" . PHP_EOL;

$superAdmin = User::where('email', 'superadmin@customtee.vn')->first();
$admin = User::where('email', 'leduynhat@gmail.com')->first();
$customer = User::where('email', 'nhatldph49138@gmail.com')->first();

assert($superAdmin->hasRole('super_admin'), 'Super Admin phải có role super_admin');
assert(Gate::forUser($superAdmin)->allows('roles.manage'), 'Super Admin phải quản lý được roles');
assert(Gate::forUser($superAdmin)->allows('anything_random'), 'Super Admin phải bypass được mọi gate');

assert($admin->hasRole('admin'), 'Admin phải có role admin');
assert(Gate::forUser($admin)->allows('products.view'), 'Admin phải xem được sản phẩm');
assert(!Gate::forUser($admin)->allows('roles.manage'), 'Admin KHÔNG được quản lý roles');

assert($customer->hasRole('customer'), 'Customer phải có role customer');
assert(!Gate::forUser($customer)->allows('admin.access'), 'Customer KHÔNG được vào admin');

echo "[OK] Tất cả assertions về logic RBAC đều thành công!" . PHP_EOL;
echo "Tổng số Roles: " . Role::count() . PHP_EOL;
echo "Tổng số Permissions: " . Permission::count() . PHP_EOL;
echo "Tổng số Users: " . User::count() . PHP_EOL;

