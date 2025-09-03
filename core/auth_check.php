<?php
if (!isset($_SESSION['id_petugas'])) {
  header("Location: login.php"); exit;
}