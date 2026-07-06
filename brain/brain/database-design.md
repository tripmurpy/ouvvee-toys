# Database Design

## DBMS
Supabase PostgreSQL dengan model data relasional.

## Entitas
| Tabel | Fungsi |
| --- | --- |
| users | Akun pembeli dan admin. |
| addresses | Alamat pengiriman user. |
| categories | Kategori produk. |
| products | Data mainan yang dijual. |
| product_images | Gambar produk untuk katalog dan detail. |
| carts | Keranjang aktif milik user. |
| cart_items | Item produk dalam keranjang. |
| orders | Transaksi pembelian. |
| order_items | Rincian produk dalam pesanan. |
| payment_methods | Pilihan transfer bank, kartu kredit, dan COD. |
| payments | Data pembayaran pesanan. |
| shipping_methods | Pilihan JNE dan GOJEK. |
| shipping_rates | Aturan ongkir otomatis. |
| shipments | Data pengiriman pesanan. |
| reviews | Rating dan komentar produk. |
| wishlists | Produk favorit user. |

## Kunci Utama dan Kandidat
| Tabel | Primary Key | Candidate/Unique Key |
| --- | --- | --- |
| users | id_user | email |
| addresses | id_address | - |
| categories | id_category | category_name |
| products | id_product | - |
| product_images | id_image | id_product + image_url |
| carts | id_cart | - |
| cart_items | id_cart_item | id_cart + id_product |
| orders | id_order | order_code |
| order_items | id_order_item | id_order + id_product |
| payment_methods | id_payment_method | method_name |
| payments | id_payment | id_order |
| shipping_methods | id_shipping_method | method_name |
| shipping_rates | id_shipping_rate | id_shipping_method + min_weight_gram + max_weight_gram |
| shipments | id_shipment | id_order |
| reviews | id_review | id_user + id_product + id_order |
| wishlists | id_user + id_product | id_user + id_product |

## Relasi Utama
1. User memiliki banyak alamat.
2. User memiliki satu keranjang aktif.
3. Keranjang memiliki banyak item.
4. Kategori memiliki banyak produk.
5. Produk memiliki banyak gambar produk.
6. User membuat banyak pesanan.
7. Pesanan memiliki banyak item pesanan.
8. Pesanan memiliki satu pembayaran.
9. Pesanan memiliki satu pengiriman.
10. User dan produk terhubung melalui review dan wishlist.

## Seed Katalog
- Katalog MVP mengikuti 9 produk display figure dari brief produk.
- Thumbnail disimpan sebagai file publik di `backend/public/images/products/` dan dicerminkan ke `products.image_url`.
- `product_images` menyimpan baris gallery per produk; satu baris utama cukup untuk thumbnail, detail page bisa menambah gallery lain nanti.

## Normalisasi
- UNF: data transaksi mentah berisi order, user, alamat, produk, pembayaran, dan pengiriman dalam satu bentuk.
- 1NF: pisahkan `orders` dan `order_items` agar setiap produk dalam pesanan menjadi baris atomik.
- 2NF: pisahkan produk, kategori, dan detail pesanan agar atribut non-key bergantung penuh pada primary key.
- 3NF: pisahkan metode pembayaran, metode pengiriman, tarif ongkir, dan alamat untuk menghindari ketergantungan transitif.

## DFD Level 0
| Entitas | Input ke Sistem | Output dari Sistem |
| --- | --- | --- |
| Pengunjung | Permintaan katalog/detail produk | Informasi produk, gambar produk, dan detail mainan |
| Pembeli | Login, keranjang, checkout, pembayaran, review, wishlist | Status pesanan, invoice, pembayaran, pengiriman |
| Admin | Permintaan laporan dashboard | Data stok produk dan laporan penjualan |

## DFD Level 1
| Proses | Nama | Data Store |
| --- | --- | --- |
| P1 | Registrasi dan Login | users |
| P2 | Melihat Katalog Produk | products, categories, product_images |
| P3 | Mengelola Wishlist | wishlists |
| P4 | Mengelola Keranjang | carts, cart_items |
| P5 | Checkout Pesanan | orders, order_items |
| P6 | Pembayaran Simulasi | payments |
| P7 | Pengiriman | shipments, shipping_rates |
| P8 | Review Produk | reviews |
| P9 | Dashboard Admin | products, orders, order_items |
