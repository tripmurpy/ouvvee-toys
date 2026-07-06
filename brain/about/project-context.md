# Project Context

## Ringkasan Produk
Ouvvee Toys adalah toko mainan pajangan yang menjual produk mainan untuk dilihat, dikoleksi, dijadikan hadiah, dan tetap bisa dibeli lewat checkout.

## Tujuan Bisnis
- Menyediakan katalog mainan yang bisa diakses publik tanpa login.
- Memberi informasi produk yang cukup sebelum checkout, terutama stok, harga, usia rekomendasi, dan catatan keamanan.
- Menjalankan alur transaksi sederhana dari cart sampai pesanan selesai.
- Menyediakan dashboard admin read-only untuk memantau stok dan penjualan.

## Kelompok User
| User | Kebutuhan Utama |
| --- | --- |
| Pengunjung | Melihat homepage, katalog, detail produk, foto produk, review, dan informasi mainan tanpa login. |
| Pembeli | Login, menambah ke cart, checkout, memilih alamat, pembayaran, pengiriman, wishlist, review, dan melihat status pesanan. |
| Admin | Melihat ringkasan penjualan, stok, dan pesanan terbaru tanpa CRUD produk. |

## Fitur Wajib
| Fitur | Deskripsi |
| --- | --- |
| Katalog publik | Pengunjung dapat melihat daftar produk mainan yang dijual. |
| Detail produk | Produk menampilkan foto, galeri, deskripsi, kategori, stok, usia rekomendasi, ukuran, berat, dan catatan keamanan. |
| Cart | Pembeli bisa menambah lebih dari satu jenis barang dan mengubah jumlah pembelian. |
| Checkout | Checkout hanya untuk user login. |
| Review | Pembeli dapat memberi review produk setelah transaksi. |
| Wishlist | Pembeli dapat menyimpan produk favorit. |
| Status pesanan | Pembeli bisa melihat status pembayaran dan pengiriman. |
| Dashboard admin | Admin memantau stok dan penjualan, bukan mengelola produk. |

## Aturan Bisnis Inti
1. Seorang penjual dapat menjual banyak barang.
2. Seorang pembeli dapat membeli lebih dari satu jenis barang dari penjual.
3. Stok barang berkurang sesuai jumlah barang yang dibeli.
4. Nomor telepon penjual boleh lebih dari satu.
5. Pembayaran dapat dilakukan melalui transfer bank, kartu kredit, dan bayar di tempat (COD).
6. Pengiriman barang dilakukan melalui jasa pengiriman.
7. Review hanya relevan setelah pembeli melakukan transaksi.
8. Checkout wajib melalui akun yang sudah login.

## Ruang Lingkup Sistem
- Homepage, katalog, detail produk, cart, checkout, order status, wishlist, review, dan admin dashboard.
- Payment simulasi, bukan payment gateway asli.
- Shipping simulasi dengan jasa pengiriman yang ditentukan sistem.
- Data produk dan stok disimpan di Supabase PostgreSQL sebagai database relasional.
- Katalog MVP berisi 9 display figure dari brief produk, dengan thumbnail publik di `backend/public/images/products/`.

## Output yang Diharapkan
Website e-commerce berbasis Laravel, Blade, dan Supabase PostgreSQL yang mendukung browsing katalog publik, detail produk yang informatif, cart dan checkout login, pembayaran simulasi, pengiriman, review, wishlist, status pesanan, dan dashboard admin sederhana.

## Goals Akhir
- Katalog produk dapat diakses publik.
- Checkout hanya dapat dilakukan oleh user login.
- Produk memiliki gambar katalog, galeri foto, kategori, stok, usia rekomendasi, dan informasi keamanan dasar.
- Pesanan mencatat pembayaran simulasi dan pengiriman.
- Admin dapat melihat stok dan ringkasan penjualan tanpa fitur CRUD produk.
