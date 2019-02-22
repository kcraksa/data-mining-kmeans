<?php
	include 'connect.php';

	$searchTerm = $_GET['term'];

	$query = mysqli_query($con, "SELECT * FROM asal_sekolah WHERE nama_prodi LIKE '%$searchTerm%' ORDER BY nama_prodi ASC");
	while ($row = mysqli_fetch_array($query)){
		$data[] = $row['nama_prodi'];
	}

	echo json_encode($data);
?>