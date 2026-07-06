<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale() ?? 'id') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Auth - Ouvvee Toys')</title>
    @include('partials.frontend-assets')
</head>
<body class="auth-page">
    @yield('content')
</body>
</html>
