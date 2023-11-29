<?php
require "../../functions.php";
$id_mkn = $_GET["id"];

if (hapusMkn($id_mkn) > 0) {
  echo "
  <script>
    alert('Data Berhasil Dihapus');
    document.location.href = 'index.php?page=makan'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dihapus');
    document.location.href = 'index.php?page=makan'; 
  </script>
  ";
}
