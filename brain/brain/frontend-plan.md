# Frontend Plan Ouvvee Toys

## Tujuan Utama
Membuat frontend Ouvvee Toys yang tetap on-path, linear, dan mudah dipahami dari awal sampai checkout.

Fokus dokumen ini:
- Menjaga scope frontend tetap terarah.
- Menentukan urutan kerja yang paling aman untuk MVP.
- Menjelaskan alur data dan layar yang benar-benar dipakai user.
- Mencegah halaman atau komponen yang tidak mendukung transaksi utama.

## North Star
Website harus mengantar user dari melihat produk sampai menyelesaikan pesanan dengan langkah sesedikit mungkin.

Jalur utama yang wajib selalu didukung:
1. Lihat home
2. Masuk katalog
3. Buka detail produk
4. Tambah ke cart
5. Login jika diperlukan
6. Checkout
7. Pilih pembayaran
8. Pilih pengiriman
9. Selesaikan pesanan
10. Lihat status order
11. Tinggalkan review atau simpan wishlist

Jika sebuah layar tidak membantu jalur ini, layar itu bukan prioritas.

## Prinsip On-Path
1. Satu tujuan utama per halaman.
2. Satu CTA utama yang jelas.
3. Navigasi mendukung pencarian produk, bukan mengalihkan perhatian.
4. Admin bersifat read-only kecuali nanti ada kebutuhan CRUD yang benar-benar disepakati.
5. Review, wishlist, dan halaman informatif mengikuti transaksi, bukan mendahuluinya.
6. 3D viewer diperlakukan sebagai fitur pendukung, bukan penghambat checkout.

## Struktur Website Linear
### 1. Public Pages
Halaman publik dipakai untuk discovery dan validasi produk.

1. Home
2. Catalog / Products
3. Product Detail
4. Product Viewer
5. Category Page
6. Search Results
7. About Us
8. FAQ
9. Contact
10. Login
11. Register

### 2. Customer Pages
Halaman customer dipakai untuk transaksi dan after-sales.

1. User Dashboard
2. Profile
3. Edit Profile
4. Address Management
5. Cart
6. Checkout
7. Payment
8. Order Success
9. My Orders
10. Order Detail
11. Wishlist
12. Review Product

### 3. Admin Pages
Halaman admin dipakai untuk monitoring operasional.

1. Admin Dashboard
2. Manage Products
3. Add Product
4. Edit Product
5. Manage Categories
6. Manage Orders
7. Order Detail
8. Manage Users
9. Stock Management
10. Sales Report

## Prioritas Implementasi
Urutan kerja mengikuti alur bisnis, bukan urutan halaman acak.

| Urutan | Fokus | Output |
| --- | --- | --- |
| 1 | Fondasi layout | Header, footer, grid, token warna, typography, spacing |
| 2 | Discovery | Home, catalog, category, search results |
| 3 | Evaluasi produk | Product detail, viewer, review snippet |
| 4 | Transaksi | Cart, checkout, payment selection, order success |
| 5 | After-sales | My orders, order detail, wishlist, review product |
| 6 | Admin monitoring | Dashboard, orders, stock, sales report |

Prinsip prioritas:
- Jangan mulai admin CRUD sebelum alur pembelian stabil.
- Jangan perluas halaman informatif sebelum katalog dan checkout selesai.
- Jangan tambah interaksi dekoratif yang mengganggu keputusan beli.

## Main Layout Structure
### Halaman Utama
1. Navbar
2. Hero section
3. Category section
4. Featured products
5. Product card
6. Promo / banner section
7. Product preview section
8. Testimonials / reviews
9. Footer

### Arah Penggunaan
- Navbar harus memudahkan pindah ke katalog, cart, login, dan order.
- Hero harus langsung mengarahkan ke katalog.
- Featured products harus menjadi jalan tercepat ke detail produk.
- Footer hanya untuk informasi pendukung.

## Product Data Structure
Data produk yang dianggap wajib untuk frontend:

1. Product name
2. Price
3. Description
4. Images
5. 3D model `.glb`
6. Stock
7. Category
8. Size
9. Weight
10. Rating
11. Reviews

Aturan tampilan:
- Harga harus konsisten formatnya.
- Stok harus terlihat sebelum user masuk cart.
- Review harus muncul hanya jika tersedia.
- Model 3D dipakai hanya jika file ada dan tidak mengganggu fallback image.

## Alur Data Frontend
### Discovery
Home dan katalog mengambil data produk, kategori, stok, rating, dan gambar utama.

### Evaluation
Detail produk menggabungkan deskripsi, galeri, ukuran, berat, stok, review, dan model 3D bila ada.

### Transaction
Cart dan checkout memakai data produk, quantity, shipping, payment method, dan ringkasan biaya.

### After-Sales
Order success, my orders, order detail, wishlist, dan review mengambil data transaksi dan status pesanan.

### Admin Monitoring
Admin dashboard menampilkan ringkasan stok, pesanan, dan penjualan untuk monitoring saja.

## Route Structure
Rute dibuat mengikuti jalur linear user.

```txt
/
/catalog
/catalog/:category
/product/:id
/cart
/checkout
/payment
/order-success
/login
/register
/profile
/orders
/orders/:id

/admin
/admin/products
/admin/products/add
/admin/products/edit/:id
/admin/orders
/admin/users
/admin/reports
```

Aturan route:
- Route discovery harus lebih pendek daripada route admin.
- Route checkout tidak boleh terlalu dalam.
- Route order detail harus mudah diakses dari order list.

## Frontend Folder Structure
Struktur berikut dipakai sebagai referensi kerja frontend.

```txt
src/
├── assets/
│   ├── images/
│   ├── icons/
│   └── models/
│
├── components/
│   ├── layout/
│   │   ├── Navbar.jsx
│   │   ├── Footer.jsx
│   │   └── Sidebar.jsx
│   │
│   ├── common/
│   │   ├── Button.jsx
│   │   ├── Input.jsx
│   │   ├── Modal.jsx
│   │   └── Loader.jsx
│   │
│   ├── product/
│   │   ├── ProductCard.jsx
│   │   ├── ProductGrid.jsx
│   │   ├── ProductFilter.jsx
│   │   └── ProductViewer3D.jsx
│   │
│   └── checkout/
│       ├── CartItem.jsx
│       ├── OrderSummary.jsx
│       └── PaymentMethod.jsx
│
├── pages/
│   ├── Home.jsx
│   ├── Catalog.jsx
│   ├── ProductDetail.jsx
│   ├── Cart.jsx
│   ├── Checkout.jsx
│   ├── Login.jsx
│   ├── Register.jsx
│   ├── UserDashboard.jsx
│   └── admin/
│       ├── AdminDashboard.jsx
│       ├── Products.jsx
│       ├── Orders.jsx
│       └── Users.jsx
│
├── routes/
│   └── AppRoutes.jsx
│
├── services/
│   ├── productService.js
│   ├── authService.js
│   ├── cartService.js
│   └── orderService.js
│
├── store/
│   ├── authStore.js
│   ├── cartStore.js
│   └── productStore.js
│
├── hooks/
│   ├── useAuth.js
│   ├── useCart.js
│   └── useProducts.js
│
├── utils/
│   ├── formatCurrency.js
│   ├── calculateShipping.js
│   └── validation.js
│
├── styles/
│   ├── globals.css
│   └── variables.css
│
├── App.jsx
└── main.jsx
```

Catatan:
- Struktur ini adalah referensi arsitektur, bukan kewajiban membuat semua folder sekaligus.
- Jika implementasi sekarang berbasis Blade, gunakan pola yang sama secara konseptual: layout, partial, component, page, service.

## Component Priority
Komponen paling penting harus selesai lebih dulu karena dipakai ulang di banyak layar.

| Prioritas | Komponen | Alasan |
| --- | --- | --- |
| 1 | Navbar | Pintu masuk semua alur |
| 2 | Footer | Penutup konsisten di seluruh halaman |
| 3 | Product Card | Dipakai di katalog, wishlist, rekomendasi |
| 4 | Product Grid | Menyusun katalog dan hasil pencarian |
| 5 | Product Detail | Titik keputusan beli |
| 6 | Cart Item | Titik edit sebelum checkout |
| 7 | Checkout Form | Inti transaksi |
| 8 | 3D Viewer | Fitur pendukung produk tertentu |
| 9 | Admin Table | Monitoring stok dan pesanan |
| 10 | Dashboard Card | Ringkasan metrik |

## Design Direction
Konsep visual:
- Toy store modern yang playful, tapi tetap rapi untuk orang tua dan kolektor.
- Produk harus dominan, bukan ornamen.
- Admin harus lebih tenang dan utilitarian daripada storefront.

Prinsip visual:
- Warna cerah secukupnya, bukan anak-anak berlebihan.
- Hierarki teks jelas.
- Grid rapi, kartu produk mudah dipindai.
- 3D viewer diposisikan sebagai fitur premium, bukan gimmick.

## Responsive Plan
| Breakpoint | Perilaku |
| --- | --- |
| Mobile | Header ringkas, grid 1 kolom, filter collapsible, checkout 1 kolom |
| Tablet | Grid 2 kolom, summary di bawah form |
| Desktop | Grid 3-4 kolom, checkout 2 kolom dengan summary di kanan |

## Accessibility Minimum
- Semua tombol icon punya label atau tooltip.
- Form field punya label yang jelas.
- Error validasi muncul dekat input.
- Warna status tidak menjadi satu-satunya penanda; tetap pakai teks.
- Fokus keyboard terlihat.
- Gambar produk punya alt text dari `product_images.alt_text`.

## Batas Scope
Bagian berikut sengaja tidak dijadikan prioritas sekarang.

| Item | Status |
| --- | --- |
| Landing page marketing panjang | Ditunda |
| Admin CRUD penuh | Ditunda sampai dibutuhkan |
| Payment gateway asli | Ditunda |
| Live tracking ekspedisi | Ditunda |
| 3D preview untuk semua produk | Ditunda sebagai default |
| Design system besar | Ditunda, komponen kecil sudah cukup |

## Definition of Done
Frontend dianggap on-path jika:
- User bisa masuk home lalu mencapai checkout tanpa jalan buntu.
- Product discovery, detail, cart, dan checkout semuanya punya CTA yang jelas.
- Payment dan shipping punya pilihan yang sesuai scope.
- Order success dan my orders bisa dipakai setelah transaksi.
- Wishlist dan review ada di after-sales, bukan mengganggu proses beli.
- Admin dashboard bisa membaca stok dan pesanan tanpa mengubah workflow customer.
- Semua halaman utama responsif dan konsisten.

## Checklist Implementasi
- [ ] Home mengarahkan ke katalog.
- [ ] Katalog bisa dicari dan difilter.
- [ ] Detail produk menampilkan data inti dan fallback yang aman.
- [ ] Cart bisa ubah jumlah dan hapus item.
- [ ] Checkout menampilkan alamat, pembayaran, pengiriman, ongkir, dan total.
- [ ] Status pesanan menampilkan payment dan shipment.
- [ ] Wishlist punya empty state.
- [ ] Review tampil di detail produk.
- [ ] Admin dashboard read-only.
- [ ] Semua halaman responsif mobile dan desktop.
