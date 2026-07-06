
<?php
    $cssPath = file_exists(resource_path('css/app.css'))
        ? resource_path('css/app.css')
        : base_path('frontend/resources/css/app.css');
?>

<?php if(file_exists($cssPath)): ?>
    <style><?php echo file_get_contents($cssPath); ?></style>
<?php endif; ?>
<?php /**PATH C:\Users\ASUS\Documents\.Benny\project\.ouvetoys\frontend\resources\views/partials/frontend-assets.blade.php ENDPATH**/ ?>