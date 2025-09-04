<?php
// Bagian: Memulai sesi
session_start();

// Bagian: Cek autentikasi pengguna (hanya petugas/admin)
require "core/auth_check.php";

// Bagian: Judul halaman
$title = "Dashboard";

// Bagian: Layout utama (header, navbar, sidebar)
include "layouts/head.php";
include "layouts/navbar.php";
include "layouts/sidebar.php";

// Bagian: Routing halaman berdasarkan parameter "page"
$page = $_GET['page'] ?? 'dashboard'; // default dashboard
$allowed = ['dashboard','siswa','kelas','spp','pembayaran','petugas','laporan'];

// Jika "page" tidak ada di daftar allowed → kembalikan ke dashboard
if (!in_array($page,$allowed)) $page = 'dashboard';

// Bagian: Memuat isi halaman sesuai parameter "page"
include "pages/$page.php";

// Bagian: Footer layout
include "layouts/footer.php";
