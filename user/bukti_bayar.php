<?php
// Include koneksi ke database
include '../connection.php';

// Tangkap data dari form
$order_id = $_POST['order_id'];
$proof_of_payment = $_FILES['proof_of_payment']['name'];

// Cek apakah data pada form lengkap
if (empty($order_id) || empty($proof_of_payment)) {
    echo "<script>alert('Semua data harus diisi');window.location='pesanan.php';</script>";
    exit();
}

// Cek apakah ada file yang diupload
if ($proof_of_payment != "") {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'pdf'); // Jenis file yang diizinkan
    $x = explode('.', $proof_of_payment); //Memisahkan nama file menjadi nama dan ekstensinya
    $extension = strtolower(end($x));
    $file_tmp = $_FILES['proof_of_payment']['tmp_name'];
    $random_number = rand(1, 999);
    $new_file_name = $random_number . '-' . $proof_of_payment; // Mengkombinasi angka acak dengan nama asli file

    if (in_array($extension, $allowed_extensions) === true) {
        $upload_path = '../assets1/upload/' . $new_file_name;
        if (move_uploaded_file($file_tmp, $upload_path)) {
            // Mengupdate status dan menyimpan path file ke database
            $stmt = $koneksi->prepare("UPDATE orders SET proof_of_payment = ?, status = 'Unverified' WHERE order_id = ?");
            $stmt->bind_param("si", $new_file_name, $order_id);

            if ($stmt->execute()) {
                header("Location: pesanan.php?info=bayar_sukses");
                exit();
            } else {
                die("Query gagal dijalankan: " . $stmt->errno . " - " . $stmt->error);
            }

            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengupload file.');window.location='pesanan.php';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi file yang boleh hanya jpg, jpeg, png, atau pdf.');window.location='pesanan.php';</script>";
    }
} else {
    echo "<script>alert('Tidak ada file yang diupload.');window.location='pesanan.php';</script>";
}
?>
