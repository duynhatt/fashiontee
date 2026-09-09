<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    public static function booted()
    {
        static::saved(function (Role $role) {
            $role->clearUsersCache();
        });

        static::deleted(function (Role $role) {
            $role->clearUsersCache();
        });
    }

    /**
     * Clear cached permissions for all users assigned to this role.
     */
    public function clearUsersCache(): void
    {
        Cache::forget('all_system_roles');
        $userIds = $this->users()->pluck('users.id');
        foreach ($userIds as $id) {
            Cache::forget("user_{$id}_permissions");
            Cache::forget("user_{$id}_roles");
        }
    }

    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    /**
     * The permissions that belong to the role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Give permissions to role.
     */
    public function givePermissionTo(...$permissions): self
    {
        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                if (is_string($permission)) {
                    return Permission::where('name', $permission)->first();
                }
                return $permission;
            })
            ->filter();

        $this->permissions()->syncWithoutDetaching($permissions->pluck('id'));
        $this->clearUsersCache();

        return $this;
    }

    /**
     * Revoke permissions from role.
     */
    public function revokePermissionTo(...$permissions): self
    {
        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                if (is_string($permission)) {
                    return Permission::where('name', $permission)->first();
                }
                return $permission;
            })
            ->filter();

        $this->permissions()->detach($permissions->pluck('id'));
        $this->clearUsersCache();

        return $this;
    }

    /**
     * Sync permissions for role.
     */
    public function syncPermissions($permissions): self
    {
        $permissionIds = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                if (is_numeric($permission)) {
                    return (int) $permission;
                }
                if (is_string($permission)) {
                    $p = Permission::where('name', $permission)->first();
                    return $p ? $p->id : null;
                }
                if ($permission instanceof Permission) {
                    return $permission->id;
                }
                return null;
            })
            ->filter();

        $this->permissions()->sync($permissionIds);
        $this->clearUsersCache();

        return $this;
    }

    /**
     * Check if role has a permission.
     */
    public function hasPermissionTo(string $permission): bool
    {
        return $this->permissions->contains('name', $permission);
    }
}

