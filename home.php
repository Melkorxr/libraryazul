<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
include('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Data Pengunjung</title>
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
		<h2 class="header-container">Data Pengunjung</h2>
		<hr>
		<div class="container my-4">
			<form method="GET" action="" class="mb-3">
				<div class="form-row">
					<div class="col-md-4">
						<input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau NIM" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
					</div>
					<div class="col-md-3">
						<select name="filter_prodi" class="form-control">
							<option value="">Semua Prodi</option>
							<option value="Fisika" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Fisika" ? 'selected' : '' ?>>Fisika</option>
							<option value="Biologi" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Biologi" ? 'selected' : '' ?>>Biologi</option>
							<option value="Matematika" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Matematika" ? 'selected' : '' ?>>Matematika</option>
							<option value="Informatika" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Informatika" ? 'selected' : '' ?>>Informatika</option>
							<option value="Teknik Elektro" <?= isset($_GET['filter_prodi']) && $_GET['filter_prodi'] === "Teknik Elektro" ? 'selected' : '' ?>>Teknik Elektro</option>
						</select>
					</div>
					<div class="col-md-3">
						<select name="filter_fakultas" class="form-control">
							<option value="">Semua Fakultas</option>
							<option value="Fakultas Sains" <?= isset($_GET['filter_fakultas']) && $_GET['filter_fakultas'] === "Fakultas Sains" ? 'selected' : '' ?>>Fakultas Sains</option>
							<option value="Fakultas Teknik" <?= isset($_GET['filter_fakultas']) && $_GET['filter_fakultas'] === "Fakultas Teknik" ? 'selected' : '' ?>>Fakultas Teknik</option>
						</select>
					</div>
					<div class="col-md-2">
						<input type="date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>" placeholder="Dari Tanggal">
					</div>
					<div class="col-md-2">
						<input type="date" name="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>" placeholder="Sampai Tanggal">
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary btn-block">Cari</button>
					</div>
				</div>
			</form>
			<table class="table table-striped table-hover table-sm table-bordered">
				<thead class="thead-danger">
					<tr class="table-primary" style="text-align:center">
						<th>NO.</th>
						<th>NIM</th>
						<th>NAMA PENGUNJUNG</th>
						<th>PRODI</th>
						<th>FAKULTAS</th>
						<th>WAKTU BERKUNJUNG</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
					$limit = 12;
					$offset = ($page - 1) * $limit;
					$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
					$filter_prodi = isset($_GET['filter_prodi']) ? mysqli_real_escape_string($conn, $_GET['filter_prodi']) : '';
					$filter_fakultas = isset($_GET['filter_fakultas']) ? mysqli_real_escape_string($conn, $_GET['filter_fakultas']) : '';
					$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
					$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';
					$query = "SELECT * FROM pengunjung WHERE 1=1";
					if (!empty($search)) {
						$query .= " AND (nim LIKE '%$search%' OR nama_pengunjung LIKE '%$search%' nomor_kunjungan LIKE '%$search%')";
					}
					if (!empty($filter_prodi)) {
						$query .= " AND prodi = '$filter_prodi'";
					}
					if (!empty($filter_fakultas)) {
						$query .= " AND fakultas = '$filter_fakultas'";
					}
					if (!empty($start_date)) {
						$query .= " AND waktu_berkunjung >= '$start_date'";
					}
					if (!empty($end_date)) {
						$query .= " AND waktu_berkunjung <= '$end_date'";
					}
					$query .= " ORDER BY nomor_kunjungan DESC LIMIT $limit OFFSET $offset";
					$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
					if (mysqli_num_rows($sql) > 0) {
						while ($data = mysqli_fetch_assoc($sql)) {
							echo '
							<tr style="text-align:center">
								<td>' . htmlspecialchars($data['nomor_kunjungan']) . '</td>
								<td>' . htmlspecialchars($data['nim']) . '</td>
								<td>' . htmlspecialchars($data['nama_pengunjung']) . '</td>
								<td>' . htmlspecialchars($data['prodi']) . '</td>
								<td>' . htmlspecialchars($data['fakultas']) . '</td>
								<td>' . htmlspecialchars($data['waktu_berkunjung']) . '</td>
								<td>
									<a href="edit.php?nomor_kunjungan=' . urlencode($data['nomor_kunjungan']) . '" class="badge badge-warning">Edit</a>
									<a href="delete.php?nomor_kunjungan=' . urlencode($data['nomor_kunjungan']) . '" class="badge badge-danger" onclick="return confirm(\'Yakin ingin menghapus data ini?\')">Delete</a>
								</td>
							</tr>';
						}
					} else {
						echo '<tr><td colspan="6">Tidak ada data.</td></tr>';
					}
					$total_query = "SELECT COUNT(*) AS total FROM pengunjung WHERE 1=1";
					if (!empty($search)) $total_query .= " AND (nim LIKE '%$search%' OR nama_pengunjung LIKE '%$search%' nomor_kunjungan LIKE '%$search%')";
					if (!empty($filter_prodi)) $total_query .= " AND prodi = '$filter_prodi'";
					if (!empty($filter_fakultas)) $total_query .= " AND fakultas = '$filter_fakultas'";
					if (!empty($start_date)) $total_query .= " AND waktu_berkunjung >= '$start_date'";
					if (!empty($end_date)) $total_query .= " AND waktu_berkunjung <= '$end_date'";
					$total_result = mysqli_query($conn, $total_query);
					$total_data = mysqli_fetch_assoc($total_result)['total'];
					$total_pages = ceil($total_data / $limit);
					?>
				<tbody>
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
					<?php for ($i = 1; $i <= $total_pages; $i++): ?>
						<li class="page-item <?= $i == $page ? 'active' : '' ?>">
							<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
						</li>
					<?php endfor; ?>
					<?php if ($page < $total_pages): ?>
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