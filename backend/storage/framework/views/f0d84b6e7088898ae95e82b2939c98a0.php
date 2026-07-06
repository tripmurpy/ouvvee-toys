<?php $__env->startSection('title', 'The Exhibition - Ouvvee Toys'); ?>
<?php $__env->startSection('body_class', 'gallery-home-page'); ?>

<?php
    $featured = $featured ?? collect();
    $heroImageUrl = data_get($featured, '0.image_url');
    $heroImagePath = $heroImageUrl ? ltrim(parse_url($heroImageUrl, PHP_URL_PATH) ?: $heroImageUrl, '/') : null;
    $heroModelUrl = data_get($featured, '0.model_url', '/models/products/robot_police.glb');
    $heroModelPath = ltrim(parse_url($heroModelUrl, PHP_URL_PATH) ?: $heroModelUrl, '/');
    // ponytail: support this repo snapshot and a normal Laravel public path until frontend files are merged into one app root.
    $heroModelExists = file_exists(public_path($heroModelPath)) || file_exists(base_path('frontend/public/' . $heroModelPath));
?>

<?php if($heroModelExists): ?>
    <?php $__env->startPush('head'); ?>
        <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
<section class="gallery-home">
    <div class="gallery-loader" data-gallery-loader>
        <strong data-gallery-counter>00%</strong>
        <span>Acquiring Signal</span>
    </div>

    <nav class="gallery-nav" aria-label="Navigasi exhibition">
        <a class="gallery-brand" href="<?php echo e(url('/')); ?>">Ouvvee Toys</a>
        <div class="gallery-nav-links">
            <a href="#exhibit">Exhibits</a>
            <a href="<?php echo e(url('/products')); ?>">Collection</a>
            <a href="<?php echo e(url('/cart')); ?>">Vault</a>
        </div>
    </nav>

    <section class="gallery-hero" id="exhibit" aria-labelledby="gallery-title">
        <div class="gallery-stage" aria-label="Preview produk unggulan">
            <?php if($heroImageUrl): ?>
                <img src="<?php echo e(asset($heroImagePath)); ?>" alt="Foto <?php echo e(data_get($featured, '0.product_name')); ?>" loading="eager">
            <?php elseif($heroModelExists): ?>
                <model-viewer
                    src="<?php echo e(asset($heroModelPath)); ?>"
                    alt="Model 3D <?php echo e(data_get($featured, '0.name', data_get($featured, '0.product_name'))); ?>"
                    camera-controls
                    auto-rotate
                    shadow-intensity="1"
                    exposure=".86"
                    loading="eager"
                ></model-viewer>
            <?php else: ?>
                <div class="gallery-model-fallback" aria-hidden="true">
                    <span class="product-shape"></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="gallery-hero-copy">
            <p class="gallery-kicker">The Gallery // Exhibit 01</p>
            <h1 id="gallery-title"><?php echo e(data_get($featured, '0.product_name', 'Curated Display Figures')); ?></h1>
            <p>Collector-grade display toys with live stock, clear provenance, and a short path from inspection to checkout.</p>
            <div class="gallery-actions">
                <a class="gallery-btn gallery-btn-primary" href="<?php echo e(url('/products')); ?>">Enter Collection</a>
                <a class="gallery-btn gallery-btn-ghost" href="<?php echo e(url('/cart')); ?>">Open Vault</a>
            </div>
        </div>

        <a class="gallery-scroll" href="#collection-preview" aria-label="Scroll ke koleksi">
            <span>Enter Gallery</span>
            <i aria-hidden="true"></i>
        </a>
    </section>

    <section class="gallery-collection" id="collection-preview">
        <div class="gallery-section-head">
            <p class="gallery-kicker">Collection begins here</p>
            <h2>Masterpieces of engineering</h2>
            <a href="<?php echo e(url('/products')); ?>">View all works</a>
        </div>

        <div class="gallery-product-grid">
            <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $name = data_get($product, 'name', data_get($product, 'product_name'));
                    $category = data_get($product, 'category.category_name', data_get($product, 'category'));
                    $imageUrl = data_get($product, 'image_url');
                    $imagePath = $imageUrl ? ltrim(parse_url($imageUrl, PHP_URL_PATH) ?: $imageUrl, '/') : null;
                    $modelUrl = data_get($product, 'model_url');
                    $modelPath = $modelUrl ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null;
                    $modelExists = $modelPath && (file_exists(public_path($modelPath)) || file_exists(base_path('frontend/public/' . $modelPath)));
                    $slug = data_get($product, 'slug', trim(strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)), '-'));
                ?>
                <article class="gallery-product">
                    <a class="gallery-product-media" href="<?php echo e(route('products.show', $slug)); ?>" aria-label="Lihat <?php echo e($name); ?>">
                        <?php if($imageUrl): ?>
                            <img src="<?php echo e(asset($imagePath)); ?>" alt="Foto <?php echo e($name); ?>" loading="lazy">
                        <?php elseif($modelExists): ?>
                            <model-viewer
                                src="<?php echo e(asset($modelPath)); ?>"
                                alt="Model 3D <?php echo e($name); ?>"
                                auto-rotate
                                shadow-intensity=".7"
                                loading="lazy"
                            ></model-viewer>
                        <?php else: ?>
                            <span class="product-shape" aria-hidden="true"></span>
                        <?php endif; ?>
                    </a>
                    <div class="gallery-product-body">
                        <span><?php echo e($category); ?></span>
                        <h3><?php echo e($name); ?></h3>
                        <div class="gallery-product-meta">
                            <?php if (isset($component)) { $__componentOriginal5c7c50258000edf57abfef324d310474 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c7c50258000edf57abfef324d310474 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.price','data' => ['amount' => data_get($product, 'price')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('price'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['amount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(data_get($product, 'price'))]); ?>
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
                            <strong><?php echo e(data_get($product, 'stock')); ?> in stock</strong>
                        </div>
                        <a class="gallery-btn gallery-btn-primary" href="<?php echo e(route('products.show', $slug)); ?>">Acquire</a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
</section>

<script>
    (() => {
        const loader = document.querySelector('[data-gallery-loader]');
        const counter = document.querySelector('[data-gallery-counter]');
        if (!loader || !counter) return;

        let progress = 0;
        const tick = window.setInterval(() => {
            progress = Math.min(100, progress + 20);
            counter.textContent = String(progress).padStart(2, '0') + '%';
            if (progress === 100) {
                window.clearInterval(tick);
                window.setTimeout(() => loader.classList.add('is-hidden'), 220);
            }
        }, 80);
    })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Documents\.Benny\project\.ouvetoys\backend\resources\views/store/home.blade.php ENDPATH**/ ?>