<?php include '../proses/connect.php';
session_start();

// Cek session
if (!isset($_SESSION['level'])) {
  header("location: index.php");
} else {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Input Data</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/input.css">
	<link rel="stylesheet" href="../css/bootstrap-select.min.css">
	<link rel="stylesheet" href="../css/bootstrap-datepicker.min.css">

	<!-- Plugin Autocomplete -->
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
</head>
<body>
	<?php include 'navbar.php'; ?>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form action="../proses/p_data_mahasiswa.php" method="POST">
				<div class="panel panel-default">
					<div class="panel-heading">
						Form Input Data Mahasiswa
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="nama">Nama</label>
							<input type="text" name="nama" class="form-control">
						</div>
						<div class="form-group">
							<label for="prodi">Program Studi</label>
							<div class="input-group">
								<select class="selectpicker form-control" data-live-search="true" name="prodi" data-size="5">
									<option>- Pilih Program Studi -</option>
									<?php
										$q_prodi = "SELECT * FROM prodi";
										$hasil = mysqli_query($con, $q_prodi);
										if (mysqli_num_rows($hasil) > 0) {
											while ($r_prodi = mysqli_fetch_assoc($hasil)) {
									?>
									<option value="<?php echo $r_prodi['id_prodi']; ?>"><?php echo $r_prodi['nama_prodi']; ?></option>
									<?php
											}
										} else {
									?>
									<option>No data found</option>
									<?php
										}
									?>
								</select>
								<div class="input-group-btn">
									<a class="btn btn-primary" id="btn-1"><i class="fa fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="Sekolah">Asal Sekolah</label>
							<div class="input-group">
								<select class="selectpicker form-control" data-live-search="true" name="sekolah" data-size="5">
									<option>- Pilih Asal Sekolah -</option>
									<?php
										$q_sekolah = "SELECT * FROM asal_sekolah";
										$hasil_sekolah = mysqli_query($con, $q_sekolah);
										if (mysqli_num_rows($hasil_sekolah) > 0) {
											while ($r_sekolah = mysqli_fetch_assoc($hasil_sekolah)) {
									?>
									<option value="<?php echo $r_sekolah['id_sekolah']; ?>"><?php echo $r_sekolah['nama_sekolah']; ?></option>
									<?php
											}
										} else {
									?>
									<option>No data found</option>
									<?php
										}
									?>
								</select>
								<div class="input-group-btn">
									<a class="btn btn-primary" id="btn-2"><i class="fa fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="pj">Nama PJ</label>
							<div class="input-group">
								<select class="selectpicker form-control" data-live-search="true" name="pj" data-size="5">
									<option>- Pilih Nama PJ -</option>
									<?php
										$q_pj = "SELECT * FROM pj";
										$hasil_pj = mysqli_query($con, $q_pj);
										if (mysqli_num_rows($hasil_pj) > 0) {
											while ($r_pj = mysqli_fetch_assoc($hasil_pj)) {
									?>
									<option value="<?php echo $r_pj['id_pj']; ?>"><?php echo $r_pj['nama_pj']; ?></option>
									<?php
											}
										} else {
									?>
									<option>No data found</option>
									<?php
										}
									?>
								</select>
								<div class="input-group-btn">
									<a class="btn btn-primary" id="btn-3"><i class="fa fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="gel">Gelombang Masuk</label>
							<div class="input-group">
								<select class="selectpicker form-control" data-live-search="true" name="gelombang" data-size="5">
									<option>- Pilih Gelombang Masuk -</option>
									<?php
										$q_gelombang = "SELECT * FROM gelombang_masuk";
										$hasil_gelombang = mysqli_query($con, $q_gelombang);
										if (mysqli_num_rows($hasil_gelombang) > 0) {
											while ($r_gelombang = mysqli_fetch_assoc($hasil_gelombang)) {
									?>
									<option value="<?php echo $r_gelombang['id_gelombang']; ?>"><?php echo $r_gelombang['nama_gelombang']; ?></option>
									<?php
											}
										} else {
									?>
									<option>No data found</option>
									<?php
										}
									?>
								</select>
								<div class="input-group-btn">
									<a class="btn btn-primary" id="btn-4"><i class="fa fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="beasiswa">Status Beasiswa</label><br>
							<label class="radio-inline"><input type="radio" name="status_beasiswa" value="1">Ya</label>
							<label class="radio-inline"><input type="radio" name="status_beasiswa" value="2">Tidak</label>
						</div>
						<div class="form-group">
							<label>Tanggal Daftar</label>
							<div class="input-group date" data-provide="datepicker">
							    <input type="text" class="form-control" name="tanggal_daftar">
							    <div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
							    </div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<button type="just_submit" class="btn btn-danger" name="submit_data_and_close" style="border-radius: 0;">Submit</button>
						<button type="submit" class="btn btn-primary" name="submit_data">Submit & Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Modal Tambah Prodi -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-sm">

	    <!-- Modal content-->
	    <form id="f_tambah" action="" method="POST">
	    	<div class="modal-content">
		      <div class="modal-header" style="border-radius: 0; background: #007F30; color: #FFF; padding: 10px; text-align: center;">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Tambah Data</h4>
		      </div>
		      <div class="modal-body">
		        <div class="form-group">
	        		<input id="tambah" type="text" class="form-control" name="" placeholder="">
	        	</div>
		      </div>
		      <div class="modal-footer" style="border-radius: 0; background: #007F30; color: #FFF; padding: 10px; text-align: center;">
		        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
		      </div>
		    </div>
	    </form>

	  </div>
	</div>

</body>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-select.min.js"></script>s
<script src="../js/bootstrap-datepicker.min.js"></script>
<script src="../js/moment.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript">
            $(function () {
							$('.datepicker').datepicker({
								format: 'yyyy-mm-dd',
								startDate: '-3d'
							});
            });
        </script>
<script>
  $(document).ready(function () {
	$('#btn-1').click(function() {
		$('#myModal').modal('show');
		$('#tambah').attr({
			name: 'tambah_prodi',
			placeholder: 'Program Studi'
		});
		$('#f_tambah').attr({
			action: '../proses/p_tambah_prodi.php'
		});
	});

	$('#btn-2').click(function() {
		$('#myModal').modal('show');
		$('#tambah').attr({
			name: 'tambah_sekolah',
			placeholder: 'Nama Sekolah'
		});
		$('#f_tambah').attr({
			action: '../proses/p_tambah_sekolah.php'
		});
	});

	$('#btn-3').click(function() {
		$('#myModal').modal('show');
		$('#tambah').attr({
			name: 'tambah_pj',
			placeholder: 'Nama PJ'
		});
		$('#f_tambah').attr({
			action: '../proses/p_tambah_pj.php'
		});
	});

	$('#btn-4').click(function() {
		$('#myModal').modal('show');
		$('#tambah').attr({
			name: 'tambah_gelombang',
			placeholder: 'Kode Gelombang (Ex. Gelombang 1)'
		});
		$('#f_tambah').attr({
			action: '../proses/p_tambah_gelombang.php'
		});
	});

	$('#txt_prodi').autocomplete({
		source: '../proses/p_cari_prodi.php',
		minLength: 1
	});
  });
</script>
</html>
<?php } ?>
