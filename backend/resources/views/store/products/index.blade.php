@extends('layouts.store')

@section('title', 'The Collection - Ouvvee Toys')
@section('body_class', 'collection-page')

@php
    $products = $products ?? collect();
    $count = method_exists($products, 'total') ? $products->total() : (is_countable($products) ? count($products) : 0);
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
                @if(method_exists($products, 'links'))
                    <div class="collection-pagination">
                        {{ $products->links() }}
                    </div>
                @endif
            @else
                <x-empty-state title="Produk tidak ditemukan" body="Koleksi belum tersedia. Cek kembali drop berikutnya." />
            @endif
        </div>
    </div>
</section>
@endsection
