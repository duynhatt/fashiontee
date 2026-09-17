<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <h4 class="text-center text-success mb-4">
                <i class="fa fa-user-circle me-2"></i> Thông tin cá nhân
            </h4>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            
            <form method="POST"
                  action="<?php echo e(route('profile.update')); ?>"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body text-center">

                        <label for="avatarInput" style="cursor:pointer;">
                            <img
                                id="avatarPreview"
                                src="<?php echo e($user->avatar
                                    ? asset('storage/'.$user->avatar)
                                    : asset('img/default-avatar.png')); ?>"
                                class="rounded-circle shadow border mb-2"
                                width="200"
                                height="200"
                                style="object-fit: cover;"
                            >
                            <div class="text-success fw-semibold">
                                <i class="fa fa-camera me-1"></i> Đổi ảnh đại diện
                            </div>
                        </label>

                        <input
                            type="file"
                            name="avatar"
                            id="avatarInput"
                            class="d-none"
                            accept="image/*"
                            onchange="previewAvatar(event)"
                        >
                    </div>
                </div>

                
                <div class="row g-4">

                    
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="text-success mb-3">
                                    <i class="fa fa-id-card me-2"></i> Thông tin cá nhân
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label">Họ tên</label>
                                    <input type="text"
                                           name="name"
                                           value="<?php echo e($user->name); ?>"
                                           class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                           value="<?php echo e($user->email); ?>"
                                           class="form-control bg-light"
                                           disabled>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text"
                                           name="phone"
                                           value="<?php echo e($user->phone); ?>"
                                           class="form-control">
                                </div>

                                <button class="btn btn-success w-100">
                                    <i class="fa fa-save me-1"></i> Lưu thông tin
                                </button>
                            </div>
                        </div>
                    </div>
            </form>
            

                    
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h6 class="text-warning mb-3">
                                    <i class="fa fa-lock me-2"></i> Đổi mật khẩu
                                </h6>

                                <form method="POST" action="<?php echo e(route('profile.password')); ?>">
                                    <?php echo csrf_field(); ?>

                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password"
                                               name="current_password"
                                               class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password"
                                               name="password"
                                               class="form-control">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Nhập lại mật khẩu mới</label>
                                        <input type="password"
                                               name="password_confirmation"
                                               class="form-control">
                                    </div>

                                    <button class="btn btn-warning text-white w-100">
                                        <i class="fa fa-key me-1"></i> Đổi mật khẩu
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>

        </div>
    </div>
</div>


<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('avatarPreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views\client\Profile.blade.php ENDPATH**/ ?>