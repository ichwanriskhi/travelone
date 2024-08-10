<?php 
// koneksi database
include '../connection.php';

// menangkap data yang di kirim dari form
$package_name = $_POST['package'];
$gambar = $_FILES['picture']['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];

// Check if any of the required fields are empty
if (empty($package_name) || empty($price) || empty($description)) {
    // Redirect back to the form with an error message
    echo "<script>alert('Semua data harus diisi');window.location='paket.php';</script>";
    exit();
}

// Check if there's an image to upload
if ($gambar != "") {
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg'); // Allowed image file extensions
    $x = explode('.', $gambar); // Split the filename into name and extension
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['picture']['tmp_name'];   
    $angka_acak = rand(1, 999);
    $nama_gambar_baru = $angka_acak . '-' . $gambar; // Combine random number with the original file name
    
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if (move_uploaded_file($file_tmp, '../assets1/upload/' . $nama_gambar_baru)) {
            // Prepare and execute the SQL statement with the new image
            $stmt = $koneksi->prepare("INSERT INTO tour_packages (package, picture, price, description, category_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisi", $package_name, $nama_gambar_baru, $price, $description, $category_id);
            
            if ($stmt->execute()) {
                header("Location: paket.php?info=simpan");
            } else {
                die("Query gagal dijalankan: " . $stmt->errno . " - " . $stmt->error);
            }
            
            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengupload gambar.');window.location='barang.php';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi gambar yang boleh hanya jpg, jpeg, atau png.');window.location='barang.php';</script>";
    }
} else {
    // Prepare and execute the SQL statement without the image
    $stmt = $koneksi->prepare("INSERT INTO tour_packages (package, price, description, category_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $package_name, $price, $description, $category_id);
    
    if ($stmt->execute()) {
        header("Location: paket.php?info=simpan");
    } else {
        die("Query gagal dijalankan: " . $stmt->errno . " - " . $stmt->error);
    }
    
    $stmt->close();
}
?>
