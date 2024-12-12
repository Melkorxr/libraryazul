<?php
include('connect.php');
date_default_timezone_set('Asia/Jakarta');
$tanggal_hari_ini = date('Y-m-d');
$query = "SELECT COUNT(*) AS total_pengunjung FROM pengunjung WHERE DATE(waktu_berkunjung) = '$tanggal_hari_ini'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$total_pengunjung = $data['total_pengunjung'];
mysqli_close($conn);
echo json_encode(['jumlah_pengunjung' => $total_pengunjung]);
?>
