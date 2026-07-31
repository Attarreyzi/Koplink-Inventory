<?php
echo "<h2>Alat Ekstrak Vendor Anti-Gagal (V4 - Perbaikan Format Windows)</h2>";

// 1. Hapus semua file sampah dengan backslash di folder vendor
$vendor_dir = __DIR__ . '/vendor/';
if (is_dir($vendor_dir)) {
    $files = scandir($vendor_dir);
    $deleted = 0;
    foreach ($files as $f) {
        if (strpos($f, '\\') !== false) {
            unlink($vendor_dir . $f);
            $deleted++;
        }
    }
    echo "Dibersihkan $deleted file dengan format nama Windows yang salah.<br>";
}

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (file_exists($file)) {
        echo "Sedang mengekstrak <b>$file</b> dengan sistem perbaikan nama... Mohon tunggu.<br>";
        
        $zip = new ZipArchive;
        if ($zip->open($file) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $stat = $zip->statIndex($i);
                $oldName = $stat['name'];
                
                // Ubah backslash Windows (\) menjadi forward slash Linux (/)
                $newName = str_replace('\\', '/', $oldName);
                
                // Lewati jika ini hanya root folder vendor/
                if ($newName === 'vendor/' || $newName === 'vendor') continue;
                
                // Karena root zip sudah mengandung "vendor/", kita ekstrak ke direktori saat ini (__DIR__)
                $targetPath = __DIR__ . '/' . $newName;
                
                // Buat foldernya jika belum ada
                $dir = dirname($targetPath);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                
                // Jika ini bukan folder, ekstrak filenya
                if (substr($newName, -1) !== '/') {
                    $content = $zip->getFromIndex($i);
                    file_put_contents($targetPath, $content);
                }
            }
            $zip->close();
            
            echo "<h3 style='color:green;'>Berhasil mengekstrak 100% isi $file dengan format Linux yang benar!</h3>";
            echo "<a href='ekstrak_aman.php'>Kembali ke Menu</a>";
        } else {
            echo "<h3 style='color:red;'>Gagal membuka $file.</h3>";
        }
    }
    exit;
}

$zips = glob('vendor_*.zip');
if (empty($zips)) {
    echo "<b>Tidak ada file vendor_*.zip.</b>";
} else {
    echo "<ul>";
    foreach ($zips as $zipFile) {
        echo "<li style='margin-bottom:10px;'>$zipFile <a href='ekstrak_aman.php?file=$zipFile' style='padding:5px 10px; background:blue; color:white; text-decoration:none;'>Ekstrak Ini</a></li>";
    }
    echo "</ul>";
}
?>
