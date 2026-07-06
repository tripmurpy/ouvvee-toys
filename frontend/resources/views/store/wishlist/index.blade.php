@extends('layouts.store')

@section('title', 'Wishlist - Ouvvee Toys')

@section('content')
@php
    $products = $products ?? collect();
@endphp

<section class="container section stack-lg">
    <div>
        <p class="eyebrow">Wishlist</p>
        <h1 class="page-title">Mainan favorit</h1>
    </div>
    <div class="grid grid-3">
        @forelse($products as $product)
            <x-product-card :product="$product" />
        @empty
            <x-empty-state title="Wishlist kosong" body="Simpan produk favorit dari katalog." />
        @endforelse
    </div>
</section>
@endsection
