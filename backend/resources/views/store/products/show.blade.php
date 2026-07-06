@extends('layouts.store')

@section('title', 'Detail Produk - Ouvvee Toys')

@php
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
@endphp

@if(! $imageUrl && $modelExists)
    @push('head')
        <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
    @endpush
@endif

@section('content')
<section class="container section split">
    <div class="stack">
        <div class="card product-art product-model">
            @if($imageUrl)
                <img src="{{ asset($imagePath) }}" alt="Foto {{ $name }}" loading="eager">
            @elseif($modelExists)
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
            @foreach($galleryImages->take(3) as $image)
                @php
                    $thumbUrl = data_get($image, 'image_url');
                    $thumbPath = $thumbUrl ? ltrim(parse_url($thumbUrl, PHP_URL_PATH) ?: $thumbUrl, '/') : null;
                @endphp
                <div class="card product-art" style="min-height:120px">
                    @if($thumbUrl)
                        <img src="{{ asset($thumbPath) }}" alt="{{ data_get($image, 'alt_text', $name) }}" loading="lazy">
                    @else
                        <span class="product-shape" style="transform:scale(.45)" aria-hidden="true"></span>
                    @endif
                </div>
            @endforeach
            @for($i = $galleryImages->count(); $i < 3; $i++)
                <div class="card product-art" style="min-height:120px"><span class="product-shape" style="transform:scale(.45)" aria-hidden="true"></span></div>
            @endfor
        </div>
    </div>
    <div class="stack-lg">
        <div class="stack">
            <x-badge>{{ $category }}</x-badge>
            <h1 class="page-title">{{ $name }}</h1>
            <x-rating :value="round((float) data_get($product, 'reviews_avg_rating', 5))" :count="data_get($product, 'reviews_count', data_get($product, 'reviews', collect())->count())" />
            <x-price :amount="data_get($product, 'price')" style="font-size:32px" />
            <p class="lead">{{ data_get($product, 'description') }}</p>
        </div>
        <div class="card panel grid grid-2">
            <div><strong>Usia</strong><p class="muted">{{ $age }}</p></div>
            <div><strong>Stok</strong><p class="muted">{{ data_get($product, 'stock') }} tersedia</p></div>
            <div><strong>Ukuran</strong><p class="muted">{{ data_get($product, 'size') }}</p></div>
            <div><strong>Berat</strong><p class="muted">{{ data_get($product, 'weight_gram') }} gram</p></div>
        </div>
        <div class="card panel">
            <strong>Catatan keamanan</strong>
            <p class="muted">{{ data_get($product, 'safety_note') }}</p>
        </div>
        <div class="actions">
            @if(data_get($product, 'stock') > 0)
                <form action="{{ route('cart.items.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_product" value="{{ data_get($product, 'id_product') }}">
                    <input type="hidden" name="quantity" value="1">
                    <x-button type="submit">Tambah ke keranjang</x-button>
                </form>
            @else
                <x-button disabled>Stok habis</x-button>
            @endif
            <form action="{{ route('wishlist.store', $product) }}" method="post">
                @csrf
                <x-button type="submit" variant="ghost">Simpan wishlist</x-button>
            </form>
            @auth
                <x-button :href="route('reviews.create', $product)" variant="ghost">Tulis review</x-button>
            @endauth
        </div>
    </div>
</section>
@endsection
