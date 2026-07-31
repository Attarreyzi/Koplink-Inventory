<?php
echo "<h2>Pengecekan Database Laravel</h2>";

$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $content = file_get_contents($envFile);
    
    preg_match('/DB_HOST=(.*)/', $content, $m_host);
    preg_match('/DB_DATABASE=(.*)/', $content, $m_db);
    preg_match('/DB_USERNAME=(.*)/', $content, $m_user);
    preg_match('/DB_PASSWORD=(.*)/', $content, $m_pass);
    
    $host = trim($m_host[1]);
    $db = trim($m_db[1]);
    $user = trim($m_user[1]);
    $pass = trim($m_pass[1]);
    
    echo "Mencoba koneksi ke database <b>$db</b> dengan user <b>$user</b>...<br><br>";
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<h3 style='color:green;'>✅ Koneksi Database BERHASIL!</h3>";
        
        // Check if sessions table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'sessions'");
        if ($stmt->rowCount() > 0) {
            echo "<h3 style='color:green;'>✅ Tabel 'sessions' ADA di database!</h3>";
        } else {
            echo "<h3 style='color:red;'>❌ Gawat! Tabel 'sessions' TIDAK ADA!</h3>";
            echo "<p>Pantas saja Anda kena 419! Anda belum meng-import (mengunggah) file <b>koplink_db.sql</b> ke dalam PhpMyAdmin di akun InfinityFree Anda.</p>";
        }
        
    } catch (PDOException $e) {
        echo "<h3 style='color:red;'>❌ Koneksi Database GAGAL!</h3>";
        echo "Error: " . $e->getMessage() . "<br>";
        echo "<p>Artinya pengaturan DB_PASSWORD atau DB_USERNAME di .env salah, atau Anda belum membuat databasenya di Control Panel.</p>";
    }
    
} else {
    echo "File .env tidak ditemukan.";
}
?>
