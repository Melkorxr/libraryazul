<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
    <link rel="shortcut icon" type="image/png" href="logo2.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        body {
            margin: 0;
            background-color: #ffffff; /* Background putih */
            color: #1f2937;
        }
        .navbar {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            z-index: 1000;
        }
        .navbar .logo {
            color: #fff;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .navbar .links {
            list-style-type: none;
            display: flex;
            gap: 15px;
        }
        .navbar .links li {
            display: inline;
        }
        .navbar .links a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.5rem;
        }
        .navbar .links a:hover {
            text-decoration: underline rgba(167, 139, 250, 1);
        }
        .slider {
            position: relative;
            width: 100%;
            height: 100vh; /* Slider memenuhi layar */
            overflow: hidden;
        }
        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }
        .slides > div {
            flex: 0 0 100%; /* Setiap slide mengambil 100% lebar */
            height: 100vh; /* Slide memenuhi layar */
            position: relative;
        }
        .slides img {
            width: 100%;
            height: 100%; /* Gambar memenuhi slide */
            object-fit: cover;
        }
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            z-index: 100;
        }
        .slider-nav button {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1.5rem;
            border-radius: 5px;
        }
        .slider-nav button:hover {
            background: rgba(0, 0, 0, 0.7);
        }
        .home-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30%;
            max-width: 800px;
            border-radius: 0.75rem;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 3rem;
            color: rgba(243, 244, 246, 1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            text-align: center;
            z-index: 10;
        }
        .home-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .home-description {
            font-size: 1.3rem;
            color: #ffffff;
            margin-bottom: 2rem;
        }
        .home-btn {
            background-color: #a78bfa;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1.2rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .home-btn:hover {
            background-color: #7c3aed;
        }
        .about-section {
            background-color: #ffffff; /* Latar belakang putih */
            padding: 5rem 2rem;
            text-align: center;
        }

        .about-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .about-title {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1.5rem;
        }

        .about-description {
            font-size: 1.2rem;
            color: #4b5563;
            line-height: 1.6;
        }
        .gallery-section {
            background-color: #F5F5DC; /* Latar belakang putih */
            padding: 5rem 2rem;
            text-align: center;
        }

        .gallery-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .gallery-title {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1.5rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 kolom */
            gap: 1.5rem;
            justify-items: center;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item img:hover {
            transform: scale(1.05); /* Efek zoom saat gambar dihover */
        }
        /* Layout untuk komentar dan kontak */
        .contact-section {
            background-color: #DCDCDC;
            padding: 5rem 2rem;s
            text-align: center;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-title {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1.5rem;
        }

        /* Menggunakan flexbox untuk menata konten */
        .contact-flex {
            display: flex;
            justify-content: space-between;
            gap: 3rem;
            margin-top: 2rem;
            flex-wrap: wrap; /* Agar responsif */
        }

        .comment-section {
            flex: 1;
            text-align: left;
            margin-right: 1rem;
        }

        .right-side {
            flex: 1;
            text-align: left;
        }

        /* Styling form komentar */
        .comment-form textarea {
            width: 100%;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            font-size: 1rem;
            resize: vertical;
            margin-bottom: 1rem;
        }

        .submit-btn {
            background-color: #7c3aed;
            color: white;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #6b2abb;
        }

        /* Styling untuk komentar */
        .comments-container {
            margin-top: 2rem;
            padding: 1rem;
            border-radius: 0.75rem;
            background-color: #f3f4f6;
        }

        .comment-item {
            background-color: #ffffff;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .comment-name {
            font-weight: bold;
            color: #1f2937;
        }

        .comment-date {
            font-size: 0.9rem;
            color: #6b7280;
            margin-left: 1rem;
        }

        .comment-text {
            font-size: 1.1rem;
            color: #4b5563;
            margin-top: 1rem;
        }

        /* Styling untuk lokasi dan kontak */
        .location-section {
            margin-bottom: 2rem;
        }

        .location-description {
            font-size: 0.9rem;
            color: #4b5563;
            line-height: 1.6;
        }

        #map {
            width: 100%;
            height: 300px;
            background-color: #e5e7eb;
            margin-top: 1.5rem;
        }

        .contact-person-section {
            margin-top: 2rem;
        }

        .contact-person-info {
            font-size: 0.9rem;
            color: #4b5563;
            line-height: 1.6;
        }

        .section-subtitle {
            font-size: 1.2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        footer {
            backdrop-filter: blur(10px);
            color: #060707;
            text-align: center;
            padding: 2px 0;
            font-size: 12px;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
            background-color: #A9A9A9;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">AZUL</div>
        <ul class="links">
            <li><a href="landingpage.php">Home</a></li>
            <li><a href="author.php">About Us</a></li>
            <li><a href="index.php">Sign In</a></li>
        </ul>
    </div>
    <div class="slider">
        <div class="slides">
            <div>
                <img src="slide1.jpg" alt="Slide 1">
            </div>
            <div>
                <img src="slide2.jpg" alt="Slide 2">
            </div>
            <div>
                <img src="slide3.jpg" alt="Slide 3">
            </div>
        </div>
        <div class="home-container">
                    <h1 class="home-title">WELCOME TO LIBRARY AZUL</h1>
                    <hr>
                    <p class="home-description">A haven for book lovers and seekers of knowledge! Explore, learn, and discover new worlds through every page you read. Join us today and dive into the world of endless possibilities.</p>
                    <a href="index.php">
                        <button class="home-btn">Get Started</button>
                    </a>
        </div>
        <div class="slider-nav">
            <button id="prev">&#10094;</button>
            <button id="next">&#10095;</button>
        </div>
    </div>
    <section class="about-section">
        <div class="about-container">
            <h2 class="about-title">ABOUT</h2>
            <hr>
            <p class="about-description"> At Library Azul, we offer a comprehensive and diverse collection of books, from timeless classics to the latest reference materials. Our mission is to provide a space where readers can explore a wide variety of books, discover new worlds, and expand their minds. Whether you're into fiction, non-fiction, or academic texts, we offer something for everyone. Enjoy easy access, modern borrowing services, and an inspiring reading atmosphere. With Library Azul, literacy becomes closer and more enjoyable.</p>
        </div>
    </section>
    <section class="gallery-section">
        <div class="gallery-container">
            <h2 class="gallery-title">GALLERY</h2>
            <hr>
            <div class="gallery-grid">
                <div class="gallery-item"><img src="bg1.jpg" alt="Library Image 1"></div>
                <div class="gallery-item"><img src="bg2.jpg" alt="Library Image 2"></div>
                <div class="gallery-item"><img src="bg3.jpg" alt="Library Image 3"></div>
                <div class="gallery-item"><img src="bg4.jpg" alt="Library Image 4"></div>
                <div class="gallery-item"><img src="bg5.jpg" alt="Library Image 5"></div>
                <div class="gallery-item"><img src="bg6.jpg" alt="Library Image 6"></div>
            </div>
        </div>
    </section>
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-flex">
                <!-- Left Side: Comment Section -->
                <div class="comment-section">
                    <h3 class="section-subtitle">LEAVE A COMMENT</h3>
                    <form action="submit_comment.php" method="POST">
                        <textarea name="comment" rows="4" placeholder="Write your comment..." required></textarea>
                        <input type="text" name="name" placeholder="Your Name" required />
                        <button type="submit" class="submit-btn">Submit</button>
                    </form>
                    
                    <!-- Displaying comments -->
                    <h3 class="section-subtitle">COMMENTS</h3>
                    <div class="comments-container">
                        <?php
                        include 'connect.php';

                        // Query to get comments
                        $sql = "SELECT name, comment, created_at FROM comments ORDER BY created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Display each comment
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='comment-item'>";
                                echo "<p class='comment-name'>" . htmlspecialchars($row['name']) . " <span class='comment-date'>" . $row['created_at'] . "</span></p>";
                                echo "<p class='comment-text'>" . htmlspecialchars($row['comment']) . "</p>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No comments yet.</p>";
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>

                <!-- Right Side: Location and Contact Person -->
                <div class="right-side">
                    <div class="location-section">
                        <h3 class="section-subtitle">LOCATION</h3>
                        <p class="location-description">Library Azul is located at the heart of the city, easily accessible for everyone. Our address is: Jalan Library No. 10, Central City.</p>
                        <div id="map" style="height: 300px; width: 100%;"></div>
                    </div>

                    <div class="contact-person-section">
                        <h3 class="section-subtitle">CONTACT US</h3>
                        <p class="contact-person-info">For more inquiries, contact us at:</p>
                        <p class="contact-person-info">Email: contact@azul.com</p>
                        <p class="contact-person-info">Phone: +123-456-7890</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <h6 style="font-size: 12px;">Copyright &copy LIBRARY of AZUL</h6>
    </footer>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13); // Koordinat dan tingkat zoom

        // Menambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Menambahkan marker di lokasi tertentu
        L.marker([51.505, -0.09]).addTo(map)
            .bindPopup('Library Azul') // Teks yang muncul saat marker diklik
            .openPopup();
    </script>
    <script>
        const slides = document.querySelector('.slides');
        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');
        const totalSlides = slides.children.length;
        let index = 0;

        function updateSliderPosition() {
            slides.style.transform = `translateX(-${index * 100}%)`;
        }

        nextButton.addEventListener('click', () => {
            index = (index + 1) % totalSlides;
            updateSliderPosition();
        });

        prevButton.addEventListener('click', () => {
            index = (index - 1 + totalSlides) % totalSlides;
            updateSliderPosition();
        });
    </script>
</body>
</html>
