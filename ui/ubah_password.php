<?php
  include '../proses/connect.php';
  session_start();

  // Cek session
  if (!isset($_SESSION['level'])) {
    header("location: index.php");
  } else {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($con, "SELECT * FROM user WHERE id_user = '$id'");
    $r = mysqli_fetch_assoc($sql);
    $iduser = $r['id_user'];
    $username = $r['username'];
    $level = $r['status_user'];
  }
  ?>
<!DOCTYPE html>
<html>
<head>
	<title>INPUT DATA USER</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/input.css">
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.min.js"></script>
</head>
<body>
	<?php include 'navbar.php'; ?>

	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form action="../proses/p_ubah_password.php" method="POST">
				<div class="panel panel-default">
					<div class="panel-heading">
						Form Ubah Password
					</div>
					<div class="panel-body">
            <input type="hidden" name="id" value="<?php echo $iduser; ?>">
						<div class="form-group">
							<label for="username">Password Lama</label>
							<input type="password" name="plama" class="form-control">
						</div>
            <div class="form-group">
							<label for="username">Password Baru</label>
							<input type="password" name="pbaru" class="form-control">
						</div>
            <div class="form-group">
							<label for="username">Konfirmasi Password Baru</label>
							<input type="password" name="kpbaru" class="form-control">
						</div>
					</div>
					<div class="panel-footer">
						<button type="submit" class="btn btn-primary" name="submit_user">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
<script>
  $(document).ready(function () {
	$('[data-toggle="tooltip"]').tooltip();
  });
</script>
</html>
<?php } ?>
