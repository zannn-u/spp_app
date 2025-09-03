<?php $title="Dashboard";
include "./config/koneksi.php"
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Dashboard</h4>
  <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0"><li class="breadcrumb-item active">Dashboard</li></ol></nav>
</div>
<div class="row g-3">
  <?php
  $c_siswa = mysqli_fetch_row(mysqli_query($koneksi,"SELECT COUNT(*) FROM siswa"))[0];
  $c_bayar = mysqli_fetch_row(mysqli_query($koneksi,"SELECT COUNT(*) FROM pembayaran"))[0];
  $sum_bayar = mysqli_fetch_row(mysqli_query($koneksi,"SELECT COALESCE(SUM(jumlah_bayar),0) FROM pembayaran"))[0];
  ?>
  <div class="col-md-4"><div class="card shadow-sm"><div class="card-body">
    <div class="d-flex justify-content-between"><span class="text-secondary">Total Siswa</span><i class="bi bi-people fs-4"></i></div>
    <div class="fs-3 fw-semibold"><?= $c_siswa ?></div>
  </div></div></div>
  <div class="col-md-4"><div class="card shadow-sm"><div class="card-body">
    <div class="d-flex justify-content-between"><span class="text-secondary">Transaksi</span><i class="bi bi-receipt fs-4"></i></div>
    <div class="fs-3 fw-semibold"><?= $c_bayar ?></div>
  </div></div></div>
  <div class="col-md-4"><div class="card shadow-sm"><div class="card-body">
    <div class="d-flex justify-content-between"><span class="text-secondary">Total Penerimaan</span><i class="bi bi-cash fs-4"></i></div>
    <div class="fs-3 fw-semibold">Rp <?= number_format($sum_bayar,0,',','.') ?></div>
  </div></div></div>
</div>