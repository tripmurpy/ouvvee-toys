# Session 049

**Tanggal:** 2026-07-07
**Topik Sesi:** Secure environment files and ignore runtime files

## Keputusan Penting

- Menghapus tracking Git untuk file `.env` di root dan `.env` di subfolder `backend` agar informasi sensitif tidak bocor ke repositori.
- Menambahkan file `.gitignore` di tingkat root untuk mengabaikan file `.env` serta file runtime Laravel (seperti cache, log, session, view compile, dan file cache PHPUnit) secara permanen.
- Membersihkan tracking Git untuk seluruh file session, view, cache, log Laravel yang sebelumnya tidak sengaja ter-track, dengan tetap mempertahankan direktori kosong menggunakan file `.gitkeep` yang sesuai.

## Perubahan Utama

- Membuat file [gitignore](file:///c:/Users/ASUS/Documents/.Benny/project/.ouvetoys/.gitignore) di root repository.
- Menghapus tracking Git (`git rm --cached`) untuk:
  - `.env`
  - `backend/.env`
  - `backend/.phpunit.result.cache`
  - Seluruh file di bawah `backend/storage/framework/sessions/` (kecuali `.gitkeep`)
  - Seluruh file di bawah `backend/storage/framework/views/` (kecuali `.gitkeep`)
  - Seluruh file di bawah `backend/storage/framework/cache/data/` (kecuali `.gitkeep`)
  - Seluruh file log di bawah `backend/storage/logs/` (kecuali `.gitkeep`)

## Verifikasi

- Menjalankan `git status` untuk memastikan file-file tersebut tidak lagi ter-track dan `.gitignore` berfungsi dengan benar.
