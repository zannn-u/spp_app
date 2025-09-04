<?php 
// Judul halaman
$title="Laporan Pembayaran"; 

// Koneksi database
include "./config/koneksi.php";
?>

<!-- ======================
 HEADER LAPORAN
====================== -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <!-- Judul -->
  <h4 class="mb-0">Laporan Pembayaran</h4>

  <!-- Tombol Cetak -->
  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
      <i class="bi bi-printer me-1"></i> Cetak
    </button>
  </div>
</div>

<?php
// ======================
// QUERY LAPORAN PEMBAYARAN
// ======================
// Ambil data pembayaran dengan join tabel:
// siswa, kelas, spp, dan petugas
$q = mysqli_query($koneksi,"
  SELECT p.id_pembayaran, s.nisn, s.nama, k.nama_kelas, sp.tahun, 
         p.tgl_bayar, p.jumlah_bayar, pt.nama_petugas
  FROM pembayaran p
  JOIN siswa s    ON p.nisn = s.nisn
  JOIN kelas k    ON s.id_kelas = k.id_kelas
  JOIN spp sp     ON s.id_spp = sp.id_spp
  JOIN petugas pt ON p.id_petugas = pt.id_petugas
  ORDER BY p.tgl_bayar DESC
");
?>

<!-- ======================
 TABEL LAPORAN PEMBAYARAN
====================== -->
<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-bordered table-striped datatable">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>NISN</th>
          <th>Nama</th>
          <th>Kelas</th>
          <th>Tahun SPP</th>
          <th>Tanggal Bayar</th>
          <th>Jumlah Bayar</th>
          <th>Petugas</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Inisialisasi nomor urut
        $no=1; 
        // Looping hasil query
        while($d=mysqli_fetch_assoc($q)): 
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $d['nisn'] ?></td>
          <!-- Gunakan htmlspecialchars untuk mencegah XSS -->
          <td><?= htmlspecialchars($d['nama']) ?></td>
          <td><?= $d['nama_kelas'] ?></td>
          <td><?= $d['tahun'] ?></td>
          <!-- Format tanggal dd-mm-yyyy -->
          <td><?= date("d-m-Y", strtotime($d['tgl_bayar'])) ?></td>
          <!-- Format rupiah -->
          <td>Rp <?= number_format($d['jumlah_bayar'],0,',','.') ?></td>
          <td><?= htmlspecialchars($d['nama_petugas']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ======================
 STYLE CETAK PRINT
====================== -->
<style>
@media print {
  /* Sembunyikan elemen navigasi, tombol, breadcrumb saat dicetak */
  nav, aside, .btn, .breadcrumb { 
    display:none !important; 
  }
  /* Maksimalkan area konten */
  main { 
    width:100% !important; 
    margin:0; 
    padding:0; 
  }
  /* Perkecil font tabel agar muat di kertas */
  table { 
    font-size:12px; 
  }
}
</style>
