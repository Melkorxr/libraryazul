<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    // Periksa apakah koneksi berhasil
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registrasi berhasil!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal! " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login Library</title>
    <link rel="shortcut icon" type="image/pmg/jpg" href="logo2.png">
</head>
<style>
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center; /* Pusatkan secara horizontal */
        align-items: center; /* Pusatkan secara vertikal */
        background-image: url("bg7.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
    }
    .form-container {
        width: 320px;
        border-radius: 0.75rem;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 2rem;
        color: rgba(243, 244, 246, 1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25); /* Tambahkan bayangan */
    }
    .title {
        text-align: center;
        font-size: 1.5rem;
        line-height: 2rem;
        font-weight: 700;
    }
    .form {
        margin-top: 1.5rem;
    }
    .input-group {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
    }
    .input-group label {
        display: block;
        color: rgba(156, 163, 175, 1);
        margin-bottom: 4px;
    }
    .input-group input {
        width: 90%;
        border-radius: 0.375rem;
        border: 1px solid rgba(55, 65, 81, 1);
        outline: 0;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 0.75rem 1rem;
        color: rgba(243, 244, 246, 1);
    }
    .input-group input:focus {
        border-color: rgba(167, 139, 250);
    }
    .forgot {
        display: flex;
        justify-content: flex-end;
        font-size: 0.75rem;
        line-height: 1rem;
        color: rgba(156, 163, 175, 1);
        margin: 8px 0 14px 0;
    }
    .forgot a, .signup a {
        color: rgba(243, 244, 246, 1);
        text-decoration: none;
        font-size: 14px;
    }
    .forgot a:hover, .signup a:hover {
        text-decoration: underline rgba(167, 139, 250, 1);
    }
    .sign {
    display: block;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.7); /* Biru utama */
    padding: 0.75rem;
    text-align: center;
    color: rgba(0, 0, 0, 1); /* Warna teks putih */
    border: none;
    border-radius: 0.375rem;
    font-weight: 600;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Efek transisi */
    }
    .sign:hover {
        background-color: rgba(255, 255, 255, 1); /* Biru lebih gelap untuk hover */
        transform: scale(1.05); /* Sedikit memperbesar tombol */
        cursor: pointer; /* Ubah kursor menjadi pointer */
    }
    .sign:active {
        transform: scale(0.95); /* Efek kecil saat diklik */
        background-color: rgba(255, 255, 255, 2); /* Biru yang lebih gelap untuk efek klik */
    }
    .social-message {
        display: flex;
        align-items: center;
        padding-top: 1rem;
    }
    .line {
        height: 1px;
        flex: 1 1 0%;
        background-color: rgba(55, 65, 81, 1);
    }
    .social-message .message {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: rgba(156, 163, 175, 1);
    }
    .social-icons {
        display: flex;
        justify-content: center;
    }
    .social-icons .icon {
        border-radius: 0.125rem;
        padding: 0.75rem;
        border: none;
        background-color: transparent;
        margin-left: 8px;
    }
    .social-icons .icon svg {
        height: 1.25rem;
        width: 1.25rem;
        fill: #fff;
    }
    .signup {
        text-align: center;
        font-size: 0.75rem;
        line-height: 1rem;
        color: rgba(156, 163, 175, 1);
    }
    .navbar {
    width: 100%; /* Menyesuaikan dengan panjang layar */
    background-color: rgba(0, 0, 0, 0.7); /* Warna navbar */
    padding: 0.5rem 2rem; /* Mengurangi padding agar navbar lebih ramping */
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box; /* Memastikan padding tidak mempengaruhi lebar */
}

.navbar .logo {
    color: #fff;
    font-size: 1.25rem; /* Mengurangi ukuran font logo */
    font-weight: bold;
}

.navbar .links {
    list-style-type: none;
    display: flex;
    gap: 15px; /* Mengurangi jarak antar link */
}

.navbar .links li {
    display: inline;
}

.navbar .links a {
    color: #fff;
    text-decoration: none;
    font-size: 0.9rem; /* Mengurangi ukuran font tautan */
    padding: 0.5rem;
}

.navbar .links a:hover {
    text-decoration: underline rgba(167, 139, 250, 1);
}

</style>
<body>
    <div class="navbar">
        <div class="logo">AZUL</div>
        <ul class="links">
            <li><a href="landingpage.php">Home</a></li>
            <li><a href="author.php">About Us</a></li>
            <li><a href="index.php">Sign In</a></li>
        </ul>
    </div>
    <div class="form-container">
        <p class="title">Sign Up</p>
        <form class="form" method="POST" action="">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan Username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password">
            </div>
            <hr>
            <button type="submit" name="submit" value="submit" class="sign">Sign Up</button>
            <?php
            if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            }
            ?>
        </form>
        <p class="signup">Already have an account?
            <a href="index.php">Login</a>
        </p>
    </div>
</body>
</html>
