@props(['label', 'amount' => null, 'strong' => false])

<div {{ $attributes->merge(['class' => 'summary-row' . ($strong ? ' summary-total' : '')]) }}>
    <span>{{ $label }}</span>
    @if(! is_null($amount))
        <x-price :amount="$amount" />
    @else
        <span>{{ $slot }}</span>
    @endif
</div>
