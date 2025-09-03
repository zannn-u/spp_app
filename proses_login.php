<?php
session_start();
include "config/koneksi.php";

if (isset($_POST['login'])) {
  $u = $_POST['username']; $p = $_POST['password'];
  $q = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$u'");
  $d = mysqli_fetch_assoc($q);
  if ($d && password_verify($p, $d['password'])) {
    $_SESSION['id_petugas']=$d['id_petugas'];
    $_SESSION['username']=$d['username'];
    $_SESSION['nama_petugas']=$d['nama_petugas'];
    $_SESSION['level']=$d['level'];
    header("Location: index.php"); exit;
  } else {
    $_SESSION['error']="Username atau password salah!";
    header("Location: login.php"); exit;
  }
}