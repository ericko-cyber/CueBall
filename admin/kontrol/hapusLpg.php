<?php
require "../../functions.php";
$id_lap = $_GET["id"];

if (hapusLpg($id_lap) > 0) {
  echo "
  <script>
    alert('Data Berhasil Dihapus');
    document.location.href = 'admin.php?page=meja'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dihapus');
    document.location.href = 'admin.php?page=meja'; 
  </script>
  ";
}
