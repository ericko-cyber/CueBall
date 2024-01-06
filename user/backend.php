<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "db_billiard");
// $mysqli = new mysqli("mifa.myhost.id", "mifamyho_cueball", "WSImif2023", "mifamyho_cueball");
//  $mysqli = new mysqli("localhost", "cueballm_billiard", "cueballmifak4", "cueballm_billiard");


if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'getBookedDates') {
    // Dapatkan idmeja dari parameter atau request
    $idmeja = $_GET['idmeja'] ?? null;
    error_log('ID Meja yang Diterima: ' . $idmeja);

    // Pastikan idmeja tidak kosong
    if ($idmeja !== null) {
        // Query untuk mendapatkan data tanggal yang sudah dipesan berdasarkan idmeja dengan kondisi status "Sudah Bayar" atau "Dikonfirmasi"
        $result = $mysqli->query("SELECT tanggal, jam FROM jam_sewa WHERE idmeja = '$idmeja' AND status IN ('Sudah Bayar', 'Dikonfirmasi')");

        // Inisialisasi array untuk menyimpan data tanggal dan jam
        $bookedDates = [];
        // Loop melalui hasil query dan tambahkan data ke array
        while ($row = $result->fetch_assoc()) {
            $date = date('Y-m-d', strtotime($row['tanggal']));
            $bookedDates[] = array(
                'tanggal' => $date,
                'jam' => $row['jam']
            );
        }

        // Kirim respons JSON
        echo json_encode(['success' => true, 'bookedDates' => $bookedDates]);
    } else {
        // Jika idmeja kosong, berikan response error
        echo json_encode(['error' => 'Parameter idmeja tidak valid']);
    }
} elseif ($action === 'saveBooking') {
    $bookingDate = $_POST['bookingDate'];
    $harga = $_POST['harga'];
    $iduser = $_POST['iduser'];
    $idmeja = $_POST['idmeja'];
    $selectedTimes = $_POST['selectedTimes'];   

    // Ambil harga meja berdasarkan idmeja
    $hargaQuery = $mysqli->query("SELECT harga FROM meja WHERE idmeja = '$idmeja'");

    if ($hargaQuery === false) {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
        error_log("Error executing SQL query: " . $mysqli->error);
        exit();
    }

    $hargaRow = $hargaQuery->fetch_assoc();
    $hargaPerJam = $hargaRow['harga'];

    // Hitung total biaya pemesanan
    $jumlahJamDipilih = count($selectedTimes); // Menghitung jumlah tombol jam yang dipilih
    $totalBiaya = $jumlahJamDipilih * $hargaPerJam;

    // Set status menjadi 'menunggu'
    $status = 'menunggu';
    $statusjam = 'menunggu';

    // Transaksi: Mulai transaksi MySQL
    $mysqli->begin_transaction();

    try {
        // Query untuk menyimpan data ke tabel sewa

        if (is_array($selectedTimes)) {
            // Gabungkan nilai array menjadi satu string dengan koma di antara setiap nilai
            $selectedTimesString = implode(',', $selectedTimes);

            $stmtSewa = $mysqli->prepare('INSERT INTO sewa (iduser, idmeja, tgl_pesan, jam, harga, tot, status) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmtSewa->bind_param('iissdss', $iduser, $idmeja, $bookingDate, $selectedTimesString, $hargaPerJam, $totalBiaya, $status);

            if (!$stmtSewa->execute()) {
                throw new Exception($stmtSewa->error);
            }


            // Ambil idsewa yang baru saja dimasukkan
            $idsewa = $mysqli->insert_id;

            // Query untuk menyimpan data ke tabel jam_sewa
            foreach ($selectedTimes as $jam) {
                $stmtJamSewa = $mysqli->prepare('INSERT INTO jam_sewa (idsewa, idmeja, tanggal, jam , status) VALUES (?, ?, ?, ?, ?)');
                $stmtJamSewa->bind_param('iisss', $idsewa, $idmeja, $bookingDate, $jam, $statusjam);

                if (!$stmtJamSewa->execute()) {
                    throw new Exception($stmtJamSewa->error);
                }
            }


            // Sekarang $selectedTimesString berisi string dengan nilai-nilai array yang dipisahkan oleh koma
            // echo $selectedTimesString;
        } else {
            // Handle jika $selectedTimes bukan array
            echo "Error: selectedTimes is not an array";
        }


        $mysqli->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Transaksi: Rollback transaksi MySQL jika terjadi kesalahan
        $mysqli->rollback();

        $errorResponse = ['success' => false, 'error' => $e->getMessage()];
        echo json_encode($errorResponse);
        error_log("Error executing SQL query: " . $e->getMessage());
    } finally {
        // Tutup statement
        $stmtSewa->close();
        if (isset($stmtJamSewa)) {
            $stmtJamSewa->close();
        }
    }
}
