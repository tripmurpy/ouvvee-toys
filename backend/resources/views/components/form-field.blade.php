@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'error' => null,
])

<div class="field">
    <label for="{{ $name }}">{{ $label }}</label>
    @if($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" class="field-control" {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" class="field-control" {{ $attributes }}>
    @endif
    @if($error || $errors->has($name))
        <span class="field-error">{{ $error ?? $errors->first($name) }}</span>
    @endif
</div>
