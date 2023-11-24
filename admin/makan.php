<?php
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');
if ($role !== 'Admin') {
  header("location:../login.php");
}

// Pagination

$makanan = query("SELECT * FROM makanan");

if (isset($_POST["simpan"])) {
  if (tambahMkn($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiTambahkan');
          window.location.href = 'index.php?page=makan'; 
          </script>";
  } else {
    echo "<script>
          alert('Gagal DiTambahkan');
          </script>";
  }
}

if (isset($_POST["edit"])) {
  if (editMkn($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Ubah');
          window.location.href = 'index.php?page=makan'; // Merefresh halaman ke admin.php
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
  <link rel="stylesheet" href="../css/form.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Data Lapangan</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">

      <!-- Modal Tambah -->
      <div class="modal fade" id="tambahModal1" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tambahModalLabel">Tambah Makanan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <!-- konten form modal -->
                <div class="row justify-content-center align-items-center">
                  <div class="col">
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Nama Makanan</label>
                      <input type="text" name="makanan" class="form-control" id="exampleInputPassword1">
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
          <h1 style="margin-left:10px;">Data Minuman</h1>
          <div class="input-group">
            <input type="search" name="search" id="searchInput" oninput="searchTable()" placeholder="Search Data...">
          </div>
        </section>
        <hr>
        <button class="btn btn-inti btn btn-warning" style="margin-left: 28px;" data-bs-toggle="modal" data-bs-target="#tambahModal1">Tambah</button>
        <section class="table__body">
          <table >
            <thead>
              <tr>
                <th> No <span class="icon-arrow">&UpArrow;</span></th>
                <th> Nama Makanan <span class="icon-arrow">&UpArrow;</span></th>
                <th> Harga <span class="icon-arrow">&UpArrow;</span></th>
                <th> Foto <span class="icon-arrow">&UpArrow;</span></th>
                <th> aksi <span class="icon-arrow">&UpArrow;</span></th>
              </tr>
            </thead>
            <tbody id="dataTable">
              <?php $i = 1; ?>
              <?php foreach ($makanan as $row) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $row["nm"]; ?></td>
                  <td><?= $row["harga"]; ?></td>
                  <td><img src="../img/<?= $row["foto"]; ?>" id="imglap" width="100" height="100"></td>
                  <td>
                    <button class="btn btn-inti btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["idmakanan"]; ?>">Edit</button>
                    <a href="admin/kontrol/hapusMkn.php?id=<?= $row["idmakanan"]; ?>" class="btn btn-danger">Hapus</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </section>
      </main>
      <?php foreach ($makanan as $row) : ?>
        <div class="modal fade" id="editModal<?= $row["idmakanan"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Edit Makanan <?= $row["nm"]; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idmkn" class="form-control" id="exampleInputPassword1" value="<?= $row["idmakanan"]; ?>">
                <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $row["foto"]; ?>">
                <div class="modal-body">
                  <!-- konten form modal -->
                  <div class="row justify-content-center align-items-center">
                    <div class="mb-3">
                      <img src="../img/<?= $row["foto"]; ?>" alt="gambar lapangan" class="img-fluid">
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nama makanan</label>
                        <input type="text" name="makanan" class="form-control" id="exampleInputPassword1" value="<?= $row["nm"]; ?>">
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
                      <input type="file" name="foto" class="form-control" id="exampleInputPassword1" value="<?= $row["foto"]; ?>">
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


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
<script>
  function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
      var found = false;
      td = tr[i].getElementsByTagName("td");
      for (var j = 0; j < td.length; j++) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          found = true;
          break;
        }
      }
      tr[i].style.display = found ? "" : "none";
    }
  }
</script>

</html>