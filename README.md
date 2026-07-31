# Koplink Inventory

Koplink Inventory adalah aplikasi berbasis web yang dirancang untuk mengelola stok barang dan mencatat transaksi harian. Aplikasi ini dibangun menggunakan framework Laravel dan basis data MySQL.

Fokus utama dari sistem ini adalah untuk mempermudah pencatatan barang masuk, barang keluar, serta menyajikan laporan stok secara terstruktur agar ketersediaan barang dapat dipantau dengan mudah.

## Live Demo
Aplikasi dapat diakses secara langsung melalui tautan berikut:
[https://koplink.infinityfree.me](https://koplink.infinityfree.me)

## Fitur Utama
- Manajemen data produk dan kategori
- Pencatatan transaksi stok (masuk dan keluar)
- Laporan riwayat pergerakan stok otomatis
- Dashboard statistik untuk memantau data
- Sistem autentikasi admin

## Stack Teknologi
- Laravel
- MySQL
- Blade Templating

## Instalasi Lokal
Untuk menjalankan proyek ini di perangkat lokal, silakan ikuti langkah-langkah berikut:

1. Salin (clone) repositori ini: `git clone https://github.com/Attarreyzi/Koplink-Inventory.git`
2. Buka terminal dan jalankan: `composer install`
3. Gandakan file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda.
4. Jalankan perintah: `php artisan key:generate`
5. Lakukan migrasi database: `php artisan migrate`
6. Jalankan server lokal: `php artisan serve`

---
Dikembangkan oleh [Attarreyzi](https://github.com/Attarreyzi)
