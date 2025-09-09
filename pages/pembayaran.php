<?php 
// Batasi akses admin/petugas
require_once __DIR__."/../core/role_admin_or_petugas.php"; 

// Judul halaman
$title="Pembayaran";

// Koneksi database
include __DIR__."/../config/koneksi.php";


// ======================
// PROSES DELETE DATA
// ======================
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = mysqli_prepare($koneksi, "DELETE FROM pembayaran WHERE id_pembayaran=?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: /spp_app/index.php?page=pembayaran&msg=hapus");
    exit;
}


// ======================
// PROSES AMBIL DATA UNTUK EDIT
// ======================
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = mysqli_prepare($koneksi, "SELECT id_pembayaran, id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar FROM pembayaran WHERE id_pembayaran=?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $data_edit = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}


// ======================
// PROSES CREATE (TAMBAH) - Menggunakan Stored Procedure
// ======================
if (isset($_POST['tambah'])) {
    $id_petugas = (int)$_POST['id_petugas'];
    $nisn       = $_POST['nisn'];
    $tgl_bayar  = $_POST['tgl_bayar'];
    $bulan      = $_POST['bulan'];
    $tahun      = $_POST['tahun'];
    $id_spp     = (int)$_POST['id_spp'];
    $jumlah     = (int)$_POST['jumlah'];

    $stmt = mysqli_prepare($koneksi, "CALL tambah_pembayaran(?, ?, ?, ?, ?, ?, ?, @pesan_hasil)");
    mysqli_stmt_bind_param($stmt, 'issssii', $id_petugas, $nisn, $tgl_bayar, $bulan, $tahun, $id_spp, $jumlah);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $result = mysqli_query($koneksi, "SELECT @pesan_hasil AS pesan");
    $pesan = mysqli_fetch_assoc($result)['pesan'];
    
    if (strpos($pesan, 'Success') !== false) {
        header("Location: /spp_app/index.php?page=pembayaran&msg=tambah");
    } else {
        $err = rawurlencode($pesan);
        header("Location: /spp_app/index.php?page=pembayaran&error=$err");
    }
    exit;
}


// ======================
// PROSES UPDATE
// ======================
if (isset($_POST['update'])) {
    $id        = (int)$_POST['id_pembayaran'];
    $id_petugas= (int)$_POST['id_petugas'];
    $nisn      = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $bulan     = $_POST['bulan'];
    $tahun     = $_POST['tahun'];
    $id_spp    = (int)$_POST['id_spp'];
    $jumlah    = (int)$_POST['jumlah'];

    // Update dilakukan seperti biasa, triggers akan menangani validasi setelahnya
    $stmt = mysqli_prepare($koneksi, "UPDATE pembayaran SET id_petugas=?, nisn=?, tgl_bayar=?, bulan_dibayar=?, tahun_dibayar=?, id_spp=?, jumlah_bayar=? WHERE id_pembayaran=?");
    mysqli_stmt_bind_param($stmt, 'issssiii', $id_petugas, $nisn, $tgl_bayar, $bulan, $tahun, $id_spp, $jumlah, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: /spp_app/index.php?page=pembayaran&msg=update");
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Pembayaran</h4>
  <?php if (!isset($_GET['edit'])): ?>
  <a href="#formTambahPembayaran" class="btn btn-primary btn-sm" 
     onclick="document.getElementById('formTambahPembayaran').scrollIntoView();return false;">
     <i class="bi bi-plus-lg me-1"></i>Tambah Pembayaran
  </a>
  <?php endif; ?>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg']==='hapus'): ?>
<div class="alert alert-success py-2">Data terhapus.</div>
<?php endif; ?>
<?php if(isset($_GET['msg']) && $_GET['msg']==='tambah'): ?>
<div class="alert alert-success py-2">Pembayaran berhasil ditambahkan.</div>
<?php endif; ?>
<?php if(isset($_GET['msg']) && $_GET['msg']==='update'): ?>
<div class="alert alert-success py-2">Data berhasil diupdate.</div>
<?php endif; ?>
<?php if(isset($_GET['error'])): ?>
<div class="alert alert-danger py-2">Gagal menambah: <?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>


<?php if (isset($_GET['edit'])) { ?>
  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id_pembayaran" value="<?php echo $data_edit['id_pembayaran']; ?>">
        <div class="row g-2">
          <div class="col-md-3"><label class="form-label">ID Petugas</label><input type="number" class="form-control" name="id_petugas" value="<?php echo $data_edit['id_petugas']; ?>" required></div>
          <div class="col-md-3"><label class="form-label">NISN</label><input type="text" class="form-control" name="nisn" value="<?php echo $data_edit['nisn']; ?>" required></div>
          <div class="col-md-3"><label class="form-label">Tanggal Bayar</label><input type="date" class="form-control" name="tgl_bayar" value="<?php echo $data_edit['tgl_bayar']; ?>" required></div>
          <div class="col-md-3"><label class="form-label">Bulan Dibayar</label><input type="text" class="form-control" name="bulan" value="<?php echo $data_edit['bulan_dibayar']; ?>" required></div>
          <div class="col-md-3"><label class="form-label">Tahun Dibayar</label><input type="text" class="form-control" name="tahun" value="<?php echo $data_edit['tahun_dibayar']; ?>" required></div>
          <div class="col-md-3"><label class="form-label">ID SPP</label><input type="number" class="form-control" name="id_spp" value="<?php echo $data_edit['id_spp']; ?>" required></div>
          <div class="col-md-3"><label class="form-label">Jumlah Bayar</label><input type="number" class="form-control" name="jumlah" value="<?php echo $data_edit['jumlah_bayar']; ?>" required></div>
        </div>
        <div class="mt-3">
          <button type="submit" name="update" class="btn btn-primary">Update</button>
          <a class="btn btn-outline-secondary" href="/spp_app/index.php?page=pembayaran">Batal</a>
        </div>
      </form>
    </div>
  </div>

<?php } else { ?>
  <div class="card shadow-sm mb-3" id="formTambahPembayaran">
    <div class="card-body">
      <form method="post">
        <div class="row g-2">
          <div class="col-md-3">
            <label class="form-label">Petugas</label>
            <select class="form-select" name="id_petugas" required>
              <option value="" disabled selected>Pilih Petugas</option>
              <?php 
              $pet = mysqli_query($koneksi, "SELECT id_petugas, nama_petugas FROM petugas ORDER BY nama_petugas"); 
              while($p = mysqli_fetch_assoc($pet)): ?>
                <option value="<?= $p['id_petugas'] ?>"><?= htmlspecialchars($p['nama_petugas']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">NISN</label>
            <select class="form-select" name="nisn" required>
              <option value="" disabled selected>Pilih Siswa (NISN)</option>
              <?php 
              $sis = mysqli_query($koneksi, "SELECT nisn, nama FROM siswa ORDER BY nama"); 
              while($s = mysqli_fetch_assoc($sis)): ?>
                <option value="<?= $s['nisn'] ?>"><?= htmlspecialchars($s['nisn']).' - '.htmlspecialchars($s['nama']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-3"><label class="form-label">Tanggal Bayar</label><input type="date" class="form-control" name="tgl_bayar" required></div>
          <div class="col-md-3"><label class="form-label">Bulan Dibayar</label><input type="text" class="form-control" name="bulan" required></div>
          <div class="col-md-3"><label class="form-label">Tahun Dibayar</label><input type="text" class="form-control" name="tahun" required></div>
          <div class="col-md-3">
            <label class="form-label">SPP</label>
            <select class="form-select" name="id_spp" required>
              <option value="" disabled selected>Pilih SPP</option>
              <?php 
              $spp = mysqli_query($koneksi, "SELECT id_spp, tahun, nominal FROM spp ORDER BY tahun DESC"); 
              while($sp = mysqli_fetch_assoc($spp)): ?>
                <option value="<?= $sp['id_spp'] ?>"><?= htmlspecialchars($sp['tahun']).' - '.htmlspecialchars($sp['nominal']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-3"><label class="form-label">Jumlah Bayar</label><input type="number" class="form-control" name="jumlah" required></div>
        </div>
        <div class="mt-3">
          <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
<?php } ?>


<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped datatable">
      <thead>
        <tr>
          <th>ID</th>
          <th>ID Petugas</th>
          <th>NISN</th>
          <th>Tanggal Bayar</th>
          <th>Bulan</th>
          <th>Tahun</th>
          <th>ID SPP</th>
          <th>Jumlah</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
      // Ambil semua data pembayaran
      $q = mysqli_query($koneksi, "SELECT * FROM pembayaran");
      while ($d = mysqli_fetch_assoc($q)):
      ?>
        <tr>
          <td><?= $d['id_pembayaran'] ?></td>
          <td><?= htmlspecialchars($d['id_petugas']) ?></td>
          <td><?= htmlspecialchars($d['nisn']) ?></td>
          <td><?= htmlspecialchars($d['tgl_bayar']) ?></td>
          <td><?= htmlspecialchars($d['bulan_dibayar']) ?></td>
          <td><?= htmlspecialchars($d['tahun_dibayar']) ?></td>
          <td><?= htmlspecialchars($d['id_spp']) ?></td>
          <td><?= htmlspecialchars($d['jumlah_bayar']) ?></td>
          <td>
            <a class="btn btn-sm btn-outline-primary" href="/spp_app/index.php?page=pembayaran&edit=<?= $d['id_pembayaran'] ?>"><i class="bi bi-pencil"></i></a>
            <a class="btn btn-sm btn-outline-danger" href="/spp_app/index.php?page=pembayaran&hapus=<?= $d['id_pembayaran'] ?>" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>