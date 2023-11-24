<?php
// session_start();
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');

if ($role !== 'Admin') {
    header("location:../login.php");
};

// Pagination

$pengeluaran = query("SELECT * FROM pengeluaran");


if (isset($_POST["simpan"])) {
    if (tambahpengeluaran($_POST) > 0) {
        echo "<script>
  alert('Berhasil DiTambahkan');
  window.location.href = 'index.php?page=pengeluaran'; 
</script>";
    } else {
        echo "<script>
  alert('Gagal DiTambahkan');
</script>";
    }
}



?>
<link rel="stylesheet" href="../css/form.css">

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <!-- konten form modal -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" id="exampleInputPassword1">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" id="exampleInputPassword1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Pengeluaran</label>
                            <input type="text" name="pengeluaran" class="form-control" id="exampleInputPassword1">
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
        <h1 style="margin-left:10px;">Data Pengeluaran</h1>
        <div class="input-group">
            <input type="search" name="search" id="searchInput" oninput="searchTable()" placeholder="Search Data...">
        </div>
    </section>
    <hr>
    <button class="btn btn-inti btn btn-warning" style="margin-left: 28px;" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
    <section class="table__body">
        <table id="dataTable">
            <thead>
                <tr>
                    <th> No <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Tanggal Masuk <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Keterangan <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Pengeluaran <span class="icon-arrow">&UpArrow;</span></th>
                </tr>
            </thead>
            <tbody id="dataTable">
                <?php $i = 1; ?>
                <?php $totalPengeluaran = 0; ?>
                <?php foreach ($pengeluaran as $row) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $row["tgl"]; ?></td>
                        <td><?= $row["keterangan"]; ?></td>
                        <td><?= $row["pengeluaran"]; ?></td>
                    </tr>
                    <?php
                    $totalPengeluaran += $row["pengeluaran"];
                    $i++;
                    ?>
                <?php endforeach; ?>
                <tr>
                    <th scope="row" colspan="3">Total</th>
                    <td><?= $totalPengeluaran; ?></td>
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