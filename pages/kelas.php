<?php require_once __DIR__."/../core/role_only.php"; $title="Kelas";
include __DIR__."/../config/koneksi.php";

// DELETE (before output)
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id'");
    header("Location: /spp_app/index.php?page=kelas&msg=hapus");
    exit;
}

// CREATE
if (isset($_POST['tambah'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi = $_POST['kompetensi_keahlian'];
    $sql = "INSERT INTO kelas (nama_kelas,kompetensi_keahlian) VALUES('$nama_kelas','$kompetensi')";
    mysqli_query($koneksi, $sql);
    header("Location: /spp_app/index.php?page=kelas&msg=tambah");
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Kelas</h4>
  <a href="#formTambahKelas" class="btn btn-primary btn-sm" onclick="document.getElementById('formTambahKelas').scrollIntoView();return false;"><i class="bi bi-plus-lg me-1"></i>Tambah Kelas</a>
</div>
<?php if(isset($_GET['msg']) && $_GET['msg']==='hapus'): ?>
<div class="alert alert-success py-2">Data terhapus.</div>
<?php endif; ?>

<div class="card shadow-sm mb-3" id="formTambahKelas">
  <div class="card-body">
    <form method="post">
      <div class="row g-2">
        <div class="col-md-6">
          <label class="form-label">Nama Kelas</label>
          <input type="text" class="form-control" name="nama_kelas" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kompetensi</label>
          <input type="text" class="form-control" name="kompetensi_keahlian" required>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped datatable">
      <thead><tr><th>ID</th><th>Nama Kelas</th><th>Kompetensi</th><th width="90">Aksi</th></tr></thead>
      <tbody>
      <?php
      $q = mysqli_query($koneksi, "SELECT * FROM kelas");
      while ($d = mysqli_fetch_assoc($q)):
      ?>
        <tr>
          <td><?= $d['id_kelas'] ?></td>
          <td><?= htmlspecialchars($d['nama_kelas']) ?></td>
          <td><?= htmlspecialchars($d['kompetensi_keahlian']) ?></td>
          <td>
            <a class="btn btn-sm btn-outline-danger" href="/spp_app/index.php?page=kelas&hapus=<?= $d['id_kelas'] ?>" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>