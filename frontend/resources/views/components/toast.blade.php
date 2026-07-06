@props(['message' => session('status'), 'tone' => 'ok'])

@if($message || trim($slot) !== '')
    <div {{ $attributes->merge(['class' => 'toast toast-' . $tone]) }} role="status">{{ $message ?: $slot }}</div>
@endif
