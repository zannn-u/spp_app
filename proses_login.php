<?php
// Bagian: Mulai session
session_start();

// Bagian: Koneksi ke database
include "config/koneksi.php";

// Bagian: Cek apakah form login dikirim
if (isset($_POST['login'])) {
  
  // Ambil data dari form
  $u = $_POST['username'];
  $p = $_POST['password'];

  // Bagian: Cari user berdasarkan username
  $q = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$u'");
  $d = mysqli_fetch_assoc($q);

  // Bagian: Validasi user & password
  if ($d && password_verify($p, $d['password'])) {
    // Jika berhasil → simpan data ke session
    $_SESSION['id_petugas']  = $d['id_petugas'];
    $_SESSION['username']    = $d['username'];
    $_SESSION['nama_petugas']= $d['nama_petugas'];
    $_SESSION['level']       = $d['level'];

    // Redirect ke dashboard
    header("Location: index.php");
    exit;
  } else {
    // Jika gagal → simpan pesan error dan kembali ke login
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: login.php");
    exit;
  }
}
