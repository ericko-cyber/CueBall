<?php
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');
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

$member = query("SELECT * FROM user");

?>

  <link rel="stylesheet" href="../css/form.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Konten -->
  <main class="table">
    <section class="table__header mt-5">
      <h1 style="margin-left:10px;">Data Pelanggan</h1>
      <div class="input-group">
        <input type="search" name="search" id="searchInput" oninput="searchTable()" placeholder="Search Data...">
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
          <tbody id="dataTable">
            <?php $i = 1; ?>
            <?php foreach ($member as $row) : ?>
              <tr>
                <th scope="row"><?= $i; ?></th>
                <td><img src="./img/<?= $row["foto"]; ?>"><?= $row["nama_lengkap"]; ?></td>
                <td><?= $row["jenis_kelamin"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><?= $row["hp"]; ?></td>
                <td>
                  <a href="admin/controller/hapusMember.php?id=<?= $row["id_user"]; ?>" class="btn btn-danger">Hapus</a>
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
