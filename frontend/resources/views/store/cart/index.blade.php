@extends('layouts.store')

@section('title', 'Keranjang - Ouvvee Toys')

@section('content')
@php
    $items = $items ?? [
        ['name' => 'Galaxy Ranger Figure', 'price' => 249000, 'qty' => 1],
        ['name' => 'Puzzle Safari 120 pcs', 'price' => 89000, 'qty' => 2],
    ];
    $subtotal = array_sum(array_map(fn ($item) => $item['price'] * $item['qty'], $items));
@endphp

<section class="container section split">
    <div class="stack-lg">
        <div>
            <p class="eyebrow">Keranjang</p>
            <h1 class="page-title">Cek item</h1>
        </div>
        @forelse($items as $item)
            <div class="card panel cart-row">
                <div class="thumb" aria-hidden="true"></div>
                <div>
                    <strong>{{ $item['name'] }}</strong>
                    <p class="muted small"><x-price :amount="$item['price']" /> per item</p>
                </div>
                <div class="actions">
                    <input class="field-control" style="width:82px" data-qty type="number" min="1" value="{{ $item['qty'] }}" aria-label="Jumlah {{ $item['name'] }}">
                    <x-button variant="ghost">Hapus</x-button>
                </div>
            </div>
        @empty
            <x-empty-state title="Keranjang kosong" body="Tambahkan produk dari katalog sebelum checkout." />
        @endforelse
    </div>
    <aside class="card panel stack">
        <h2 style="margin:0">Ringkasan</h2>
        <x-order-summary label="Subtotal" :amount="$subtotal" />
        <x-order-summary label="Estimasi ongkir">Pilih saat checkout</x-order-summary>
        <x-order-summary label="Total sementara" :amount="$subtotal" strong />
        <x-button href="{{ url('/checkout') }}">Checkout</x-button>
    </aside>
</section>
@endsection
