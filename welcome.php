<?php
session_start();

// Jika sudah login sebagai petugas/admin → ke dashboard admin
if (isset($_SESSION['id_petugas'])) {
  header("Location: index.php");
  exit;
}

// Jika sudah login sebagai siswa → ke dashboard siswa
if (isset($_SESSION['siswa_nisn'])) {
  header("Location: userindex.php");
  exit;
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Selamat Datang - Aplikasi SPP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h4 class="mb-3 text-center">Aplikasi Pembayaran SPP</h4>
          <p class="text-center text-secondary mb-4">Silakan pilih jenis akun untuk masuk</p>

          <div class="row g-3">
            <div class="col-md-6">
              <div class="border rounded p-4 h-100 text-center">
                <div class="mb-2"><i class="bi bi-shield-lock fs-1 text-primary"></i></div>
                <h6>Login Admin/Petugas</h6>
                <p class="small text-secondary">Kelola data siswa, kelas, SPP, dan transaksi</p>
                <a class="btn btn-primary w-100" href="login.php">Masuk sebagai Petugas</a>
                <div class="mt-2"><a class="small" href="register.php">Buat akun petugas</a></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="border rounded p-4 h-100 text-center">
                <div class="mb-2"><i class="bi bi-person fs-1 text-success"></i></div>
                <h6>Login Siswa</h6>
                <p class="small text-secondary">Lihat profil dan riwayat pembayaran Anda</p>
                <a class="btn btn-success w-100" href="userlogin.php">Masuk sebagai Siswa</a>
                <div class="mt-2"><a class="small" href="userregist.php">Buat akun siswa</a></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

