<?php
require "../../functions.php";
$idpesan = $_GET["id"];

if (konfirmasimkn($idpesan) > 0) {
  echo "
  <script>
    alert('Data Berhasil DiKonfirmasi');
    document.location.href = '../../admin.php?page=makanpesan'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dihapus');
    document.location.href = '../../admin.php?page=makanpesan'; 
  </script>
  ";
}
