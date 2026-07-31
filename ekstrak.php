<?php
$zip = new ZipArchive;
$files = glob('*.zip');
foreach($files as $file) {
  if ($zip->open($file) === TRUE) {
    // Jika namanya diawali 'vendor_', ekstrak ke dalam folder vendor/
    if (strpos($file, 'vendor_') === 0) {
      if (!is_dir('./vendor')) {
        mkdir('./vendor', 0755, true);
      }
      $zip->extractTo('./vendor/');
    } else {
      $zip->extractTo('./');
    }
    $zip->close();
    echo 'Berhasil mengekstrak: ' . $file . '<br>';
  } else {
    echo 'Gagal mengekstrak: ' . $file . '<br>';
  }
}
echo '<h1>Semua proses selesai!</h1>';
?>
