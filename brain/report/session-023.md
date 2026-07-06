# Session 023

**Tanggal:** 2026-07-06
**Topik Sesi:** Implementasi Collection storefront sesuai Stitch Premium Store

## Keputusan Penting

- Scope hanya `Katalog / Collection` dan `Product Card`; detail produk, cart, checkout, dan data terpusat ditunda.
- Memakai `.glb` lokal dari `frontend/public/models/products`, bukan gambar dummy remote dari Stitch.
- Tidak menambah route, dependency, build step, atau abstraksi data baru.

## Perubahan Utama

- Mengubah `frontend/resources/views/store/products/index.blade.php` menjadi halaman Collection:
  - body class `collection-page`;
  - hero premium dengan gaya Sahara ochre;
  - filter UI GET untuk search, series/kategori, harga, stok, dan usia;
  - grid header dengan jumlah produk dan sort visual;
  - fallback data katalog berisi field `model_url`, `brand`, `label`, `reviews`, `age`, `stock`, `price`, `category`, dan `url`.
- Mengupgrade `frontend/resources/views/components/product-card.blade.php`:
  - mendukung live model `.glb` via `model-viewer`;
  - fallback ke `product-shape` jika file tidak tersedia;
  - mendukung label, brand, rating, reviews, age, stock;
  - menampilkan state sold out dan tombol `Acquire`/`Sold Out`;
  - load script `model-viewer` sekali dengan `@once`.
- Menambahkan CSS namespaced `.collection-*` dan memperkuat base `.product-card` di `frontend/resources/css/app.css`.

## Verifikasi

- Static check: semua `.collection-*` class di Blade memiliki selector CSS.
- Static check: semua file `.glb` Collection tersedia:
  - `robot_police.glb`
  - `bulldozer.glb`
  - `robot_crab.glb`
  - `excavator.glb`
  - `dragonborn.glb`
  - `ship.glb`
- Static check: tidak ada referensi `lh3.googleusercontent` atau `aida-public` di Collection/Product Card.
- Regression check: home masih memakai class `.gallery-*`.
- Visual smoke synthetic dengan Playwright/Chrome:
  - desktop: 6 card, 6 model, grid 3 kolom, tidak ada horizontal overflow;
  - mobile: grid 1 kolom, filter menjadi static, tidak ada horizontal overflow;
  - sold-out button disabled;
  - tidak ada page error.

## Dampak

- Collection sekarang mengikuti arah visual Stitch Premium Store dan memakai asset 3D lokal.
- Product Card lebih reusable untuk data backend lama maupun fallback demo baru.
- Filter masih UI GET; filtering backend penuh menunggu controller/data produk nyata.
