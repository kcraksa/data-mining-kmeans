<?php session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else { ?>
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
			<form action="../proses/p_new_user.php" method="POST">
				<div class="panel panel-default">
					<div class="panel-heading">
						Form Input Data User
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" class="form-control">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" class="form-control">
						</div>
						<div class="form-group">
							<label for="status_usr">Level User</label>
							<select name="status_usr" class="form-control">
								<option value="">- Pilih Level -</option>
								<option value="Admin">Admin</option>
								<option value="Employee">Employee</option>
								<option value="Manager">Manager</option>
							</select>
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
