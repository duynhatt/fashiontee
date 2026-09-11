<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'danh_mucs';

    protected $fillable = [
        'parent_id',
        'ten_danh_muc',
        'slug',
        'mo_ta',
        'hinh_anh',
        'trang_thai',
    ];

    protected $casts = [
        'parent_id'  => 'integer',
        'trang_thai' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'danh_muc_id');
    }

    public function scopeHienThi($query)
    {
        return $query->where('trang_thai', 1);
    }

    /**
     * Lấy toàn bộ ID của các danh mục con, cháu, chắt... (đệ quy)
     */
    public function getAllChildrenIds(): array
    {
        $ids = [];
        $children = $this->children()->get();
        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }
        return $ids;
    }

    /**
     * Lấy danh sách chuỗi danh mục cha ông (Ancestors) từ gốc đến cha trực tiếp
     */
    public function getAncestors(): \Illuminate\Support\Collection
    {
        $ancestors = collect();
        $current = $this->parent;
        $visited = [];

        while ($current && !in_array($current->id, $visited)) {
            $visited[] = $current->id;
            $ancestors->prepend($current);
            $current = $current->parent;
        }

        return $ancestors;
    }

    /**
     * Lấy danh sách phẳng có thụt lề phục vụ dropdown <select>
     * Duyệt trong bộ nhớ (chỉ tốn 1 query duy nhất)
     */
    public static function getFlatTree($excludeId = null, $onlyActive = false): array
    {
        $query = static::query();
        if ($onlyActive) {
            $query->where('trang_thai', 1);
        }
        $categories = $query->orderBy('ten_danh_muc', 'asc')->get();

        // Nếu có excludeId, tìm và loại bỏ excludeId cùng toàn bộ con cháu của nó
        $excludedIds = [];
        if ($excludeId) {
            $excludedIds[] = (int) $excludeId;
            $findDescendants = function ($parentId) use (&$findDescendants, &$excludedIds, $categories) {
                foreach ($categories as $cat) {
                    if ((int) $cat->parent_id === (int) $parentId) {
                        $excludedIds[] = (int) $cat->id;
                        $findDescendants($cat->id);
                    }
                }
            };
            $findDescendants($excludeId);
        }

        // Nhóm theo parent_id
        $grouped = [];
        foreach ($categories as $cat) {
            if (in_array((int) $cat->id, $excludedIds, true)) {
                continue;
            }
            $pId = $cat->parent_id ? (int) $cat->parent_id : 0;
            $grouped[$pId][] = $cat;
        }

        $result = [];
        $buildFlat = function ($parentId, $depth) use (&$buildFlat, &$grouped, &$result) {
            if (empty($grouped[$parentId])) {
                return;
            }
            foreach ($grouped[$parentId] as $cat) {
                $prefix = $depth > 0 ? str_repeat('— ', $depth) : '';
                $cat->depth = $depth;
                $cat->display_name = $prefix . $cat->ten_danh_muc;
                $result[] = $cat;
                $buildFlat($cat->id, $depth + 1);
            }
        };

        $buildFlat(0, 0);

        return $result;
    }

    /**
     * Lấy cây phân cấp lồng nhau (Nested Tree)
     */
    public static function getNestedTree($onlyActive = false)
    {
        $query = static::query();
        if ($onlyActive) {
            $query->where('trang_thai', 1);
        }
        $categories = $query->orderBy('ten_danh_muc', 'asc')->get();

        $grouped = [];
        foreach ($categories as $cat) {
            $pId = $cat->parent_id ? (int) $cat->parent_id : 0;
            $grouped[$pId][] = $cat;
        }

        $buildTree = function ($parentId) use (&$buildTree, &$grouped) {
            $branch = [];
            if (!empty($grouped[$parentId])) {
                foreach ($grouped[$parentId] as $cat) {
                    $cat->sub_categories = $buildTree($cat->id);
                    $branch[] = $cat;
                }
            }
            return $branch;
        };

        return $buildTree(0);
    }
}

