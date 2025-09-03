<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-semibold" href="index.php">
      <i class="bi bi-cash-coin me-1"></i> SPP App
    </a>
    <div class="d-flex align-items-center gap-3 ms-auto">
      <span class="text-secondary small">
        <?= $_SESSION['nama_petugas'] ?? '-' ?> (<?= $_SESSION['level'] ?? '-' ?>)
      </span>
      <a class="btn btn-outline-danger btn-sm" href="logout.php">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </a>
    </div>
  </div>
</nav>