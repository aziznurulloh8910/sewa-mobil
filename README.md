# Aplikasi Persewaan Mobil

## Deskripsi Proyek
Proyek ini adalah aplikasi persewaan mobil yang dibangun menggunakan Laravel. Aplikasi ini dirancang untuk memudahkan manajemen persewaan mobil, memungkinkan pengguna untuk mendaftar, menambah mobil, memesan, dan mengembalikan mobil dengan mudah. Proyek ini dibuat sebagai bagian dari tahap rekrutmen di PT Jasamedika.

## Instalasi

### Prasyarat
- Pastikan Anda memiliki [PHP](https://www.php.net/downloads) dan [Composer](https://getcomposer.org/download/) terinstal di sistem Anda.
- Instal library yang diperlukan dengan menjalankan:

  ```bash
  composer install
  ```

### Langkah Instalasi
1. Clone repositori ini:

   ```bash
   git clone https://github.com/username/repo-name.git
   ```
2. Masuk ke direktori proyek:

   ```bash
   cd repo-name
   ```
3. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi yang diperlukan.
4. Generate application key:

   ```bash
   php artisan key:generate
   ```

5. Jalankan migrasi database:
   
   ```bash
   php artisan migrate
   ```
  
8. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

## Konfigurasi
- Konfigurasi database dapat dilakukan di file `.env`.
- Pastikan untuk menyesuaikan pengaturan seperti nama database, pengguna, dan kata sandi sesuai kebutuhan Anda.

## Fitur Utama

1. **Registrasi Pengguna**
   - Pengguna dapat mendaftar dengan informasi pribadi.
   - Data pengguna disimpan dan dapat diakses kembali.

2. **Manajemen Mobil**
   - Tambah mobil baru dengan detail lengkap.
   - Cari mobil berdasarkan merek, model, atau ketersediaan.
   - Lihat daftar mobil yang tersedia.

3. **Peminjaman Mobil**
   - Pesan mobil dengan memilih tanggal dan mobil yang tersedia.
   - Verifikasi ketersediaan mobil.
   - Lihat daftar mobil yang sedang disewa.

4. **Pengembalian Mobil**
   - Kembalikan mobil dengan memasukkan nomor plat.
   - Verifikasi penyewaan dan hitung biaya sewa.

5. **Keluar Aplikasi**
   - Pengguna dapat keluar dan login kembali di lain waktu.

## Petunjuk Penggunaan
- Ikuti antarmuka pengguna yang intuitif untuk navigasi dan penggunaan aplikasi.
- Gunakan manajemen kesalahan untuk menangani situasi seperti mobil yang tidak tersedia.
