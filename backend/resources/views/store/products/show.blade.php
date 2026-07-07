@extends('layouts.store')

@section('title', 'Detail Produk - Ouvvee Toys')
@section('body_class', 'storefront-page product-detail-page')

@php
    $name = data_get($product, 'name', data_get($product, 'product_name'));
    $age = data_get($product, 'age', data_get($product, 'recommended_age'));
    $category = data_get($product, 'category');
    $categoryName = data_get($category, 'category_name', 'Katalog');
    $categorySlug = data_get($category, 'slug');
    $price = (float) data_get($product, 'price', 0);
    $stock = (int) data_get($product, 'stock', 0);
    $reviewCount = (int) data_get($product, 'reviews_count', data_get($product, 'reviews', collect())->count());
    $galleryImages = data_get($product, 'images', collect());
    $displayImagePath = method_exists($product, 'displayImagePath') ? $product->displayImagePath() : null;
    $displayModelPath = method_exists($product, 'displayModelPath') ? $product->displayModelPath() : null;
    $imageUrl = data_get($galleryImages, '0.image_url', data_get($product, 'image_url'));
    $imagePath = $displayImagePath ?: ($imageUrl ? ltrim(parse_url($imageUrl, PHP_URL_PATH) ?: $imageUrl, '/') : null);
    $galleryThumbs = collect([$imagePath])
        ->merge($galleryImages->pluck('image_url')->map(fn ($url) => $url ? ltrim(parse_url($url, PHP_URL_PATH) ?: $url, '/') : null))
        ->filter()
        ->unique()
        ->values();
    $modelPath = $displayModelPath ?: (($modelUrl = data_get($product, 'model_url')) ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null);
    $fallbackBackUrl = route('products.index');
    $previousUrl = url()->previous();
    $backUrl = str_starts_with($previousUrl, url('/')) && $previousUrl !== request()->fullUrl()
        ? $previousUrl
        : $fallbackBackUrl;
    $modelExists = (bool) $modelPath;
    $shareUrl = route('products.show', $product);
@endphp

@if($modelExists)
    @push('head')
        <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
    @endpush
@endif

@section('content')
<section class="container section product-page">
    <nav class="product-breadcrumbs" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('products.index') }}">Katalog</a>
        @if($categorySlug)
            <span aria-hidden="true">/</span>
            <a href="{{ route('categories.show', $categorySlug) }}">{{ $categoryName }}</a>
        @endif
        <span aria-hidden="true">/</span>
        <span>{{ $name }}</span>
    </nav>

    <div class="product-layout">
        <div class="stack" data-product-gallery>
            @if($modelExists)
                <div class="product-stage-note">
                    <strong>Preview 3D aktif</strong>
                    <span>Putar model untuk melihat proporsi dan detail figure dari berbagai sisi.</span>
                </div>
            @endif

            <div class="card product-art product-model product-spotlight">
                @if($modelExists)
                    <model-viewer
                        src="{{ asset($modelPath) }}"
                        alt="Model 3D {{ $name }}"
                        camera-controls
                        auto-rotate
                        interaction-prompt="auto"
                        environment-image="neutral"
                        exposure="1.65"
                        shadow-intensity=".35"
                        touch-action="pan-y"
                        loading="eager"
                    >
                        <span class="product-shape" aria-hidden="true"></span>
                    </model-viewer>
                @elseif($imagePath)
                    <img
                        data-product-main-image
                        src="{{ asset($imagePath) }}"
                        alt="Foto {{ $name }}"
                        loading="eager"
                    >
                @else
                    <span class="product-shape" aria-hidden="true"></span>
                @endif
            </div>

            @if($galleryThumbs->isNotEmpty())
                <div class="product-gallery-thumbs" aria-label="Galeri produk">
                    @foreach($galleryThumbs as $thumb)
                        @if($modelExists)
                            <div class="card product-thumb product-thumb-static">
                                <img src="{{ asset($thumb) }}" alt="Foto {{ $name }} {{ $loop->iteration }}" loading="lazy">
                            </div>
                        @else
                            <button
                                class="card product-thumb{{ $loop->first ? ' is-active' : '' }}"
                                type="button"
                                data-product-thumb
                                data-image-src="{{ asset($thumb) }}"
                                data-image-alt="Foto {{ $name }} {{ $loop->iteration }}"
                                aria-label="Lihat foto {{ $loop->iteration }} {{ $name }}"
                            >
                                <img src="{{ asset($thumb) }}" alt="" loading="lazy">
                            </button>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <div class="stack-lg">
            <div class="stack">
                <a class="back-link" href="{{ $backUrl }}" data-back-button="{{ $fallbackBackUrl }}">Kembali</a>
                <span class="eyebrow">Koleksi {{ $categoryName }}</span>
                <h1 class="page-title product-page-title">{{ $name }}</h1>
                <div class="product-proof">
                    <x-rating :value="round((float) data_get($product, 'reviews_avg_rating', 5))" :count="$reviewCount" />
                    <span class="product-proof-dot" aria-hidden="true"></span>
                    <span class="muted small">{{ $categoryName }}</span>
                </div>
                <div class="product-detail-price">
                    <x-price :amount="$price" class="product-page-price" />
                    <span class="product-stock">{{ $stock > 0 ? $stock . ' stok tersedia' : 'Stok habis' }}</span>
                </div>
                <p class="lead">{{ $modelExists ? 'Figure koleksi dengan preview 3D aktif, jadi bentuk badan, roda, dan proporsinya bisa dicek sebelum beli.' : 'Figure koleksi dengan spesifikasi ringkas, stok jelas, dan alur beli yang singkat.' }}</p>
                <p class="product-body-copy">{{ data_get($product, 'description') }}</p>
            </div>

            <div class="card panel product-specs">
                <div><strong>Usia</strong><p class="muted">{{ $age }}</p></div>
                <div><strong>Stok</strong><p class="muted">{{ $stock }} tersedia</p></div>
                <div><strong>Ukuran</strong><p class="muted">{{ data_get($product, 'size') }}</p></div>
                <div><strong>Berat</strong><p class="muted">{{ data_get($product, 'weight_gram') }} gram</p></div>
            </div>

            <div class="card panel product-description">
                <div class="product-section-head">
                    <h2>Deskripsi Produk</h2>
                    <span>Informasi inti</span>
                </div>
                <div class="stack">
                    <p class="muted">Kondisi baru, siap pajang, dan minimum pembelian 1 item.</p>
                    <p class="muted">Kategori {{ $categoryName }} dengan stok yang terus sinkron ke checkout.</p>
                    <p>{{ data_get($product, 'description') }}</p>
                </div>
            </div>

            <div class="card panel">
                <strong>Catatan keamanan</strong>
                <p class="muted">{{ data_get($product, 'safety_note') }}</p>
            </div>
        </div>

        <aside class="card panel product-buy-card" data-purchase-card data-price="{{ $price }}">
            <div class="stack">
                <div>
                    <p class="eyebrow">Fitur pembelian</p>
                    <h2 class="product-buy-title">Pilih jumlah lalu lanjut beli</h2>
                </div>

                <div class="product-buy-summary">
                    <div class="product-buy-thumb">
                        @if($imagePath)
                            <img src="{{ asset($imagePath) }}" alt="Thumbnail {{ $name }}" loading="lazy">
                        @else
                            <span class="product-shape" aria-hidden="true"></span>
                        @endif
                    </div>
                    <div class="stack" style="gap:6px">
                        <strong>{{ $name }}</strong>
                        <span class="muted small">{{ $categoryName }}</span>
                    </div>
                </div>

                <p class="muted small">Catatan tambahan, alamat, dan opsi kirim tetap dipilih di langkah checkout.</p>

                @if($stock > 0)
                    @auth
                        <form class="stack" action="{{ route('cart.items.store') }}" method="post" data-cart-form>
                            @csrf
                            <input type="hidden" name="id_product" value="{{ data_get($product, 'id_product') }}">
                            <input type="hidden" name="redirect_to" value="cart" data-purchase-redirect>
                            <div class="product-buy-row">
                                <div class="qty-stepper qty-stepper-wide" aria-label="Jumlah {{ $name }}">
                                    <button type="button" data-qty="-1" aria-label="Kurangi jumlah">-</button>
                                    <input
                                        data-purchase-qty
                                        name="quantity"
                                        type="number"
                                        min="1"
                                        max="{{ $stock }}"
                                        value="1"
                                        aria-label="Jumlah {{ $name }}"
                                    >
                                    <button type="button" data-qty="1" aria-label="Tambah jumlah">+</button>
                                </div>
                                <span class="product-buy-stock">Stok: {{ $stock }}</span>
                            </div>

                            <div class="product-buy-subtotal">
                                <span>Subtotal</span>
                                <strong data-purchase-subtotal>Rp{{ number_format($price, 0, ',', '.') }}</strong>
                            </div>

                            <div class="stack" style="gap:10px">
                                <button class="btn btn-primary product-buy-button" type="submit" data-purchase-action="cart">Tambah ke Keranjang</button>
                                <button class="btn btn-ghost product-buy-button" type="submit" data-purchase-action="checkout">Beli Langsung</button>
                            </div>
                        </form>
                    @else
                        <div class="stack" style="gap:10px">
                            <a class="btn btn-primary product-buy-button" href="{{ route('login') }}">Tambah ke Keranjang</a>
                            <a class="btn btn-ghost product-buy-button" href="{{ route('login') }}">Beli Langsung</a>
                            <p class="muted small">Login diperlukan sebelum produk masuk ke keranjang atau checkout.</p>
                        </div>
                    @endauth
                @else
                    <button class="btn btn-primary product-buy-button" type="button" disabled>Stok habis</button>
                @endif

                <div class="product-buy-links">
                    <form action="{{ route('wishlist.store', $product) }}" method="post">
                        @csrf
                        <button class="product-inline-action" type="submit">Wishlist</button>
                    </form>
                    <button class="product-inline-action" type="button" data-copy-url="{{ $shareUrl }}">Share</button>
                    @auth
                        <a class="product-inline-action" href="{{ route('reviews.create', $product) }}">Tulis review</a>
                    @endauth
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection
