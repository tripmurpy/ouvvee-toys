@extends('layouts.store')

@section('title', 'Detail Produk - Ouvvee Toys')

@php
    $product = $product ?? [
        'name' => 'Galaxy Ranger Figure',
        'category' => 'Figur',
        'price' => 249000,
        'stock' => 12,
        'age' => '8+',
        'rating' => 5,
        'description' => 'Figur artikulasi dengan aksesori helm, base display, dan material plastik ABS.',
        'safety_note' => 'Mengandung bagian kecil. Tidak untuk anak di bawah 3 tahun.',
        'size' => '18 cm',
        'weight_gram' => 420,
        'model_url' => '/models/products/robot_police.glb',
    ];

    $modelUrl = data_get($product, 'model_url');
    $modelPath = $modelUrl ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null;
    // ponytail: support this frontend snapshot and future Laravel public paths; remove fallback after backend moves views/public into one app.
    $modelExists = $modelPath && (
        file_exists(public_path($modelPath)) ||
        file_exists(base_path('frontend/public/' . $modelPath))
    );
@endphp

@if($modelExists)
    @push('head')
        <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
    @endpush
@endif

@section('content')
<section class="container section split">
    <div class="stack">
        <div class="card product-art product-model">
            @if($modelExists)
                <model-viewer
                    src="{{ asset($modelPath) }}"
                    alt="Model 3D {{ data_get($product, 'name') }}"
                    camera-controls
                    auto-rotate
                    shadow-intensity="1"
                    loading="lazy"
                >
                    <span class="product-shape" aria-hidden="true"></span>
                </model-viewer>
            @else
                <span class="product-shape" aria-hidden="true"></span>
            @endif
        </div>
        <div class="grid grid-3">
            @for($i = 0; $i < 3; $i++)
                <div class="card product-art" style="min-height:120px"><span class="product-shape" style="transform:scale(.45)" aria-hidden="true"></span></div>
            @endfor
        </div>
    </div>
    <div class="stack-lg">
        <div class="stack">
            <x-badge>{{ data_get($product, 'category') }}</x-badge>
            <h1 class="page-title">{{ data_get($product, 'name') }}</h1>
            <x-rating :value="data_get($product, 'rating', 5)" count="28" />
            <x-price :amount="data_get($product, 'price')" style="font-size:32px" />
            <p class="lead">{{ data_get($product, 'description') }}</p>
        </div>
        <div class="card panel grid grid-2">
            <div><strong>Usia</strong><p class="muted">{{ data_get($product, 'age') }}</p></div>
            <div><strong>Stok</strong><p class="muted">{{ data_get($product, 'stock') }} tersedia</p></div>
            <div><strong>Ukuran</strong><p class="muted">{{ data_get($product, 'size') }}</p></div>
            <div><strong>Berat</strong><p class="muted">{{ data_get($product, 'weight_gram') }} gram</p></div>
        </div>
        <div class="card panel">
            <strong>Catatan keamanan</strong>
            <p class="muted">{{ data_get($product, 'safety_note') }}</p>
        </div>
        <div class="actions">
            <x-button>Tambah ke keranjang</x-button>
            <x-button variant="ghost">Simpan wishlist</x-button>
        </div>
    </div>
</section>
@endsection
