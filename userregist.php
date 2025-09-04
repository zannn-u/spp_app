<?php
include "config/koneksi.php";
$msg = '';

if (isset($_POST['register'])) {
  $nisn = trim($_POST['nisn']);
  $nama = trim($_POST['nama']);
  $pwd  = $_POST['password'];

  if ($nisn === '' || $nama === '' || $pwd === '') {
    $msg = '<div class="alert alert-warning">Semua field wajib diisi</div>';
  } else {
    mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS akun_siswa (
      nisn CHAR(10) PRIMARY KEY,
      nama VARCHAR(35) NOT NULL,
      password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    $cek = mysqli_query($koneksi, "SELECT 1 FROM akun_siswa WHERE nisn='".mysqli_real_escape_string($koneksi,$nisn)."'");
    if (mysqli_num_rows($cek)) {
      $msg = '<div class="alert alert-warning">NISN sudah terdaftar</div>';
    } else {
      $hash = password_hash($pwd, PASSWORD_DEFAULT);
      $ok = mysqli_query($koneksi, "INSERT INTO akun_siswa(nisn,nama,password) VALUES('".
        mysqli_real_escape_string($koneksi,$nisn)."','".
        mysqli_real_escape_string($koneksi,$nama)."','".$hash."')");
      $msg = $ok
        ? '<div class="alert alert-success">Registrasi berhasil. Silakan login.</div>'
        : '<div class="alert alert-danger">Registrasi gagal: '.mysqli_error($koneksi).'</div>';
    }
  }
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h5 class="mb-3">Register Siswa</h5>

          <?= $msg ?>

          <form method="post">
            <div class="mb-2">
              <label class="form-label">NISN</label>
              <input class="form-control" name="nisn" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Nama</label>
              <input class="form-control" name="nama" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="d-flex gap-2">
              <a href="userlogin.php" class="btn btn-outline-secondary">Kembali</a>
              <button class="btn btn-primary" name="register">Register</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
<?php
// Bagian: Koneksi
include "config/koneksi.php";

// Variabel pesan
$msg = '';

// Bagian: Proses form register siswa
if (isset($_POST['register'])) {
  $nisn = trim($_POST['nisn']);
  $nama = trim($_POST['nama']);
  $pwd  = $_POST['password'];

  // Validasi sederhana
  if ($nisn === '' || $nama === '' || $pwd === '') {
    $msg = '<div class="alert alert-warning">Semua field wajib diisi</div>';
  } else {
    // Pastikan tabel akun_siswa ada (untuk menyimpan kredensial siswa)
    mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS akun_siswa (
      nisn CHAR(10) PRIMARY KEY,
      nama VARCHAR(35) NOT NULL,
      password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

    // Cek NISN sudah terdaftar di akun_siswa
    $cek = mysqli_query($koneksi, "SELECT 1 FROM akun_siswa WHERE nisn='".mysqli_real_escape_string($koneksi,$nisn)."'");
    if (mysqli_num_rows($cek)) {
      $msg = '<div class="alert alert-warning">NISN sudah terdaftar</div>';
    } else {
      $hash = password_hash($pwd, PASSWORD_DEFAULT);
      $ok = mysqli_query($koneksi, "INSERT INTO akun_siswa(nisn,nama,password) VALUES('".
        mysqli_real_escape_string($koneksi,$nisn)."','".
        mysqli_real_escape_string($koneksi,$nama)."','".$hash."')");
      $msg = $ok
        ? '<div class="alert alert-success">Registrasi berhasil. Silakan login.</div>'
        : '<div class="alert alert-danger">Registrasi gagal: '.mysqli_error($koneksi).'</div>';
    }
  }
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h5 class="mb-3">Register Siswa</h5>

          <?= $msg ?>

          <form method="post">
            <div class="mb-2">
              <label class="form-label">NISN</label>
              <input class="form-control" name="nisn" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Nama</label>
              <input class="form-control" name="nama" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="d-flex gap-2">
              <a href="userlogin.php" class="btn btn-outline-secondary">Kembali</a>
              <button class="btn btn-primary" name="register">Register</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

