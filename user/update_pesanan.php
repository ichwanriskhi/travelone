<?php
// Include koneksi ke database
include '../connection.php';

// Cek apakah metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $order_id = $_POST['order_id'];
    $booking_date = $_POST['booking_date'];
    $num_people = $_POST['num_people'];

    // Cek apakah semua data diisi atau tidak
    if (empty($order_id) || empty($booking_date) || empty($num_people)) {
        // Redirect ke halaman sebelumnya dengan pesan error
        header('Location: pesanan.php?info=error');
        exit();
    }

    // Ambil package_id dari order_id
    $query_package = "SELECT package_id FROM orders WHERE order_id = '$order_id'";
    $result_package = mysqli_query($koneksi, $query_package);

    // Cek apakah query berhasil dan package_id ditemukan
    if ($result_package && mysqli_num_rows($result_package) > 0) {
        $row_package = mysqli_fetch_assoc($result_package);
        $package_id = $row_package['package_id'];

        // Ambil harga paket dari database
        $query_price = "SELECT price FROM tour_packages WHERE package_id = '$package_id'";
        $result_price = mysqli_query($koneksi, $query_price);

        // Cek apakah query berhasil dan harga ditemukan
        if ($result_price && mysqli_num_rows($result_price) > 0) {
            $row_price = mysqli_fetch_assoc($result_price);
            $price = $row_price['price'];

            // Hitung total_price
            $total_price = $price * $num_people;

            // Update data di database
            $query_order = "UPDATE orders 
                            SET booking_date = '$booking_date', num_people = '$num_people', total_price = '$total_price' 
                            WHERE order_id = '$order_id'";
            $result_order = mysqli_query($koneksi, $query_order);

            // Cek apakah proses update berhasil
            if ($result_order) {
                // Redirect ke halaman sebelumnya dengan pesan sukses
                header('Location: pesanan.php?info=update');
            } else {
                // Redirect ke halaman sebelumnya dengan pesan error
                header('Location: pesanan.php?info=gagal');
            }
        } else {
            // Redirect ke halaman sebelumnya dengan pesan error
            echo "<script>alert('Harga paket tidak ditemukan.');window.location='pesanan.php';</script>";
        }
    } else {
        // Redirect ke halaman sebelumnya dengan pesan error
        echo "<script>alert('Paket tidak ditemukan.');window.location='pesanan.php';</script>";
    }
} else {
    // Redirect ke halaman sebelumnya dengan pesan error
    echo "<script>alert('Metode request tidak valid.');window.location='pesanan.php';</script>";
}

?>
