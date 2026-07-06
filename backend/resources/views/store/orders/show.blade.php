@extends('layouts.store')

@section('title', 'Status Pesanan - Ouvvee Toys')

@section('content')
<section class="container section stack-lg">
    <div>
        <p class="eyebrow">Order {{ $order->order_code }}</p>
        <h1 class="page-title">Status pesanan</h1>
    </div>
    <div class="grid grid-4">
        <div class="card stat"><span class="muted">Pembayaran</span><strong>{{ $order->payment->payment_status }}</strong></div>
        <div class="card stat"><span class="muted">Pengiriman</span><strong>{{ $order->shipment->shipment_status }}</strong></div>
        <div class="card stat"><span class="muted">Kurir</span><strong>{{ $order->shipment->method->method_name }}</strong></div>
        <div class="card stat"><span class="muted">Total</span><strong><x-price :amount="$order->total_price" /></strong></div>
    </div>
    @if($order->payment->payment_status === 'unpaid')
        <form action="{{ route('orders.pay', $order) }}" method="post">
            @csrf
            <x-button type="submit">Bayar simulasi</x-button>
        </form>
    @endif
    <div class="card panel table-wrap">
        <table class="table">
            <thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Total</th><th></th></tr></thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td><x-price :amount="$item->price_each" /></td>
                        <td><x-price :amount="$item->total_price" /></td>
                        <td>
                            @if(in_array($order->order_status, ['paid', 'processing', 'shipped', 'completed'], true))
                                <a href="{{ route('reviews.create', $item->product) }}">Review</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
