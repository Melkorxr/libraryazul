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
	<title>Edit Buku</title>
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
			<h2>Edit Buku</h2>
		</div>
        <div class="container my-4">
            <?php
            if (isset($_GET['id_buku'])) {
                $id_buku = $_GET['id_buku'];
                $select = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku='$id_buku'");
                if (!$select) {
                    die("Query gagal: " . mysqli_error($conn));  // Menampilkan pesan kesalahan jika query gagal
                }
                if (mysqli_num_rows($select) == 0) {
                    echo '<div class="alert alert-warning">No peminjaman tidak ada dalam database.</div>';
                    exit();
                } else {
                    // Menyimpan data dari query ke variabel $data
                    $data = mysqli_fetch_assoc($select);
                }
            } else {
                // Jika id_buku tidak ada di URL, tampilkan pesan kesalahan
                echo '<div class="alert alert-danger">No peminjaman tidak ditemukan di URL.</div>';
                exit();
            }
            ?>
            <?php
            if (isset($_POST['submit'])) {
                $id_buku = $_POST['id_buku'];
                $judul_buku = $_POST['judul_buku'];
                $penulis = $_POST['penulis'];
                $tahun_terbit = $_POST['tahun_terbit'];
                $jenis_buku = $_POST['jenis_buku'];
                $bahasa = $_POST['bahasa'];
                $ketersedian = $_POST['ketersedian'];
                $sql = mysqli_query($conn, "UPDATE buku SET penulis='$penulis', tahun_terbit='$tahun_terbit', id_buku='$id_buku', jenis_buku='$jenis_buku', bahasa='$bahasa', ketersedian='$ketersedian' WHERE id_buku='$id_buku'");
                if ($sql) {
                    echo '<script>alert("Berhasil menyimpan data."); document.location="editbuku.php?id_buku='.$id_buku.'";</script>';
                } else {
                    echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
                }
            }
            ?>
            <form action="editbuku.php?id_buku=<?php echo $id_buku; ?>" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ID Buku</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
                        <input type="text" name="judul_buku" class="form-control" value="<?php echo isset($data['judul_buku']) ? $data['judul_buku'] : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" name="penulis" class="form-control" value="<?php echo isset($data['penulis']) ? $data['penulis'] : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tahun Terbit</label>
                    <div class="col-sm-10">
                        <input type="number" name="tahun_terbit" class="form-control" value="<?php echo isset($data['tahun_terbit']) ? $data['tahun_terbit'] : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Buku</label>
                    <div class="col-sm-10">
                        <input type="text" name="jenis_buku" class="form-control" value="<?php echo isset($data['jenis_buku']) ? $data['jenis_buku'] : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bahasa</label>
                    <div class="col-sm-10">
                        <input type="text" name="bahasa" class="form-control" value="<?php echo isset($data['bahasa']) ? $data['bahasa'] : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ketersedian</label>
                    <div class="col-sm-10">
                        <input type="text" name="ketersedian" class="form-control" value="<?php echo isset($data['ketersedian']) ? $data['ketersedian'] : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                        <a href="buku.php" class="btn btn-warning">KEMBALI</a>
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
