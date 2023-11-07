<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./send.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>
    <div class="wrapper">
        <?php

        $token = $_POST["token"];

        $token_hash = hash("sha256", $token);

        $mysqli = require __DIR__ . "/database.php";

        $sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param("s", $token_hash);

        $stmt->execute();

        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        if ($user === null) {
           echo "token tidak ditemukan";
           echo '<script>
            setTimeout(function(){
                window.location.href = "login.php";
            }, 3000); // 3000ms (3 detik)
            </script>';
        }

        if (strtotime($user["reset_token_expires_at"]) <= time()) {
            echo "token telah kedaluwarsa";
            echo '<script>
            setTimeout(function(){
                window.location.href = "reset-password.php?";
            }, 3000); // 3000ms (3 detik)
            </script>';
        }
        if ($_POST["password"] !== $_POST["password_confirmation"]) {
            echo "kata sandi harus cocok";
            echo '<script>
            setTimeout(function(){
                window.location.href = "reset-password.php?token=' . $token . '";
            }, 3000); // 3000ms (3 detik)
            </script>';
    exit;
        }
        

        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "UPDATE user
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id_user = ?";

        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param("ss", $password_hash, $user["id_user"]);

        $stmt->execute();

        echo "Password updated. You can now login.";
        echo '<script>
            setTimeout(function(){
                window.location.href = "login.php";
            }, 3000); // 3000ms (3 detik)
        </script>';
        ?>
    </div>
</body>

</html>