<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Harus login sebagai petugas/admin
if (!isset($_SESSION['id_petugas'])) {
  header("Location: /spp_app/login.php");
  exit;
}

// Hanya izinkan level admin atau petugas
$level = $_SESSION['level'] ?? '';
if (!in_array($level, ['admin','petugas'], true)) {
  http_response_code(403);
  die('<div class="p-5 text-center">Akses ditolak (khusus admin/petugas)</div>');
}
?>
