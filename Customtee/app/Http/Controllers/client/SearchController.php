<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Gợi ý tìm kiếm nhanh (Live search / Auto-suggest)
     */
    public function suggest(Request $request)
    {
        $keyword = trim($request->input('q', ''));

        if (mb_strlen($keyword) < 1) {
            return response()->json([
                'success' => true,
                'keyword' => $keyword,
                'total'   => 0,
                'data'    => [],
            ]);
        }

        $query = SanPham::with([
            'category',
            'variants' => function ($q) {
                $q->where('trang_thai', true);
            }
        ])
        ->where('trang_thai', true)
        ->whereHas('danhMuc', function ($q) {
            $q->where('trang_thai', 1);
        })
        ->where(function ($q) use ($keyword) {
            $q->where('ten_san_pham', 'like', "%{$keyword}%")
              ->orWhere('mo_ta_ngan', 'like', "%{$keyword}%");
        });

        $total = (clone $query)->count();

        $products = $query->latest()
            ->take(6)
            ->get()
            ->map(function ($product) {
                $variants = $product->variants;
                $activePrices = $variants->map(function ($v) {
                    return $v->gia_khuyen_mai ?: $v->gia;
                })->filter()->values();

                $minPrice = $activePrices->min() ?? 0;
                $originalPrices = $variants->pluck('gia')->filter()->values();
                $minOriginalPrice = $originalPrices->min() ?? 0;

                // Kiểm tra xem có khuyến mãi không
                $hasDiscount = false;
                if ($variants->isNotEmpty()) {
                    $hasDiscount = $variants->contains(function ($v) {
                        return !empty($v->gia_khuyen_mai) && $v->gia_khuyen_mai < $v->gia;
                    });
                }

                // Xử lý đường dẫn ảnh
                $imageUrl = asset('img/default-avatar.png');
                if ($product->hinh_anh_chinh) {
                    if (str_starts_with($product->hinh_anh_chinh, 'http')) {
                        $imageUrl = $product->hinh_anh_chinh;
                    } elseif (str_starts_with($product->hinh_anh_chinh, 'img/')) {
                        $imageUrl = asset($product->hinh_anh_chinh);
                    } else {
                        $imageUrl = asset('storage/' . $product->hinh_anh_chinh);
                    }
                }

                return [
                    'id'               => $product->id,
                    'name'             => $product->ten_san_pham,
                    'slug'             => $product->slug,
                    'url'              => route('sanpham.chitiet', $product->slug),
                    'category_name'    => $product->category->ten_danh_muc ?? 'Thời trang',
                    'image'            => $imageUrl,
                    'price'            => (float) $minPrice,
                    'price_formatted'  => number_format($minPrice, 0, ',', '.') . ' ₫',
                    'original_price'   => (float) $minOriginalPrice,
                    'original_price_formatted' => number_format($minOriginalPrice, 0, ',', '.') . ' ₫',
                    'has_discount'     => $hasDiscount,
                ];
            });

        return response()->json([
            'success' => true,
            'keyword' => $keyword,
            'total'   => $total,
            'data'    => $products,
        ]);
    }
}
