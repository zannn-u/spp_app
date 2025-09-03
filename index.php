<?php
session_start();
require "core/auth_check.php";
$title = "Dashboard";
include "layouts/head.php";
include "layouts/navbar.php";
include "layouts/sidebar.php";

$page = $_GET['page'] ?? 'dashboard';
$allowed = ['dashboard','siswa','kelas','spp','pembayaran','petugas','laporan'];
if (!in_array($page,$allowed)) $page = 'dashboard';
include "pages/$page.php";

include "layouts/footer.php";