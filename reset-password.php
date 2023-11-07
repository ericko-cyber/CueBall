<?php

$token = $_GET["token"];

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
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="reset-password.css">

    <script>
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("password_confirmation").value;

            if (password !== confirmPassword) {
                alert("Kata sandi dan konfirmasi kata sandi tidak cocok. Silakan coba lagi.");
                return false; // Mencegah pengiriman formulir jika kata sandi tidak cocok
            }
            return true; // Lanjutkan dengan pengiriman formulir jika kata sandi cocok
        }
    </script>


</head>

<body>
    <div class="wrapper">
        <form method="POST" action="process-reset-password.php" onsubmit="return checkPasswordMatch();">
            <h1>Reset Password</h1>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="input-box">
                <input type="password" name="password" placeholder="New Password" required>
                <i class='bx bx-low-vision' id="showPassword"></i>
            </div>
            <div class="input-box">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <i class='bx bx-low-vision' id="showPassword2"></i>
            </div>
            <button type="submit" name="login" id="login" class="btn">Reset</button>
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
  <script>
    document.getElementById("showPassword2").addEventListener("click", function() {
    var passwordInput = document.getElementsByName("password_confirmation")[0];
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
});
  </script>
</body>

</html>