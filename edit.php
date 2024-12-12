<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php include('connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Pengunjung</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" type="image/pmg/jpg" href="logo2.png">
</head>
<style>
	html, body {
    height: 100%; /* Pastikan background mencakup seluruh halaman */
    margin: 0; /* Hilangkan margin default */
    display: flex;
    flex-direction: column;
}

body {
    background-image: url("PerpusAzul.jpg");
    background-size: cover; /* Membuat gambar menutupi seluruh layar */
    background-repeat: no-repeat; /* Menghindari pengulangan gambar */
    background-attachment: fixed; /* Membuat background tetap di tempat saat halaman digulir */
    background-position: center; /* Menempatkan background di tengah */
}

.container {
    flex: 1; /* Membuat area konten mengambil ruang yang tersedia */
    background-color: rgba(255, 255, 255, 0.7); /* Opsional: Tambahkan overlay semi-transparan pada konten */
    padding: 20px;
    border-radius: 10px;
}

footer {
    backdrop-filter: blur(10px);
    color: #060707;
    text-align: center;
    padding: 15px 0;
    font-size: 14px;
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
}

* {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
  padding: 0;
}
.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center; /* Vertically centers the items */
  gap: 10px; /* Adjust space between button and heading */
}
.sidebar {
  height: 100vh;
  width: 200px;
  list-style: none;
  background-color: rgba(255, 255, 255, 0.7);
}
.sidebar li a {
  display: block;
  padding: 10px;
  text-decoration: none;
  color: white;
  font-weight: bold;
  text-transform: uppercase;
  border-bottom: 1px solid silver;
  transition: background-color 0.5s;
}
.sidebar li a:hover {
  background-color: rgba(255, 255, 255, 0.3);
}
.sidebar {
  height: 100vh;
  width: 200px;
  list-style: none;
  background-color: rgba(0, 0, 0, 0.7);
  /* tambahkan kode ini */
  position: fixed;
  left: 0px;
  transition: 0.5s;
}
/* tambahkan selector .sidebar-open di css */
.sidebar-open {
  left: 0;
}
.image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 10%; /* Sesuaikan dengan tinggi yang diinginkan */
}
</style>
<body>
	<ul class="sidebar">
		<div class="image-container" style="margin: 20px">
          <img src="iconadmin.png" height="100%" >
        </div>
	  <li><a href="dashboard_admin.php">Dashboard</a></li>
	  <li><a href="pengunjung.php">Tambah Pengunjung</a></li>
	  <li><a href="tambahbuku.php">Tambah Buku</a></li>
	  <li><a href="tambahpinjam.php">Tambah Pinjam</a></li>
      <li><a href="home.php">Data Pengunjung</a></li>
	  <li><a href="pinjam.php">Data Pinjam</a></li>
	  <li><a href="buku.php">Data Buku</a></li>
	  <li><a href="reservasi.php">Data Reservasi</a></li>
	  <li><a href="manajemenakun.php">Manajemen Akun</a></li>
	  <li><a href="request_reset.php">Reset Password</a></li>
	  <li><a href="logout.php">Log Out</a></li>
	</ul>
	<div class="container mt-4">
		<div class="header-container">
			<h2>Edit Pengunjung</h2>
		</div>
		<?php
		if(isset($_GET['nomor_kunjungan'])){
			$nomor_kunjungan = $_GET['nomor_kunjungan'];
			$select = mysqli_query($conn, "SELECT * FROM pengunjung WHERE nomor_kunjungan='$nomor_kunjungan'") or die(mysqli_error($conn));
			if(mysqli_num_rows($select) == 0){
				echo '<div class="alert alert-warning">Nomor Kunjungan tidak ada dalam database.</div>';
				exit();
			}else{
				$data = mysqli_fetch_assoc($select);
			}
		}
		?>
		<?php
		if(isset($_POST['submit'])){
			$nomor_kunjungan = $_POST['nomor_kunjungan'];
			$nim = $_POST['nim'];
			$nama_pengunjung	= $_POST['nama_pengunjung'];
			$prodi				= $_POST['prodi'];
			$fakultas			= $_POST['fakultas'];
			
			$sql = mysqli_query($conn, "UPDATE pengunjung SET nama_pengunjung='$nama_pengunjung', prodi = '$prodi', nim = '$nim', fakultas='$fakultas' WHERE nomor_kunjungan ='$nomor_kunjungan' ") or die(mysqli_error($conn));
			
			if($sql){
				echo '<script>alert("Berhasil menyimpan data."); document.location="home.php?nomor_kunjungan='.$nomor_kunjungan.'";</script>';
			}else{
				echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
			}
		}
		?>
		<div class="container my-4">
			<form action="edit.php?nomor_kunjungan=<?php echo $nomor_kunjungan; ?>" method="post">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">NAMA PENGUNJUNG</label>
					<div class="col-sm-10">
						<td><input type="hidden" name="nomor_kunjungan" value=<?php echo $_GET['nomor_kunjungan'];?>></td>
						<input type="text" name="nama_pengunjung" class="form-control" value="<?php echo $data['nama_pengunjung']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">NIM</label>
					<div class="col-sm-10">
					<input type="number" name="nim" class="form-control" value="<?php echo $data['nim']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">PRODI</label>
					<div class="col-sm-10">
					<input type="text" name="prodi" class="form-control" value="<?php echo $data['prodi']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">FAKULTAS</label>
					<div class="col-sm-10">
					<input type="text" name="fakultas" class="form-control" value="<?php echo $data['fakultas']; ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">&nbsp;</label>
					<div class="col-sm-10">
						<input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
						<a href="home.php" class="btn btn-warning">KEMBALI</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<footer class="footer">
		<h6 style="font-size: 12px;">Copyright &copy LIBRARY of AZUL</h6>
	</footer>

</body>
</html>