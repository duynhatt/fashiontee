<?php $__env->startSection('title', 'Xác thực tài khoản - FashionTee'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-3" style="width: 64px; height: 64px;">
                            <i class="fa fa-envelope-open-text fa-2x"></i>
                        </div>
                        <h3 class="fw-bold mb-2">Xác thực Email</h3>
                        <p class="text-muted small mb-0">
                            Vui lòng nhập mã OTP 6 chữ số đã được gửi tới hộp thư của bạn.
                        </p>
                    </div>

                    
                    <?php if(session('status')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fa fa-info-circle me-1"></i> <?php echo e(session('status')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-triangle me-1"></i> <?php echo e(session('warning')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-times-circle me-1"></i> <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    
                    <form method="POST" action="<?php echo e(route('verification.verify')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ Email</label>
                            <input type="email" name="email" id="verification_email"
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('email', $email)); ?>"
                                   placeholder="example@gmail.com"
                                   required
                                   <?php if(old('email', $email)): ?> readonly <?php endif; ?>>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mã OTP (6 chữ số)</label>
                            <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code"
                                   class="form-control text-center fs-4 fw-bold letter-spacing <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('code')); ?>"
                                   placeholder="· · · · · ·"
                                   maxlength="6"
                                   style="letter-spacing: 0.35em; font-family: monospace;"
                                   required autofocus>
                            <div class="form-text text-muted small mt-1 text-center">
                                <i class="fa fa-clock me-1"></i> Mã OTP có hiệu lực trong 5 phút.
                            </div>
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback text-center"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                            <i class="fa fa-check me-1"></i> Kích hoạt tài khoản
                        </button>
                    </form>

                    <hr class="my-4 text-muted opacity-25">

                    <div class="alert alert-light border small text-muted text-start mb-3">
                        <i class="fa fa-info-circle text-primary me-1"></i>
                        <strong>Mẹo:</strong> Nếu chưa thấy thư trong <em>Hộp thư đến</em>, bạn hãy kiểm tra thêm mục <strong>Thư rác (Spam)</strong> hoặc <strong>Quảng cáo</strong> của Gmail nhé.
                    </div>

                    
                    <div class="text-center">
                        <p class="text-muted small mb-2">Chưa nhận được mã xác nhận?</p>
                        <form method="POST" action="<?php echo e(route('verification.resend')); ?>" id="resendForm">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" value="<?php echo e(old('email', $email)); ?>">
                            <button type="submit" id="resendBtn" class="btn btn-outline-secondary btn-sm px-3">
                                <i class="fa fa-redo me-1"></i> Gửi lại mã OTP
                            </button>
                        </form>
                    </div>

                    <p class="text-center mt-4 mb-0 small text-muted">
                        <a href="<?php echo e(route('register')); ?>" class="text-decoration-none">Đăng ký email khác</a>
                        ·
                        <a href="<?php echo e(route('login')); ?>" class="text-decoration-none">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resendForm = document.getElementById('resendForm');
        const resendBtn = document.getElementById('resendBtn');
        const emailInput = document.getElementById('verification_email');

        // Đồng bộ email khi người dùng thay đổi
        if (emailInput && resendForm) {
            emailInput.addEventListener('input', function() {
                const hiddenEmail = resendForm.querySelector('input[name="email"]');
                if (hiddenEmail) hiddenEmail.value = this.value;
            });
        }

        // Hỗ trợ chỉ cho phép nhập số trong ô OTP
        const codeInput = document.querySelector('input[name="code"]');
        if (codeInput) {
            codeInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\auth\verify-email.blade.php ENDPATH**/ ?>