<?php session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else { ?>
<!doctype html>
<html>
    <head>
        <title>List Data Pendaftar</title>
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
          <h3 style="text-align: center;">DATA PENDAFTAR</h3>
          <a href="input.php" class="btn btn-primary" id="tambah" style="margin-top: -50px;">Tambah Data</a>
          <hr style="margin-top: -10px;">
            <table id="mahasiswa" class="table table-striped">
                <thead>
                    <tr>
                      <th>No. </th>
                      <th>Nama</th>
                      <th>Asal Sekolah</th>
                      <th>Tanggal Daftar</th>
                      <th>Jalur Masuk</th>
                      <th>Prodi Pilihan</th>
                      <th>PJ</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    //Data mentah yang ditampilkan ke tabel
                    include '../proses/connect.php';
                    $sql = mysqli_query($con, "SELECT a.nim, a.nama, b.nama_sekolah, a.tanggal_daftar, c.nama_gelombang, d.nama_prodi, e.nama_pj FROM mahasiswa a INNER JOIN asal_sekolah b ON (a.id_sekolah = b.id_sekolah) INNER JOIN gelombang_masuk c ON (a.id_gelombang = c.id_gelombang)
								            INNER JOIN prodi d ON (a.id_prodi = d.id_prodi) INNER JOIN pj e ON (a.id_pj = e.id_pj)");
                    $no = 1;
                    while ($r = mysqli_fetch_assoc($sql)) {
                    $id = $r['nim'];
                    ?>

                    <tr align='left'>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $r['nama']; ?></td>
                      <td><?php echo $r['nama_sekolah']; ?></td>
                      <td><?php echo $r['tanggal_daftar']; ?></td>
                      <td><?php echo $r['nama_gelombang']; ?></td>
                      <td><?php echo $r['nama_prodi']; ?></td>
                      <td><?php echo $r['nama_pj']; ?></td>
                      <td>
                        <a href="edit_mhs.php?id=<?php echo $r['nim']; ?>"><span class="fa fa-edit"></span></a> |
                        <a href="../proses/p_delete_mhs.php?id=<?php echo $r['nim']; ?>" onclick="javascript: return confirm('Anda yakin ingin menghapus data ini ?')"><span class="fa fa-trash-o"></span></a>
                      </td>
                    </tr>
                    <?php
                    $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="../js/jquery-1.11.0.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery.dataTables.js"></script>
        <script src="../js/dataTables.bootstrap.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#mahasiswa").dataTable();
            });
        </script>
    </body>
</html>
<?php } ?>
