# Tahap 4: Perancangan Basis Data Secara Logika

Perancangan logik dilakukan dengan teknik normalisasi agar data tidak berulang dan hubungan antar data jelas.

## Hasil Normalisasi

### 1. Tabel Penjual

| Field | Keterangan |
|---|---|
| id_penjual | Kunci primer |
| nama_penjual | Nama penjual |
| alamat | Alamat penjual |
| email | Email penjual |

### 2. Tabel Telepon Penjual

| Field | Keterangan |
|---|---|
| id_telepon | Kunci primer |
| id_penjual | Kunci tamu ke tabel penjual |
| nomor_telepon | Nomor telepon penjual |

### 3. Tabel Users

| Field | Keterangan |
|---|---|
| id_user | Kunci primer |
| nama | Nama user |
| alamat | Alamat user |
| email | Email user |
| nomor_telepon | Nomor telepon user |
| password | Password user |
| role | Peran user, yaitu admin atau pembeli |

### 4. Tabel Kategori

| Field | Keterangan |
|---|---|
| id_kategori | Kunci primer |
| nama_kategori | Nama kategori barang |

### 5. Tabel Barang

| Field | Keterangan |
|---|---|
| id_barang | Kunci primer |
| id_penjual | Kunci tamu ke tabel penjual |
| id_kategori | Kunci tamu ke tabel kategori |
| nama_barang | Nama barang |
| harga | Harga barang |
| stok | Jumlah stok barang |
| deskripsi | Deskripsi barang |

### 6. Tabel Pesanan

| Field | Keterangan |
|---|---|
| id_pesanan | Kunci primer |
| id_user | Kunci tamu ke tabel users |
| tanggal_pesanan | Tanggal pesanan dibuat |
| total_pesanan | Total harga pesanan |
| status_pesanan | Status pesanan |

### 7. Tabel Detail Pesanan

| Field | Keterangan |
|---|---|
| id_detail | Kunci primer |
| id_pesanan | Kunci tamu ke tabel pesanan |
| id_barang | Kunci tamu ke tabel barang |
| jumlah | Jumlah barang yang dibeli |
| harga_satuan | Harga barang saat dibeli |
| subtotal | Jumlah dikali harga satuan |

### 8. Tabel Pembayaran

| Field | Keterangan |
|---|---|
| id_pembayaran | Kunci primer |
| id_pesanan | Kunci tamu ke tabel pesanan |
| metode_pembayaran | Transfer bank, kartu kredit, atau CoD |
| tanggal_bayar | Tanggal pembayaran |
| status_pembayaran | Status pembayaran |
| total_bayar | Total pembayaran |

### 9. Tabel Jasa Pengiriman

| Field | Keterangan |
|---|---|
| id_jasa | Kunci primer |
| nama_jasa | Nama jasa pengiriman, yaitu JNE atau SiCepat |

### 10. Tabel Pengiriman

| Field | Keterangan |
|---|---|
| id_pengiriman | Kunci primer |
| id_pesanan | Kunci tamu ke tabel pesanan |
| id_jasa | Kunci tamu ke tabel jasa pengiriman |
| nomor_resi | Nomor resi pengiriman |
| ongkos_kirim | Biaya pengiriman |
| status_kirim | Status pengiriman |

## Relasi Logik

| Tabel Asal | Tabel Tujuan | Relasi |
|---|---|---|
| telepon_penjual.id_penjual | penjual.id_penjual | Many to one |
| barang.id_penjual | penjual.id_penjual | Many to one |
| barang.id_kategori | kategori.id_kategori | Many to one |
| pesanan.id_user | users.id_user | Many to one |
| detail_pesanan.id_pesanan | pesanan.id_pesanan | Many to one |
| detail_pesanan.id_barang | barang.id_barang | Many to one |
| pembayaran.id_pesanan | pesanan.id_pesanan | One to one |
| pengiriman.id_pesanan | pesanan.id_pesanan | One to one |
| pengiriman.id_jasa | jasa_pengiriman.id_jasa | Many to one |
