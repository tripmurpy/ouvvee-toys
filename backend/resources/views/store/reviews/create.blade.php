@extends('layouts.store')

@section('title', 'Tulis Review - Ouvvee Toys')

@section('content')
<section class="container section">
    <form class="card panel stack-lg" style="max-width:720px" action="{{ route('reviews.store', $product) }}" method="post">
        @csrf
        <div>
            <p class="eyebrow">Review produk</p>
            <h1 class="page-title">Bagikan pengalaman</h1>
            <p class="muted">{{ $product->product_name }} / {{ $order->order_code }}</p>
        </div>
        <div class="field">
            <label for="rating">Rating</label>
            <select id="rating" name="rating" class="field-control">
                <option value="5">5 - Sangat baik</option>
                <option value="4">4 - Baik</option>
                <option value="3">3 - Cukup</option>
                <option value="2">2 - Kurang</option>
                <option value="1">1 - Buruk</option>
            </select>
        </div>
        <x-form-field label="Komentar" name="comment" type="textarea" rows="5" placeholder="Tulis komentar pembelian..." />
        <x-button type="submit">Kirim review</x-button>
    </form>
</section>
@endsection
