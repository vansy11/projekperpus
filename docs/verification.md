# Catatan verifikasi KTA

- Kartu depan-belakang memakai ukuran ID-1 (85,6 × 53,98 mm) dan lembar cetak A4 untuk duplex skala 100%.
- Logo kampus pada kartu diambil dari situs UPT Perpustakaan Pascasarjana UNIGA. Cap bertuliskan “VALIDASI QR DIGITAL” menandai pemeriksaan status melalui sistem; garis tanda tangan disediakan bagi pejabat berwenang.
- QR mengarah ke halaman verifikasi publik dengan nama, NIM, program studi, fakultas, tanggal terbit, dan status keanggotaan terkini. Foto hanya tampil ketika persetujuan QR tersimpan; foto anggota lama tanpa persetujuan tidak tampil. Email, nomor HP, dokumen KTM, dan kata sandi tidak ditampilkan.
- Form pendaftaran meminta persetujuan bahwa data tersebut dapat dilihat publik saat QR dipindai.
- Alamat QR harus dapat diakses ponsel yang memindainya. Untuk server lokal, gunakan alamat LAN yang ditampilkan `scripts/start-local.ps1`; untuk akses umum dan tautan kartu yang stabil, deploy aplikasi ke domain HTTPS. IP LAN atau localhost tidak dapat dibuka dari internet.
- QR sudah disiapkan sebagai SVG dan tautan, tetapi pemindaian dengan kamera ponsel serta cetak fisik perlu diperiksa pada perangkat/printer tujuan.
- Tanda tangan basah dan cap resmi harus dibubuhkan/disediakan oleh pejabat kampus yang berwenang; tidak dibuat tanda tangan atau cap resmi rekaan.

## Integrasi pembaruan teman, 12 November 2026

- Source dari `yuna0202/perpustakaa` pada commit `c749df9ec1597792609f84c4ee05bcac108b4343` disalin ke branch integrasi; riwayat Git yang terpisah tidak digabung.
- Dockerfile ditambah ekstensi `mbstring` agar dependensi Laravel 13 dapat dipasang. Persetujuan QR disimpan sebagai kolom baru dengan nilai awal `false` untuk anggota lama.
- `composer install`, `npm run build`, dan `php artisan view:cache` berhasil. `php artisan test --compact`: 48 lulus, 374 assertions.
- Database Laragon dicadangkan secara lokal sebelum migrasi; migrasi `2026_11_12_000001_add_qr_consent_to_members` berhasil tanpa reset atau seeding.
- Docker build/deployment, akses QR dari ponsel, dan cetak fisik belum diuji.
