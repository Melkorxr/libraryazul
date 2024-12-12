<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
include 'connect.php';
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Pastikan halaman minimal adalah 1
$offset = ($page - 1) * $limit;
$totalQuery = "SELECT COUNT(*) as total FROM pinjam WHERE status IN ('belum dikembalikan', 'diperpanjang')";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalData = $totalRow['total'];
$totalPages = ceil($totalData / $limit);
$query = "SELECT no_pinjam, nomor_kunjungan, id_buku, tanggal_pinjam, tanggal_pengembalian, kontak, status 
          FROM pinjam 
          WHERE status IN ('belum dikembalikan', 'diperpanjang') 
          ORDER BY tanggal_pinjam DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
$totalQuery = "SELECT COUNT(*) as total FROM reservasi WHERE status IN ('process', 'bisa diambil')";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalData = $totalRow['total'];
$totalPages = ceil($totalData / $limit);
$query = "SELECT no_rsvs, nama, id_buku, tanggal_pengambilan, kontak, status 
          FROM reservasi 
          WHERE status IN ('process', 'bisa diambil') 
          ORDER BY tanggal_pengambilan DESC 
          LIMIT $limit OFFSET $offset";
$resultRsvs = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" type="image/png/jpg" href="logo2.png">
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
	<script src="https://cdn.rawgit.com/mikeerickson/CountUp.js/master/dist/countUp.min.js"></script>
</head>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Poppins:400,600,700,700i');
	@import url('https://fonts.googleapis.com/css?family=Roboto+Slab:300,400');
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
		<h2 class="header-container"><center>Welcome, This is Admin Dashboard!</center></h2>
		<hr>
        <div class="row-6" style="display: flex; justify-content: center; gap: 20px;">
            <div class="col-3" style="flex: 1; text-align: center;">
                <h5 style="font-weight: bold; margin: 30px 0px;">PENGUNJUNG</h5>
                <div class="circle-indicator">
                    <div class="circle-fill" id="circleFill"></div>
                    <div class="circle-text" id="circleText">0</div>
                </div>
            </div>
			<div class="col-3" style="flex: 1; text-align: center;">
				<h5 style="font-weight: bold; margin: 30px 0px;">JUMLAH BUKU</h5>
				<div class="circle-indicator">
					<div class="circle-fill" id="circleFillBuku"></div>
					<div class="circle-text" id="circleTextBuku">0</div>
				</div>
			</div>
			<div class="col-3" style="flex: 1; text-align: center;">
				<h5 style="font-weight: bold; margin: 30px 0px;">JUMLAH RESERVASI</h5>
				<div class="circle-indicator">
					<div class="circle-fill" id="circleFillRsvs"></div>
					<div class="circle-text" id="circleTextRsvs">0</div>
				</div>
			</div>
			<div class="col-3" style="flex: 1; text-align: center;">
				<h5 style="font-weight: bold; margin: 30px 0px;">JUMLAH PEMINJAMAN</h5>
				<div class="circle-indicator">
					<div class="circle-fill" id="circleFillpinjam"></div>
					<div class="circle-text" id="circleTextpinjam">0</div>
				</div>
			</div>
        </div>
		<div class="container my-4">
			<h2 style="text-align: center; margin: 20px 0;">Reservasi</h2>
			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>No Reservasi</th>
						<th>Atas Nama</th>
						<th>ID Buku</th>
						<th>Waktu Pengambilan</th>
						<th>Kontak</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = $offset + 1;

					if (mysqli_num_rows($resultRsvs) > 0) {
						while ($row = mysqli_fetch_assoc($resultRsvs)) {
							echo "<tr>";
							echo "<td>" . $row['no_rsvs'] . "</td>";
							echo "<td>" . $row['nama'] . "</td>";
							echo "<td>" . $row['id_buku'] . "</td>";
							echo "<td>" . $row['tanggal_pengambilan'] . "</td>";
							echo "<td>" . $row['kontak'] . "</td>";
							echo "<td>" . ucfirst($row['status']) . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data Reservasi.</td></tr>";
					}
					?>
				</tbody>
			</table>
			<nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">
					<?php if ($page > 1): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
					<?php endif; ?>
					<?php for ($i = 1; $i <= $totalPages; $i++): ?>
						<li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
							<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
						</li>
					<?php endfor; ?>
					<?php if ($page < $totalPages): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
		</div>
		<div class="container my-4">
			<h2 style="text-align: center; margin: 20px 0;">Peminjaman</h2>
			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>No</th>
						<th>Nomor Peminjaman</th>
						<th>Nomor Kunjungan</th>
						<th>ID Buku</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Pengembalian</th>
						<th>Kontak</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = $offset + 1;

					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>" . $no++ . "</td>";
							echo "<td>" . $row['no_pinjam'] . "</td>";
							echo "<td>" . $row['nomor_kunjungan'] . "</td>";
							echo "<td>" . $row['id_buku'] . "</td>";
							echo "<td>" . $row['tanggal_pinjam'] . "</td>";
							echo "<td>" . $row['tanggal_pengembalian'] . "</td>";
							echo "<td>" . $row['kontak'] . "</td>";
							echo "<td>" . ucfirst($row['status']) . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data peminjaman.</td></tr>";
					}
					?>
				</tbody>
			</table>
			<nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">
					<?php if ($page > 1): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
					<?php endif; ?>
					<?php for ($i = 1; $i <= $totalPages; $i++): ?>
						<li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
							<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
						</li>
					<?php endfor; ?>
					<?php if ($page < $totalPages): ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
		</div>
	</div>

	<footer class="footer">
		<h6 style="font-size: 12px;">Copyright &copy LIBRARY of AZUL</h6>
	</footer>

	<script>
		fetch('data_pengunjung.php')
			.then(response => response.json())
			.then(data => {
				let jumlahPengunjung = data.jumlah_pengunjung;
				let currentCount = 0;
				let targetCount = jumlahPengunjung;
				let animationSpeed = 300;
				let step = Math.ceil(targetCount / 300);
				let percentage = 0;
				const circleFill = document.getElementById('circleFill');
				const circleText = document.getElementById('circleText');
				let interval = setInterval(function () {
					if (currentCount < targetCount) {
						currentCount += Math.ceil(targetCount / 100); // Tingkat kenaikan angka
						percentage = Math.min((currentCount / targetCount) * 100, 100); // Hitung persentase
						circleText.textContent = Math.min(currentCount, targetCount); // Update angka
						circleFill.style.height = `${percentage}%`; // Update tinggi air
					} else {
						clearInterval(interval);
					}
				}, animationSpeed);
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Terjadi kesalahan saat memuat data.");
			});
		fetch('data_buku.php')
			.then(response => response.json())
			.then(data => {
				let jumlahBuku = data.jumlah_buku;
				let currentCountBuku = 0;
				let targetCountBuku = jumlahBuku;
				let animationSpeedBuku = 300;
				const circleFillBuku = document.getElementById('circleFillBuku');
				const circleTextBuku = document.getElementById('circleTextBuku');
				let intervalBuku = setInterval(function () {
					if (currentCountBuku < targetCountBuku) {
						currentCountBuku += Math.ceil(targetCountBuku / 100); // Tingkat kenaikan angka
						let percentageBuku = Math.min((currentCountBuku / targetCountBuku) * 100, 100); // Hitung persentase
						circleTextBuku.textContent = Math.min(currentCountBuku, targetCountBuku); // Update angka
						circleFillBuku.style.height = `${percentageBuku}%`; // Update tinggi air
					} else {
						clearInterval(intervalBuku);
					}
				}, animationSpeedBuku);
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Terjadi kesalahan saat memuat data buku.");
			});
		fetch('data_reservasi.php')
			.then(response => response.json())
			.then(data => {
				let jumlahRsvs = data.jumlah_Rsvs;
				let currentCountRsvs = 0;
				let targetCountRsvs = jumlahRsvs;
				let animationSpeedRsvs = 300;
				const circleFillRsvs = document.getElementById('circleFillRsvs');
				const circleTextRsvs = document.getElementById('circleTextRsvs');
				let intervalRsvs = setInterval(function () {
					if (currentCountRsvs < targetCountRsvs) {
						currentCountRsvs += Math.ceil(targetCountRsvs / 100); // Tingkat kenaikan angka
						let percentageRsvs = Math.min((currentCountRsvs / targetCountRsvs) * 100, 100); // Hitung persentase
						circleTextRsvs.textContent = Math.min(currentCountRsvs, targetCountRsvs); // Update angka
						circleFillRsvs.style.height = `${percentageRsvs}%`; // Update tinggi air
					} else {
						clearInterval(intervalRsvs);
					}
				}, animationSpeedRsvs);
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Terjadi kesalahan saat memuat data reservasi.");
			});
		fetch('data_peminjaman.php')
			.then(response => response.json())
			.then(data => {
				let jumlahpinjam = data.jumlah_pinjam;
				let currentCountpinjam = 0;
				let targetCountpinjam = jumlahpinjam;
				let animationSpeedpinjam = 300;
				const circleFillpinjam = document.getElementById('circleFillpinjam');
				const circleTextpinjam = document.getElementById('circleTextpinjam');
				let intervalpinjam = setInterval(function () {
					if (currentCountpinjam < targetCountpinjam) {
						currentCountpinjam += Math.ceil(targetCountpinjam / 100); // Tingkat kenaikan angka
						let percentagepinjam = Math.min((currentCountpinjam / targetCountpinjam) * 100, 100); // Hitung persentase
						circleTextpinjam.textContent = Math.min(currentCountpinjam, targetCountpinjam); // Update angka
						circleFillpinjam.style.height = `${percentagepinjam}%`; // Update tinggi air
					} else {
						clearInterval(intervalpinjam);
					}
				}, animationSpeedpinjam);
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Terjadi kesalahan saat memuat data reservasi.");
			});
	</script>
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