<?php
	if (isset($_POST['submit_user'])) {
		include 'connect.php';

		$uname = $_POST['username'];
		$passw = $_POST['password'];
		$pwmd5 = md5($passw);
		$level = $_POST['status_usr'];

		$query = "INSERT INTO user VALUES ('', '$uname', '$pwmd5', '$level')";

		if (mysqli_query($con, $query)) {
			echo "<script>alert('Data berhasil disimpan')
			window.location.href='../ui/list_user.php';
			</script>";
		} else {
			echo "<script>alert('Data Gagal disimpan')
			window.location.href='../ui/list_user.php';
			</script>";
		}
	}
?>
