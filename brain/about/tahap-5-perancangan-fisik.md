# Tahap 5: Perancangan Basis Data Secara Fisik

Desain fisik basis data aktif di Supabase PostgreSQL melalui Laravel migration `backend/database/migrations/2026_07_06_000000_create_ouvvee_schema.php`.

> Catatan: SQL di bawah adalah draft fisik lama. Skema yang dipakai sekarang mengikuti migration Laravel.

```sql
CREATE DATABASE ouvvee_toys;
USE ouvvee_toys;

CREATE TABLE penjual (
    id_penjual INT AUTO_INCREMENT PRIMARY KEY,
    nama_penjual VARCHAR(100) NOT NULL,
    alamat TEXT,
    email VARCHAR(100) UNIQUE
);

CREATE TABLE telepon_penjual (
    id_telepon INT AUTO_INCREMENT PRIMARY KEY,
    id_penjual INT NOT NULL,
    nomor_telepon VARCHAR(20) NOT NULL,
    FOREIGN KEY (id_penjual) REFERENCES penjual(id_penjual)
);

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    email VARCHAR(100) UNIQUE NOT NULL,
    nomor_telepon VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pembeli') NOT NULL
);

CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    id_penjual INT NOT NULL,
    id_kategori INT NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT NOT NULL,
    deskripsi TEXT,
    FOREIGN KEY (id_penjual) REFERENCES penjual(id_penjual),
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);

CREATE TABLE pesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    tanggal_pesanan DATETIME NOT NULL,
    total_pesanan DECIMAL(12,2) NOT NULL,
    status_pesanan VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

CREATE TABLE detail_pesanan (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan),
    FOREIGN KEY (id_barang) REFERENCES barang(id_barang)
);

CREATE TABLE pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL UNIQUE,
    metode_pembayaran ENUM('transfer bank', 'kartu kredit', 'cod') NOT NULL,
    tanggal_bayar DATETIME,
    status_pembayaran VARCHAR(50) NOT NULL,
    total_bayar DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)
);

CREATE TABLE jasa_pengiriman (
    id_jasa INT AUTO_INCREMENT PRIMARY KEY,
    nama_jasa VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE pengiriman (
    id_pengiriman INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL UNIQUE,
    id_jasa INT NOT NULL,
    nomor_resi VARCHAR(100),
    ongkos_kirim DECIMAL(12,2) NOT NULL,
    status_kirim VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan),
    FOREIGN KEY (id_jasa) REFERENCES jasa_pengiriman(id_jasa)
);

INSERT INTO penjual (nama_penjual, alamat, email)
VALUES ('Ouvvee', 'Alamat toko Ouvvee', 'ouvvee@example.com');

INSERT INTO jasa_pengiriman (nama_jasa)
VALUES ('JNE'), ('SiCepat');
```

## Keterangan Desain Fisik

| Komponen | Keterangan |
|---|---|
| INT AUTO_INCREMENT | Digunakan untuk primary key agar otomatis bertambah. |
| VARCHAR | Digunakan untuk data teks pendek seperti nama, email, dan nomor telepon. |
| TEXT | Digunakan untuk alamat dan deskripsi barang. |
| DECIMAL(12,2) | Digunakan untuk data uang seperti harga, total, dan ongkos kirim. |
| ENUM | Digunakan untuk pilihan tetap seperti role dan metode pembayaran. |
| FOREIGN KEY | Digunakan untuk menghubungkan tabel. |
| UNIQUE | Digunakan agar email, nama jasa, pembayaran pesanan, dan pengiriman pesanan tidak ganda. |
