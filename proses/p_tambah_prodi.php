<?php 
	if (isset($_POST['submit'])) {
		include 'connect.php';
		$prodi = $_POST['tambah_prodi'];

		$query = "INSERT INTO prodi VALUES ('', '$prodi')";

		if (mysqli_query($con, $query)) {
			header("location: ../ui/input.php");
		} else {
			echo "<script>alert('Input data gagal')</script>";
			header("location: ../ui/input.php");
		}
	}
?>