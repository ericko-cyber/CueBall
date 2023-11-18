<?php
// session_start();
include_once(__DIR__ . '/../functions.php');
include_once(__DIR__ . '/../session.php');
include_once(__DIR__ . '/../database.php');
if ($role !== 'Admin') {
  header("location:../login.php");
}

$lapangan = query("SELECT COUNT(idlap) AS jml_lapangan FROM lapangan")[0];
$user = query("SELECT COUNT(id_user) AS jml_user FROM user")[0];
$stok = query("SELECT SUM(idmakanan) AS jml_makanan FROM makanan")[0];
$pesanan = query("SELECT COUNT(idbayar) AS jml_sewa FROM bayar")[0];
$besar = query("SELECT COUNT(*) as jumlah_meja_besar FROM lapangan INNER JOIN sewa ON lapangan.idlap = sewa.idlap WHERE lapangan.ket = 'meja besar'; ")[0];
$kecil = query("SELECT COUNT(*) as jumlah_meja_kecil FROM lapangan INNER JOIN sewa ON lapangan.idlap = sewa.idlap WHERE lapangan.ket = 'meja kecil';")[0];


$sqlBulan = "SELECT MONTHNAME(tgl_pesan) AS bulan FROM sewa GROUP BY MONTH(tgl_pesan) ORDER BY MONTH(tgl_pesan)";
$resultBulan = $conn->query($sqlBulan);

// Query untuk mendapatkan total sewa
  $sqlTotalSewa = "SELECT MONTHNAME(tgl_pesan) AS bulan, SUM(tot) AS total_sewa FROM sewa GROUP BY MONTH(tgl_pesan) ORDER BY MONTH(tgl_pesan)";
  $sqlTotalpesan = "SELECT MONTHNAME(tgl_pesan) AS bulan, SUM(tot) AS total_sewa FROM keranjang GROUP BY MONTH(tgl_pesan) ORDER BY MONTH(tgl_pesan)";
  $resultTotalSewa = $conn->query($sqlTotalSewa);
  $resultTotalpesan = $conn->query($sqlTotalpesan);

  $labels = [];
  $totalSewa = [];
  $totalpesan = [];

  while ($rowBulan = $resultBulan->fetch_assoc()) {
    $bulan = $rowBulan['bulan'];
    $labels[] = $bulan;

    // Inisialisasi total_sewa untuk setiap bulan menjadi 0
    $totalSewa[$bulan] = 0;
    $totalpesan[$bulan] = 0;
  }

  while ($rowTotalSewa = $resultTotalSewa->fetch_assoc()) {
    $bulan = $rowTotalSewa['bulan'];
    $totalSewa[$bulan] = $rowTotalSewa['total_sewa'];
  }
  while ($rowTotalpesan = $resultTotalpesan->fetch_assoc()) {
    $bulan = $rowTotalpesan['bulan'];
    $totalpesan[$bulan] = $rowTotalpesan['total_sewa'];
  }

?>

  <link rel="stylesheet" href="../css/form.css">
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css">
  <link rel="stylesheet" href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css">
  <link rel="stylesheet" href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/soft-ui-dashboard.min.css?v=1.0.2">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <h1 class="text" style="font-size: 40px; padding-left: 30px; margin-bottom: 0px;">Dashboard</h1>

  <div class="container-fluid pt-1">
    <div class="row removable">
      <div class="col-xl-3 col-sm-6">
        <div class="card bg-gradient-white mb-4" style="background: linear-gradient(to right, #DBE9F3, #5175A7);">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize " style="color: #4B4B4B; font-weight: bold;">Jumlah Meja</p>
                  <h5 class="font-weight-bolder mb-0" style="color: #4B4B4B; font-weight: bold;">
                    <?= $lapangan["jml_lapangan"]; ?>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-app text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card mb-4" style="background: linear-gradient(to right, #DBE9F3, #5175A7);">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize" style="color: #4B4B4B; font-weight: bold;">Jumlah sewa</p>
                  <h5 class="font-weight-bolder mb-0" style="color: #4B4B4B; font-weight: bold;">
                    <?= $pesanan["jml_sewa"]; ?>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card mb-4" style="background: linear-gradient(to right, #DBE9F3, #5175A7);">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize" style="color: #4B4B4B; font-weight: bold;">Jumlah user</p>
                  <h5 class="font-weight-bolder mb-0" style="color: #4B4B4B; font-weight: bold;">
                    <?= $user["jml_user"]; ?>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card mb-4" style="background: linear-gradient(to right, #DBE9F3, #5175A7);">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize" style="color: #4B4B4B; font-weight: bold;">Stok </p>
                  <h5 class="font-weight-bolder mb-0" style="color: #4B4B4B; font-weight: bold;">
                    <?= $stok["jml_makanan"]; ?>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-shop text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-container">
  <!-- Kartu Pertama -->
  <div class="card shadow mb-4" id="myLineChartCard">
    <!-- Card Header - Dropdown -->
    <canvas id="myLineChart" width="900" height="400"></canvas>
  </div>

  <!-- Kartu Kedua -->
  <div class="card shadow mb-4" id="myPieChartCard">
    <!-- Card Header - Accordion -->
    <canvas id="myPieChart" width="290" height="400"></canvas>
  </div>
    </div>
  </div>
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../script.js"></script>

  <script>
    function handleHover(evt, item, legend) {
      legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
        colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
      });
      legend.chart.update();
    }
    function handleLeave(evt, item, legend) {
      legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
        colors[index] = color.length === 9 ? color.slice(0, -2) : color;
      });
      legend.chart.update();
    }
    const data = {
      labels: ['Meja Besar', 'Meja Kecil'],
      datasets: [{
        label: '# Total',
        data: [
          <?= $besar["jumlah_meja_besar"]; ?>,
          <?= $kecil["jumlah_meja_kecil"]; ?>
        ],
        borderWidth: 1,
        backgroundColor: ['#FFD369', '#393E46'],
      }]
    };
    var pieCtx = document.getElementById('myPieChart').getContext('2d');
    var pieChart = new Chart(pieCtx, {
      type: 'pie',
      data: data,
      options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            onHover: handleHover,
            onLeave: handleLeave
          }
        }
      }
    });
  </script>

  <script>
    const DATA_COUNT = 12;
    const NUMBER_CFG = {
      count: DATA_COUNT,
      min: -100,
      max: 100
    };

    const lineLabels = <?php echo json_encode($labels); ?>;
    const lineData = {
      labels: lineLabels,
      datasets: [{
        label: 'Meja',
        data: <?php echo json_encode(array_values($totalSewa)); ?>,
        borderColor: 'red',
        backgroundColor: 'rgba(255, 0, 0, 0.5)',
      },{
      label: 'Makanan',
      data: <?php echo json_encode(array_values($totalpesan)); ?>,
      borderColor: 'blue',
      backgroundColor: 'rgba(0, 0, 255, 0.5)',

    }]
    };

    // Add the following code to create a new Chart instance using the provided data
    var lineCtx = document.getElementById('myLineChart').getContext('2d');

    var lineChart = new Chart(lineCtx, {
      type: 'line',
      data: lineData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: '{PENDAPATAN}',
          },
        },
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  </script>
