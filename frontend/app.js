(function () {
    const apiBaseUrl = document.querySelector('meta[name="api-base-url"]')?.content?.replace(/\/$/, '') || 'http://127.0.0.1:8000';
    const grid = document.querySelector('#product-grid');
    const statusText = document.querySelector('#status-text');
    const searchForm = document.querySelector('#search-form');
    const searchInput = document.querySelector('#search-input');
    const refreshButton = document.querySelector('#refresh-button');
    const template = document.querySelector('#product-card-template');
    const currency = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
    const fallbackImage = 'data:image/svg+xml;utf8,' + encodeURIComponent(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480">' +
        '<rect width="640" height="480" fill="#f1e4d6"/>' +
        '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#8f3515" font-family="Georgia, serif" font-size="32">Ouvvee Toys</text>' +
        '</svg>'
    );

    async function loadProducts() {
        const q = searchInput.value.trim();
        const url = new URL(`${apiBaseUrl}/api/products`);

        if (q) {
            url.searchParams.set('q', q);
        }

        statusText.textContent = 'Memuat katalog live...';

        try {
            const response = await fetch(url, {
                headers: {
                    Accept: 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const payload = await response.json();
            renderProducts(payload.data || []);
            statusText.textContent = `${payload.meta?.total ?? 0} produk tersambung. Update terakhir ${new Date().toLocaleTimeString('id-ID')}.`;
        } catch (error) {
            renderProducts([]);
            statusText.textContent = `Gagal ambil data dari ${apiBaseUrl}. Pastikan backend Laravel jalan.`;
            console.error(error);
        }
    }

    function renderProducts(products) {
        grid.innerHTML = '';

        if (!products.length) {
            const empty = document.createElement('div');
            empty.className = 'empty-state';
            empty.textContent = 'Tidak ada produk untuk ditampilkan.';
            grid.appendChild(empty);
            return;
        }

        for (const product of products) {
            const fragment = template.content.cloneNode(true);
            const image = fragment.querySelector('.card-image');

            image.src = product.image_url || fallbackImage;
            image.alt = product.name || 'Product image';

            fragment.querySelector('.card-category').textContent = product.category || 'Tanpa kategori';
            fragment.querySelector('.card-title').textContent = product.name || '-';
            fragment.querySelector('.card-price').textContent = currency.format(product.price || 0);
            fragment.querySelector('.card-stock').textContent = `${product.stock ?? 0} stok tersedia`;
            fragment.querySelector('.card-description').textContent = product.description || 'Produk aktif tanpa deskripsi tambahan.';

            const link = fragment.querySelector('.card-link');
            link.href = product.product_url || '#';

            grid.appendChild(fragment);
        }
    }

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        loadProducts();
    });

    refreshButton.addEventListener('click', loadProducts);

    loadProducts();
}());
