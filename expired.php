<?php
require 'vendor/autoload.php';

use Cron\CronExpression;

// Setel zona waktu PHP
date_default_timezone_set('Asia/Jakarta');

$mysqli = new mysqli("localhost", "root", "", "db_futsal");

if ($mysqli->connect_error) {
    error_log('Kesalahan Koneksi (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    exit;
}

// Setel zona waktu MySQL (gunakan '+07:00' jika UTC)
$mysqli->query("SET time_zone = '+07:00'");

$cronExpression = CronExpression::factory('* * * * *'); // setiap 5 menit

if ($cronExpression->isDue()) {
    // Cetak waktu NOW() dan tenggat_pembayaran
    error_log("Waktu NOW(): " . date('Y-m-d H:i:s'));
    error_log("Waktu tenggat_pembayaran: 2023-11-26 22:38:55");

    $deleteExpiredQuery = $mysqli->prepare("DELETE FROM sewa WHERE tenggat_pembayaran < NOW() AND status = 'menunggu'");

    if ($deleteExpiredQuery === false) {
        error_log("Error preparing delete query: " . $mysqli->error);
    } else {
        $deleteResult = $deleteExpiredQuery->execute();

        if ($deleteResult === false) {
            error_log("Error executing delete query: " . $mysqli->error);
        } else {
            if ($deleteExpiredQuery->affected_rows > 0) {
                error_log("Data yang sudah kedaluwarsa berhasil dihapus.");
            } else {
                error_log("Tidak ada data yang memenuhi kriteria untuk dihapus.");
            }
        }

        $deleteExpiredQuery->close();
    }
} else {
    error_log("Tidak ada tugas yang dijadwalkan untuk dijalankan pada saat ini.");
}

$mysqli->close();
