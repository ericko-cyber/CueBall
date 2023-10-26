<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi</title>
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
        <label for="">Reset Password</label>
    </div>
    <div class="center" id="catas">
        <div class="box box-background" id="bbatas">
            <div class="bsandi">
                <div class="title">Set New Password</div>
                <div class="description">Must be at least 8 characters</div>
            </div>
            <div class="border"></div>
        </div>
    </div>
    <div id="cbawah">
        <form action="">
            <div class="box box-background" id="bbawah">
                <div class="input-container">
                    <label for="inputpass" class="label-pass">Confirm Password</label>
                    <input type="password" name="password" class="form-control" id="inputpass" required>
                </div>
                <div class="input-container">
                    <label for="inputpass" class="label-pass">Password</label>
                    <input type="password" name="password" class="form-control" id="inputpass" required>
                </div>
                <div class="mt-3 mb-4">
                    <button class="button btn-inti" name="daftar" id="daftar">Daftar</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>