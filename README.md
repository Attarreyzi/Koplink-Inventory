# 📦 Koplink Inventory System

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

Koplink Inventory adalah aplikasi manajemen stok dan transaksi berbasis web yang dikembangkan menggunakan framework **Laravel**. Aplikasi ini dirancang untuk mempermudah pencatatan stok masuk, stok keluar, dan penyusunan laporan inventaris secara rapi.

## 🌐 Live Demo
Anda dapat melihat dan mencoba aplikasi ini secara langsung melalui tautan berikut:  
👉 **[https://koplink.infinityfree.me](https://koplink.infinityfree.me)**

## ✨ Fitur Utama
- **Manajemen Produk & Kategori:** Pendataan barang secara terstruktur.
- **Transaksi Stok:** Pencatatan aktivitas stok barang masuk dan keluar dengan akurat.
- **Laporan (Report):** Menghasilkan laporan pergerakan stok barang secara rinci untuk pemantauan ketersediaan barang.
- **Dashboard Admin:** Tampilan ringkasan statistik yang mudah dipahami.
- **Keamanan:** Sistem login (autentikasi) untuk membatasi akses hanya kepada admin.

## 💻 Teknologi yang Digunakan
- **Backend:** Laravel (PHP)
- **Frontend:** Blade Templating, HTML, CSS
- **Database:** MySQL

## 🛠️ Cara Menjalankan Secara Lokal
Jika Anda ingin menjalankan aplikasi ini di komputer Anda sendiri:
1. *Clone* repositori ini: `git clone https://github.com/Attarreyzi/Koplink-Inventory.git`
2. Masuk ke folder: `cd Koplink-Inventory`
3. Install dependensi: `composer install`
4. Sesuaikan file `.env` (copy dari `.env.example`)
5. Generate key: `php artisan key:generate`
6. Jalankan database: `php artisan migrate`
7. Mulai server: `php artisan serve`

---
*Dikembangkan oleh [Attarreyzi](https://github.com/Attarreyzi)*
