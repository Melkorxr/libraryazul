<?php
include('connect.php');
if(isset($_GET['no_pinjam'])){
	$no_pinjam = $_GET['no_pinjam'];
	$cek = mysqli_query($conn, "SELECT * FROM pinjam WHERE no_pinjam='$no_pinjam'") or die(mysqli_error($conn));
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($conn, "DELETE FROM pinjam WHERE no_pinjam='$no_pinjam'") or die(mysqli_error($coneksi));
		if($del){
			echo '<script>alert("Berhasil menghapus data."); document.location="pinjam.php";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data."); document.location="pinjam.php";</script>';
		}
	}else{
		echo '<script>alert("no_pinjam tidak ditemukan di database."); document.location="pinjam.php";</script>';
	}
}else{
	echo '<script>alert("no_pinjam tidak ditemukan di database."); document.location="pinjam.php";</script>';
}
?>