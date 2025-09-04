<?php session_start(); ?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Siswa - SPP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h5 class="mb-3 text-center">Login Siswa</h5>

          <?php if(isset($_SESSION['error_user'])): ?>
            <div class="alert alert-danger py-2">
              <?= $_SESSION['error_user']; unset($_SESSION['error_user']); ?>
            </div>
          <?php endif; ?>

          <form method="post" action="proses_login.php">
            <div class="mb-3">
              <label class="form-label">NISN</label>
              <input class="form-control" name="nisn" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary w-100" name="login_user">Login</button>
          </form>

          <div class="text-center mt-3">
            <a href="userregist.php" class="small">Buat akun siswa</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

