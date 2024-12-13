<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>About Us</title>
    <link rel="shortcut icon" type="image/png" href="logo2.png">
</head>
<style>
    body {
        margin: 0;
        background-color: #f3f4f6;
        background-image: url('bg6.jpg');
        color: #1f2937;
        background-size: cover; /* Membuat gambar menutupi seluruh layar */
        background-repeat: no-repeat; /* Menghindari pengulangan gambar */
        background-attachment: fixed; /* Membuat background tetap di tempat saat halaman digulir */
        background-position: center; /* Menempatkan background di tengah */
        display: flex;
        justify-content: center; /* Pusatkan secara horizontal */
        align-items: center;    /* Pusatkan secara vertikal */
        height: 100vh;          /* Pastikan body memiliki tinggi penuh layar */
        margin: 0;              /* Hilangkan margin default */
    }
    .about-container {
        width: 100%;
        max-width: 1300px;
        border-radius: 0.75rem;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 3rem;
        color: rgba(243, 244, 246, 1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        text-align: center;
    }
    .about-title {
        padding: 0px;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    .about-description {
        font-size: 1.3rem;
        font-style: Poppins;
        color: #ffffff;
        margin-bottom: 2rem;
    }
    .cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 250px;
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        margin-bottom: 1rem;
    }
    .card .name {
        font-size: 1.25rem;
        font-weight: bold;
        color: #000000;
        margin-bottom: 0.5rem;
    }
    .card .role {
        font-size: 1rem;
        color: #000000;
        margin-bottom: 0.5rem;
    }
    .card .bio {
        font-size: 0.875rem;
        color: #000000;
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
</style>s
<body>
    <div class="navbar">
        <div class="logo">AZUL</div>
        <ul class="links">
            <li><a href="landingpage.php">Home</a></li>
            <li><a href="author.php">About Us</a></li>
            <li><a href="index.php">Sign In</a></li>
        </ul>
    </div>
    <div class="about-container">
        <h1 class="about-title">ABOUT US</h1>
        <hr>
        <p class="about-description">We are a dedicated team striving to revolutionize the library experience. Together, we bring innovation, passion, and excellence to every project. Our mission is to create a seamless, engaging, and user-friendly platform. Driven by collaboration, we aim to inspire and empower our community. Meet the brilliant minds behind our journey!</p>
        <div class="cards">
            <!-- Card 1 -->
            <div class="card">
                <img src="profil-img3.jpg" alt="John Doe">
                <div class="name">Muhammad Fahrun Nasyit</div>
                <div class="role">Database Administrator</div>
                <p class="bio">Membuat fitur manajemen data antara lain: CRUD, Search & Filter.</p>
            </div>
            <!-- Card 2 -->
            <div class="card">
                <img src="notfound.jpg" alt="Jane Smith">
                <div class="name">Zaimy Cakra Andika</div>
                <div class="role">Frontend Developer</div>
                <p class="bio">Jane specializes in creating stunning user interfaces that are both functional and aesthetic.</p>
            </div>
            <!-- Card 3 -->
            <div class="card">
                <img src="profil-img1.jpg" alt="Michael Brown">
                <div class="name">Muhammad Hidayatullah Ipango</div>
                <div class="role">Backend Developer</div>
                <p class="bio">Membuat Fitur Autentikasi, Otorisasi, Dashboard dan Navigasi serta Manajemen Author.</p>
            </div>
            <!-- Card 4 -->
            <div class="card">
                <img src="profil-img4.jpg" alt="Emily White">
                <div class="name">Rayhand Tirtadistira Mile</div>
                <div class="role">UI/UX Designer</div>
                <p class="bio">Emily loves designing user-friendly experiences that engage and inspire.</p>
            </div>
        </div>
    </div>
</body>
</html>
