# Session 036

**Tanggal:** 2026-07-06
**Topik Sesi:** Koreksi env koneksi Supabase Laravel

## Keputusan Penting

- Laravel membaca env dari `backend/.env`, bukan hanya `.env` root.
- Koneksi Supabase tetap memakai konfigurasi PostgreSQL standar Laravel: host, port, database, username, password, dan SSL.
- `DB_URL` tidak dipakai karena placeholder `${DB_PASSWORD}` terbaca literal di config Laravel; field DB terpisah lebih aman dan cukup.

## Perubahan Utama

- Menyalin konfigurasi env root ke `backend/.env` agar runtime Laravel membaca host Supabase yang benar.
- Menghapus `DB_URL` dari `.env`, `.env.example`, dan `backend/.env`.

## Verifikasi

- `database.connections.pgsql.url` terbaca `null`.
- `database.connections.pgsql.host` terbaca `db.wugyxbudqzgmeuarpguf.supabase.co`.
- `database.connections.pgsql.sslmode` terbaca `require`.
- `.\.runtime\php-src\php.exe vendor\bin\phpunit --filter DatabaseConfigTest` lulus: 1 test, 3 assertions.

## Batasan

- Koneksi live belum bisa dites sampai `DB_PASSWORD` diisi dengan password database Supabase yang valid.
