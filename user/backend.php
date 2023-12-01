<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "db_billiard");
// $mysqli = new mysqli("mifa.myhost.id", "mifamyho_cueball", "WSImif2023", "mifamyho_cueball");
//  $mysqli = new mysqli("localhost", "cueballm_billiard", "cueballmifak4", "cueballm_billiard");


if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// backend.php

if ($action === 'getBookedDates') {
    // Dapatkan idmeja dari parameter atau request
    $idmeja = $_GET['idmeja'] ?? null;

    // Pastikan idmeja tidak kosong
    if ($idmeja !== null) {
        // Query untuk mendapatkan data tanggal yang sudah dipesan berdasarkan idmeja dengan kondisi status "Sudah Bayar" atau "Dikonfirmasi"
        $result = $mysqli->query("SELECT tgl_pesan, jmulai, jhabis FROM sewa WHERE idmeja = '$idmeja' AND status IN ('Sudah Bayar', 'Dikonfirmasi')");

        if ($result === false) {
            echo json_encode(['error' => 'Error executing SQL query', 'sql_error' => $mysqli->error]);
            error_log("Error executing SQL query: " . $mysqli->error);
        } else {
            $bookedDates = [];
            while ($row = $result->fetch_assoc()) {
                $date = date('Y-m-d', strtotime($row['tgl_pesan']));

                $bookedDates[] = [
                    'date' => $date,
                    'start_time' => $row['jmulai'],
                    'end_time' => $row['jhabis']
                ];
            }

            echo json_encode(['dates' => $bookedDates]);
        }
    } else {
        // Jika idmeja kosong, berikan response error
        echo json_encode(['error' => 'Parameter idmeja tidak valid']);
    }
}
 elseif ($action === 'saveBooking') {
    $bookingDate = $_POST['bookingDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $iduser = $_POST['iduser'];
    $idmeja = $_POST['idmeja'];


    error_log("bookingDate: " . $bookingDate);
    error_log("startTime: " . $startTime);
    error_log("endTime: " . $endTime);
    error_log("iduser: " . $iduser);
    error_log("idmeja: " . $idmeja);

    // Ambil harga lapangan berdasarkan idmeja
    $hargaQuery = $mysqli->query("SELECT harga FROM meja WHERE idmeja = '$idmeja'");

    if ($hargaQuery === false) {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
        error_log("Error executing SQL query: " . $mysqli->error);
        exit();
    }

    $hargaRow = $hargaQuery->fetch_assoc();
    $harga = $hargaRow['harga'];

    // Hitung total biaya pemesanan
    $startTimeObj = new DateTime($startTime);
    $endTimeObj = new DateTime($endTime);
    $diff = $startTimeObj->diff($endTimeObj);
    $hours = $diff->h + ($diff->i / 60);
    $totalBiaya = $hours * $harga;

    // Set tenggat_pembayaran beberapa menit setelah waktu pemesanan


    $status = 'menunggu';

    $stmt = $mysqli->prepare('INSERT INTO sewa (iduser, idmeja, tgl_pesan, jmulai, jhabis, harga, tot, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('iisssiss', $iduser, $idmeja, $bookingDate, $startTime, $endTime, $harga, $totalBiaya, $status);

    error_log("Data yang dikirim: " . print_r($_POST, true));

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
        error_log("Error executing SQL query: " . $mysqli->error);
    }

    $stmt->close();
}

?>
