# Session 041

**Tanggal:** 2026-07-07
**Topik Sesi:** Sambungkan frontend terpisah ke backend dan database live

## Keputusan Penting

- Tidak membuat SPA/build pipeline baru karena folder `frontend` sebelumnya kosong dan kebutuhan utamanya hanya membaca data live produk.
- Backend tetap jadi sumber data tunggal; frontend hanya konsumsi `GET /api/products`.
- CORS dibuka untuk `api/*` supaya frontend statis atau origin lain bisa fetch data katalog.

## Perubahan Utama

- Mengaktifkan routing API di Laravel lewat `backend/bootstrap/app.php`.
- Menambah endpoint `backend/routes/api.php` yang mengembalikan nama produk, harga, stok, kategori, deskripsi, gambar, dan URL detail dari database.
- Menambah `backend/config/cors.php` untuk akses cross-origin ke endpoint API.
- Membuat frontend statis di `frontend/index.html`, `frontend/app.js`, dan `frontend/styles.css`.
- Menambah test API katalog di `backend/tests/Feature/CatalogTest.php`.

## Verifikasi

- Endpoint `GET /api/products` sekarang tersedia.
- Frontend membaca data live dari endpoint backend.
- Test fitur katalog API ditambahkan untuk memastikan field utama tetap keluar.
