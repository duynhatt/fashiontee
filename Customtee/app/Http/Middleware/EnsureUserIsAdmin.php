<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = Auth::user();

        // Kiểm tra tài khoản có bị khóa không
        if (isset($user->status) && (int) $user->status === 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
        }

        // Kiểm tra quyền truy cập Admin (hoặc fallback role === admin)
        if ($user->hasPermission('admin.access') || $user->hasRole('super_admin') || $user->role === 'admin') {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập vào khu vực quản trị.'
            ], 403);
        }

        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào khu vực quản trị.');
    }
}
