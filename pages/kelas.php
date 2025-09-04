<?php 
// Membatasi akses halaman hanya untuk role tertentu
require_once __DIR__."/../core/role_only.php"; 

// Judul halaman
$title = "Kelas";

// Koneksi database
include __DIR__."/../config/koneksi.php";


// ======================
// PROSES DELETE DATA
// ======================
// Mengecek apakah ada parameter GET 'hapus'
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']); // pastikan ID berupa angka
    // Query hapus data berdasarkan id_kelas
    mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id'");
    // Redirect kembali ke halaman kelas dengan pesan sukses
    header("Location: /spp_app/index.php?page=kelas&msg=hapus");
    exit;
}

// ======================
// PROSES AMBIL DATA EDIT
// ======================
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas=$id"));
}

// ======================
// PROSES UPDATE DATA
// ======================
if (isset($_POST['update'])) {
    $id = (int)$_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi = $_POST['kompetensi_keahlian'];
    mysqli_query($koneksi, "UPDATE kelas SET nama_kelas='".mysqli_real_escape_string($koneksi,$nama_kelas)."', kompetensi_keahlian='".mysqli_real_escape_string($koneksi,$kompetensi)."' WHERE id_kelas=$id");
    header("Location: /spp_app/index.php?page=kelas&msg=update");
    exit;
}


// ======================
// PROSES CREATE DATA
// ======================
// Mengecek apakah ada submit form 'tambah'
if (isset($_POST['tambah'])) {
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);
    $kompetensi = mysqli_real_escape_string($koneksi, $_POST['kompetensi_keahlian']);
    
    // Query tambah data kelas baru
    $sql = "INSERT INTO kelas (nama_kelas,kompetensi_keahlian) VALUES('$nama_kelas','$kompetensi')";
    mysqli_query($koneksi, $sql);
    
    // Redirect kembali ke halaman kelas dengan pesan sukses
    header("Location: /spp_app/index.php?page=kelas&msg=tambah");
    exit;
}
?>

<!-- ======================
 BAGIAN HEADER HALAMAN
====================== -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <!-- Judul halaman -->
  <h4 class="mb-0">Data Kelas</h4>

  <!-- Tombol Tambah Kelas -->
  <a href="#formTambahKelas" class="btn btn-primary btn-sm" 
     onclick="document.getElementById('formTambahKelas').scrollIntoView();return false;">
     <i class="bi bi-plus-lg me-1"></i>Tambah Kelas
  </a>
</div>

<!-- Notifikasi jika data berhasil dihapus -->
<?php if(isset($_GET['msg']) && $_GET['msg']==='hapus'): ?>
<div class="alert alert-success py-2">Data terhapus.</div>
<?php endif; ?>


<!-- ======================
 FORM EDIT / TAMBAH DATA KELAS
====================== -->
<div class="card shadow-sm mb-3" id="formTambahKelas">
  <div class="card-body">
    <form method="post">
      <?php if(isset($data_edit)): ?>
        <input type="hidden" name="id_kelas" value="<?= $data_edit['id_kelas'] ?>">
      <?php endif; ?>
      <div class="row g-2">
        <!-- Input Nama Kelas -->
        <div class="col-md-6">
          <label class="form-label">Nama Kelas</label>
          <input type="text" class="form-control" name="nama_kelas" value="<?= isset($data_edit)?htmlspecialchars($data_edit['nama_kelas']):'' ?>" required>
        </div>
        <!-- Input Kompetensi -->
        <div class="col-md-6">
          <label class="form-label">Kompetensi</label>
          <input type="text" class="form-control" name="kompetensi_keahlian" value="<?= isset($data_edit)?htmlspecialchars($data_edit['kompetensi_keahlian']):'' ?>" required>
        </div>
      </div>
      <div class="mt-3">
        <!-- Tombol Submit Tambah/Update -->
        <?php if(isset($data_edit)): ?>
          <button type="submit" name="update" class="btn btn-primary">Update</button>
          <a class="btn btn-outline-secondary" href="/spp_app/index.php?page=kelas">Batal</a>
        <?php else: ?>
          <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>


<!-- ======================
 TABEL DATA KELAS
====================== -->
<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped datatable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Kelas</th>
          <th>Kompetensi</th>
          <th width="90">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
      // Query untuk menampilkan semua data kelas
      $q = mysqli_query($koneksi, "SELECT * FROM kelas");
      while ($d = mysqli_fetch_assoc($q)):
      ?>
        <tr>
          <!-- Menampilkan data per baris -->
          <td><?= $d['id_kelas'] ?></td>
          <td><?= htmlspecialchars($d['nama_kelas']) ?></td>
          <td><?= htmlspecialchars($d['kompetensi_keahlian']) ?></td>
          <td>
            <!-- Tombol hapus dengan konfirmasi -->
            <a class="btn btn-sm btn-outline-danger" 
               href="/spp_app/index.php?page=kelas&hapus=<?= $d['id_kelas'] ?>" 
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
