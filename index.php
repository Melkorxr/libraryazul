<?php
session_start();
include 'connect.php';
require_once 'vendor/autoload.php'; // Pastikan autoload Composer sudah ada

// Login dengan Google
$client = new Google_Client();
$client->setClientId('941940160450-0tta5m6lstmornu27890653cso4sj9vt.apps.googleusercontent.com'); // Ganti dengan Client ID
$client->setClientSecret('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'); // Ganti dengan Client Secret
$client->setRedirectUri('http://localhost/google-callback.php'); // Ganti dengan URL redirect yang benar
$client->addScope("email");

$google_oauthV2 = new Google_Service_Oauth2($client);

// Proses login dengan Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
    $client->setAccessToken($token);

    $user = $google_oauthV2->userinfo->get();
    $username = $user['email'];
    $name = $user['name'];
    
    // Cek apakah pengguna sudah terdaftar
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {
        // Jika tidak terdaftar, daftarkan pengguna
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', 'google', 'user')";
        mysqli_query($conn, $query);
    }

    // Simpan info user ke session
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'user'; // Role default, bisa disesuaikan

    header("Location: dashboard_user.php");
    exit();
}

// Proses login biasa dengan username dan password
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek username di database
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Pengguna ditemukan, ambil data dari database
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password yang dimasukkan
        $db_password = $row['password'];

        if (password_verify($password, $db_password)) {
            // Password cocok dengan hash terenkripsi
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Role dari database (user atau admin)

            // Arahkan ke dashboard sesuai role
            if ($_SESSION['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit();
        } elseif ($password === $db_password) {
            // Password cocok dengan password tidak terenkripsi
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Role dari database (user atau admin)

            // Arahkan ke dashboard sesuai role
            if ($_SESSION['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit();
        } else {
            // Jika password salah
            $error_message = "Username atau password salah!";
        }
    } else {
        // Jika username tidak ditemukan
        $error_message = "Username atau password salah!";
    }
}

$loginUrl = $client->createAuthUrl();
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
        background-image: url("bg1.jpg");
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
            <li><a href="author.php">About Us</a></li>
        </ul>
    </div>
    <div class="form-container">
        <p class="title">Login</p>
        <form class="form" method="POST" action="">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan Username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password">
                <div class="forgot">
                    <a href="request_resetuser.php">Forgot Password?</a>
                </div>
            </div>
            <button type="submit" name="login" value="login" class="sign">Sign in</button>
            <?php
            if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            }
            ?>
        </form>
        <div class="social-message">
            <div class="line"></div>
            <p class="message">Login with social accounts</p>
            <div class="line"></div>
        </div>
        <div class="social-icons">
            <button aria-label="Log in with Google" class="icon">
                <a href="<?= $loginUrl ?>" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-5 h-5 fill-current">
                        <path d="M16.318 13.714v5.484h9.078c-0.37 2.354-2.745 6.901-9.078 6.901-5.458 0-9.917-4.521-9.917-10.099s4.458-10.099 9.917-10.099c3.109 0 5.193 1.318 6.38 2.464l4.339-4.182c-2.786-2.599-6.396-4.182-10.719-4.182-8.844 0-16 7.151-16 16s7.156 16 16 16c9.234 0 15.365-6.49 15.365-15.635 0-1.052-0.115-1.854-0.255-2.651z"></path>
                    </svg>
                </a>
            </button>
        </div>
        <p class="signup">Don't have an account?
            <a href="#">Sign up</a>
        </p>
    </div>
</body>
</html>

