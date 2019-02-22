<?php
  include 'connect.php';
  if (isset($_POST['submit_data'])) {
    $id = $_GET['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
		$prodi = $_POST['prodi'];
		$sekolah = $_POST['sekolah'];
		$pj = $_POST['pj'];
		$gelombang = $_POST['gelombang'];
		$statusB = $_POST['status_beasiswa'];
		$tgl = $_POST['tanggal_daftar'];
		$tanggal = date("Y-m-d", strtotime($tgl));

    $sql = "UPDATE mahasiswa SET nama = '$nama', id_prodi = '$prodi', id_sekolah = '$sekolah', id_pj = '$pj', id_gelombang = '$gelombang', id_status = '$statusB', tanggal_daftar = '$tanggal' WHERE nim = '$nim'";
    if (mysqli_query($con, $sql)) {
      echo "<script>alert('Data berhasil diperbarui')
			window.location.href='../ui/mahasiswa.php';
			</script>";
    } else {
      echo "<script>alert('Data gagal diperbarui')
			window.location.href='../ui/mahasiswa.php';
			</script>";
    }
  }
?>
