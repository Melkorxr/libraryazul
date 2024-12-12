<?php
include('connect.php');
$query = "SELECT COUNT(*) AS total_buku FROM buku";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$total_buku = $data['total_buku'];
mysqli_close($conn);
echo json_encode(['jumlah_buku' => $total_buku]);
?>
