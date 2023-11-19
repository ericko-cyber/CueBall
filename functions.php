<?php

$autoload["libraries"] = array('email', 'session');

$conn = mysqli_connect("localhost", "root", "", "db_futsal");

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function getAdminProfile() {
  global $conn;

  // Assuming you have a table named 'admin' with columns 'id', 'username', and others
  $sql = "SELECT * FROM admin WHERE id_user = ".$_SESSION['id_user']; // You should modify this query based on your actual table structure

  $result = mysqli_query($conn, $sql);

  if ($result) {
      $profile = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      mysqli_close($conn);
      return $profile;
  } else {
      die("Error retrieving admin profile: " . mysqli_error($conn));
  }
}

function hapusMember($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM user WHERE id_user = $id");

  return mysqli_affected_rows($conn);
}

function hapusLpg($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM lapangan WHERE idlap = $id");

  return mysqli_affected_rows($conn);
}
function hapusMkn($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM makanan WHERE idmakanan = $id");

  return mysqli_affected_rows($conn);
}

function hapusAdmin($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM admin WHERE id_user = $id");

  return mysqli_affected_rows($conn);
}

function hapusPesan($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM sewa WHERE idsewa = $id");

  return mysqli_affected_rows($conn);
}

function daftar($data)
{
  global $conn;

  $activation_token = bin2hex(random_bytes(16));
  $activation_token_hash = hash("sha256", $activation_token);
  $mysqli = require __DIR__ . "/database.php";

  $username = strtolower(stripslashes($data["email"]));
  $password = password_hash($data["password"], PASSWORD_DEFAULT);
  $nama = $data["nama"];
  $hp = $data["hp"];
  $alamat = $data["alamat"];
  $gender = $data["gender"];
  //Upload Gambar
  $upload = upload();
  if (!$upload) {
    return false;
  }

  $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$username'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>
            alert('Username sudah terdaftar!');
        </script>";
    return false;
  }

$sql= "INSERT INTO user (email,password,hp,jenis_kelamin,nama_lengkap,alamat,foto,account_activation_hash) VALUES ('?','?','?','?','?','?','?','?')";

  $stmt->bind_param("ssss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash,
                  $activation_token_hash);

  // mysqli_query($conn, "INSERT INTO user (email,password,hp,jenis_kelamin,nama_lengkap,alamat,foto,account_activation_hash) VALUES ('$username','$password','$hp','$gender','$nama','$alamat','$upload','$activation_token_hash')");
  return mysqli_affected_rows($conn);
}

function edit($data)
{
  global $conn;

  $userid = $_SESSION["id_user"];
  $username = strtolower(stripslashes($data["email"]));
  $nama = $data["nama_lengkap"];
  $hp = $data["hp"];
  $gender = $data["jenis_kelamin"];
  //Upload Gambar
  $upload = upload();
  if (!$upload) {
    return false;
  }

  $query = "UPDATE user SET email = '$username', 
  nama_lengkap = '$nama',
  hp = '$hp',
  jenis_kelamin = '$gender',
  foto = '$upload'
  WHERE id_user = '$userid'
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function editAdmin($data)
{
  global $conn;

  $id = $_SESSION["id_user"];
  $username = $data["username"];
  $plainPassword = $data["password"]; 
  $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT); 
  $nama = $data["nama"];
  $hp = $data["hp"];
  $email = $data["email"];

  $query = "UPDATE admin SET 
  username = '$username',
  password = '$hashedPassword',  
  nama = '$nama',
  phone = '$hp',
  email  = '$email' WHERE id_user = '$id';
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


function pesan($data)
{
  global $conn;

  $userid = $_SESSION["id_user"];
  $idlpg = $data["id_lpg"];
  $lama =  $data["jam_mulai"];
  $mulai = $data["tgl_main"];
  $mulai_waktu = strtotime($mulai); // mengubah format datetime-local menjadi format UNIX timestamp
  $habis_waktu = $mulai_waktu + (intval($lama) * 3600); // menambahkan waktu dalam menit ke waktu awal
  $habis = date('Y-m-d\TH:i', $habis_waktu); // mengubah format waktu kembali ke datetime-local
  $habis_datetime_local = date('Y-m-d\TH:i:s', strtotime($habis)); // mengubah format waktu dari Y-m-d\TH:i ke format datetime-local
  $habis = $habis_datetime_local; // menyimpan hasil ke dalam variabel $habis_datetime_local
  $harga = $data["harga"];
  $total = date("H", strtotime($lama)) * $harga;

  mysqli_query($conn, "INSERT INTO sewa (iduser, idlap,lama,jmulai,jhabis,harga,tot) VALUES ('$userid','$idlpg','$lama','$mulai','$habis','$harga','$total') ");

  return mysqli_affected_rows($conn);
}

function bayar($data)
{
  global $conn;
  $idsewa = $data["idsewa"];

  //Upload Gambar
  $upload = upload();
  if (!$upload) {
    return false;
  }

  mysqli_query($conn, "INSERT INTO bayar (idsewa,bukti,konfirmasi) VALUES ('$idsewa','$upload','Sudah Bayar')");

  return mysqli_affected_rows($conn);
}

function tambahLpg($data)
{
  global $conn;

  $lapangan = $data["lapangan"];
  $harga = $data["harga"];

  //Upload Gambar
  $upload = upload();
  if (!$upload) {
    return false;
  }


  $query = "INSERT INTO lapangan (nm,harga,foto) VALUES ('$lapangan','$harga','$upload')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function tambahMkn($data)
{
  global $conn;

  $makanan = $data["makanan"];
  $harga = $data["harga"];

  //Upload Gambar
  $upload = upload();
  if (!$upload) {
    return false;
  }


  $query = "INSERT INTO makanan (nm,harga,foto) VALUES ('$makanan','$harga','$upload')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
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
  move_uploaded_file($tmpName, './img/' . $namaFileBaru);
  return $namaFileBaru;
}

function editLpg($data)
{
  global $conn;

  $id = $data["idlap"];
  $lapangan = $data["lapangan"];
  $ket = $data["ket"];
  $harga = $data["harga"];
  $gambarLama =  $data["fotoLama"];

  // Cek apakah User pilih gambar baru
  if ($_FILES["foto"]["error"] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }


  $query = "UPDATE lapangan SET 
  nm = '$lapangan',
  ket = '$ket',
  harga = '$harga',
  foto = '$gambar' WHERE idlap = '$id'
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}
function editMkn($data)
{
  global $conn;

  $id = $data["idmkn"];
  $makanan = $data["makanan"];
  $harga = $data["harga"];
  $gambarLama =  $data["fotoLama"];

  // Cek apakah User pilih gambar baru
  if ($_FILES["foto"]["error"] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }


  $query = "UPDATE makanan SET 
  nm = '$makanan',
  harga = '$harga',
  foto = '$gambar' WHERE idmakanan = '$id'
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


function tambahAdmin($data)
{
  global $conn;

  $username = $data["username"];
  $password = password_hash($data["password"], PASSWORD_DEFAULT);
  $nama = $data["nama"];
  $hp = $data["hp"];
  $email = $data["email"];

  $query = "INSERT INTO admin (username,password,nama,phone,email) VALUES ('$username','$password','$nama','$hp','$email')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}
function tambahpengeluaran($data)
{
  global $conn;

  $date = $data["tanggal"];
  $keterangan = $data["keterangan"];
  $pengeluaran = $data["pengeluaran"];

  $query = "INSERT INTO pengeluaran (tgl,keterangan,pengeluaran) VALUES ('$date','$keterangan','$pengeluaran')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}



function konfirmasi($idsewa)
{
  global $conn;

  $id = $idsewa;

  mysqli_query($conn, "UPDATE bayar set konfirmasi = ('Terkonfirmasi') WHERE idsewa = '$id'");
  return mysqli_affected_rows($conn);
}

function checkEmailExists($email)
    {
      global $conn;
        $email = $conn->real_escape_string($email);

        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            return true; // Email ada di database
        }
        return false; // Email tidak ditemukan di database
    }

 ?>


