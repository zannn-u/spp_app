<?php 
// Batasi akses berdasarkan role
require_once __DIR__."/../core/role_only.php"; 
$title="SPP";

// Koneksi database
include __DIR__."/../config/koneksi.php";

// Hapus data SPP (DELETE)
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id'");
    header("Location: /spp_app/index.php?page=spp&msg=hapus");
    exit;
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM spp WHERE id_spp='$id'"));
}

// Tambah data SPP (CREATE)
if (isset($_POST['tambah'])) {
    $tahun   = $_POST['tahun'];
    $nominal = $_POST['nominal'];
    $sql = "INSERT INTO spp (tahun,nominal) VALUES('$tahun','$nominal')";
    mysqli_query($koneksi, $sql);
    header("Location: /spp_app/index.php?page=spp&msg=tambah");
    exit;
}

// Update data SPP (UPDATE)
if (isset($_POST['update'])) {
    $id = intval($_POST['id_spp']);
    $tahun   = $_POST['tahun'];
    $nominal = $_POST['nominal'];
    $sql = "UPDATE spp SET tahun='".$tahun."', nominal='".$nominal."' WHERE id_spp='".$id."'";
    mysqli_query($koneksi, $sql);
    header("Location: /spp_app/index.php?page=spp&msg=update");
    exit;
}
?>

<!-- Header halaman -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data SPP</h4>
  <?php if(!isset($_GET['edit'])): ?>
  <a href="#formTambahSpp" class="btn btn-primary btn-sm" onclick="document.getElementById('formTambahSpp').scrollIntoView();return false;">
    <i class="bi bi-plus-lg me-1"></i>Tambah SPP
  </a>
  <?php endif; ?>
</div>

<!-- Notifikasi sukses -->
<?php if(isset($_GET['msg']) && $_GET['msg']==='hapus'): ?>
<div class="alert alert-success py-2">Data terhapus.</div>
<?php endif; ?>

<?php if(isset($_GET['edit'])) { ?>
<div class="card shadow-sm mb-3">
  <div class="card-body">
    <form method="post">
      <input type="hidden" name="id_spp" value="<?= (int)$data_edit['id_spp'] ?>">
      <div class="row g-2">
        <div class="col-md-6">
          <label class="form-label">Tahun</label>
          <input type="number" class="form-control" name="tahun" value="<?= htmlspecialchars($data_edit['tahun']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nominal</label>
          <input type="number" class="form-control" name="nominal" value="<?= htmlspecialchars($data_edit['nominal']) ?>" required>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a class="btn btn-outline-secondary" href="/spp_app/index.php?page=spp">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php } else { ?>
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
<?php } ?>

<!-- Tabel data SPP -->
<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped datatable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tahun</th>
          <th>Nominal</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
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
            <a class="btn btn-sm btn-outline-primary" href="/spp_app/index.php?page=spp&edit=<?= $d['id_spp'] ?>">
              <i class="bi bi-pencil"></i>
            </a>
            <a class="btn btn-sm btn-outline-danger" href="/spp_app/index.php?page=spp&hapus=<?= $d['id_spp'] ?>" onclick="return confirm('Hapus data ini?')">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
