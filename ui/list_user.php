<?php
session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else {
?>
<!doctype html>
<html>
    <head>
        <title>Harviacode - Datatables</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="../css/dataTables.bootstrap.css"/>
        <link rel="stylesheet" href="../css/input.css">
    </head>
    <style media="screen">
      body {
        margin-top: 60px;
        background: #fff;
      }
    </style>
    <body>
        <div class="container">
          <?php include 'navbar.php'; ?>
          <h3 style="text-align: center;">DATA USER</h3>
          <a href="user.php" class="btn btn-primary" id="tambah" style="margin-top: -50px;">Tambah Data</a>
          <hr style="margin-top: -10px;">
            <div class="col-md-8 col-md-offset-2">
              <table id="user" class="table table-striped">
                  <thead>
                      <tr>
                        <th>No. </th>
                        <th>Username</th>
                        <th>Status User</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php

                      //Data mentah yang ditampilkan ke tabel
                      include '../proses/connect.php';
                      $sql = mysqli_query($con, "SELECT id_user, username, password, status_user FROM user");
                      $no = 1;
                      while ($r = mysqli_fetch_assoc($sql)) {
                      $id = $r['id_user'];
                      ?>

                      <tr align='left'>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $r['username']; ?></td>
                        <td><?php echo $r['status_user']; ?></td>
                        <td>
                          <a href="ubah_user.php?id=<?php echo $id; ?>">Ubah Data</a> |
                          <a href="ubah_password.php?id=<?php echo $id; ?>">Ubah Password</a> |
                          <a href="../proses/p_hapus_user.php?id=<?php echo $id; ?>">Hapus</a>
                        </td>
                      </tr>
                      <?php
                      $no++;
                      }
                      ?>
                  </tbody>
              </table>
            </div>
        </div>

        <script src="../js/jquery-1.11.0.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.dataTables.js"></script>
        <script src="../js/dataTables.bootstrap.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#user").dataTable();
            });
        </script>
    </body>
</html>
<?php } ?>
