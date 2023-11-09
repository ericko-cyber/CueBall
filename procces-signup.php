<?php
require "functions.php";

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$activation_token = bin2hex(random_bytes(16));

$activation_token_hash = hash("sha256", $activation_token);

$email = $_POST["email"];
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$hp = $_POST["hp"];
$jenis_kelamin = $_POST["gender"];
$nama = $_POST["nama"];
$alamat = $_POST["alamat"];

  //Upload Gambar
  $upload = upload();
  if (!$upload) {
    return false;
  }

$mysqli = require __DIR__ . "/database.php";

$sql= "INSERT INTO user (email,password,hp,jenis_kelamin,nama_lengkap,alamat,foto,account_activation_hash) VALUES (?,?,?,?,?,?,?,?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param('ssssssss', $email, $password_hash, $hp, $jenis_kelamin, $nama, $alamat, $upload, $activation_token_hash);
                  
if ($stmt->execute()) {
    $mail = require __DIR__ . "/mailer.php";
    $mail->Host = "smtp.gmail.com";
    $mail->setFrom("Billiad@gmail.com   ", "Basecamp Billiard");
    $mail->addAddress($_POST["email"]);
    $mail->Subject = "Account Activation";
    $mail->Body = <<<END
    Click <a href="http://localhost:3000/activate-account.php?token=$activation_token">here</a>
    to activate your account.
    END;
    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Messege could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
    header("Location: signup-success.html");
    exit;
}else{
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

?>