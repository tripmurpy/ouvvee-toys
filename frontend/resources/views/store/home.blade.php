@extends('layouts.store')

@section('title', 'The Exhibition - Ouvvee Toys')
@section('body_class', 'gallery-home-page')

@php
    $featured = $featured ?? collect();
    $heroModelUrl = data_get($featured, '0.model_url', '/models/products/robot_police.glb');
    $heroModelPath = ltrim(parse_url($heroModelUrl, PHP_URL_PATH) ?: $heroModelUrl, '/');
    // ponytail: support this repo snapshot and a normal Laravel public path until frontend files are merged into one app root.
    $heroModelExists = file_exists(public_path($heroModelPath)) || file_exists(base_path('frontend/public/' . $heroModelPath));
@endphp

@if($heroModelExists)
    @push('head')
        <script type="module" src="https://unpkg.com/@google/model-viewer@4.3.1/dist/model-viewer.min.js"></script>
    @endpush
@endif

@section('content')
<section class="gallery-home">
    <div class="gallery-loader" data-gallery-loader>
        <strong data-gallery-counter>00%</strong>
        <span>Acquiring Signal</span>
    </div>

    <nav class="gallery-nav" aria-label="Navigasi exhibition">
        <a class="gallery-brand" href="{{ url('/') }}">Ouvvee Toys</a>
        <div class="gallery-nav-links">
            <a href="#exhibit">Exhibits</a>
            <a href="{{ url('/products') }}">Collection</a>
            <a href="{{ url('/cart') }}">Vault</a>
        </div>
    </nav>

    <section class="gallery-hero" id="exhibit" aria-labelledby="gallery-title">
        <div class="gallery-stage" aria-label="Preview model 3D Ruin Sentinel">
            @if($heroModelExists)
                <model-viewer
                    src="{{ asset($heroModelPath) }}"
                    alt="Model 3D {{ data_get($featured, '0.name', data_get($featured, '0.product_name')) }}"
                    camera-controls
                    auto-rotate
                    shadow-intensity="1"
                    exposure=".86"
                    loading="eager"
                ></model-viewer>
            @else
                <div class="gallery-model-fallback" aria-hidden="true">
                    <span class="product-shape"></span>
                </div>
            @endif
        </div>

        <div class="gallery-hero-copy">
            <p class="gallery-kicker">The Gallery // Exhibit 01</p>
            <h1 id="gallery-title">The Ruin Campaign</h1>
            <p>Collector-grade display toys with live stock, clear provenance, and a short path from inspection to checkout.</p>
            <div class="gallery-actions">
                <a class="gallery-btn gallery-btn-primary" href="{{ url('/products') }}">Enter Collection</a>
                <a class="gallery-btn gallery-btn-ghost" href="{{ url('/cart') }}">Open Vault</a>
            </div>
        </div>

        <a class="gallery-scroll" href="#collection-preview" aria-label="Scroll ke koleksi">
            <span>Enter Gallery</span>
            <i aria-hidden="true"></i>
        </a>
    </section>

    <section class="gallery-collection" id="collection-preview">
        <div class="gallery-section-head">
            <p class="gallery-kicker">Collection begins here</p>
            <h2>Masterpieces of engineering</h2>
            <a href="{{ url('/products') }}">View all works</a>
        </div>

        <div class="gallery-product-grid">
            @foreach($featured as $product)
                @php
                    $name = data_get($product, 'name', data_get($product, 'product_name'));
                    $category = data_get($product, 'category.category_name', data_get($product, 'category'));
                    $modelUrl = data_get($product, 'model_url');
                    $modelPath = $modelUrl ? ltrim(parse_url($modelUrl, PHP_URL_PATH) ?: $modelUrl, '/') : null;
                    $modelExists = $modelPath && (file_exists(public_path($modelPath)) || file_exists(base_path('frontend/public/' . $modelPath)));
                    $slug = data_get($product, 'slug', trim(strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)), '-'));
                @endphp
                <article class="gallery-product">
                    <a class="gallery-product-media" href="{{ route('products.show', $slug) }}" aria-label="Lihat {{ $name }}">
                        @if($modelExists)
                            <model-viewer
                                src="{{ asset($modelPath) }}"
                                alt="Model 3D {{ $name }}"
                                auto-rotate
                                shadow-intensity=".7"
                                loading="lazy"
                            ></model-viewer>
                        @else
                            <span class="product-shape" aria-hidden="true"></span>
                        @endif
                    </a>
                    <div class="gallery-product-body">
                        <span>{{ $category }}</span>
                        <h3>{{ $name }}</h3>
                        <div class="gallery-product-meta">
                            <x-price :amount="data_get($product, 'price')" />
                            <strong>{{ data_get($product, 'stock') }} in stock</strong>
                        </div>
                        <a class="gallery-btn gallery-btn-primary" href="{{ route('products.show', $slug) }}">Acquire</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</section>

<script>
    (() => {
        const loader = document.querySelector('[data-gallery-loader]');
        const counter = document.querySelector('[data-gallery-counter]');
        if (!loader || !counter) return;

        let progress = 0;
        const tick = window.setInterval(() => {
            progress = Math.min(100, progress + 20);
            counter.textContent = String(progress).padStart(2, '0') + '%';
            if (progress === 100) {
                window.clearInterval(tick);
                window.setTimeout(() => loader.classList.add('is-hidden'), 220);
            }
        }, 80);
    })();
</script>
@endsection
