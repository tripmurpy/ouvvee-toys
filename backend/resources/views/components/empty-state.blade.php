@props(['title' => 'Belum ada data', 'body' => 'Data akan tampil di sini setelah tersedia.', 'action' => null])

<div {{ $attributes->merge(['class' => 'card panel stack']) }}>
    <x-badge>Empty</x-badge>
    <h2 style="margin:0">{{ $title }}</h2>
    <p class="muted" style="margin:0">{{ $body }}</p>
    @if($action)
        <div>{{ $action }}</div>
    @endif
</div>
