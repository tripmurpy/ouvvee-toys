@extends('layouts.store')

@section('title', 'Wishlist - Ouvvee Toys')

@section('content')
@php
    $products = $products ?? [
        ['name' => 'Luna Plush Doll', 'category' => 'Boneka', 'price' => 159000, 'stock' => 4, 'age' => '3+', 'rating' => 4],
        ['name' => 'City Racer Mini', 'category' => 'Mobil', 'price' => 129000, 'stock' => 6, 'age' => '5+', 'rating' => 4],
    ];
@endphp

<section class="container section stack-lg">
    <div>
        <p class="eyebrow">Wishlist</p>
        <h1 class="page-title">Mainan favorit</h1>
    </div>
    <div class="grid grid-3">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
@endsection
