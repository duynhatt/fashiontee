<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BinhLuan;
use Illuminate\Support\Str;

class SanPham extends Model
{
    use HasFactory;

    protected $table = 'san_phams';

    protected $fillable = [
        'danh_muc_id',
        'ten_san_pham',
        'slug',
        'mo_ta_ngan',
        'mo_ta_chi_tiet',
        'chat_lieu',
        'kieu_dang',
        'diem_noi_bat',
        'huong_dan_bao_quan',
        'hinh_anh_chinh',
        'trang_thai',
    ];

    protected $casts = [
        'trang_thai'        => 'boolean',
    ];

    public function danhMuc()
    {
        return $this->belongsTo(Category::class, 'danh_muc_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sanPham) {
            $sanPham->slug = Str::slug($sanPham->ten_san_pham);
        });

        static::updating(function ($sanPham) {
            if ($sanPham->isDirty('ten_san_pham')) {
                $sanPham->slug = Str::slug($sanPham->ten_san_pham);
            }
        });
    }
    public function variants()
{
    return $this->hasMany(BienThe::class, 'san_pham_id');
}

    public function allVariants()
    {
        return $this->hasMany(BienThe::class, 'san_pham_id');
    }

    public function images()
    {
        return $this->hasMany(HinhAnhSanPham::class, 'san_pham_id')->orderBy('thu_tu');
    }

public function category()
{
    return $this->belongsTo(Category::class, 'danh_muc_id');
}

    public function binhLuans()
    {
        return $this->hasMany(BinhLuan::class);
    }

}