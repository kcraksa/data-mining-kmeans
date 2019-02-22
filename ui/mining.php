<?php include '../proses/connect.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mining Data</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/input.css">
    <link rel="stylesheet" href="../css/mining.css">
  </head>
  <body>
    <?php include 'navbar.php'; ?>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Data Mining dengan K-Means Clustering</h2>
          <br />
          <?php
            class DataSet {

              public $a;
              public $b;
              public $c;
              public $d;
              public $e;

              function __construct ($a, $b, $c, $d, $e)
              {
                $this->a = $a;
                $this->b = $b;
                $this->c = $c;
                $this->d = $d;
                $this->e = $e;
              }
            }

            function jarak($p1, $p2)
            {
              return abs($p1->a - $p2->a) + abs($p1->b - $p2->b) + abs($p1->c - $p2->c) + abs($p1->d - $p2->d) + abs($p1->e - $p2->e);
            }

            function dump($table, $centroid, $k)
            {
              $cluster = array();
          ?>
          <div class="jumbotron">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Prodi</th>
                  <th>Asal Sekolah</th>
                  <th>PJ</th>
                  <th>Gelombang</th>
                  <th>Status Beasiswa</th>
                  <th>C1</th>
                  <th>C2</th>
                  <th>C3</th>
                  <th>Cluster</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($table as $row) {
                ?>
                <tr>
                  <td><?php echo $row->a; ?></td>
                  <td><?php echo $row->b; ?></td>
                  <td><?php echo $row->c; ?></td>
                  <td><?php echo $row->d; ?></td>
                  <td><?php echo $row->e; ?></td>
                <?php
                  $nilaiMin = 999999;
                  $idMin = 0;

                  for ($i=0; $i < $k; $i++) {
                    $dist = jarak($row, $centroid[$i]);
                    echo "<td>".$dist."</td>";
                    if ($nilaiMin > $dist)
                    {
                      $idMin = $i;
                      $nilaiMin = $dist;
                    }
                  }

                  $cluster[] = $idMin;
                ?>
                <td><?php echo $idMin; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <br /><br />
            <?php
              return $cluster;
            }

            function dump_group($centroid, $group, $k) {
              ?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <?php
                    for ($i=0; $i < $k; $i++) {
                      echo "<th>(".$centroid[$i]->a." , ".$centroid[$i]->b." , ".$centroid[$i]->c." , ".$centroid[$i]->d." , ".$centroid[$i]->e."</th>";
                    }
                  ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php
                    for ($i=0; $i < $k; $i++) {
                      echo "<td>";

                      $a = 0;
                      $b = 0;
                      $c = 0;
                      $d = 0;
                      $e = 0;

                      $f = 0;
                      foreach ($group[$i] as $set) {
                        $f++;
                        echo "( ".$set->a." , ".$set->b." , ".$set->c." , ".$set->d." , ".$set->e." ) ";
                        $a += $set->a;
                        $b += $set->b;
                        $c += $set->c;
                        $d += $set->d;
                        $e += $set->e;
                      }

                      $a /= $f;
                      $b /= $f;
                      $c /= $f;
                      $d /= $f;
                      $e /= $f;

                      $centroid[$i] = new DataSet($a, $b, $c, $d, $e);

                      echo "</td>";
                    }
                  ?>
                </tr>
              </tbody>
            </table>

            <?php
              return $centroid;
            }

            $sql = "SELECT id_prodi, id_sekolah, id_pj, id_gelombang, id_status FROM mahasiswa";
            $result = mysqli_query($con, $sql);

            $var = array();
            while ($r = mysqli_fetch_assoc($result)) {
              $var[] = array("a" => $r['id_prodi'], "b" => $r['id_sekolah'], "c" => $r['id_pj'], "d" => $r['id_gelombang'], "e" => $r['id_status']);
            }

            $json = json_encode($var);

            $obj = json_decode($json);

            $k = 3;

            $table = array();
    				foreach($obj as $row){
    					$table[] = new DataSet($row->a, $row->b, $row->c, $row->d, $row->e);
    				}

            $centroid = array();
            for ($i=0; $i < $k; $i++) {
              $centroid[] = array_rand($var, 5);
            }

            $batas_iterasi = 10;

            for ($iteration = 0; $iteration < $batas_iterasi; $iteration++) {
              echo '<br/><div style="background: #DDD; position: relative; width: 100%; height: 30px; border: 1px solid black; color: black; font-weight: bold;"><div style="padding: 5px;"><i class="fa fa-info-circle"></i> ITERATION '. $iteration .'</div></div><br/>';

              $cluster = dump($table, $centroid, $k);

              $group = array();
              for ($i=0; $i < $k; $i++) {
                $group[] = array();
              }

              $i = 0;
              foreach ($table as $row) {
                $group[$cluster[$i]][] = new DataSet($row->a, $row->b, $row->c, $row->d, $row->e);
                $i++;
              }

              $new_centroid = dump_group($centroid, $group, $k);

              $flag = true;
              $i = 0;
              foreach ($new_centroid as $g) {
                if($centroid[$i]->id_prodi != $new_centroid[$i]->id_prodi || $centroid[$i]->id_sekolah != $new_centroid[$i]->id_sekolah || $centroid[$i]->id_pj != $new_centroid[$i]->id_pj || $centroid[$i]->id_gelombang != $new_centroid[$i]->id_gelombang
                 || $centroid[$i]->id_status != $new_centroid[$i]->id_status)
                 {
                   $flag = false;
                   break;
                 }
                 $i++;
              }

              if($flag){
                break;
              }

              $i = 0;
              foreach ($new_centroid as $g) {
                $centroid[$i] = new DataSet($g->id_prodi, $g->id_sekolah, $g->id_pj, $g->id_gelombang, $g->id_status);
                $i++;
              }

              echo "<br /><br /><br />";
            }

            if ($flag) {
              echo '<br/><div style="background: aquamarine; position: relative; width: 100%; height: 30px; border: 1px solid yellow; color: black; font-weight: bold;"><div style="padding: 5px;"><i class="fa fa-info-circle"></i> CLUSTER FINDING SUCCESSFULL</div></div><br/>';
            } else{
    					echo '<br/><div style="background: red; position: relative; width: 100%; height: 30px; border: 1px solid yellow; color: white; font-weight: bold;"><div style="padding: 5px;"><i class="fa fa-info-circle"></i> ITERATION LIMIT REACHED. IMPERFECT CLUSTER, TRY CHAGING VALUE OF $k </div></div><br/>';
    				}

            ?>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
</html>
