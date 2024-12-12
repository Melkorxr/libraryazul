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
	<title>Data Peminjaman</title>
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
			<h2>Data Pinjam</h2>
		</div>
		<div class="container my-4">
			<form method="GET" action="" class="mb-3">
				<div class="form-row">
					<div class="col-md-4">
						<input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama, nomor peminjaman" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
					</div>
					<div class="col-md-2">
						<input type="date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>" placeholder="Tanggal Peminjaman">
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary btn-block">Cari</button>
					</div>
				</div>
			</form>
			<table class="table table-striped table-hover table-sm table-bordered">
				<thead class="thead-danger">
					<tr class="table-primary" style="text-align:center">
						<th>No</th>
						<th>Nomor Peminjaman</th>
						<th>Nomor Kunjungan</th>
						<th>ID Buku</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Pengembalian</th>
						<th>Kontak</th>
						<th>Status</th>
						<th>User</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
					$limit = 8;
					$offset = ($page - 1) * $limit;
					$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
					$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
					$query = "SELECT * FROM pinjam WHERE 1=1";
					if (!empty($search)) {
						$query .= " AND (no_pinjam LIKE '%$search%' OR nomor_kunjungan LIKE '%$search%' OR id_buku LIKE '%$search%')";
					}
					if (!empty($start_date)) {
						$query .= " AND tanggal_pinjam >= '$start_date'";
					}
					$query .= " ORDER BY tanggal_pinjam DESC LIMIT $limit OFFSET $offset";
					$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
					$no = 1;
					if (mysqli_num_rows($sql) > 0) {
						while ($data = mysqli_fetch_assoc($sql)) {
							echo '
							<tr style="text-align:center">
								<td>' . htmlspecialchars($no++) . '</td> <!-- Menampilkan nomor urut -->
								<td>' . htmlspecialchars($data['no_pinjam']) . '</td>
								<td>' . htmlspecialchars($data['nomor_kunjungan']) . '</td>
								<td>' . htmlspecialchars($data['id_buku']) . '</td>
								<td>' . htmlspecialchars($data['tanggal_pinjam']) . '</td>
								<td>' . htmlspecialchars($data['tanggal_pengembalian']) . '</td>
								<td>' . htmlspecialchars($data['kontak']) . '</td>
								<td>' . htmlspecialchars($data['status']) . '</td>
								<td>' . htmlspecialchars($data['user']) . '</td>
								<td>
									<a href="editpinjam.php?no_pinjam=' . urlencode($data['no_pinjam']) . '" class="badge badge-warning">Edit</a>
									<a href="deletepinjam.php?no_pinjam=' . urlencode($data['no_pinjam']) . '" class="badge badge-danger" onclick="return confirm(\'Yakin ingin menghapus data ini?\')">Delete</a>
								</td>
							</tr>';
						}
					} else {
						echo '<tr><td colspan="6">Tidak ada data.</td></tr>';
					}
					$total_query = "SELECT COUNT(*) AS total FROM pinjam WHERE 1=1";
					if (!empty($search)) $total_query .= " AND (no_pinjam LIKE '%$search%' OR nomor_kunjungan LIKE '%$search%' OR id_buku LIKE '%$search%')";
					if (!empty($start_date)) $total_query .= " AND tanggal_pinjam >= '$start_date'";
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