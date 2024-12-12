<?php
include('connect.php');
if(isset($_GET['nomor_kunjungan'])){
	$nomor_kunjungan = $_GET['nomor_kunjungan'];
	$cek = mysqli_query($conn, "SELECT * FROM pengunjung WHERE nomor_kunjungan='$nomor_kunjungan'") or die(mysqli_error($conn));
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($conn, "DELETE FROM pengunjung WHERE nomor_kunjungan='$nomor_kunjungan'") or die(mysqli_error($conn));
		if($del){
			echo '<script>alert("Berhasil menghapus data."); document.location="home.php";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data."); document.location="home.php";</script>';
		}
	}else{
		echo '<script>alert("Nomor kunjungan tidak ditemukan di database."); document.location="home.php";</script>';
	}
}else{
	echo '<script>alert("Nomor Kunjungan tidak ditemukan di database."); document.location="home.php";</script>';
}
?>