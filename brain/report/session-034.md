# Session 034

**Tanggal:** 2026-07-06
**Topik Sesi:** Memindahkan Laravel backend ke folder backend

## Keputusan Penting

- Seluruh Laravel app dipindahkan sebagai satu unit dari `frontend/` ke `backend/`.
- Folder `backend/` sekarang menjadi root runnable untuk Artisan, Composer, PHPUnit, routes, controllers, models, migrations, views, public assets, runtime PHP, dan vendor.
- Folder `frontend/` tidak berisi app aktif. Isinya hanya README pointer karena UI saat ini masih Blade server-rendered di `backend/resources/views`.
- Nested metadata `frontend/.git` tidak dipindahkan karena bukan kode backend dan root repo sudah punya `.git`.

## Perubahan Utama

- Memindahkan isi Laravel project ke `backend/`.
- Memindahkan `.env` dan `.env.example` ke `backend/`.
- Menyesuaikan `backend/README.md` agar command run/test memakai root baru.
- Menambahkan `frontend/README.md` agar struktur repo jelas.
- Mengubah referensi path dokumen aktif dari `frontend/...` ke `backend/...`.

## Verifikasi

- `.\.runtime\php-src\php.exe .\vendor\bin\phpunit` dijalankan dari `backend/` dan lulus: 10 tests, 46 assertions.

## Catatan

- PHPUnit masih melaporkan 2 deprecation lama, tidak memblokir test.
- Historical report lama tetap menyebut `frontend/...` sebagai catatan masa lalu.
