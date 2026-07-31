<?php
echo "<h2>Alat Penghubung Database Otomatis (Versi Public)</h2>";

// Karena file ini sekarang ada di folder public/, maka .env ada di satu folder di atasnya (../)
$envFile = __DIR__ . '/../.env';

if (!file_exists($envFile)) {
    echo "<h3 style='color:red;'>File .env tidak ditemukan di server! Tolong pastikan Anda sudah mengupload file .env ke folder paling luar (htdocs).</h3>";
} else {
    $content = file_get_contents($envFile);
    
    // Ganti DB_DATABASE
    $content = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=if0_42347781_koplink_db', $content);
    
    // Ganti DB_USERNAME
    $content = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=if0_42347781', $content);
    
    // Ganti DB_HOST
    $content = preg_replace('/DB_HOST=.*/', 'DB_HOST=sql104.infinityfree.com', $content);
    
    // Ganti DB_PASSWORD (jika mereka belum isi, kita setidaknya biarkan kosong atau beritahu)
    // Ingat: User harusnya memasukkan password vPanel mereka di .env
    
    // Simpan perubahan
    file_put_contents($envFile, $content);
    
    echo "<h3 style='color:green;'>Berhasil memperbarui file .env! Nama database sudah diganti menjadi if0_42347781_koplink_db</h3>";
    
    // Bersihkan cache config lagi untuk berjaga-jaga
    $cacheFile = __DIR__ . '/../bootstrap/cache/config.php';
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
        echo "<p>Cache pengaturan lama berhasil dihapus.</p>";
    }
    
    echo "<p><b>PENTING:</b> Pastikan Anda sudah mengisi <b>DB_PASSWORD</b> di dalam file .env dengan password V-Panel InfinityFree Anda.</p>";
    echo "<p><a href='/login'>Klik di sini untuk mencoba Login kembali!</a></p>";
}
?>
