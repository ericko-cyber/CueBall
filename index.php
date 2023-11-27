<!-- Coding by CodingLab | www.codinglabweb.com -->
<?php
session_start();
require "session.php";
require "functions.php";

if ($role !== 'Admin') {
    header("location:login.php");
}
$stmtpp = mysqli_prepare($conn, "
    (SELECT * FROM `bayar` WHERE konfirmasi = 'Sudah Bayar')
    UNION
    (SELECT * FROM `bayarmkn` WHERE konfirmasi = 'Sudah Bayar')
");
mysqli_stmt_execute($stmtpp);
$result = mysqli_stmt_get_result($stmtpp);
$row_count_total = mysqli_num_rows($result);


$stmt = mysqli_prepare($conn, "SELECT * FROM `bayar` WHERE konfirmasi = 'Sudah Bayar'");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row_count = mysqli_num_rows($result);

$stmtp = mysqli_prepare($conn, "SELECT * FROM `bayarmkn` WHERE konfirmasi = 'Sudah Bayar'");
mysqli_stmt_execute($stmtp);
$result = mysqli_stmt_get_result($stmtp);
$row_countp = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/style.css">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <title>Dashboard Sidebar Menu</title>
</head>

<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../logo.png" class="logo" style="width: 80px;" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Basecamp Billiard</span>
                    <span class="profession"><?= $_SESSION["nama"]; ?></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="index.php?page=home">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="index.php?page=member">
                            <i class='bx bxs-user-account icon'></i>
                            <span class="text nav-text">Data Member</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="index.php?page=admin">
                            <i class='bx bxs-user icon'></i>
                            <span class="text nav-text">Data Admin</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#sidemenu2" data-bs-toggle="collapse" aria-current="page">
                            <i class='bx bx-money-withdraw icon'></i>
                            <span class="text nav-text">Pemesanan</span>
                        </a>
                    </li>
                    <ul class="collapse " id="sidemenu2" data-bs-parent="#menu">
                        <li class="nav-link drop">
                            <a class="nav-text text-white" href="index.php?page=mejapesan">Meja &nbsp;</a>
                        </li>
                        <li class="nav-link drop">
                            <a class=" nav-text text-white" href="index.php?page=makanpesan">Minuman &nbsp; </a>
                        </li>
                    </ul>

                    <li class="nav-link down">
                        <a href="#sidemenu" data-bs-toggle="collapse" aria-current="page">
                            <i class='bx bx-clipboard icon'></i>
                            <span class="text nav-text">Meja & Minuman </span>
                        </a>
                    </li>
                    <ul class="collapse " id="sidemenu" data-bs-parent="#menu">
                        <li class="nav-link drop">
                            <a class="nav-text text-white" href="index.php?page=meja">Meja</a>
                        </li>
                        <li class="nav-link drop">
                            <a class=" nav-text text-white" href="index.php?page=makan">Minuman</a>
                        </li>
                    </ul>
                    <li class="nav-link">
                        <a href="#sidemenu1" data-bs-toggle="collapse" aria-current="page">
                            <i class='bx bxs-report icon'></i>
                            <span class="text nav-text">Laporan</span>
                        </a>
                    </li>
                    <ul class="collapse " id="sidemenu1" data-bs-parent="#menu">
                        <li class="nav-link drop">
                            <a class=" nav-text text-white" href="index.php?page=pemasukan">Pemasukan</a>
                        </li>
                        <li class="nav-link drop">
                            <a class=" nav-text text-white" href="index.php?page=pengeluaran">Pengeluaran</a>
                        </li>
                    </ul>

                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="index.php?page=setting">
                        <i class='bx bx-cog icon'></i>
                        <span class="text nav-text">Setting</span>
                    </a>
                </li>
                <li class="">
                    <a href="../logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

            </div>
        </div>

    </nav>

    <section class="home">
        <div class="text"></div>
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'home':
                    include 'admin/home.php';
                    break;
                case 'member':
                    include 'admin/member.php';
                    break;
                case 'admin':
                    include 'admin/admin.php';
                    break;
                case 'mejapesan':
                    include 'admin/pesan.php';
                    break;
                case 'makanpesan':
                    include 'admin/pesanmakan.php';
                    break;
                case 'meja':
                    include 'admin/lapangan.php';
                    break;
                case 'makan':
                    include 'admin/makan.php';
                    break;
                case 'pemasukan':
                    include 'admin/pemasukan.php';
                    break;
                case 'pengeluaran':
                    include 'admin/pengeluaran.php';
                    break;
                case 'setting':
                    include 'admin/setting.php';
                    break;
                default:
                    include 'admin/setting.php';
                    break;
            }
        } else {
            include 'admin/setting.php';
        }
        ?>
    </section>

    <script src="../script.js"></script>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>

</body>

</html>