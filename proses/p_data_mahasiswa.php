<?php
	if (isset($_POST['submit_data'])) {
		include 'connect.php';

		$nama = $_POST['nama'];
		$prodi = $_POST['prodi'];
		$sekolah = $_POST['sekolah'];
		$pj = $_POST['pj'];
		$gelombang = $_POST['gelombang'];
		$statusB = $_POST['status_beasiswa'];
		$tgl = $_POST['tanggal_daftar'];
		$tanggal = date("Y-m-d", strtotime($tgl));

		$query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$prodi', '$sekolah', '$pj', '$gelombang', '$statusB', '$tanggal')";
		if (mysqli_query($con, $query)) {
			echo "<script>alert('Data berhasil ditambahkan')
			window.location.href='../ui/input.php';
			</script>";
		} else {
			echo "<script>alert('Data gagal ditambahkan')
			window.location.href='../ui/input.php';
			</script>";
		}
	} elseif (isset($_POST['submit_data_and_close'])) {
		include 'connect.php';

		$nama = $_POST['nama'];
		$prodi = $_POST['prodi'];
		$sekolah = $_POST['sekolah'];
		$pj = $_POST['pj'];
		$gelombang = $_POST['gelombang'];
		$statusB = $_POST['status_beasiswa'];
		$tgl = $_POST['tanggal_daftar'];
		$tanggal = date("Y-m-d", strtotime($tgl));

		$query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$prodi', '$sekolah', '$pj', '$gelombang', '$statusB', '$tanggal')";
		if (mysqli_query($con, $query)) {
			echo "<script>alert('Data berhasil ditambahkan')
			window.location.href='../ui/mahasiswa.php';
			</script>";
		} else {
			echo "<script>alert('Data gagal ditambahkan')
			window.location.href='../ui/mahasiswa.php';
			</script>";
		}
	}
?>
