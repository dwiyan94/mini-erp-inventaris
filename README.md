# Mini ERP Inventaris - PT. Syailendra Bumi Investama (DDistillers)

Aplikasi simulasi manajemen inventaris berbasis web yang dirancang untuk mengelola katalog produk, memantau pergerakan stok masuk dan keluar secara *real-time*, melacak riwayat mutasi (*traceability*), serta menyajikan ringkasan valuasi inventaris secara komprehensif.

---

## 👨‍💻 Informasi Pengembang
* **Nama Kandidat**: Dwiyan Primastia Saputra
* **Program Studi**: S1 Teknik Informatika, Universitas Amikom Yogyakarta
* **Waktu Pengerjaan**: 15 Oktober 2026

---

## 🛠️ Tech Stack & Arsitektur
* **Backend Framework**: Laravel 13 (PHP 8.3+)
* **Database**: PostgreSQL (dengan dukungan transaksi aman & `TRUNCATE CASCADE`)
* **Frontend UI Theme**: Inspinia Admin Theme v2.7 (Bootstrap, jQuery, SweetAlert, Toastr)
* **Manajemen Akses**: Spatie Laravel-Permission (Role-Based Access Control)
* **Keamanan Sesi**: *Custom Middleware* `CheckSingleSession` (Pencegahan login multi-perangkat)

---

## 🚀 Fitur Utama & Kesesuaian Modul
1. **Modul A (Login & Role Management)**:
   - Autentikasi aman dengan enkripsi password ketat (8+ karakter, kombinasi huruf besar/kecil, angka, dan simbol).
   - Pembatasan akses berbasis peran (*admin*, *gudang*, *manager*) dengan perlindungan rute (*middleware*).
   - Fitur keamanan *Single-Session* untuk memastikan satu akun hanya aktif pada satu perangkat dalam satu waktu.
2. **Modul B (Katalog & SKU)**:
   - Integrasi data awal produk otomatis dari API `https://dummyjson.com/products` menggunakan `Http::withoutVerifying()`.
   - SKU unik, kategori, satuan, harga referensi (dikonversi ke Rupiah), dan manajemen foto produk lokal (`public/uploads/products/items/`).
   - Fitur *Soft Deletes* dengan arsip pembersihan otomatis ke folder `deleted/` dan fitur *Reset Demo* instan via PostgreSQL `TRUNCATE TABLE products RESTART IDENTITY CASCADE;`.
3. **Modul C (Mutasi Stok Masuk & Keluar)**:
   - Pencatatan barang masuk (*In*) dan keluar (*Out*) lengkap dengan jumlah dan catatan/memo.
   - **Aturan Kunci Keamanan**: Barang keluar divalidasi ketat agar tidak melebihi stok tersedia. Kuantitas wajib berupa bilangan bulat positif (menolak angka nol, negatif, dan desimal).
   - Perlindungan *Race Condition* menggunakan `DB::beginTransaction()` dan `Product::lockForUpdate()`.
4. **Modul D (Riwayat & Traceability)**:
   - Tabel pelacakan mutasi terpusat yang mencatat waktu, SKU/nama barang, jenis mutasi, jumlah, perubahan stok (sebelum & sesudah), foto bukti, catatan, serta petugas yang bertugas.
   - Dilengkapi filter rentang tanggal dinamis dan pencarian kata kunci.
5. **Modul E (Ringkasan Inventaris)**:
   - Dasbor metrik komprehensif: Total SKU aktif, Akumulasi Stok Fisik di gudang, Indikator Peringatan Stok Menipis (`< 5`), serta Kalkulasi Total Estimasi Nilai Persediaan.

---

## 🔑 Akun Demo
Sistem dilengkapi dengan akun simulasi bawaan untuk pengujian hak akses:
* **Admin**: `admin@syailendra.test` / `Password123`
* **Gudang**: `gudang@syailendra.test` / `Password123`
* **Manager**: `manager@syailendra.test` / `Password123`

---

## ⚙️ Cara Menjalankan Aplikasi & Pengujian

1. **Clone / Salin Proyek**:
   Letakkan folder proyek di dalam direktori server lokal Anda (misal: XAMPP/Laragon).

2. **Konfigurasi Lingkungan (`.env`)**:
   Salin file `.env.example` menjadi `.env`, lalu sesuaikan koneksi database PostgreSQL Anda:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=erp_corp
   DB_USERNAME=postgres
   DB_PASSWORD=password_anda

3. **Instalasi Dependensi & Migrasi**:
   Jalankan perintah berikut melalui terminal di root direktori proyek:
   ```env
   composer install
   php artisan key:generate
   php artisan migrate --seed

4. **Menjalankan Server Lokal**:
   ```env
   php artisan serve

   Akses aplikasi via browser di: http://127.0.0.1:8000

5. **Menjalankan Unit Test**:
   Untuk memverifikasi keunikan SKU, batas stok keluar, dan perhitungan valuasi inventaris secara otomatis:
   ```env
   php artisan test

---

## 🤖 Catatan Penggunaan AI & Penanganan Kekeliruan

Bagaimana AI Digunakan:
   Asisten AI dimanfaatkan sebagai mitra kolaboratif dalam merancang struktur logika database transaction lock, menyusun query filter tanggal pada riwayat mutasi, serta membangun validasi sisi client dan server untuk mencegah input desimal/negatif.

Proses Verifikasi:
   Seluruh kode yang dihasilkan diuji secara langsung melalui pengujian manual di antarmuka web serta eksekusi Unit Test Laravel untuk memastikan tidak ada celah keamanan atau bug pada perhitungan mutasi stok.

Contoh Kekeliruan & Penanganannya:

Kekeliruan: Pada saat awal pengujian Unit Test menggunakan SQLite in-memory, terjadi error active transaction conflict akibat penggunaan trait RefreshDatabase bersamaan dengan transaksi manual berbasis lockForUpdate().

Penanganan: Mengganti trait RefreshDatabase menjadi DatabaseMigrations pada kelas tes agar manajemen migrasi dan pengujian isolasi data berjalan selaras tanpa konflik nested transaction.

---