<!-- Bagian: Navbar utama -->
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container-fluid">

    <!-- Bagian: Branding / Logo Aplikasi -->
    <a class="navbar-brand fw-semibold" href="index.php">
      <i class="bi bi-cash-coin me-1"></i> SPP App
    </a>

    <!-- Bagian: Info User + Tombol Logout (kanan) -->
    <div class="d-flex align-items-center gap-3 ms-auto">
      
      <!-- Bagian: Tampilkan nama & level user dari session -->
      <span class="text-secondary small">
        <?= $_SESSION['nama_petugas'] ?? '-' ?> (<?= $_SESSION['level'] ?? '-' ?>)
      </span>

      <!-- Bagian: Tombol Logout -->
      <a class="btn btn-outline-danger btn-sm" href="logout.php">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </a>
    </div>

  </div>
</nav>
