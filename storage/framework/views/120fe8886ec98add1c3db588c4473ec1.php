<!DOCTYPE html>
<html lang="en" <?php echo $__env->yieldContent('html-attributes'); ?>>

<head>
    <?php echo $__env->make('layouts.partials.title-meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!--===== CSS LINK =======-->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/all.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/magnific-popup/dist/magnific-popup.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/slick-slider/slick/slick.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/slick-slider/slick/slick-theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/nice-select.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/typography.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/aos/dist/aos.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <?php echo $__env->yieldContent('css'); ?>

</head>

<body <?php echo $__env->yieldContent('body-attributes'); ?>>

    <?php echo $__env->make('layouts.partials.loader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('header'); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->yieldContent('scripts'); ?>

    <script src="<?php echo e(asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js', 'resources/js/main.js']); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/layouts/base.blade.php ENDPATH**/ ?>