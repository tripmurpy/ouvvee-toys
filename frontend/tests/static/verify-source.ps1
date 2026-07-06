$ErrorActionPreference = 'Stop'

$root = Resolve-Path (Join-Path $PSScriptRoot '../..')

$required = @(
    'composer.json',
    'artisan',
    'routes/web.php',
    'app/Http/Controllers/CheckoutController.php',
    'app/Models/Product.php',
    'database/migrations/2026_07_06_000000_create_ouvvee_schema.php',
    'database/seeders/DatabaseSeeder.php',
    'resources/views/store/orders/index.blade.php'
)

foreach ($path in $required) {
    $fullPath = Join-Path $root $path
    if (-not (Test-Path $fullPath)) {
        throw "Missing required file: $path"
    }
}

$views = Get-ChildItem -Path (Join-Path $root 'resources/views') -Recurse -File
$forbidden = @('OVV-2407', 'Galaxy Ranger', 'Puzzle Safari', 'Luna Plush', 'City Racer')

foreach ($pattern in $forbidden) {
    $hits = $views | Select-String -Pattern $pattern
    if ($hits) {
        throw "Found stale demo payload: $pattern"
    }
}

$routes = Get-Content (Join-Path $root 'routes/web.php') -Raw
foreach ($routeName in @('products.index', 'cart.items.store', 'checkout.store', 'orders.pay', 'reviews.store', 'admin.dashboard')) {
    if ($routes -notmatch [regex]::Escape($routeName)) {
        throw "Missing route name: $routeName"
    }
}

$checkout = Get-Content (Join-Path $root 'app/Http/Controllers/CheckoutController.php') -Raw
foreach ($pattern in @('DB::transaction', 'lockForUpdate', "decrement('stock'")) {
    if ($checkout -notmatch [regex]::Escape($pattern)) {
        throw "Checkout safety marker missing: $pattern"
    }
}

Write-Host 'Source verification passed.'
