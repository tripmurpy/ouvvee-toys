<header class="store-header">
    <div class="container nav">
        <a class="brand" href="{{ url('/') }}" aria-label="Ouvvee Toys home">
            <span class="brand-mark">OT</span>
            <span>Ouvvee Toys</span>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="{{ url('/products') }}">Katalog</a>
            <a href="{{ url('/wishlist') }}">Wishlist</a>
            <a href="{{ url('/orders/OVV-2407') }}">Status Pesanan</a>
            <a href="{{ url('/admin') }}">Admin</a>
        </nav>

        <div class="nav-actions">
            <form class="search" action="{{ url('/products') }}" method="get">
                <span aria-hidden="true">Search</span>
                <input name="q" type="search" placeholder="Cari mainan..." value="{{ request('q') }}">
            </form>
            <a class="btn btn-ghost" href="{{ url('/cart') }}">Cart</a>
            <a class="btn btn-primary" href="{{ url('/login') }}">Login</a>
        </div>
    </div>
</header>
