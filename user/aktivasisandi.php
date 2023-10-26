<?php
require "../functions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../gantisandi.css">
</head>

<body class="login">
    <div class="text-center">
        <img src="../billiard.png" class="rounded" alt="">
    </div>
    <div class="text-center">
        <label for="">Activation</label>
    </div>
    <div class="center" id="catas">
        <div class="box box-background" id="bbatas">
            <div class="bsandii">
                <div class="title">Please enter your username or email address. You <br>
                    will receive a link to create a new password via <br>
                    email.</div>
            </div>
            <div class="border"></div>
        </div>
    </div>
    <div id="cbawahh">
        <form action="">
            <div class="box box-background" id="bbawahh">
                <div class="input-container">
                    <label for="inputpass" class="label-pass">Email</label>
                    <input type="text" name="password" class="form-control" id="inputpass" required>
                </div>
                <div class="mt-3 mb-4">
                    <button class="button btn-inti" name="daftar" id="daftarr">Get New Password</button>
                </div>
                <div class="log"><a href="../login.php">Log in</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="daftar.php">Register</a></div>
            </div>
        </form>
    </div>

</body>

</html>