<?php
include '../layout/header.php';
include '../layout/sidebar_admin.php';
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
            <h1>Data Pesanan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Data Pesanan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        
        <div class="col-lg-12">
        <div class="card">
    <?php
        include '../connection.php';
        $query = "SELECT * FROM users INNER JOIN orders ON users.user_id = orders.user_id INNER JOIN tour_packages ON orders.package_id = tour_packages.package_id";
        $result = mysqli_query($koneksi, $query);
    ?>
    <div class="card-header">
        <h5 class="card-title">Daftar Pesanan Anda</h5>
    </div>
    <div class="card-body">
    <?php 
        if(isset($_GET['info'])){
            if($_GET['info'] == "verifikasi"){ ?>
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-check"></i> Sukses</h5>
                    Verifikasi berhasil
                </div>
            <?php }else if($_GET['info'] == "tolak"){ ?>
                <div class="alert alert-warning alert-dismissible">
                    <h5><i class="icon fas fa-edit"></i> Sukses</h5>
                    Data berhasil ditolak
                </div>
            <?php } } ?>
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pemesan</th>
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
                        <td><?php echo $row['nama_lengkap']; ?></td>
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
                                    echo 'Menunggu Verifikasi';
                                    break;
                                case 'Rejected':
                                    echo 'Ditolak';
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                        <?php if ($row['status'] === 'Unverified') { ?>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-bukti<?php echo $row['order_id']; ?>">
                                <i class="fas fa-edit"></i> Lihat Bukti 
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
    <div class="modal fade" id="modal-bukti<?php echo $row['order_id']; ?>" tabindex="-1" aria-labelledby="modalBuktiLabel<?php echo $row['order_id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBuktiLabel<?php echo $row['order_id']; ?>">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    // Check if proof_of_payment is not empty
                    if (!empty($row['proof_of_payment'])) {
                        // Display the uploaded proof of payment
                        echo '<img src="../assets1/upload/' . $row['proof_of_payment'] . '" class="img-fluid" alt="Bukti Pembayaran">';
                    } else {
                        // Display a message if no proof of payment is uploaded
                        echo '<p>Tidak ada bukti pembayaran yang diupload.</p>';
                    }
                    ?>
                </div>
                <div class="modal-footer">
                <?php if ($row['status'] === 'Unverified') { ?>
                    <a href="verifikasi_pesanan.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-success">
                        <i class="fas fa-check"></i> Verifikasi
                    </a>
                    <a href="tolak_pesanan.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-danger">
                        <i class="fas fa-check"></i> Tolak
                    </a>
                <?php } ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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