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
        <div class="card stat"><span class="muted">Penjualan</span><strong>Rp12,8jt</strong></div>
        <div class="card stat"><span class="muted">Pesanan</span><strong>84</strong></div>
        <div class="card stat"><span class="muted">Stok rendah</span><strong>6</strong></div>
        <div class="card stat"><span class="muted">Review</span><strong>4.8</strong></div>
    </div>
    <div class="card panel table-wrap">
        <table class="table">
            <thead><tr><th>Produk</th><th>Kategori</th><th>Stok</th><th>Status</th></tr></thead>
            <tbody>
                <tr><td>Galaxy Ranger Figure</td><td>Figur</td><td>12</td><td><x-badge tone="ok">Aman</x-badge></td></tr>
                <tr><td>Luna Plush Doll</td><td>Boneka</td><td>4</td><td><x-badge tone="warn">Rendah</x-badge></td></tr>
                <tr><td>City Racer Mini</td><td>Mobil</td><td>6</td><td><x-badge tone="ok">Aman</x-badge></td></tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
