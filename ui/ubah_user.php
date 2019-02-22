<?php
session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else {
  include '../proses/connect.php';
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
			<form action="../proses/p_edit_data_user.php" method="POST">
				<div class="panel panel-default">
					<div class="panel-heading">
						Form Input Data User
					</div>
					<div class="panel-body">
            <input type="hidden" name="id" value="<?php echo $iduser; ?>">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
						</div>
						<div class="form-group">
							<label for="status_usr">Level User</label>
							<select name="status_usr" class="form-control">
								<option value="">- Pilih Level -</option>
                <?php
                  if ($level == 'Admin') {
                ?>
                <option value="Admin" selected="selected">Admin</option>
								<option value="Employee">Employee</option>
								<option value="Manager">Manager</option>
                <?php } elseif ($level == 'Employee') { ?>
                <option value="Admin">Admin</option>
                <option value="Employee" selected="selected">Employee</option>
                <option value="Manager">Manager</option>
                <?php } elseif ($level == 'Manager') { ?>
                <option value="Admin">Admin</option>
                <option value="Employee">Employee</option>
                <option value="Manager" selected="selected">Manager</option>
                <?php } ?>
                <!-- <option value="Admin">Admin</option>
								<option value="Employee">Employee</option>
								<option value="Manager">Manager</option> -->
							</select>
						</div>
            <hr>
            <p align='center' style="font-size: 15pt;"><label class="label label-danger">Konfirmasi Password</label></p>
            <hr>
            <div class="form-group">
							<label for="username">Password Anda</label>
							<input type="password" name="password" class="form-control">
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
