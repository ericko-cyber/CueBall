<?php
header('Content-Type: application/json');
// $mysqli = new mysqli("localhost", "root", "", "db_futsal");
// $mysqli = new mysqli("mifa.myhost.id", "mifamyho_cueball", "WSImif2023", "mifamyho_cueball");
 $mysqli = new mysqli("localhost", "cueballm_billiard", "cueballmifak4", "cueballm_billiard");


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
        // Query untuk mendapatkan data tanggal yang sudah dipesan berdasarkan idlap dengan kondisi status "Sudah Bayar" atau "Dikonfirmasi"
        $result = $mysqli->query("SELECT tgl_pesan, jmulai, jhabis FROM sewa WHERE idlap = '$idlap' AND status IN ('Sudah Bayar', 'Dikonfirmasi')");

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
        // Jika idlap kosong, berikan response error
        echo json_encode(['error' => 'Parameter idlap tidak valid']);
    }
}
 elseif ($action === 'saveBooking') {
    $bookingDate = $_POST['bookingDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $iduser = $_POST['iduser'];
    $idlap = $_POST['idlap'];


    error_log("bookingDate: " . $bookingDate);
    error_log("startTime: " . $startTime);
    error_log("endTime: " . $endTime);
    error_log("iduser: " . $iduser);
    error_log("idlap: " . $idlap);

    // Ambil harga lapangan berdasarkan idlap
    $hargaQuery = $mysqli->query("SELECT harga FROM lapangan WHERE idlap = '$idlap'");

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

    $stmt = $mysqli->prepare('INSERT INTO sewa (iduser, idlap, tgl_pesan, jmulai, jhabis, harga, tot, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('iisssiss', $iduser, $idlap, $bookingDate, $startTime, $endTime, $harga, $totalBiaya, $status);

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
