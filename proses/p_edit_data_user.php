<?php
  include 'connect.php';
  if (isset($_POST['submit_user'])){
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = $_POST['status_usr'];

    // Cek password
    $cek = mysqli_query($con, "SELECT password FROM user WHERE id_user = '$id'");
    $r = mysqli_fetch_assoc($cek);
    $pass = $r['password'];
    if ($password == $pass) {
      $u = mysqli_query($con, "UPDATE user SET username = '$username', status_user = '$level' WHERE id_user = '$id'");
      if ($u) {
        echo "<script>alert('Data berhasil diperbarui')
  			window.location.href='../ui/list_user.php';
  			</script>";
      } else {
        echo "<script>alert('Data gagal diperbarui')
  			window.location.href='../ui/list_user.php.php';
  			</script>";
      }
    } else {
      echo "<script>alert('Anda tidak memiliki akses')
      window.location.href='../ui/list_user.php';
      </script>";
    }
  }
?>
