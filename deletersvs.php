<?php
include('connect.php');
if(isset($_GET['no_rsvs'])){
	$no_rsvs = $_GET['no_rsvs'];
	$cek = mysqli_query($conn, "SELECT * FROM reservasi WHERE no_rsvs='$no_rsvs'") or die(mysqli_error($conn));
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($conn, "DELETE FROM reservasi WHERE no_rsvs='$no_rsvs'") or die(mysqli_error($coneksi));
		if($del){
			echo '<script>alert("Berhasil menghapus data."); document.location="reservasi.php";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data."); document.location="reservasi.php";</script>';
		}
	}else{
		echo '<script>alert("no_rsvs tidak ditemukan di database."); document.location="reservasi.php";</script>';
	}
}else{
	echo '<script>alert("no_rsvs tidak ditemukan di database."); document.location="reservasi.php";</script>';
}
?>