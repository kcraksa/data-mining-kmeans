<?php
  include 'connect.php';
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($con, "DELETE FROM user WHERE id_user = '$id'");
    if ($sql) {
      echo "<script>alert('User berhasil dihapus')
      window.location.href='../ui/list_user.php';
      </script>";
    } else {
      echo "<script>alert('User gagal dihapus')
      window.location.href='../ui/list_user.php';
      </script>";
    }
  }
?>
