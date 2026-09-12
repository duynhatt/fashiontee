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
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            if (is_null($existingUser->email_verified_at)) {
                return back()->withErrors([
                    'email' => 'Email này đã được đăng ký nhưng chưa xác thực tài khoản.',
                ])->withInput()->with('unverified_email', $existingUser->email);
            }

            return back()->withErrors([
                'email' => 'Email này đã được sử dụng.',
            ])->withInput();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'status' => 1,
            'email_verified_at' => null,
        ]);

        // Tự động gán vai trò customer cho user mới
        $user->assignRole('customer');

        return redirect('/login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập!');
        // Sinh mã OTP 6 số
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('email_verification_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
            ]
        );

        \Illuminate\Support\Facades\Log::info("FashionTee OTP verification code for [{$user->email}]: {$code}");

        try {
            $user->sendEmailVerificationOtpNotification($code);
        } catch (\Throwable $e) {
            report($e);
            // Xóa user tạm nếu gửi mail thất bại để tránh tài khoản rác không thể kích hoạt
            $user->roles()->detach();
            $user->delete();
            DB::table('email_verification_tokens')->where('email', $request->email)->delete();

            throw ValidationException::withMessages([
                'email' => ['Không gửi được email xác thực. Vui lòng kiểm tra lại địa chỉ email hoặc kết nối mạng: ' . $e->getMessage()],
            ]);
        }

        return redirect()->route('verification.notice', ['email' => $user->email])
            ->with('status', 'Mã xác thực OTP gồm 6 chữ số đã được gửi tới email của bạn. Vui lòng kiểm tra hộp thư (hoặc mục Spam).');
    }

    // Hiển thị form xác thực email
    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email', old('email', session('unverified_email', '')));
        return view('auth.verify-email', compact('email'));
    }

    // Xử lý xác thực email với mã OTP
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|digits:6',
        ]);

        $record = DB::table('email_verification_tokens')->where('email', $request->email)->first();
        $expire = 5; // Hiệu lực trong 5 phút

        $expired = ! $record?->created_at
            || Carbon::parse($record->created_at)->addMinutes($expire)->isPast();

        if (! $record || $expired || ! Hash::check($request->code, $record->token)) {
            throw ValidationException::withMessages([
                'code' => ['Mã xác thực OTP không chính xác hoặc đã hết hạn (mã có hiệu lực trong 5 phút).'],
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Không tìm thấy thông tin tài khoản với email này.'],
            ]);
        }

        // Cập nhật email_verified_at
        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        // Xóa token đã xác thực xong
        DB::table('email_verification_tokens')->where('email', $request->email)->delete();

        // Tự động đăng nhập cho khách hàng
        Auth::login($user);
        $request->session()->regenerate();

        if ($user->hasRole('super_admin') || $user->hasPermission('admin.access') || $user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Xác thực email thành công! Chào mừng bạn đến với trang quản trị.');
        }

        return redirect('/')->with('success', 'Xác thực email thành công! Chào mừng bạn đến với ' . config('app.name', 'FashionTee') . '.');
    }

    // Gửi lại mã OTP xác thực email
    public function resendVerificationOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Không tìm thấy tài khoản với email này.'],
            ]);
        }

        if (! is_null($user->email_verified_at)) {
            return redirect()->route('login')->with('success', 'Tài khoản này đã được xác thực trước đó. Bạn có thể đăng nhập ngay.');
        }

        $last = DB::table('email_verification_tokens')->where('email', $user->email)->first();
        $throttle = 60; // 60 giây giãn cách

        if ($last?->created_at && Carbon::parse($last->created_at)->addSeconds($throttle)->isFuture()) {
            $secondsLeft = Carbon::now()->diffInSeconds(Carbon::parse($last->created_at)->addSeconds($throttle));
            throw ValidationException::withMessages([
                'email' => ["Vui lòng chờ {$secondsLeft} giây nữa trước khi yêu cầu gửi lại mã mới."],
            ]);
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('email_verification_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
            ]
        );

        \Illuminate\Support\Facades\Log::info("FashionTee OTP resend code for [{$user->email}]: {$code}");

        try {
            $user->sendEmailVerificationOtpNotification($code);
        } catch (\Throwable $e) {
            report($e);
            throw ValidationException::withMessages([
                'email' => ['Không gửi được email xác thực. Vui lòng kiểm tra lại cấu hình: ' . $e->getMessage()],
            ]);
        }

        return redirect()->route('verification.notice', ['email' => $user->email])
            ->with('status', 'Mã xác thực mới đã được gửi tới email của bạn. Vui lòng kiểm tra hộp thư.');
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

            // Kiểm tra xác thực email
            if (is_null($user->email_verified_at)) {
                $email = $user->email;
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('verification.notice', ['email' => $email])
                    ->with('warning', 'Tài khoản của bạn chưa được xác thực email. Vui lòng nhập mã OTP hoặc bấm gửi lại mã để kích hoạt tài khoản.');
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
