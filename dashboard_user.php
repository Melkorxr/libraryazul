<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'connect.php';

// Tentukan jumlah data per halaman
$limit = 5;

// Ambil halaman saat ini dari parameter URL, jika tidak ada maka halaman default adalah 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Pastikan halaman minimal adalah 1

// Hitung offset
$offset = ($page - 1) * $limit;

// Ambil username dari sesi
$username = $_SESSION['username'];

// Query untuk mendapatkan ID pengguna berdasarkan username
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_row = $result->fetch_assoc();
$user_id = $user_row['id']; // ID pengguna berdasarkan username

// Hitung total data berdasarkan user
$totalQuery = "SELECT COUNT(*) as total 
               FROM pinjam 
               WHERE user = ? 
                 AND status IN ('belum dikembalikan', 'diperpanjang')";

$stmt = $conn->prepare($totalQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$totalResult = $stmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalData = $totalRow['total'];

// Hitung total halaman
$totalPages = ceil($totalData / $limit);

// Query untuk mengambil data dengan limit dan offset berdasarkan user
$dataQuery = "SELECT no_pinjam, nomor_kunjungan, id_buku, tanggal_pinjam, tanggal_pengembalian, kontak, status 
              FROM pinjam 
              WHERE user = ? 
                AND status IN ('belum dikembalikan', 'diperpanjang') 
              ORDER BY tanggal_pinjam DESC 
              LIMIT ? OFFSET ?";

$stmt = $conn->prepare($dataQuery);
$stmt->bind_param("iii", $user_id, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Hitung total data reservasi berdasarkan user
$totalRsvsQuery = "SELECT COUNT(*) as total 
                   FROM reservasi 
                   WHERE user = ?";

$stmt = $conn->prepare($totalRsvsQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$totalRsvsResult = $stmt->get_result();
$totalRsvsRow = $totalRsvsResult->fetch_assoc();
$totalRsvsData = $totalRsvsRow['total'];

// Hitung total halaman untuk reservasi
$totalRsvsPages = ceil($totalRsvsData / $limit);

// Query untuk mengambil data reservasi berdasarkan user
$dataRsvsQuery = "SELECT no_rsvs, nama, id_buku, tanggal_pengambilan, kontak, status 
                  FROM reservasi 
                  WHERE user = ? 
                  ORDER BY tanggal_pengambilan DESC 
                  LIMIT ? OFFSET ?";

$stmt = $conn->prepare($dataRsvsQuery);
$stmt->bind_param("iii", $user_id, $limit, $offset);
$stmt->execute();
$resultRsvs = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" type="image/pmg/jpg" href="logo2.png">
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
		<h2 class="header-container"><center>Welcome, This is your dashboard!</center></h2>
		<hr>
		<div class="container my-4">
			<div id="content" class="content">
				<h2 class="text-center">Reservasi</h2>
				<table class="table table-bordered table-striped">
					<thead class="thead-dark">
						<tr>
							<th>No Reservasi</th>
							<th>Atas Nama</th>
							<th>ID Buku</th>
							<th>Tanggal Pengambilan</th>
							<th>Kontak</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = $offset + 1;
						if ($resultRsvs->num_rows > 0) {
							while ($row = $resultRsvs->fetch_assoc()) {
								echo "<tr>";
								echo "<td>" . htmlspecialchars($row['no_rsvs']) . "</td>";
								echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
								echo "<td>" . htmlspecialchars($row['id_buku']) . "</td>";
								echo "<td>" . htmlspecialchars($row['tanggal_pengambilan']) . "</td>";
								echo "<td>" . htmlspecialchars($row['kontak']) . "</td>";
								echo "<td>" . ucfirst(htmlspecialchars($row['status'])) . "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='8' class='text-center'>Belum Melakukan Reservasi.</td></tr>";
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
		<div class="container my-4">
			<h2 class="text-center">Peminjaman</h2>
			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>No</th>
						<th>Nomor Peminjaman</th>
						<th>ID Buku</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Pengembalian</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = $offset + 1;
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "<tr>";
							echo "<td>" . $no++ . "</td>";
							echo "<td>" . htmlspecialchars($row['no_pinjam']) . "</td>";
							echo "<td>" . htmlspecialchars($row['id_buku']) . "</td>";
							echo "<td>" . htmlspecialchars($row['tanggal_pinjam']) . "</td>";
							echo "<td>" . htmlspecialchars($row['tanggal_pengembalian']) . "</td>";
							echo "<td>" . ucfirst(htmlspecialchars($row['status'])) . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='8' class='text-center'>Belum melakukan peminjaman.</td></tr>";
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
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script>
		const toggleSidebar = document.querySelector("#toggle-sidebar");
		const sidebar = document.querySelector(".sidebar");

		toggleSidebar.addEventListener("click", () => {
		sidebar.classList.toggle("sidebar-open");
		});
	</script>

</body>
</html>
