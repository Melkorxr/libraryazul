<?php
session_start();
include 'connect.php';

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    // Verifikasi token
    $query = "SELECT * FROM users WHERE reset_token='$token' AND token_expires > NOW()";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        if (isset($_POST['reset_password'])) {
            $row = mysqli_fetch_assoc($result);
            $email = $row['username'];
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Perbarui password dan hapus token
            $query = "UPDATE users SET password='$hashed_password', reset_token=NULL, token_expires=NULL WHERE username='$email'";
            mysqli_query($conn, $query);

            echo "Password has been reset successfully!";
            exit();
        }
    } else {
        echo "Invalid or expired token.";
        exit();
    }
} else {
    echo "No token provided.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reset Password</title>
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
    background-image: url("bg5.jpg");
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
.reset {
display: block;
width: 20%;
background-color: rgba(43, 191, 254, 0.7); /* Biru utama */
padding: 0.75rem;
text-align: center;
align-items: center;
color: rgba(255, 255, 255, 1); /* Warna teks putih */
border: none;
border-radius: 0.375rem;
font-weight: 600;
transition: background-color 0.3s ease, transform 0.2s ease; /* Efek transisi */
margin-left: 180px;
}
.reset:hover {
    background-color: rgba(43, 191, 254, 1); /* Biru lebih gelap untuk hover */
    transform: scale(1.05); /* Sedikit memperbesar tombol */
    cursor: pointer; /* Ubah kursor menjadi pointer */
}
.reset:active {
    transform: scale(0.95); /* Efek kecil saat diklik */
    background-color: rgba(43, 191, 254, 2); /* Biru yang lebih gelap untuk efek klik */
}
</style>
<body>
	<div class="container mt-4">
		<h2 class="header-container">Set New Password</h2>
		<hr>
        <div class="container my-4">
            <form method="POST" action="">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="color: #000000">New Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="new_password" class="form-control" required placeholder="Masukkan Password Baru">
                    </div>
                </div>
                <button type="submit" name="reset_password" class="reset">Reset Password</button>
            </form>
        </div>
    </div>
    <footer class="footer">
		<h6 style="font-size: 12px;">Copyright &copy LIBRARY of AZUL</h6>
	</footer>
</body>
</html>
