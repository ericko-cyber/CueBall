<?php
session_start();
require "../functions.php";
require "../session.php";
if ($role !== 'User') {
  header("location:../login.php");
};

$id_user = $_SESSION["id_user"];


$pesan = query("SELECT pesan.*, bayarmkn.tgl_upload 
               FROM pesan 
               JOIN bayarmkn ON pesan.idpesan = bayarmkn.idpesan  
               WHERE pesan.iduser = '$id_user'");

// $profil = query("SELECT * FROM user WHERE id_user = '$id_user'")[0];

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

  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/logo.png" rel="apple-touch-icon">
</head>

<body>
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

  <section class="lapangan mb-5" id="lapangan" style="margin-top: 5%;">
    <div class="container-fluid">
    <div class="col-12 col-md-12">
    <div class="table-responsive">
      <form action="" method="post" class="px-4">
        <table class="table table-hover my-5">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal Pesan</th>
              <th scope="col">Nama Pemesan</th>
              <th scope="col">HP</th>
              <th scope="col">Meja</th>
              <th scope="col">Total Produk</th>
              <th scope="col">Total Harga</th>
              <th scope="col">Status</th>
              <th scope="col">Detail</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($pesan as $row) : ?>
              <tr>
                <th scope="row"><?= $i++; ?></th>
                <td><?= $row["tgl_upload"] ?></td>
                <td><?= $row["nama"] ?></td>
                <td><?= $row["hp"] ?></td>
                <td><?= $row["meja"] ?></td>
                <td><?= $row["total_products"] ?></td>
                <td><span>Rp. </span><?= $row["total_price"] ?></td>
                <td><?= $row["status"] ?></td>
                <td>
                  <!-- Tombol Detail -->
                  <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row["idpesan"] ?>">
                    Detail
                  </button>
                <td>
                  <!-- Modal Detail -->
                  <div class="modal fade" id="detailModal<?= $row["idpesan"] ?>" tabindex="-1" role="dialog" aria-labelledby="bayarModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Detail Pembayaran Makanan</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                          <div class="modal-body">
                            <!-- konten form modal -->
                            <div class="row justify-content-center align-items-center">
                              <div class="col">
                                <div class="mb-3">
                                  <label for="tgl_upload" class="form-label">Tanggal Pesan</label>
                                  <input type="date" name="tgl_upload" class="form-control" id="tgl_upload" value="<?= date('Y-m-d', strtotime($row["tgl_upload"])); ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="nama" class="form-label">Nama Pemesan</label>
                                  <input type="text" name="nama" class="form-control" id="nama" value="<?= $row["nama"]; ?>" disabled>
                                </div>
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="hp" class="form-label">HP</label>
                                  <input type="number" name="hp" class="form-control" id="hp" value="<?= $row["hp"]; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="meja" class="form-label">Ket Meja</label>
                                  <input type="text" name="meja" class="form-control" id="meja" value="<?= $row["meja"]; ?>" disabled>
                                </div>
                              </div>
                                <div class="mb-3">
                                  <label for="total_products" class="form-label">Total Produk</label>
                                  <input type="text" name="total_products" class="form-control" id="total_products" value="<?= $row["total_products"]; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="total_price" class="form-label">Total Harga</label>
                                  <div class="input-groub">                                   
                                    <input type="text" name="total_price" class="form-control" id="total_price" value="<?= $row["total_price"]; ?>" disabled>
                                  </div>
                                </div>                      
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal Detail -->
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