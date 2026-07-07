# Session 051

**Tanggal:** 2026-07-07
**Topik Sesi:** Dokumentasi teknis project Ouvvee Toys

## Ringkasan

- Menambahkan dokumentasi proyek tingkat akar di `README.md`.
- Dokumentasi dimulai dengan gambar hero yang dikirim user agar narasi visualnya konsisten dengan UI homepage.
- Isi dokumen menjelaskan tech stack, frontend, backend, database, alur user, asset strategy, dan batasan implementasi saat ini.

## Isi Dokumentasi

- Tech stack: Laravel 11, PHP 8.3, Blade, vanilla JS, PostgreSQL/Supabase, Eloquent, session auth, dan `model-viewer`.
- Frontend:
  - Blade server-rendered storefront di `backend/resources/views`
  - demo catalog live di `frontend/`
  - pemakaian CSS inline dari partial untuk menjaga app tetap runnable tanpa Vite
- Backend:
  - pemetaan route public, guest auth, auth commerce, dan admin
  - penjelasan controller per domain
  - checkout transaction, lock stok, dan simulasi payment/shipping
- Database:
  - skema UUID relasional
  - relasi inti antar users, products, carts, orders, payments, shipments, reviews, dan wishlists
  - constraint penting untuk integritas data

## Verifikasi

- Tidak menjalankan test karena perubahan ini murni dokumentasi.
- Tidak menyentuh file yang sedang diubah sebelumnya pada backend selain menambah dokumen baru.

