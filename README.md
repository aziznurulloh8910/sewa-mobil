# Project: Implementasi TOPSIS pada Data Aset dengan Laravel 11

## Pendahuluan
Proyek ini adalah implementasi dari metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution) untuk evaluasi data aset menggunakan framework Laravel 11. TOPSIS adalah metode pengambilan keputusan yang digunakan untuk memilih alternatif terbaik dari sejumlah alternatif berdasarkan kedekatannya dengan solusi ideal positif dan menjauhnya dari solusi ideal negatif.

## Instalasi

1. **Persyaratan Sistem**
   - PHP >= 8.1
   - Composer
   - Database (MySQL, PostgreSQL, dll.)

2. **Langkah Instalasi**

   - Clone repositori ini:
     ```bash
     https://github.com/aziznurulloh8910/inventarisasi-aset.git
     cd laravel-topsis
     ```

   - Instal dependensi menggunakan Composer:
     ```bash
     composer install
     ```

   - Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda:
     ```bash
     cp .env.example .env
     ```

   - Generate application key:
     ```bash
     php artisan key:generate
     ```

   - Migrasi dan seed database:
     ```bash
     php artisan migrate --seed
     ```

   - Jalankan server pengembangan:
     ```bash
     php artisan serve
     ```

   - Buka aplikasi di browser pada `http://localhost:8000`.

## Struktur Proyek

- `app/Http/Controllers/AssetController.php` - Kontroler untuk manajemen aset dan perhitungan TOPSIS.
- `app/Models/Asset.php` - Model untuk entitas Aset.
- `database/migrations/` - File migrasi untuk membuat tabel aset.
- `database/seeders/AssetSeeder.php` - Seeder untuk mengisi data awal aset.
- `resources/views/` - Templat blade untuk tampilan.

## Implementasi TOPSIS

1. **Pengumpulan Data**
   - Data aset dikumpulkan dan disimpan dalam database.

2. **Normalisasi Matriks Keputusan**
   - Matriks keputusan dinormalisasi untuk mengubah nilai atribut menjadi skala yang sebanding.

3. **Pembobotan Kriteria**
   - Setiap kriteria diberi bobot berdasarkan tingkat kepentingannya.

4. **Matriks Keputusan Ternormalisasi Terbobot**
   - Matriks keputusan ternormalisasi dikalikan dengan bobot kriteria.

5. **Menentukan Solusi Ideal Positif dan Negatif**
   - Solusi ideal positif (A+) dan solusi ideal negatif (A-) ditentukan berdasarkan nilai maksimal dan minimal dari setiap kriteria.

6. **Menghitung Jarak terhadap Solusi Ideal Positif dan Negatif**
   - Jarak setiap alternatif terhadap A+ dan A- dihitung menggunakan formula Euclidean.

7. **Menghitung Nilai Preferensi**
   - Nilai preferensi dihitung untuk setiap alternatif berdasarkan jaraknya dari A+ dan A-.

8. **Peringkat Alternatif**
   - Alternatif diurutkan berdasarkan nilai preferensi untuk menentukan peringkat terbaik.

## Penjelasan Singkat TOPSIS

TOPSIS (Technique for Order Preference by Similarity to Ideal Solution) adalah metode pengambilan keputusan multikriteria yang didasarkan pada konsep bahwa alternatif terbaik adalah yang memiliki jarak terpendek dari solusi ideal positif dan jarak terjauh dari solusi ideal negatif. Langkah-langkah utama dalam TOPSIS meliputi normalisasi matriks keputusan, pembobotan kriteria, menentukan solusi ideal, dan menghitung jarak serta nilai preferensi untuk setiap alternatif.

## Kontak
Jika Anda memiliki pertanyaan atau memerlukan bantuan, silakan hubungi kami di [aziznurulloh8@gmail.com].

## Lisensi
Proyek ini dilisensikan di bawah MIT License - lihat file LICENSE.md untuk detail lebih lanjut.
