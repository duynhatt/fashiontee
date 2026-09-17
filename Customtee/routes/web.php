<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\KichThuocController;
use App\Http\Controllers\Admin\MauSacController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\BinhLuanController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\client\GioHangController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ChatbotController;
use App\Http\Controllers\client\ProfileController;
use App\Http\Controllers\client\SanPhamController as ClientSanPhamController;
use App\Http\Controllers\client\ShopController;
use App\Models\BienThe;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\client\OrderController;
use App\Http\Controllers\Client\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Client Authentication
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification
Route::get('/verify-email', [AuthController::class, 'showVerifyForm'])->name('verification.notice');
Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/verify-email/resend', [AuthController::class, 'resendVerificationOtp'])->middleware('throttle:6,1')->name('verification.resend');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->middleware('throttle:6,1')->name('password.email');
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Liên hệ cho khách (Client)
Route::get('Contact', [ContactController::class, 'Contact'])->name('contact');
Route::post('Contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('Shop', [ShopController::class, 'Shop']);
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->middleware('throttle:20,1')->name('chatbot.message');

Route::get('/san-pham/{slug}', [ClientSanPhamController::class, 'showProduct'])
    ->name('sanpham.chitiet');

Route::get('/api/product-variant', function (Request $request) {
    $productId = $request->query('product_id');
    $colorId   = $request->query('color');
    $sizeId    = $request->query('size');

    $product = \App\Models\SanPham::where('id', $productId)
        ->where('trang_thai', true)
        ->whereHas('danhMuc', fn($q) => $q->where('trang_thai', 1))
        ->first();

    if (!$product) {
        return response()->json(['success' => false]);
    }

    $variant = BienThe::where('san_pham_id', $productId)
        ->where('mau_sac_id', $colorId)
        ->where('kich_thuoc_id', $sizeId)
        ->where('trang_thai', true)
        ->first();

    if ($variant) {
        return response()->json([
            'success' => true,
            'variant' => [
                'id'              => $variant->id,
                'gia'             => $variant->gia,
                'gia_khuyen_mai'  => $variant->gia_khuyen_mai,
                'so_luong'        => $variant->so_luong,
            ]
        ]);
    }
    return response()->json(['success' => false]);
})->name('api.product.variant');

// API Gợi ý tìm kiếm nhanh (Live search)
Route::get('/api/search/suggest', [SearchController::class, 'suggest'])->name('api.search.suggest');

// API Lấy dữ liệu Mini-Cart Drawer (cho cả khách và user)
Route::get('/api/cart/drawer-data', [GioHangController::class, 'getDrawerData'])->name('api.cart.drawer-data');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

    Route::get('/order', [OrderController::class, 'list'])->name('order');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::post('/order/{id}/received', [OrderController::class, 'received'])->name('order.received');
    Route::post('/order/{id}/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::post('/order/{donHang}/return-request', [OrderController::class, 'requestReturn'])
        ->name('order.return.request');
    Route::post('/order/{id}/reorder', [OrderController::class, 'reorder'])
        ->name('order.reorder');

    Route::get('/gio-hang', [GioHangController::class, 'index'])->name('gio-hang.index');
    Route::post('/gio-hang', [GioHangController::class, 'store'])->name('gio-hang.store');
    Route::put('/gio-hang/{gioHang}', [GioHangController::class, 'update'])->name('gio-hang.update');
    Route::delete('/gio-hang/{gioHang}', [GioHangController::class, 'destroy'])->name('gio-hang.destroy');
    Route::post('/gio-hang/selection', [GioHangController::class, 'updateSelection'])->name('gio-hang.selection');
    Route::delete('/api/cart/quick-remove/{id}', [GioHangController::class, 'quickRemove'])->name('api.cart.quick-remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('dat-hang');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Mua ngay (không dùng giỏ hàng)
    Route::post('/buy-now', [CheckoutController::class, 'buyNow'])->name('buy-now');
    Route::get('/checkout/buy-now', [CheckoutController::class, 'checkoutBuyNow'])->name('checkout.buy-now');
    Route::post('/checkout/buy-now/process', [CheckoutController::class, 'processBuyNow'])->name('checkout.buy-now.process');
    Route::get('/checkout/vnpay/return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
    Route::get('/order/{id}/repay', [CheckoutController::class, 'repay'])->name('order.repay');

    // ROUTE ÁP DỤNG VOUCHER CHO CLIENT
    Route::post('/apply-voucher', [VoucherController::class, 'applyVoucher'])->name('voucher.apply');

    Route::post('binh-luan', [BinhLuanController::class, 'store'])->name('binh-luan.store');

    Route::get('/order/success/{ma_don_hang}', function ($ma_don_hang) {
        $donHang = \App\Models\DonHang::where('ma_don_hang', $ma_don_hang)->firstOrFail();
        return view('client.checkout.success', compact('donHang'));
    })->name('order.success');
});

// KHU VỰC ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'home'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->name('dashboard');

    // Quản lý Vai trò & Phân quyền (Roles & Permissions) - Dành riêng cho super_admin
    Route::resource('roles', RoleController::class)->middleware('permission:roles.manage');

    // Quản lý Người dùng & Gán vai trò (User Management)
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('permission:users.view');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('permission:users.create');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.update');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('permission:users.update');
    Route::patch('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status')->middleware('permission:users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users.delete');

    // Danh mục sản phẩm
    Route::resource('danh-muc', CategoryController::class)->middleware('permission:categories.view');

    // Thuộc tính: Màu sắc & Kích thước
    Route::resource('mau-sac', MauSacController::class)->middleware('permission:attributes.view');
    Route::resource('kich-thuoc', KichThuocController::class)->middleware('permission:attributes.view');

    // Quản lý Sản phẩm
    Route::resource('san-pham', SanPhamController::class)->middleware('permission:products.view');

    // Quản lý Voucher
    Route::resource('vouchers', VoucherController::class)->middleware('permission:vouchers.view');

    // Quản lý Đánh giá / Bình luận
    Route::resource('binh-luan', BinhLuanController::class)->middleware('permission:reviews.view');
    Route::get('binh-luan', [BinhLuanController::class, 'index'])->name('binh-luan.index')->middleware('permission:reviews.view');
    Route::get('binh-luan/toggle/{id}', [BinhLuanController::class, 'toggle'])
        ->name('binh-luan.toggle')->middleware('permission:reviews.manage');
    Route::get('binh-luan/toggle-home/{id}', [BinhLuanController::class, 'toggleHome'])
        ->name('binh-luan.toggle-home')->middleware('permission:reviews.manage');

    // Quản lý Đơn hàng
    Route::get('don-hang', [DonHangController::class, 'index'])->name('don-hang.index')->middleware('permission:orders.view');
    Route::get('don-hang/{donHang}', [DonHangController::class, 'show'])->name('don-hang.show')->middleware('permission:orders.view');
    Route::patch('don-hang/{donHang}/status', [DonHangController::class, 'updateStatus'])->name('don-hang.update-status')->middleware('permission:orders.update');

    // Duyệt/từ chối yêu cầu hủy đơn
    Route::patch('don-hang/{donHang}/cancel-request/approve', [DonHangController::class, 'approveCancelRequest'])
        ->name('don-hang.cancel-request.approve')->middleware('permission:orders.update');
    Route::patch('don-hang/{donHang}/cancel-request/reject', [DonHangController::class, 'rejectCancelRequest'])
        ->name('don-hang.cancel-request.reject')->middleware('permission:orders.update');

    // Quản lý Liên hệ
    Route::prefix('lien-he')->name('lien-he.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('index')->middleware('permission:contacts.view');
        Route::post('/{id}/status', [\App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('updateStatus')->middleware('permission:contacts.manage'); 
        Route::delete('/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('destroy')->middleware('permission:contacts.manage');
    });

    // Quản lý Hoàn trả
    Route::get('/hoan-tra', [RefundController::class, 'index'])->name('hoan-tra.index')->middleware('permission:orders.refund');
    Route::get('/hoan-tra/{refund}', [RefundController::class, 'show'])->name('hoan-tra.show')->middleware('permission:orders.refund');
    Route::patch('/hoan-tra/{refund}/accept', [RefundController::class, 'accept'])
        ->name('hoan-tra.accept')->middleware('permission:orders.refund');
    Route::patch('/hoan-tra/{refund}/reject', [RefundController::class, 'reject'])
        ->name('hoan-tra.reject')->middleware('permission:orders.refund');
    Route::patch('hoan_tra/{refund}/refund-complete',[RefundController::class,'RefundComplete'])
        ->name('hoan-tra.complete')->middleware('permission:orders.refund');
});

// Quản lý Biến thể & Tồn kho
Route::prefix('admin/variants')->name('variants.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [VariantController::class, 'index'])->name('index')->middleware('permission:inventory.view');
    Route::get('/create', [VariantController::class, 'create'])->name('create')->middleware('permission:inventory.update');
    Route::post('/store', [VariantController::class, 'store'])->name('store')->middleware('permission:inventory.update');
    Route::get('/edit/{id}', [VariantController::class, 'edit'])->name('edit')->middleware('permission:inventory.update');
    Route::post('/update/{id}', [VariantController::class, 'update'])->name('update')->middleware('permission:inventory.update');
    Route::delete('/delete/{id}', [VariantController::class, 'destroy'])->name('delete')->middleware('permission:inventory.update');
    Route::delete('/images/{id}', [VariantController::class, 'destroyImage'])->name('images.delete')->middleware('permission:inventory.update');
});

// Các Route API bổ trợ cho Admin
Route::get('/admin/products/info/{id}', function ($id) {
    $product = \App\Models\SanPham::with('category')->findOrFail($id);
    return response()->json([
        'name'     => $product->ten_san_pham,
        'image'    => $product->hinh_anh_chinh,
        'category' => $product->category->ten_danh_muc ?? '',
        'desc'     => $product->mo_ta_ngan,
    ]);
})->middleware(['auth', 'admin']);

Route::get('/admin/variants/by-product/{id}', function ($id) {
    $product = \App\Models\SanPham::with(['variants.color', 'variants.size', 'variants.images'])->findOrFail($id);
    return response()->json([
        'variants' => $product->variants->map(function ($variant) {
            return [
                'id'             => $variant->id,
                'mau_sac_id'     => $variant->mau_sac_id,
                'kich_thuoc_id'  => $variant->kich_thuoc_id,
                'mau'            => $variant->color->ten_mau ?? '',
                'size'           => $variant->size->ten_kich_thuoc ?? '',
                'gia'            => $variant->gia,
                'gia_khuyen_mai' => $variant->gia_khuyen_mai,
                'so_luong'       => $variant->so_luong,
                'trang_thai'     => (bool) $variant->trang_thai,
                'images'         => $variant->images->map(fn ($image) => asset('storage/' . $image->duong_dan))->values(),
            ];
        })->values(),
    ]);
})->middleware(['auth', 'admin']);

// Báo cáo & Thống kê Dashboard
Route::get('/admin/dashboard/orders-by-status', [DashboardController::class, 'ordersByStatus'])
    ->middleware(['auth', 'admin', 'permission:reports.view'])
    ->name('admin.dashboard.orders-by-status');

Route::get('/admin/dashboard/revenue-time-table', [DashboardController::class, 'revenueTimeTable'])
    ->middleware(['auth', 'admin', 'permission:reports.view'])
    ->name('admin.dashboard.revenue-time-table');

Route::get('/admin/dashboard/low-stock-variants', [DashboardController::class, 'lowStockVariants'])
    ->middleware(['auth', 'admin', 'permission:reports.view'])
    ->name('admin.dashboard.low-stock-variants');
