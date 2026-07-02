# Product Requirement Document (PRD)

## Judul Sistem
Ouvvee Toys - Website E-Commerce Toko Mainan

## Kelompok User
| User | Hak Akses |
| --- | --- |
| Pengunjung | Melihat homepage, katalog, detail produk, foto produk, dan informasi mainan. |
| Pembeli | Checkout, mengelola keranjang, wishlist, alamat, status pesanan, dan review. |
| Admin | Melihat dashboard penjualan dan stok produk. |

## Scope MVP
- Homepage dengan logo, navigasi, hero visual mainan, dan tombol ke katalog.
- Katalog produk berisi gambar, nama, harga, stok, detail, tombol keranjang, dan wishlist.
- Detail produk berisi foto, galeri produk, harga, deskripsi, kategori, usia rekomendasi, ukuran, berat, stok, review, dan aksi pembelian.
- Keranjang belanja berisi item, jumlah, harga satuan, total, hapus item, dan checkout.
- Checkout berisi pilihan alamat, metode pembayaran, metode pengiriman, perhitungan ongkir, dan ringkasan pesanan.
- Status pesanan berisi kode, tanggal, status pembayaran, status pengiriman, total, dan detail produk.
- Dashboard admin berisi total penjualan, jumlah pesanan, stok rendah, daftar stok, dan grafik sederhana.

## Komponen Wajib Website
### Atoms
- Button
- Input
- Select
- Checkbox / Radio
- Badge status
- Icon
- Tooltip
- Spinner

### Molecules
- Search bar
- Form field
- Product card
- Cart item row
- Order summary row
- Rating display
- Filter group
- Pagination
- Breadcrumb

### Organisms
- Header / navbar
- Footer
- Product grid
- Product detail section
- Product image gallery
- Cart section
- Checkout form section
- Payment method selector
- Shipping method selector
- Review list
- Admin stats panel
- Data table stok dan pesanan

### Templates
- Homepage layout
- Catalog page layout
- Product detail layout
- Cart layout
- Checkout layout
- Order status layout
- Admin dashboard layout
- Auth layout

### States Wajib
- Loading state
- Empty state
- Validation state
- Success state
- Error state
- Confirm dialog
- Toast / flash message

## Batasan
- Admin hanya melihat stok dan laporan penjualan.
- Admin tidak menambah, mengubah, atau menghapus produk melalui panel.
- Data produk dimasukkan melalui database atau seeder.
- Pembayaran hanya simulasi, bukan payment gateway asli.
- Pengiriman hanya menggunakan JNE dan GOJEK.

## Alur Pengguna (User Flow)
1. Pengunjung membuka homepage.
2. Pengunjung melihat katalog dan detail produk.
3. Pengunjung login atau register saat ingin checkout.
4. Pembeli menambahkan produk ke keranjang atau wishlist.
5. Pembeli checkout dengan alamat, metode pembayaran, dan metode pengiriman.
6. Sistem menghitung ongkir berdasarkan berat dan metode pengiriman.
7. Sistem membuat pesanan, pembayaran simulasi, dan pengiriman.
8. Pembeli melihat status pesanan.
9. Pembeli dapat memberi review produk setelah transaksi.

## Dokumen Turunan
- Kebutuhan user.
- Kebutuhan data.
- DFD sistem.
- ERD/model konseptual.
- Rancangan relasi database.
- Normalisasi database.
- Desain user interface.
- Script implementasi basis data MySQL.
