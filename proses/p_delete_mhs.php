<?php
  include 'connect.php';
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($con, "DELETE FROM mahasiswa WHERE nim = '$id'");
    if ($sql) {
      echo "<script>alert('Data berhasil dihapus')
			window.location.href='../ui/mahasiswa.php';
			</script>";
    } else {
      echo "<script>alert('Data gagal dihapus')
			window.location.href='../ui/mahasiswa.php';
			</script>";
    }
  }
?>
