<?php
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');
if ($role !== 'Admin') {
  header("location:../login.php");
}

// Pagination


$pesan = query("SELECT pesan.idpesan, pesan.nama, pesan.hp, pesan.meja, pesan.total_products, pesan.total_price, bayarmkn.tgl_upload, bayarmkn.bukti, bayarmkn.konfirmasi
FROM pesan
JOIN bayarmkn ON pesan.idpesan = bayarmkn.idpesan ");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/form.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

  <title>Data Pesanan</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">

      <div class="col-10 p-5">

        <main class="table">
          <section class="table__header mt-5">
            <h1 style="margin-left:10px;">Data Pesanan Makanan</h1>
            <div class="input-group">
              <input type="search" class="form-control rounded" id="searchInput" aria-label="Search" aria-describedby="search-addon" placeholder="Search Data...">
            </div>
          </section>
          <hr>
          <button class="btn btn-inti btn btn-warning" onclick="printTable()" style="margin-left: 28px;"><i style="font-size: 20px;" class="bi bi-file-pdf"></i></button>
          <button class="btn btn-inti btn btn-warning" onclick="exportToExcel()" style="margin-left: 10px;"><i style="font-size: 20px;" class="bi bi-filetype-xls"></i></button>
          <section class="table__body">
            <table class="table">
              <thead>
                <tr>
                  <th> No <span class="icon-arrow"></span></th>
                  <th> Nama Cust <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Tgl Pesan <span class="icon-arrow">&UpArrow;</span></th>
                  <th> HP <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Ket Meja <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Total Produk <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Total Harga <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Bukti <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Konfirmasi <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Action <span class="icon-arrow">&UpArrow;</span></th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="searchResults">
                <?php $i = 1; ?>
                <?php foreach ($pesan as $row) : ?>
                  <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["tgl_upload"]; ?></td>
                    <td><?= $row["hp"]; ?></td>
                    <td><?= $row["meja"]; ?></td>
                    <td><?= $row["total_products"]; ?></td>
                    <td><?= $row["total_price"]; ?></td>
                    <td><img src="../img/<?= $row["bukti"]; ?>" id="imglap" width="100" height="100"></td>
                    <td><?= $row["konfirmasi"]; ?></td>
                    <td>
                      <?php
                      $idpesan = $row["idpesan"];
                      if ($row["konfirmasi"] == "Terkonfirmasi") {
                        // tampilkan tombol Bayar dan Hapus
                        echo '';
                      } else {
                        // tampilkan tombol Detail
                        echo ' <button type="button" class="btn btn-inti btn btn-success" data-bs-toggle="modal" data-bs-target="#konfirmasiModal' . $idpesan . '">
                    Konfirmasi
                  </button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal' . $idpesan . '">
                    Hapus
                  </button>
                  ';
                      }
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
          </section>
          </table>
        </main>
      </div>

      <?php foreach ($pesan as $row) : ?>
        <div class="modal fade" id="hapusModal<?= $row["idpesan"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Hapus Pesanan <?= $row["nama_lengkap"]; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Anda yakin ingin menghapus pesanan ini?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="./controller/hapusPesan.php?id=<?= $row["idsewa"]; ?>" class="btn btn-danger">Hapus</a>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="konfirmasiModal<?= $row["idpesan"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true" data-bs-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pesanan <?= $row["nama"]; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Anda yakin ingin mengkonfirmasi pesanan ini?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="admin/kontrol/konfirmasiPesanmkn.php?id=<?= $row["idpesan"]; ?>" class="btn btn-primary">Konfirmasi</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <div style="display: none;">
        <table class="table table-striped mt-3" id="print">
          <thead class="table" style="background-color:#9cd203 ;">
            <tr>
              <th scope="col" style="text-align: center; vertical-align: middle;">No</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">NamaCust</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">TglPesan</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">HP</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">Ket Meja</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">TotalProduk</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">TotalHarga</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">Bukti</th>
              <th scope="col" style="text-align: center; vertical-align: middle;">Konfirmasi</th>
              <!-- <th scope="col" style="text-align: center; vertical-align: middle;">Aksi</th> -->
            </tr>
          </thead>
          <tbody class="" id="searchResults">
            <?php $i = 1; ?>
            <?php foreach ($pesan as $row) : ?>
              <tr>
                <td style="text-align: center; vertical-align: middle;"><?= $i++; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row["nama"]; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row["tgl_upload"]; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row["hp"]; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row["meja"]; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row["total_products"]; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row["total_price"]; ?></td>
                <td style="text-align: center; vertical-align: middle;"><img src="../img/<?= $row["bukti"]; ?>" width="100" height="100"></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row["konfirmasi"]; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <script>
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

        function printTable() {
          var printContents = document.getElementById("print").outerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
        }

        function exportToExcel() {
          var table2excel = new Table2Excel();
          table2excel.export(document.querySelectorAll("table.table"));
        }
      </script>
      <script src="/admin/table2excel.js"></script>
</body>

</html>