<?php
// Include koneksi ke database
include '../connection.php';


// Mengambil data dari form
$user_id = $_POST['user_id'];
$package_id = $_POST['package_id'];
$booking_date = $_POST['booking_date'];
$num_people = $_POST['num_people'];
$status = 'Pending'; // Status awal pemesanan

// Cek apakah semua data diisi atau tidak
if (empty($user_id) || empty($package_id) || empty($booking_date) || empty($num_people)) {
    // Redirect ke halaman sebelumnya dengan pesan error
    exit();
}

// Ambil harga paket dari database
$query_price = "SELECT price FROM tour_packages WHERE package_id = '$package_id'";
$result_price = mysqli_query($koneksi, $query_price);

// Cek apakah query berhasil dan harga ditemukan
if ($result_price && mysqli_num_rows($result_price) > 0) {
    $row_price = mysqli_fetch_assoc($result_price);
    $price = $row_price['price'];
    
    // Hitung total_price
    $total_price = $price * $num_people;

    // Insert data ke database
    $query_order = "INSERT INTO orders (user_id, package_id, booking_date, num_people, total_price, status) 
                    VALUES ('$user_id', '$package_id', '$booking_date', '$num_people', '$total_price', '$status')";
    $result_order = mysqli_query($koneksi, $query_order);

    // Cek apakah proses insert berhasil
    if ($result_order) {
        // Redirect ke halaman sebelumnya dengan pesan sukses
        header('location:penawaran.php?info=simpan');
    } else {
        // Redirect ke halaman sebelumnya dengan pesan error
        header('location:penawaran.php?info=gagal');
    }
} else {
    // Redirect ke halaman sebelumnya dengan pesan error
    echo "<script>alert('Harga paket tidak ditemukan.');window.location='index.php';</script>";
}
?>
