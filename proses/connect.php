<?php 
	$host = "localhost";
	$user = "root";
	$pass = "P@ngrango28";
	$db = "mahasiswa";

	$con = mysqli_connect($host, $user, $pass, $db);
	if (mysqli_connect_errno()){
		echo "Gagal Terhubung ke Database";
	}
?>
