<?php $__env->startSection('title', 'Detail Produk - Ouvvee Toys'); ?>

<?php
    $name = data_get($product, 'name', data_get($product, 'product_name'));
    $category = data_get($product, 'category.category_name', data_get($product, 'category'));
    $age = data_get($product, 'age', data_get($product, 'recommended_age'));
    $galleryImages = data_get($product, 'images', collect());
    $imageUrl = data_get($galleryImages, '0.image_url', data_get($product, 'image_url'));
    $imagePath = $imageUrl ? ltrim(parse_url($imageUrl, PHP_URL_PATH) ?: $imageUrl, '/') : null;
    $modelUrl = data_get($product, 'model_url');
    $modelPath = $modelUrl ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null;
    // ponytail: support this frontend snapshot and future Laravel public paths; remove fallback after backend moves views/public into one app.
    $modelExists = $modelPath && (
        file_exists(public_path($modelPath)) ||
        file_exists(base_path('frontend/public/' . $modelPath))
    );
?>

<?php if(! $imageUrl && $modelExists): ?>
    <?php $__env->startPush('head'); ?>
        <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
<section class="container section split">
    <div class="stack">
        <div class="card product-art product-model">
            <?php if($imageUrl): ?>
                <img src="<?php echo e(asset($imagePath)); ?>" alt="Foto <?php echo e($name); ?>" loading="eager">
            <?php elseif($modelExists): ?>
                <model-viewer
                    src="<?php echo e(asset($modelPath)); ?>"
                    alt="Model 3D <?php echo e(data_get($product, 'name')); ?>"
                    camera-controls
                    auto-rotate
                    shadow-intensity="1"
                    loading="lazy"
                >
                    <span class="product-shape" aria-hidden="true"></span>
                </model-viewer>
            <?php else: ?>
                <span class="product-shape" aria-hidden="true"></span>
            <?php endif; ?>
        </div>
        <div class="grid grid-3">
            <?php $__currentLoopData = $galleryImages->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $thumbUrl = data_get($image, 'image_url');
                    $thumbPath = $thumbUrl ? ltrim(parse_url($thumbUrl, PHP_URL_PATH) ?: $thumbUrl, '/') : null;
                ?>
                <div class="card product-art" style="min-height:120px">
                    <?php if($thumbUrl): ?>
                        <img src="<?php echo e(asset($thumbPath)); ?>" alt="<?php echo e(data_get($image, 'alt_text', $name)); ?>" loading="lazy">
                    <?php else: ?>
                        <span class="product-shape" style="transform:scale(.45)" aria-hidden="true"></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php for($i = $galleryImages->count(); $i < 3; $i++): ?>
                <div class="card product-art" style="min-height:120px"><span class="product-shape" style="transform:scale(.45)" aria-hidden="true"></span></div>
            <?php endfor; ?>
        </div>
    </div>
    <div class="stack-lg">
        <div class="stack">
            <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($category); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
            <h1 class="page-title"><?php echo e($name); ?></h1>
            <?php if (isset($component)) { $__componentOriginaldaaa4f7e4868d5d2754fc46560cdd197 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldaaa4f7e4868d5d2754fc46560cdd197 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.rating','data' => ['value' => round((float) data_get($product, 'reviews_avg_rating', 5)),'count' => data_get($product, 'reviews_count', data_get($product, 'reviews', collect())->count())]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(round((float) data_get($product, 'reviews_avg_rating', 5))),'count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(data_get($product, 'reviews_count', data_get($product, 'reviews', collect())->count()))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldaaa4f7e4868d5d2754fc46560cdd197)): ?>
<?php $attributes = $__attributesOriginaldaaa4f7e4868d5d2754fc46560cdd197; ?>
<?php unset($__attributesOriginaldaaa4f7e4868d5d2754fc46560cdd197); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldaaa4f7e4868d5d2754fc46560cdd197)): ?>
<?php $component = $__componentOriginaldaaa4f7e4868d5d2754fc46560cdd197; ?>
<?php unset($__componentOriginaldaaa4f7e4868d5d2754fc46560cdd197); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5c7c50258000edf57abfef324d310474 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c7c50258000edf57abfef324d310474 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.price','data' => ['amount' => data_get($product, 'price'),'style' => 'font-size:32px']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('price'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['amount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(data_get($product, 'price')),'style' => 'font-size:32px']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c7c50258000edf57abfef324d310474)): ?>
<?php $attributes = $__attributesOriginal5c7c50258000edf57abfef324d310474; ?>
<?php unset($__attributesOriginal5c7c50258000edf57abfef324d310474); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c7c50258000edf57abfef324d310474)): ?>
<?php $component = $__componentOriginal5c7c50258000edf57abfef324d310474; ?>
<?php unset($__componentOriginal5c7c50258000edf57abfef324d310474); ?>
<?php endif; ?>
            <p class="lead"><?php echo e(data_get($product, 'description')); ?></p>
        </div>
        <div class="card panel grid grid-2">
            <div><strong>Usia</strong><p class="muted"><?php echo e($age); ?></p></div>
            <div><strong>Stok</strong><p class="muted"><?php echo e(data_get($product, 'stock')); ?> tersedia</p></div>
            <div><strong>Ukuran</strong><p class="muted"><?php echo e(data_get($product, 'size')); ?></p></div>
            <div><strong>Berat</strong><p class="muted"><?php echo e(data_get($product, 'weight_gram')); ?> gram</p></div>
        </div>
        <div class="card panel">
            <strong>Catatan keamanan</strong>
            <p class="muted"><?php echo e(data_get($product, 'safety_note')); ?></p>
        </div>
        <div class="actions">
            <?php if(data_get($product, 'stock') > 0): ?>
                <form action="<?php echo e(route('cart.items.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id_product" value="<?php echo e(data_get($product, 'id_product')); ?>">
                    <input type="hidden" name="quantity" value="1">
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit']); ?>Tambah ke keranjang <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                </form>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['disabled' => true]); ?>Stok habis <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            <?php endif; ?>
            <form action="<?php echo e(route('wishlist.store', $product)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'ghost']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'ghost']); ?>Simpan wishlist <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            </form>
            <?php if(auth()->guard()->check()): ?>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => route('reviews.create', $product),'variant' => 'ghost']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('reviews.create', $product)),'variant' => 'ghost']); ?>Tulis review <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Documents\.Benny\project\.ouvetoys\backend\resources\views/store/products/show.blade.php ENDPATH**/ ?>