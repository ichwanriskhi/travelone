<?php
session_start();

// mengecek apakah user sudah login atau belum
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// menghubungkan php dengan koneksi database
include '../connection.php';

// mengambil data user berdasarkan email
$email = $_SESSION['email'];

// Menggunakan prepared statements untuk mencegah SQL injection
$query = $koneksi->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User tidak ditemukan.");
}

$nama_kolom = "nama_lengkap";
?>

<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">TravelOne</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="container d-flex align-items-center justify-content-end">
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed">
                    <span><?php echo htmlspecialchars($user[$nama_kolom]); ?></span>
                </a>
            </li><!-- End Dashboard Nav -->
        </ul>
    </div>
</header><!-- End Header -->
