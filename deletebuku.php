<?php
include('connect.php');
if(isset($_GET['id_buku'])){
	$id_buku = $_GET['id_buku'];
	$cek = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku='$id_buku'") or die(mysqli_error($conn));
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($conn, "DELETE FROM buku WHERE id_buku='$id_buku'") or die(mysqli_error($conn));
		if($del){
			echo '<script>alert("Berhasil menghapus data."); document.location="buku.php";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data."); document.location="buku.php";</script>';
		}
	}else{
		echo '<script>alert("id_buku tidak ditemukan di database."); document.location="buku.php";</script>';
	}
}else{
	echo '<script>alert("id_buku tidak ditemukan di database."); document.location="buku.php";</script>';
}
?>