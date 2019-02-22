<?php
  include 'connect.php';
  $id = $_POST['id'];
  $plama = md5($_POST['plama']);
  $pbaru = md5($_POST['pbaru']);
  $kpbaru = md5($_POST['kpbaru']);

  // Cek Password Baru
  if ($pbaru = $kpbaru) {
    // Cek Password lama
    $cek = mysqli_query($con, "SELECT password FROM user WHERE password = '$plama' AND id_user = '$id'");
    if (mysqli_num_rows($cek) == 1) {
      // Update Password
      $up = mysqli_query($con, "UPDATE user SET password = '$pbaru' WHERE id_user = '$id'");
      if ($up) {
        echo "<script>alert('Password berhasil diperbarui')
  			window.location.href='../ui/list_user.php';
  			</script>";
      } else {
        echo "<script>alert('Password gagal diperbarui')
  			window.location.href='../ui/list_user.php';
  			</script>";
      }
    } else {
      echo "<script>alert('Password Anda Salah')
      window.location.href='../ui/ubah_password.php';
      </script>";
    }
  } else {
    echo "<script>alert('Password Anda Salah')
    window.location.href='../ui/ubah_password.php';
    </script>";
  }
?>
