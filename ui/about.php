<?php
session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else {
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>About</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/input.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
  </head>
  <body style="text-align: center; margin-top: 100px;">
    <?php include 'navbar.php'; ?>
    <div class="container">
      <div class="row">
        <div class="jumbotron">
          <h3><i class="fa fa-info-circle"></i> ABOUT THIS APPLICATION</h3>
          <hr>
          <p>Ini adalah Aplikasi e-Marketing yang berfungsi sebagai aplikasi sistem informasi marketing.
          Selain itu, pada aplikasi ini juga diterapkan algoritma k-means untuk mengcluster data dan exponential smoothing untuk meramalkan data.</p>
          <p><u>Dibuat Oleh : </u><br />
            Krisna Cipta Raksa<br />
            Amirulloh<br />
          </p>
          <p>- SISTEM INFORMASI 2013 -</p>
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
</html>
<?php } ?>
