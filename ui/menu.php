<?php
session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Beranda</title>
	<link rel="stylesheet" type="text/css" href="../css/beranda.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
	<script type="text/javascript">
		function showTime() {
			var a_p = "";
			var today = new Date();
			var curr_hour = today.getHours();
			var curr_minute = today.getMinutes();
			if (curr_hour < 12){
				a_p = "AM";
			} else {
				a_p = "PM";
			}
			if (curr_hour == 0){
				curr_hour = 12;
			}
			if (curr_hour > 12){
				curr_hour = curr_hour - 12;
			}
			curr_hour = checkTime(curr_hour);
			curr_minute = checkTime(curr_minute);
			document.getElementById('time').innerHTML = curr_hour + ":" + curr_minute + " " + a_p;
		}

		function checkTime(i) {
			if (i < 10){
				i = "0" + i;
			}
			return i;
		}
		setInterval(showTime, 500);
	</script>
</head>
<body>
	<div class="container-fluid">
    <img src="../logo mercu.png" alt="" width="70" height="50" style="float: left; margin-top: 15px;">
		<div id="info">
			<span class="jam">
			<?php
			$hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
			$bulan = array("","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
			echo $hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");
			?> - <span id="time"></span></span>
			<h4>Hi, <?php echo $_SESSION['username']; ?>. Welcome Back!</h4>
		</div>
	</div>

	<?php
		if (isset($_SESSION['level']))
		{
			if ($_SESSION['level'] == "Admin")
			{
	?>
	<nav>
		<ul>
			<a href="list_user.php">
				<li>
					<div class="front" id="box1"><span class="fa fa-user fa-5x"></span></div>
				    <div class="back">MANAGE USER</div>
				</li>
			</a>
		<!--	<a href="hasil_mining.php">
				<li>
					<div class="front" id="box2"><span class="fa fa-bar-chart fa-5x"></span></div>
					<div class="back">CLUSTER DATA</div>
				</li>
			</a>
			<a href="forecast.php">
				<li>
					<div class="front" id="box3"><span class="fa fa-line-chart fa-5x"></span></div>
					<div class="back">FORECAST DATA</div>
				</li>
			</a>
		</ul>
		<ul>
			<a href="dashboard.php">
				<li>
					<div class="front" id="box4"><span class="fa fa-dashboard fa-5x"></span></div>
					<div class="back">STATISTIK</div>
				</li>
			</a> -->
			<a href="about.php">
				<li>
					<div class="front" id="box5"><span class="fa fa-question-circle-o fa-5x"></span></div>
					<div class="back">ABOUT</div>
				</li>
			</a>
			<a href="../proses/p_logout.php">
				<li>
					<div class="front" id="box6"><span class="fa fa-sign-out fa-5x"></span></div>
					<div class="back">LOG OUT</div>
				</li>
			</a>
		</ul>
	</nav>
	<?php
			} elseif ($_SESSION['level'] == "Employee") {
	?>
	<nav>
		<ul>
			<a href="mahasiswa.php">
				<li>
					<div class="front" id="box1"><span class="fa fa-pencil fa-5x"></span></div>
				    <div class="back">INPUT DATA</div>
				</li>
			</a>
			<a href="forbidden.php">
				<li>
					<div class="front" id="box2"><span class="fa fa-bar-chart fa-5x"></span></div>
					<div class="back">NOT ACCESSIBLE</div>
				</li>
			</a>
			<a href="forbidden.php">
				<li>
					<div class="front" id="box3"><span class="fa fa-line-chart fa-5x"></span></div>
					<div class="back">NOT ACCESSIBLE</div>
				</li>
			</a>
		</ul>
		<ul>
			<a href="dashboard.php">
				<li>
					<div class="front" id="box4"><span class="fa fa-dashboard fa-5x"></span></div>
					<div class="back">VIEW DATA</div>
				</li>
			</a>
			<a href="about.php">
				<li>
					<div class="front" id="box5"><span class="fa fa-question-circle-o fa-5x"></span></div>
					<div class="back">ABOUT</div>
				</li>
			</a>
			<a href="../proses/p_logout.php">
				<li>
					<div class="front" id="box6"><span class="fa fa-sign-out fa-5x"></span></div>
					<div class="back">LOG OUT</div>
				</li>
			</a>
		</ul>
	</nav>
  <?php
} elseif ($_SESSION['level'] == "Manager") {
	?>
	<nav>
		<ul>
			<a href="forbidden.php">
				<li>
					<div class="front" id="box1"><span class="fa fa-pencil fa-5x"></span></div>
				    <div class="back">NOT ACCESSIBLE</div>
				</li>
			</a>
			<a href="hasil_mining.php">
				<li>
					<div class="front" id="box2"><span class="fa fa-bar-chart fa-5x"></span></div>
					<div class="back">MINING DATA</div>
				</li>
			</a>
			<a href="forecast.php">
				<li>
					<div class="front" id="box3"><span class="fa fa-line-chart fa-5x"></span></div>
					<div class="back">FORECAST DATA</div>
				</li>
			</a>
		</ul>
		<ul>
			<a href="dashboard.php">
				<li>
					<div class="front" id="box4"><span class="fa fa-dashboard fa-5x"></span></div>
					<div class="back">VIEW DATA</div>
				</li>
			</a>
			<a href="about.php">
				<li>
					<div class="front" id="box5"><span class="fa fa-question-circle-o fa-5x"></span></div>
					<div class="back">ABOUT</div>
				</li>
			</a>
			<a href="../proses/p_logout.php">
				<li>
					<div class="front" id="box6"><span class="fa fa-sign-out fa-5x"></span></div>
					<div class="back">LOG OUT</div>
				</li>
			</a>
		</ul>
	</nav>
	<?php
			}
		}
	?>
</body>
</html>
<?php } ?>
