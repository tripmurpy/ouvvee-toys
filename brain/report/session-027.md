# Session 027

**Tanggal:** 2026-07-06
**Topik Sesi:** Implementasi awal Laravel penuh untuk Ouvvee Toys

## Keputusan Penting

- Folder `frontend/` dijadikan root app Laravel Blade-first.
- Tidak menambah SPA, Livewire, Inertia, atau dependency UI baru.
- Checkout dibuat transaction-safe dengan lock stok dan snapshot harga.
- Payment tetap simulasi dengan route bayar sederhana dari detail order.

## Perubahan Utama

- Menambahkan scaffold Laravel minimal:
  - `composer.json`, `.env.example`, `artisan`, `public/index.php`;
  - `bootstrap/`, `config/`, `routes/web.php`;
  - storage/cache directory placeholder.
- Menambahkan model Eloquent untuk user, alamat, produk, kategori, cart, order, payment, shipment, review, wishlist, dan shipping.
- Menambahkan controller untuk:
  - homepage dan katalog;
  - auth login/register/logout;
  - cart add/update/remove;
  - checkout transaction;
  - order history/status dan pembayaran simulasi;
  - wishlist;
  - review guard;
  - admin dashboard read-only.
- Menambahkan migration tunggal schema MVP dan seeder demo:
  - admin `admin@ouvvee.test` / `password`;
  - buyer `buyer@ouvvee.test` / `password`;
  - produk seed memakai asset `.glb` lokal existing;
  - payment method dan shipping rate.
- Mengubah Blade agar memakai route/form Laravel nyata:
  - product card submit add-to-cart;
  - cart update/delete;
  - checkout POST;
  - order detail/pay;
  - review POST;
  - auth forms CSRF;
  - admin dashboard aggregate real.
- Menghapus demo payload lokal dari view commerce utama.

## Verifikasi

- Static check PowerShell lulus:
  - `frontend/tests/static/verify-source.ps1`
- Check memastikan:
  - file Laravel inti tersedia;
  - stale demo payload lama tidak ada di Blade;
  - route utama tersedia;
  - checkout memakai `DB::transaction`, `lockForUpdate`, dan decrement stok.

## Batasan

- Runtime PHP test belum bisa dijalankan karena `php` dan `composer` tidak tersedia di PATH environment ini.
- Setelah PHP 8.3+ dan Composer tersedia, lanjutkan dengan:
  - `cd frontend`
  - `composer install`
  - `php artisan key:generate`
  - `php artisan migrate --seed`
  - `php artisan test`
  - `php artisan serve`
