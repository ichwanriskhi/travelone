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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
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
            <h1>Pesanan Saya</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Pesanan Saya</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        
        <div class="col-lg-12">
        <div class="card">
    <?php
        include '../connection.php';
        $email = $_SESSION['email'];
        $user_id_query = "SELECT user_id FROM users WHERE email = '$email' LIMIT 1";
        $user_id_result = mysqli_query($koneksi, $user_id_query);
        $user = mysqli_fetch_assoc($user_id_result);
        $user_id = $user['user_id'];
        $query = "SELECT * FROM orders INNER JOIN tour_packages ON orders.package_id = tour_packages.package_id WHERE orders.user_id = '$user_id'";
        $result = mysqli_query($koneksi, $query);
    ?>
    <div class="card-header">
        <h5 class="card-title">Daftar Pesanan Anda</h5>
    </div>
    <div class="card-body">
    <?php 
        if(isset($_GET['info'])){
            if($_GET['info'] == "hapus"){ ?>
                <div class="alert alert-warning alert-dismissible">
                    <h5><i class="icon fas fa-check"></i> Sukses</h5>
                    Pesanan dibatalkan
                </div>
            <?php }else if($_GET['info'] == "update"){ ?>
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-edit"></i> Sukses</h5>
                    Data berhasil di update
                </div>
            <?php } } ?>
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Paket</th>
                    <th>Harga Paket</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Jumlah Orang</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $orderData = [];
                while ($row = mysqli_fetch_array($result)) {
                    $orderData[] = $row; // Store row data for later use in modals
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['package']; ?></td>
                        <td>Rp. <?= number_format($row['price']); ?></td>
                        <td><?php echo $row['booking_date']; ?></td>
                        <td><?php echo $row['num_people']; ?></td>
                        <td>Rp. <?= number_format($row['total_price']); ?></td>
                        <td>
                        <?php
                            // Display status based on the value in the database
                            switch ($row['status']) {
                                case 'Confirmed':
                                    echo 'Pesanan Dikonfirmasi';
                                    break;
                                case 'Pending':
                                    echo 'Belum Dibayar';
                                    break;
                                case 'Cancelled':
                                    echo 'Pesanan Dibatalkan';
                                    break;
                                case 'Unverified':
                                    echo 'Menunggu Konfirmasi';
                                    break;
                                case 'Rejected':
                                    echo 'Ditolak';
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                        <?php if ($row['status'] === 'Pending') { ?>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-ubah<?php echo $row['order_id']; ?>">
                            <i class="fas fa-edit"></i> Edit 
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-hapus<?php echo $row['order_id']; ?>">
                            <i class="fas fa-trash"></i> Batal
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-bayar<?php echo $row['order_id']; ?>">
                            <i class="fas fa-money-bill"></i> Bayar
                        </button>
                        <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>
    </div>
</div>

<?php
foreach ($orderData as $row) {
?>
    <!-- Modal Ubah -->
    <div class="modal fade" id="modal-ubah<?php echo $row['order_id']; ?>" tabindex="-1" aria-labelledby="modalUbahLabel<?php echo $row['order_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahLabel<?php echo $row['order_id']; ?>">Ubah Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="update_pesanan.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                        <div class="mb-3">
                                <label for="booking_date">Tanggal Pemesanan</label>
                                <input type="date" class="form-control" id="booking_date<?php echo $row['order_id']; ?>" name="booking_date" value="<?php echo $row['booking_date']; ?>" required>
                            </div>
                        <div class="mb-3">
                            <label for="num_people<?php echo $row['order_id']; ?>" class="form-label">Jumlah Orang</label>
                            <input type="number" class="form-control" id="num_people<?php echo $row['order_id']; ?>" name="num_people" value="<?php echo $row['num_people']; ?>" required>
                        </div>
                        <!-- Additional form fields for other order details can be added here -->
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modal-hapus<?php echo $row['order_id']; ?>" tabindex="-1" aria-labelledby="modalHapusLabel<?php echo $row['order_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel<?php echo $row['order_id']; ?>">Batalkan Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                    <form action="hapus_pesanan.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Bayar -->
    <div class="modal fade" id="modal-bayar<?php echo $row['order_id']; ?>" tabindex="-1" aria-labelledby="modalBayarLabel<?php echo $row['order_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBayarLabel<?php echo $row['order_id']; ?>">Bayar Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Silakan transfer pembayaran sebesar Rp. <?= number_format($row['total_price']); ?> ke rekening berikut:</p>
                    <p><strong>Bank ABC</strong><br>Nomor Rekening: 1234567890<br>Atas Nama: PT. Travel</p>
                    <p>Atau scan QRIS berikut:</p>
                    <img src="../assets1/img/qris.jpg" alt="QRIS" class="img-fluid mb-3">
                    <form action="bukti_bayar.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                        <div class="mb-3">
                            <label for="proof_of_payment<?php echo $row['order_id']; ?>" class="form-label">Upload Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="proof_of_payment<?php echo $row['order_id']; ?>" name="proof_of_payment" required>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

            </div>
        </div>
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
