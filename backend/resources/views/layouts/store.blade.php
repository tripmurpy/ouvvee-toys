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
    <script>
        (() => {
            const formatRupiah = (value) => new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(value);

            document.querySelectorAll('[data-product-gallery]').forEach((gallery) => {
                const mainImage = gallery.querySelector('[data-product-main-image]');
                if (!mainImage) return;

                gallery.querySelectorAll('[data-product-thumb]').forEach((thumb) => {
                    thumb.addEventListener('click', () => {
                        mainImage.src = thumb.dataset.imageSrc;
                        mainImage.alt = thumb.dataset.imageAlt;
                        gallery.querySelectorAll('[data-product-thumb]').forEach((item) => item.classList.remove('is-active'));
                        thumb.classList.add('is-active');
                    });
                });
            });

            document.querySelectorAll('[data-purchase-card]').forEach((card) => {
                const price = Number(card.dataset.price || 0);
                const qtyInput = card.querySelector('[data-purchase-qty]');
                const subtotal = card.querySelector('[data-purchase-subtotal]');
                const redirectInput = card.querySelector('[data-purchase-redirect]');

                const syncSubtotal = () => {
                    if (!qtyInput || !subtotal) return;
                    const nextValue = Math.min(
                        Number(qtyInput.max || 99),
                        Math.max(Number(qtyInput.min || 1), Number(qtyInput.value || 1))
                    );
                    qtyInput.value = nextValue;
                    subtotal.textContent = formatRupiah(nextValue * price);
                };

                syncSubtotal();
                qtyInput?.addEventListener('input', syncSubtotal);
                qtyInput?.addEventListener('change', syncSubtotal);

                card.querySelectorAll('[data-purchase-action]').forEach((button) => {
                    button.addEventListener('click', () => {
                        if (redirectInput) redirectInput.value = button.dataset.purchaseAction || 'cart';
                    });
                });
            });

            document.addEventListener('click', (event) => {
                const backLink = event.target.closest('[data-back-button]');
                if (backLink && document.referrer.startsWith(window.location.origin) && window.history.length > 1) {
                    event.preventDefault();
                    window.history.back();
                    return;
                }

                const copyButton = event.target.closest('[data-copy-url]');
                if (copyButton) {
                    const url = copyButton.dataset.copyUrl;
                    if (!url) return;

                    const done = () => copyButton.textContent = 'Link disalin';
                    const restore = () => window.setTimeout(() => copyButton.textContent = 'Share', 1600);

                    if (navigator.clipboard?.writeText) {
                        navigator.clipboard.writeText(url).then(done).then(restore);
                    } else {
                        window.prompt('Salin link produk ini:', url);
                    }

                    return;
                }

                const button = event.target.closest('[data-qty]');
                if (!button) return;
                const input = button.parentElement.querySelector('input[type="number"]');
                if (!input) return;
                input.value = Math.min(Number(input.max || 99), Math.max(Number(input.min || 1), Number(input.value || 1) + Number(button.dataset.qty)));
                input.dispatchEvent(new Event('input', { bubbles: true }));
            });

            document.addEventListener('submit', (event) => {
                const form = event.target.closest('[data-cart-form]');
                if (form && event.submitter instanceof HTMLButtonElement) event.submitter.textContent = 'Menambahkan...';
            });
        })();
    </script>
</body>
</html>
