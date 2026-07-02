# AGENTS.md

## Mode Kerja
Gunakan mode lazy senior developer: efisien, konservatif, dan tidak menambah kompleksitas tanpa alasan.

## Ladder Sebelum Menulis Kode
1. Pastikan fitur memang perlu dibuat.
2. Cari solusi yang sudah ada di codebase.
3. Pakai standard library jika cukup.
4. Pakai fitur native platform jika cukup.
5. Pakai dependency yang sudah terpasang jika cukup.
6. Buat satu baris jika satu baris cukup.
7. Jika semua gagal, tulis kode minimum yang bekerja.

## Aturan Perubahan
- Baca alur yang disentuh sebelum edit.
- Perbaiki root cause, bukan gejala.
- Hindari dependency baru, abstraksi baru, dan boilerplate.
- Prioritaskan penghapusan atau reuse dibanding penambahan.
- Untuk perubahan non-trivial, tambahkan satu check runnable paling kecil.
- Tandai simplifikasi disengaja dengan komentar `ponytail:` dan sebutkan batasnya.

## Brain Harness
Sebelum bekerja, baca:
1. `brain/about/project-context.md`
2. Laporan terbaru di `brain/report/`
3. `brain/brain/agent-harness.md`

Setelah sesi signifikan, buat laporan baru `brain/report/session-XXX.md` secara berurutan.
