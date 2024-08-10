<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$nama = $_POST['nama_lengkap'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$telephone = $_POST['telephone'];

$query = "UPDATE users SET nama_lengkap = '$nama', email='$email', password='$password', gender = '$gender', telephone = '$telephone'";
if (!empty($password)) {
    $query .= ", password = '$password'";
}
$query .= " WHERE email = '$email'";

mysqli_query($koneksi, $query);

header('Location: profil.php?info=update');
exit;
?>
