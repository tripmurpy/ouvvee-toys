# Frontend Source References Ouvvee Toys

## Rekomendasi Utama

| Prioritas | Source | Alasan Cocok | Catatan |
| --- | --- | --- | --- |
| 1 | [Kiddo - Kids Store Ecommerce HTML Template](https://github.com/templatesJungle/kiddo-kids-store-ecommerce-html-template) | Bootstrap 5, tema kid/toy store, struktur source sederhana: `index.html`, `style.css`, `css/`, `js/`, `images/`. | Paling mudah dipecah ke Blade components/layout tanpa pindah stack. Cek lisensi sebelum copy asset langsung. |
| 2 | [W3Layouts Toys eCommerce Bootstrap Template](https://w3layouts.com/toys-ecommerce-bootstrap-responsive-website-template/) | Tema mainan/e-commerce dan responsive Bootstrap. | Pakai sebagai referensi layout/section; cek lisensi W3Layouts sebelum mengambil source. |
| 3 | [Zoutoys - Toys HTML Template](https://html.design/download/zoutoys-toys-html-template-for-website/) | Spesifik toy store, ada download HTML dan live demo link. | Live demo terbaca tidak tersedia saat dicek; tetap bisa jadi fallback visual/source. |
| 4 | [Toyqo - Kids Store Bootstrap 5 Template](https://bootstrap.hasthemes.com/toyqo-kids-store-bootstrap-5-template/) | Tampilan lebih polished dan Bootstrap 5. | Berbayar; cocok untuk inspirasi, bukan source utama MVP. |

## Source yang Tidak Diprioritaskan

| Source | Alasan |
| --- | --- |
| [TemplateMonster Free Toy Store Template](https://www.templatemonster.com/website-templates/free-toy-store-responsive-website-template-248642.html) | Halaman kena security verification saat dicek di Chrome, jadi tidak cukup reliable untuk dijadikan source utama. |
| Repo GitHub React/MERN toy store | Tidak cocok untuk repo Laravel Blade; pindah stack akan menambah kerja tanpa perlu. |

## Cara Adaptasi Minimal ke Blade

1. Ambil struktur dari Kiddo sebagai acuan, bukan copy penuh.
2. Pecah `index.html` menjadi:
   - `backend/resources/views/layouts/store.blade.php`
   - `backend/resources/views/partials/store/header.blade.php`
   - `backend/resources/views/partials/store/footer.blade.php`
   - `backend/resources/views/components/product-card.blade.php`
   - `backend/resources/views/store/home.blade.php`
   - `backend/resources/views/store/products/index.blade.php`
3. Pindahkan warna dan spacing penting ke `backend/resources/css/app.css`.
4. Pakai asset mainan sendiri di `backend/public/images/`.
5. Jangan tambah dependency frontend baru kalau Bootstrap/CSS template sudah cukup.

## Yang Perlu Diambil

- Header toko dengan search/cart/wishlist/login.
- Hero toko mainan yang langsung mengarah ke katalog.
- Category cards untuk figur, boneka, mobil-mobilan, puzzle, dan karakter.
- Product grid dengan gambar, harga, kategori, stok, usia rekomendasi.
- Section promo sederhana dan featured products.

## Yang Perlu Dibuang

- Newsletter/pop-up yang tidak dibutuhkan MVP.
- Animasi berat.
- Section blog panjang.
- Multi-page template yang tidak masuk scope checkout, wishlist, review, atau admin read-only.
