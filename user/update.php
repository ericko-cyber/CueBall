<?php
session_start();
require "../session.php";
require "../functions.php";
if ($role !== 'User') {
    header("location:../login.php");
}
function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek apakah tidak ada gambar yang di upload
    if ($error === 4) {
        echo "<script>
    alert('Pilih gambar terlebih dahulu');
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Tangkap data formulir
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $hp = mysqli_real_escape_string($conn, $_POST["hp"]);
    $meja = mysqli_real_escape_string($conn, $_POST["meja"]);
    $upload = upload();
    if (!$upload) {
      return false;
    }

    $cart_query = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE iduser = '$iduser'");
    $price_total = 0;
    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['nama'] . ' (' . $product_item['jumlah'] . ') ';
            $product_price = number_format($product_item['harga'] * $product_item['jumlah']);
            $price_total += $product_price;
        };
    };
    $total_product = implode(', ', $product_name);
    $insert_query = mysqli_query($conn, "INSERT INTO `pesan`(nama, hp, meja, foto, total_products, total_price) VALUES('$nama','$hp','$meja','$upload','$total_product','$price_total')") or die('query failed');

    if (mysqli_query($conn, $insert_query)) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
// skrip-pembaruan.php

// Sertakan file koneksi database Anda

$id_user = $_SESSION["id_user"];
$select_cart = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE iduser = '$id_user'");
$total = 0;

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        // Hitung total harga untuk setiap item
        $total_price = $fetch_cart['harga'] * $fetch_cart['jumlah'];

        // Tambahkan total harga ke total keseluruhan
        $total += $total_price;

        // Tampilkan detail item
        echo '<span style="font-size: 15px;">' . $fetch_cart['nama'] . '(' . $fetch_cart['jumlah'] . ')</span>';
    }
} else {
    echo "<div class='display-order'><span>Keranjang Anda kosong!</span></div>";
}

// Terapkan number_format ke total keseluruhan setelah perulangan
$grand_total = $total;

echo '<span class="grand-total" style="font-size: 15px;"> Total Keseluruhan: Rp' . number_format($grand_total, 2) . '/- </span>';
