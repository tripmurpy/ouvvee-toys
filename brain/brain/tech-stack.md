# Tech Stack & Architecture

## Teknologi yang Digunakan
- Frontend: Blade Template + CSS/Tailwind/Bootstrap
- Backend: Laravel
- Database: Supabase PostgreSQL
- Authentication: Laravel Starter Kit
- Local Server: Laravel Herd atau built-in PHP server
- Database Tool: Supabase SQL Editor, `psql`, atau pgAdmin
- Infrastruktur: Local development terlebih dahulu

## Arsitektur
Sistem menggunakan arsitektur MVC Laravel. Blade menangani view, controller menangani alur katalog, keranjang, checkout, pesanan, dan dashboard, sedangkan Supabase PostgreSQL menyimpan data relasional. Eloquent ORM digunakan untuk relasi antar tabel seperti users, products, carts, orders, payments, shipments, reviews, dan wishlists.

## Keputusan Teknis
- Laravel dipilih karena mendukung PostgreSQL via Supabase, MVC, routing, controller, view, query builder, Eloquent ORM, dan starter kit authentication.
- Supabase PostgreSQL dipilih karena kebutuhan sistem berbentuk data relasional dengan primary key dan foreign key, plus hosting database terkelola yang sudah aktif.
- Galeri gambar produk cukup memakai Blade dan HTML standar karena fokus sistem adalah toko mainan.

## Catatan Implementasi
- Produk wajib memiliki gambar katalog dan informasi mainan yang jelas.
- Stok produk berkurang setelah pesanan berhasil dibuat.
- Ongkir dihitung otomatis berdasarkan metode pengiriman dan berat barang.
- Dashboard admin fokus pada monitoring, bukan manajemen data produk.
