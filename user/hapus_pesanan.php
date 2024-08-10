<?php 
// koneksi database
include '../connection.php';

// Menangkap data yang dikirim dari form
$id_order = $_POST['order_id'];

// Cek apakah order_id diisi
if (empty($id_order)) {
    echo "<script>alert('ID pesanan tidak ditemukan.');window.location='pesanan.php';</script>";
    exit();
}

// Update status pesanan menjadi 'cancelled'
$query = "UPDATE orders SET status = 'Cancelled' WHERE order_id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_order);

if ($stmt->execute()) {
    // Redirect kembali dengan pesan sukses
    header("Location: pesanan.php?info=hapus");
} else {
    // Tampilkan pesan error jika query gagal
    echo "<script>alert('Terjadi kesalahan: " . $stmt->error . "');window.location='pesanan.php';</script>";
}

$stmt->close();
?>
