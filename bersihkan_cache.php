<?php
echo "<h2>Alat Pembersih Cache Laravel</h2>";

$files_to_delete = [
    __DIR__ . '/bootstrap/cache/packages.php',
    __DIR__ . '/bootstrap/cache/services.php',
    __DIR__ . '/bootstrap/cache/config.php',
    __DIR__ . '/bootstrap/cache/routes.php',
    __DIR__ . '/bootstrap/cache/events.php',
];

$all_cleared = true;

echo "<ul>";
foreach ($files_to_delete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "<li style='color:green;'>Berhasil menghapus: " . basename($file) . "</li>";
        } else {
            echo "<li style='color:red;'>Gagal menghapus: " . basename($file) . " (masalah hak akses)</li>";
            $all_cleared = false;
        }
    } else {
        echo "<li style='color:blue;'>Aman: " . basename($file) . " sudah tidak ada.</li>";
    }
}
echo "</ul>";

if ($all_cleared) {
    echo "<h3 style='color:green;'>Selesai! Semua cache lawas yang menyebabkan error PailServiceProvider sudah dibersihkan.</h3>";
}

echo "<p><a href='/'>Klik di sini untuk membuka Website Anda!</a></p>";
?>
