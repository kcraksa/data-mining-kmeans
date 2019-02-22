<?php
  include '../proses/connect.php';

  session_start();

  // Cek session
  if (!isset($_SESSION['level'])) {
    header("location: index.php");
  } else {

  $data = [296, 317, 330, 456, 517];
  $tahun = [2012, 2013, 2014, 2015, 2016, 2017, 2018];

    // Inisialisasi Awal
    $at = array(); // Nilai Kesalahan Absolut ke-t
    $mt = array(); // Nilai Pemulusan Absolut ke-t
    $ct = array(); // Nilai Konstanta ke-t
    $et = array(); // Nilai Error ke-t
    $ea = array(); // Nilai Error Absolut
    $ea2 = array(); // Nilai Error Absolute Kuadrat
    $pe = array(); // Hitung Persentage Error
    $hasilForecast = array(); //Untuk menampung hasil forecast

    $hasilForecast[0] = "-";
    $hasilForecast[1] = array_sum($data) / count($data);
    $at[0] = "-"; $mt[0] = "-"; $ct[0] = "-"; $ct[1] = 0.20; $beta = 0.50; $et[0] = "-";

    for ($k=0; $k < count($data); $k++) {
      if ($k > 0) {
        // Hitung Forecast
        $hitungForecast = $ct[$k] * $data[$k] + (1 - $ct[$k]) * $hasilForecast[$k];
        $nff = number_format($hitungForecast, 1);
        array_push($hasilForecast, $nff);

        // Hitung E
        $hitungE = $data[$k] - $hasilForecast[$k];
        $nfe = number_format($hitungE, 1);
        array_push($et, $nfe);
        array_push($ea, abs($nfe));
        array_push($ea2, pow($nfe, 2));
        array_push($pe, $nfe/$data[$k] * 100/100);

        // Hitung A
        $hitungA = $beta * $et[$k] + (1 - $beta) * $at[$k - 1];
        $nfa = number_format($hitungA, 1);
        array_push($at, $nfa);

        // Hitung M
        $hitungM = $beta * abs($et[$k]) + (1 - $beta) * $mt[$k - 1];
        $nfm = number_format($hitungM, 1);
        array_push($mt, $nfm);

        // Hitung Alpha
        $HitungAlpha = abs($at[$k] / $mt[$k]);
        $nfal = number_format($HitungAlpha, 2);
        array_push($ct, $nfal);
      }
    }
    array_push($data, "-");
    array_push($et, "-");
    array_push($at, "-");
    array_push($mt, "-");
    array_push($ct, "-");
  /* $getTahun = mysqli_query($con, "SELECT DISTINCT year(tanggal_daftar) AS tahun FROM mahasiswa");
  while ($r = mysqli_fetch_assoc($getTahun)) {
    $tahun[] = $r['tahun'];
    sort($tahun);
  }

  // Get data
  // Tahunan
   for ($i=0; $i < count($tahun); $i++) {
    if ($i < 2) {
      $thnDepan = $i + 1;
      $sqlTahunan = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM mahasiswa WHERE tanggal_daftar BETWEEN '".$tahun[$i]."-09-01' AND '".$tahun[$thnDepan]."-09-01'");
      while ($rs = mysqli_fetch_assoc($sqlTahunan)) {
        $jumlahMhs[] = $rs['jumlah'];
      }
    } elseif ($i == 2) {
      break;
    }
  }

  // Get Data Bulanan
  $total = array();
  $jumlahData = array();
  for ($i=0; $i < count($tahun); $i++) {
    $s = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM mahasiswa WHERE year(tanggal_daftar) = '$tahun[$i]' GROUP BY month(tanggal_daftar)");
    while ($r = mysqli_fetch_assoc($s)) {
      $nilai[$tahun[$i]][] = $r['jumlah'];
    }
    array_push($total, array_sum($nilai[$tahun[$i]]));
    array_push($jumlahData, count($nilai[$tahun[$i]]));
  }
  $rata2bulanan = array_sum($total) / array_sum($jumlahData);

  // Get Bulan
  for ($i=0; $i < count($tahun); $i++) {
    $b = mysqli_query($con, "SELECT month(tanggal_daftar) AS bulan FROM mahasiswa WHERE year(tanggal_daftar) = '$tahun[$i]' GROUP BY month(tanggal_daftar)");
    while ($bl = mysqli_fetch_assoc($b)) {
      $bulan[$tahun[$i]][] = $bl['bulan'];
    }
  } */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Forecast Data</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/input.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/highcharts.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  </head>
  <style media="screen">
    body {
      margin-top: 70px;
      text-align: center;
    }
    .table > thead > tr > th {
      text-align: center;
    }
    .jumbotron {
      text-align: center;
      background: #fff;
      -webkit-box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
      -moz-box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
      box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
    }
    #container {
      -webkit-box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
      -moz-box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
      box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
    }
  </style>
  <body>
    <?php include 'navbar.php'; ?>
    <h3 style="margin-bottom: 20px;">FORECAST DATA DENGAN METODE <i>EXPONENTIAL SMOOTHING</i></h3>
    <div class="container">
      <div class="col-md-12">
        <div id="container">

        </div>
        <BR />
        <div class="jumbotron" style="border-radius: 0;">
          <h4>FORECASTING</h4>
          <hr>
          <table class="table table-bordered">
            <thead>
              <th>Tahun Akademik</th>
              <th>Data Aktual</th>
              <th>Forecast</th>
              <th><i>E</i><i style="font-size: 8pt;">t</i></th>
              <th><i>A</i><i style="font-size: 8pt;">t</i></th>
              <th><i>M</i><i style="font-size: 8pt;">t</i></th>
              <th><i>α</i><i style="font-size: 8pt;">t</i></th>
            </thead>
            <tbody>
              <?php
                for ($tb=0; $tb < count($data); $tb++) {
                  echo "<tr>
                  <td>".$tahun[$tb]."/".$tahun[$tb + 1]."</td>
                  <td>".$data[$tb]."</td>
                  <td>".$hasilForecast[$tb]."</td>
                  <td>".$et[$tb]."</td>
                  <td>".$at[$tb]."</td>
                  <td>".$mt[$tb]."</td>
                  <td>".$ct[$tb]."</td>
                  </tr>";
                }
              ?>
            </tbody>
          </table>
          <?php
            // Hitung MAD
            $mad = array_sum($ea) / 4;

            // Hitung MSE
            $mse = array_sum($ea2) / 4;

            // Hitung MAPE
            $mape = array_sum($pe) / 4;
          ?>
          <h4>PERHITUNGAN KESALAHAN RAMALAN</h4>
          <hr>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>MAD</th>
                <th>MSE</th>
                <th>MAPE</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo number_format($mad, 2); ?></td>
                <td><?php echo $mse; ?></td>
                <td><?php echo number_format($mape, 2)."%"; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-12">
        <script type="text/javascript">
    			$(function () {
    			    Highcharts.chart('container', {
    			        title: {
    			            text: 'Forecasting Data Pendaftar UMB Kampus D',
    			            x: -20 //center
    			        },
    			        xAxis: {
    			            categories: ['2012/2013', '2013/2014', '2014/2015', '2015/2016', '2016/2017']
    			        },
    			        yAxis: {
    			            title: {
    			                text: 'Jumlah Mahasiswa'
    			            },
    			            plotLines: [{
    			                value: 0,
    			                width: 1,
    			                color: '#808080'
    			            }]
    			        },
    			        tooltip: {
    			            valueSuffix: '°C'
    			        },
    			        legend: {
    			            layout: 'vertical',
    			            align: 'right',
    			            verticalAlign: 'middle',
    			            borderWidth: 0
    			        },
    			        series: [{
                    name: 'Data Aktual',
                    data: [296, 317, 330, 456, 517]
    			        }, {
                    name: 'Forecasting',
                    data: [383.2, 370, 330, 456, 489.6]
    			        }]
    			    });
    			});
    		</script>

        <div class="jumbotron" style="text-align: justify; border-radius: 0; margin-top: 15px; padding: 40px;">
          <p align="center">Keterangan</p>
          <hr>
          Berikut ini adalah peramalan jumlah pendaftar untuk TA 2017/2018 berdasarkan data TA sebelumnya.
          Peramalan ini menggunakan metode <i>Exponential Smoothing</i> dengan ARRSES. Untuk mengukur kualitas ramalan
          digunakan metode MAD, MSE, dan MAPE yang menghasilkan nilai MAD : <?php echo $mad; ?>, MSE : <?php echo $mse; ?> dan MAPE : <?php echo number_format($mape, 2)."%"; ?> yang berarti permalan data pendaftaran
          tahunan Universitas Mercu Buana Kampus D menggunakan metode <i>Exponential Smoothing</i> adalah metode yang tepat karena Persentase keakuratannya <?php echo 100 - number_format($mape, 2)."%"; ?>.
        </div>
      </div>
    </div>
  </body>
</html>
<?php } ?>
