<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // 1. Super Admin bypass: toàn quyền truy cập
        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
                return true;
            }
        });

        // 2. Dynamic Gates đăng ký tự động theo Permissions trong Database (có cache)
        try {
            $permissionNames = Cache::remember('all_system_permissions', 86400, function () {
                return Permission::pluck('name')->toArray();
            });

            foreach ($permissionNames as $permissionName) {
                Gate::define($permissionName, function ($user) use ($permissionName) {
                    return method_exists($user, 'hasPermission') && $user->hasPermission($permissionName);
                });
            }
        } catch (\Throwable $e) {
            // Tránh lỗi khi chạy migration hoặc chưa kết nối DB
        }

        // 3. Custom Blade Directives
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('hasanyrole', function (...$roles) {
            return auth()->check() && auth()->user()->hasAnyRole($roles);
        });
    }
}
