<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="send.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

    <div class="wrapper">
        <?php

        require __DIR__ . "./functions.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];

            // Buat instance dari class DatabaseHandler

            if (checkEmailExists($email)) {
                $email = $_POST["email"];
                $token = bin2hex(random_bytes(16));
                $token_hash = hash("sha256", $token);
                $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
                $mysqli = require __DIR__ . "/database.php";
                $sql = "UPDATE user
                SET reset_token_hash = ?,
                reset_token_expires_at = ?
                WHERE email = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sss", $token_hash, $expiry, $email);
                $stmt->execute();
                if ($stmt->affected_rows) {
                    $mail = require __DIR__ . "/mailer.php";
                    $mail->setFrom("Billiad@gmail.com   ", "Basecamp Billiard");
                    $mail->addAddress($email);
                    $mail->Subject = "Password Reset";
                    $mail->Body = <<<END
                    Click <a href="http://localhost:3000/reset-password.php?token=$token">here</a>
                    to reset your password.
                    END;
                    try {
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Messege could not be sent. Mailer error: {$mail->ErrorInfo}";
                    }
                }

                echo "  Email telah dikirim, Silahkan cek gmail anda.";
            } else {
                // Email tidak ditemukan di database
                echo "Email tidak ditemukan. Silakan coba lagi atau daftar akun baru.";
                echo '<script>
                setTimeout(function(){
                window.location.href = "send-email.php";
                }, 3000); // 3000ms (3 detik)
                </script>';
            }
        }

        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>