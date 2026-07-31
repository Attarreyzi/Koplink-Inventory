# Koplink Inventory

Koplink Inventory adalah aplikasi web sederhana untuk manajemen stok barang dan transaksi yang dibangun menggunakan Laravel. 

Fokus utama aplikasi ini adalah untuk mencatat barang masuk, barang keluar, dan membuat laporan stok secara otomatis agar lebih gampang dipantau.

## Live Demo
Aplikasi bisa dicoba langsung lewat link ini:  
[https://koplink.infinityfree.me](https://koplink.infinityfree.me)

## Fitur
- Kelola Data Produk & Kategori
- Catat Transaksi Stok (Masuk & Keluar)
- Laporan Riwayat Stok
- Dashboard Admin
- Sistem Login

## Tech Stack
- Laravel
- MySQL
- Blade Templating

## Cara Setup di Lokal
Kalo mau jalanin project ini di komputer sendiri:
1. Clone repo ini
2. Buka terminal, jalanin `composer install`
3. Copy `.env.example` jadi `.env` trus sesuaikan config database-nya
4. Jalanin `php artisan key:generate`
5. Jalanin `php artisan migrate` buat bikin tabelnya
6. Terakhir, `php artisan serve`

---
Dibuat oleh [Attarreyzi](https://github.com/Attarreyzi)
