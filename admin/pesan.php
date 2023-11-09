<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}

// Pagination

$pesan = query("SELECT sewa.idsewa,user.nama_lengkap,sewa.tgl_pesan,sewa.jmulai,sewa.jhabis,sewa.lama,sewa.tot,bayar.bukti,bayar.konfirmasi
FROM sewa
JOIN user ON sewa.iduser = user.id_user
JOIN bayar ON sewa.idsewa = bayar.idsewa ");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/table.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

  <title>Data Pesanan</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="d-flex flex-column justify-content-between col-auto bg-dark min-vh-100" id="bgg">
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
                  <a class="nav-link text-white" href="makan.php">MInuman</a>
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

      <div class="col-10 p-5" id="bg">

        <main class="table">
          <section class="table__header mt-5">
            <h1 style="margin-left:10px;">Data Pesanan</h1>
            <div class="input-group">
              <input type="search" placeholder="Search Data...">
            </div>
          </section>
          <hr>
          <button class="btn btn-inti btn btn-warning" style="margin-left: 28px;" data-bs-toggle="modal" data-bs-target="#tambahModal1">Download</button>
          <section class="table__body">
            <table>
              <thead>
                <tr>
                  <th> No <span class="icon-arrow"></span></th>
                  <th> NamaCust <span class="icon-arrow">&UpArrow;</span></th>
                  <th> TglPesan <span class="icon-arrow">&UpArrow;</span></th>
                  <th> TglMain <span class="icon-arrow">&UpArrow;</span></th>
                  <th> TglAkhir <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Lama <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Total <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Bukti <span class="icon-arrow">&UpArrow;</span></th>
                  <th> konfirmasi <span class="icon-arrow">&UpArrow;</span></th>
                  <th> action <span class="icon-arrow">&UpArrow;</span></th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($pesan as $row) : ?>
                  <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row["nama_lengkap"]; ?></td>
                    <td><?= $row["tgl_pesan"]; ?></td>
                    <td><?= $row["jmulai"]; ?></td>
                    <td><?= $row["jhabis"]; ?></td>
                    <td><?= $row["lama"]; ?></td>
                    <td><?= $row["tot"]; ?></td>
                    <td><img src="../img/<?= $row["bukti"]; ?>" id="imglap" width="100" height="100"></td>
                    <td><?= $row["konfirmasi"]; ?></td>
                    <td>
                      <?php
                      $idsewa = $row["idsewa"];
                      if ($row["konfirmasi"] == "Terkonfirmasi") {
                        // tampilkan tombol Bayar dan Hapus
                        echo '';
                      } else {
                        // tampilkan tombol Detail
                        echo ' <button type="button" class="btn btn-inti" data-bs-toggle="modal" data-bs-target="#konfirmasiModal' . $idsewa . '">
                    Konfir
                  </button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal' . $idsewa . '">
                    Hapus
                  </button>
                  ';
                      }
                      ?>
                    </td>
                  </tr>

                  <!-- Modal Konfirmasi -->
                  <div class="modal fade" id="konfirmasiModal<?= $row["idsewa"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pesanan <?= $row["nama_lengkap"]; ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p>Anda yakin ingin mengkonfirmasi pesanan ini?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <a href="./controller/konfirmasiPesan.php?id=<?= $row["idsewa"]; ?>" class="btn btn-primary">Konfirmasi</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal Konfirmasi -->

                  <!-- Modal Hapus -->
                  <div class="modal fade" id="hapusModal<?= $row["idsewa"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="hapusModalLabel">Hapus Pesanan <?= $row["nama_lengkap"]; ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p>Anda yakin ingin menghapus pesanan ini?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <a href="./controller/hapusPesan.php?id=<?= $row["idsewa"]; ?>" class="btn btn-danger">Hapus</a>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php endforeach; ?>
              </tbody>
          </section>
          </table>
        </main>

      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>