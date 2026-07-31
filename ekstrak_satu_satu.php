<?php
echo "<h2>Alat Ekstrak Aman (Satu per Satu)</h2>";

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (file_exists($file)) {
        echo "Sedang mengekstrak <b>$file</b>... Mohon tunggu jangan di-refresh/tutup...<br><br>";
        
        $zip = new ZipArchive;
        if ($zip->open($file) === TRUE) {
            $zip->extractTo('./');
            $zip->close();
            echo "<h3 style='color:green;'>✅ Berhasil mengekstrak $file!</h3>";
        } else {
            echo "<h3 style='color:red;'>❌ Gagal mengekstrak $file.</h3>";
        }
        echo "<a href='ekstrak_satu_satu.php' style='padding:10px; background:#ddd; text-decoration:none;'>Kembali ke Menu</a>";
    }
    exit;
}

$zips = glob('*.zip');
if (empty($zips)) {
    echo "<b>Tidak ada file .zip di folder ini.</b>";
} else {
    echo "<ul>";
    foreach ($zips as $zipFile) {
        echo "<li style='margin-bottom:15px; font-size:18px;'>$zipFile <br><br> <a href='ekstrak_satu_satu.php?file=$zipFile' style='padding:8px 15px; background:blue; color:white; text-decoration:none; border-radius:5px;'>Ekstrak File Ini</a></li>";
    }
    echo "</ul>";
}
?>
