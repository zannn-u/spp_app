<div class="container-fluid">
  <div class="row">
    <aside class="col-12 col-md-3 col-lg-2 bg-white border-end min-vh-100 p-0">
      <div class="list-group list-group-flush sticky-top" style="top:56px">
        <a class="list-group-item list-group-item-action" href="index.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a class="list-group-item list-group-item-action" href="index.php?page=siswa"><i class="bi bi-people me-2"></i>Siswa</a>
        <a class="list-group-item list-group-item-action" href="index.php?page=kelas"><i class="bi bi-building me-2"></i>Kelas</a>
        <a class="list-group-item list-group-item-action" href="index.php?page=spp"><i class="bi bi-wallet2 me-2"></i>SPP</a>
        <a class="list-group-item list-group-item-action" href="index.php?page=pembayaran"><i class="bi bi-receipt me-2"></i>Pembayaran</a>
        <?php if(($_SESSION['level'] ?? '') === 'admin'): ?>
          <a class="list-group-item list-group-item-action" href="index.php?page=petugas"><i class="bi bi-shield-lock me-2"></i>Petugas</a>
        <?php endif; ?>
        <a class="list-group-item list-group-item-action" href="index.php?page=laporan"><i class="bi bi-file-earmark-text me-2"></i>Laporan</a>
      </div>
    </aside>
    <main class="col-12 col-md-9 col-lg-10 p-4">