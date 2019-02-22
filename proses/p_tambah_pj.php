<?php 
	if (isset($_POST['submit'])) {
		include 'connect.php';
		$pj = $_POST['tambah_pj'];

		$query = "INSERT INTO pj VALUES ('', '$pj')";

		if (mysqli_query($con, $query)) {
			header("location: ../ui/input.php");
		} else {
			echo "<script>alert('Input data gagal')</script>";
			header("location: ../ui/input.php");
		}
	}
?>