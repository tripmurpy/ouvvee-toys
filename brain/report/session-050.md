# Session 050

**Tanggal:** 2026-07-07
**Topik Sesi:** Perbaikan QA dari session-047

## Keputusan Penting

- Wishlist schema drift sudah selesai di session-048, jadi tidak diubah lagi.
- `APP_DEBUG=false` sudah berlaku di root/backend env dan example env; `.env` tidak di-track sesuai session-049.
- Deprecation `PDO::MYSQL_ATTR_SSL_CA` berasal dari merge base config Laravel yang memuat koneksi MySQL/MariaDB vendor walau app memakai PostgreSQL.
- Katalog list tidak boleh memuat GLB massal; preview 3D tetap ada di homepage hero dan detail produk.

## Perubahan Utama

- `backend/bootstrap/app.php` memanggil `dontMergeFrameworkConfiguration()` setelah app dibuat agar config vendor yang tidak dipakai tidak dimuat.
- Copy katalog diperjelas: kartu/list memakai foto dan preview 3D diarahkan ke halaman detail.
- Test katalog disesuaikan untuk memastikan list tidak lagi merender model 3D kartu.

## Verifikasi

- `.runtime\php-src\php.exe vendor\bin\phpunit --testsuite Feature`: lulus, 18 test, 93 assertion, tanpa deprecation.
- `.runtime\php-src\php.exe artisan route:list --except-vendor`: 25 route tampil, tanpa deprecation.
- `.runtime\php-src\php.exe artisan config:show database.connections`: hanya `sqlite` dan `pgsql` dari config app yang tampil, tanpa koneksi MySQL/MariaDB/SQL Server vendor.
