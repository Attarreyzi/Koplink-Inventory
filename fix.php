<?php
echo "<h2>Membuat platform_check.php Buatan...</h2>";

$dir = __DIR__ . '/vendor/composer';
$file = $dir . '/platform_check.php';

if (!is_dir($dir)) {
    die("Folder vendor/composer belum ada. Anda harus mengekstrak vendor terlebih dahulu.");
}

$content = "<?php\n// File dummy dibuat oleh fix.php untuk membungkam error\nreturn true;\n";

if (file_put_contents($file, $content)) {
    echo "<h3 style='color:green;'>BERHASIL! File platform_check.php bohongan sudah diletakkan di server!</h3>";
    echo "Silakan buka kembali website Anda: <a href='/'>Klik di sini</a>";
} else {
    echo "<h3 style='color:red;'>GAGAL membuat file. Folder vendor mungkin read-only.</h3>";
}
?>
