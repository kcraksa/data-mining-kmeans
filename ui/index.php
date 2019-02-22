<!DOCTYPE html>
<html>
<head>
	<title>Sign In - eMarketing</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/login.css">
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<body>
<?php
	session_start();
	if (isset($_SESSION['username'])) {
		header("location: ../ui/menu.php");
	} else {
?>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form action="../proses/p_login.php" method="POST">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4><img src="../logo mercu.png" alt="" width="60" height="50" style="margin-top: 15px;"><br><br><span> Sign In First!</span></h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<input type="text" class="form-control" name="username" placeholder="Username">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="Password">
							</div>
						</div>
						<div class="panel-footer">
							<button type="submit" name="login" class="btn btn-primary"><i class="fa fa-sign-in"></i> Sign In</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>
</body>
</html>
