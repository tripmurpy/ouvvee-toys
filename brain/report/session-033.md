# Session 033

**Tanggal:** 2026-07-06
**Topik Sesi:** Implementasi MVP backend web

## Keputusan Penting

- Scope tetap Blade web backend. API v1, queue, cache warming, dan hardening produksi belum ditambahkan.
- Route kategori memakai view katalog yang sudah ada agar tidak membuat halaman baru.
- Status order, payment, shipment, cart, product, dan role admin dipusatkan di model constants. Enum payment database tetap `unpaid` melalui `Payment::STATUS_PENDING`.
- Admin dashboard memakai Laravel Gate `access-admin` dan config `app.low_stock_threshold`.

## Perubahan Utama

- Menambahkan route publik `/categories/{category:slug}` untuk browse produk aktif per kategori.
- Mengetatkan cart update agar produk inactive tidak bisa diproses dan ownership cart item tetap dicek pada active cart.
- Mengetatkan checkout dengan status constants, validasi ulang active product/stock dalam transaksi, snapshot harga, ongkir dari shipping rate, dan status cart checked out.
- Menghapus direct `env()` dari controller backend yang disentuh.
- Menambah/menyesuaikan feature tests untuk category browse, cart merge batas stok, checkout stok habis, ownership cart/order, review guard, auth guard, dan admin gate.

## Verifikasi

- `.\.runtime\php-src\php.exe .\vendor\bin\phpunit tests\Feature\CatalogTest.php tests\Feature\CheckoutTest.php tests\Feature\ReviewAndAdminTest.php tests\Feature\AuthGateTest.php` lulus.
- `.\.runtime\php-src\php.exe .\vendor\bin\phpunit` lulus.

## Catatan

- PHPUnit masih melaporkan 2 deprecation dari konfigurasi/runtime lama, tidak memblokir test.
