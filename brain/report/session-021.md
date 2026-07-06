# Session 021

**Tanggal:** 2026-07-06
**Topik Sesi:** Implementasi landing page storefront sesuai mockup dan frontend plan

## Keputusan Penting

- Mengganti `frontend/resources/views/store/home.blade.php` dari placeholder sederhana menjadi landing page storefront yang tetap on-path ke katalog.
- Memakai ulang Blade component yang sudah ada (`button`, `badge`, `product-card`) agar tidak menambah komponen baru.
- Menambahkan preview 3D di home hanya sebagai section pendukung, sesuai frontend plan bahwa viewer bukan pusat alur checkout.

## Perubahan Utama

- Menyusun ulang home menjadi:
  - hero atmosferik dengan CTA ke katalog dan wishlist;
  - signal cards untuk stok, usia, dan simulasi pengiriman;
  - section kategori;
  - produk unggulan;
  - preview model 3D;
  - testimoni;
  - CTA penutup ke katalog dan status pesanan.
- Menambahkan styling `landing-*` di `frontend/resources/css/app.css` untuk visual direction yang lebih galeri dan kolektor.
- Mengganti typography global ke `Manrope` dengan heading `Bricolage Grotesque` agar storefront tidak terasa generik.
- Menambahkan fallback aman untuk preview `.glb` di home bila file model tidak tersedia.

## Verifikasi

- Menjalankan check ringan untuk memastikan semua class `landing-*` yang dipakai di `home.blade.php` memiliki pasangan selector di `app.css`.

## Dampak

- Homepage sekarang lebih dekat ke mockup landing page dan tetap konsisten dengan jalur utama home -> katalog -> detail -> checkout.
- Perubahan tetap terbatas ke halaman home dan stylesheet global, tanpa menambah dependency atau komponen baru.
