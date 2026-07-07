# Session 042

**Tanggal:** 2026-07-07
**Topik Sesi:** Analisis dan perbaikan auth register/login yang menabrak SQLite legacy

## Keputusan Penting

- Error register bukan dari form auth, tetapi dari proses dev server yang masih hidup dengan state database SQLite lama.
- Kode auth (`AuthController`, `User`, migration) sudah konsisten memakai `password_hash`; yang bentrok adalah schema `backend/database/database.sqlite` legacy.
- Solusi paling kecil adalah restart server ke env backend saat ini dan tambah check auth supaya regresi cepat ketahuan.

## Perubahan Utama

- Menambah test [backend/tests/Feature/AuthFlowTest.php](/C:/Users/ASUS/Documents/.Benny/project/.ouvetoys/backend/tests/Feature/AuthFlowTest.php) untuk register dan login.
- Menghentikan proses PHP server lama dan menyalakan ulang `artisan serve` dari folder `backend`.

## Verifikasi

- `vendor/bin/phpunit --filter AuthFlowTest` lulus.
- CLI Laravel membaca `database.default=pgsql`.
- Migrasi aktif ada di PostgreSQL, bukan SQLite legacy.
