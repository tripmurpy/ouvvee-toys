@extends('layouts.store')

@section('title', 'Checkout - Ouvvee Toys')

@section('content')
<section class="container section split">
    <form class="stack-lg">
        <div>
            <p class="eyebrow">Checkout login</p>
            <h1 class="page-title">Alamat dan pembayaran</h1>
            <p class="lead">Pembayaran masih simulasi. Pengiriman tersedia untuk JNE dan GOJEK.</p>
        </div>
        <div class="card panel stack">
            <h2 style="margin:0">Alamat</h2>
            <x-form-field label="Nama penerima" name="recipient_name" value="Benny" />
            <x-form-field label="Nomor telepon" name="phone" value="081234567890" />
            <x-form-field label="Alamat lengkap" name="address" type="textarea" rows="4" value="Jl. Mainan No. 7, Jakarta" />
        </div>
        <div class="card panel grid grid-2">
            <div class="field">
                <label for="payment">Pembayaran</label>
                <select id="payment" name="payment" class="field-control">
                    <option>Transfer Bank</option>
                    <option>Kartu Kredit</option>
                    <option>COD</option>
                </select>
            </div>
            <div class="field">
                <label for="shipping">Pengiriman</label>
                <select id="shipping" name="shipping" class="field-control">
                    <option>JNE</option>
                    <option>GOJEK</option>
                </select>
            </div>
        </div>
        <x-button type="submit">Buat pesanan simulasi</x-button>
    </form>
    <aside class="card panel stack">
        <h2 style="margin:0">Ringkasan pesanan</h2>
        <x-order-summary label="Subtotal" :amount="427000" />
        <x-order-summary label="Ongkir JNE" :amount="15000" />
        <x-order-summary label="Total" :amount="442000" strong />
    </aside>
</section>
@endsection
