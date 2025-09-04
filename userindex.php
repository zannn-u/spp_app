<?php
session_start();
if (!isset($_SESSION['siswa_nisn'])) {
  header("Location: userlogin.php");
  exit;
}

include "config/koneksi.php";
$nisn = mysqli_real_escape_string($koneksi, $_SESSION['siswa_nisn']);

$profil = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT s.nisn, s.nis, s.nama, k.nama_kelas, s.alamat, s.no_telp, sp.tahun, sp.nominal
  FROM siswa s
  LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
  LEFT JOIN spp sp ON s.id_spp = sp.id_spp
  WHERE s.nisn='$nisn'"));

$riwayat = mysqli_query($koneksi, "SELECT tgl_bayar, bulan_dibayar, tahun_dibayar, jumlah_bayar FROM pembayaran WHERE nisn='$nisn' ORDER BY tgl_bayar DESC");
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Halo, <?= htmlspecialchars($_SESSION['siswa_nama']) ?></h4>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-secondary btn-sm" href="userlogin.php">Ganti Akun</a>
      <a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="mb-3">Profil Siswa</h6>
          <div class="mb-1"><strong>NISN:</strong> <?= htmlspecialchars($profil['nisn'] ?? $nisn) ?></div>
          <div class="mb-1"><strong>NIS:</strong> <?= htmlspecialchars($profil['nis'] ?? '-') ?></div>
          <div class="mb-1"><strong>Nama:</strong> <?= htmlspecialchars($profil['nama'] ?? $_SESSION['siswa_nama']) ?></div>
          <div class="mb-1"><strong>Kelas:</strong> <?= htmlspecialchars($profil['nama_kelas'] ?? '-') ?></div>
          <div class="mb-1"><strong>Alamat:</strong> <?= htmlspecialchars($profil['alamat'] ?? '-') ?></div>
          <div class="mb-1"><strong>No Telp:</strong> <?= htmlspecialchars($profil['no_telp'] ?? '-') ?></div>
          <div class="mb-1"><strong>Tahun SPP:</strong> <?= htmlspecialchars($profil['tahun'] ?? '-') ?></div>
          <div class="mb-1"><strong>Nominal SPP:</strong> <?= isset($profil['nominal']) ? 'Rp '.number_format($profil['nominal'],0,',','.') : '-' ?></div>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="mb-3">Riwayat Pembayaran</h6>
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($riwayat && mysqli_num_rows($riwayat)>0): ?>
                  <?php while($r=mysqli_fetch_assoc($riwayat)): ?>
                  <tr>
                    <td><?= htmlspecialchars($r['tgl_bayar']) ?></td>
                    <td><?= htmlspecialchars($r['bulan_dibayar']) ?></td>
                    <td><?= htmlspecialchars($r['tahun_dibayar']) ?></td>
                    <td>Rp <?= number_format($r['jumlah_bayar'],0,',','.') ?></td>
                  </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr><td colspan="4" class="text-center text-muted">Belum ada pembayaran.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

