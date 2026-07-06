<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale() ?? 'id')); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Admin - Ouvvee Toys'); ?></title>
    <?php echo $__env->make('partials.frontend-assets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="admin-page">
    <div class="admin-layout">
        <?php echo $__env->make('partials.admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="admin-main">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\ASUS\Documents\.Benny\project\.ouvetoys\frontend\resources\views/layouts/admin.blade.php ENDPATH**/ ?>