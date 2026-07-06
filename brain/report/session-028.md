# Session 028

**Tanggal:** 2026-07-06
**Topik Sesi:** Finalisasi SQL XAMPP untuk database Ouvvee Toys

## Keputusan Penting

- `brain/brain/schema.sql` dijadikan script SQL import-ready untuk phpMyAdmin/XAMPP.
- Nama database final: `ouvvee_toys`.
- Konfigurasi XAMPP yang dipakai: host `127.0.0.1`, port `3306`, username `root`, password kosong.
- Schema tetap mengikuti Laravel MVP yang sudah ada, dengan tambahan `sellers` dan `seller_phones` dari kebutuhan dokumentasi.
- MCP cukup khusus untuk project ini dulu; dibuat reusable hanya jika ada project lain yang benar-benar butuh.

## Perubahan Utama

- Menambahkan charset/collation `utf8mb4`.
- Menambahkan tabel penjual dan telepon penjual.
- Melengkapi schema katalog, cart, checkout, order, payment simulasi, shipment, wishlist, review, dan admin dashboard read-only.
- Menambahkan unique key, foreign key, index dasar, dan check constraint untuk data uang, stok, berat, quantity, dan rating.
- Menambahkan seed awal untuk admin, buyer, kategori, produk, payment method, shipping method, dan shipping rate.

## Verifikasi

- Static check PowerShell lulus untuk tabel wajib dan constraint/index utama.
- MySQL CLI XAMPP tersedia di `C:\xampp\mysql\bin\mysql.exe`.

## Batasan

- SQL belum di-import otomatis ke XAMPP agar tidak mengubah database lokal tanpa perintah eksplisit.
- Jika schema dijalankan melalui Laravel migration, migration saat ini belum memuat tabel `sellers` dan `seller_phones`; script SQL adalah output utama untuk import phpMyAdmin.
