<?php
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');
if ($role !== 'Admin') {
  header("location:../login.php");
}

// Pagination

$lapangan = query("SELECT * FROM lapangan");

if (isset($_POST["simpan"])) {
  if (tambahLpg($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiTambahkan');
          window.location.href = 'index.php?page=meja'; // Merefresh halaman ke admin.php
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
          window.location.href = 'index.php?page=meja'; // Merefresh halaman ke admin.php
          </script>";
  } else {
    echo "<script>
          alert('Gagal Di Ubah');
          </script>";
  }
}

?>

  <link rel="stylesheet" href="../css/form.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
  <div class="container-fluid">
    <div class="row">


    </div>
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
          <input type="search" name="search" id="searchInput" oninput="searchTable()" placeholder="Search Data...">
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
          <tbody id="dataTable">
            <?php $i = 1; ?>
            <?php foreach ($lapangan as $row) : ?>
              <tr>
                <th scope="row"><?= $i++; ?></th>
                <td><?= $row["nm"]; ?></td>
                <td><?= $row["harga"]; ?></td>
                <td><?= $row["ket"]; ?></td>
                <td><img src="./img/<?= $row["foto"]; ?>" id="imglap" width="100" height="100"></td>
                <td>
                  <button class="btn btn-inti btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["idlap"]; ?>">Edit</button>
                  <a href="admin/kontrol/hapusLpg.php?id=<?= $row["idlap"]; ?>" class="btn btn-danger">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
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
