<?php
include 'connect.php';

// Ambil data dari form
$name = $_POST['name'];
$comment = $_POST['comment'];

// Query untuk menyimpan komentar
$sql = "INSERT INTO comments (name, comment) VALUES ('$name', '$comment')";

if ($conn->query($sql) === TRUE) {
    // Mengarahkan kembali ke halaman landing setelah pengiriman
    header("Location: landingpage.php?status=success");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
