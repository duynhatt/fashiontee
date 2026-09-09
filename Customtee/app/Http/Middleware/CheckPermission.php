<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = Auth::user();

        // Tài khoản bị khóa
        if (isset($user->status) && (int) $user->status === 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
        }

        // Kiểm tra quyền
        if ($user->hasRole('super_admin') || $user->hasPermission($permission)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này!'
            ], 403);
        }

        // Web request: redirect về trang trước kèm flash alert
        $previousUrl = url()->previous();
        $currentUrl = $request->fullUrl();

        if ($previousUrl && $previousUrl !== $currentUrl) {
            return redirect()->back()->with('error', 'Bạn không có quyền thực hiện hành động này!');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Bạn không có quyền thực hiện hành động này!');
    }
}

