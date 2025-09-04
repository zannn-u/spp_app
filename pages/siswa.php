<?php 
// Batasi akses hanya untuk role tertentu
require_once __DIR__."/../core/role_only.php"; 
$title="Siswa";

// Koneksi database
include __DIR__."/../config/koneksi.php";

// Hapus data siswa (DELETE)
if (isset($_GET['hapus'])) {
    $nisn = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");
    header("Location: /spp_app/index.php?page=siswa&msg=hapus");
    exit;
}

// Tambah data siswa (CREATE)
if(isset($_POST['tambah'])) {
    $nisn     = $_POST['nisn'];
    $nis      = $_POST['nis'];
    $nama     = $_POST['nama'];
    $id_kelas = (int)$_POST['id_kelas'];
    $alamat   = $_POST['alamat'];
    $no_telp  = $_POST['no_telp'];
    $id_spp   = (int)$_POST['id_spp'];

    // Validasi foreign key kelas & spp
    $kelasExists = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(1) FROM kelas WHERE id_kelas=$id_kelas"))[0] ?? 0;
    $sppExists   = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(1) FROM spp WHERE id_spp=$id_spp"))[0] ?? 0;

    if (!$kelasExists) {
        header("Location: /spp_app/index.php?page=siswa&error=".rawurlencode('Kelas tidak ditemukan'));
        exit;
    }
    if (!$sppExists) {
        header("Location: /spp_app/index.php?page=siswa&error=".rawurlencode('SPP tidak ditemukan'));
        exit;
    }

    // Insert data ke tabel siswa
    $sql = "INSERT INTO siswa (nisn, nis, nama, id_kelas, alamat, no_telp, id_spp)
            VALUES('$nisn', '$nis', '$nama', '$id_kelas', '$alamat', '$no_telp', '$id_spp')";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: /spp_app/index.php?page=siswa&msg=tambah");
        exit;
    } else {
        $err = rawurlencode(mysqli_error($koneksi));
        header("Location: /spp_app/index.php?page=siswa&error=$err");
        exit;
    }
}
?>

<!-- Header halaman -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Siswa</h4>
  <a href="#formTambahSiswa" class="btn btn-primary btn-sm" onclick="document.getElementById('formTambahSiswa').scrollIntoView();return false;">
    <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
  </a>
</div>

<!-- Notifikasi sukses / error -->
<?php if(isset($_GET['msg']) && $_GET['msg']==='hapus'): ?>
<div class="alert alert-success py-2">Data terhapus.</div>
<?php endif; ?>
<?php if(isset($_GET['error'])): ?>
<div class="alert alert-danger py-2">Gagal menambah: <?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<!-- Form tambah siswa -->
<div class="card shadow-sm mb-3" id="formTambahSiswa">
  <div class="card-body">
    <form method="post">
      <div class="row g-2">
        <div class="col-md-3">
          <label class="form-label">NISN</label>
          <input type="text" class="form-control" name="nisn" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">NIS</label>
          <input type="text" class="form-control" name="nis" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Nama</label>
          <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Kelas</label>
          <select class="form-select" name="id_kelas" required>
            <option value="" disabled selected>Pilih Kelas</option>
            <?php 
            $kelas = mysqli_query($koneksi, "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas"); 
            while($k = mysqli_fetch_assoc($kelas)): ?>
              <option value="<?= $k['id_kelas'] ?>"><?= htmlspecialchars($k['nama_kelas']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Alamat</label>
          <input type="text" class="form-control" name="alamat" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">No Telp</label>
          <input type="text" class="form-control" name="no_telp" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">SPP</label>
          <select class="form-select" name="id_spp" required>
            <option value="" disabled selected>Pilih SPP</option>
            <?php 
            $spp = mysqli_query($koneksi, "SELECT id_spp, tahun, nominal FROM spp ORDER BY tahun DESC"); 
            while($s = mysqli_fetch_assoc($spp)): ?>
              <option value="<?= $s['id_spp'] ?>"><?= htmlspecialchars($s['tahun']).' - '.htmlspecialchars($s['nominal']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
      </div>
    </form>
  </div>
</div>

<!-- Tabel data siswa -->
<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped datatable">
      <thead>
        <tr>
          <th>NISN</th><th>NIS</th><th>Nama</th><th>ID Kelas</th>
          <th>Alamat</th><th>No Telp</th><th>ID SPP</th><th width="90">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $q = mysqli_query($koneksi, "SELECT * FROM siswa");
        while ($d = mysqli_fetch_assoc($q)):
        ?>
        <tr>
          <td><?= htmlspecialchars($d['nisn']) ?></td>
          <td><?= htmlspecialchars($d['nis']) ?></td>
          <td><?= htmlspecialchars($d['nama']) ?></td>
          <td><?= htmlspecialchars($d['id_kelas']) ?></td>
          <td><?= htmlspecialchars($d['alamat']) ?></td>
          <td><?= htmlspecialchars($d['no_telp']) ?></td>
          <td><?= htmlspecialchars($d['id_spp']) ?></td>
          <td>
            <a class="btn btn-sm btn-outline-danger" 
               href="/spp_app/index.php?page=siswa&hapus=<?= urlencode($d['nisn']) ?>" 
               onclick="return confirm('Hapus data ini?')">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
