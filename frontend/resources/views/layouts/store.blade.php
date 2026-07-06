<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale() ?? 'id') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ouvvee Toys')</title>
    @include('partials.frontend-assets')
    @stack('head')
</head>
<body class="@yield('body_class')">
    <div class="shell">
        @include('partials.store.header')
        <main id="main-content" class="main">
            @if(session('success') || session('error'))
                <div class="container" style="padding-top:16px">
                    <x-toast :tone="session('error') ? 'danger' : 'ok'">
                        {{ session('error') ?? session('success') }}
                    </x-toast>
                </div>
            @endif
            @yield('content')
        </main>
        @include('partials.store.footer')
    </div>
</body>
</html>
