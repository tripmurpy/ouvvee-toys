@extends('layouts.auth')

@section('title', 'Login - Ouvvee Toys')

@section('content')
<main class="auth-card card stack-lg">
    <a class="brand" href="{{ url('/') }}"><span class="brand-mark">OT</span><span>Ouvvee Toys</span></a>
    <div>
        <p class="eyebrow">Masuk</p>
        <h1 style="margin:0">Login untuk checkout</h1>
    </div>
    <form class="stack" action="{{ route('login') }}" method="post">
        @csrf
        <x-form-field label="Email" name="email" type="email" placeholder="nama@email.com" />
        <x-form-field label="Password" name="password" type="password" placeholder="Password" />
        <x-button type="submit">Login</x-button>
        <a class="muted small" href="{{ url('/register') }}">Belum punya akun? Register</a>
    </form>
</main>
@endsection
