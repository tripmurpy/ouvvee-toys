# Session 039

**Tanggal:** 2026-07-07
**Topik Sesi:** Sambungkan backend Laravel ke Supabase PostgreSQL live

## Keputusan Penting

- Backend tetap memakai koneksi PostgreSQL Laravel/Eloquent, tanpa Supabase SDK baru.
- Supabase live sudah punya schema dan 9 produk, jadi katalog seeder baru tidak ditambah.
- Migration Laravel dibaseline di tabel `migrations` karena schema live sudah ada tetapi belum tercatat.
- Model backend disesuaikan ke schema live Supabase: UUID primary key, `users.password_hash`, dan enum status `pending`/`processed`.

## Perubahan Utama

- Menambahkan `HasUuids` ke model Eloquent yang memakai primary key UUID.
- User auth memakai `password_hash` sebagai kolom password Laravel.
- Checkout tidak lagi meng-cast `id_shipping_method` ke integer agar UUID Supabase tidak berubah menjadi `0`.
- Migration lokal disesuaikan dengan UUID key dan enum status live.
- Supabase live ditambah kolom `users.remember_token` jika belum ada.

## Verifikasi

- `php artisan config:clear` berhasil.
- `php artisan migrate:status --no-interaction` menunjukkan `2026_07_06_000000_create_ouvvee_schema` status `Ran`.
- `php artisan db:seed --force --no-interaction` berhasil.
- `.\.runtime\php-src\php.exe .\vendor\bin\phpunit` lulus: 11 tests, 47 assertions, 2 deprecations lama.
- Smoke live via Laravel kernel: `/` status 200, `/products` status 200, `products=9`.

## Catatan

- `php artisan test` tidak tersedia di project ini; verifikasi memakai PHPUnit langsung.
- Smoke checkout live permanen tidak dijalankan agar tidak membuat order dan mengubah stok nyata di Supabase.
