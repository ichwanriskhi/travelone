<?php
// koneksi database
include '../connection.php';

// menangkap data yang di kirim dari URL
$order_id = $_GET['order_id'];

// cek apakah order_id ada
if (!empty($order_id)) {
    // mempersiapkan query untuk update status
    $query = "UPDATE orders SET status = 'Rejected' WHERE order_id = ?";
    
    // mempersiapkan statement
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $order_id);

    // menjalankan query
    if ($stmt->execute()) {
        // mengalihkan halaman dengan pesan sukses
        header("Location: pesanan.php?info=tolak");
    } else {
        // menampilkan pesan error jika query gagal
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    // menutup statement
    $stmt->close();
} else {
    // menampilkan pesan error jika order_id tidak ditemukan
    echo "<script>alert('ID pesanan tidak ditemukan.');window.location='pesanan.php';</script>";
}

// menutup koneksi database
$koneksi->close();
?>
