<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BienThe extends Model
{
    protected $table = 'bien_thes';

    protected $fillable = [
        'san_pham_id',
        'mau_sac_id',
        'kich_thuoc_id',
        'gia',
        'gia_khuyen_mai',
        'so_luong',
        'trang_thai',
    ];

    public function product()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function color()
    {
        return $this->belongsTo(MauSac::class, 'mau_sac_id');
    }

    public function size()
    {
        return $this->belongsTo(KichThuoc::class, 'kich_thuoc_id');
    }

    public function images()
    {
        return $this->hasMany(HinhAnhSanPham::class, 'bien_the_id')->orderBy('thu_tu');
    }

    protected static function booted(): void
    {
        static::deleting(function (self $variant) {
            $variant->images()->get()->each->delete();
        });
    }
    public function SanPham()
{
    return $this->belongsTo(SanPham::class, 'san_pham_id');
}

}
