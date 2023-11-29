<?php
require "../../functions.php";
$id_user = $_GET["id"];

if (hapusMember($id_user) > 0) {
  echo "
  <script>
    alert('Data Berhasil Dihapus');
    document.location.href = 'index.php?page=member'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dihapus');
    document.location.href = 'index.php?page=member'; 
  </script>
  ";
}
