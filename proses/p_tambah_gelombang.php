<?php 
	if (isset($_POST['submit'])) {
		include 'connect.php';
		$gelombang = $_POST['tambah_gelombang'];

		$query = "INSERT INTO gelombang_masuk VALUES ('', '$gelombang')";

		if (mysqli_query($con, $query)) {
			header("location: ../ui/input.php");
		} else {
			echo "<script>alert('Input data gagal')</script>";
			header("location: ../ui/input.php");
		}
	}
?>