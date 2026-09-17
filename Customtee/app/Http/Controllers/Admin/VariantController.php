<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BienThe;
use App\Models\HinhAnhSanPham;
use App\Models\KichThuoc;
use App\Models\MauSac;
use App\Models\SanPham;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class VariantController extends Controller

{
public function index(Request $request)
{
    $selectedProductId = $request->get('san_pham_id');

    // Data cho dropdown lọc
    $colors = MauSac::orderBy('ten_mau')->get();
    $sizes = KichThuoc::orderBy('ten_kich_thuoc')->get();

    // Tham số lọc biến thể
    $mauSacId = $request->query('mau_sac_id');
    $kichThuocId = $request->query('kich_thuoc_id');
    $trangThai = $request->query('trang_thai'); // 0/1

    $khoFilter = $request->query('kho_filter', 'all'); // all | het_hang | gan_het
    $khoMin = $request->query('kho_min');
    $khoMax = $request->query('kho_max');
    $kmFilter = $request->query('km_filter', 'all'); // all | dang_giam
    $giaMin = $request->query('gia_min');
    $giaMax = $request->query('gia_max');

    $hasVariantFilters = !empty($mauSacId)
        || !empty($kichThuocId)
        || ($trangThai !== null && $trangThai !== '')
        || $khoFilter !== 'all'
        || ($kmFilter !== 'all')
        || ($khoMin !== null && $khoMin !== '')
        || ($khoMax !== null && $khoMax !== '')
        || ($giaMin !== null && $giaMin !== '')
        || ($giaMax !== null && $giaMax !== '');

    $applyVariantFilters = function ($q) use (
        $mauSacId,
        $kichThuocId,
        $trangThai,
        $khoFilter,
        $khoMin,
        $khoMax,
        $kmFilter,
        $giaMin,
        $giaMax
    ) {
        if (!empty($mauSacId)) {
            $q->where('mau_sac_id', $mauSacId);
        }

        if (!empty($kichThuocId)) {
            $q->where('kich_thuoc_id', $kichThuocId);
        }

        if ($trangThai !== null && $trangThai !== '') {
            // trang_thai boolean lưu 0/1
            if (in_array((string) $trangThai, ['0', '1'], true)) {
                $q->where('trang_thai', (int) $trangThai);
            }
        }

        // Lọc biến thể đang giảm giá
        if ($kmFilter === 'dang_giam') {
            $q->whereNotNull('gia_khuyen_mai')
                ->whereColumn('gia_khuyen_mai', '<', 'gia');
        }

        // Lọc kho theo so_luong
        if ($khoFilter === 'het_hang') {
            $q->where('so_luong', '=', 0);
        } elseif ($khoFilter === 'gan_het') {
            $q->where('so_luong', '<', 10);
        }

        if ($khoMin !== null && $khoMin !== '' && is_numeric($khoMin)) {
            $q->where('so_luong', '>=', (int) $khoMin);
        }

        if ($khoMax !== null && $khoMax !== '' && is_numeric($khoMax)) {
            $q->where('so_luong', '<=', (int) $khoMax);
        }

        // Lọc giá theo đúng cột "Giá" đang hiển thị trong bảng admin: gia
        if ($giaMin !== null && $giaMin !== '' && is_numeric($giaMin)) {
            $q->where('gia', '>=', (float) $giaMin);
        }

        if ($giaMax !== null && $giaMax !== '' && is_numeric($giaMax)) {
            $q->where('gia', '<=', (float) $giaMax);
        }
    };

    $sanPhamsQuery = SanPham::with([
        'danhMuc',
        'variants' => function ($q) use ($applyVariantFilters) {
            $applyVariantFilters($q);
            $q->with(['color', 'size'])->latest();
        }
    ]);

    if (!empty($selectedProductId)) {
        $sanPhamsQuery->where('id', $selectedProductId);
    }

    // Nếu đang lọc theo 1 sản phẩm cụ thể (`san_pham_id` có mặt) thì KHÔNG loại sản phẩm khỏi danh sách.
    // Khi đó, các điều kiện lọc chỉ áp vào `variants` (quan hệ), và nếu không match thì phần bảng sẽ rỗng.
    // Nếu KHÔNG chọn sản phẩm cụ thể thì mới ràng buộc để chỉ lấy sản phẩm có ít nhất 1 biến thể match.
    $sanPhamsQuery->when($hasVariantFilters && empty($selectedProductId), function ($q) use ($applyVariantFilters) {
        $q->whereHas('variants', function ($inner) use ($applyVariantFilters) {
            $applyVariantFilters($inner);
        });
    });

    $sanPhams = $sanPhamsQuery
        ->orderBy('ten_san_pham')
        ->get();

    return view('admin.variants.index', compact('sanPhams', 'selectedProductId', 'colors', 'sizes', 'hasVariantFilters'));








}

public function create(Request $request)
{
    $products = SanPham::orderBy('ten_san_pham')->get();
    $colors   = MauSac::all();
    $sizes    = KichThuoc::all();
    $selectedProductId = $request->get('san_pham_id');

    return view('admin.variants.create', compact('products', 'colors', 'sizes', 'selectedProductId'));
}





public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'san_pham_id'               => 'required|exists:san_phams,id',
        'variants'                  => 'required|array|min:1',
        'variants.*.mau_sac_id'     => 'required|exists:mau_sacs,id',
        'variants.*.kich_thuoc_id'  => 'required|exists:kich_thuocs,id',
        'variants.*.gia'            => 'required|numeric|min:0|max:999999999999',
        'variants.*.gia_khuyen_mai' => 'nullable|numeric|min:0|max:999999999999',
        'variants.*.so_luong'       => 'required|integer|min:0',
        'variants.*.trang_thai'     => 'nullable|in:0,1',
        'variants.*.images'         => 'nullable|array',
        'variants.*.images.*'       => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'color_images'              => 'nullable|array',
        'color_images.*'            => 'array',
        'color_images.*.*'          => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
    ], [
        'variants.*.gia.min'            => 'Giá không được âm.',
        'variants.*.gia.max'            => 'Giá vượt quá giới hạn cho phép.',
        'variants.*.gia_khuyen_mai.min' => 'Giá khuyến mãi không được âm.',
        'variants.*.so_luong.min'       => 'Số lượng không được âm.',
        'variants.*.trang_thai.in'      => 'Trạng thái không hợp lệ.',
    ]);

    $validator->after(function ($validator) use ($request) {
        $variants = $request->input('variants', []);
        $sanPhamId = $request->input('san_pham_id');

        $seen = [];
        foreach ($variants as $index => $variant) {
            $mau = $variant['mau_sac_id'] ?? null;
            $kich = $variant['kich_thuoc_id'] ?? null;
            $gia = $variant['gia'] ?? null;
            $giaKm = $variant['gia_khuyen_mai'] ?? null;

            if ($giaKm !== null && $gia !== null && $giaKm > $gia) {
                $validator->errors()->add("variants.$index.gia_khuyen_mai", 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.');
            }

            if ($mau !== null && $kich !== null) {
                $key = $mau . '-' . $kich;
                if (isset($seen[$key])) {
                    $validator->errors()->add("variants.$index.mau_sac_id", 'Không được trùng biến thể trong danh sách thêm mới.');
                }
                $seen[$key] = true;
            }
        }

        if ($sanPhamId) {
            $existing = BienThe::where('san_pham_id', $sanPhamId)
                ->get(['mau_sac_id', 'kich_thuoc_id'])
                ->map(function ($item) {
                    return $item->mau_sac_id . '-' . $item->kich_thuoc_id;
                })
                ->flip();

            foreach ($variants as $index => $variant) {
                $mau = $variant['mau_sac_id'] ?? null;
                $kich = $variant['kich_thuoc_id'] ?? null;
                if ($mau !== null && $kich !== null) {
                    $key = $mau . '-' . $kich;
                    if ($existing->has($key)) {
                        $validator->errors()->add("variants.$index.mau_sac_id", 'Biến thể màu + size này đã tồn tại cho sản phẩm.');
                    }
                }
            }
        }
    });

    $validated = $validator->validate();

    foreach ($validated['variants'] as $index => $variant) {
        $bienThe = BienThe::create([
            'san_pham_id'    => $validated['san_pham_id'],
            'mau_sac_id'     => $variant['mau_sac_id'],
            'kich_thuoc_id'  => $variant['kich_thuoc_id'],
            'gia'            => $variant['gia'],
            'gia_khuyen_mai' => $variant['gia_khuyen_mai'] ?? null,
            'so_luong'       => $variant['so_luong'],
            'trang_thai'     => $variant['trang_thai'] ?? 1,
        ]);

        foreach ($request->file("variants.$index.images", []) as $image) {
            HinhAnhSanPham::create([
                'san_pham_id' => $bienThe->san_pham_id,
                'mau_sac_id' => $bienThe->mau_sac_id,
                // Product images are shared by every size of the same color.
                'bien_the_id' => null,
                'duong_dan' => $image->store('san-pham/variants', 'public'),
                'thu_tu' => HinhAnhSanPham::where('san_pham_id', $bienThe->san_pham_id)
                    ->where('mau_sac_id', $bienThe->mau_sac_id)
                    ->count(),
            ]);
        }
    }

    $this->storeColorImages($request, $validated['san_pham_id']);

    return redirect()
        ->route('variants.create', ['san_pham_id' => $validated['san_pham_id']])
        ->with('success', 'Thêm biến thể thành công');
}


public function edit($id)
{
    $variant = BienThe::findOrFail($id);
    $product = SanPham::with([
        'variants' => function ($q) {
            $q->with(['color', 'size', 'images'])->orderBy('id');
        },
        'images',
        'category'
    ])->findOrFail($variant->san_pham_id);
    $products = SanPham::all();
    $colors = MauSac::all();
    $sizes = KichThuoc::all();

    return view('admin.variants.edit', compact('variant','product','products','colors','sizes'));
}




public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'san_pham_id'               => 'required|exists:san_phams,id',
        'variants'                  => 'required|array|min:1',
        'variants.*.id'             => 'required|exists:bien_thes,id',
        'variants.*.mau_sac_id'     => 'required|exists:mau_sacs,id',
        'variants.*.kich_thuoc_id'  => 'required|exists:kich_thuocs,id',
        'variants.*.gia'            => 'required|numeric|min:0|max:999999999999',
        'variants.*.gia_khuyen_mai' => 'nullable|numeric|min:0|max:999999999999',
        'variants.*.so_luong'       => 'required|integer|min:0',
        'variants.*.trang_thai'     => 'nullable|in:0,1',
        'variants.*.images'         => 'nullable|array',
        'variants.*.images.*'       => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'color_images'              => 'nullable|array',
        'color_images.*'            => 'array',
        'color_images.*.*'          => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'variants_to_delete'        => 'nullable|array',
        'variants_to_delete.*'      => 'integer|exists:bien_thes,id',
    ], [
        'variants.*.gia.min'            => 'Giá không được âm.',
        'variants.*.gia.max'            => 'Giá vượt quá giới hạn cho phép.',
        'variants.*.gia_khuyen_mai.min' => 'Giá khuyến mãi không được âm.',
        'variants.*.so_luong.min'       => 'Số lượng không được âm.',
        'variants.*.trang_thai.in'      => 'Trạng thái không hợp lệ.',
    ]);

    $validator->after(function ($validator) use ($request) {
        $variants = $request->input('variants', []);
        $sanPhamId = $request->input('san_pham_id');
        $ids = collect($variants)->pluck('id')->filter()->values();

        $seen = [];
        foreach ($variants as $index => $variant) {
            $mau = $variant['mau_sac_id'] ?? null;
            $kich = $variant['kich_thuoc_id'] ?? null;
            $gia = $variant['gia'] ?? null;
            $giaKm = $variant['gia_khuyen_mai'] ?? null;

            if ($giaKm !== null && $gia !== null && $giaKm > $gia) {
                $validator->errors()->add("variants.$index.gia_khuyen_mai", 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.');
            }

            if ($mau !== null && $kich !== null) {
                $key = $mau . '-' . $kich;
                if (isset($seen[$key])) {
                    $validator->errors()->add("variants.$index.mau_sac_id", 'Không được trùng biến thể trong danh sách cập nhật.');
                }
                $seen[$key] = true;
            }
        }

        if ($sanPhamId && $ids->isNotEmpty()) {
            $validIds = BienThe::where('san_pham_id', $sanPhamId)
                ->whereIn('id', $ids)
                ->pluck('id')
                ->flip();

            foreach ($variants as $index => $variant) {
                $id = $variant['id'] ?? null;
                if ($id && !$validIds->has($id)) {
                    $validator->errors()->add("variants.$index.id", 'Biến thể không thuộc sản phẩm này.');
                }
            }
        }

        if ($sanPhamId) {
            $existing = BienThe::where('san_pham_id', $sanPhamId)
                ->when($ids->isNotEmpty(), function ($q) use ($ids) {
                    $q->whereNotIn('id', $ids);
                })
                ->get(['mau_sac_id', 'kich_thuoc_id'])
                ->map(function ($item) {
                    return $item->mau_sac_id . '-' . $item->kich_thuoc_id;
                })
                ->flip();

            foreach ($variants as $index => $variant) {
                $mau = $variant['mau_sac_id'] ?? null;
                $kich = $variant['kich_thuoc_id'] ?? null;
                if ($mau !== null && $kich !== null) {
                    $key = $mau . '-' . $kich;
                    if ($existing->has($key)) {
                        $validator->errors()->add("variants.$index.mau_sac_id", 'Biến thể màu + size này đã tồn tại cho sản phẩm.');
                    }
                }
            }
        }
    });

    $validated = $validator->validate();
    $sanPhamId = $validated['san_pham_id'];

    foreach ($validated['variants'] as $index => $variantData) {
        $bienThe = BienThe::where('id', $variantData['id'])
            ->where('san_pham_id', $sanPhamId)
            ->firstOrFail();
        $oldColorId = $bienThe->mau_sac_id;
        $bienThe->update([
            'san_pham_id'    => $sanPhamId,
            'mau_sac_id'     => $variantData['mau_sac_id'],
            'kich_thuoc_id'  => $variantData['kich_thuoc_id'],
            'gia'            => $variantData['gia'],
            'gia_khuyen_mai' => $variantData['gia_khuyen_mai'] ?? null,
            'so_luong'       => $variantData['so_luong'],
            'trang_thai'     => $variantData['trang_thai'] ?? 1,
        ]);

        foreach ($request->file("variants.$index.images", []) as $image) {
            HinhAnhSanPham::create([
                'san_pham_id' => $sanPhamId,
                'mau_sac_id' => $bienThe->mau_sac_id,
                // Product images are shared by every size of the same color.
                'bien_the_id' => null,
                'duong_dan' => $image->store('san-pham/variants', 'public'),
                'thu_tu' => HinhAnhSanPham::where('san_pham_id', $sanPhamId)
                    ->where('mau_sac_id', $bienThe->mau_sac_id)
                    ->count(),
            ]);
        }

        if ((string) $oldColorId !== (string) $bienThe->mau_sac_id) {
            $this->cleanupColorImages($sanPhamId, $oldColorId);
        }
    }

    $this->storeColorImages($request, $sanPhamId);

    $deleteIds = collect($validated['variants_to_delete'] ?? [])->unique()->values();
    if ($deleteIds->isNotEmpty()) {
        $variantsToDelete = BienThe::where('san_pham_id', $sanPhamId)
            ->whereIn('id', $deleteIds)
            ->with('images')
            ->get();

        $variantsToDelete->each(function (BienThe $variant) {
            $variant->images->each->delete();
            $variant->delete();
        });

        $variantsToDelete->pluck('mau_sac_id')->unique()->each(function ($colorId) use ($sanPhamId) {
            $this->cleanupColorImages($sanPhamId, $colorId);
        });
    }

    return redirect()
        ->route('variants.edit', $id)
        ->with('success', 'Cập nhật biến thể thành công');
}


public function destroy($id)
{
    $variant = BienThe::findOrFail($id);
    $sanPhamId = $variant->san_pham_id;
    $colorId = $variant->mau_sac_id;
    $variant->load('images');
    $variant->images->each->delete();
    $variant->delete();
    $this->cleanupColorImages($sanPhamId, $colorId);

    return redirect()->back()
        ->with('success', 'Đã xoá biến thể');
}

private function cleanupColorImages(int $sanPhamId, ?int $colorId): void
{
    if (!$colorId || BienThe::where('san_pham_id', $sanPhamId)->where('mau_sac_id', $colorId)->exists()) {
        return;
    }

    HinhAnhSanPham::where('san_pham_id', $sanPhamId)
        ->where('mau_sac_id', $colorId)
        ->whereNull('bien_the_id')
        ->get()
        ->each
        ->delete();
}

private function storeColorImages(Request $request, int $sanPhamId): void
{
    foreach ($request->file('color_images', []) as $colorId => $images) {
        if (!BienThe::where('san_pham_id', $sanPhamId)->where('mau_sac_id', $colorId)->exists()) {
            continue;
        }
        foreach ($images as $image) {
            HinhAnhSanPham::create([
                'san_pham_id' => $sanPhamId,
                'mau_sac_id' => $colorId,
                'bien_the_id' => null,
                'duong_dan' => $image->store('san-pham/variants', 'public'),
                'thu_tu' => HinhAnhSanPham::where('san_pham_id', $sanPhamId)
                    ->where('mau_sac_id', $colorId)->count(),
            ]);
        }
    }
}

public function destroyImage($id)
{
    $image = HinhAnhSanPham::findOrFail($id);
    $image->delete();

    return response()->json(['status' => true, 'message' => 'Đã xóa ảnh biến thể']);
}



}
