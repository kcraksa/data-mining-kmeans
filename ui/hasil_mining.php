<!DOCTYPE html>
<?php include '../proses/connect.php';

session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else { ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>KMeans Hasil</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/input.css">
    <link rel="stylesheet" href="../css/hasil_mining.css">
    <link rel="stylesheet" href="../css/chartphp.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/highcharts.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/modules/data.js"></script>
    <script type="text/javascript" src="../js/modules/exporting.js"></script>
  </head>
  <style media="screen">
    .jumbotron {
      background: #fff;
      border-radius: 0;
      -webkit-box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
      -moz-box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
      box-shadow: 10px 11px 40px -12px rgba(0,0,0,0.75);
    }
    .table-bordered > thead {
      background: green;
      color: #fff;
    }

    .table-bordered > tbody > tr > td:last-child {
      background: red;
      color: #fff;
      font-weight: bold;
      width: 50px;
    }
  </style>
  <body>
    <?php include 'navbar.php'; ?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php
            class DataSet{
              public $v;
              public $w;
              public $x;
              public $y;
              public $z;
              function __construct($v, $w, $x, $y, $z){
                $this->v = $v;
                $this->w = $w;
                $this->x = $x;
                $this->y = $y;
                $this->z = $z;
              }
            }

            function distance($p1, $p2){
              return sqrt(pow(($p1->v - $p2->v), 2) + pow(($p1->w - $p2->w), 2) + pow(($p1->x - $p2->x), 2) + pow(($p1->y - $p2->y), 2) + pow(($p1->z - $p2->z), 2));
              //return sqrt($p1*$p1 + $p2*$p2);
            }

            function dump($table, $centroid, $k){
              $cluster = array();
                foreach($table as $row){

                $minValue = 999999;
                $minID = 0;

                for($i=0; $i<$k; $i++){
                //echo "<td>(".$row->x." , ".$row->y.") - (".$centroid[$i]->x." , ".$centroid[$i]->y.")</td>";
                $dist = distance($row, $centroid[$i]);
                if($minValue > $dist){
                $minID = $i;
                $minValue = $dist;
                }
              }

              $cluster[] = $minID;

              }
              return $cluster;
            }

            function dump_group($centroid, $group, $k){

      						for($i=0; $i<$k; $i++){

      							$v = 0;
      							$w = 0;
      							$x = 0;
      							$y = 0;
      							$z = 0;

      							$c = 0;
      							foreach($group[ $i ] as $set){
      								$c++;
      								$v += $set->v;
      								$w += $set->w;
      								$x += $set->x;
      								$y += $set->y;
      								$z += $set->z;
      							}

      							$v /= $c;
      							$w /= $c;
      							$x /= $c;
      							$y /= $c;
      							$z /= $c;

      							$centroid[$i] = new DataSet($v, $w, $x, $y, $z);

      						}

              return $centroid;
            }

            if(isset($_REQUEST['data'])){
              $var = $_REQUEST['data'];
            }
            else
              $sql = "SELECT id_prodi, id_sekolah, id_pj, id_gelombang, id_status FROM mahasiswa";
              $result = mysqli_query($con, $sql);
              while ($r = mysqli_fetch_assoc($result)) {
                $var1[] = array('v' => $r['id_prodi'], 'w' => $r['id_sekolah'], 'x' => $r['id_pj'], 'y' => $r['id_gelombang'], 'z' => $r['id_status']);
              }
            $var = json_encode($var1);

            if(isset($_REQUEST['k']))
              $k = $_REQUEST['k'];
            else
              $k = 3;

            $obj = json_decode($var);

            $table = array();
            foreach($obj as $row){
              $table[] = new DataSet($row->v, $row->w, $row->x, $row->y, $row->z);
            }

            $centroid = array();
            for($i=0; $i<$k; $i++)
              $centroid[] = new DataSet($table[$i]->v, $table[$i]->w, $table[$i]->x, $table[$i]->y, $table[$i]->z);


            $iteration_limit = 100;

            for($iteration = 0; $iteration < $iteration_limit; $iteration++){

              $cluster = dump($table, $centroid, $k);

              $group = array();
              for($i=0; $i<$k; $i++){
                $group[] = array();
              }

              $i = 0;
              foreach($table as $row){
                $group[ $cluster[$i] ][] = new DataSet( $row->v, $row->w, $row->x, $row->y, $row->z );
                  $i++;
              }

              $new_centroid = dump_group($centroid, $group, $k);

              // CHECK CHANGED IN NEW CENTROID AND BREAK
              $flag = true;	//ASSUME SAME VALUES EXIST
              $i = 0;
              foreach($new_centroid as $g){
                if( $centroid[$i]->v != $new_centroid[$i]->v || $centroid[$i]->w != $new_centroid[$i]->w || $centroid[$i]->x != $new_centroid[$i]->x
                || $centroid[$i]->y != $new_centroid[$i]->y || $centroid[$i]->z != $new_centroid[$i]->z)
                {
                  $flag = false;
                  break;
                }
                $i++;
              }

              if($flag){
                break;
              }

              // COPY NEW_CENTROID TO CENTROID
              $i = 0;
              foreach($new_centroid as $g){
                $centroid[$i] = new DataSet( $g->v, $g->w, $g->x, $g->y, $g->z );
                $i++;
              }

              /*
              echo "<br/>CENTROID { <br/>";
              foreach($centroid as $g){
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$g->x." , ".$g->y."<br/>";
              }
              echo "}<br/><br/>";
              */

            }
            ?>
            <h3>HASIL AKHIR CLUSTERING DATA DENGAN K-MEANS</h3>
            <div class="jumbotron" id="info_iterasi" style="border-radius: 0;">
              <label class="label label-warning">Jumlah Data = <?php echo count($obj); ?></label><br />
              <label class="label label-default">Jumlah Iterasi = <?php echo $iteration; ?></label><br />
              <label class="label label-success">Jumlah Cluster = <?php echo $k; ?></label>
              <a href="detail_mining.php" style="float: right; background: green; color: white; padding: 10px; margin-top: -20px; text-decoration: none;">Lihat Detail Iterasi</a>
            </div>
            <?php
              $sqlHapus = "TRUNCATE TABLE hasil_cluster";
              $hasil = mysqli_query($con, $sqlHapus);
              for ($i=0; $i < count($group); $i++) {
                $prodiCount[$i] = array();
                $asalSekolahCount[$i] = array();
                $pjCount[$i] = array();
                $gelombangCount[$i] = array();
                $beasiswaCount[$i] = array();
                $jmlProdi[$i] = array();
            ?>
            <div class="jumbotron" style="border-radius: 0; overflow: scroll; height: 400px;">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th colspan="5">Pola Ke-<?php echo $i+1; ?></th>
                  </tr>
                  <tr>
                    <th>Prodi</th>
                    <th>Asal Sekolah</th>
                    <th>PJ</th>
                    <th>Jalur Masuk</th>
                    <th>Status Beasiswa</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $prodi = array();
                    $asalSekolah = array();
                    $pj = array();
                    $gelombang = array();
                    $status = array();
                    foreach ($group[$i] as $var) {
                      $sqlProdi = "SELECT nama_prodi FROM prodi WHERE id_prodi = $var->v";
                      $resProdi = mysqli_query($con, $sqlProdi);
                      while ($rProdi = mysqli_fetch_assoc($resProdi)){
                        $prodi = $rProdi;
                      }
                      $sqlAsalSekolah = "SELECT nama_sekolah FROM asal_sekolah WHERE id_sekolah = $var->w";
                      $resAsalSekolah = mysqli_query($con, $sqlAsalSekolah);
                      while ($rAsalSekolah = mysqli_fetch_assoc($resAsalSekolah)) {
                        $asalSekolah = $rAsalSekolah;
                      }
                      $sqlPJ = "SELECT nama_pj FROM pj WHERE id_pj = $var->x";
                      $resPJ = mysqli_query($con, $sqlPJ);
                      while ($rPJ = mysqli_fetch_assoc($resPJ)) {
                        $pj = $rPJ;
                      }
                      $sqlGelombang = "SELECT nama_gelombang FROM gelombang_masuk WHERE id_gelombang = $var->y";
                      $resGelombang = mysqli_query($con, $sqlGelombang);
                      while ($rGelombang = mysqli_fetch_assoc($resGelombang)) {
                        $gelombang = $rGelombang;
                      }
                      $sqlStatus = "SELECT status FROM status_beasiswa WHERE id_status = $var->z";
                      $resStatus = mysqli_query($con, $sqlStatus);
                      while ($rStatus = mysqli_fetch_assoc($resStatus)) {
                        $status = $rStatus;
                      }
                      //$a = "INSERT INTO tmp_cluster VALUES ('".$prodi['nama_prodi']."','".$asalSekolah['nama_sekolah']."','".$pj['nama_pj']."','".$gelombang['nama_gelombang']."',
                      //'".$status['status']."','".$i."')";
                      //$sqlInput = mysqli_query($con, $a);
                      echo "<tr>
                        <td>".$prodi['nama_prodi']."</td>
                        <td>".$asalSekolah['nama_sekolah']."</td>
                        <td>".$pj['nama_pj']."</td>
                        <td>".$gelombang['nama_gelombang']."</td>
                        <td>".$status['status']."</td>
                      </tr>";
                      array_push($prodiCount[$i], $prodi['nama_prodi']);
                      array_push($asalSekolahCount[$i], $asalSekolah['nama_sekolah']);
                      array_push($pjCount[$i], $pj['nama_pj']);
                      array_push($gelombangCount[$i], $gelombang['nama_gelombang']);
                      array_push($beasiswaCount[$i], $status['status']);
                    }
                    $jmlProdi[$i] = array_count_values($prodiCount[$i]);
                    arsort($jmlProdi[$i]);
                    $jmlAsalSekolah[$i] = array_count_values($asalSekolahCount[$i]);
                    arsort($jmlAsalSekolah[$i]);
                    $jmlPj[$i] = array_count_values($pjCount[$i]);
                    arsort($jmlPj[$i]);
                    $jmlGelombang[$i] = array_count_values($gelombangCount[$i]);
                    arsort($jmlGelombang[$i]);
                    $jmlStatus[$i] = array_count_values($beasiswaCount[$i]);
                    arsort($jmlStatus[$i]);
                    ?>
                </tbody>
              </table>
            </div>
            <!-- Initialisasi Data -->
            <?php
              $tampilProdi = array_values($jmlProdi[$i]);
              $tampilSekolah = array_values($jmlAsalSekolah[$i]);
              $tampilPj = array_values($jmlPj[$i]);
              $tampilGelombang = array_values($jmlGelombang[$i]);
              $tampilStatus = array_values($jmlStatus[$i]);
              $tnprodi = array_keys($jmlProdi[$i]);
              $tnsekolah = array_keys($jmlAsalSekolah[$i]);
              $tnpj = array_keys($jmlPj[$i]);
              $tngelombang = array_keys($jmlGelombang[$i]);
              $tnbeasiswa = array_keys($jmlStatus[$i]);
            ?>
            <div class="jumbotron" style="border-radius: 0;">
              <h3>TABEL HASIL ITERASI - Cluster <?php echo $i+1; ?></h3>
              <hr>
              <div class="row">
                <div class="col-md-4">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Prodi</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        for ($tp=0; $tp < (count($tampilProdi) / count($tampilProdi) * 5); $tp++) {
                          echo "<tr>
                          <td>".$tnprodi[$tp]."</td>
                          <td>".$tampilProdi[$tp]."</td>
                          </tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-4">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Sekolah</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        for ($ts=0; $ts < (count($tampilSekolah) / count($tampilSekolah) * 5); $ts++) {
                          echo "<tr>
                          <td>".$tnsekolah[$ts]."</td>
                          <td>".$tampilSekolah[$ts]."</td>
                          </tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-4">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>PJ</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        for ($tj=0; $tj < (count($tampilPj) / count($tampilPj) * 5); $tj++) {
                          echo "<tr>
                          <td>".$tnpj[$tj]."</td>
                          <td>".$tampilPj[$tj]."</td>
                          </tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Jalur Masuk</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        for ($tjm=0; $tjm < (count($tampilGelombang) / count($tampilGelombang) * 5); $tjm++) {
                          echo "<tr>
                          <td>".$tngelombang[$tjm]."</td>
                          <td>".$tampilGelombang[$tjm]."</td>
                          </tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-4">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Beasiswa</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        for ($tb=0; $tb < 2; $tb++) {
                          echo "<tr>
                          <td>".$tnbeasiswa[$tb]."</td>
                          <td>".$tampilStatus[$tb]."</td>
                          </tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <?php
              }
            ?>
        </div>
      </div>
    </div>
  </body>
</html>
<?php } ?>
