<?php
require "../../functions.php";
$id_pesan = $_GET["id"];

if (hapusPesanmkn($id_pesan) > 0) {
  echo "
  <script>
    alert('Data Berhasil Dihapus');
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
