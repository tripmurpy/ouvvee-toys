<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['value' => 5, 'count' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['value' => 5, 'count' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php ($stars = str_repeat('*', max(0, min(5, (int) $value)))); ?>

<span <?php echo e($attributes->merge(['class' => 'rating'])); ?> aria-label="Rating <?php echo e($value); ?> dari 5">
    <?php echo e($stars); ?><?php if($count): ?><span class="muted small"> (<?php echo e($count); ?>)</span><?php endif; ?>
</span>
<?php /**PATH C:\Users\ASUS\Documents\.Benny\project\.ouvetoys\backend\resources\views/components/rating.blade.php ENDPATH**/ ?>