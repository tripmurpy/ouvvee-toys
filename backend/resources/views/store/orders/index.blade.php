@extends('layouts.store')

@section('title', 'Pesanan - Ouvvee Toys')

@section('content')
<section class="container section stack-lg">
    <div>
        <p class="eyebrow">Pesanan</p>
        <h1 class="page-title">Riwayat pesanan</h1>
    </div>

    <div class="card panel table-wrap">
        <table class="table">
            <thead><tr><th>Kode</th><th>Status</th><th>Pembayaran</th><th>Total</th><th></th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->order_status }}</td>
                        <td>{{ $order->payment->payment_status }}</td>
                        <td><x-price :amount="$order->total_price" /></td>
                        <td><a href="{{ route('orders.show', $order) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
