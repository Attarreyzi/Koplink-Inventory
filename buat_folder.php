<?php
echo "<h2>Memeriksa dan Membuat Folder Storage Laravel</h2>";

$directories = [
    __DIR__ . '/storage/framework/sessions',
    __DIR__ . '/storage/framework/views',
    __DIR__ . '/storage/framework/cache',
    __DIR__ . '/storage/logs',
    __DIR__ . '/bootstrap/cache',
];

$success = true;

echo "<ul>";
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "<li style='color:green;'>Berhasil membuat: " . str_replace(__DIR__, '', $dir) . "</li>";
        } else {
            echo "<li style='color:red;'>Gagal membuat: " . str_replace(__DIR__, '', $dir) . "</li>";
            $success = false;
        }
    } else {
        echo "<li style='color:blue;'>Sudah ada: " . str_replace(__DIR__, '', $dir) . "</li>";
    }
}
echo "</ul>";

if ($success) {
    echo "<h3 style='color:green;'>Selesai! Semua folder yang dibutuhkan untuk Login (Session) sudah siap.</h3>";
}

echo "<p><a href='/'>Klik di sini untuk mencoba Login kembali</a></p>";
?>
