@props(['message' => session('status')])

@if($message)
    <div class="toast" role="status">{{ $message }}</div>
@endif
