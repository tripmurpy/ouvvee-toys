@extends('layouts.store')

@section('title', 'The Collection - Ouvvee Toys')
@section('body_class', 'collection-page')

@php
    // ponytail: local demo catalog stays here until product data is centralized for catalog + detail.
    $products = $products ?? [
        ['name' => 'Ruin Sentinel Type-Zero', 'brand' => 'Ouvvee Works', 'label' => 'New Release', 'category' => 'Mecha', 'price' => 249000, 'stock' => 12, 'age' => '8+', 'rating' => 5, 'reviews' => 24, 'model_url' => '/models/products/robot_police.glb'],
        ['name' => 'Ashen Builder Unit', 'brand' => 'Foundry Series', 'label' => 'Limited Run', 'category' => 'Construction', 'price' => 189000, 'stock' => 6, 'age' => '5+', 'rating' => 4, 'reviews' => 18, 'model_url' => '/models/products/bulldozer.glb'],
        ['name' => 'Crimson Crab Drone', 'brand' => 'Drone Archive', 'label' => 'Curator Pick', 'category' => 'Drone', 'price' => 229000, 'stock' => 9, 'age' => '8+', 'rating' => 5, 'reviews' => 31, 'model_url' => '/models/products/robot_crab.glb'],
        ['name' => 'Excavator Relic Mk-II', 'brand' => 'Foundry Series', 'label' => 'Heavy Grade', 'category' => 'Construction', 'price' => 279000, 'stock' => 3, 'age' => '7+', 'rating' => 4, 'reviews' => 12, 'model_url' => '/models/products/excavator.glb'],
        ['name' => 'Dragonborn Display Figure', 'brand' => 'Mythos Lab', 'label' => 'Sold Out', 'category' => 'Mythos', 'price' => 319000, 'stock' => 0, 'age' => '10+', 'rating' => 4, 'reviews' => 16, 'model_url' => '/models/products/dragonborn.glb'],
        ['name' => 'Orbital Carrier Ship', 'brand' => 'Orbit Foundry', 'label' => 'Vault Ready', 'category' => 'Vehicle', 'price' => 209000, 'stock' => 7, 'age' => '6+', 'rating' => 5, 'reviews' => 21, 'model_url' => '/models/products/ship.glb'],
    ];

    $count = is_countable($products) ? count($products) : 0;
@endphp

@section('content')
<section class="collection-shell">
    <section class="collection-hero" aria-labelledby="collection-title">
        <div class="collection-hero-copy">
            <span>OUVVEE TOYS DROP</span>
            <h1 id="collection-title">Your Next Display Piece Starts Here</h1>
            <p>From iconic figures to limited collectibles, explore every toy with immersive 3D previews.</p>
            <a class="collection-btn collection-btn-primary" href="#collection-grid">SEE THE DROP</a>
        </div>
        <div class="collection-hero-art" aria-hidden="true">
            <i></i>
            <strong>NEW<br>DROP.</strong>
        </div>
    </section>

    <div class="collection-layout">
        <div class="collection-results" id="collection-grid">
            <div class="collection-results-head">
                <p>Showing <strong>{{ $count }} Works</strong> in Collection</p>
            </div>

            @if($count)
                <div class="collection-grid">
                    @foreach($products as $product)
                        <x-product-card :product="$product" class="collection-card" />
                    @endforeach
                </div>
            @else
                <x-empty-state title="Produk tidak ditemukan" body="Koleksi belum tersedia. Cek kembali drop berikutnya." />
            @endif
        </div>
    </div>
</section>
@endsection
