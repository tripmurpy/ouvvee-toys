@props(['product'])

@php
    $name = data_get($product, 'name', data_get($product, 'product_name', 'Mainan Koleksi'));
    $label = data_get($product, 'label');
    $id = data_get($product, 'id_product');
    $price = data_get($product, 'price', 0);
    $stock = (int) data_get($product, 'stock', 0);
    $rating = (int) round((float) data_get($product, 'rating', data_get($product, 'reviews_avg_rating', 5)));
    $reviewsValue = data_get($product, 'reviews_count');
    if ($reviewsValue === null) {
        $reviewsRelation = data_get($product, 'reviews');
        $reviewsValue = is_countable($reviewsRelation) ? count($reviewsRelation) : (int) $reviewsRelation;
    }
    $reviews = (int) $reviewsValue;
    $slug = data_get($product, 'slug', trim(strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)), '-'));
    $url = data_get($product, 'url', url('/products/' . $slug));
    $displayImagePath = is_object($product) && method_exists($product, 'displayImagePath') ? $product->displayImagePath() : null;
    $displayModelPath = is_object($product) && method_exists($product, 'displayModelPath') ? $product->displayModelPath() : null;
    $imageUrl = data_get($product, 'image_url');
    $imagePath = $displayImagePath ?: ($imageUrl ? ltrim(parse_url($imageUrl, PHP_URL_PATH) ?: $imageUrl, '/') : null);
    $modelPath = $displayModelPath ?: (($modelUrl = data_get($product, 'model_url')) ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null);
    $modelExists = (bool) $modelPath;
    $isSoldOut = $stock < 1;
@endphp

@if($modelExists)
    @once
        @push('head')
            <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
        @endpush
    @endonce
@endif

<article
    {{ $attributes->merge(['class' => trim('card product-card shop-card' . ($isSoldOut ? ' product-card-sold-out' : ''))]) }}
>
    @if($modelExists)
        <div class="product-art product-art-live" aria-label="Preview 3D {{ $name }}">
            @if($label)
                <span class="product-label">{{ $isSoldOut ? 'Sold Out' : $label }}</span>
            @endif
            <span class="product-art-note">Preview 3D</span>
            <model-viewer
                src="{{ asset($modelPath) }}"
                alt="Model 3D {{ $name }}"
                camera-controls
                auto-rotate
                interaction-prompt="none"
                environment-image="neutral"
                exposure="1.65"
                shadow-intensity=".35"
                touch-action="pan-y"
                loading="lazy"
            ></model-viewer>
        </div>
    @else
        <a class="product-art" href="{{ $url }}" aria-label="Lihat {{ $name }}">
            @if($label)
                <span class="product-label">{{ $isSoldOut ? 'Sold Out' : $label }}</span>
            @endif

            @if($imagePath)
                <img src="{{ asset($imagePath) }}" alt="Foto {{ $name }}" loading="lazy">
            @else
                <span class="product-shape" aria-hidden="true"></span>
            @endif
        </a>
    @endif

    <div class="product-body">
        <div>
            <h3>{{ $name }}</h3>
            <span class="product-card-copy">{{ $modelExists ? 'Putar model 3D langsung dari katalog sebelum buka detail.' : 'Lihat detail ukuran, stok, dan catatan produk.' }}</span>
        </div>

        <div class="product-rating">
            <x-rating :value="$rating" />
            @if($reviews)
                <span>({{ $reviews }} reviews)</span>
            @endif
        </div>

        <div class="product-meta">
            <x-price :amount="$price" />
            <span class="product-stock">{{ $isSoldOut ? 'Stok habis' : $stock . ' stok tersedia' }}</span>
        </div>

        <div class="actions shop-card-actions">
            <x-button :href="$url" variant="ghost">Lihat</x-button>
            @if($id && ! $isSoldOut)
                <form class="quick-cart" action="{{ route('cart.items.store') }}" method="post" data-cart-form>
                    @csrf
                    <input type="hidden" name="id_product" value="{{ $id }}">
                    <div class="qty-stepper" aria-label="Jumlah {{ $name }}">
                        <button type="button" data-qty="-1" aria-label="Kurangi jumlah">-</button>
                        <input name="quantity" type="number" min="1" max="{{ $stock }}" value="1">
                        <button type="button" data-qty="1" aria-label="Tambah jumlah">+</button>
                    </div>
                    <x-button type="submit">Beli</x-button>
                </form>
            @else
                <x-button :disabled="$isSoldOut" aria-disabled="{{ $isSoldOut ? 'true' : 'false' }}">{{ $isSoldOut ? 'Habis' : 'Beli' }}</x-button>
            @endif
        </div>
    </div>
</article>
