# Ouvvee Toys

![Hero reference](C:/Users/ASUS/AppData/Local/Temp/codex-clipboard-a40532e6-eadc-4b6d-b152-671395792ce5.png)

Dokumen ini menjelaskan implementasi Ouvvee Toys berdasarkan state repo saat ini. Fokusnya adalah arsitektur teknis, alur frontend, backend, dan database, bukan copy marketing.

## Ringkasan Produk

Ouvvee Toys adalah storefront e-commerce untuk display toys dan collectible figures. Pengunjung bisa menjelajah katalog publik, melihat detail produk yang kaya informasi, lalu melanjutkan ke keranjang, checkout, order tracking, wishlist, dan review. Admin hanya mendapat dashboard monitoring, bukan CRUD produk.

## Tech Stack

| Layer | Teknologi | Peran |
| --- | --- | --- |
| Backend app | Laravel 11 | Server-side rendering, routing, auth, transaction, model relasi, dan API katalog |
| Runtime | PHP 8.3 | Menjalankan Laravel, Eloquent, Blade, dan test suite |
| Frontend utama | Blade + HTML + CSS + Vanilla JS | UI storefront yang dirender server-side di `backend/resources/views` |
| Frontend live catalog | Static HTML/JS di `frontend/` | Demo katalog yang mengambil data live dari endpoint backend |
| Database | PostgreSQL | Database relasional utama, ditargetkan ke Supabase PostgreSQL |
| ORM | Eloquent | Mapping model, relasi, scope, dan query composition |
| Auth | Laravel session auth | Login, register, logout, guard `auth`, dan gate admin |
| 3D asset viewer | `@google/model-viewer` via CDN | Preview GLB pada hero dan detail produk |
| Storage asset | File publik di `backend/public/` | Gambar produk, thumbnail, dan model GLB |

## Arsitektur Tingkat Tinggi

```mermaid
flowchart LR
    A[Browser] --> B[Laravel routes]
    B --> C[Controllers]
    C --> D[Eloquent models]
    D --> E[(PostgreSQL / Supabase)]
    C --> F[Blade views]
    F --> A
    A --> G[Static frontend/frontend]
    G --> H[/api/products]
    H --> C
```

### Pola utama

- Satu backend Laravel melayani storefront utama, auth, checkout, order, wishlist, review, dan admin dashboard.
- Frontend statis di `frontend/` adalah katalog live ringan yang memanggil API backend, bukan aplikasi terpisah dengan state kompleks.
- Media produk disajikan dari folder publik, bukan dari object storage terpisah pada state repo saat ini.

## Frontend

### 1. Frontend utama: Blade server-rendered

Frontend utama ada di `backend/resources/views/`.

File yang paling relevan:

- `backend/resources/views/layouts/store.blade.php`
- `backend/resources/views/store/home.blade.php`
- `backend/resources/views/store/products/index.blade.php`
- `backend/resources/views/store/products/show.blade.php`
- `backend/resources/views/store/cart/index.blade.php`
- `backend/resources/views/store/checkout/index.blade.php`
- `backend/resources/views/store/orders/index.blade.php`
- `backend/resources/views/store/orders/show.blade.php`
- `backend/resources/views/store/wishlist/index.blade.php`
- `backend/resources/views/store/reviews/create.blade.php`
- `backend/resources/views/admin/dashboard.blade.php`

Karakter frontend ini:

- Render dilakukan dari server, jadi HTML utama datang dari Blade, bukan SPA.
- State kritis seperti keranjang, checkout, dan order disimpan di backend, bukan di local storage.
- UI memakai komponen Blade kecil seperti badge, button, price, rating, dan order summary.
- CSS di-load lewat partial `backend/resources/views/partials/frontend-assets.blade.php` yang meng-inline `resources/css/app.css`.
- Ada fallback asset untuk menjaga tampilan tetap jalan walau beberapa media produk belum lengkap di database.

### 2. Hero dan exhibitor feel

Halaman home memakai pendekatan visual seperti exhibition showcase:

- Hero besar dengan preview 3D `model-viewer` bila file `.glb` tersedia.
- Navigasi ke `Exhibits`, `Collection`, dan `Vault`.
- Section koleksi yang menampilkan produk unggulan secara marquee.
- Loader kecil di hero untuk memberi rasa "gallery launch" saat halaman dibuka.

Gambar yang kamu kirim cocok sebagai pembuka dokumentasi karena itu merepresentasikan gaya halaman home saat ini: display toy diperlakukan seperti objek koleksi, bukan sekadar barang katalog biasa.

### 3. Product detail

Halaman detail produk di `backend/resources/views/store/products/show.blade.php` lebih teknis daripada landing page biasa:

- Menampilkan nama, harga, stok, kategori, ukuran, berat, usia rekomendasi, dan safety note.
- Menampilkan rating agregat dan jumlah review.
- Mendukung preview 3D jika model `.glb` tersedia.
- Jika model tidak ada, UI turun ke image gallery statis.
- Aksi pembelian disiapkan langsung di halaman detail:
  - tambah ke cart
  - beli langsung
  - wishlist
  - share link
  - tulis review setelah login

### 4. Frontend statis `frontend/`

Folder `frontend/` adalah demo katalog live yang sangat tipis.

File yang dipakai:

- `frontend/index.html`
- `frontend/app.js`
- `frontend/styles.css`

Perilakunya:

- Membaca base URL backend dari `<meta name="api-base-url">`.
- Memanggil `GET /api/products`.
- Mendukung search query `q`.
- Merender kartu produk dari template HTML.
- Menggunakan `Intl.NumberFormat('id-ID', { currency: 'IDR' })` untuk formatting harga.
- Memakai fallback SVG jika image product tidak ada.

Ini penting karena frontend statis ini membuktikan backend benar-benar menyediakan data live, bukan hardcoded copy.

## Backend

### 1. Struktur backend

Laravel ada di folder `backend/`.

File inti:

- `backend/routes/web.php`
- `backend/routes/api.php`
- `backend/app/Http/Controllers/`
- `backend/app/Models/`
- `backend/database/migrations/`
- `backend/database/seeders/`
- `backend/app/Providers/AppServiceProvider.php`

### 2. Routing

`backend/routes/web.php` membagi fitur menjadi tiga blok besar:

- Public storefront:
  - `/`
  - `/products`
  - `/categories/{category:slug}`
  - `/products/{product:slug}`
- Guest auth:
  - `/login`
  - `/register`
- Authenticated commerce:
  - `/cart`
  - `/wishlist`
  - `/checkout`
  - `/orders`
  - `/products/{product:slug}/reviews/create`
  - `/admin`

`backend/routes/api.php` hanya membuka endpoint katalog live:

- `GET /api/products`

### 3. Controller responsibility

Lapisan controller dipisah per domain fungsi:

- `StoreController`
  - Menyusun hero/home page.
  - Mengambil produk unggulan untuk halaman depan.
- `ProductController`
  - Menangani katalog, filter kategori, search, dan detail produk.
- `CartController`
  - Menangani cart item, update kuantitas, dan hapus item.
- `CheckoutController`
  - Menghitung subtotal, berat kiriman, ongkir, dan membuat order.
- `OrderController`
  - Menampilkan order list, detail order, dan simulasi payment.
- `WishlistController`
  - Menambah dan menghapus wishlist.
- `ReviewController`
  - Membuat review setelah transaksi.
- `AuthController`
  - Login, register, logout.
- `AdminDashboardController`
  - Menampilkan ringkasan stok dan penjualan untuk admin.

### 4. Auth dan role

Auth menggunakan session standard Laravel.

Hal penting:

- Login memakai `Auth::attempt(...)`.
- Register membuat user baru lalu langsung login.
- Password disimpan di kolom `password_hash`.
- Model `User` mengarahkan Laravel auth ke field `password_hash` lewat `getAuthPasswordName()`.
- Admin access dijaga gate `access-admin` di `backend/app/Providers/AppServiceProvider.php`.

### 5. Checkout flow

Checkout adalah bagian backend yang paling penting secara bisnis.

Alurnya:

1. User login membuka `/checkout`.
2. Backend mengambil cart aktif dan item cart.
3. Berat total dihitung dari jumlah item dikali `weight_gram` produk.
4. Ongkir dihitung dari `shipping_rates`.
5. Saat submit, backend validasi alamat, payment method, dan shipping method.
6. Transaksi database berjalan di dalam `DB::transaction(...)`.
7. Stok produk di-lock dengan `lockForUpdate()` supaya tidak race condition.
8. Order dibuat.
9. Order items, payment record, dan shipment record dibuat.
10. Stok produk dikurangi.
11. Cart dikosongkan dan status diubah ke `checked_out`.

Itu membuat checkout aman dari double spend stok pada request paralel.

### 6. API katalog

Endpoint `GET /api/products` dipakai frontend live catalog.

Karakter respons:

- support search query `q`
- data dipaginate
- metadata pagination ikut dikirim
- image URL dibentuk dari asset publik backend
- product URL mengarah ke route detail Laravel

Contoh bentuk payload:

```json
{
  "data": [
    {
      "slug": "white-battle-mech-figure",
      "name": "White Battle Mech",
      "category": "Mech",
      "price": 250000,
      "stock": 12,
      "description": "..."
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 12,
    "total": 9
  }
}
```

## Database

### 1. Platform dan target

Konfigurasi database di repo menargetkan PostgreSQL:

- `DB_CONNECTION=pgsql`
- `DB_SSLMODE=require`
- database production diarahkan ke Supabase PostgreSQL

Ada fallback SQLite di config untuk kebutuhan local/test, tetapi database utama sistem ini tetap relasional PostgreSQL.

### 2. Strategi skema

Database memakai pola berikut:

- Primary key UUID di hampir semua entitas utama.
- Foreign key eksplisit untuk menjaga integritas relasi.
- Unique constraint untuk mencegah duplikasi natural key.
- Composite key untuk tabel join seperti wishlist.
- Timestamp dan enum dipakai di status-state yang memang terbatas.

### 3. Entitas inti

#### Identity

- `users`
  - `id_user`
  - `name`
  - `email`
  - `password_hash`
  - `phone`
  - `role`

#### Addressing

- `addresses`
  - satu user bisa punya banyak alamat
  - ada flag `is_default`

#### Catalog

- `categories`
  - master kategori produk
- `products`
  - nama, slug, price, description, stock
  - `recommended_age`
  - `safety_note`
  - `size`
  - `weight_gram`
  - `status`
- `product_images`
  - galeri gambar tambahan
  - satu produk bisa punya banyak image

#### Commerce

- `carts`
  - satu user punya cart aktif
- `cart_items`
  - produk dan quantity di cart
- `orders`
  - order header
- `order_items`
  - detail baris pesanan
- `payments`
  - simulasi status pembayaran
- `shipments`
  - simulasi status pengiriman

#### Fulfillment reference

- `payment_methods`
- `shipping_methods`
- `shipping_rates`

#### Engagement

- `reviews`
- `wishlists`

### 4. Relasi penting

- `users` -> `addresses` : one to many
- `users` -> `carts` : one to many
- `users` -> `orders` : one to many
- `categories` -> `products` : one to many
- `products` -> `product_images` : one to many
- `carts` -> `cart_items` : one to many
- `orders` -> `order_items` : one to many
- `orders` -> `payments` : one to one
- `orders` -> `shipments` : one to one
- `users` <-> `products` via `wishlists` : many to many

### 5. Constraint yang penting secara bisnis

- `products.slug` unique
- `users.email` unique
- `cart_items` unique per cart dan product
- `order_items` unique per order dan product
- `reviews` unique per user, product, dan order
- `wishlists` primary key gabungan user + product
- `payments` dan `shipments` masing-masing satu record per order

Constraint ini bukan kosmetik. Ini yang menjaga sistem tetap konsisten saat cart, order, dan review dipakai berulang.

### 6. Seed data

`backend/database/seeders/DatabaseSeeder.php` hanya menyiapkan data bootstrap:

- admin user awal
- payment methods
- shipping methods
- shipping rates

Catalog produk tidak di-seed di sini, karena katalog live diasumsikan datang dari import/admin flow.

## Asset dan Media

File asset utama ada di `backend/public/`:

- `backend/public/images/products/`
- `backend/public/models/products/`

Aturan media yang dipakai model `Product`:

- jika `image_url` ada dan file benar-benar ada, itu dipakai
- jika tidak ada, model melakukan fallback berdasarkan slug atau keyword
- jika `model_url` ada dan file ada, preview 3D dipakai
- jika tidak ada, fallback ke mapping slug/keyword juga dipakai

Ini membuat katalog tetap hidup walau data import belum lengkap.

## Alur Pengguna

### Pengunjung

- buka home
- lihat hero dan featured collection
- masuk katalog
- buka detail produk

### Pembeli

- register atau login
- tambah item ke cart
- buka checkout
- pilih alamat, payment method, dan shipping method
- buat order
- bayar simulasi
- lihat status order
- tambah wishlist
- tulis review setelah transaksi

### Admin

- login sebagai admin
- buka `/admin`
- pantau stok dan ringkasan penjualan
- tidak diposisikan sebagai operator CRUD katalog

## Catatan Implementasi

- Project ini bukan SPA penuh. Core storefront tetap Blade server-rendered.
- Folder `frontend/` hanya lapisan demo live catalog yang ringan.
- Payment gateway asli belum dipasang. Yang ada adalah simulasi status pembayaran.
- Shipping juga disimulasikan lewat rate table dan metode pengiriman referensi.
- Admin dashboard read-only by design.

## Jalankan Lokal

### Backend

```powershell
cd backend
.\.runtime\php-src\php.exe artisan serve
```

### Test backend

```powershell
cd backend
.\.runtime\php-src\php.exe .\vendor\bin\phpunit
```

### Frontend statis demo

1. Jalankan backend Laravel.
2. Buka `frontend/index.html`.
3. Jika backend tidak berjalan di `http://127.0.0.1:8000`, ubah nilai `api-base-url` di `frontend/index.html`.

## File Paling Penting

- `backend/routes/web.php`
- `backend/routes/api.php`
- `backend/database/migrations/2026_07_06_000000_create_ouvvee_schema.php`
- `backend/app/Http/Controllers/CheckoutController.php`
- `backend/app/Http/Controllers/ProductController.php`
- `backend/app/Models/Product.php`
- `backend/app/Providers/AppServiceProvider.php`
- `frontend/app.js`
- `frontend/index.html`

## Penutup

Kalau kamu pakai dokumen ini sebagai README utama, orang baru bisa langsung paham:

- stack yang dipakai
- cara UI dibangun
- bagaimana backend memproses transaksi
- struktur database dan relasinya
- di mana batas simulasi dan batas fitur produksi

