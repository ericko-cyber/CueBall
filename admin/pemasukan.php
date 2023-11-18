<?php
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');
if ($role !== 'Admin') {
    header("location:/login.php");
}
$pemasukan = query("SELECT * FROM pemasukan");
?>
<link rel="stylesheet" href="../css/form.css">
<main class="table">
    <section class="table__header mt-5">
        <h1 style="margin-left:10px;">Data Pemasukan</h1>
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
                    <th> Tanggal Masuk <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Keterangan <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Pemasukan <span class="icon-arrow">&UpArrow;</span></th>
                </tr>
            </thead>
            <tbody id="dataTable">
                <?php $i = 1; ?>
                <?php $totalPemasukan = 0; ?>
                <?php foreach ($pemasukan as $row) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $row["tgl"]; ?></td>
                        <td><?= $row["keterangan"]; ?></td>
                        <td><?= $row["pemasukan"]; ?></td>
                    </tr>
                    <?php
                    $totalPemasukan += $row["pemasukan"];
                    $i++;
                    ?>
                <?php endforeach; ?>
                <tr>
                    <th scope="row" colspan="3">Total</th>
                    <td><?= $totalPemasukan; ?></td>
                </tr>
            </tbody>
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