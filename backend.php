<?php
// header('Content-Type: application/json');
// $mysqli = new mysqli("localhost", "root", "", "shop_db");

// if ($mysqli->connect_error) {
//     die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
// }

// $action = isset($_GET['action']) ? $_GET['action'] : '';

// if ($action === 'getBookedDates') {
//     $result = $mysqli->query('SELECT booking_date, start_time, end_time FROM bookings');
//     $bookedDates = [];
//     while ($row = $result->fetch_assoc()) {
//         $bookedDates[] = [
//             'date' => $row['booking_date'],
//             'start_time' => $row['start_time'],
//             'end_time' => $row['end_time']
//         ];
//     }
//     echo json_encode(['dates' => $bookedDates]);
// } elseif ($action === 'saveBooking') {
//     $bookingDate = $_POST['bookingDate'];
//     $startTime = $_POST['startTime'];
//     $endTime = $_POST['endTime'];

//     $stmt = $mysqli->prepare('INSERT INTO bookings (booking_date, start_time, end_time) VALUES (?, ?, ?)');
//     $stmt->bind_param('sss', $bookingDate, $startTime, $endTime);

//     if ($stmt->execute()) {
//         echo json_encode(['success' => true]);
//     } else {
//         echo json_encode(['success' => false, 'error' => $mysqli->error]);
//     }

//     $stmt->close();
// }

// $mysqli->close();
?>
