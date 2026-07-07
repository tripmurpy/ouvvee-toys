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
            <span class="eyebrow">Katalog Ouvvee Toys</span>
            <h1 id="collection-title">Koleksi figure pilihan, siap dilihat dari dekat.</h1>
            <p class="lead">Temukan display figure dengan foto produk, stok, ukuran, catatan keamanan, dan preview 3D di halaman detail saat tersedia.</p>
        </div>
    </section>

    <div class="shop-results-meta">
        <p><strong>{{ $count }}</strong> koleksi siap dilihat</p>
        <span class="shop-results-hint">Buka detail produk untuk melihat preview 3D saat tersedia.</span>
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
