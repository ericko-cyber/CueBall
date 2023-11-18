<?php

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
    Klik <a href="http://localhost:3000/aktivasi/activate-account.php?token=$activation_token">disini</a>
    untuk mengaktifkan akun Anda.
    END;
    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Messege could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
    header("Location: signup-success.php");
    exit;
}else{
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

?>