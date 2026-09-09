@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-3 fw-bold">Quên mật khẩu</h3>
                    <p class="text-center text-muted mb-4">
                        Nhập email đã đăng ký. Nếu tài khoản tồn tại, chúng tôi sẽ gửi mã xác nhận đặt lại mật khẩu.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="example@gmail.com"
                                   required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            Gửi mã xác nhận
                        </button>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        <a href="{{ route('login') }}" class="fw-semibold">Quay lại đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
