<?php
echo "<h2>Alat Penampil Error Laravel</h2>";

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    echo "<h3 style='color:red;'>File .env tidak ditemukan di server!</h3>";
    echo "<p>Laravel butuh file .env untuk berjalan. Silakan copy file .env dari komputer Anda ke server.</p>";
} else {
    $content = file_get_contents($envFile);
    
    // Ubah APP_DEBUG menjadi true
    if (strpos($content, 'APP_DEBUG=false') !== false) {
        $content = str_replace('APP_DEBUG=false', 'APP_DEBUG=true', $content);
        file_put_contents($envFile, $content);
        echo "<h3 style='color:green;'>Berhasil menyalakan Mode Debug (APP_DEBUG=true)!</h3>";
    } else if (strpos($content, 'APP_DEBUG=true') !== false) {
        echo "<h3 style='color:blue;'>Mode Debug sudah menyala.</h3>";
    } else {
        $content .= "\nAPP_DEBUG=true\n";
        file_put_contents($envFile, $content);
        echo "<h3 style='color:green;'>Berhasil menambahkan APP_DEBUG=true ke .env!</h3>";
    }
    
    echo "<p><a href='/'>Klik di sini untuk melihat error aslinya</a></p>";
}
?>
