# Tahap 6: Dokumentasi Sistem Ouvvee Toys

Tahap ini merapikan seluruh pengetahuan proyek ke dalam dokumentasi yang bisa dipakai sebagai acuan kerja untuk fitur, alur data, backend, dan frontend.

## Tujuan

- Menjadikan dokumentasi sebagai sumber kebenaran utama sebelum implementasi lanjut.
- Memetakan semua fitur yang memang masuk scope MVP.
- Menjelaskan alur data dari user sampai data tersimpan di database.
- Memisahkan dokumen backend, frontend, dan data agar mudah dirawat.

## Prinsip

- Ikuti scope di `brain/brain/prd.md`.
- Reuse dokumen yang sudah ada sebelum menulis ulang.
- Jangan mengarang backend yang belum ada di source code.
- Tandai fitur di luar MVP sebagai tunda.
- Bedakan antara implementasi yang sudah ada dan rencana yang belum dibuat.

## Status Saat Ini

### Dokumen yang sudah ada

- `brain/about/project-context.md`
- `brain/brain/prd.md`
- `brain/brain/analisa-kebutuhan-user.md`
- `brain/brain/tech-stack.md`
- `brain/brain/database-design.md`
- `backend/database/migrations/2026_07_06_000000_create_ouvvee_schema.php`
- `brain/brain/frontend-plan.md`
- `brain/brain/frontend-source-references.md`

### Implementasi yang sudah terlihat di repo

- Layout store, auth, dan admin.
- Halaman home, katalog, detail produk, cart, checkout, order status, wishlist, review, dan dashboard admin.
- Komponen Blade untuk badge, button, form field, empty state, order summary, price, product card, rating, dan toast.
- Aset produk `.glb` untuk preview detail produk.

### Batasan penting

- Repo ini belum punya controller, model, route, atau service backend yang nyata.
- Jadi dokumentasi backend harus ditulis sebagai spesifikasi target, bukan deskripsi implementasi yang sudah selesai.

## Inventaris Fitur

| Area | Fitur | Status |
| --- | --- | --- |
| Publik | Homepage | Ada di Blade snapshot |
| Publik | Katalog produk | Ada di Blade snapshot |
| Publik | Detail produk | Ada di Blade snapshot |
| Publik | Preview 3D produk di detail | Ada sebagai enhancement detail page |
| Pembeli | Cart | Ada di Blade snapshot |
| Pembeli | Checkout | Ada di Blade snapshot |
| Pembeli | Status pesanan | Ada di Blade snapshot |
| Pembeli | Wishlist | Ada di Blade snapshot |
| Pembeli | Review produk | Ada di Blade snapshot |
| Admin | Dashboard read-only | Ada di Blade snapshot |
| Sistem | Auth login/register | Ada di layout auth dan halaman auth |
| Sistem | Payment simulasi | Ada di PRD dan schema |
| Sistem | Shipping JNE dan GOJEK | Ada di PRD dan schema |
| Sistem | Stok dan validasi | Ada di PRD, schema, dan komponen UI |

## Peta Dokumentasi Yang Harus Ada

| Dokumen | Isi | Catatan |
| --- | --- | --- |
| Ringkasan fitur | Daftar fitur per role | Satu halaman referensi cepat |
| DFD konteks | Entitas luar dan arus data utama | Cocok untuk level 0 |
| DFD level 1 | Alur per proses bisnis | Fokus browse, cart, checkout, payment, shipment, review, admin |
| Dokumen backend | Route, controller, validasi, transaksi, aturan stok | Spesifikasi target backend |
| Dokumen frontend | Layout, page, component, state, responsive | Mengikuti Blade snapshot |
| Kamus data | Field utama per entitas | Bisa diturunkan dari schema |
| Checklist MVP | Daftar verifikasi fitur selesai | Dipakai saat implementasi |

## Fitur Yang Harus Didokumentasikan

### 1. Publik

- Homepage.
- Katalog produk.
- Detail produk.
- Search dan filter katalog.
- Preview 3D detail produk bila model tersedia.

### 2. Pembeli

- Login dan register.
- Cart.
- Checkout.
- Pembayaran simulasi.
- Pengiriman simulasi.
- Status pesanan.
- Wishlist.
- Review produk.

### 3. Admin

- Dashboard penjualan.
- Ringkasan stok.
- Produk dengan stok rendah.
- Tabel pesanan terbaru.
- Tanpa CRUD produk.

### 4. Sistem

- Validasi stok.
- Validasi login untuk checkout.
- Transaction untuk order creation.
- Snapshot harga pada order item.
- Aturan review hanya untuk pembeli yang berhak.
- Perhitungan ongkir berdasarkan berat dan metode kirim.

## Dataflow Yang Perlu Ditulis

| Alur | Input | Proses | Output | Data Store |
| --- | --- | --- | --- | --- |
| Browse katalog | Query search/filter | Ambil produk, kategori, gambar | Daftar produk | products, categories, product_images |
| Lihat detail | ID/slug produk | Ambil detail, stok, review, gambar, model | Halaman detail | products, product_images, reviews |
| Tambah cart | Produk, qty | Validasi stok lalu simpan item | Cart update | carts, cart_items |
| Checkout | Alamat, payment, shipping | Validasi login, hitung ongkir, buat order | Order baru | orders, order_items, payments, shipments |
| Payment simulasi | Order, metode bayar | Set status payment | Status bayar | payments |
| Shipment | Order, metode kirim | Hitung ongkir dan buat shipment | Status kirim | shipments, shipping_rates |
| Review | Order selesai, rating, komentar | Cek kelayakan review | Review tersimpan | reviews |
| Admin dashboard | Request admin | Agregasi stok dan sales | Ringkasan toko | products, orders, order_items |

## Backend Yang Harus Didokumentasikan

- Auth dan role buyer/admin.
- Route publik, buyer, dan admin.
- Validasi form untuk cart, checkout, dan review.
- Transaction saat membuat order.
- Pengurangan stok setelah order berhasil.
- Snapshot harga di `order_items`.
- Logika payment simulasi.
- Logika shipping simulasi.
- Query dashboard admin yang read-only.

## Frontend Yang Harus Didokumentasikan

- Layout `store`, `auth`, dan `admin`.
- Header, footer, dan search bar.
- Komponen `badge`, `button`, `form-field`, `empty-state`, `order-summary`, `price`, `product-card`, `rating`, dan `toast`.
- Halaman home, katalog, detail produk, cart, checkout, order status, wishlist, review, dan dashboard admin.
- State loading, empty, success, error, dan validation.
- Responsive mobile, tablet, desktop.
- Aksesibilitas dasar untuk form, tombol, dan status.

## Urutan Kerja Dokumentasi

1. Buat ringkasan fitur per role.
2. Tuliskan DFD level konteks dan level 1.
3. Turunkan backend spec dari schema dan PRD.
4. Turunkan frontend spec dari Blade snapshot.
5. Tambahkan kamus data dari `database-design.md` dan migration Laravel.
6. Tutup dengan checklist MVP.

## Output Yang Diharapkan

Dokumentasi final harus menjawab:

- fitur apa saja yang ada;
- data mengalir dari mana ke mana;
- backend harus memproses apa;
- frontend harus menampilkan apa;
- mana yang sudah ada dan mana yang masih rencana;
- apa yang ditunda karena di luar MVP.
