@extends('layouts.store')

@section('title', 'Checkout - Ouvvee Toys')

@section('content')
<section class="container section split">
    <form class="stack-lg" action="{{ route('checkout.store') }}" method="post">
        @csrf
        <div>
            <p class="eyebrow">Checkout login</p>
            <h1 class="page-title">Alamat dan pembayaran</h1>
            <p class="lead">Pembayaran masih simulasi. Pengiriman tersedia untuk JNE dan GOJEK.</p>
        </div>
        <div class="card panel stack">
            <h2 style="margin:0">Alamat</h2>
            <x-form-field label="Nama penerima" name="recipient_name" :value="data_get($address, 'recipient_name', auth()->user()->name)" />
            <x-form-field label="Nomor telepon" name="phone" :value="data_get($address, 'phone', auth()->user()->phone)" />
            <x-form-field label="Provinsi" name="province" :value="data_get($address, 'province', 'DKI Jakarta')" />
            <x-form-field label="Kota" name="city" :value="data_get($address, 'city', 'Jakarta')" />
            <x-form-field label="Kecamatan" name="district" :value="data_get($address, 'district', 'Kebayoran Baru')" />
            <x-form-field label="Alamat lengkap" name="detail_address" type="textarea" rows="4" :value="data_get($address, 'detail_address')" />
            <x-form-field label="Kode pos" name="postal_code" :value="data_get($address, 'postal_code')" />
        </div>
        <div class="card panel grid grid-2">
            <div class="field">
                <label for="payment">Pembayaran</label>
                <select id="payment" name="id_payment_method" class="field-control">
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id_payment_method }}">{{ $method->method_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="shipping">Pengiriman</label>
                <select id="shipping" name="id_shipping_method" class="field-control">
                    @foreach($shippingMethods as $method)
                        <option value="{{ $method->id_shipping_method }}">{{ $method->method_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <x-button type="submit">Buat pesanan simulasi</x-button>
    </form>
    <aside class="card panel stack">
        <h2 style="margin:0">Ringkasan pesanan</h2>
        <x-order-summary label="Subtotal" :amount="$subtotal" />
        <x-order-summary label="Estimasi ongkir" :amount="$shippingCost" />
        <x-order-summary label="Total" :amount="$total" strong />
    </aside>
</section>
@endsection
