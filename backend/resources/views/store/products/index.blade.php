@extends('layouts.store')

@section('title', 'Katalog Mainan - Ouvvee Toys')
@section('body_class', 'storefront-page')

@php
    $products = $products ?? collect();
    $count = method_exists($products, 'total') ? $products->total() : (is_countable($products) ? count($products) : 0);
@endphp

@section('content')
<section class="shop-shell">
    <section class="shop-hero" aria-labelledby="collection-title">
        <div class="shop-hero-copy">
            <span class="eyebrow">Belanja koleksi Ouvvee Toys</span>
            <h1 id="collection-title">Baca detail pentingnya, lalu pilih figure yang paling pas.</h1>
            <p class="lead">Katalog ini dirapikan agar lebih enak dibaca: jarak antar elemen lebih lega, informasi utama langsung terlihat, dan preview 3D tetap tersedia di halaman detail produk.</p>
        </div>
    </section>

    <div class="shop-results-meta">
        <p><strong>{{ $count }}</strong> koleksi siap dilihat</p>
        <span class="shop-results-hint">Preview 3D tersedia di halaman detail produk.</span>
    </div>

    <div class="shop-results" id="collection-grid">
        @if($count)
                <div class="shop-grid">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                @if(method_exists($products, 'links'))
                    <div class="collection-pagination">
                        {{ $products->links() }}
                    </div>
                @endif
            @else
                <x-empty-state title="Produk tidak ditemukan" body="Koleksi belum tersedia. Cek kembali drop berikutnya." />
            @endif
    </div>
</section>
@endsection
