<?php
$zip = new ZipArchive;
$file = 'vendor_laravel_inti.zip';
if ($zip->open($file) === TRUE) {
    if (!is_dir('./vendor')) {
        mkdir('./vendor', 0755, true);
    }
    // Karena isi zip adalah folder 'laravel', kita langsung ekstrak ke dalam 'vendor/'
    $zip->extractTo('./vendor/');
    $zip->close();
    echo '<h3>Berhasil mengekstrak jantung Laravel!</h3>';
} else {
    echo '<h3>Gagal mengekstrak, file vendor_laravel_inti.zip tidak ditemukan.</h3>';
}
?>
