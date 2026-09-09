<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait HasRolesAndPermissions
{
    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * Clear cached roles and permissions for this user.
     */
    public function clearPermissionCache(): void
    {
        Cache::forget("user_{$this->id}_roles");
        Cache::forget("user_{$this->id}_permissions");
    }

    /**
     * Assign role(s) to user.
     */
    public function assignRole(...$roles): self
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                if (is_string($role)) {
                    return Role::where('name', $role)->first();
                }
                if (is_numeric($role)) {
                    return Role::find($role);
                }
                return $role;
            })
            ->filter();

        $this->roles()->syncWithoutDetaching($roles->pluck('id'));
        $this->clearPermissionCache();

        return $this;
    }

    /**
     * Remove role(s) from user.
     */
    public function removeRole(...$roles): self
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                if (is_string($role)) {
                    return Role::where('name', $role)->first();
                }
                if (is_numeric($role)) {
                    return Role::find($role);
                }
                return $role;
            })
            ->filter();

        $this->roles()->detach($roles->pluck('id'));
        $this->clearPermissionCache();

        return $this;
    }

    /**
     * Sync roles for user.
     */
    public function syncRoles($roles): self
    {
        $roleIds = collect($roles)
            ->flatten()
            ->map(function ($role) {
                if (is_numeric($role)) {
                    return (int) $role;
                }
                if (is_string($role)) {
                    $r = Role::where('name', $role)->first();
                    return $r ? $r->id : null;
                }
                if ($role instanceof Role) {
                    return $role->id;
                }
                return null;
            })
            ->filter();

        $this->roles()->sync($roleIds);
        $this->clearPermissionCache();

        return $this;
    }

    /**
     * Check if user has role.
     *
     * @param string|array|Collection $roles
     */
    public function hasRole($roles): bool
    {
        $userRoles = Cache::remember("user_{$this->id}_roles", 3600, function () {
            return $this->roles()->pluck('name')->toArray();
        });

        if (is_string($roles)) {
            return in_array($roles, $userRoles);
        }

        if (is_array($roles) || $roles instanceof Collection) {
            foreach ($roles as $role) {
                if (in_array($role, $userRoles)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Check if user has all of the given roles.
     */
    public function hasAllRoles(array $roles): bool
    {
        $userRoles = Cache::remember("user_{$this->id}_roles", 3600, function () {
            return $this->roles()->pluck('name')->toArray();
        });

        foreach ($roles as $role) {
            if (!in_array($role, $userRoles)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get all permissions assigned to user through roles.
     */
    public function getAllPermissions(): Collection
    {
        $permissionNames = Cache::remember("user_{$this->id}_permissions", 3600, function () {
            return $this->roles()
                ->with('permissions')
                ->get()
                ->pluck('permissions')
                ->flatten()
                ->pluck('name')
                ->unique()
                ->values()
                ->toArray();
        });

        return collect($permissionNames);
    }

    /**
     * Check if user has permission.
     */
    public function hasPermission(string $permission): bool
    {
        // super_admin always has all permissions
        if ($this->hasRole('super_admin')) {
            return true;
        }

        $userPermissions = Cache::remember("user_{$this->id}_permissions", 3600, function () {
            return $this->roles()
                ->with('permissions')
                ->get()
                ->pluck('permissions')
                ->flatten()
                ->pluck('name')
                ->unique()
                ->values()
                ->toArray();
        });

        return in_array($permission, $userPermissions);
    }
}

