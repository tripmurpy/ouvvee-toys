@props(['product'])

@php
    $name = data_get($product, 'name', data_get($product, 'product_name', 'Mainan Koleksi'));
    $category = data_get($product, 'category', data_get($product, 'category.category_name', 'Toys'));
    $brand = data_get($product, 'brand', data_get($product, 'seller.name', 'Ouvvee Curated'));
    $label = data_get($product, 'label');
    $price = data_get($product, 'price', 0);
    $stock = (int) data_get($product, 'stock', 0);
    $age = data_get($product, 'age', data_get($product, 'recommended_age', '3+'));
    $rating = (int) data_get($product, 'rating', 5);
    $reviews = (int) data_get($product, 'reviews', data_get($product, 'reviews_count', 0));
    $slug = trim(strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)), '-');
    $url = data_get($product, 'url', url('/products/' . $slug));
    $modelUrl = data_get($product, 'model_url');
    $modelPath = $modelUrl ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null;
    // ponytail: check both normal Laravel public path and this repo snapshot's frontend/public path.
    $modelExists = $modelPath && (file_exists(public_path($modelPath)) || file_exists(base_path('frontend/public/' . $modelPath)));
    $isSoldOut = $stock < 1;
@endphp

@if($modelExists)
    @once
        @push('head')
            <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
        @endpush
    @endonce
@endif

<article {{ $attributes->merge(['class' => trim('card product-card' . ($isSoldOut ? ' product-card-sold-out' : ''))]) }}>
    <a class="product-art" href="{{ $url }}" aria-label="Lihat {{ $name }}">
        @if($label)
            <span class="product-label">{{ $isSoldOut ? 'Sold Out' : $label }}</span>
        @endif

        @if($modelExists)
            <model-viewer
                src="{{ asset($modelPath) }}"
                alt="Model 3D {{ $name }}"
                auto-rotate
                shadow-intensity=".8"
                loading="lazy"
            ></model-viewer>
        @else
            <span class="product-shape" aria-hidden="true"></span>
        @endif
    </a>

    <div class="product-body">
        <div>
            <span class="product-brand">{{ $brand }}</span>
            <h3>{{ $name }}</h3>
            <span class="product-category">{{ $category }} / Usia {{ $age }}</span>
        </div>

        <div class="product-rating">
            <x-rating :value="$rating" />
            @if($reviews)
                <span>({{ $reviews }} reviews)</span>
            @endif
        </div>

        <div class="product-meta">
            <x-price :amount="$price" />
            <x-badge :tone="$isSoldOut ? 'danger' : ($stock > 5 ? 'ok' : 'warn')">{{ $isSoldOut ? 'Habis' : $stock . ' stok' }}</x-badge>
        </div>

        <div class="actions">
            <x-button :href="$url" variant="ghost">Detail</x-button>
            <x-button :disabled="$isSoldOut" aria-disabled="{{ $isSoldOut ? 'true' : 'false' }}">{{ $isSoldOut ? 'Sold Out' : 'Acquire' }}</x-button>
        </div>
    </div>
</article>
