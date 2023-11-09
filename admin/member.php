<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:/login.php");
}

// Pagination
$jmlHalamanPerData = 5;
$jumlahData = count(query("SELECT * FROM user"));
$jmlHalaman = ceil($jumlahData / $jmlHalamanPerData);

if (isset($_GET["halaman"])) {
  $halamanAktif = $_GET["halaman"];
} else {
  $halamanAktif = 1;
}

$awalData = ($jmlHalamanPerData * $halamanAktif) - $jmlHalamanPerData;

$member = query("SELECT * FROM user LIMIT $awalData, $jmlHalamanPerData");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/table.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <title>Data Member</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="d-flex flex-column justify-content-between col-auto min-vh-100" id="bgg">
        <div class="mt-4">
          <a class="text-white d-none d-sm-inline text-decoration-none d-flex align-item-center " style="margin-left: 35px;" role="button">
            <span class="fs-5"><?= $_SESSION["username"]; ?></span>
          </a>
          <hr class="text-white d-none d-sm-block" />
          <ul class="nav nav-pills flex-column mt-10 mt-sm-0 " id="#menu">
            <li class="nav-item my-sm-1 my-2">
              <a href="home.php" class="nav-link text-white text-center text-sm-start" aria-current="page">
                <i class="fa fa-home"></i>
                <span class="ms-2 d-none d-sm-inline">Home</span>
              </a>
            </li>
            <li class="nav-item my-sm-1 my-2">
              <a href="member.php" class="nav-link text-white text-center text-sm-start" aria-current="page">
                <i class="fa fa-users"></i>
                <span class="ms-2 d-none d-sm-inline">Data Pelanggan</span>
              </a>
            </li>
            <li class="nav-item my-sm-1 my-2">
              <a href="pesan.php" class="nav-link text-white text-center text-sm-start" aria-current="page">
                <i class="fa fa-shopping-cart"></i>
                <span class="ms-2 d-none d-sm-inline">Data Pembayaran</span>
              </a>
            </li>
            <li class="nav-item my-sm-1 my-2">
              <a href="admin.php" class="nav-link text-white text-center text-sm-start" aria-current="page">
                <i class="fa fa-user"></i>
                <span class="ms-2 d-none d-sm-inline">Data Admin</span>
              </a>
            </li>
            <li class="nav-item my-sm-1 my-2">
              <a href="#sidemenu" data-bs-toggle="collapse" class="nav-link text-white text-center text-sm-start" aria-current="page">
                <i class="fa fa-table"></i>
                <span class="ms-2 d-none d-sm-inline">Meja & Minuman</span>
                <i class="fa fa-caret-down"></i>
              </a>
              <ul class="collapse flex-column text-white text-center text-sm-start" id="sidemenu" data-bs-parent="#menu">
                <li class="nav-item">
                  <a class="nav-link text-white" href="lapangan.php">Meja</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="makan.php">Minuman</a>
                </li>
              </ul>
            </li>
            <li class="nav-item my-sm-1 my-2">
              <a href="#sidemenup" data-bs-toggle="collapse" class="nav-link text-white text-center text-sm-start" aria-current="page">
                <i class="fa fa-table"></i>
                <span class="ms-2 d-none d-sm-inline">Data Laporan</span>
                <i class="fa fa-caret-down"></i>
              </a>
              <ul class="collapse flex-column text-white text-center text-sm-start" id="sidemenup" data-bs-parent="#menu">
                <li class="nav-item">
                  <a class="nav-link text-white" href="#">Pemasukan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="#">Pengeluaran</a>
                </li>
              </ul>
            </li>
            <li class="nav-item my-sm-1 my-2">
              <a href="../logout.php" class="nav-link text-white text-center text-sm-start" aria-current="page">
                <i class="fa fa-sign-out"></i>
                <span class="ms-2 d-none d-sm-inline">Log out</span>
              </a>
            </li>
          </ul>
          </ul>
        </div>
      </div>



      <div class="col-10 p-5" id="bg" >
        <!-- Konten -->
        <main class="table">
        <section class="table__header mt-5">
          <h1 style="margin-left:10px;" >Data Pelanggan</h1>
          <div class="input-group">
            <input type="search" placeholder="Search Data...">
          </div>
        </section>
        <hr>
        <section class="table__body">
          <table>
            <thead>
              <tr>
                <th> No <span class="icon-arrow">&UpArrow;</span></th>
                <th> Nama Lengkap <span class="icon-arrow">&UpArrow;</span></th>
                <th> Jenis Kelamin <span class="icon-arrow">&UpArrow;</span></th>
                <th> Email <span class="icon-arrow">&UpArrow;</span></th>
                <th> No HP <span class="icon-arrow">&UpArrow;</span></th>
                <th> aksi <span class="icon-arrow">&UpArrow;</span></th>
              </tr>
            </thead>
            <form action="" method="post">
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($member as $row) : ?>
                  <tr>
                    <th scope="row"><?= $i; ?></th>
                    <td><img src="../img/<?= $row["foto"]; ?>"><?= $row["nama_lengkap"]; ?></td>
                    <td><?= $row["jenis_kelamin"]; ?></td>
                    <td><?= $row["email"]; ?></td>
                    <td><?= $row["hp"]; ?></td>
                    <td>
                    <a href="./controller/hapusMember.php?id=<?= $row["id_user"]; ?>" class="btn btn-danger">Hapus</a>
                      </a>
                    </td>
                  </tr>
                  <?php $i++; ?>
                <?php endforeach; ?>
              </tbody>
            </form>
          </table>
        </section>
      </main>

        <!-- <ul class="pagination">
          <?php if ($halamanAktif > 1) : ?>
            <li class="page-item">
              <a href="?halaman=<?= $halamanAktif - 1; ?>" class="page-link">Previous</a>
            </li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $jmlHalaman; $i++) : ?>
            <?php if ($i == $halamanAktif) : ?>
              <li class="page-item active"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
            <?php else : ?>
              <li class="page-item "><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
            <?php endif; ?>
          <?php endfor; ?>

          <?php if ($halamanAktif < $jmlHalaman) : ?>
            <li class="page-item">
              <a href="?halaman=<?= $halamanAktif + 1; ?>" class="page-link">Next</a>
            </li>
          <?php endif; ?>
        </ul> -->

      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>