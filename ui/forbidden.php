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
	<title>404 Forbidden!</title>
	<link rel="stylesheet" href="../css/font-awesome.min.css">
</head>
<style>
	body {
		margin-top: 130px;
		text-align: center;
		color: red;
		text-transform: uppercase;
	}
</style>
<body>
	<h1>FORBIDDEN !</h1>
	<span class="fa fa-warning" style="font-size: 200px;"></span>
	<h1>Anda tidak berhak mengakses halaman ini.</h1>
	<a href="menu.php">Back to Home</a>
</body>
</html>
<?php } ?>
