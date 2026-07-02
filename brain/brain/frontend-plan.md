# Frontend Plan Ouvvee Toys

## Tujuan
Membuat frontend website e-commerce Ouvvee Toys yang profesional, responsif, dan sesuai scope MVP: katalog publik, detail produk, cart, checkout login, status pesanan, wishlist, review, dan dashboard admin read-only.

## Arah Visual
Konsep: toko mainan modern yang playful tapi tetap rapi untuk orang tua, kolektor, dan pembeli hadiah.

Karakter desain:
- Bersih dan mudah discan.
- Warna utama cerah secukupnya, bukan tampilan anak-anak berlebihan.
- Produk menjadi fokus utama lewat gambar besar dan kartu katalog yang rapi.
- Admin dashboard dibuat lebih tenang dan padat, berbeda dari halaman toko.

Palet awal:
| Token | Fungsi | Warna |
| --- | --- | --- |
| Primary | CTA utama, link aktif | `#F97316` |
| Accent | Highlight wishlist, promo kecil | `#06B6D4` |
| Success | Stok tersedia, pembayaran berhasil | `#16A34A` |
| Warning | Stok rendah, status pending | `#F59E0B` |
| Danger | Error, hapus item | `#DC2626` |
| Surface | Background utama | `#FAFAF7` |
| Text | Teks utama | `#1F2937` |

Tipografi:
- Heading: font rounded/geometric yang ramah.
- Body: font sans-serif yang mudah dibaca.
- Jika memakai Tailwind/Bootstrap default, cukup atur hierarchy, spacing, dan weight agar tidak perlu dependency font baru.

## Struktur Layout
| Layout | Dipakai Untuk | Isi Utama |
| --- | --- | --- |
| `layouts/store.blade.php` | Homepage, katalog, detail, cart, checkout, order status | Header toko, main content, footer, toast |
| `layouts/admin.blade.php` | Dashboard admin | Sidebar/nav admin, content, tabel, chart sederhana |
| `layouts/auth.blade.php` | Login/register | Form auth ringkas |

## Halaman Publik
### 1. Homepage
Tujuan: memberi kesan profesional dan mengarahkan user ke katalog.

Komponen:
- Header dengan logo, katalog, wishlist, cart, login/account.
- Hero visual mainan dengan CTA `Lihat Katalog`.
- Section kategori utama.
- Produk rekomendasi atau produk terbaru.
- Keunggulan toko: aman untuk anak, pilihan hadiah, stok jelas, checkout mudah.
- Footer dengan informasi toko dan link penting.

State:
- Empty state jika produk rekomendasi belum ada.
- Loading skeleton ringan untuk grid produk jika memakai request async.

### 2. Katalog Produk
Tujuan: user cepat menemukan mainan.

Komponen:
- Search bar.
- Filter kategori.
- Filter usia rekomendasi.
- Sorting harga/terbaru.
- Product grid.
- Pagination.

Product card wajib menampilkan:
- Gambar utama.
- Nama produk.
- Harga.
- Kategori.
- Usia rekomendasi.
- Stok atau badge stok rendah.
- Tombol detail.
- Tombol cart.
- Tombol wishlist.

### 3. Detail Produk
Tujuan: user yakin sebelum membeli.

Komponen:
- Breadcrumb.
- Galeri gambar produk.
- Nama, harga, kategori, usia rekomendasi.
- Deskripsi.
- Info ukuran, berat, stok.
- Catatan keamanan mainan.
- Quantity stepper.
- CTA tambah ke cart dan wishlist.
- Review list.

State:
- Produk habis: tombol cart disabled dan badge `Stok habis`.
- Belum ada review: empty state singkat.

## Halaman Pembeli
### 4. Cart
Tujuan: mengedit item sebelum checkout.

Komponen:
- Cart item row berisi gambar, nama, harga, jumlah, subtotal, hapus.
- Order summary berisi subtotal dan tombol checkout.
- Confirm dialog saat hapus item.

State:
- Cart kosong: CTA kembali ke katalog.
- Validation error jika jumlah melebihi stok.

### 5. Checkout
Tujuan: checkout singkat dan jelas.

Komponen:
- Pilihan alamat.
- Form alamat jika belum punya alamat.
- Payment method selector.
- Shipping method selector hanya JNE dan GOJEK.
- Ringkasan order: subtotal, ongkir, total.
- Tombol buat pesanan.

Validasi tampilan:
- Tampilkan error per field.
- Tampilkan perubahan ongkir setelah metode pengiriman dipilih.
- Disable submit saat data wajib belum lengkap.

### 6. Status Pesanan
Tujuan: pembeli tahu status transaksi.

Komponen:
- Kode order.
- Tanggal order.
- Badge status order, pembayaran, dan pengiriman.
- Rincian produk.
- Ringkasan biaya.
- Info pengiriman.

### 7. Wishlist
Tujuan: menyimpan produk incaran.

Komponen:
- Grid produk wishlist.
- Tombol pindahkan ke cart.
- Tombol hapus wishlist.

State:
- Wishlist kosong: CTA ke katalog.

### 8. Review Produk
Tujuan: pembeli memberi feedback setelah membeli.

Komponen:
- Rating input 1 sampai 5.
- Textarea komentar.
- Submit review.

Aturan UI:
- Form review hanya muncul jika user berhak review.
- Jika tidak berhak, cukup tampilkan review list tanpa form.

## Halaman Admin
### 9. Dashboard Admin
Tujuan: admin memantau stok dan penjualan tanpa CRUD produk.

Komponen:
- Stat cards: total penjualan, jumlah pesanan, stok rendah, produk aktif.
- Grafik sederhana penjualan.
- Tabel stok produk.
- Tabel pesanan terbaru.

Tampilan:
- Lebih padat dan utilitarian daripada storefront.
- Gunakan badge status untuk stok dan pesanan.
- Tidak ada tombol tambah/edit/hapus produk.

## Komponen Blade
| Komponen | File Disarankan | Catatan |
| --- | --- | --- |
| Button | `components/button.blade.php` | Variant primary, secondary, danger |
| Form field | `components/form-field.blade.php` | Label, input, error |
| Badge | `components/badge.blade.php` | Status stok, order, payment |
| Product card | `components/product-card.blade.php` | Dipakai katalog dan wishlist |
| Price | `components/price.blade.php` | Format harga konsisten |
| Rating | `components/rating.blade.php` | Tampilan review |
| Order summary | `components/order-summary.blade.php` | Cart dan checkout |
| Empty state | `components/empty-state.blade.php` | Cart, wishlist, review |
| Toast | `components/toast.blade.php` | Flash message Laravel |

## Urutan Implementasi
| Prioritas | Pekerjaan | Alasan |
| --- | --- | --- |
| 1 | Layout store, header, footer, token warna | Fondasi semua halaman |
| 2 | Product card, price, badge, rating | Komponen dipakai berulang |
| 3 | Homepage dan katalog | Katalog publik adalah goal utama |
| 4 | Detail produk | User butuh info lengkap sebelum beli |
| 5 | Cart dan checkout | Core transaksi |
| 6 | Status pesanan dan wishlist | Fitur pembeli setelah login |
| 7 | Review produk | Bergantung data order |
| 8 | Admin dashboard | Read-only, setelah data order/stok ada |
| 9 | Polish responsive dan state kosong/error | Profesionalitas akhir |

## Responsive Plan
| Breakpoint | Perilaku |
| --- | --- |
| Mobile | Header ringkas, grid 1 kolom, filter collapsible, checkout 1 kolom |
| Tablet | Grid 2 kolom, summary tetap di bawah form |
| Desktop | Grid 3-4 kolom, checkout 2 kolom dengan order summary di kanan |

## Accessibility Minimum
- Semua tombol icon punya label atau tooltip.
- Form field punya label yang jelas.
- Error validasi muncul dekat input.
- Warna status tidak menjadi satu-satunya penanda; tetap pakai teks.
- Fokus keyboard terlihat.
- Gambar produk punya alt text dari `product_images.alt_text`.

## Ditunda / Tidak Perlu Sekarang
| Item | Alasan |
| --- | --- |
| Landing page marketing panjang | MVP butuh toko yang bisa dipakai, bukan halaman promosi kosong |
| Admin CRUD produk | Bertentangan dengan scope admin read-only |
| Payment gateway asli | Scope pembayaran simulasi |
| Live tracking ekspedisi | Scope hanya JNE dan GOJEK simulasi |
| 3D preview produk | Sudah ditandai di luar MVP |
| Custom design system besar | Komponen Blade kecil sudah cukup |

## Checklist Selesai
- Homepage punya CTA jelas ke katalog.
- Katalog bisa dicari, difilter, dan dipaginasi.
- Detail produk menampilkan galeri, stok, usia rekomendasi, berat, ukuran, dan keamanan.
- Cart bisa ubah jumlah dan hapus item.
- Checkout menampilkan alamat, pembayaran, pengiriman, ongkir, dan total.
- Status pesanan menampilkan payment dan shipment.
- Wishlist punya empty state.
- Review tampil di detail produk.
- Admin dashboard read-only.
- Semua halaman responsif mobile dan desktop.
