<?php
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include 'connection.php';

// menangkap data yang dikirim dari form
$email = $_POST['email'];
$password = $_POST['password'];

// Menggunakan prepared statements untuk mencegah SQL injection
$query = $koneksi->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Memverifikasi password 
    if ($password === $user['password']) {
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user_id['user_id']; 
        $_SESSION['status'] = "login";

        // Mengaeahkan berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else if ($user['role'] === 'user') {
            header("Location: user/index.php");
        }
    } else {
        header("Location: login.php?info=gagal");
    }
} else {
    header("Location: login.php?info=gagal");
}
?>
