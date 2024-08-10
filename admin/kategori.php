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
      <h1>Kategori Wisata</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Kategori Wisata</li>
        </ol>
      </nav>
    </div>
    <div class="content">
    <div class="container">
    <div class="row">
        
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kategori Wisata</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                Tambah Data
            </button>
        </div>
        
        <div class="card-body">
          <?php 
          if(isset($_GET['info'])){
            if($_GET['info'] == "hapus"){ ?>
              <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-trash"></i> Sukses</h5>
                Data berhasil di hapus
              </div>
            <?php } else if($_GET['info'] == "simpan"){ ?>
              <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Sukses</h5>
                Data berhasil di simpan
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
                  <th>Nama Kategori</th>
                  <th>Jumlah Destinasi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $no = 1;
              include "../connection.php";
              $categories = mysqli_query($koneksi, "
                    SELECT c.category_id, c.category, COUNT(tp.package_id) AS jumlah_destinasi 
                    FROM categories c
                    LEFT JOIN tour_packages tp ON c.category_id = tp.category_id
                    GROUP BY c.category_id, c.category
                ");
                while($d_categories = mysqli_fetch_array($categories)) {
                    ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?=$d_categories['category']?></td>
                    <td><?=$d_categories['jumlah_destinasi']?></td>
                    <td>
                      <button type="submit" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-ubah<?php echo $d_categories['category_id']; ?>">
                        <i class="fas fa-edit"></i> Edit
                      </button>
                      <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-hapus<?php echo $d_categories['category_id']; ?>">
                        <i class="fas fa-trash"></i> Hapus
                      </button>
                    </td>
                  </tr>
                  <div class="modal fade" id="modal-hapus<?php echo $d_categories['category_id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hapus Data Kategori</h4>
                        </div>
                        <form>
                          <div class="modal-body">
                            <p>Apakah Anda Yakin Akan Menghapus Data <b><?=$d_categories['category']?></b>!!!</p>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            <a href="hapus_kategori.php?category_id=<?php echo $d_categories['category_id']; ?>" class="btn btn-danger">Hapus</a>
                          </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>

                  <div class="modal fade" id="modal-ubah<?php echo $d_categories['category_id']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Data Kategori</h4>
                          </button>
                        </div>
                        <form method="post" action="update_kategori.php" enctype="multipart/form-data">
                          <div class="modal-body">
                            <div class="form-group">
                              <label>Nama Paket</label>
                              <input type="text" name="category_id" value="<?php echo $d_categories['category_id']; ?>" hidden>
                              <input type="text" class="form-control" value="<?php echo $d_categories['category']; ?>" name="category">
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                <?php 
              } ?>
              </tbody>
            </table>
            
        <script>
        $(document).ready( function () {
          $('#myTable').DataTable();
          } );
          </script>                              
            <div class="modal fade" id="modal-tambah">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Paket</h4>
                    </button>
                  </div>
                  <form method="post" action="simpan_kategori.php" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" name="category">
                      </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                  </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          </div>
        </div>
</div>

</div>
</main>

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