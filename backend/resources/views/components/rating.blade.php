@props(['value' => 5, 'count' => null])

@php($stars = str_repeat('*', max(0, min(5, (int) $value))))

<span {{ $attributes->merge(['class' => 'rating']) }} aria-label="Rating {{ $value }} dari 5">
    {{ $stars }}@if($count)<span class="muted small"> ({{ $count }})</span>@endif
</span>
