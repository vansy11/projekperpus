# Hasil verifikasi

## Revisi KTA dan login pada 9 November 2026

- Form masuk memiliki tombol lihat/sembunyikan password; form pendaftaran tetap menampilkan petunjuk komposisi password dan tombol yang sama.
- Tanggal terbit KTA dan halaman verifikasi berasal dari `tanggal_terbit` yang disimpan saat admin menyetujui pendaftaran. QR membuka route verifikasi anggota yang membaca status terbaru dari database. Saat kartu dibuka melalui localhost, URL QR mengambil IP LAN privat aktif dari pemantau.
- Pada 9 November 2026, anggota NIM `24510005` yang disetujui sebelum kolom tanggal dibuat memiliki `updated_at=2026-11-02 19:21:22` setelah pendaftaran `2026-11-02 18:51:28`. Migrasi backfill menggunakan jejak perubahan ini; `tanggal_terbit` kini `2026-11-02 19:21:22`. Baris tersebut dicadangkan di `.runtime/backups/anggota-3-sebelum-tanggal-terbit-2026-11-09.sql`. Tidak ada lagi anggota disetujui dengan tanggal terbit kosong.
- Peringatan teknis localhost di bawah kartu dihapus. Server yang berjalan pada `127.0.0.1:8000` dan `10.10.9.228:8000` menampilkan halaman Laravel yang valid; login mengandung tombol lihat password, katalog melalui LAN terbuka. `php artisan test --compact`: **45 passed, 364 assertions**. Pemindaian fisik dari ponsel belum diuji.

## Akses LAN mengikuti DHCP pada 3 November 2026

- Helper startup menjalankan dua server yang masing-masing terikat ke localhost dan IPv4 LAN privat aktif, lalu memantau perubahan DHCP tiap 5 detik. `APP_URL` dikembalikan ke localhost untuk perintah CLI; `APP_DEBUG=false` tetap berlaku.
- QR kartu memakai asal HTTP yang digunakan untuk membuka halaman kartu. Pengujian fitur mencakup dua alamat LAN berbeda dan peringatan bila halaman dibuka melalui localhost. URL cover/foto memakai path relatif.
- Pada LAN saat ini, listener terikat ke `127.0.0.1:8000` dan `192.168.1.5:8000`; kedua beranda serta katalog melalui LAN mengembalikan HTTP 200. `php artisan test --compact`: **45 passed, 359 assertions**.
- Pengujian dari kamera atau browser ponsel lain belum dilakukan. Aturan firewall dan isolasi jaringan Wi-Fi dapat memengaruhi akses. QR pada kartu cetak tetap memuat IP lama dan perlu dicetak ulang jika DHCP berubah, kecuali tersedia alamat DNS yang stabil.

## Revisi kelompok pada 2 November 2026

- Database MySQL dicadangkan ke `.runtime/backups/perpustakaan-sebelum-revisi-2026-11-02.sql` sebelum migration. Kolom fakultas dan tanggal terbit anggota serta cover buku ditambahkan; angkatan lama tetap disimpan dan kolomnya dapat kosong. Setelah migration terdapat 2 anggota dan 20 buku; fakultas anggota lama berhasil terisi untuk program studi yang cocok.
- `php artisan test --compact`: **45 passed, 353 assertions** dengan SQLite in-memory. Pengujian mencakup validasi program studi/fakultas, CAPTCHA dan password, hak akses, notifikasi hasil, QR, serta upload/ganti/hapus cover. `npm run build` dan `php artisan view:cache` berhasil.
- Pemeriksaan browser: memilih Psikologi menampilkan Fakultas Sosial dan Budaya; kontrol tampilkan password berfungsi; kolom angkatan tidak ada dan soal verifikasi tersedia.
- Batas verifikasi: email nyata belum diuji karena konfigurasi masih mode log; pemindaian QR melalui kamera ponsel belum diuji. Tanda tangan dan stempel resmi belum disediakan, sehingga kartu menampilkan tempat pengesahan saja.

## Penyelarasan UI pada 2 November 2026

- Arah visual memakai kontras gelap-terang, judul editorial, dan aksen biru dari [World Class Edge](https://www.worldclassedge.com/), diterapkan ke katalog dan layanan perpustakaan. Detail interaksi mengikuti [Vercel Web Interface Guidelines](https://vercel.com/design/guidelines). Seluruh halaman publik dan admin memakai komponen tombol, panel, field, navigasi, status, serta tabel yang seragam.
- Beranda menampilkan ringkasan koleksi dari database, pencarian, koleksi terbaru, dan jalur ke layanan anggota. Tidak ada sampul atau statistik buatan.
- `npm run build` berhasil dan `php artisan view:cache` berhasil. Regresi Laravel: **37 passed, 296 assertions** memakai SQLite in-memory. Database MySQL development tidak direset, dimigrasi ulang, atau di-seed.
- Browser: pencarian `Basis Data`, filter kategori Teknologi Informasi, dan detail menunjukkan stok 5 serta Rak A-03. Link kembali dari detail mempertahankan filter pada URL. Login admin, dashboard, navigasi mobile, dan tabel admin berjalan. Pendaftaran kosong memfokuskan kolom nama wajib.
- Tampilan publik dan admin diperiksa pada lebar desktop 1280 px dan mobile 390 px; tidak ada overflow horizontal. Input pencarian mobile berukuran 16 px, tabel admin memiliki scroll sendiri. Tidak ada error atau warning console pada pemeriksaan akhir.
- Pratinjau tersimpan di `docs/screenshots/desain-editorial-desktop.jpg`, `desain-editorial-mobile.jpg`, dan `desain-editorial-admin.jpg`.

## Pembaruan desain pada 2 November 2026

- Desain publik, login/pendaftaran, kartu/verifikasi anggota, dan admin memakai warna netral, tipografi sans-serif, border tipis, ikon SVG, serta favicon SVG/ICO. Acuan: [Vercel Web Interface Guidelines](https://vercel.com/design/guidelines). Implementasi tetap Laravel Blade dan Tailwind, tanpa migrasi framework.
- Dekorasi emoji, sampul buku buatan, slogan, tanda bintang label, dan karakter panah teks pagination dihapus. Kolom wajib tetap memakai `required`; status tetap dijelaskan dengan teks.
- `npm run build` dan `php artisan view:cache` berhasil. Suite regresi: **37 passed, 296 assertions**. Setelah penyempurnaan pagination/pesan validasi, subset CatalogueTest dan AuthenticationTest juga lulus: **10 passed, 78 assertions**.
- Browser: pencarian Basis Data dan filter Teknologi Informasi menghasilkan buku yang sesuai; detail menampilkan stok 5 dan Rak A-03. Login gagal menampilkan pesan per field dan memfokuskan email; login admin serta logout berhasil.
- Pendaftaran kosong dicegah oleh validasi browser dengan fokus pada nama; tombol tetap dapat digunakan. Form tambah buku mempertahankan sembilan kolom wajib. Tidak ada data anggota/buku yang ditambah, diubah, atau dihapus pada pemeriksaan UI ini.
- Pada viewport 390×844, beranda, pendaftaran, login, dashboard, dan daftar buku tidak melebar keluar layar. Tabel admin memiliki area scroll sendiri (333 px dengan isi 724 px). Ukuran font input mobile 16 px. Menu mobile bekerja; Escape menutup menu dan mengembalikan fokus ke tombol.
- Desktop diperiksa pada viewport default 1280 px dan 1365×900. Pagination admin berpindah dari halaman 1 ke 2. Tidak ada error/warning console pada tab pemeriksaan akhir.
- MySQL Laragon port 3306 dan PHP port 8000 sempat berhenti saat pemeriksaan dimulai; keduanya dijalankan kembali memakai konfigurasi/database yang sudah ada. Tidak ada migration atau seeder yang dijalankan ulang.
- Pratinjau: `docs/screenshots/desain-baru-desktop.jpg`, `desain-baru-mobile.jpg`, dan `desain-baru-admin.jpg`. Kartu/QR tercakup pengujian otomatis; cetak fisik tidak diuji ulang pada perubahan tampilan ini.

## Perbaikan koneksi pada 2 November 2026

- Error yang direproduksi: SQLSTATE[HY000] [2002] pada beranda. Konfigurasi aplikasi masih port 3307, sedangkan MySQL Laragon yang aktif memakai port 3306.
- Database tujuan belum ada. Database sumber dicadangkan, kemudian diimpor ke database baru pada MySQL Laragon; checksum `t_user`, `t_anggota`, `t_kategori`, `t_buku`, dan `migrations` cocok seluruhnya. Data saat pemindahan: 2 akun, 1 anggota, 5 kategori, 20 buku. Data pengguna tidak direset.
- `.env` diubah ke port 3306 dan cache konfigurasi dibersihkan. Instance sementara port 3307 dihentikan setelah pemindahan.
- Helper startup kini memakai MySQL Laragon sesuai `.env`, memeriksa koneksi dan migration, serta memakai server proyek yang sudah berjalan. Seeder tidak dijalankan lagi setiap startup.
- Beranda kembali memberi HTTP 200, tanpa SQLSTATE, dan berhasil dimuat ulang pada browser pengguna. Petunjuk startup dan troubleshooting ada di README.

## Pemeriksaan implementasi awal

Tanggal pemeriksaan: 1 November 2026 (Asia/Jakarta).

## Pengujian otomatis

- `php artisan test --compact`: **37 passed, 296 assertions**, run akhir 12,17 detik.
- `npm run build`: berhasil; Vite 6.4.5 menghasilkan CSS dan JavaScript pada `public/build`.
- `php artisan view:cache`: semua template Blade berhasil dikompilasi.
- `composer validate --no-check-publish`: manifest dan lockfile valid.
- `php artisan migrate --seed`: berhasil pada MySQL 8.4.3 khusus proyek, port 3307. Menjalankan ulang seeder tidak menggandakan data.

PHPUnit menggunakan SQLite in-memory, storage palsu, dan mail palsu. Kasus meliputi akses role, login/rate limit, transaksi registrasi, duplikasi, validasi upload, cleanup saat rollback, KTM privat, persetujuan/penolakan, keputusan ganda, QR, kegagalan SMTP, empat template email, CRUD, larangan hapus kategori terpakai, stok, pencarian/filter/pagination (termasuk pencarian `0`), dashboard, serta seeder.

## Alur browser dengan database MySQL

1. Beranda memuat 20 judul dan 5 kategori.
2. Katalog: pencarian “Basis Data” dan kategori Teknologi Informasi menghasilkan satu buku yang sesuai. Halaman detail menampilkan stok 5 dan Rak A-03.
3. Pendaftaran melalui form dan upload dua gambar PNG bertuliskan DATA UJI QA berhasil. Akun langsung masuk dan menampilkan status menunggu verifikasi.
4. Logout dan login admin berhasil; dashboard menampilkan satu pendaftar pending. Kedua foto benar-benar termuat, termasuk KTM melalui endpoint admin.
5. Aksi Setuju menyimpan keputusan dan membuat kartu berisi foto, identitas, serta QR SVG pada akun mahasiswa.
6. Akun mahasiswa yang membuka endpoint KTM mendapat halaman 403.
7. Setelah logout, URL verifikasi dari kartu berhasil dibuka. Data yang terlihat hanya nama, NIM, prodi, angkatan, dan status; email/nomor HP/KTM tidak ditampilkan.
8. Menu seluler berhasil dibuka. Beranda diperiksa pada ukuran desktop 1365×900 dan mobile 390×844; lebar konten mobile tidak melampaui viewport. Tidak ada log error/warning browser pada pemeriksaan akhir.
9. Akun dan berkas QA dihapus setelah pengujian. Data akhir: 1 user admin, 0 anggota, 5 kategori, 20 buku.

Pratinjau tersimpan di `docs/screenshots`. Kartu pada gambar menggunakan identitas fiktif dan tokennya sudah tidak berlaku setelah cleanup.

## Batas verifikasi

- Email development benar-benar dirender ke log, bukan dikirim ke inbox. SMTP/Mailtrap memerlukan kredensial pengguna dan belum diuji langsung.
- Cetak menggunakan `window.print()` dan CSS print; printer fisik serta pemindaian QR dengan kamera ponsel belum diuji. URL QR dan hasil SVG sudah diperiksa.
- Belum dilakukan stress test atau pengujian request MySQL bersamaan. Penguncian keputusan memakai `lockForUpdate`; constraint database melindungi duplikasi dan kategori yang masih dipakai.
- Composer melaporkan 5 advisory pada Laravel 11.57.1. Versi ini dipertahankan sesuai permintaan untuk penggunaan lokal; lihat catatan keamanan dan rencana sebelum deployment pada README.
