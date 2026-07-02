# Tech Stack & Architecture

## Teknologi yang Digunakan
- Frontend: Blade Template + CSS/Tailwind/Bootstrap
- Backend: Laravel
- Database: MySQL
- Authentication: Laravel Starter Kit
- Local Server: XAMPP, Laragon, atau Laravel Herd
- Database Tool: phpMyAdmin atau MySQL Workbench
- Infrastruktur: Local development terlebih dahulu

## Arsitektur
Sistem menggunakan arsitektur MVC Laravel. Blade menangani view, controller menangani alur katalog, keranjang, checkout, pesanan, dan dashboard, sedangkan MySQL menyimpan data relasional. Eloquent ORM digunakan untuk relasi antar tabel seperti users, products, carts, orders, payments, shipments, reviews, dan wishlists.

## Keputusan Teknis
- Laravel dipilih karena mendukung MySQL, MVC, routing, controller, view, query builder, Eloquent ORM, dan starter kit authentication.
- MySQL dipilih karena kebutuhan sistem berbentuk data relasional dengan primary key dan foreign key.
- Galeri gambar produk cukup memakai Blade dan HTML standar karena fokus sistem adalah toko mainan.

## Catatan Implementasi
- Produk wajib memiliki gambar katalog dan informasi mainan yang jelas.
- Stok produk berkurang setelah pesanan berhasil dibuat.
- Ongkir dihitung otomatis berdasarkan metode pengiriman dan berat barang.
- Dashboard admin fokus pada monitoring, bukan manajemen data produk.
