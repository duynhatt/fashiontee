<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\BienThe;
use App\Models\GioHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GioHangController extends Controller
{
    /**
     * Danh sách giỏ hàng (chỉ dòng đang_trong_gio).
     */
    public function index()
    {
        $items = GioHang::with(['sanPham', 'bienThe.color', 'bienThe.size'])
            ->where('nguoi_dung_id', Auth::id())
            ->dangTrongGio()
            // Chỉ hiển thị những dòng giỏ còn hợp lệ:
            // - Sản phẩm đang bật (trang_thai = true)
            // - Danh mục của sản phẩm đang bật (trang_thai = 1)
            // - Biến thể đang bật (trang_thai = true)
            ->whereHas('sanPham', function ($q) {
                $q->where('trang_thai', true)
                  ->whereHas('danhMuc', function ($q2) {
                      $q2->where('trang_thai', 1);
                  });
            })
            ->whereHas('bienThe', function ($q) {
                $q->where('trang_thai', true);
            })
            ->whereNotNull('bien_the_id')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Cập nhật giá hiện tại từ bien_thes
        foreach ($items as $item) {
            $item->syncGiaMoi();
            // Đảm bảo thành tiền luôn đúng với giá mới và số lượng
            $item->thanh_tien = $item->so_luong * $item->don_gia;
            // Chỉ lưu khi có sự thay đổi để tối ưu, tránh ghi vào DB không cần thiết
            if ($item->isDirty()) $item->save();
        }

        $tongTien = $items->sum('thanh_tien');
        $hasSelection = session()->has('gio_hang_selected_ids');
        $selectedIds = session('gio_hang_selected_ids');
        $selectedIds = is_array($selectedIds) ? $selectedIds : [];
        $itemIds = $items->pluck('id')->all();
        $selectedIds = array_values(array_intersect($selectedIds, $itemIds));
        $useSelection = $hasSelection;
        $selectedSet = $useSelection ? array_fill_keys($selectedIds, true) : [];

        return view('client.gio-hang.index', compact('items', 'tongTien', 'selectedSet', 'useSelection'));
    }

    /**
     * Thêm sản phẩm (biến thể) vào giỏ.
     * Nếu đã có cùng user + product + variant + dang_trong_gio → cộng dồn so_luong.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'san_pham_id' => 'required|exists:san_phams,id',
            'bien_the_id' => 'required|exists:bien_thes,id',
            'so_luong'    => 'required|integer|min:1',
        ], [
            'san_pham_id.required' => 'Thiếu thông tin sản phẩm.',
            'bien_the_id.required'  => 'Vui lòng chọn màu và kích thước.',
            'bien_the_id.exists'    => 'Biến thể không tồn tại.',
            'so_luong.min'          => 'Số lượng tối thiểu là 1.',
        ]);

        $bienThe = BienThe::where('id', $validated['bien_the_id'])
            ->where('san_pham_id', $validated['san_pham_id'])
            ->where('trang_thai', true)
            ->firstOrFail();

        $soLuongTon = $bienThe->so_luong;
        if ($validated['so_luong'] > $soLuongTon) {
            throw ValidationException::withMessages([
                'so_luong' => "Chỉ còn {$soLuongTon} sản phẩm trong kho.",
            ]);
        }

        $donGia = $bienThe->gia_khuyen_mai ?? $bienThe->gia;
        if ($donGia === null || $donGia < 0) {
            throw ValidationException::withMessages(['bien_the_id' => 'Sản phẩm chưa có giá.']);
        }

        $existing = GioHang::where('nguoi_dung_id', Auth::id())
            ->where('san_pham_id', $validated['san_pham_id'])
            ->where('bien_the_id', $validated['bien_the_id'])
            ->dangTrongGio()
            ->first();

        if ($existing) {
            $newSoLuong = $existing->so_luong + $validated['so_luong'];
            $buyNow = $request->boolean('buy_now');
            if ($newSoLuong > $soLuongTon) {
                if ($buyNow) {
                    // Mua ngay: đã có trong giỏ (có thể đủ tồn kho), chỉ cần trả cart_item_id để chuyển checkout
                    $existing->syncGiaMoi();
                    if ($existing->isDirty()) {
                        $existing->save();
                    }
                    $cartItemId = $existing->id;
                    $message = 'Chuyển đến thanh toán.';
                } else {
                    throw ValidationException::withMessages([
                        'so_luong' => "Tổng số lượng vượt tồn kho (tối đa {$soLuongTon}).",
                    ]);
                }
            } else {
                $existing->so_luong = $newSoLuong;
                $existing->don_gia = $donGia;
                $existing->thanh_tien = $newSoLuong * $donGia;
                $existing->save();
                $message = 'Đã cập nhật số lượng trong giỏ hàng.';
                $cartItemId = $existing->id;
            }
        } else {
            $item = GioHang::create([
                'nguoi_dung_id' => Auth::id(),
                'san_pham_id'   => $validated['san_pham_id'],
                'bien_the_id'   => $validated['bien_the_id'],
                'thiet_ke_ao_id' => null,
                'so_luong'      => $validated['so_luong'],
                'don_gia'       => $donGia,
                'thanh_tien'    => $validated['so_luong'] * $donGia,
                'trang_thai'    => GioHang::TRANG_THAI_DANG_TRONG_GIO,
            ]);
            $message = 'Đã thêm vào giỏ hàng.';
            $cartItemId = $item->id;
        }

        if ($request->wantsJson()) {
            $cartCount = GioHang::where('nguoi_dung_id', Auth::id())
                ->dangTrongGio()
                ->whereNotNull('bien_the_id')
                ->count();

            return response()->json([
                'success'      => true,
                'message'      => $message,
                'cart_item_id' => $cartItemId,
                'cart_count'   => $cartCount,
            ]);
        }

        return redirect()->route('gio-hang.index')->with('success', $message);
    }

    /**
     * Cập nhật số lượng một dòng giỏ hàng.
     */
    public function update(Request $request, GioHang $gioHang)
    {
        $this->authorizeCartItem($gioHang);

        $validated = $request->validate([
            'so_luong' => 'required|integer|min:1',
        ], [
            'so_luong.min' => 'Số lượng tối thiểu là 1.',
        ]);

        $bienThe = $gioHang->bienThe;
        if (!$bienThe || $validated['so_luong'] > $bienThe->so_luong) {
            $max = $bienThe ? $bienThe->so_luong : 0;
            $message = "Số lượng tối đa theo kho là {$max}.";
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $message,
                    'errors'  => ['so_luong' => [$message]],
                    'max'     => (int) $max,
                ], 422);
            }
            throw ValidationException::withMessages([
                'so_luong' => $message,
            ]);
        }

        $gioHang->so_luong = $validated['so_luong'];
        // Cập nhật giá mới nếu có thay đổi
        $gioHang->syncGiaMoi();
        // Tính lại thành tiền
        $gioHang->thanh_tien = $gioHang->so_luong * $gioHang->don_gia;
        $gioHang->save();

        if ($request->wantsJson()) {
            $gioHang->refresh();
            return response()->json([
                'success'    => true,
                'thanh_tien' => (int) $gioHang->thanh_tien,
                'so_luong'   => (int) $gioHang->so_luong,
                'max'        => $bienThe ? (int) $bienThe->so_luong : 0,
                'message'    => 'Đã cập nhật số lượng.',
            ]);
        }

        return redirect()->route('gio-hang.index')->with('success', 'Đã cập nhật số lượng.');
    }

    /**
     * Xóa một dòng khỏi giỏ hàng.
     */
    public function destroy(GioHang $gioHang)
    {
        $this->authorizeCartItem($gioHang);

        $gioHang->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa khỏi giỏ hàng.']);
        }

        return redirect()->route('gio-hang.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    /**
     * Lưu danh sách dòng giỏ hàng được chọn để checkout.
     */
    public function updateSelection(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'array',
            'ids.*' => 'integer',
        ]);

        $ids = $validated['ids'] ?? [];

        if (count($ids) > 0) {
            $validIds = GioHang::where('nguoi_dung_id', Auth::id())
                ->dangTrongGio()
                ->whereIn('id', $ids)
                ->pluck('id')
                ->all();
            $ids = $validIds;
        }

        session(['gio_hang_selected_ids' => $ids]);

        return response()->json(['success' => true, 'selected' => $ids]);
    }

    /**
     * Lấy dữ liệu giỏ hàng cho Mini-Cart Drawer
     */
    public function getDrawerData()
    {
        if (!Auth::check()) {
            return response()->json([
                'logged_in'          => false,
                'items'              => [],
                'total_qty'          => 0,
                'total_items'        => 0,
                'subtotal'           => 0,
                'subtotal_formatted' => '0 ₫',
            ]);
        }

        $items = GioHang::with(['sanPham.category', 'bienThe.color', 'bienThe.size'])
            ->where('nguoi_dung_id', Auth::id())
            ->dangTrongGio()
            ->whereHas('sanPham', function ($q) {
                $q->where('trang_thai', true)
                  ->whereHas('danhMuc', function ($q2) {
                      $q2->where('trang_thai', 1);
                  });
            })
            ->whereHas('bienThe', function ($q) {
                $q->where('trang_thai', true);
            })
            ->whereNotNull('bien_the_id')
            ->orderBy('updated_at', 'desc')
            ->get();

        $formattedItems = [];
        $totalQty = 0;
        $subtotal = 0;

        foreach ($items as $item) {
            $item->syncGiaMoi();
            $item->thanh_tien = $item->so_luong * $item->don_gia;
            if ($item->isDirty()) {
                $item->save();
            }

            $sp = $item->sanPham;
            $bt = $item->bienThe;

            $imageUrl = asset('img/default-avatar.png');
            if ($sp && $sp->hinh_anh_chinh) {
                if (str_starts_with($sp->hinh_anh_chinh, 'http')) {
                    $imageUrl = $sp->hinh_anh_chinh;
                } elseif (str_starts_with($sp->hinh_anh_chinh, 'img/')) {
                    $imageUrl = asset($sp->hinh_anh_chinh);
                } else {
                    $imageUrl = asset('storage/' . $sp->hinh_anh_chinh);
                }
            }

            $formattedItems[] = [
                'id'           => $item->id,
                'san_pham_id'  => $item->san_pham_id,
                'name'         => $sp->ten_san_pham ?? 'Sản phẩm',
                'slug'         => $sp->slug ?? '',
                'url'          => $sp ? route('sanpham.chitiet', $sp->slug) : '#',
                'image'        => $imageUrl,
                'color'        => $bt && $bt->color ? $bt->color->ten_mau : null,
                'color_code'   => $bt && $bt->color ? $bt->color->ma_mau : null,
                'size'         => $bt && $bt->size ? $bt->size->ten_kich_thuoc : null,
                'so_luong'     => $item->so_luong,
                'don_gia'      => (float) $item->don_gia,
                'don_gia_formatted' => number_format($item->don_gia, 0, ',', '.') . ' ₫',
                'thanh_tien'   => (float) $item->thanh_tien,
                'thanh_tien_formatted' => number_format($item->thanh_tien, 0, ',', '.') . ' ₫',
                'max_stock'    => $bt ? (int) $bt->so_luong : 0,
            ];

            $totalQty += $item->so_luong;
            $subtotal += $item->thanh_tien;
        }

        return response()->json([
            'logged_in'          => true,
            'items'              => $formattedItems,
            'total_qty'          => $totalQty,
            'total_items'        => count($formattedItems),
            'subtotal'           => (float) $subtotal,
            'subtotal_formatted' => number_format($subtotal, 0, ',', '.') . ' ₫',
        ]);
    }

    /**
     * Xóa nhanh item trực tiếp từ Mini-Cart Drawer
     */
    public function quickRemove($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.'], 401);
        }

        $item = GioHang::where('id', $id)
            ->where('nguoi_dung_id', Auth::id())
            ->dangTrongGio()
            ->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ.'], 404);
        }

        $item->delete();

        $cartCount = GioHang::where('nguoi_dung_id', Auth::id())
            ->dangTrongGio()
            ->whereNotNull('bien_the_id')
            ->count();

        return response()->json([
            'success'    => true,
            'message'    => 'Đã xóa sản phẩm khỏi giỏ hàng.',
            'cart_count' => $cartCount,
        ]);
    }

    private function authorizeCartItem(GioHang $gioHang): void
    {
        if ($gioHang->nguoi_dung_id !== Auth::id()) {
            abort(403);
        }
        if ($gioHang->trang_thai !== GioHang::TRANG_THAI_DANG_TRONG_GIO) {
            abort(404);
        }
    }
}
