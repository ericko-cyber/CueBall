<?php
session_start();
require "../functions.php";
require "../session.php";

if ($role !== 'User') {
  header("location:../login.php");
}

$id = $_SESSION["id_user"];

$lapangan = query("SELECT * FROM meja");
$modal = query("SELECT * FROM meja where idmeja");
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


// if (isset($_POST["pesan"])) {
//   if (pesan($_POST) > 0) {
//     echo "<script>
//           alert('Berhasil DiPesan');
//           document.location.href = 'bayar.php';
//           </script>";
//   } else {
//     echo "<script>
//           alert('Gagal DiPesan');
//           </script>";
//   }
// }



?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book Table</title>
  <link rel="stylesheet" href="../css/lapangan.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- Favicons -->
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/logo.png" rel="apple-touch-icon">

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
      color: #666;
      cursor: not-allowed;
    }

    button.selected:disabled {
      background-color: #3498db;
      color: #ffffff;
      cursor: not-allowed;
    }

    button {
      background-color: #0A0A0A;
      color: #fff;
      padding: 10px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 5px;
    }

    button.selected {
      background-color: #FFBB35;
      color: #ffffff;
    }

    /* Kursor pointer saat di atas tombol */
    button:hover {
      cursor: pointer;
    }

    /* Gaya saat tombol ditekan */
    button:active {
      background-color: #FFBB35;
      /* Ganti warna sesuai kebutuhan */
      color: #ffffff;
    }
  </style>
</head>

<body style="background-color: black">
  <!-- Navbar -->
  <div class="container ">
    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: black;">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="../assets/img/logo.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" style="background-color: white;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="../index.php">Home</a>
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
        </div>
      </div>
    </nav>
  </div>
  <!-- End Navbar -->

  <section class="lapangan" id="lapangan" style="margin-top: 20px">
    <div class="container">
      <main class="contain" data-aos="fade-right" data-aos-duration="1000">
        <h2 class="text-head" style=" color:#ccc; margin-bottom: 30px"> Choose <span>Your</span> Table! </h2>
        <div class="row row-cols-1 row-cols-md-4">
          <?php foreach ($lapangan as $row) : ?>
            <div class="col" style="padding-bottom: 10px;">
              <div class="card">
                <img src="../img/<?= $row["foto"]; ?>" alt="gambar lapangan" class="card-img-top">
                <div class="card-body text-center">
                  <h5 class="card-title"><?= $row["nm"]; ?></h5>
                  <p class="card-text"><?= $row["ket"]; ?></p>
                  <p class="card-price"><?= $row["harga"]; ?></p>
                  <!-- <a href="jadwal.php?id=<?= $row["idmeja"]; ?>" type="button" class="btn btn-secondary">Jadwal</a> -->
                  <button type="button" class="btn btn-inti" data-bs-toggle="modal" data-bs-target="#pesanModal<?= $row["idmeja"]; ?>" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" style="background-color: #ffbb35;">Book</button>
                </div>
              </div>
            </div>

            <!-- Modal Pesan -->
            <div class="modal fade" id="pesanModal<?= $row["idmeja"]; ?>" data-idmeja="<?= $row["idmeja"]; ?>" data-debug="true" tabindex="-1" aria-labelledby="pesanModalLabel<?= $row["idmeja"]; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel<?= $row["idmeja"]; ?>">Book <?= $row["nm"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="bookingForm">
                    <div class="modal-body">
                      <!-- konten form modal -->
                      <div class="row justify-content-center align-items-center">
                        <div class="mb-3">
                          <img src="../img/<?= $row["foto"]; ?>" alt="gambar lapangan" class="img-fluid" style="left: 20%; position: relative;">
                        </div>
                        <div class="text-left">
                          <h6 name="harga" class="form-control bookingDate" id="harga">Harga : <?= $row["harga"]; ?></h6>
                        </div>
                        <div class="col">
                          <label for="bookingDate">Pilih Tanggal:</label>
                          <input type="date" class="form-control bookingDate" id="bookingDate" name="bookingDate" required>
                        </div>
                        <div class="mb-3">
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="12:00">12:00-13:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="13:00">13:00-14:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="14:00">14:00-15:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="15:00">15:00-16:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="16:00">16:00-17:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="17:00">17:00-18:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="18:00">18:00-19:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="19:00">19:00-20:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="20:00">20:00-21:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="21:00">21:00-22:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="22:00">22:00-23:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="23:00">23:00-24:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="00:00">00:00-01:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="01:00">01:00-02:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="02:00">02:00-03:00</button>
                          <button type="button" onclick="handleTimeButtonClick(<?= $row["idmeja"]; ?>)" data-time="03:00">03:00-04:00</button>
                          <br>
                          <input type="hidden" id="selectedDate" name="selectedDate" value="">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-inti btn btn-warning" onclick="submitBookingForm('<?= $row["idmeja"]; ?>', event)">Book</button>
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

  <script>
    var selectedTimes = [];

    function getBookedDates(idmeja) {
      console.log('getBookedDates called for idmeja:', idmeja);
      console.log('JavaScript file loaded');

      var modalElement = $('#pesanModal' + idmeja);
      console.log('Modal Element:', modalElement);
      $.ajax({
        url: 'backend.php?action=getBookedDates&idmeja=' + idmeja,
        method: 'GET',
        success: function(data) {
          console.log('Data tanggal yang sudah dipesan:', data.bookedDates);

          // Inisialisasi objek untuk menyimpan data tanggal yang sudah dipesan
          var bookedDatesMap = {};

          // Loop melalui data.bookedDates dan tambahkan data ke bookedDatesMap
          data.bookedDates.forEach(function(date) {
            var formattedDate = date.tanggal;
            bookedDatesMap[formattedDate] = bookedDatesMap[formattedDate] || [];
            bookedDatesMap[formattedDate].push({
              jam: date.jam,
              // Tambahkan properti lain jika diperlukan
            });
          });

          // Perbarui tombol-tombol setelah mendapatkan data tanggal yang sudah dipesan
          updateButtonsForDate(idmeja, bookedDatesMap);
        },
        error: function(error) {
          console.error('Error saat mengambil tanggal yang sudah dipesan:', error);
        }
      });
    }

    var debugValue = $(this).closest('.modal').data('debug');
    console.log('Debug Value:', debugValue);

    // Pastikan event handler berada dalam loop yang mencakup setiap modal
    $('[id^=pesanModal]').on('shown.bs.modal', function() {
      // Handle event, contohnya:
      var idmeja = $(this).data('idmeja');
      console.log('Modal shown for idmeja:', idmeja);
      getBookedDates(idmeja);
    });



    $(document).on('change', '.modal .bookingDate', function() {
      console.log('Change event triggered');
      var selectedDate = $(this).val();
      var idmeja = $(this).closest('.modal').attr('id').replace('pesanModal', '');
      document.getElementById('selectedDate').value = selectedDate;
      console.log('Tanggal yang Dipilih:', selectedDate);
      console.log('ID Meja yang Dikirim:', idmeja);
      getBookedDates(idmeja);
    });


    function updateButtonsForDate(idmeja, bookedDatesMap) {
      console.log('updateButtonsForDate called for idmeja:', idmeja);
      var buttons = $('#pesanModal' + idmeja + ' button[data-time]');
      var selectedDate = $('#pesanModal' + idmeja + ' #bookingDate').val();
      console.log('Selected Date:', selectedDate);
      console.log('Booked Dates Map:', bookedDatesMap);


      buttons.each(function() {
        var startTime = $(this).attr('data-time');

        // Periksa apakah waktu sudah dipesan pada tanggal yang dipilih
        if (bookedDatesMap[selectedDate] && isTimeBooked(bookedDatesMap[selectedDate], startTime)) {
          // Nonaktifkan tombol jika waktu sudah dipesan
          $(this).prop('disabled', true);
        } else {
          // Aktifkan tombol jika waktu belum dipesan
          $(this).prop('disabled', false);
        }
      });
    }



    // Fungsi helper untuk memeriksa apakah waktu sudah dipesan pada suatu tanggal
    function isTimeBooked(bookedDates, time) {
      return bookedDates.some(function(date) {
        return date.jam === time;
      });
    }



    // Fungsi untuk menanggapi pemilihan waktu
    function handleTimeButtonClick(idmeja) {

      console.log('handleTimeButtonClick called with idmeja:', idmeja);

      var button = event.target;
      var selectedTime = button.getAttribute('data-time');
      // var idmeja = idmeja;
      var tanggal = $('#pesanModal' + idmeja + ' #bookingDate').val();
      // var selectedTimes = getSelectedTimes(); // Perbarui nilai selectedTimes

      // Keterangan di log konsol
      console.log("Button clicked - idmeja:", idmeja, "selectedTime:", selectedTime, "tanggal:", tanggal);

      // Periksa apakah tanggal dan jam sudah dipilih
      if (tanggal && selectedTime) {
        // Toggle kelas 'selected' saat tombol diklik
        button.classList.toggle('selected');

        // Periksa apakah tombol dipilih atau tidak, dan tambahkan atau hapus dari array
        if (button.classList.contains('selected')) {
          // Tombol dipilih, tambahkan nilai jam ke array
          selectedTimes.push(selectedTime);
        } else {
          // Tombol tidak dipilih, hapus nilai jam dari array
          var index = selectedTimes.findIndex(item => item === selectedTime);
          if (index !== -1) {
            selectedTimes.splice(index, 1);
          }
        }

        // Tampilkan nilai jam yang dipilih di konsol
        console.log("Selected times:", selectedTimes);
      } else {
        console.log("Please select both date and time before booking.");
      }
    }

    // Fungsi untuk mengirim data ke server
    function submitBookingForm(idmeja, event) {

      console.log('handleTimeButtonClick called with idmeja:', idmeja);

      var bookingDateTime = $('#pesanModal' + idmeja + ' #bookingDate').val();
      var currentDate = new Date();
      var currentTime = currentDate.toTimeString().split(' ')[0]; // Ambil jam dari waktu saat ini


      // Gabungkan tanggal dan waktu saat ini
      var bookingDate = bookingDateTime + ' ' + currentTime;

      console.log('Nilai bookingDate:', bookingDate);
      var hargaText = $('#pesanModal<?= $row["idmeja"]; ?> #harga').text().replace(/[^\d]/g, '');
      var harga = parseInt(hargaText, 10);
      var iduser = <?= $_SESSION["id_user"]; ?>;
      console.log('Isi elemen #pesanModal' + idmeja + ' #bookingDate:', $('#pesanModal' + idmeja + ' #bookingDate').val());


      var selectedTimesString = selectedTimes.map(item => item.selectedTime).join(',');
      console.log(selectedTimesString);
      $.ajax({
        url: 'backend.php?action=saveBooking',
        method: 'POST',
        data: {
          bookingDate: bookingDate,
          harga: harga,
          idmeja: idmeja,
          selectedTimes: selectedTimes,
          selectedTimesString: selectedTimesString,
          iduser: iduser
        },
        success: function(data, textStatus, xhr) {
          if (data.success) {
            alert('Berhasil Dipesan.');
            console.log('Ajax request success. Data:', data);
            window.location.href = 'bayar.php';
          } else {
            alert('Gagal menyimpan pemesanan. Error: ' + data.error);
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Request Error:');
          console.error('Ajax request error:', status, error);
          // Optional: Log the response text if available
          if (xhr.responseText) {
            console.error('Response Text:', xhr.responseText);
          }

          // Optional: Show an alert or handle the error in another way
          alert('Terjadi kesalahan saat menyimpan pemesanan. Lihat konsol untuk detail.');

          // NEW: Log the data sent in the request
          console.log('Data yang dikirim:', {
            bookingDate: bookingDate,
            harga: harga,
            idmeja: idmeja,
            iduser: iduser,
            selectedTimes: selectedTimes
          });
        }
      });
    }
  </script>



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
                <strong>Phone: +62 821-3927-6104</strong><br>
                <i class="bx bxl-instagram"></i>
                <strong>Instagram:</strong> @basecampbilliard21<br>
              </p>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Quick Links</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="../index.php">Home</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="../index.php">About us</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="../index.php">Services</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="../index.php">Book</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="../index.php">Contact</a></li>
              </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="lapangan.php">Table</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="../index.php">Beverage</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="../index.php">Snack</a></li>
              </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Opening Hours</h4>
              <p>Everyday | 12:00 PM - 04:00 AM </p>
              <div class="social-links mt-3">
                <a href="https://instagram.com/basecampbilliard21?igshid=YzAwZjE1ZTI0Zg==" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="https://wa.me/6282139276104" class="google-plus"><i class="bx bxl-whatsapp"></i></a>
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

</body>

</html>