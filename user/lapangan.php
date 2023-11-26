<?php
session_start();
require "../functions.php";
require "../session.php";
if ($role !== 'User') {
  header("location:../login.php");
}

$id = $_SESSION["id_user"];

$lapangan = query("SELECT * FROM lapangan");
$modal = query("SELECT * FROM lapangan where idlap");
$profil = query("SELECT * FROM user WHERE id_user = '$id'")[0];

if (isset($_POST["simpan"])) {
  if (edit($_POST) > 0) {
    echo "<script>
          alert('Berhasil Diubah');
          </script>";
  } else {
    echo "<script>
          alert('Gagal Diubah');
          </script>";
  }
}


if (isset($_POST["pesan"])) {
  if (pesan($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiPesan');
          document.location.href = 'bayar.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal DiPesan');
          </script>";
  }
}



?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book Table</title>
  <link rel="stylesheet" href="../style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!--font awesome-->
  <script src="https://kit.fontawesome.com/ab6316514a.js" crossorigin="anonymous"></script>

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

  <!-- FAS-->

  <style>
    /* CSS untuk mempercantik tombol */
    button:disabled {
      background-color: #ccc;
      /* Warna latar belakang ketika tombol dinonaktifkan */
      color: #666;
      /* Warna teks ketika tombol dinonaktifkan */
      cursor: not-allowed;
      /* Ganti kursor saat tombol dinonaktifkan */
    }

    button.selected:disabled {
      background-color: #3498db;
      /* Warna latar belakang yang berbeda saat tombol dipilih dan dinonaktifkan */
      color: #ffffff;
      /* Warna teks yang kontras dengan latar belakang */
      cursor: not-allowed;
      /* Ganti kursor saat tombol dipilih dan dinonaktifkan */
    }

    button {
      background-color: #0A0A0A;
      color: #fff;
      /* Warna teks tombol */
      padding: 10px 10px;
      /* Padding tombol */
      border: none;
      /* Hilangkan border */
      border-radius: 5px;
      /* Tambahkan radius sudut */
      cursor: pointer;
      /* Ganti kursor saat mengarah ke tombol */
      margin: 5px;
      /* Margin antar tombol */
    }

    button.selected {
      background-color: #FFBB35;
      /* Warna latar belakang yang berbeda saat tombol dipilih */
      color: #ffffff;
      /* Warna teks yang kontras dengan latar belakang */
    }

    /* Kursor pointer saat di atas tombol */
    button:hover {
      cursor: pointer;
    }
  </style>
</head>

<body style="background-color: #FFBB35">
  <!-- Navbar -->
  <div class="container ">
    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: black;">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="../assets/img/logo.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler " style="background-color: white;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="../indexuser.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Booking
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="lapangan.php">Table</a></li>
                <li><a class="dropdown-item" href="keranjang.php">Beverage</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="bayar.php">My Order</a>
            </li>
          </ul>
          <?php
          if (isset($_SESSION['id_user'])) {
            // jika user telah login, tampilkan tombol profil dan sembunyikan tombol login'
            //echo '<a href="bayar.php" class="btn btn-inti"><i class="fas fa-shopping-cart"></i></a>';
            echo '<a href="user/profil.php" data-bs-toggle="modal" data-bs-target="#profilModal" class="btn btn-inti"><i data-feather="user"></i></a>';
          } else {
            // jika user belum login, tampilkan tombol login dan sembunyikan tombol profil
            echo '<a href="login.php" class="btn btn-inti" type="submit">Login</a>';
          }
          ?>
        </div>
      </div>
    </nav>
  </div>
  <!-- End Navbar -->

  <!-- Modal Profil -->
  <div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profilModalLabel">Profil Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="row">
              <div class="col-4 my-5">
                <img src="../img/<?= $profil["foto"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col-8">
                <h5 class="mb-3"><?= $profil["nama_lengkap"]; ?></h5>
                <p><?= $profil["jenis_kelamin"]; ?></p>
                <p><?= $profil["email"]; ?></p>
                <p><?= $profil["hp"]; ?></p>
                <p><?= $profil["alamat"]; ?></p>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
                <a href="" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-inti">Edit Profil</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Profil -->

  <!-- Edit profil -->
  <div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog edit modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfilModalLabel">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $profil["foto"]; ?>">
          <div class="modal-body">
            <div class="row justify-content-center align-items-center">
              <div class="mb-3">
                <img src="../img/<?= $profil["foto"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                  <input type="text" name="nama_lengkap" class="form-control" id="exampleInputPassword1" value="<?= $profil["nama_lengkap"]; ?>">
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if ($profil['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($profil['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">No Telp</label>
                  <input type="number" name="hp" class="form-control" id="exampleInputPassword1" value="<?= $profil["hp"]; ?>">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $profil["email"]; ?>">
                </div>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">alamat</label>
                <input type="text" name="alamat" class="form-control" id="exampleInputPassword1" value="<?= $profil["alamat"]; ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Foto : </label>
                <input type="file" name="foto" class="form-control" id="exampleInputPassword1">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-inti" name="simpan" id="simpan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Edit Modal -->

  <section class="lapangan" id="lapangan">
    <div class="container">
      <main class="contain" data-aos="fade-right" data-aos-duration="1000">
        <h2 class="text-head"> Choose <span>Your</span> Table! </h2>
        <div class="row row-cols-1 row-cols-md-4">
          <?php foreach ($lapangan as $row) : ?>
            <div class="col" style="padding-bottom: 10px;">
              <div class="card">
                <img src="../img/<?= $row["foto"]; ?>" alt="gambar lapangan" class="card-img-top">
                <div class="card-body text-center">
                  <h5 class="card-title"><?= $row["nm"]; ?></h5>
                  <p class="card-text"><?= $row["ket"]; ?></p>
                  <p class="card-price"><?= $row["harga"]; ?></p>
                  <!-- <a href="jadwal.php?id=<?= $row["idlap"]; ?>" type="button" class="btn btn-secondary">Jadwal</a> -->
                  <button type="button" class="btn btn-inti" data-bs-toggle="modal" data-bs-target="#pesanModal<?= $row["idlap"]; ?>" onclick="handlePesanButtonClick(<?= $row["idlap"]; ?>)">Pesan</button>
                </div>
              </div>
            </div>

            <!-- Modal Pesan -->
            <div class="modal fade" id="pesanModal<?= $row["idlap"]; ?>" tabindex="-1" aria-labelledby="pesanModalLabel<?= $row["idlap"]; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel<?= $row["idlap"]; ?>">Pesan <?= $row["nm"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="bookingForm">
                    <div class="modal-body">
                      <!-- konten form modal -->
                      <div class="row justify-content-center align-items-center">
                        <div class="mb-3">
                          <img src="../img/<?= $row["foto"]; ?>" alt="gambar lapangan" class="img-fluid" style="left: 20%; position: relative;">
                        </div>
                        <div class="text-center">
                          <h6 name="harga" class="form-control" id="harga">Harga : <?= $row["harga"]; ?></h6>
                        </div>
                        <div class="col">
                          <!-- <input type="hidden" name="id_lpg" class="form-control" id="exampleInputPassword1" value="<?= $row["idlap"]; ?>"> -->
                          <label for="bookingDate">Pilih Tanggal:</label>
                          <input type="date" class="form-control" style="margin-bottom: 20px;" id="bookingDate" name="bookingDate" required>
                        </div>
                        <div class="mb-3">
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="12:00" data-end-time="13:00" onclick="toggleTimeRange(this)" data-date="">12:00-13:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="13:00" data-end-time="14:00" onclick="toggleTimeRange(this)" data-date="">13:00-14:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="14:00" data-end-time="15:00" onclick="toggleTimeRange(this)" data-date="">14:00-15:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="15:00" data-end-time="16:00" onclick="toggleTimeRange(this)" data-date="">15:00-16:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="16:00" data-end-time="17:00" onclick="toggleTimeRange(this)" data-date="">16:00-17:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="17:00" data-end-time="18:00" onclick="toggleTimeRange(this)" data-date="">17:00-18:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="18:00" data-end-time="19:00" onclick="toggleTimeRange(this)" data-date="">18:00-19:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="19:00" data-end-time="20:00" onclick="toggleTimeRange(this)" data-date="">19:00-20:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="20:00" data-end-time="21:00" onclick="toggleTimeRange(this)" data-date="">20:00-21:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="21:00" data-end-time="22:00" onclick="toggleTimeRange(this)" data-date="">21:00-22:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="22:00" data-end-time="23:00" onclick="toggleTimeRange(this)" data-date="">22:00-23:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="23:00" data-end-time="00:00" onclick="toggleTimeRange(this)" data-date="">23:00-24:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="00:00" data-end-time="01:00" onclick="toggleTimeRange(this)" data-date="">00:00-01:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="01:00" data-end-time="02:00" onclick="toggleTimeRange(this)" data-date="">01:00-02:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="02:00" data-end-time="03:00" onclick="toggleTimeRange(this)" data-date="">02:00-03:00</button>
                          <button type="button" data-idlap="<?= $row["idlap"]; ?>" data-start-time="03:00" data-end-time="04:00" onclick="toggleTimeRange(this)" data-date="">03:00-04:00</button>
                          <br>
                          <input type="hidden" id="selectedDate" name="selectedDate" value="">
                          <input type="hidden" id="jmulai" name="jmulai" value="">
                          <input type="hidden" id="jhabis" name="jhabis" value="">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-inti">Pesan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- End Modal Pesan -->
          <?php endforeach; ?>
        </div>
      </main>
    </div>
  </section>

  < <!--=======Footer=======-->
    <footer id="footer">


      <div class="footer-top">
        <div class="container">
          <div class="row">

            <div class="col-lg-3 col-md-6 footer-contact">
              <h3>BASECAMP BILLIARD</h3>
              <p>
                <i class="bi bi-geo-alt"></i>
                Jalan Riau 15GG <br>
                Krajan Barat, Sumbersari<br>
                Jember <br><br>
                <i class="bi bi-phone"></i>
                <strong>Phone:</strong><br>
                <i class="bx bxl-instagram"></i>
                <strong>Instagram:</strong> @basecampbilliard21<br>
              </p>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Quick Links</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="#hero">Home</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#services">Services</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#table">Book</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contact</a></li>
              </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="#table">Table</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#fnb">Beverage</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#fnb">Snack</a></li>
              </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Opening Hours</h4>
              <p>Everyday | 12:00 PM - 04:00 AM </p>
              <div class="social-links mt-3">
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#https://wa.me/6285704478791" class="google-plus"><i class="bx bxl-whatsapp"></i></a>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="container footer-bottom clearfix">
        <div class="copyright">
          &copy; Copyright <strong><span>Basecamp Billiard</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        </div>
      </div>
    </footer>
    <!-- End Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
      feather.replace();
    </script>


    <script>
      var selectedIdlap;
      var selectedTimeRanges = [];
      var clickedButton;

      function handlePesanButtonClick(idlap) {
        console.log('Tombol Pesan diklik untuk lapangan dengan ID:', idlap);
        // Dapatkan tanggal yang sudah dipilih
        var selectedDate = $('#pesanModal' + idlap + ' #bookingDate').val();

        // Set data-date pada tombol-tombol sesuai dengan tanggal yang dipilih
        updateButtonsForDate(selectedDate, idlap);

        // Perbarui tombol-tombol berdasarkan tanggal yang sudah dipesan
        checkAllTimes(selectedDate, idlap);

        // Sekarang Anda dapat menggunakan idlap sesuai kebutuhan, misalnya untuk mengambil data dari backend
        // atau melakukan tindakan lain yang diperlukan.

        // Contoh: Jika Anda ingin memperbarui data tanggal yang sudah dipesan saat tombol Pesan diklik
        getBookedDates(idlap);
      }



      function toggleTimeRange(clickedButton, idlap) {
        console.log('Button clicked:', clickedButton);
        var idlap = clickedButton.getAttribute('data-idlap');
        clickedButton.idlap = idlap;
        var selectedDate = $('#pesanModal' + idlap + ' #bookingDate').val();
        console.log('Selected Date:', selectedDate);

        var bookingDateValue = $('#pesanModal' + idlap + ' #bookingDate').val();
        console.log('Isi elemen #pesanModal' + idlap + ' #bookingDate:', bookingDateValue);

        var startTime = clickedButton.getAttribute('data-start-time');
        var endTime = clickedButton.getAttribute('data-end-time');
        clickedButton.setAttribute('data-date', selectedDate);

        // Pilih tanggal terlebih dahulu
        if (!selectedDate) {
          alert('Pilih tanggal terlebih dahulu.');
          return;
        }
        updateButtonsForDate(idlap);

        var today = new Date().toISOString().split('T')[0];
        var isToday = selectedDate === today;

        if (!isToday && isTimeRangeBooked(selectedDate, startTime)) {
          // alert('Jam ini sudah dipesan. Pilih jam lain.');
          return;
        }

        // Check if the time range is already selected
        var existingRangeIndex = findTimeRangeIndex(startTime, endTime);

        if (existingRangeIndex !== -1) {
          // Unselect the time range if already selected
          selectedTimeRanges.splice(existingRangeIndex, 1);
          clickedButton.classList.remove('selected'); // Hapus kelas 'selected'
        } else {
          // Add the time range to the selection
          selectedTimeRanges.push({
            startTime: startTime,
            endTime: endTime
          });
          clickedButton.classList.add('selected'); // Tambahkan kelas 'selected'
        }
        window.clickedButton = clickedButton;

        // Update the hidden input fields
        updateHiddenFields();

        // Optional: Display the selected time ranges to the user
        var selectedRangesText = selectedTimeRanges.map(range => range.startTime + '-' + range.endTime).join(', ');
        // alert('Waktu Pemesanan: ' + selectedRangesText);

        // Check all times
        checkAllTimes();
      }


      function findTimeRangeIndex(startTime, endTime) {
        // Check if the time range is already selected
        for (var i = 0; i < selectedTimeRanges.length; i++) {
          if (selectedTimeRanges[i].startTime === startTime && selectedTimeRanges[i].endTime === endTime) {
            return i;
          }
        }
        return -1;
      }

      function updateHiddenFields() {
        // Sort the selected time ranges by start time
        selectedTimeRanges.sort((a, b) => (a.startTime > b.startTime) ? 1 : -1);

        // Set the start time and end time based on the selected ranges
        if (selectedTimeRanges.length > 0) {
          document.getElementById('jmulai').value = selectedTimeRanges[0].startTime;
          document.getElementById('jhabis').value = selectedTimeRanges[selectedTimeRanges.length - 1].endTime;
        } else {
          // No selected ranges, clear the hidden fields
          document.getElementById('jmulai').value = '';
          document.getElementById('jhabis').value = '';
        }
      }

      function submitBookingForm() {
        var idlap = clickedButton.idlap;
        var bookingDate = $('#pesanModal' + idlap + ' #bookingDate').val();

        var currentDate = new Date();
        var currentTime = currentDate.toTimeString().split(' ')[0]; // Ambil jam dari waktu saat ini

        // Gabungkan tanggal dan waktu saat ini
        var bookingDateTime = bookingDate + ' ' + currentTime;

        console.log('Nilai bookingDate:', bookingDate);
        var startTime = $('#jmulai').val();
        var endTime = $('#jhabis').val();
        var hargaText = $('#pesanModal<?= $row["idlap"]; ?> #harga').text().replace(/[^\d]/g, '');
        var harga = parseInt(hargaText, 10);
        var iduser = <?= $_SESSION["id_user"]; ?>;
        console.log('Isi elemen #pesanModal' + idlap + ' #bookingDate:', $('#pesanModal' + idlap + ' #bookingDate').val());

        $.ajax({
          url: 'backend.php?action=saveBooking',
          method: 'POST',
          data: {
            bookingDate: bookingDateTime,
            startTime: startTime,
            endTime: endTime,
            harga: harga,
            idlap: idlap,
            iduser: iduser,
          },
          success: function(data, textStatus, xhr) {
            if (data.success) {
              alert('Berhasil Dipesan.');
              console.log('Nilai bookingDate:', bookingDate);
              console.log('Nilai #bookingDate:', $('#bookingDate').val());
              window.location.href = 'bayar.php';
            } else {
              alert('Gagal menyimpan pemesanan. Error: ' + data.error);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Request Error:');
            console.error('Status:', status);
            console.error('Error:', error);
            // Optional: Log the response text if available
            if (xhr.responseText) {
              console.error('Response Text:', xhr.responseText);
            }

            // Optional: Show an alert or handle the error in another way
            alert('Terjadi kesalahan saat menyimpan pemesanan. Lihat konsol untuk detail.');

            // NEW: Log the data sent in the request
            console.log('Data yang dikirim:', {
              bookingDate: bookingDate,
              startTime: startTime,
              endTime: endTime,
              harga: harga,
              idlap: idlap,
              iduser: iduser
            });
          }
        });
      }

      $(document).on('submit', '#bookingForm', function(event) {
        event.preventDefault();
        submitBookingForm(); // Panggil fungsi pengiriman formulir kustom
      });


      var bookedDatesMap = {};

      $(document).ready(function() {
        <?php foreach ($lapangan as $row) : ?>
          var idlap = <?= $row["idlap"]; ?>;
          updateButtonsForDate(idlap);
        <?php endforeach ?>
      });



      function updateButtonsForDate(idlap) {
        var buttons = $('#pesanModal' + idlap + ' button[data-start-time]');
        var selectedDate = $('#pesanModal' + idlap + ' #bookingDate').val();

        buttons.each(function() {
          var startTime = $(this).attr('data-start-time');

          // Periksa apakah waktu sudah dipesan
          if (isTimeRangeBooked(selectedDate, startTime)) {
            $(this).prop('disabled', true);
          } else {
            $(this).prop('disabled', false);
          }
        });
      }




      function checkAllTimes(selectedDate, idlap) {
        var buttons = $('#pesanModal' + idlap + ' button[data-start-time]');
        buttons.each(function() {
          var startTime = $(this).attr('data-start-time');

          // Check if the time range is booked
          if (isTimeRangeBooked(selectedDate, startTime)) {
            $(this).prop('disabled', true);
          } else {
            $(this).prop('disabled', false);
          }
        });
      }




      function isTimeRangeBooked(selectedDate, startTime) {
        var bookedTimeRanges = bookedDatesMap[selectedDate] || [];
        console.log('Selected Date:', selectedDate);
        console.log('Start Time:', startTime);

        for (var i = 0; i < bookedTimeRanges.length; i++) {
          var bookedStartTime = bookedTimeRanges[i].start_time;
          var bookedEndTime = bookedTimeRanges[i].end_time;


          // Konversi waktu menjadi objek Date untuk perbandingan yang lebih baik
          var selectedDateTime = new Date(selectedDate + ' ' + startTime);
          var bookedStartDateTime = new Date(selectedDate + ' ' + bookedStartTime);
          var bookedEndDateTime = new Date(selectedDate + ' ' + bookedEndTime);
          console.log('Booked Start Time:', bookedStartTime);
          console.log('Booked End Time:', bookedEndTime);

          // Periksa apakah waktu yang dipilih berada dalam rentang waktu yang sudah dipesan
          if (selectedDateTime >= bookedStartDateTime && selectedDateTime < bookedEndDateTime) {
            return true; // Ada tumpang tindih, rentang waktu sudah dipesan
          }
        }

        return false; // Tidak ada tumpang tindih, rentang waktu tersedia
      }


      function getBookedDates(idlap) {
        $.ajax({
          url: 'backend.php?action=getBookedDates&idlap=' + idlap,
          method: 'GET',
          success: function(data) {
            console.log('Data tanggal yang sudah dipesan:', data.dates);
            bookedDatesMap = {};
            data.dates.forEach(function(date) {
              bookedDatesMap[date.date] = bookedDatesMap[date.date] || [];
              bookedDatesMap[date.date].push({
                start_time: date.start_time,
                end_time: date.end_time
              });
            });

            // Perbarui tombol-tombol setelah mendapatkan data tanggal yang sudah dipesan
            updateButtonsForDate(idlap);
          },
          error: function(error) {
            console.error('Error saat mengambil tanggal yang sudah dipesan:', error);
          }
        });
      }




      $(document).on('change', '#bookingDate', function() {
        var selectedDate = $(this).val();
        var idlap = $(this).closest('.modal').attr('id').replace('pesanModal', '');
        document.getElementById('selectedDate').value = selectedDate;

        // After updating the selected date, call the functions to update buttons and check all times
        updateButtonsForDate(idlap);
        checkAllTimes(idlap);
      });

      getBookedDates(function(bookedDates) {
        // Update this line
        updateButtonsForDate(selectedIdlap);
        checkAllTimes(selectedIdlap);
      });



      // 
    </script>
</body>

</html>