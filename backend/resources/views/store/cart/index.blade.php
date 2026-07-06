@extends('layouts.store')

@section('title', 'Keranjang - Ouvvee Toys')

@section('content')
@php
    $items = $items ?? collect();
    $subtotal = $subtotal ?? $items->sum(fn ($item) => $item->quantity * (float) $item->product->price);
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
                    <strong>{{ $item->product->product_name }}</strong>
                    <p class="muted small"><x-price :amount="$item->product->price" /> per item</p>
                </div>
                <div class="actions">
                    <form action="{{ route('cart.items.update', $item) }}" method="post" class="actions">
                        @csrf
                        @method('patch')
                        <input class="field-control" style="width:82px" data-qty type="number" name="quantity" min="1" max="{{ $item->product->stock }}" value="{{ $item->quantity }}" aria-label="Jumlah {{ $item->product->product_name }}">
                        <x-button type="submit" variant="ghost">Update</x-button>
                    </form>
                    <form action="{{ route('cart.items.destroy', $item) }}" method="post">
                        @csrf
                        @method('delete')
                        <x-button type="submit" variant="ghost">Hapus</x-button>
                    </form>
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
        <x-button href="{{ route('checkout.index') }}">Checkout</x-button>
    </aside>
</section>
@endsection
