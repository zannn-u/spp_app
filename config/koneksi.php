<?php
// Muat environment
$envPath = __DIR__.'/.env';
if (!file_exists($envPath)) {
    // Fallback ke nilai default lokal
    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = 'db_spp';
} else {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(ltrim($line), '#') === 0) continue;
        $pos = strpos($line, '=');
        if ($pos === false) continue;
        $key = trim(substr($line, 0, $pos));
        $val = trim(substr($line, $pos + 1));
        $env[$key] = $val;
    }
    $DB_HOST = $env['DB_HOST'] ?? 'localhost';
    $DB_USER = $env['DB_USER'] ?? 'root';
    $DB_PASS = $env['DB_PASS'] ?? '';
    $DB_NAME = $env['DB_NAME'] ?? 'db_spp';
}

$koneksi = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$koneksi) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}
?>