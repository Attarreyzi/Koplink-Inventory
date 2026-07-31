<?php
echo "<h2>Alat Diagnostik Vendor Server (V2)</h2>";

$target = __DIR__ . '/vendor/symfony/deprecation-contracts/function.php';

if (file_exists($target)) {
    echo "<h3 style='color:green;'>FILE BENAR ADA DI: $target</h3>";
} else {
    echo "<h3 style='color:red;'>FILE TETAP TIDAK ADA DI: $target</h3>";
    
    // Mari kita cek apa yang ada di dalam htdocs/vendor/
    $vendor_dir = __DIR__ . '/vendor/';
    echo "<h4>Isi folder vendor/ :</h4><ul>";
    if (is_dir($vendor_dir)) {
        $files = scandir($vendor_dir);
        foreach ($files as $f) {
            echo "<li>$f</li>";
        }
    } else {
        echo "<li style='color:red;'>Folder vendor/ tidak ada!</li>";
    }
    echo "</ul>";
    
    // Mari kita cek apa yang ada di dalam htdocs/
    $htdocs_dir = __DIR__ . '/';
    echo "<h4>Isi folder htdocs/ :</h4><ul>";
    if (is_dir($htdocs_dir)) {
        $files = scandir($htdocs_dir);
        foreach ($files as $f) {
            if ($f === 'vendor' || $f === 'vendor_super.zip' || $f === 'ekstrak_aman.php') {
                echo "<li><b>$f</b></li>";
            }
        }
    }
    echo "</ul>";
}
?>
