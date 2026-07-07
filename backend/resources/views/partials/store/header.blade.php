<header class="store-header">
    <div class="container nav">
        <a class="brand" href="{{ url('/') }}" aria-label="Ouvvee Toys home">
            <span class="brand-mark">OT</span>
            <span>Ouvvee Toys</span>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="{{ route('products.index') }}">Katalog</a>
            <a href="{{ route('wishlist.index') }}">Wishlist</a>
            <a href="{{ route('orders.index') }}">Status Pesanan</a>
            @auth
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
            @endauth
        </nav>

        <div class="nav-actions">
            <form class="search" action="{{ route('products.index') }}" method="get">
                <span aria-hidden="true">Search</span>
                <input name="q" type="search" placeholder="Cari mainan..." value="{{ request('q') }}">
            </form>
            <a class="cart-icon-button" href="{{ route('cart.index') }}" aria-label="Buka keranjang"></a>
            @auth
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-primary" type="submit">Logout</button>
                </form>
            @else
                <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </div>
</header>
