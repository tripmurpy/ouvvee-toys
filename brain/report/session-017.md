# Session 017

**Tanggal:** 2026-07-06
**Topik Sesi:** Menyiapkan aset GLB untuk detail produk frontend

## Keputusan Penting
- Memindahkan aset `.glb` dari `frontend/resources/` ke `frontend/public/models/products/` agar bisa diserve sebagai file publik.
- Menambahkan dukungan `model_url` hanya di halaman detail produk, bukan katalog, karena model 3D di grid produk akan terlalu berat untuk MVP.
- Memakai `<model-viewer>` via CDN karena repo belum punya scaffold npm/Vite aktif.
- Menjaga fallback placeholder jika `model_url` kosong atau file `.glb` belum tersedia.

## Perubahan Teknis
- Menambahkan `@stack('head')` di layout store.
- Menambahkan default `model_url` ke contoh produk detail: `/models/products/robot_police.glb`.
- Menampilkan `<model-viewer>` saat file model tersedia.
- Menambahkan CSS `.product-model` untuk ukuran viewer desktop dan mobile.

## Aset Dipindahkan
- `bulldozer.glb`
- `dragonborn.glb`
- `elephant.glb`
- `excavator.glb`
- `house.glb`
- `robot_arm.glb`
- `robot_crab.glb`
- `robot_police.glb`
- `ship.glb`

## Pemeriksaan
- Menjalankan PHP lint untuk `frontend/resources/views/store/products/show.blade.php`.
- Menjalankan PHP lint untuk `frontend/resources/views/layouts/store.blade.php`.
- Mengecek folder `frontend/public/models/products/` berisi file `.glb`.
- Mengecek default `robot_police.glb` tersedia.
