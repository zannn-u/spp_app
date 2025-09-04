<?php
// Hanya izinkan akses jika login sebagai petugas/admin
if (!isset($_SESSION['id_petugas'])) {
  header("Location: login.php");
  exit;
}