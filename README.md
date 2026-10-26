# Sistem Peminjaman Ruang Meeting PT Medquest Jaya Global

Sistem internal untuk mengajukan dan mengelola peminjaman ruang meeting kantor PT Medquest Jaya Global. Pengguna dapat mengirim agenda meeting dan memilih ruang yang tersedia, sementara admin mengelola ruang serta memproses pengajuan.


## Fitur

* Mengajukan peminjaman ruang meeting dengan agenda
* Memilih tanggal dan slot meeting per jam pada pukul 08.00-17.00; slot terpesan tidak dapat dipilih
* Mengelola ruang meeting dan status ketersediaannya
* Memproses, memverifikasi, membatalkan, dan menyelesaikan pengajuan
* Mengunduh laporan peminjaman berdasarkan rentang tanggal
* Antarmuka responsif untuk komputer dan ponsel


## Informasi Pendukung

Untuk instalasi baru, impor salah satu database di ***assets/db***. Kedua seed menyediakan lima ruang meeting dengan kapasitas 8, 12, 20, 30, dan 50 orang, tanpa akun demo. Buat akun Admin pertama melalui Adminer/HeidiSQL setelah membuat hash password menggunakan PHP:

```sh
php -r "echo password_hash('GANTI_DENGAN_PASSWORD_KUAT', PASSWORD_DEFAULT), PHP_EOL;"
```

Masukkan hash hasil perintah ke query berikut:

```sql
INSERT INTO tb_user (username, fullname, password, level)
VALUES ('admin', 'Administrator', 'TEMPEL_HASH_DI_SINI', 'Admin');
```

Untuk database `db_pinjamkelas` yang sudah terlanjur diimpor, jalankan `assets/db/setup_ruang_meeting.sql` melalui Adminer atau HeidiSQL. Skrip itu menambahkan kolom yang diperlukan dan katalog ruang serta mempertahankan data peminjaman dan akun pengguna.

Untuk penggunaan publik, gunakan HTTPS dan lingkungan hosting production. Dump SQL diblokir oleh `.htaccess`; jangan menaruh backup database di folder publik. Password lama akan dimigrasikan ke hash modern saat akun berhasil login, dan password untuk akun baru akan langsung di-hash.

Level akses aplikasi hanya terdiri dari dua pilihan: **Admin**, dengan akses pengelolaan akun, ruang, persetujuan, dan laporan; serta **Pengguna**, untuk melihat ruang dan mengajukan atau mengelola peminjaman sendiri.


## Tampilan Aplikasi

![Halaman Login](https://user-images.githubusercontent.com/76983038/104809591-0a01fe80-5821-11eb-9234-b142322e1b07.PNG)

![Halaman Beranda](https://user-images.githubusercontent.com/76983038/104809861-ffe0ff80-5822-11eb-9f66-6fd0d4f1614d.PNG)

![Kelola Akun Pengguna](https://user-images.githubusercontent.com/76983038/104810321-500d9100-5826-11eb-8ae4-62c783f36177.PNG)

![Kelola Data Ruangan](https://user-images.githubusercontent.com/76983038/104810359-92cf6900-5826-11eb-9935-b2fb17ec7038.PNG)

![Data Peminjaman](https://user-images.githubusercontent.com/76983038/104810381-b4305500-5826-11eb-977e-ea2e0360bc36.PNG)

![Ajukan Peminjaman](https://user-images.githubusercontent.com/76983038/104810395-cb6f4280-5826-11eb-9f22-f6549d021a3a.PNG)

![Riwayat Akses Ruanagan](https://user-images.githubusercontent.com/76983038/104810407-e2159980-5826-11eb-9d2d-37a2f0010292.PNG)


## Author

Ahmad Rivaldy S - [Kunjungi Situs](https://rivaldy.net)
