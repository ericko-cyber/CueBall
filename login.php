<?php
session_start();
require "functions.php";


if (isset($_SESSION["role"])) {
  $role = $_SESSION["role"];
  if ($role == "Admin") {
    header("Location: admin/home.php");
  } else {
    header("Location: index.php");
  }
}

// Store $hashedPassword in the database along with other user/admin details

  if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $adminRow = query("SELECT * FROM admin WHERE email = '$username'");
    // Query untuk mengambil data pengguna
$userRow = query("SELECT * FROM user WHERE email = '$username'");

// Periksa login dan verifikasi
if ($adminRow) {
    if (password_verify($password, $adminRow[0]['password'])) {
        // set session untuk admin
        $_SESSION['username'] = $adminRow[0]['nama'];
        $_SESSION['role'] = "Admin";
        header("Location: admin/admin.php");
    } else {
        echo "<div class='alert alert-warning'>Username atau Password salah</div>";
    }
} elseif ($userRow && $userRow[0]["account_activation_hash"] === NULL) {
    if (password_verify($password, $userRow[0]['password'])) {
        // set session untuk user
        $_SESSION['email'] = $userRow[0]['email'];
        $_SESSION['id_user'] = $userRow[0]['id_user'];
        $_SESSION['role'] = "User";
        header("Location: index.php");
    } else {
        echo "<div class='alert alert-warning'>Username atau Password salah</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Verifikasi Terlebih Dahulu atau Email Tidak Ditemukan</div>";
}
  }
?>


<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login Sport Center</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/login.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <style>
    .alert-warning {
      text-align: center;
      /* Pusatkan teks dalam pesan sukses */
      position: absolute;
      /* Posisikan elemen secara absolut */
      top: 10%;
      /* Posisikan elemen di tengah vertikal */
      left: 50%;
      /* Posisikan elemen di tengah horizontal */
      transform: translate(-50%, -50%);
      /* Pusatkan elemen tepat di tengah layar */
      padding: 20px;
      /* Padding untuk elemen pesan sukses */
      z-index: 2;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <form method="POST">
      <h1>Login</h1>
      <div class="input-box">
        <input type="email" name="username" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bx-low-vision' id="showPassword"></i>
      </div>

      <div class="remember-forgot">
        <a href="send-email.php">Forgot password ?</a>
      </div>
      <button type="submit" name="login" id="login" class="btn">Login</button>
      <div class="register-link">
        <p>Don't have an account? <a href="/user/daftar.php">Register</a></p>
      </div>
    </form>
  </div>
  <script>
    document.getElementById("showPassword").addEventListener("click", function() {
      var passwordInput = document.getElementsByName("password")[0];
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>