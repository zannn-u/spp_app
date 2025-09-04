<?php 
// Judul halaman
$title = "Dashboard";

// Memanggil file koneksi database
include "./config/koneksi.php";
?>

<!-- Bagian Header Dashboard -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <!-- Judul Halaman -->
  <h4 class="mb-0">Dashboard</h4>
  
  <!-- Breadcrumb navigasi -->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<!-- Bagian Konten Dashboard -->
<div class="row g-3">
  <?php
  // Query untuk menghitung jumlah siswa
  $c_siswa = mysqli_fetch_row(mysqli_query($koneksi,"SELECT COUNT(*) FROM siswa"))[0];
  
  // Query untuk menghitung jumlah transaksi pembayaran
  $c_bayar = mysqli_fetch_row(mysqli_query($koneksi,"SELECT COUNT(*) FROM pembayaran"))[0];
  
  // Query untuk menghitung total penerimaan (jumlah_bayar)
  // COALESCE digunakan agar jika hasilnya NULL diganti menjadi 0
  $sum_bayar = mysqli_fetch_row(mysqli_query($koneksi,"SELECT COALESCE(SUM(jumlah_bayar),0) FROM pembayaran"))[0];
  ?>

  <!-- Kartu Statistik: Total Siswa -->
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span class="text-secondary">Total Siswa</span>
          <i class="bi bi-people fs-4"></i> <!-- Ikon Bootstrap -->
        </div>
        <!-- Menampilkan jumlah siswa -->
        <div class="fs-3 fw-semibold"><?= $c_siswa ?></div>
      </div>
    </div>
  </div>

  <!-- Kartu Statistik: Total Transaksi -->
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span class="text-secondary">Transaksi</span>
          <i class="bi bi-receipt fs-4"></i> <!-- Ikon Bootstrap -->
        </div>
        <!-- Menampilkan jumlah transaksi -->
        <div class="fs-3 fw-semibold"><?= $c_bayar ?></div>
      </div>
    </div>
  </div>

  <!-- Kartu Statistik: Total Penerimaan -->
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span class="text-secondary">Total Penerimaan</span>
          <i class="bi bi-cash fs-4"></i> <!-- Ikon Bootstrap -->
        </div>
        <!-- Menampilkan total penerimaan dalam format Rupiah -->
        <div class="fs-3 fw-semibold">Rp <?= number_format($sum_bayar,0,',','.') ?></div>
      </div>
    </div>
  </div>

</div>
