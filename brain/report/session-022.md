# Session 022

**Tanggal:** 2026-07-06
**Topik Sesi:** Implementasi home frontend sesuai Stitch Gallery PRD

## Keputusan Penting

- Mengimplementasikan scope `Home only` dari Stitch project `The Gallery Figure Shop - PRD`.
- Memakai live `.glb` lokal melalui `model-viewer`, bukan gambar dummy remote dari Stitch.
- Menjaga halaman lain tetap memakai layout/storefront existing; header dan footer global hanya disembunyikan untuk home via body class.

## Perubahan Utama

- Mengganti `frontend/resources/views/store/home.blade.php` menjadi landing exhibition:
  - loading overlay `Acquiring Signal`;
  - nav minimal `Exhibits`, `Collection`, `Vault`;
  - hero full-bleed dengan model 3D `robot_police.glb`;
  - CTA ke katalog dan cart;
  - preview koleksi dengan tiga model `.glb` lokal.
- Menambahkan `@yield('body_class')` di layout store agar styling khusus home tidak bocor ke halaman lain.
- Menambahkan style `.gallery-*` di `frontend/resources/css/app.css` mengikuti arah visual Stitch.

## Verifikasi

- Static check: semua class `.gallery-*` di home memiliki selector CSS.
- Static check: model lokal `robot_police.glb`, `bulldozer.glb`, dan `robot_crab.glb` tersedia.
- Static check: tidak ada referensi gambar dummy remote Stitch di home Blade.
- Visual smoke check desktop dan mobile dengan Chrome/Playwright; model 3D load via route HTTP virtual, tanpa page error.
- Mobile overlap check: model selesai sebelum title dan scroll indicator disembunyikan agar tidak menabrak CTA.

## Dampak

- Home sekarang lebih dekat ke desain Stitch dan tetap on-path ke katalog/cart.
- Tidak ada dependency frontend baru, build step baru, atau perubahan backend.
