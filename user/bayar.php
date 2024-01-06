<?php
session_start();
require "../functions.php";
require "../session.php";
if ($role !== 'User') {
  header("location:../login.php");
};

$id_user = $_SESSION["id_user"];


$sewa = query("SELECT sewa.*, user.nama_lengkap, meja.nm, bayar.bukti, bayar.konfirmasi
FROM sewa
JOIN meja ON sewa.idmeja = meja.idmeja
JOIN user ON sewa.iduser = user.id_user 
LEFT JOIN bayar ON sewa.idsewa = bayar.idsewa
WHERE sewa.iduser = '$id_user'");

// Pagination





if (isset($_POST["bayar"])) {
  if (bayar($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Bayar!');
          document.location.href = 'bayar.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal Bayar!');
          </script>";
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Order</title>
  <link rel="stylesheet" href="../css/keranjang.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Favicons -->
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/logo.png" rel="apple-touch-icon">

</head>

<body>

  <!-- Navbar -->
  <div class="container">
    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: black;">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="../assets/img/logo.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler " style="background-color: white;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="../index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Booking
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="lapangan.php">Table</a></li>
                <li><a class="dropdown-item" href="keranjang.php">Beverage</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="#">My Order</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <section class="lapangan mb-5" id="lapangan" style="margin-top: 4%;">
    <div class="container-fluid">
      <!-- <h2 class="text-head"><span>Pembayaran</span>Meja </h2> -->
      <form action="" method="post" enctype="multipart/form-data" class="px-4">
        <div class="col-12 col-md-12">
          <div class="table-responsive">
            <table class="table table-hover my-5">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Tanggal Pesan</th>
                  <th scope="col">Nama Pemesan</th>
                  <th scope="col">Nama Meja</th>
                  <th scope="col">Jam Bermain</th>
                  <th scope="col">Total</th>
                  <th scope="col">Status</th>
                  <th scope="col">Konfirmasi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($sewa as $row) : ?>
                  <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><?= $row["tgl_pesan"] ?></td>
                    <td><?= $row["nama_lengkap"] ?></td>
                    <td><?= $row["nm"] ?></td>
                    <td><?= $row["jam"] ?></td>
                    <td><?= $row["tot"] ?></td>
                    <td><?= $row["status"] ?></td>
                    <td>
                      <?php
                      $idsewa = $row["idsewa"];
                      if ($row["konfirmasi"] == "Sudah Bayar" || $row["konfirmasi"] == "Terkonfirmasi") {
                        // tampilkan tombol Bayar dan Hapus
                        // echo '<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal' . $row["idsewa"] . '">Detail</button> ';
                      } else {
                        // tampilkan tombol Detail
                        echo '<button type="button" class="btn btn-inti btn btn-success" data-bs-toggle="modal" data-bs-target="#bayarModal' . $row["idsewa"] . '">Bayar</button>
                    <a href="" data-bs-toggle="modal" data-bs-target="#hapusModal' . $row["idsewa"] . '" class="btn btn-danger">Hapus</a>';
                      }
                      ?>

                      <!-- Modal Bayar -->
                      <div class="modal fade" id="bayarModal<?= $row["idsewa"] ?>" tabindex="-1" role="dialog" aria-labelledby="bayarModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Bayar Meja <?= $row["nm"]; ?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data">
                              <input type="hidden" name="idsewa" value="<?= $row["idsewa"]; ?>">
                              <div class="modal-body">
                                <!-- konten form modal -->
                                <div class="row justify-content-center align-items-center">
                                  <div class="col">
                                    <div class="mb-3">
                                      <label for="exampleInputPassword1" class="form-label">Jam Bermain</label>
                                      <input type="text" name="tgl_main" class="form-control" id="exampleInputPassword1" value="<?= $row["jam"]; ?>" disabled>
                                    </div>
                                  <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Harga</label>
                                    <input type="number" name="harga" class="form-control" id="exampleInputPassword1" value="<?= $row["harga"]; ?>" disabled>
                                  </div>

                                  <div class="input-group ">
                                    <div class="input-group-prepend border border-danger">
                                      <span class="input-group-text">Total</span>
                                    </div>
                                    <input type="number" name="total" class="form-control border border-danger" id="exampleInputPassword1" value="<?= $row["tot"]; ?>" disabled>
                                  </div>
                                  <div class="mt-3">
                                    <label for="exampleInputPassword1" class="form-label">Transfer ke : BRI </label>
                                  </div>
                                  <div class="mt-3">
                                    <label for="exampleInputPassword1" class="form-label">Upload Bukti</label>
                                    <input type="file" name="foto" class="form-control" id="exampleInputPassword1">
                                  </div>
                                </div>
                              </div>
                              <div class="mt-3 mx-3">
                                <h6 class=" text-center border border-danger">Status : Belum Bayar</h6>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-inti btn btn-success" name="bayar" id="bayar">Bayar</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Bayar -->

                      <!-- Modal Detail -->
                      <div class="modal fade" id="detailModal<?= $row["idsewa"] ?>" tabindex="-1" role="dialog" aria-labelledby="bayarModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title">Detail Pembayaran <?= $row["nm"]; ?></h3>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                              <div class="modal-body">
                                <!-- konten form modal -->
                                <div class="row justify-content-center align-items-center" style="height: 395px;">
                                  <div class="mb-1 text-center d-flex align-items-center justify-content-center">
                                    <img src="../img/<?= $row["bukti"]; ?>" alt="gambar lapangan" class="img-fluid rounded" style="height: 160px;">
                                  </div>
                                  <div class="col">
                                    <div class="mb-1">
                                      <label for="exampleInputPassword1" class="form-label">Jam Bermain</label>
                                      <input type="text" name="tgl_main" class="form-control" id="exampleInputPassword1" value="<?= $row["jam"]; ?>" disabled>
                                    </div>
                                  </div>
                                  <div class="mb-2">
                                    <label for="exampleInputPassword1" class="form-label">Harga</label>
                                    <input type="number" name="harga" class="form-control" id="exampleInputPassword1" value="<?= $row["harga"]; ?>" disabled>
                                  </div>
                                  <div class="input-group ">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Total</span>
                                    </div>
                                    <input type="number" name="total" class="form-control " id="exampleInputPassword1" value="<?= $row["tot"]; ?>" disabled>
                                  </div>
                                </div>
                              </div>
                              <div class="mt-4 mx-3">
                                <h6 class="text-center border border-danger rounded">Status : <?= $row["konfirmasi"]; ?></h6>
                              </div>
                              <div class="mt-2 mb-2 d-flex text-center align-items-center justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100px; height: 35px;">Tutup</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Detail -->

                      <!-- Modal Hapus -->
                      <div class="modal fade" id="hapusModal<?= $row["idsewa"]; ?>" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus Data</h5>
                            </div>
                            <div class="modal-body">
                              <p>Anda yakin ingin menghapus data ini?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <a href="./controller/hapus.php?id=<?= $row["idsewa"] ?>" class="btn btn-danger">Hapus</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Hapus -->
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
      </form>
    </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script>
    feather.replace();
  </script>
</body>

</html>