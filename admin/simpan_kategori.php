<?php
// include koneksi ke database
include '../connection.php';

// mengambil data dari form
$category = $_POST['category'];

// Cek apakah nama kategori diisi atau tidak
if(empty($category)) {
  // Redirect ke halaman kategori dengan pesan error
  echo "<script>alert('Data harus diisi.');window.location='kategori.php';</script>";
  exit();
}

// insert data ke database
$query = "INSERT INTO categories (category) VALUES ('$category')";
$result = mysqli_query($koneksi, $query);

// cek apakah proses insert berhasil
if ($result) {
  // redirect ke halaman kategori dengan pesan sukses
  header('location:kategori.php?info=simpan');
} else {
  // redirect ke halaman kategori dengan pesan error
  header('location:kategori.php?info=gagal');
}
?>
