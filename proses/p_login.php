<?php
	session_start();
	include 'connect.php';

	$username = mysqli_real_escape_string($con, $_POST['username']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$passmd5 = md5($password);

	$query = "SELECT * FROM user WHERE username = '$username'";
	$hasil = mysqli_query($con, $query);
	$data = mysqli_fetch_assoc($hasil);
	if ($passmd5 == $data['password'])
	{
		$_SESSION['level'] = $data['status_user'];
		$_SESSION['username'] = $data['username'];
		header("location: ../ui/menu.php");
	} else {
		echo "<script>alert('Login gagal')
		window.location.href='../ui/index.php';
		</script>";
	}
?>
