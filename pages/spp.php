<?php require_once __DIR__."/../core/role_only.php"; $title="SPP";
include __DIR__."/../config/koneksi.php";

// DELETE (before output)
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id'");
    header("Location: /spp_app/index.php?page=spp&msg=hapus");
    exit;
}

// CREATE
if (isset($_POST['tambah'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];
    $sql = "INSERT INTO spp (tahun,nominal) VALUES('$tahun','$nominal')";
    mysqli_query($koneksi, $sql);
    header("Location: /spp_app/index.php?page=spp&msg=tambah");
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data SPP</h4>
  <a href="#formTambahSpp" class="btn btn-primary btn-sm" onclick="document.getElementById('formTambahSpp').scrollIntoView();return false;"><i class="bi bi-plus-lg me-1"></i>Tambah SPP</a>
</div>
<?php if(isset($_GET['msg']) && $_GET['msg']==='hapus'): ?>
<div class="alert alert-success py-2">Data terhapus.</div>
<?php endif; ?>

<div class="card shadow-sm mb-3" id="formTambahSpp">
  <div class="card-body">
    <form method="post">
      <div class="row g-2">
        <div class="col-md-6">
          <label class="form-label">Tahun</label>
          <input type="number" class="form-control" name="tahun" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nominal</label>
          <input type="number" class="form-control" name="nominal" required>
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
      <thead><tr><th>ID</th><th>Tahun</th><th>Nominal</th><th width="90">Aksi</th></tr></thead>
      <tbody>
      <?php
      $q = mysqli_query($koneksi, "SELECT * FROM spp");
      while ($d = mysqli_fetch_assoc($q)):
      ?>
        <tr>
          <td><?= $d['id_spp'] ?></td>
          <td><?= htmlspecialchars($d['tahun']) ?></td>
          <td><?= htmlspecialchars($d['nominal']) ?></td>
          <td>
            <a class="btn btn-sm btn-outline-danger" href="/spp_app/index.php?page=spp&hapus=<?= $d['id_spp'] ?>" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>