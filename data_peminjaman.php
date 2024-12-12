<?php
include('connect.php');
$query = "SELECT COUNT(*) AS total_pinjam FROM pinjam WHERE status IN ('Belum dikembalikan', 'Diperpanjang')";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$total_pinjam = $data['total_pinjam'];
mysqli_close($conn);
echo json_encode(['jumlah_pinjam' => $total_pinjam]);
?>
