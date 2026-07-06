# Analisa Kebutuhan User

## Tujuan Tahap
Menetapkan kebutuhan awal user untuk website e-commerce Ouvvee Toys sebagai toko mainan sebelum masuk ke DFD dan rancangan konseptual database.

## A. Kelompok User
| Kelompok User | Tujuan Utama | Kebutuhan |
| --- | --- | --- |
| Pengunjung | Menilai produk sebelum membeli. | Melihat homepage, katalog, detail produk, foto produk, kategori, harga, stok, usia rekomendasi, dan catatan keamanan tanpa login. |
| Pembeli | Membeli mainan dengan alur checkout sederhana. | Login/register, mengelola keranjang, wishlist, alamat, checkout, pembayaran simulasi, status pesanan, dan review produk. |
| Admin | Memantau stok dan penjualan. | Melihat ringkasan penjualan, jumlah pesanan, daftar stok, dan produk dengan stok rendah. |

## B. Dokumen yang Dihasilkan
| Dokumen | Status | Catatan |
| --- | --- | --- |
| PRD | Selesai | Sudah mengikuti scope toko mainan. |
| Analisa kebutuhan user | Selesai | Dokumen ini. |
| Kebutuhan data | Selesai awal | Data utama diturunkan dari PRD dan schema. |
| Rancangan relasi database | Draft | Entitas, relasi, kunci, dan normalisasi sudah ada di `database-design.md`. |
| Implementasi basis data | Draft | Laravel migration sudah mengikuti scope toko mainan dan `product_images` di Supabase PostgreSQL. |
| DFD sistem | Ditunda | Belum dikerjakan sesuai instruksi. |
| ERD / model konseptual | Belum | Dikerjakan setelah DFD disetujui. |

## C. Data yang Dibutuhkan
| Area Data | Data yang Dibutuhkan | Digunakan Oleh |
| --- | --- | --- |
| User | Nama, email, password, nomor telepon, role. | Login, checkout, dashboard admin. |
| Alamat | Nama penerima, nomor telepon, provinsi, kota, kecamatan, detail alamat, kode pos, alamat default. | Checkout dan pengiriman. |
| Kategori | Nama kategori dan deskripsi. | Filter katalog dan pengelompokan produk. |
| Produk | Nama produk, kategori, harga, deskripsi, gambar utama, stok, usia rekomendasi, catatan keamanan, ukuran, berat, status. | Katalog, detail produk, keranjang, checkout, stok admin. |
| Gambar Produk | Produk terkait, URL gambar, alt text, status gambar utama. | Foto katalog dan galeri detail produk. |
| Keranjang | User, produk, jumlah item, status keranjang. | Penyimpanan item sebelum checkout. |
| Wishlist | User, produk, tanggal simpan. | Produk favorit pembeli. |
| Pesanan | Kode pesanan, user, alamat, tanggal, subtotal, ongkir, total, status pesanan. | Checkout, status pesanan, laporan penjualan. |
| Item Pesanan | Pesanan, produk, jumlah, harga satuan, total per item. | Rincian pesanan dan ringkasan penjualan. |
| Pembayaran | Pesanan, metode pembayaran, status pembayaran, waktu bayar. | Pembayaran simulasi dan status pesanan. |
| Pengiriman | Pesanan, metode pengiriman, ongkir, nomor resi, status pengiriman. | Checkout dan pelacakan pesanan. |
| Tarif Ongkir | Metode pengiriman, batas berat minimum/maksimum, biaya dasar, biaya per kg. | Perhitungan ongkir otomatis. |
| Review | User, produk, pesanan, rating, komentar, tanggal review. | Detail produk dan evaluasi pembelian. |

## D. DFD
Ditunda. Tahap ini berhenti di analisa kebutuhan user dan kebutuhan data.

## Catatan Project Manager
- Scope terbaru: Ouvvee Toys adalah toko mainan, bukan khusus figur 3D printed.
- Prioritas validasi: kategori mainan awal, data produk wajib, dan batas dashboard admin read-only.
- Di luar MVP: admin CRUD produk, payment gateway asli, integrasi ekspedisi real-time, dan preview 3D.
- Next step setelah dokumen ini disetujui: mulai DFD level konteks dan level 1.
