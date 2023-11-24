<?php
session_start();
require "functions.php";

$id_user = $_SESSION["id_user"];

$profil = query("SELECT * FROM user WHERE id_user = '$id_user'")[0];

if (isset($_POST['add_to_cart'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = 1;

  // Ambil id_user dari sesi
  $id_user = $_SESSION['id_user'];

  // Periksa apakah produk sudah ada dalam keranjang pengguna
  $select_cart = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE iduser = '$id_user' AND nama = '$product_name'");

  if (mysqli_num_rows($select_cart) > 0) {
    $message[] = 'Product already added to the cart.';
  } else {
    // Tambahkan produk ke keranjang pengguna
    $insert_product = mysqli_query($conn, "INSERT INTO `keranjang` (iduser, nama, harga, gambar, jumlah) VALUES ('$id_user', '$product_name', '$product_price', '$product_image', '$product_quantity')");

    if ($insert_product) {
      $message[] = 'Product added to the cart successfully.';
    } else {
      $message[] = 'Error adding product to the cart.';
    }
  }
}


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
?>
<?php
$select_products = mysqli_query($conn, "SELECT * FROM `makanan`");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Basecamp Billiard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!--font awesome-->
  <script src="https://kit.fontawesome.com/ab6316514a.js" crossorigin="anonymous"></script>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- FAS-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofGJ+fcF5t5z2msFb9gfHJCDGpD2be" crossorigin="anonymous">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
      <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
      <h1 class="logo me-auto"><a href="index.html">BASECAMP</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li class="dropdown"><a href="#table"><span>Book</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <div class="buttons">
                <?php
                if (isset($_SESSION['id_user'])) {
                  // jika user telah login, tampilkan tombol profil dan sembunyikan tombol login
                  echo '<li><a href="user/lapangan.php">Book Table</a></li>';
                } else {
                  // jika user belum login, tampilkan tombol login dan sembunyikan tombol profil
                  echo '<li><a href="#table">Book Table</a></li>';
                }
                ?>
              </div>
              <li><a href="#fnb">Book Beverage</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <?php
          if (isset($_SESSION['id_user'])) {
            $id_user = $_SESSION['id_user'];
            $stmt = mysqli_prepare($conn, "SELECT * FROM `keranjang` WHERE iduser = ?");
            mysqli_stmt_bind_param($stmt, "i", $id_user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row_count = mysqli_num_rows($result);
            echo '<a href="user/keranjang.php" class="cart-icon" id="keranjang"><i class="bi bi-cart getstarted scrollto"> <span>' . $row_count . '</span></i></a>';
            echo '<a href="user/profil.php" data-bs-toggle="modal" data-bs-target="#profilModal" class="getstarted scrollto"><i data-feather="user"></i></a>';
          } else {

            echo '<a href="login.php" class="btn btn-inti getstarted scrollto" type="submit" >Login</a>';
          }
          ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- modal profil -->
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
                <img src="/img/<?= $profil["foto"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col-8">
                <h5 class="mb-3"><?= $profil["nama_lengkap"]; ?></h5>
                <p><?= $profil["jenis_kelamin"]; ?></p>
                <p><?= $profil["email"]; ?></p>
                <p><?= $profil["hp"]; ?></p>
                <p><?= $profil["alamat"]; ?></p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
                <a href="" data-bs-toggle="modal" data-bs-target="#editProfil" class="btn btn-success">Edit Profil</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal profile end -->

  <!-- Edit profil -->
  <div class="modal fade" id="editProfil" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
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
                <img src="/img/<?= $profil["foto"]; ?>" alt="Foto Profil" class="img-fluid ">
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
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success" name="simpan" id="simpan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Edit Modal -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Basecamp <span>Billiard</span></h1>
          <h2>Your favorite Billiards place in town!</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="#about" class="btn-get-started scrollto">Get Started</a>
            <a href="" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="assets/img/ebout.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">


    <!-- ======= About Us Section ======= -->
    <section id="about" class="about" style="top: 70px;">
      <div class="container" data-aos="fade-up">

        <div class="section-title" style="margin-top: 50px;">
          <h2>ABOUT<span> US</span></h2>
        </div>

        <div class="row content">
          <div class="col-lg-6">
            <p>
              Selamat datang di Basecamp Billiard, pilihan yang tepat untuk para pecinta Billiard yang mencari
              pengalaman bermain billiard yang tak terlupakan. Kami adalah pusat hiburan Billiard yang menyediakan fasilitas
              berkualitas tinggi, suasana yang ramah, dan layanan pelanggan terbaik. Dengan koleksi meja Billiard yang
              modern dan nyaman, Basecamp Billiard menjadi tempat ideal untuk bertemu teman, merayakan momen spesial,
              atau sekadar melepaskan stres setelah hari yang sibuk. Kami berkomitmen untuk memberikan pengalaman
              bermain billiard yang menyenangkan dan memuaskan bagi setiap pelanggan. Selamat datang di Basecamp
              Billiard, di mana kegembiraan dan persaingan bisa kamu temukan disini!
            </p>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <ul>
              <li><i class="ri-check-double-line"></i> Mengutamakan kenyamanan pelanggan</li>
              <li><i class="ri-check-double-line"></i> Menyediakan minuman dan snack dengan harga terjangkau</li>
              <li><i class="ri-check-double-line"></i> Berada di tempat strategis, area kota dan dekat dengan kampus
              </li>
            </ul>
          </div>
        </div>

      </div>
    </section>
    <!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>OUR<span> SERVICES</span></h2>
          <p>Berikut ini adalah fasilitas-fasilitas yang diberikan oleh Basecamp Billiard untuk kenyamanan para
            pelanggan.</p>
        </div>

        <div class="row">
          <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="assets/img/toilet.png"></div>
              <h4><a href="">Toilet</a></h4>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="assets/img/sofa.png"></div>
              <h4><a href="">Sofa dan Meja</a></h4>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="assets/img/ac.png"></div>
              <h4><a href="">Ruang Ber-AC</a></h4>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
            <div class="icon-box">
              <div class="img-area mb-4"><img alt="" class="img-fluid" src="assets/img/parkiran.png"></div>
              <h4><a href="">Tempat Parkir</a></h4>
            </div>
          </div>

        </div>

      </div>
    </section>
    <!-- End Services Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">
        <div class="row">
          <div class="col-lg-9 text-center text-lg-start">
            <h3>Call To Action</h3>
            <p> Rasakan kemudahan dalam memesan meja dan snack yang kami sediakan dengan menjadi User di Website kami.
              Register sekarang!</p>
          </div>
          <div class="col-lg-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="#">Call To Action</a>
          </div>
        </div>

      </div>
    </section><!-- End Cta Section -->


    <!-- ======= Table Section ======= -->
    <section id="table" class="table">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Table</h2>
          <p>Kami menyediakan 2 jenis meja yang dapat kamu pilih, dengan harga terjankau serta kualitas yang selalu
            terjaga.</p>
        </div>

        <div class="row">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="box">
              <h3>Small Table</h3>
              <h4>12k<span>/hour</span></h4>
              <ul>
                <li><i class="bx bx-check"></i> More Practical </li>
                <li><i class="bx bx-check"></i> Easy for Beginner </li>
              </ul>
              <div class="buttons">
                <?php
                if (isset($_SESSION['id_user'])) {
                  // jika user telah login, tampilkan tombol profil dan sembunyikan tombol login
                  echo '<a href="user/lapangan.php" class="buy-btn">Book Now!</a>';
                } else {
                  // jika user belum login, tampilkan tombol login dan sembunyikan tombol profil
                  echo '<a href="login.php" class="buy-btn">Book Now!</a>';
                }
                ?>
              </div>
            </div>
          </div>


          <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
            <div class="box">
              <h3>Big Table</h3>
              <h4>25k<span>/hour</span></h4>
              <ul>
                <li><i class="bx bx-check"></i> The Bigger, The Better</li>
                <li><i class="bx bx-check"></i> Suitable for Competition </li>
              </ul>
              <div class="buttons">
                <?php
                if (isset($_SESSION['id_user'])) {
                  // jika user telah login, tampilkan tombol profil dan sembunyikan tombol login
                  echo '<a href="user/lapangan.php" class="buy-btn">Book Now!</a>';
                } else {
                  // jika user belum login, tampilkan tombol login dan sembunyikan tombol profil
                  echo '<a href="login.php" class="buy-btn">Book Now!</a>';
                }
                ?>
              </div>
            </div>
          </div>


        </div>

      </div>
    </section>
    <!-- End Table Section -->

    <!-- ======= Beverage and Snack Section ======= -->
    <section id="fnb" class="fnb section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title" style="margin-top: 30px;">
          <h2>Beverage <span>and</span> Snack</h2>
          <p>Di sela-sela bermainmu, kamu juga bisa memesan makanan dan minuman yang telah kami sediakan.</p>
        </div>
        <section class="product_section">
          <div class="container">
            <div class="row mx-0">
              <?php
              if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_products)) {
              ?>
                  <div class="col-lg-3 box">
                    <form action="" method="post">
                      <div class="card product-card" data-name="1">
                        <div class="product-img">
                          <img src="/img/<?php echo $fetch_product['foto']; ?>" alt="">
                        </div>
                        <div class="name-product"><?php echo $fetch_product['nm']; ?></div>
                        <div class="price-product">Rp <?php echo $fetch_product['harga']; ?>/-</div>
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['nm']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['harga']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['foto']; ?>">
                        <div class="buttons">
                          <?php
                          if (isset($_SESSION['id_user'])) {
                            // jika user telah login, tampilkan tombol profil dan sembunyikan tombol login
                            echo '<input type="submit" class="btn btn-warning" value="add to cart" name="add_to_cart">';
                          } else {
                            // jika user belum login, tampilkan tombol login dan sembunyikan tombol profil
                            echo '<a href="login.php" class="btn btn-warning">Add to Cart</a>';
                          }
                          ?>
                        </div>
                    </form>
                  </div>
            </div>
        <?php
                }
              }
        ?>
          </div>
      </div>
    </section>



    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Bagaimana caranya agar kamu dapat terus ber interkasi dengan kami?</p>
        </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>Jalan Riau 15GG Krajan Barat, Sumbersari, Jember</p>
              </div>

              <div class="email">
                <i class="bx bxl-instagram"></i>
                <h4>Instagram:</h4>
                <p>@basecampbilliard21</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+1 5589 55488 55s</p>
              </div>
            </div>
          </div>
          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15797.361519891363!2d113.7228033!3d-8.1684213!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd69562bda2e9cd%3A0xe42e8a1c6c620426!2sBilliard%20Basecamp!5e0!3m2!1sen!2sid!4v1699982757064!5m2!1sen!2sid" frameborder="0" style="border:0; width: 100%; height: 320px;" allowfullscreen></iframe>
          </div>
        </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <div class="subcribe">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <h4>Join Our Family with Click The Button Below</h4>
            <li><a class="getstarted scrollto" href="login.php">Subscribe</a></li>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/menu.js" defer></script>

</body>
<script>
  feather.replace();
</script>

</html>