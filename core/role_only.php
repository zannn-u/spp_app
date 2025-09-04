<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (($_SESSION['level'] ?? '') !== 'admin') {
  http_response_code(403);
  die('<div class="p-5 text-center">Akses ditolak (khusus admin)</div>');
}