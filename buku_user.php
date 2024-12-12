<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
//memasukkan file config.php
include('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Buku</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
    background-image: url("bg2.jpg");
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
</style>
<body>
	<ul class="sidebar">
		<div class="image-container" style="margin: 20px">
          <img src="iconuser2.png" height="100%" >
        </div>
	  <li><a href="dashboard_user.php">Dashboard</a></li>
	  <li><a href="buku_user.php">Daftar Buku</a></li>
	  <li><a href="tambahreservasi_user.php">Reservasi</a></li>
	  <li><a href="riwayat_pinjam.php">Riwayat Peminjaman</a></li>
	  <li><a href="">(coming soon)</a></li>
	  <li><a href="logout.php">Log Out</a></li>
	</ul>	
	<div class="container mt-4">
		<h2 class="header-container"><center>Data Buku Perpustakaan</center></h2>
		<hr>
		<div class="container my-4">
			<form method="GET" action="" class="mb-3">
				<div class="form-row">
					<div class="col-md-4">
						<input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Judul, Penulis, ID" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
					</div>
					<div class="col-md-3">
						<select name="filter_tahun" class="form-control">
							<option value="">Semua Tahun</option>
							<option value="2018" <?= isset($_GET['filter_tahun']) && $_GET['filter_tahun'] === "2018" ? 'selected' : '' ?>>2018</option>
							<option value="2019" <?= isset($_GET['filter_tahun']) && $_GET['filter_tahun'] === "2019" ? 'selected' : '' ?>>2019</option>
							<option value="2020" <?= isset($_GET['filter_tahun']) && $_GET['filter_tahun'] === "2020" ? 'selected' : '' ?>>2020</option>
							<option value="2021" <?= isset($_GET['filter_tahun']) && $_GET['filter_tahun'] === "2021" ? 'selected' : '' ?>>2021</option>
							<option value="2022" <?= isset($_GET['filter_tahun']) && $_GET['filter_tahun'] === "2022" ? 'selected' : '' ?>>2022</option>
							<!-- Tambahkan opsi lainnya sesuai kebutuhan -->
						</select>
					</div>
					<div class="col-md-3">
						<select name="filter_jenis" class="form-control">
							<option value="">Semua jenis</option>
							<option value="Pemrograman" <?= isset($_GET['filter_jenis']) && $_GET['filter_jenis'] === "Pemrograman" ? 'selected' : '' ?>>Pemrograman</option>
							<option value="Teknologi" <?= isset($_GET['filter_jenis']) && $_GET['filter_jenis'] === "Teknologi" ? 'selected' : '' ?>>Teknologi</option>
							<option value="Web Development" <?= isset($_GET['filter_jenis']) && $_GET['filter_jenis'] === "Web Development" ? 'selected' : '' ?>>Web Development</option>
							<!-- Tambahkan opsi lainnya sesuai kebutuhan -->
						</select>
					</div>
					<div class="col-md-3">
						<select name="filter_bahasa" class="form-control">
							<option value="">Semua Bahasa</option>
							<option value="Indonesia" <?= isset($_GET['filter_bahasa']) && $_GET['filter_bahasa'] === "Indonesia" ? 'selected' : '' ?>>Indonesia</option>
							<option value="Inggris" <?= isset($_GET['filter_bahasa']) && $_GET['filter_bahasa'] === "Inggris" ? 'selected' : '' ?>>Inggris</option>
							<!-- Tambahkan opsi lainnya sesuai kebutuhan -->
						</select>
					</div>
					<div class="col-md-3">
						<select name="filter_ketersediaan" class="form-control">
							<option value="">Semua Ketersediaan</option>
							<option value="Tersedia" <?= isset($_GET['filter_ketersediaan']) && $_GET['filter_ketersediaan'] === "Tersedia" ? 'selected' : '' ?>>Tersedia</option>
							<option value="Tidak Tersedia" <?= isset($_GET['filter_ketersediaan']) && $_GET['filter_ketersediaan'] === "Tidak Tersedia" ? 'selected' : '' ?>>Tidak Tersedia</option>
							<!-- Tambahkan opsi lainnya sesuai kebutuhan -->
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary btn-block">Cari</button>
					</div>
				</div>
			</form>
			<table class="table table-striped table-hover table-sm table-bordered">
				<thead class="thead-danger">
					<tr class="table-primary" style="text-align:center">
						<th>ID Buku</th>
						<th>Judul Buku</th>
						<th>Penulis</th>
						<th>Tahun Terbit</th>
						<th>Jenis Buku</th>
						<th>Bahasa</th>
						<th>Ketersediaan</th>
					</tr>
				</thead>
				<tbody>
				<?php
					// Pagination setup
					$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
					$limit = 8;
					$offset = ($page - 1) * $limit;

					// Ambil input dari formulir
					$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
					$filter_tahun = isset($_GET['filter_tahun']) ? mysqli_real_escape_string($conn, $_GET['filter_tahun']) : '';
					$filter_jenis = isset($_GET['filter_jenis']) ? mysqli_real_escape_string($conn, $_GET['filter_jenis']) : '';
					$filter_bahasa = isset($_GET['filter_bahasa']) ? mysqli_real_escape_string($conn, $_GET['filter_bahasa']) : '';
					$filter_ketersedian = isset($_GET['filter_ketersedian']) ? mysqli_real_escape_string($conn, $_GET['filter_ketersedian']) : '';

					// Query untuk pencarian dan filter
					$query = "SELECT * FROM buku WHERE 1=1";

					if (!empty($search)) {
						$query .= " AND (id_buku LIKE '%$search%' OR penulis LIKE '%$search%' OR judul_buku LIKE '%$search%')";
					}
					if (!empty($filter_tahun)) {
						$query .= " AND tahun_terbit = '$filter_tahun'";
					}
					if (!empty($filter_jenis)) {
						$query .= " AND jenis_buku = '$filter_jenis'";
					}
					if (!empty($filter_bahasa)) {
						$query .= " AND bahasa = '$filter_bahasa'";
					}
					if (!empty($filter_ketersediaan)) {
						$query .= " AND ketersediaan = '$filter_ketersediaan'";
					}

					$query .= " ORDER BY id_buku DESC LIMIT $limit OFFSET $offset";

					$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

					// Menampilkan data
					if (mysqli_num_rows($sql) > 0) {
						while ($data = mysqli_fetch_assoc($sql)) {
							echo '
							<tr style="text-align:center">
								<td>' . htmlspecialchars($data['id_buku']) . '</td>
								<td>' . htmlspecialchars($data['judul_buku']) . '</td>
								<td>' . htmlspecialchars($data['penulis']) . '</td>
								<td>' . htmlspecialchars($data['tahun_terbit']) . '</td>
								<td>' . htmlspecialchars($data['jenis_buku']) . '</td>
								<td>' . htmlspecialchars($data['bahasa']) . '</td>
								<td>' . htmlspecialchars($data['ketersedian']) . '</td>
							</tr>';
						}
					} else {
						echo '<tr><td colspan="6">Tidak ada data.</td></tr>';
					}

					// Query total data
					$total_query = "SELECT COUNT(*) AS total FROM buku WHERE 1=1";
					if (!empty($search)) $total_query .= " AND (id_buku LIKE '%$search%' OR penulis LIKE '%$search%' OR judul_buku LIKE '%$search%')";
					if (!empty($filter_tahun)) $total_query .= " AND tahun_terbit = '$filter_tahun'";
					if (!empty($filter_jenis)) $total_query .= " AND jenis_buku = '$filter_jenis'";
					if (!empty($filter_golongan)) $total_query .= " AND golongan = '$filter_golongan'";
					if (!empty($filter_bahasa)) $total_query .= " AND bahasa = '$filter_bahasa'";
					if (!empty($filter_ketersediaan)) $total_query .= " AND ketersediaan = '$filter_ketersediaan'";
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
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>