<?php 
// koneksi database
include '../connection.php';

// menangkap data id yang di kirim dari url
$id_package = $_GET['package_id'];

// menghapus data dari database
mysqli_query($koneksi, "DELETE FROM tour_packages WHERE package_id = '$id_package'");

// mengalihkan halaman kembali ke paket.php
header("Location: paket.php?info=hapus");
?>
