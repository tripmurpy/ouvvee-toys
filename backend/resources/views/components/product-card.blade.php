@props(['product'])

@php
    $name = data_get($product, 'name', data_get($product, 'product_name', 'Mainan Koleksi'));
    $category = data_get($product, 'category.category_name', data_get($product, 'category', 'Toys'));
    $brand = data_get($product, 'brand', data_get($product, 'seller.name', 'Ouvvee Curated'));
    $label = data_get($product, 'label');
    $id = data_get($product, 'id_product');
    $price = data_get($product, 'price', 0);
    $stock = (int) data_get($product, 'stock', 0);
    $age = data_get($product, 'age', data_get($product, 'recommended_age', '3+'));
    $rating = (int) round((float) data_get($product, 'rating', data_get($product, 'reviews_avg_rating', 5)));
    $reviewsValue = data_get($product, 'reviews_count');
    if ($reviewsValue === null) {
        $reviewsRelation = data_get($product, 'reviews');
        $reviewsValue = is_countable($reviewsRelation) ? count($reviewsRelation) : (int) $reviewsRelation;
    }
    $reviews = (int) $reviewsValue;
    $slug = data_get($product, 'slug', trim(strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)), '-'));
    $url = data_get($product, 'url', url('/products/' . $slug));
    $imageUrl = data_get($product, 'image_url');
    $imagePath = $imageUrl ? ltrim(parse_url($imageUrl, PHP_URL_PATH) ?: $imageUrl, '/') : null;
    $modelUrl = data_get($product, 'model_url');
    $modelPath = $modelUrl ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null;
    // ponytail: check both normal Laravel public path and this repo snapshot's frontend/public path.
    $modelExists = $modelPath && (file_exists(public_path($modelPath)) || file_exists(base_path('frontend/public/' . $modelPath)));
    $isSoldOut = $stock < 1;
@endphp

@if(! $imageUrl && $modelExists)
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

        @if($imageUrl)
            <img src="{{ asset($imagePath) }}" alt="Foto {{ $name }}" loading="lazy">
        @elseif($modelExists)
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
            @if($id && ! $isSoldOut)
                <form action="{{ route('cart.items.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_product" value="{{ $id }}">
                    <input type="hidden" name="quantity" value="1">
                    <x-button type="submit">Acquire</x-button>
                </form>
            @else
                <x-button :disabled="$isSoldOut" aria-disabled="{{ $isSoldOut ? 'true' : 'false' }}">{{ $isSoldOut ? 'Sold Out' : 'Acquire' }}</x-button>
            @endif
        </div>
    </div>
</article>
