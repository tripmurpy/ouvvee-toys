@extends('layouts.admin')

@section('title', 'Dashboard Admin - Ouvvee Toys')

@section('content')
<section class="stack-lg">
    <div>
        <p class="eyebrow">Dashboard read-only</p>
        <h1 class="page-title">Ringkasan toko</h1>
        <p class="lead">Admin melihat penjualan, pesanan, dan stok rendah tanpa fitur CRUD produk.</p>
    </div>
    <div class="grid grid-4">
        <div class="card stat"><span class="muted">Penjualan</span><strong><x-price :amount="$salesTotal" /></strong></div>
        <div class="card stat"><span class="muted">Pesanan</span><strong>{{ $orderCount }}</strong></div>
        <div class="card stat"><span class="muted">Stok rendah</span><strong>{{ $lowStockCount }}</strong></div>
        <div class="card stat"><span class="muted">Review</span><strong>{{ $reviewAverage ?: '-' }}</strong></div>
    </div>
    <div class="card panel table-wrap">
        <table class="table">
            <thead><tr><th>Produk</th><th>Kategori</th><th>Stok</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->category->category_name }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><x-badge tone="warn">Rendah</x-badge></td>
                    </tr>
                @empty
                    <tr><td colspan="4">Tidak ada stok rendah.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card panel table-wrap">
        <table class="table">
            <thead><tr><th>Order</th><th>Pembeli</th><th>Status</th><th>Total</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->order_status }}</td>
                        <td><x-price :amount="$order->total_price" /></td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
