<?php 
// koneksi database
include '../connection.php';
session_start();

// Mengecek apakah user telah masuk dan file telah diupload
if (isset($_SESSION['email']) && isset($_FILES['profile_picture'])) {
    $email = $_SESSION['email'];
    $profile_picture = $_FILES['profile_picture']['name'];

    // Mengecek apakah ada gambar untuk diupload
    if ($profile_picture != "") {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg'); // Ekstensi file yang diperbolehkan
        $x = explode('.', $profile_picture); 
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['profile_picture']['tmp_name'];   
        $angka_acak = rand(1, 999);
        $nama_gambar_baru = $angka_acak . '-' . $profile_picture; // Mengkombinasikan angka acak dengan file asli

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if (move_uploaded_file($file_tmp, '../assets1/upload/' . $nama_gambar_baru)) {
                // Menyiapkan dan mengeksekusi statement SQL dengan gambar baru
                $stmt = $koneksi->prepare("UPDATE users SET profile_picture = ? WHERE email = ?");
                $stmt->bind_param("ss", $nama_gambar_baru, $email);
                
                if ($stmt->execute()) {
                    header("Location: profil.php?info=update");
                } else {
                    die("Query gagal dijalankan: " . $stmt->errno . " - " . $stmt->error);
                }
                
                $stmt->close();
            } else {
                echo "<script>alert('Gagal mengupload gambar.');window.location='profil.php';</script>";
            }
        } else {
            echo "<script>alert('Ekstensi gambar yang boleh hanya jpg, jpeg, atau png.');window.location='profil.php';</script>";
        }
    } else {
        echo "<script>alert('Harap pilih gambar untuk diupload.');window.location='profil.php';</script>";
    }
} else {
    echo "<script>alert('Terjadi kesalahan. Harap coba lagi.');window.location='profil.php';</script>";
}
?>
