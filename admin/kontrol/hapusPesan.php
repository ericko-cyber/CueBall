<?php
require "../../functions.php";
$id_sewa = $_GET["id"];

if (hapusPesan($id_sewa) > 0) {
  echo "
  <script>
    alert('Data Berhasil Dihapus');
    document.location.href = 'admin.php?page=mejapesan'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dihapus');
    document.location.href = 'admin.php?page=mejapesan'; 
  </script>
  ";
}
