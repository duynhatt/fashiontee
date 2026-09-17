<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HinhAnhSanPham extends Model
{
    protected $table = 'hinh_anh_san_phams';

    protected $fillable = [
        'san_pham_id',
        'mau_sac_id',
        'bien_the_id',
        'duong_dan',
        'thu_tu',
    ];

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function bienThe()
    {
        return $this->belongsTo(BienThe::class, 'bien_the_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (self $image) {
            if ($image->duong_dan) {
                Storage::disk('public')->delete($image->duong_dan);
            }
        });
    }
}
