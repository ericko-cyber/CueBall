<?php
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');

if ($role !== 'Admin') {
  header("location:../login.php");
};


$pesan = query("SELECT sewa.idsewa,sewa.harga,user.nama_lengkap,sewa.tgl_pesan,sewa.jmulai,sewa.jhabis,sewa.tot,bayar.bukti,bayar.konfirmasi
FROM sewa
JOIN user ON sewa.iduser = user.id_user
JOIN bayar ON sewa.idsewa = bayar.idsewa");


?>

<link rel="stylesheet" href="../css/form.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<div class="container-fluid">
  <div class="row">

    <div class="col-10 p-5">

      <main class="table">
        <section class="table__header mt-5">
          <h1 style="margin-left:10px;">Data Pesanan</h1>
          <div class="input-group">
            <input type="search" name="search" id="searchInput" oninput="searchTable()" placeholder="Search Data...">
          </div>
        </section>
        <hr>
        <button class="btn btn-inti btn btn-warning" onclick="printTable()" style="margin-left: 28px;">Download</button>
        <section class="table__body">
          <table>
            <thead>
              <tr>
                <th> No <span class="icon-arrow"></span></th>
                <th> NamaCust <span class="icon-arrow">&UpArrow;</span></th>
                <th> TglPesan <span class="icon-arrow">&UpArrow;</span></th>
                <th> JamMulai <span class="icon-arrow">&UpArrow;</span></th>
                <th> JamAkhir <span class="icon-arrow">&UpArrow;</span></th>
                <th> Harga <span class="icon-arrow">&UpArrow;</span></th>
                <th> Total <span class="icon-arrow">&UpArrow;</span></th>
                <th> Bukti <span class="icon-arrow">&UpArrow;</span></th>
                <th> konfirmasi <span class="icon-arrow">&UpArrow;</span></th>
                <th> action <span class="icon-arrow">&UpArrow;</span></th>
              </tr>
            </thead>
            <tbody  id="searchResults">
              <?php $i = 1; ?>
              <?php foreach ($pesan as $row) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $row["nama_lengkap"]; ?></td>
                  <td><?= $row["tgl_pesan"]; ?></td>
                  <td><?= $row["jmulai"]; ?></td>
                  <td><?= $row["jhabis"]; ?></td>
                  <td><span>Rp.</span><?= $row["harga"]; ?></td>
                  <td><span>Rp.</span><?= $row["tot"]; ?></td>
                  <td><img src="../img/<?= $row["bukti"]; ?>" id="imglap" width="100" height="100"></td>
                  <td><?= $row["konfirmasi"]; ?></td>
                  <td>
                    <?php
                    $idsewa = $row["idsewa"];
                    if ($row["konfirmasi"] == "Terkonfirmasi") {
                      // tampilkan tombol Bayar dan Hapus
                      echo '';
                    } else {
                      // tampilkan tombol Detail
                      echo ' <button type="button" class="btn btn-inti btn btn-success" data-bs-toggle="modal" data-bs-target="#konfirmasiModal' . $idsewa . '">
                    Konfirmasi
                  </button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal' . $idsewa . '">
                    Hapus
                  </button>
                  ';
                    }
                    ?>
                  </td>
                </tr>
            </tbody>
        </section>
      <?php endforeach; ?>
      </table>
      </main>
      <?php foreach ($pesan as $row) : ?>
        <div class="modal fade" id="konfirmasiModal<?= $row["idsewa"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pesanan <?= $row["nama_lengkap"]; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Anda yakin ingin mengkonfirmasi pesanan ini?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="admin/kontrol/konfirmasiPesan.php?id=<?= $row["idsewa"]; ?>" class="btn btn-primary">Konfirmasi</a>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal Konfirmasi -->

        <!-- Modal Hapus -->
        <div class="modal fade" id="hapusModal<?= $row["idsewa"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
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
                <a href="admin/kontrol/hapusPesan.php?id=<?= $row["idsewa"]; ?>" class="btn btn-danger">Hapus</a>
              </div>
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
          <th scope="col" style="text-align: center; vertical-align: middle;">JamMulai</th>
          <th scope="col" style="text-align: center; vertical-align: middle;">JamAkhir</th>
          <th scope="col" style="text-align: center; vertical-align: middle;">Harga</th>
          <th scope="col" style="text-align: center; vertical-align: middle;">Total</th>
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
            <td style="text-align: center; vertical-align: middle;"><?= $row["nama_lengkap"]; ?></td>
            <td style="text-align: center; vertical-align: middle;"><?= $row["tgl_pesan"]; ?></td>
            <td style="text-align: center; vertical-align: middle;"><?= $row["jmulai"]; ?></td>
            <td style="text-align: center; vertical-align: middle;"><?= $row["jhabis"]; ?></td>
            <td style="text-align: center; vertical-align: middle;"><?= $row["harga"]; ?></td>
            <td style="text-align: center; vertical-align: middle;"><?= $row["tot"]; ?></td>
            <td style="text-align: center; vertical-align: middle;"><img src="../img/<?= $row["bukti"]; ?>" width="100" height="100"></td>
            <td style="text-align: center; vertical-align: middle;"><?= $row["konfirmasi"]; ?></td>
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