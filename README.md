# Koplink Inventory

Koplink Inventory adalah aplikasi berbasis web yang dirancang untuk mengelola stok barang dan mencatat transaksi harian. Aplikasi ini dibangun menggunakan framework Laravel dan basis data MySQL.

Fokus utama dari sistem ini adalah untuk mempermudah pencatatan barang masuk, barang keluar, serta menyajikan laporan stok secara terstruktur agar ketersediaan barang dapat dipantau dengan mudah.

## Live Demo & Preview
Aplikasi dapat diakses secara langsung melalui tautan berikut: [https://koplink.infinityfree.me](https://koplink.infinityfree.me) 
*(Portal ini tertutup khusus untuk Admin)*

▶️ **[Klik di sini untuk menonton Video Demo Aplikasi](https://drive.google.com/file/d/19Tg1hbOGqGVX6CK0ieuMk2qnSsHFp2-1/view?usp=drivesdk)**

## Fitur Utama
- Manajemen data produk dan kategori
- Pencatatan transaksi stok (masuk dan keluar)
- Laporan riwayat pergerakan stok otomatis
- Dashboard statistik untuk memantau data
- Sistem autentikasi admin

## Stack Teknologi
**Backend & Database:**
- Laravel (PHP Framework)
- MySQL

**Frontend & Interaksi:**
- Tailwind CSS
- Blade Templating (HTML)
- JavaScript

## Instalasi Lokal
Untuk menjalankan proyek ini di perangkat lokal, ikuti langkah-langkah berikut:

1. Salin (clone) repositori ini: `git clone https://github.com/Attarreyzi/Koplink-Inventory.git`
2. Buka terminal dan jalankan: `composer install`
3. Gandakan file `.env.example` menjadi `.env` dan sesuaikan pengaturan database.
4. Jalankan perintah: `php artisan key:generate`
5. Lakukan migrasi database: `php artisan migrate`
6. Jalankan server lokal: `php artisan serve`

Dikembangkan oleh [Attarreyzi](https://github.com/Attarreyzi)
