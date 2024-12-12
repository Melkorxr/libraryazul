<?php
session_start();
include 'connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Pastikan PHPMailer diinstal dan autoload-nya benar
date_default_timezone_set('Asia/Jakarta');
if (isset($_POST['request_reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "SELECT * FROM users WHERE username='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(32)); // Token unik
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token berlaku 1 jam sesuai WIB
        $query = "UPDATE users SET reset_token='$token', token_expires='$expires' WHERE username='$email'";
        mysqli_query($conn, $query);
        $reset_link = "http://localhost/reset_password.php?token=$token";
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            // Set email menggunakan SMTP
            $mail->Host = 'smtp.gmail.com';                               // Ganti dengan server SMTP yang digunakan (misal Gmail)
            $mail->SMTPAuth = true;                                       // Aktifkan otentikasi SMTP
            $mail->Username = 'yayatipango@students.amikom.ac.id';                     // Ganti dengan email pengirim
            $mail->Password = '@pleasehelpme';                      // Ganti dengan password email pengirim
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Gunakan enkripsi TLS
            $mail->Port = 587;                                            // Port SMTP untuk TLS
            $mail->setFrom('azulteam@gmail.com', 'Library of Azul');       // Ganti dengan alamat pengirim
            $mail->addAddress($email);                                    // Tambahkan email penerima
            $mail->isHTML(true);                                           // Kirim email dalam format HTML
            $mail->Subject = 'Reset Your Password';
            $mail->Body    = "Click this link to reset your password: <a href='$reset_link'>$reset_link</a>";
            $mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email is not registered.";
    }
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
    background-image: url("bg4.jpg");
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
</style>
<body>
	<div class="container mt-4">
		<h2 class="header-container">Reset Password</h2>
		<hr>
        <div class="container my-4">
            <form method="POST" action="">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="color: #000000">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" required placeholder="Masukkan Alamat Email">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <br>
                        <input type="submit" name="request_reset" class="btn btn-primary" value="SIMPAN">
                        <input type="reset" name="reset" class="btn btn-warning" value="RESET">
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
