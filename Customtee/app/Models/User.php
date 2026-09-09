<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\BinhLuan;
use App\Notifications\ResetPasswordNotification;
use App\Traits\HasRolesAndPermissions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // app/Models/User.php
    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'password',
        'role',
    ];

    public function sendPasswordResetNotification($code): void
    {
        $this->notify(new ResetPasswordNotification($code));
    }

    public function gioHangs()
    {
        return $this->hasMany(GioHang::class, 'nguoi_dung_id');
    }

    public function binhLuans()
    {
        return $this->hasMany(BinhLuan::class);
    }
}
