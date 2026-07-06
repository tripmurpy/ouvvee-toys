<header class="store-header">
    <div class="container nav">
        <a class="brand" href="<?php echo e(url('/')); ?>" aria-label="Ouvvee Toys home">
            <span class="brand-mark">OT</span>
            <span>Ouvvee Toys</span>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="<?php echo e(route('products.index')); ?>">Katalog</a>
            <a href="<?php echo e(route('wishlist.index')); ?>">Wishlist</a>
            <a href="<?php echo e(route('orders.index')); ?>">Status Pesanan</a>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'admin'): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>

        <div class="nav-actions">
            <form class="search" action="<?php echo e(route('products.index')); ?>" method="get">
                <span aria-hidden="true">Search</span>
                <input name="q" type="search" placeholder="Cari mainan..." value="<?php echo e(request('q')); ?>">
            </form>
            <a class="btn btn-ghost" href="<?php echo e(route('cart.index')); ?>">Cart</a>
            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('logout')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-primary" type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a class="btn btn-primary" href="<?php echo e(route('login')); ?>">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\Users\ASUS\Documents\.Benny\project\.ouvetoys\frontend\resources\views/partials/store/header.blade.php ENDPATH**/ ?>