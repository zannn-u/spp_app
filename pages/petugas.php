<?php require_once __DIR__."/../core/role_only.php"; $title="Petugas";
include __DIR__."/../config/koneksi.php";

// Ensure soft-delete column exists
$colCheck = mysqli_query($koneksi, "SHOW COLUMNS FROM petugas LIKE 'aktif'");
if ($colCheck && mysqli_num_rows($colCheck) === 0) {
  @mysqli_query($koneksi, "ALTER TABLE petugas ADD COLUMN aktif TINYINT(1) NOT NULL DEFAULT 1");
}

// Soft delete (process before any HTML output)
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $deleteResult = mysqli_query($koneksi, "UPDATE petugas SET aktif=0 WHERE id_petugas=$id");
  if ($deleteResult) {
    header("Location: /spp_app/index.php?page=petugas&msg=hapus");
    exit;
  } else {
    // If column didn't exist and migration failed silently, try to add then retry once
    @mysqli_query($koneksi, "ALTER TABLE petugas ADD COLUMN aktif TINYINT(1) NOT NULL DEFAULT 1");
    $retry = mysqli_query($koneksi, "UPDATE petugas SET aktif=0 WHERE id_petugas=$id");
    if ($retry) {
      header("Location: /spp_app/index.php?page=petugas&msg=hapus");
      exit;
    }
    $err = rawurlencode(mysqli_error($koneksi));
    header("Location: /spp_app/index.php?page=petugas&error=$err");
    exit;
  }
}
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Petugas</h4>
  <a href="register.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Petugas</a>
</div>

<?php
if (isset($_GET['edit'])) {
  $id = intval ($_GET['edit']);
  $rows = mysqli_query($koneksi, "SELECT * FROM petugas WHERE id_petugas=$id");
}
// Only show active staff
$rows = mysqli_query($koneksi,"SELECT * FROM petugas WHERE aktif=1 ORDER BY id_petugas DESC");
?>
<?php if(isset($_GET['msg']) && $_GET['msg']==='hapus'): ?>
<div class="alert alert-success py-2">Data terhapus.</div>
<?php endif; ?>
<?php if(isset($_GET['error'])): ?>
<div class="alert alert-danger py-2">Gagal menghapus: <?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>
<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped datatable">
      <thead><tr><th>ID</th><th>Username</th><th>Nama</th><th>Level</th><th width="120">Aksi</th></tr></thead>
      <tbody>
      <?php while($d=mysqli_fetch_assoc($rows)): ?>
        <tr>
          <td><?= $d['id_petugas'] ?></td>
          <td><?= htmlspecialchars($d['username']) ?></td>
          <td><?= htmlspecialchars($d['nama_petugas']) ?></td>
          <td><span class="badge bg-secondary"><?= $d['level'] ?></span></td>
          <td>
            <a class="btn btn-sm btn-outline-primary" href="/spp_app/index.php?page=petugas&edit=<?= $d['id_petugas'] ?>"><i class="bi bi-pencil"></i></a>
            <a class="btn btn-sm btn-outline-danger" href="/spp_app/index.php?page=petugas&hapus=<?= $d['id_petugas'] ?>" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if(isset($_GET['edit'])):
  $id=(int)$_GET['edit']; $e=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM petugas WHERE id_petugas=$id"));
  if(isset($_POST['save'])){
    $u=$_POST['username']; $nama=$_POST['nama_petugas']; $level=$_POST['level'];
    if($_POST['password']!==''){
      $pass=password_hash($_POST['password'], PASSWORD_DEFAULT);
      mysqli_query($koneksi,"UPDATE petugas SET username='$u', nama_petugas='$nama', level='$level', password='$pass' WHERE id_petugas=$id");
    }else{
      mysqli_query($koneksi,"UPDATE petugas SET username='$u', nama_petugas='$nama', level='$level' WHERE id_petugas=$id");
    }
    echo "<script>location='/spp_app/index.php?page=petugas'</script>"; exit;
  }
?>
<div class="offcanvas offcanvas-end show" tabindex="-1" style="visibility:visible; background:white; width:380px; border-left:1px solid #e5e7eb">
  <div class="offcanvas-header">
    <h5>Edit Petugas</h5>
    <a href="/spp_app/index.php?page=petugas" class="btn-close"></a>
  </div>
  <div class="offcanvas-body">
    <form method="post">
      <div class="mb-2"><label class="form-label">Username</label><input class="form-control" name="username" value="<?= htmlspecialchars($e['username']) ?>" required></div>
      <div class="mb-2"><label class="form-label">Password Baru (opsional)</label><input type="password" class="form-control" name="password"></div>
      <div class="mb-2"><label class="form-label">Nama</label><input class="form-control" name="nama_petugas" value="<?= htmlspecialchars($e['nama_petugas']) ?>" required></div>
      <div class="mb-3"><label class="form-label">Level</label>
        <select class="form-select" name="level" required>
          <option value="admin"   <?= $e['level']=='admin'?'selected':'';?>>Admin</option>
          <option value="petugas" <?= $e['level']=='petugas'?'selected':'';?>>Petugas</option>
        </select>
      </div>
      <button class="btn btn-primary" name="save">Simpan</button>
      <a class="btn btn-outline-secondary" href="/spp_app/index.php?page=petugas">Batal</a>
    </form>
  </div>
</div>
<?php endif; ?>