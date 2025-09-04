<?php
// Bagian: Mulai session
session_start();

// Bagian: Koneksi ke database
include "config/koneksi.php";

// Bagian: Cek apakah form login dikirim
if (isset($_POST['login'])) {
  
  // Ambil data dari form
  $u = $_POST['username'] ?? '';
  $p = $_POST['password'] ?? '';

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

// Proses login siswa (userlogin)
if (isset($_POST['login_user'])) {
  $nisn = $_POST['nisn'] ?? '';
  $pwd  = $_POST['password'] ?? '';

  include "config/koneksi.php";

  // Pastikan tabel akun_siswa ada
  mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS akun_siswa (
    nisn CHAR(10) PRIMARY KEY,
    nama VARCHAR(35) NOT NULL,
    password VARCHAR(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

  $q = mysqli_query($koneksi, "SELECT * FROM akun_siswa WHERE nisn='".mysqli_real_escape_string($koneksi,$nisn)."'");
  $d = mysqli_fetch_assoc($q);

  if ($d && password_verify($pwd, $d['password'])) {
    $_SESSION['siswa_nisn'] = $d['nisn'];
    $_SESSION['siswa_nama'] = $d['nama'];
    header("Location: userindex.php");
    exit;
  } else {
    $_SESSION['error_user'] = "NISN atau password salah!";
    header("Location: userlogin.php");
    exit;
  }
}
