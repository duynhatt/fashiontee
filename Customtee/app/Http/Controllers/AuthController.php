<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'status' => 1,
        ]);

        // Tự động gán vai trò customer cho user mới
        $user->assignRole('customer');

        return redirect('/login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập!');
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if (isset($user->status) && (int) $user->status === 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.',
                ])->withInput();
            }

            $request->session()->regenerate();

            if ($user->hasRole('super_admin') || $user->hasPermission('admin.access') || $user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công vào trang quản trị!');
            }

            return redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng',
        ])->withInput();
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $last = DB::table('password_reset_tokens')->where('email', $user->email)->first();
            $throttle = (int) config('auth.passwords.users.throttle', 60);

            if ($last?->created_at && Carbon::parse($last->created_at)->addSeconds($throttle)->isFuture()) {
                throw ValidationException::withMessages([
                    'email' => ['Vui lòng thử lại sau ít phút.'],
                ]);
            }

            $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => Hash::make($code),
                    'created_at' => now(),
                ]
            );

            $mailUser = (string) config('mail.mailers.smtp.username');
            $mailPass = (string) config('mail.mailers.smtp.password');
            $mailFrom = (string) config('mail.from.address');

            if (config('mail.default') === 'smtp' && ($mailUser === '' || $mailPass === '' || $mailFrom === '')) {
                DB::table('password_reset_tokens')->where('email', $user->email)->delete();

                throw ValidationException::withMessages([
                    'email' => ['Chưa cấu hình gửi Gmail. Điền MAIL_USERNAME (email Gmail), MAIL_PASSWORD (App Password 16 ký tự) và MAIL_FROM_ADDRESS (trùng email Gmail) trong file .env, rồi chạy php artisan config:clear.'],
                ]);
            }

            try {
                $user->sendPasswordResetNotification($code);
            } catch (\Throwable $e) {
                report($e);
                DB::table('password_reset_tokens')->where('email', $user->email)->delete();

                throw ValidationException::withMessages([
                    'email' => ['Không gửi được email. Kiểm tra App Password Gmail và MAIL_FROM_ADDRESS trong .env. Chi tiết: '.$e->getMessage()],
                ]);
            }
        }

        return redirect()
            ->route('password.reset', ['email' => $request->email])
            ->with('status', 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi mã xác nhận đặt lại mật khẩu.');
    }

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', [
            'email' => $request->query('email', old('email', '')),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        $expire = (int) config('auth.passwords.users.expire', 10);

        $expired = ! $record?->created_at
            || Carbon::parse($record->created_at)->addMinutes($expire)->isPast();

        if (! $record || $expired || ! Hash::check($request->code, $record->token)) {
            throw ValidationException::withMessages([
                'code' => ['Mã xác nhận không hợp lệ hoặc đã hết hạn.'],
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Mã xác nhận không hợp lệ hoặc đã hết hạn.'],
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công, vui lòng đăng nhập!');
    }
}
