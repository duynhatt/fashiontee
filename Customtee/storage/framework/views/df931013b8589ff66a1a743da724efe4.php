<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $__env->yieldContent('title', 'CustomTee'); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ICON -->
    <link rel="apple-touch-icon" href="<?php echo e(asset('img/apple-icon.png')); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('img/favicon.ico')); ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/templatemo.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">

    <!-- FONT -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">

    <link rel="stylesheet" href="<?php echo e(asset('css/fontawesome.min.css')); ?>">
</head>
<body>

    <?php echo $__env->make('client.layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>  
    
    <?php echo $__env->yieldContent('content'); ?>                  

    <?php echo $__env->make('client.layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>   

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
</body>
</html>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/layouts/app.blade.php ENDPATH**/ ?>