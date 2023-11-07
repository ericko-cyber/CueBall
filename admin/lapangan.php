<?php
session_start();
require "../session.php";
require "../functions.php";

if ($role !== 'Admin') {
  header("location:../login.php");
}

// Pagination

$lapangan = query("SELECT * FROM lapangan");

if (isset($_POST["simpan"])) {
  if (tambahLpg($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiTambahkan');
          window.location.href = 'lapangan.php'; // Merefresh halaman ke admin.php
          </script>";
  } else {
    echo "<script>
          alert('Gagal DiTambahkan');
          </script>";
  }
}

if (isset($_POST["edit"])) {
  if (editLpg($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Ubah');
          window.location.href = 'lapangan.php'; // Merefresh halaman ke admin.php
          </script>";
  } else {
    echo "<script>
          alert('Gagal Di Ubah');
          </script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../table.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Data Lapangan</title>
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
      <div class="col-10 p-5" id="bg">
        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahModal1" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Lapangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <!-- konten form modal -->
                  <div class="row justify-content-center align-items-center">
                    <div class="col">
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nama Lapangan</label>
                        <input type="text" name="lapangan" class="form-control" id="exampleInputPassword1">
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" id="exampleInputPassword1">
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Foto</label>
                      <input type="file" name="foto" class="form-control" id="exampleInputPassword1">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary" name="simpan" id="simpan">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal Tambah -->

        <main class="table">
          <section class="table__header mt-5">
            <h1 style="margin-left:10px;">Data Lapangan</h1>
            <div class="input-group">
              <input type="search" placeholder="Search Data...">
            </div>
          </section>
          <hr>
          <button class="btn btn-inti btn btn-warning" style="margin-left: 28px;" data-bs-toggle="modal" data-bs-target="#tambahModal1">Tambah</button>
          <section class="table__body">
            <table>
              <thead>
                <tr>
                  <th> No <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Nama Lapangan <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Harga <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Keterangan <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Foto <span class="icon-arrow">&UpArrow;</span></th>
                  <th> aksi <span class="icon-arrow">&UpArrow;</span></th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($lapangan as $row) : ?>
                  <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><?= $row["nm"]; ?></td>
                    <td><?= $row["harga"]; ?></td>
                    <td><?= $row["ket"]; ?></td>
                    <td><img src="../img/<?= $row["foto"]; ?>" id="imglap" width="100" height="100"></td>
                    <td>
                      <button class="btn btn-inti btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["idlap"]; ?>">Edit</button>
                      <a href="./controller/hapusLpg.php?id=<?= $row["idlap"]; ?>" class="btn btn-danger">Hapus</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
          </section>
          </table>
        </main>
        <?php foreach ($lapangan as $row) : ?>
          <div class="modal fade" id="editModal<?= $row["idlap"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="tambahModalLabel">Edit Lapangan <?= $row["nm"]; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="idlap" class="form-control" id="exampleInputPassword1" value="<?= $row["idlap"]; ?>">
                  <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $row["foto"]; ?>">
                  <div class="modal-body">
                    <!-- konten form modal -->
                    <div class="row justify-content-center align-items-center">
                      <div class="mb-3">
                        <img src="../img/<?= $row["foto"]; ?>" alt="gambar lapangan" class="img-fluid">
                      </div>
                      <div class="col">
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Nama Lapangan</label>
                          <input type="text" name="lapangan" class="form-control" id="exampleInputPassword1" value="<?= $row["nm"]; ?>">
                        </div>
                      </div>
                      <div class="col">
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Harga</label>
                          <input type="number" name="harga" class="form-control" id="exampleInputPassword1" value="<?= $row["harga"]; ?>">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Foto : </label>
                        <input type="file" name="foto" class="form-control" id="exampleInputPassword1" value="<?= $row["harga"]; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Keterangan : </label>
                        <input type="text" name="ket" class="form-control" id="exampleInputPassword1" value="<?= $row["ket"]; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="edit" id="edit">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>