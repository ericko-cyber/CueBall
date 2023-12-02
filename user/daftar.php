<!-- <?php
require "../functions.php";


if (isset($_POST["daftar"])) {
  if (daftar($_POST) > 0) {
    echo "<div class='alert alert-success' id='success-message'>Berhasil mendaftar, silahkan login.</div>";
    echo "<script>
            setTimeout(function() {
              window.location.href = '../login.php'; // Ganti 'halaman_login.php' dengan URL halaman login yang sesuai
            }, 4000);
          </script>";
  }
}


?> -->


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi</title>
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/logo.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="/css/daftar.css">
  <link rel="icon" href="/img/soccer-ground.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <style>
    .alert-success {
      text-align: center;
      position: absolute;
      top: 10%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgb(53, 206, 60);
      padding: 20px;
      z-index: 2;
    }
  </style>
</head>

<body> 
  <div class="wrapper">
    <form method="post" action="../aktivasi/procces-signup.php" enctype="multipart/form-data">
      <h1>Register</h1>
      <div class="input-box mt-3">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="input-box">
        <input type="text" name="hp" placeholder="No Hp" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="input-box">
        <input type="text" name="alamat" placeholder="Alamat" required>
      </div>
      <div class="d-flex mt-3 ">
        <p>Jenis Kelamin : </p>
        <div class="form-check mx-3">
          <input class="form-check-input" type="radio" name="gender" id="male" value="Laki-Laki">
          <label class="form-check-label" for="male">
            Laki-Laki
          </label>
        </div>
        <div class="form-check mx-3">
          <input class="form-check-input" type="radio" name="gender" id="female" value="Perempuan">
          <label class="form-check-label" for="female">
            Perempuan
          </label>
        </div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Foto</label>
        <input type="file" name="foto" class="form-control" id="exampleInputPassword1" required>
      </div>
      <button type="submit" name="daftar" id="daftar" class="btn">Daftar</button>
      <div class="register-link">
        <p>have an account? <a href="../login.php">Login</a></p>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>