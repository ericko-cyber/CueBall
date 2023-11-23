<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "db_futsal");

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// backend.php

if ($action === 'getBookedDates') {
    // Dapatkan idlap dari parameter atau request
    $idlap = $_GET['idlap'] ?? null;

    // Pastikan idlap tidak kosong
    if ($idlap !== null) {
        // Query untuk mendapatkan data tanggal yang sudah dipesan berdasarkan idlap
        $result = $mysqli->query("SELECT tgl_pesan, jmulai, jhabis FROM sewa WHERE idlap = '$idlap'");

        $bookedDates = [];
        while ($row = $result->fetch_assoc()) {
            $bookedDates[] = [
                'date' => $row['tgl_pesan'],
                'start_time' => $row['jmulai'],
                'end_time' => $row['jhabis']
            ];
        }

        echo json_encode(['dates' => $bookedDates]);
    } else {
        // Jika idlap kosong, berikan response error
        echo json_encode(['error' => 'Parameter idlap tidak valid']);
    }
}

 elseif ($_GET['action'] === 'saveBooking') {

    error_log("Data yang dikirim: " . print_r($_POST, true));

    $bookingDate = $_POST['bookingDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $iduser = $_POST['iduser'];
    $idlap = $_POST['idlap'];
    $harga = $_POST['harga'];

    // Hitung jumlah jam pesanan
    $startTimeObj = new DateTime($startTime);
    $endTimeObj = new DateTime($endTime);
    $diff = $startTimeObj->diff($endTimeObj);
    $hours = $diff->h + ($diff->i / 60); // Perhatikan perubahan di sini

    // Hitung total biaya 
    $totalBiaya = $hours * $harga;


    // Gunakan referensi untuk bind_param
    $status = 'menunggu';

    $stmt = $mysqli->prepare('INSERT INTO sewa (iduser, idlap, tgl_pesan, jmulai, jhabis, harga, tot, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('iisssiss', $iduser, $idlap, $bookingDate, $startTime, $endTime, $harga, $totalBiaya, $status);


    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
    }

    $stmt->close();
}



$mysqli->close();
