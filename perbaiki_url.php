<?php
echo "<h2>Alat Perbaikan URL/Routing Server</h2>";

$root_htaccess = __DIR__ . '/.htaccess';
$root_content = "<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>";

$public_htaccess = __DIR__ . '/public/.htaccess';
$public_content = "<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>";

$success = true;

if (file_put_contents($root_htaccess, $root_content)) {
    echo "<p style='color:green;'>Berhasil membuat file .htaccess di folder utama (root).</p>";
} else {
    echo "<p style='color:red;'>Gagal membuat .htaccess di root!</p>";
    $success = false;
}

if (!is_dir(__DIR__ . '/public')) {
    mkdir(__DIR__ . '/public', 0755, true);
}

if (file_put_contents($public_htaccess, $public_content)) {
    echo "<p style='color:green;'>Berhasil membuat file .htaccess di folder public/.</p>";
} else {
    echo "<p style='color:red;'>Gagal membuat .htaccess di folder public!</p>";
    $success = false;
}

if ($success) {
    echo "<h3>Selesai! Sistem routing URL sudah diperbaiki.</h3>";
    echo "<p><a href='/'>Klik di sini untuk mencoba Website Anda lagi!</a></p>";
}
?>
