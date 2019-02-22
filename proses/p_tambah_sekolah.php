<?php 
	if (isset($_POST['submit'])) {
		include 'connect.php';
		$sekolah = $_POST['tambah_sekolah'];

		$query = "INSERT INTO asal_sekolah VALUES ('', '$sekolah')";

		if (mysqli_query($con, $query)) {
			header("location: ../ui/input.php");
		} else {
			echo "<script>alert('Input data gagal')</script>";
			header("location: ../ui/input.php");
		}
	}
?>