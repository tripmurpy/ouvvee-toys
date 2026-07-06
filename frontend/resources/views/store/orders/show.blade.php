@extends('layouts.store')

@section('title', 'Status Pesanan - Ouvvee Toys')

@section('content')
<section class="container section stack-lg">
    <div>
        <p class="eyebrow">Order OVV-2407</p>
        <h1 class="page-title">Status pesanan</h1>
    </div>
    <div class="grid grid-4">
        <div class="card stat"><span class="muted">Pembayaran</span><strong>Paid</strong></div>
        <div class="card stat"><span class="muted">Pengiriman</span><strong>Processing</strong></div>
        <div class="card stat"><span class="muted">Kurir</span><strong>JNE</strong></div>
        <div class="card stat"><span class="muted">Total</span><strong>Rp442rb</strong></div>
    </div>
    <div class="card panel table-wrap">
        <table class="table">
            <thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Total</th></tr></thead>
            <tbody>
                <tr><td>Galaxy Ranger Figure</td><td>1</td><td>Rp249.000</td><td>Rp249.000</td></tr>
                <tr><td>Puzzle Safari 120 pcs</td><td>2</td><td>Rp89.000</td><td>Rp178.000</td></tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
