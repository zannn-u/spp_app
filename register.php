<?php
include "config/koneksi.php";
$msg = '';
if (isset($_POST['register'])) {
  $u = $_POST['username'];
  $cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT 1 FROM petugas WHERE username='$u'"));
  if ($cek) { $msg = '<div class="alert alert-warning">Username sudah dipakai</div>'; }
  else {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama_petugas']; $level = $_POST['level'];
    $ok = mysqli_query($koneksi,"INSERT INTO petugas(username,password,nama_petugas,level)
             VALUES('$u','$hash','$nama','$level')");
    $msg = $ok ? '<div class="alert alert-success">Register berhasil. Silakan login.</div>'
               : '<div class="alert alert-danger">Register gagal: '.mysqli_error($koneksi).'</div>';
  }
}
?>
<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register Petugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light d-flex align-items-center" style="min-height:100vh">
<div class="container"><div class="row justify-content-center"><div class="col-md-5">
<div class="card shadow-sm"><div class="card-body p-4">
  <h5 class="mb-3">Register Petugas/Admin</h5>
  <?= $msg ?>
  <form method="post">
    <div class="mb-2"><label class="form-label">Username</label><input class="form-control" name="username" required></div>
    <div class="mb-2"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
    <div class="mb-2"><label class="form-label">Nama Petugas</label><input class="form-control" name="nama_petugas" required></div>
    <div class="mb-3"><label class="form-label">Level</label>
      <select class="form-select" name="level" required>
        <option value="admin">Admin</option>
        <option value="petugas">Petugas</option>
      </select>
    </div>
    <div class="d-flex gap-2">
      <a href="login.php" class="btn btn-outline-secondary">Kembali</a>
      <button class="btn btn-primary" name="register">Register</button>
    </div>
  </form>
</div></div></div></div></div>
</body></html>