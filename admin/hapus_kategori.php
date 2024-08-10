<?php 
// koneksi database
include '../connection.php';

// menangkap data id yang di kirim dari url
$category_id = $_GET['category_id'];


// menghapus data dari database
mysqli_query($koneksi,"delete from categories where category_id='$category_id'");

// mengalihkan halaman kembali ke kategori.php
header("location:kategori.php?info=hapus");

?>