<?php 
// koneksi database
include '../connection.php';

// menangkap data yang dikirim dari form
$package_id = $_POST['package_id']; // ID paket yang ingin diupdate
$package_name = $_POST['package'];
$gambar = $_FILES['picture']['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];

// Check if any of the required fields are empty
if (empty($package_name) || empty($price) || empty($description) || empty($category_id) || empty($package_id)) {
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
            $stmt = $koneksi->prepare("UPDATE tour_packages SET package = ?, picture = ?, price = ?, description = ?, category_id = ? WHERE package_id = ?");
            $stmt->bind_param("ssisii", $package_name, $nama_gambar_baru, $price, $description, $category_id, $package_id);
            
            if ($stmt->execute()) {
                header("Location: paket.php?info=update");
            } else {
                die("Query gagal dijalankan: " . $stmt->errno . " - " . $stmt->error);
            }
            
            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengupload gambar.');window.location='paket.php';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi gambar yang boleh hanya jpg, jpeg, atau png.');window.location='paket.php';</script>";
    }
} else {
    // Update the record without changing the image
    $stmt = $koneksi->prepare("UPDATE tour_packages SET package = ?, price = ?, description = ?, category_id = ? WHERE package_id = ?");
    $stmt->bind_param("sisii", $package_name, $price, $description, $category_id, $package_id);
    
    if ($stmt->execute()) {
        header("Location: paket.php?info=update");
    } else {
        die("Query gagal dijalankan: " . $stmt->errno . " - " . $stmt->error);
    }
    
    $stmt->close();
}
?>
