@extends('layouts.auth')

@section('title', 'Register - Ouvvee Toys')

@section('content')
<main class="auth-card card stack-lg">
    <a class="brand" href="{{ url('/') }}"><span class="brand-mark">OT</span><span>Ouvvee Toys</span></a>
    <div>
        <p class="eyebrow">Daftar</p>
        <h1 style="margin:0">Buat akun pembeli</h1>
    </div>
    <form class="stack" action="{{ route('register') }}" method="post">
        @csrf
        <x-form-field label="Nama" name="name" placeholder="Nama lengkap" />
        <x-form-field label="Email" name="email" type="email" placeholder="nama@email.com" />
        <x-form-field label="Password" name="password" type="password" placeholder="Password" />
        <x-form-field label="Konfirmasi password" name="password_confirmation" type="password" placeholder="Ulangi password" />
        <x-button type="submit">Register</x-button>
        <a class="muted small" href="{{ url('/login') }}">Sudah punya akun? Login</a>
    </form>
</main>
@endsection
