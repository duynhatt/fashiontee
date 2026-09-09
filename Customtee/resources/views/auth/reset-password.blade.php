@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-3 fw-bold">Đặt lại mật khẩu</h3>
                    <p class="text-center text-muted mb-4">
                        Nhập mã 6 số đã gửi tới email và mật khẩu mới.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $email) }}"
                                   placeholder="example@gmail.com"
                                   required
                                   @if(old('email', $email)) readonly @endif>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mã xác nhận</label>
                            <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   value="{{ old('code') }}"
                                   placeholder="6 chữ số"
                                   maxlength="6"
                                   required autofocus>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Ít nhất 6 ký tự"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Nhập lại mật khẩu"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            Đổi mật khẩu
                        </button>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        <a href="{{ route('password.request') }}" class="fw-semibold">Gửi lại mã</a>
                        ·
                        <a href="{{ route('login') }}" class="fw-semibold">Quay lại đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
