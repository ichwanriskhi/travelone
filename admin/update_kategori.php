<?php
// include koneksi ke database
include '../connection.php';

// mengambil data dari form
$category = $_POST['category'];

$category_id = $_POST['category_id'];

// insert data ke database
$query = "UPDATE categories SET category='$category' WHERE category_id='$category_id'";
$result = mysqli_query($koneksi, $query);

// cek apakah proses insert berhasil
if ($result) {
  // redirect ke halaman kategori dengan pesan sukses
  header('location:kategori.php?info=update');
} else {
  // redirect ke halaman kategori dengan pesan error
  header('location:kategori.php?info=gagal');
}
?>
