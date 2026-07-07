# Session 037

**Tanggal:** 2026-07-06
**Topik Sesi:** Perbaikan exhibit homepage 3D

## Keputusan Penting

- Homepage dikembalikan ke mode gallery/exhibit karena browser masih memakai pengalaman itu dan request berfokus ke exhibit.
- Hero exhibit memakai model tetap `models/products/mech (2).glb`, bukan produk featured pertama.
- Interaksi pointer pada model hero dimatikan agar wheel/touch scroll tetap menggerakkan halaman.

## Perubahan Utama

- `store/home.blade.php` memakai `mech (2).glb`, menghapus `camera-controls`, dan memberi judul exhibit mech.
- `resources/css/app.css` menambahkan smooth scroll, background navbar gallery, text shadow, dan `pointer-events: none` untuk model hero.
- `public/index.php` mengecualikan deprecation PHP dari output agar warning runtime tidak bocor ke HTML dan merusak navbar.

## Verifikasi

- `GET /` status 200.
- HTML tidak berisi `Deprecated:`.
- HTML berisi `gallery-home` dan `mech (2).glb`.
- Browser check: model source `http://127.0.0.1:8000/models/products/mech (2).glb`, `camera-controls=false`, `pointer-events=none`, `scroll-behavior=smooth`.
- Scroll wheel dari area model menaikkan `window.scrollY` dari 0 ke 620 dan masuk ke collection.
