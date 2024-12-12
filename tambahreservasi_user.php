<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
include('connect.php');

// Proses saat form disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pengambilan = $_POST['tanggal_pengambilan'];
    $kontak = $_POST['kontak'];


    // Ambil username dari session
    $username = $_SESSION['username'];

    // Cari ID pengguna berdasarkan username
    $query_user = "SELECT id FROM users WHERE username = '$username'";
    $result_user = mysqli_query($conn, $query_user);

    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_assoc($result_user);
        $user_id = $row_user['id']; // ID pengguna

        // Query untuk memasukkan data ke dalam tabel pinjam
        $query_insert = "INSERT INTO reservasi (nama, id_buku, tanggal_pengambilan, kontak, user) 
                         VALUES ('$nama', '$id_buku', '$tanggal_pengambilan', '$kontak', '$user_id')";

        // Eksekusi query
        if (mysqli_query($conn, $query_insert)) {
            echo "<script>alert('Peminjaman berhasil ditambahkan'); window.location.href='tambahreservasi_user.php';</script>";
        } else {
            echo "Error: " . $query_insert . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Pengguna tidak ditemukan.'); window.location.href='tambahreservasi_user.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/pmg/jpg" href="logo2.png">
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
</head>
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
        <h2 class="header-container"><center>Reservasi</center></h2>
        <hr>
        <div class="container my-4">
            <form action="" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="color: #000000">Atas Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" required placeholder="Masukkan Nama">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="color: #000000">ID Buku</label>
                    <div class="col-sm-10">
                        <input type="text" name="id_buku" placeholder="Masukkan ID Buku" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="color: #000000">Tanggal Pengambilan</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="tanggal_pengambilan" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="color: #000000">Kontak</label>
                    <div class="col-sm-10">
                        <input type="text" name="kontak" class="form-control" required placeholder="Masukkan Nomor Kontak yang bisa dihubungi">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <br>
                        <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                        <input type="reset" name="reset" class="btn btn-warning" value="RESET">
                    </div>
                </div>
            </form>
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
