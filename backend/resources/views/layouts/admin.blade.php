<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale() ?? 'id') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - Ouvvee Toys')</title>
    @include('partials.frontend-assets')
</head>
<body class="admin-page">
    <div class="admin-layout">
        @include('partials.admin.sidebar')
        <main class="admin-main">
            @yield('content')
        </main>
    </div>
</body>
</html>
