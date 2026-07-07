# Session 047

**Tanggal:** 2026-07-07
**Topik Sesi:** QA audit website, koneksi database/API, dan bottleneck

## Hasil Check

- `vendor/bin/phpunit`: lulus, 18 test, 93 assertion, 2 deprecation.
- `tests/static/verify-source.ps1`: lulus.
- `artisan route:list`: 27 route terdaftar.
- `artisan migrate:status` ke Supabase: konek berhasil setelah network sandbox diizinkan; migration `2026_07_06_000000_create_ouvvee_schema` status `Ran`.
- HTTP smoke lokal: `/`, `/products`, `/products/{slug}`, `/api/products`, `/api/products?q=dragon`, `/login`, `/register`, dan `/up` merespons.
- API `/api/products` mengembalikan 9 produk live dari Supabase.

## Temuan Utama

- Fitur wishlist live berisiko error 500: log menunjukkan insert gagal karena `public.wishlists` tidak punya kolom `updated_at`, sementara `User::wishlists()` memakai `withTimestamps()`.
- Schema live `public.wishlists` berbeda dari migration repo: live punya `id_wishlist`, `id_user`, `id_product`, `created_at`; migration repo memakai primary composite plus timestamps.
- `APP_DEBUG=true` di `backend/.env`; aman untuk lokal, berbahaya kalau file env ini dipakai live karena stack trace/secret context bisa bocor.
- Semua command artisan memunculkan deprecation `PDO::MYSQL_ATTR_SSL_CA` pada PHP 8.5. Ini belum mematahkan test, tapi noise CLI/log akan terus muncul sampai runtime/framework diselaraskan.
- Katalog dan homepage memakai banyak asset GLB 3D berukuran 5.8-8 MB per file plus `model-viewer` dari `unpkg.com`; ini bottleneck UX terbesar di koneksi lambat/CDN bermasalah.
- Endpoint live cukup lambat untuk lokal: `/` sekitar 556 ms, `/products` sekitar 952 ms, `/api/products` sekitar 1296 ms, `/up` sekitar 108 ms. Supabase/network dan render 3D-heavy page kemungkinan faktor utama.
- Cache dan session memakai file driver. Cukup untuk dev/MVP kecil, tapi bukan setup ideal untuk multi-instance production.

## Batasan Audit

- Tidak menjalankan checkout/register/wishlist mutasi langsung ke Supabase agar tidak membuat data dummy live.
- Alur mutasi cart, checkout, payment, review, admin gate, auth gate, dan API katalog divalidasi lewat feature test SQLite in-memory.
- Tidak menambah test atau dependency baru; sesi ini report-only sesuai permintaan audit.
