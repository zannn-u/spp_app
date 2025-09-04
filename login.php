<?php session_start(); ?> 

<!doctype html>
<html lang="id">
<head>
  <!-- Bagian: Meta dan Bootstrap -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - SPP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <!-- Bagian: Card Login -->
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h5 class="mb-3 text-center">Login Aplikasi SPP</h5>

          <!-- Bagian: Tampilkan pesan error (jika ada) -->
          <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger py-2">
              <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
          <?php endif; ?>

          <!-- Bagian: Form Login -->
          <form method="post" action="proses_login.php">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input class="form-control" name="username" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary w-100" name="login">Login</button>
          </form>

          <!-- Bagian: Link Register -->
          <div class="text-center mt-3 d-flex justify-content-between">
            <a href="register.php" class="small">Buat akun petugas</a>
            <span class="text-secondary small">|</span>
            <a href="userlogin.php" class="small">Login siswa</a>
            <span class="text-secondary small">/</span>
            <a href="userregist.php" class="small">Register siswa</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
