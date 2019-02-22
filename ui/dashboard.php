<?php
include '../proses/connect.php';
session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else { ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard e-Marketing</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/input.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/highcharts.js"></script>
    <script type="text/javascript" src="../js/modules/data.js"></script>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    <div class="container" style="margin-bottom: 50px;">
      <div class="row">
        <div class="col-md-12">
          <?php
            // Cari data tahun terakhir
            $cariTahun = mysqli_query($con, "SELECT max(DISTINCT year(tanggal_daftar)) AS tahun FROM mahasiswa");
            while ($thn = mysqli_fetch_assoc($cariTahun)) {
              $tahun = $thn['tahun'];
            }

            // Mencari Jumlah mahasiswa
            $sqlJmlMhs = mysqli_query($con, "SELECT COUNT(*) AS jumlah_mahasiswa FROM mahasiswa WHERE year(tanggal_daftar) = $tahun");
            while ($r = mysqli_fetch_assoc($sqlJmlMhs)) {
              $jmlMhs = $r['jumlah_mahasiswa'];
            }

            // Mencari Jumlah Penerima Beasiswa & Tidak
            $sqlBeasiswa = mysqli_query($con, "SELECT COUNT(id_status) AS penerima_beasiswa FROM mahasiswa WHERE year(tanggal_daftar) = $tahun  AND id_status = 1");
            while ($rb = mysqli_fetch_assoc($sqlBeasiswa)) {
              $beaYes = $rb['penerima_beasiswa'];
            }

            // Mencari Jumlah Bukan Penerima Beasiswa
            $sqlTdkBeasiswa = mysqli_query($con, "SELECT COUNT(id_status) AS tidak_beasiswa FROM mahasiswa WHERE year(tanggal_daftar) = $tahun AND id_status = 2");
            while ($rtb = mysqli_fetch_assoc($sqlTdkBeasiswa)) {
              $beaNo = $rtb['tidak_beasiswa'];
            }
          ?>
          <h3>Statistik Pendaftar Tahun <?php echo $tahun; ?></h3><br />
          <div class="col-md-4">
            <div class="info-jumlah">
              <span class="label-jml">Jumlah Total Mahasiswa</span><br />
              <span class="jumlahMhs"><?php echo $jmlMhs; ?></span><br />
              Mahasiswa
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-jumlah">
              <span class="label-jml">Jumlah Penerima Beasiswa</span><br />
              <span class="jumlahMhs"><?php echo $beaYes; ?></span><br />
              Mahasiswa
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-jumlah">
              <span class="label-jml">Tidak Menerima Beasiswa</span><br />
              <span class="jumlahMhs"><?php echo $beaNo; ?></span><br />
              Mahasiswa
            </div>
          </div>
          <table id="jml_sekolah" hidden="true">
            <thead>
              <tr>
                <th>Nama Sekolah</th>
                <th>Jumlah Pendaftar</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sqlJumlSkl = mysqli_query($con, "SELECT b.nama_sekolah, COUNT(a.id_sekolah) AS jumlah FROM mahasiswa a INNER JOIN asal_sekolah b ON (a.id_sekolah = b.id_sekolah) WHERE year(a.tanggal_daftar) = '2015' GROUP BY a.id_sekolah ORDER BY jumlah DESC LIMIT 5");
              while ($rjs = mysqli_fetch_assoc($sqlJumlSkl)) {
              ?>
              <tr>
                <td><?php echo $rjs['nama_sekolah']; ?></td>
                <td><?php echo $rjs['jumlah']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <table id="jml_prodi" hidden="true">
            <thead>
              <tr>
                <th>Jurusan</th>
                <th>Jumlah Peminat</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sqlJumProd = mysqli_query($con, "SELECT b.nama_prodi, COUNT(a.id_prodi) AS jumlah FROM mahasiswa a INNER JOIN prodi b ON (a.id_prodi = b.id_prodi) WHERE year(a.tanggal_daftar) = '2015' GROUP BY a.id_prodi ORDER BY jumlah DESC");
              while ($rjp = mysqli_fetch_assoc($sqlJumProd)) {
              ?>
              <tr>
                <td><?php echo $rjp['nama_prodi']; ?></td>
                <td><?php echo $rjp['jumlah']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <table id="jml_pj" hidden="true">
            <thead>
              <tr>
                <th>PJ</th>
                <th>Jumlah Intake</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sqlJumPJ = mysqli_query($con, "SELECT b.nama_pj, COUNT(a.id_pj) AS jumlah FROM mahasiswa a INNER JOIN pj b ON (a.id_pj = b.id_pj) WHERE year(a.tanggal_daftar) = '2015' GROUP BY a.id_pj ORDER BY jumlah DESC");
              while ($rpj = mysqli_fetch_assoc($sqlJumPJ)) {
              ?>
              <tr>
                <td><?php echo $rpj['nama_pj']; ?></td>
                <td><?php echo $rpj['jumlah']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <table id="jml_gel" hidden="true">
            <thead>
              <tr>
                <th>PJ</th>
                <th>Jumlah Intake</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sqlJumGel = mysqli_query($con, "SELECT b.nama_gelombang, COUNT(a.id_gelombang) AS jumlah FROM mahasiswa a INNER JOIN gelombang_masuk b ON (a.id_gelombang = b.id_gelombang) WHERE year(a.tanggal_daftar) = '2015' GROUP BY a.id_gelombang ORDER BY jumlah DESC");
              while ($rjg = mysqli_fetch_assoc($sqlJumGel)) {
              ?>
              <tr>
                <td><?php echo $rjg['nama_gelombang']; ?></td>
                <td><?php echo $rjg['jumlah']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <script type="text/javascript">
            $(function () {
                Highcharts.chart('total_asal_sekolah', {
                    data: {
                        table: 'jml_sekolah'
                    },
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'ASAL SEKOLAH PENDAFTAR TERBANYAK'
                    },
                    yAxis: {
                        allowDecimals: false,
                        title: {
                            text: 'Asal Sekolah'
                        }
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                this.point.y + ' ' + this.point.name;
                        }
                    }
                });
            });
            $(function () {
                Highcharts.chart('total_prodi', {
                    data: {
                        table: 'jml_prodi'
                    },
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'PRODI PALING BANYAK DIPILIH'
                    },
                    yAxis: {
                        allowDecimals: false,
                        title: {
                            text: 'Program Studi'
                        }
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                this.point.y + ' ' + this.point.name;
                        }
                    }
                });
            });
            $(function () {
                Highcharts.chart('total_pj', {
                    data: {
                        table: 'jml_pj'
                    },
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'INTAKE PJ'
                    },
                    yAxis: {
                        allowDecimals: false,
                        title: {
                            text: 'PJ'
                        }
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                this.point.y + ' ' + this.point.name;
                        }
                    }
                });
            });
            $(function () {
                Highcharts.chart('total_gel', {
                    data: {
                        table: 'jml_gel'
                    },
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'JALUR MASUK PALING DIMINATI'
                    },
                    yAxis: {
                        allowDecimals: false,
                        title: {
                            text: 'Jalur Masuk'
                        }
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                this.point.y + ' ' + this.point.name;
                        }
                    }
                });
            });
          </script>
          <div class="grafik">
            <div class="col-md-6" style="margin-top: 30px;">
              <div id="total_asal_sekolah"></div>
            </div>
            <div class="col-md-6" style="margin-top: 30px;">
              <div id="total_prodi"></div>
            </div>
            <div class="col-md-6" style="margin-top: 30px;">
              <div id="total_pj"></div>
            </div>
            <div class="col-md-6" style="margin-top: 30px;">
              <div id="total_gel"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php } ?>
