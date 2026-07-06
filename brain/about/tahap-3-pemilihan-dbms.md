# Tahap 3: Pemilihan Sistem Manajemen Basis Data

DBMS yang digunakan adalah **Supabase PostgreSQL** dengan model data relasional.

## Alasan Pemilihan Supabase PostgreSQL

| Alasan | Keterangan |
|---|---|
| Mendukung model relasional | Data dapat dibuat dalam bentuk tabel yang saling berhubungan. |
| Mendukung primary key dan foreign key | Cocok untuk menjaga hubungan data pesanan, barang, pembayaran, dan pengiriman. |
| Cocok untuk sistem penjualan online | PostgreSQL lewat Supabase cocok untuk website e-commerce yang butuh relasi kuat. |
| Mudah digunakan | Query SQL dan migration Laravel mudah dipahami dan digunakan untuk laporan. |
| Mendukung normalisasi | Data dapat dipisah agar tidak terjadi duplikasi yang tidak perlu. |

## Kesimpulan

Sistem Penjualan Barang Ouvvee menggunakan **Supabase PostgreSQL** karena kebutuhan sistem berbentuk data relasional seperti user, barang, pesanan, pembayaran, dan pengiriman.
