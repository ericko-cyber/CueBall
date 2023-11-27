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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
              <input type="search" placeholder="Search Data...">
            </div>
          </section>
          <hr>
          <button class="btn btn-inti btn btn-warning" style="margin-left: 28px;" data-bs-toggle="modal" data-bs-target="#tambahModal1">Download</button>
          <section class="table__body">
            <table>
              <thead>
                <tr>
                  <th> No <span class="icon-arrow"></span></th>
                  <th> NamaCust <span class="icon-arrow">&UpArrow;</span></th>
                  <th> TglPesan <span class="icon-arrow">&UpArrow;</span></th>
                  <th> HP <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Ket Meja <span class="icon-arrow">&UpArrow;</span></th>
                  <th> TotalProduk <span class="icon-arrow">&UpArrow;</span></th>
                  <th> TotalHarga <span class="icon-arrow">&UpArrow;</span></th>
                  <th> Bukti <span class="icon-arrow">&UpArrow;</span></th>
                  <th> konfirmasi <span class="icon-arrow">&UpArrow;</span></th>
                  <th> action <span class="icon-arrow">&UpArrow;</span></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
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
                    Konfirmaasi
                  </button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal' . $idpesan . '">
                    Hapus
                  </button>
                  ';
                      }
                      ?>
                    </td>
                  </tr>

                  <!-- Modal Konfirmasi -->
                  
                  <!-- End Modal Konfirmasi -->
                  
                  
                  <?php endforeach; ?>
                </tbody>
              </section>
            </table>
          </main>
          
          <!-- Modal Hapus -->
          <div class="modal fade" id="hapusModal<?= $row["idpesan"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="hapusModalLabel">Hapus Pesanan <?= $row["nama"]; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Anda yakin ingin menghapus pesanan ini?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <a href="admin/kontrol/hapusPesanmkn.php?id=<?= $row["idpesan"]; ?>" class="btn btn-danger">Hapus</a>
                </div>
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
</body>

</html>