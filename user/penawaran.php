
<?php

include '../layout/header.php';
include '../layout/sidebar_user.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TravelOne</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets1/img/favicon.png" rel="icon">
  <link href="../assets1/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets1/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets1/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets1/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets1/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets1/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets1/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets1/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets1/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Paket Wisata</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Paket Wisata</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <!-- Card with titles, buttons, and links -->
    <div class="row">
    <?php 
        if(isset($_GET['info'])){
            if($_GET['info'] == "rendah"){ ?>
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-x"></i> Maaf</h5>
                    Data berhasil di hapus
                </div>
            <?php } else if($_GET['info'] == "simpan"){ ?>
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-check"></i> Sukses</h5>
                    Pesanan berhasil di pesan
                </div>
            <?php }else if($_GET['info'] == "update"){ ?>
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-edit"></i> Sukses</h5>
                    Data berhasil di update
                </div>
            <?php } } ?>
    <form action="" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cari destinasi wisata yang anda inginkan ..." name="search">
            <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="bi bi-search"> Cari</i></button>
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="kategori">Kategori</label>
            <select class="form-select" id="kategori" name="kategori">
                <option value="">Semua Kategori</option>
                <?php
                $tb_kategori = mysqli_query($koneksi, "SELECT * FROM categories");
                while($d_tb_kategori = mysqli_fetch_array($tb_kategori)){ ?>
                    <option value="<?=$d_tb_kategori['category_id']?>"><?=$d_tb_kategori['category']?></option>
                <?php } ?>
            </select>
            <button class="btn btn-outline-secondary" type="submit">Sortir</button>
        </div>
    </form>
    <?php
    $no = 1;
    include "../connection.php";

    // Proses pencarian dan sortir
    $search = '';
    $kategori = '';
    $query = "SELECT * FROM tour_packages 
              INNER JOIN categories ON tour_packages.category_id=categories.category_id";
    if(isset($_GET['search'])) {
        $search = mysqli_real_escape_string($koneksi, $_GET['search']);
        $query .= " WHERE tour_packages.package LIKE '%$search%'";
    }
    if(isset($_GET['kategori']) && !empty($_GET['kategori'])) {
        $kategori = mysqli_real_escape_string($koneksi, $_GET['kategori']);
        $query .= " AND categories.category_id = $kategori";
    }
    $tb_lelang = mysqli_query($koneksi, $query);

    while($d_tb_lelang = mysqli_fetch_array($tb_lelang)){ ?>
        <div class="col-lg-3">
            <div class="card">
                <img src="../assets1/upload/<?php echo $d_tb_lelang['picture']; ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=$d_tb_lelang['package']?></h5>
                    <h6 class="card-subtitle mb-2"><b>Kategori</b> <a class="float-right"><?=$d_tb_lelang['category']?></a></h6>
                    <h6 class="card-subtitle mb-2"><b>Harga</b> <a class="float-right"><br>Rp. <?= number_format($d_tb_lelang['price'])?></a></h6>
                    <h6 class="card-text"><b>Deskripsi Paket</b> <a class="float-right"><br><?=$d_tb_lelang['description']?></a></h6>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-book<?php echo $d_tb_lelang['package_id'];?>">Pesan Paket</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-book<?php echo $d_tb_lelang['package_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pesan Paket Wisata</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php
                    include '../connection.php';
                    $email = $_SESSION['email'];
                    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
                    $result = mysqli_query($koneksi, $query);
                    while($user = mysqli_fetch_array($result)) {
                        ?>
                    <form method="post" action="simpan_pesanan.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id'];}?>">
                                <input type="hidden" name="package_id" value="<?php echo $d_tb_lelang['package_id'];?>">
                                <label for="package_name">Nama Paket</label>
                                <input type="text" class="form-control" value="<?=$d_tb_lelang['package']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="text" class="form-control" value="Rp. <?= number_format($d_tb_lelang['price'])?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="booking_date">Tanggal Pemesanan</label>
                                <input type="date" class="form-control" name="booking_date" required>
                            </div>
                            <div class="form-group">
                                <label for="num_people">Jumlah Orang</label>
                                <input type="number" class="form-control" name="num_people" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    <!-- End Card with titles, buttons, and links -->
</main><!-- End #main -->
<?php
include '../layout/footer.php';
?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets1/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets1/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets1/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets1/vendor/echarts/echarts.min.js"></script>
  <script src="../assets1/vendor/quill/quill.min.js"></script>
  <script src="../assets1/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets1/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets1/vendor/php-email-form/validate.js"></script>
  
  <script src="../assets1/js/show.js"></script>
  <script src="../assets1/js/nik.js"></script>
  <script src="../assets1/js/pass2.js"></script>
  <script src="../assets1/js/telp.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets1/js/main.js"></script>

</body>

</html>
