{{-- ponytail: inline CSS keeps these Blade views runnable without a Vite scaffold; replace with @vite when npm/build files exist. --}}
@php
    $cssPath = file_exists(resource_path('css/app.css'))
        ? resource_path('css/app.css')
        : base_path('frontend/resources/css/app.css');
@endphp

@if(file_exists($cssPath))
    <style>{!! file_get_contents($cssPath) !!}</style>
@endif
