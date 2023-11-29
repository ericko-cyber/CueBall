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
  window.location.href = 'admin.php?page=pengeluaran'; 
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
            <input type="search" class="form-control rounded" id="searchInput" aria-label="Search" aria-describedby="search-addon" placeholder="Search Data...">
        </div>
    </section>
    <button class="btn btn-inti btn btn-warning" onclick="printTable()" style="margin-left: 28px;">Download</button>
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
            <tbody id="searchResults">
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
<div style="display: none;">
    <table class="table table-striped mt-3" id="print">
        <thead class="table" style="background-color:#9cd203 ;">
            <tr>
                <th scope="col" style="text-align: center; vertical-align: middle;">No</th>
                <th scope="col" style="text-align: center; vertical-align: middle;">Tanggal Masuk</th>
                <th scope="col" style="text-align: center; vertical-align: middle;">Keterangan</th>
                <th scope="col" style="text-align: center; vertical-align: middle;">Pengeluaran</th>
                <!-- <th scope="col" style="text-align: center; vertical-align: middle;">Aksi</th> -->
            </tr>
        </thead>
        <tbody class="" id="searchResults">
            <?php $i = 1; ?>
            <?php foreach ($pengeluaran as $row) : ?>
                <tr>
                    <td style="text-align: center; vertical-align: middle;"><?= $i++; ?></td>
                    <td style="text-align: center; vertical-align: middle;"><?= $row["tgl"]; ?></td>
                    <td style="text-align: center; vertical-align: middle;"><?= $row["keterangan"]; ?></td>
                    <td style="text-align: center; vertical-align: middle;"><?= $row["pengeluaran"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script>
    function printTable() {
        var printContents = document.getElementById("print").outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const rows = document.querySelectorAll("#searchResults tr");

        searchInput.addEventListener("input", function() {
            const searchQuery = searchInput.value.toLowerCase();

            rows.forEach((row) => {
                const cells = row.getElementsByTagName("td");
                let rowContainsQuery = false;

                for (let i = 0; i < cells.length; i++) {
                    const cellText = cells[i].textContent.toLowerCase();

                    if (cellText.includes(searchQuery)) {
                        rowContainsQuery = true;
                        break;
                    }
                }

                if (rowContainsQuery) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>