<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $all = Category::with(['parent'])->withCount(['sanPhams', 'children'])->get();
        
        $rootQuery = Category::with(['parent'])->withCount(['sanPhams', 'children'])->whereNull('parent_id');

        if ($request->keyword) {
            $keyword = $request->keyword;
            // Tìm root có tên khớp HOẶC có con cháu khớp tên
            $matchingIds = Category::where('ten_danh_muc', 'like', '%' . $keyword . '%')->pluck('id')->toArray();
            
            $rootIds = [];
            foreach ($matchingIds as $mId) {
                $cat = $all->firstWhere('id', $mId);
                if ($cat) {
                    $ancestors = $cat->getAncestors();
                    if ($ancestors->isNotEmpty()) {
                        $rootIds[] = $ancestors->first()->id;
                    } else {
                        $rootIds[] = $cat->id;
                    }
                }
            }
            $rootQuery->whereIn('id', array_unique($rootIds));
        }

        if ($request->trang_thai !== null && $request->trang_thai !== '') {
            $rootQuery->where('trang_thai', $request->trang_thai);
        }

        $danhMucs = $rootQuery->orderBy('id', 'desc')->get();

        // Nhóm tất cả danh mục theo parent_id để tạo danh sách con cháu (N cấp)
        $grouped = [];
        foreach ($all as $cat) {
            $pId = $cat->parent_id ? (int) $cat->parent_id : 0;
            $grouped[$pId][] = $cat;
        }

        // Gán danh sách con cháu vào mỗi danh mục gốc
        foreach ($danhMucs as $root) {
            $descendants = [];
            $traverse = function ($parentId, $depth) use (&$traverse, &$grouped, &$descendants) {
                if (empty($grouped[$parentId])) {
                    return;
                }
                foreach ($grouped[$parentId] as $child) {
                    $child->depth = $depth;
                    $descendants[] = $child;
                    $traverse($child->id, $depth + 1);
                }
            };
            $traverse($root->id, 1);
            $root->descendants_list = $descendants;
        }

        $totalRoots = $danhMucs->count();
        $totalCategories = $all->count();
        $totalSubcategories = $all->whereNotNull('parent_id')->count();
        $parentCategories = Category::getFlatTree();

        return view('admin.Category.list', compact('danhMucs', 'parentCategories', 'totalRoots', 'totalCategories', 'totalSubcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255|unique:danh_mucs,ten_danh_muc',
            'parent_id'    => 'nullable|exists:danh_mucs,id',
            'mo_ta'        => 'nullable|string|max:1000',
            'hinh_anh'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'trang_thai'   => 'required|in:0,1',
        ], [
            'ten_danh_muc.required' => 'Vui lòng nhập tên danh mục.',
            'ten_danh_muc.max'      => 'Tên danh mục không được quá 255 ký tự.',
            'ten_danh_muc.unique'   => 'Tên danh mục này đã tồn tại.',
            'parent_id.exists'      => 'Danh mục cha được chọn không tồn tại.',
            'mo_ta.max'             => 'Mô tả không được quá 1000 ký tự.',
            'hinh_anh.image'        => 'Ảnh danh mục không hợp lệ.',
            'trang_thai.required'   => 'Vui lòng chọn trạng thái.',
            'trang_thai.in'         => 'Trạng thái không hợp lệ.',
        ]);

        $parentId = $request->filled('parent_id') ? (int) $request->parent_id : null;

        $data = [
            'parent_id'    => $parentId,
            'ten_danh_muc' => $request->ten_danh_muc,
            'slug'         => Str::slug($request->ten_danh_muc),
            'mo_ta'        => $request->mo_ta,
            'trang_thai'   => $request->trang_thai,
        ];

        if ($request->hasFile('hinh_anh')) {
            $data['hinh_anh'] = $request->file('hinh_anh')->store('categories', 'public');
        }

        Category::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Thêm danh mục thành công',
        ]);
    }

    public function show($id)
    {
        $danhMuc = Category::with('parent')->findOrFail($id);
        $availableParents = Category::getFlatTree($id);

        return response()->json([
            'status'            => true,
            'data'              => $danhMuc,
            'available_parents' => $availableParents,
        ]);
    }

    public function update(Request $request, $id)
    {
        $danhMuc = Category::findOrFail($id);

        $request->validate([
            'ten_danh_muc' => 'required|string|max:255|unique:danh_mucs,ten_danh_muc,' . $id,
            'parent_id'    => 'nullable|exists:danh_mucs,id',
            'mo_ta'        => 'nullable|string|max:1000',
            'hinh_anh'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'trang_thai'   => 'required|in:0,1',
        ], [
            'ten_danh_muc.required' => 'Vui lòng nhập tên danh mục.',
            'ten_danh_muc.max'      => 'Tên danh mục không được quá 255 ký tự.',
            'ten_danh_muc.unique'   => 'Tên danh mục này đã tồn tại.',
            'parent_id.exists'      => 'Danh mục cha được chọn không tồn tại.',
            'mo_ta.max'             => 'Mô tả không được quá 1000 ký tự.',
            'hinh_anh.image'        => 'Ảnh danh mục không hợp lệ.',
            'trang_thai.required'   => 'Vui lòng chọn trạng thái.',
            'trang_thai.in'         => 'Trạng thái không hợp lệ.',
        ]);

        $parentId = $request->filled('parent_id') ? (int) $request->parent_id : null;

        // Chống vòng lặp phân cấp (Cycle Detection)
        if ($parentId !== null) {
            // 1. Không được chọn chính nó
            if ($parentId === (int) $id) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Danh mục không thể chọn chính nó làm danh mục cha.',
                ], 422);
            }

            // 2. Không được chọn bất kỳ con cháu nào trong nhánh làm cha
            $descendantIds = $danhMuc->getAllChildrenIds();
            if (in_array($parentId, $descendantIds, true)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Không thể chọn danh mục con cháu trong cùng nhánh làm danh mục cha (tránh vòng lặp vô hạn).',
                ], 422);
            }
        }

        $danhMuc->update([
            'parent_id'    => $parentId,
            'ten_danh_muc' => $request->ten_danh_muc,
            'slug'         => Str::slug($request->ten_danh_muc),
            'mo_ta'        => $request->mo_ta,
            'trang_thai'   => $request->trang_thai,
        ]);

        if ($request->hasFile('hinh_anh')) {
            if ($danhMuc->hinh_anh) {
                Storage::disk('public')->delete($danhMuc->hinh_anh);
            }
            $danhMuc->hinh_anh = $request->file('hinh_anh')->store('categories', 'public');
            $danhMuc->save();
        }

        return response()->json([
            'status'  => true,
            'message' => 'Cập nhật danh mục thành công',
        ]);
    }

    public function destroy($id)
    {
        $danhMuc = Category::withCount(['sanPhams', 'children'])->findOrFail($id);

        if ($danhMuc->san_phams_count > 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Không thể xóa danh mục đang có sản phẩm. Vui lòng xóa hoặc chuyển sản phẩm sang danh mục khác trước.',
            ], 422);
        }

        if ($danhMuc->children_count > 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Không thể xóa danh mục đang có danh mục con. Vui lòng xóa hoặc chuyển các danh mục con sang danh mục khác trước.',
            ], 422);
        }

        if ($danhMuc->hinh_anh) {
            Storage::disk('public')->delete($danhMuc->hinh_anh);
        }

        $danhMuc->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Xóa danh mục thành công',
        ]);
    }
}
