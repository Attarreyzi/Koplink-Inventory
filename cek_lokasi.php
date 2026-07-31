<?php
echo "<b>Diagnostic Script</b><br><br>";

echo "Current Directory (__DIR__): " . __DIR__ . "<br>";

$uploads_dir = __DIR__ . '/uploads/products';
if (is_dir($uploads_dir)) {
    echo "Folder 'uploads/products' EXISTS in current directory.<br>";
    $files = scandir($uploads_dir);
    echo "Files inside:<br>";
    foreach($files as $f) {
        if ($f != '.' && $f != '..') {
            echo "- " . $f . "<br>";
        }
    }
} else {
    echo "Folder 'uploads/products' DOES NOT exist in current directory.<br>";
}

echo "<br>";

$public_uploads_dir = __DIR__ . '/public/uploads/products';
if (is_dir($public_uploads_dir)) {
    echo "Folder 'public/uploads/products' EXISTS.<br>";
    $files = scandir($public_uploads_dir);
    echo "Files inside:<br>";
    foreach($files as $f) {
        if ($f != '.' && $f != '..') {
            echo "- " . $f . "<br>";
        }
    }
} else {
    echo "Folder 'public/uploads/products' DOES NOT exist.<br>";
}
