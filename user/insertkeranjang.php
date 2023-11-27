<?php
session_start();
require "../session.php";
require "../functions.php";
if ($role !== 'User') {
  header("location:../login.php");
}
function uploadkeranjang()
{
  $namaFile = $_FILES['foto']['name'];
  $ukuranFile = $_FILES['foto']['size'];
  $error = $_FILES['foto']['error'];
  $tmpName = $_FILES['foto']['tmp_name'];

  // Cek apakah tidak ada gambar yang di upload
  if ($error === 4) {
    echo "<script>
    alert('Pilih gambar terlebih dahulu');
    window.location.href = 'keranjang.php';
    </script>";
    return false;
  }

  // Cek apakah gambar
  $extensiValid = ['jpg', 'png', 'jpeg'];
  $extensiGambar = explode('.', $namaFile);
  $extensiGambar = strtolower(end($extensiGambar));

  if (!in_array($extensiGambar, $extensiValid)) {
    echo "<script>
    alert('Yang anda upload bukan gambar!');
    </script>";
    return false;
  }

  if ($ukuranFile > 1000000) {
    echo "<script>
    alert('Ukuran Gambar Terlalu Besar!');
    </script>";
    return false;
  }

  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $extensiGambar;
  // Move File
  move_uploaded_file($tmpName, '../img/' . $namaFileBaru);
  return $namaFileBaru;
}


// ... (kode sebelumnya tetap sama)

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
  // Tangkap data formulir
  $id_user = $_SESSION["id_user"];
  $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
  $hp = mysqli_real_escape_string($conn, $_POST["hp"]);
  $meja = mysqli_real_escape_string($conn, $_POST["meja"]);
  $upload = uploadkeranjang();
  $status = "menunggu";

  if (!$upload) {
    return false;
  }

  $cart_query = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE iduser = '$id_user'");
  $price_total = 0;

  if (mysqli_num_rows($cart_query) > 0) {
    while ($product_item = mysqli_fetch_assoc($cart_query)) {
      $product_name[] = $product_item['nama'] . ' (' . $product_item['jumlah'] . ') ';

      // Perhatikan perubahan di baris berikut
      $product_price = ($product_item['harga'] * $product_item['jumlah']); // Tambahkan fungsi number_format
      $price_total += $product_price;
    }
  }

  $total_product = implode(', ', $product_name);

  // Gunakan prepared statement
  $insert_query = mysqli_prepare($conn, "INSERT INTO `pesan` (iduser, nama, hp, meja, foto, total_products, total_price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

  // Bind parameter ke prepared statement
  mysqli_stmt_bind_param($insert_query, "isssssds", $id_user, $nama, $hp, $meja, $upload, $total_product, $price_total, $status);

  // Eksekusi prepared statement
  if (mysqli_stmt_execute($insert_query)) {
    $idpesan_baru = mysqli_insert_id($conn);

    // Melakukan INSERT ke tabel bayarmkn dengan idpesan yang baru saja diambil
    mysqli_query($conn, "INSERT INTO bayarmkn (idpesan, bukti, konfirmasi) VALUES ('$idpesan_baru', '$upload', 'Sudah Bayar')");
    echo "<script>
          alert('Berhasil DiTambahkan');
          window.location.href = 'histori.php'; // Merefresh halaman ke admin.php
          </script>";
  } else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
   echo "<script>
   window.location.href = 'histori.php'
   </script>";
  }

  // Tutup prepared statement
  mysqli_stmt_close($insert_query);
}
