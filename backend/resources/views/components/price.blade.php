@props(['amount' => 0])

<span {{ $attributes->merge(['class' => 'price']) }}>
    Rp{{ number_format((float) $amount, 0, ',', '.') }}
</span>
