@extends('layouts.store')

@section('title', 'Status Pesanan - Ouvvee Toys')

@section('content')
<section class="container section stack-lg">
    <div class="order-hero">
        <div>
            <p class="eyebrow">Order {{ $order->order_code }}</p>
            <h1 class="page-title">Status pesanan</h1>
            <p class="lead">Detail pembayaran, pengiriman, dan barang dalam satu tampilan.</p>
        </div>
        @if($order->payment->payment_status === 'unpaid')
            <form action="{{ route('orders.pay', $order) }}" method="post">
                @csrf
                <x-button type="submit">Bayar simulasi</x-button>
            </form>
        @endif
    </div>
    <div class="grid grid-4">
        <div class="card stat"><span class="muted">Pembayaran</span><strong>{{ $order->payment->payment_status }}</strong></div>
        <div class="card stat"><span class="muted">Pengiriman</span><strong>{{ $order->shipment->shipment_status }}</strong></div>
        <div class="card stat"><span class="muted">Kurir</span><strong>{{ $order->shipment->method->method_name }}</strong></div>
        <div class="card stat"><span class="muted">Total</span><strong><x-price :amount="$order->total_price" /></strong></div>
    </div>
    <div class="order-layout">
        <div class="card panel stack">
            <div>
                <p class="eyebrow">Barang</p>
                <h2 class="section-title">Isi pesanan</h2>
            </div>
            <div class="order-item-list">
                @foreach($order->items as $item)
                    @php($imagePath = $item->product->displayImagePath())
                    <article class="order-item-card">
                        <div class="order-item-media">
                            @if($imagePath)
                                <img src="{{ asset($imagePath) }}" alt="Foto {{ $item->product->product_name }}" loading="lazy">
                            @else
                                <span>{{ str($item->product->product_name)->substr(0, 1)->upper() }}</span>
                            @endif
                        </div>
                        <div class="order-item-copy">
                            <h3>{{ $item->product->product_name }}</h3>
                            <p class="muted">Qty {{ $item->quantity }} x <x-price :amount="$item->price_each" /></p>
                            @if(in_array($order->order_status, ['paid', 'processing', 'shipped', 'completed'], true))
                                <a class="small" href="{{ route('reviews.create', $item->product) }}">Tulis review</a>
                            @endif
                        </div>
                        <strong><x-price :amount="$item->total_price" /></strong>
                    </article>
                @endforeach
            </div>
        </div>
        <aside class="card panel stack order-summary-panel">
            <h2 class="section-title">Ringkasan</h2>
            <x-order-summary label="Subtotal" :amount="$order->subtotal" />
            <x-order-summary label="Ongkir" :amount="$order->shipping_cost" />
            <x-order-summary label="Total" :amount="$order->total_price" strong />
        </aside>
    </div>
</section>
@endsection
