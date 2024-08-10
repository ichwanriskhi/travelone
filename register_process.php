<?php
// koneksi database
include 'connection.php';

// menangkap data yang dikirim dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

// query untuk memeriksa apakah email sudah terdaftar
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");

// memeriksa jumlah baris hasil query
$count = mysqli_num_rows($query);

// jika email sudah terdaftar, tampilkan pesan kesalahan
if ($count > 0) {
  echo "<script>
          alert('Email sudah terdaftar. Silahkan gunakan email lain.');
          window.location='register.php';
        </script>";
} else {
  // cek konfirmasi password
  if ($password === $password_confirm) {
    // cek panjang password
    $password_length = strlen($password);
    if ($password_length >= 8 && $password_length <= 15) {
      mysqli_query($koneksi, "INSERT INTO users (nama_lengkap, email, password) VALUES ('$nama', '$email', '$password')");
      header("location:register.php?info=daftar");
    } else {
      echo "<script>
              alert('Password Tidak Boleh Kurang Dari 8 Karakter.');
              window.location='register.php';
            </script>";
    }
  } else {
    echo "<script>
            alert('Password dan konfirmasi password tidak sesuai.');
            window.location='register.php';
          </script>";
  }
}
?>
