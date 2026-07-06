<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
]));

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

foreach (array_filter(([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php ($class = 'btn btn-' . $variant); ?>

<?php if($href): ?>
    <a <?php echo e($attributes->merge(['class' => $class, 'href' => $href])); ?>><?php echo e($slot); ?></a>
<?php else: ?>
    <button <?php echo e($attributes->merge(['class' => $class, 'type' => $type])); ?>><?php echo e($slot); ?></button>
<?php endif; ?>
<?php /**PATH C:\Users\ASUS\Documents\.Benny\project\.ouvetoys\frontend\resources\views/components/button.blade.php ENDPATH**/ ?>