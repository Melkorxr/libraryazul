<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
if (isset($_POST['submit'])) {
	$nim = $_POST['nim'];
	$nama_pengunjung = mysqli_real_escape_string($conn, $_POST['nama_pengunjung']);
	$fakultas = mysqli_real_escape_string($conn, $_POST['fakultas']);
	$prodi = mysqli_real_escape_string($conn, $_POST['prodi']);
	if (!ctype_digit($nim)) {
		echo '<div class="alert alert-warning">NIM harus berupa angka!</div>';
		exit();
	}
	$sql = mysqli_query($conn, "INSERT INTO pengunjung (nim, nama_pengunjung, fakultas, prodi) 
								VALUES ('$nim', '$nama_pengunjung', '$fakultas', '$prodi')") 
			or die(mysqli_error($conn));

	if ($sql) {
		echo '<script>alert("Data berhasil ditambahkan."); window.location="pengunjung.php";</script>';
	} else {
		echo '<div class="alert alert-warning">Gagal menambahkan data.</div>';
	}
}
?>
<?php include('connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pengunjung</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
    background-image: url("bg3.jpg");
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
.indicator-wrapper {
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	margin-top: 30px;
}
.indicator {
	width: 150px;
	height: 150px;
	background-color: #3498db;
	border-radius: 50%;
	display: flex;
	justify-content: center;
	align-items: center;
	color: white;
	font-size: 40px;
	font-weight: bold;
}
#jumlahPengunjung {
	font-size: 50px;
	font-weight: bold;
	color: #3498db;
	margin-top: 20px;
	text-align: left;
}
.circle-indicator {
width: 150px;
height: 150px;
position: relative;
background-color: #e0e0e0;
border-radius: 50%;
overflow: hidden;
display: inline-block;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.circle-fill {
	width: 100%;
	height: 0;
	position: absolute;
	bottom: 0;
	left: 0;
	background: linear-gradient(180deg, #0000ff, #2980b9);
	transition: height 1.0s linear;
}
.circle-text {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	font-size: 32px;
	font-weight: bold;
	color: #ffffff;
	z-index: 10;
	text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
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
.sidebar li a {
  display: block;
  padding: 25px;
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
  width: 270px;
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
.sidebar .submenu {
	display: none;
	list-style: none;
	padding-left: 20px;
}

.sidebar .submenu li a {
	text-transform: none;
	font-weight: bold;
}
</style>
<body>
	<ul class="sidebar">
		<div class="image-container" style="margin: 20px">
          <img src="iconadmin1.png" height="100%" >
        </div>
	  <li><a href="dashboard_admin.php">Dashboard</a></li>
	  <li><a href="#" onclick="toggleSubmenu1()">Main</a>
            <ul class="submenu" id="submenu-main">
				<li><a href="pengunjung.php">Tambah Pengunjung</a></li>
                <li><a href="tambahbuku.php">Tambah Buku</a></li>
                <li><a href="tambahpinjam.php">TambahPeminjaman</a></li>
            </ul>
    	</li>
	  <li><a href="#" onclick="toggleSubmenu2()">Pusat Data</a>
            <ul class="submenu" id="submenu-pusat-data">
				<li><a href="home.php">Data Pengunjung</a></li>
                <li><a href="buku.php">Data Buku</a></li>
                <li><a href="pinjam.php">Data Peminjaman</a></li>
                <li><a href="reservasi.php">Data Reservasi</a></li>
            </ul>
    	</li>
		<li><a href="#" onclick="toggleSubmenu3()">Manajemen Akun</a>
            <ul class="submenu" id="submenu-manage-akun">
				<li><a href="manajemenakun.php">Akun</a></li>
                <li><a href="request_reset.php">Reset Password</a></li>
            </ul>
        </li>
	  <li><a href="logout.php">Log Out</a></li>
	</ul>
	<div class="container mt-4">
		<div class="header-container">
			<h2>Tambah Pengunjung</h2>
		</div>
		<div class="container my-4">
			<form action="" method="post">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">NIM</label>
					<div class="col-sm-10">
						<input type="text" name="nim" class="form-control" size="4" required placeholder="Masukkan NIM">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">Nama</label>
					<div class="col-sm-10">
						<input type="text" name="nama_pengunjung" class="form-control" size="4" required placeholder="Masukkan Nama">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">Fakultas</label>
					<div class="col-sm-10">
						<input type="text" name="fakultas" class="form-control" size="4" required placeholder="Masukkan Fakultas">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" style="color: #000000;">Prodi</label>
					<div class="col-sm-10">
						<input type="text" name="prodi" class="form-control" size="4" required placeholder="Masukkan Program Studi">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">&nbsp;</label>
					<div class="col-sm-10">
						<br>
						<input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
					</div>
				</div>
			</form>
		</div>
	</div>
	<footer class="footer">
		<h6 style="font-size: 12px;">Copyright &copy LIBRARY of AZUL</h6>
	</footer>
	<script>
        function toggleSubmenu1() {
            const submenu = document.getElementById('submenu-main');
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        }
		function toggleSubmenu2() {
            const submenu = document.getElementById('submenu-pusat-data');
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        }
		function toggleSubmenu3() {
            const submenu = document.getElementById('submenu-manage-akun');
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>