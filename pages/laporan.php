<?php $title="Laporan Pembayaran"; 
include "./config/koneksi.php";
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Laporan Pembayaran</h4>
  <div class="d-flex gap-2">
    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
      <i class="bi bi-printer me-1"></i> Cetak
    </button>
  </div>
</div>

<?php
$q = mysqli_query($koneksi,"
  SELECT p.id_pembayaran, s.nisn, s.nama, k.nama_kelas, sp.tahun, 
         p.tgl_bayar, p.jumlah_bayar, pt.nama_petugas
  FROM pembayaran p
  JOIN siswa s   ON p.nisn = s.nisn
  JOIN kelas k   ON s.id_kelas = k.id_kelas
  JOIN spp sp    ON s.id_spp = sp.id_spp
  JOIN petugas pt ON p.id_petugas = pt.id_petugas
  ORDER BY p.tgl_bayar DESC
");
?>

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
        <?php $no=1; while($d=mysqli_fetch_assoc($q)): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $d['nisn'] ?></td>
          <td><?= htmlspecialchars($d['nama']) ?></td>
          <td><?= $d['nama_kelas'] ?></td>
          <td><?= $d['tahun'] ?></td>
          <td><?= date("d-m-Y", strtotime($d['tgl_bayar'])) ?></td>
          <td>Rp <?= number_format($d['jumlah_bayar'],0,',','.') ?></td>
          <td><?= htmlspecialchars($d['nama_petugas']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<style>
@media print {
  nav, aside, .btn, .breadcrumb { display:none !important; }
  main { width:100% !important; margin:0; padding:0; }
  table { font-size:12px; }
}
</style>