<?php
echo "<h2>Alat Keamanan Website (Matikan Mode Debug & Hapus File Sementara)</h2>";

$envFile = __DIR__ . '/../.env';

if (file_exists($envFile)) {
    $content = file_get_contents($envFile);
    
    // Ganti APP_DEBUG=true menjadi APP_DEBUG=false
    if (strpos($content, 'APP_DEBUG=true') !== false) {
        $content = str_replace('APP_DEBUG=true', 'APP_DEBUG=false', $content);
        file_put_contents($envFile, $content);
        echo "<h3 style='color:green;'>1. Mode Debug BERHASIL dimatikan! (Sangat penting agar hacker tidak bisa melihat error database Anda).</h3>";
    } else {
        echo "<h3 style='color:blue;'>1. Mode Debug sudah dalam keadaan mati (Aman).</h3>";
    }
} else {
    echo "<h3 style='color:red;'>File .env tidak ditemukan.</h3>";
}

// Hapus file-file setting yang tadi kita buat agar tidak disalahgunakan orang
$files_to_delete = [
    __DIR__ . '/seting_database.php',
    __DIR__ . '/../ekstrak_aman.php',
    __DIR__ . '/../cek_vendor.php',
    __DIR__ . '/../nyalakan_debug.php',
    __DIR__ . '/../bersihkan_cache.php',
    __DIR__ . '/../perbaiki_url.php',
    __DIR__ . '/amankan_website.php' // Hapus diri sendiri terakhir
];

echo "<h4>2. Membersihkan alat-alat bantu sementara:</h4><ul>";
foreach ($files_to_delete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "<li style='color:green;'>Berhasil menghapus: " . basename($file) . "</li>";
        } else {
            echo "<li style='color:orange;'>Gagal menghapus otomatis: " . basename($file) . " (Silakan hapus manual nanti)</li>";
        }
    }
}
echo "</ul>";

echo "<h3>Keamanan website Anda kini sudah berada di standar Produksi (Aman)!</h3>";
?>
