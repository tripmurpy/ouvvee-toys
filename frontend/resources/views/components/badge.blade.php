@props(['tone' => 'default'])

@php($class = trim('badge ' . match ($tone) {
    'ok' => 'badge-ok',
    'warn' => 'badge-warn',
    'danger' => 'badge-danger',
    default => '',
}))

<span {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</span>
