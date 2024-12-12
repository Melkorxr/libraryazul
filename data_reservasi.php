<?php
include('connect.php');
$query = "SELECT COUNT(*) AS total_Rsvs FROM reservasi WHERE status IN ('process', 'bisa diambil')";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$total_Rsvs = $data['total_Rsvs'];
mysqli_close($conn);
echo json_encode(['jumlah_Rsvs' => $total_Rsvs]);
?>
