<?php
// session_start();
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');

if ($role !== 'Admin') {
  header("location:../login.php");
};

// Pagination

$admin = query("SELECT * FROM admin");

if (isset($_GET['search'])) {
  $searchTerm = $_GET['search'];
  $$query = "SELECT * FROM admin 
  WHERE username LIKE '%$searchTerm%' 
     OR nama LIKE '%$searchTerm%' 
     OR phone LIKE '%$searchTerm%' 
     OR email LIKE '%$searchTerm%'";
  $result = query($query);
}


if (isset($_POST["simpan"])) {
  if (tambahAdmin($_POST) > 0) {
    echo "<script>
  alert('Berhasil DiTambahkan');
  window.location.href = 'admin.php?page=admin'; 
</script>";
  } else {
    echo "<script>
  alert('Gagal DiTambahkan');
</script>";
  }
}


// if (isset($_POST["edit"])) {
//   if (editAdmin($_POST) > 0) {
//     echo "<script>
//           alert('Berhasil DiTambahkan');
//           window.location.href = 'index.php'; // Merefresh halaman ke admin.php
//       </script>";
//   } else {
//     echo "<script>
//           alert('Gagal DiTambahkan');
//       </script>";
//   }
// }

?>
<link rel="stylesheet" href="../css/form.css">

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Tambah Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <!-- konten form modal -->
          <div class="row justify-content-center align-items-center">
            <div class="col">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">No Hp</label>
                <input type="number" name="hp" class="form-control" id="exampleInputPassword1">
              </div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="exampleInputPassword1">
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

<main class="table">
  <section class="table__header mt-5">
    <h1 style="margin-left:10px;">Data Admin</h1>
    <div class="input-group">
      <input type="search" name="search" id="searchInput" oninput="searchTable()" placeholder="Search Data...">
    </div>
  </section>
  <hr>
  <?php
  if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin@admin') {
  ?>
    <!-- Tombol "Tambah" hanya akan muncul jika username adalah "admin@admin" -->
    <button class="btn btn-inti btn btn-warning" style="margin-left: 28px;" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
  <?php
  }
  ?>
  <section class="table__body">
    <table>
      <thead>
        <tr>
          <th> No <span class="icon-arrow">&UpArrow;</span></th>
          <th> Username <span class="icon-arrow">&UpArrow;</span></th>
          <th> Nama Lengkap <span class="icon-arrow">&UpArrow;</span></th>
          <th> Email <span class="icon-arrow">&UpArrow;</span></th>
          <th> No HP <span class="icon-arrow">&UpArrow;</span></th>
          <?php if ($_SESSION['username'] === 'admin@admin') : ?>
            <th>Aksi <span class="icon-arrow">&UpArrow;</span></th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody id="dataTable">
        <?php $i = 1; ?>
        <?php foreach ($admin as $row) : ?>
          <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?= $row["username"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["phone"]; ?> </td>
            <td>
              <?php if ($_SESSION['username'] === 'admin@admin') : ?>
                <a href="admin/kontrol/hapusAdmin.php?id=<?= $row["id_user"]; ?>" class="btn btn-danger">Hapus</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
  </table>
</main>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Edit Admin <?= $row["nama"]; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post">
        <input type="hidden" name="id" class="form-control" id="exampleInputPassword1" value="<?= $row["id_user"]; ?>>">
        <div class="modal-body">
          <!-- konten form modal -->
          <div class="row justify-content-center align-items-center">
            <div class="col">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputPassword1" value="<?= $row["username"]; ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" value="<?= $row["password"]; ?>">
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                <input type="nama" name="nama" class="form-control" id="exampleInputPassword1" value="<?= $row["nama"]; ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $row["email"]; ?>">
              </div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">No Hp</label>
              <input type="number" name="hp" class="form-control" id="exampleInputPassword1" value="<?= $row["phone"]; ?>">
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

<!-- Tambahkan ini di bagian head atau sebelum penutup tag body -->
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