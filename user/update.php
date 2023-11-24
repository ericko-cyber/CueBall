<?php
session_start();
require "../session.php";
require "../functions.php";
if ($role !== 'User') {
    header("location:../login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Tangkap data formulir
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $hp = mysqli_real_escape_string($conn, $_POST["hp"]);
    $meja = mysqli_real_escape_string($conn, $_POST["meja"]);
    $insert_query = "INSERT INTO nama_tabel (nama, hp, meja, foto) VALUES ('$nama', '$hp', '$meja', '$foto')";

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
