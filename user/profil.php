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
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
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
          Penawaran berhasil di simpan
        </div>
        <?php }else if($_GET['info'] == "update"){ ?>
          <div class="alert alert-success alert-dismissible">
            <h5><i class="icon fas fa-edit"></i> Sukses</h5>
            Data berhasil di update
          </div>
          <?php } } ?>
          
          <?php
          include '../connection.php';
          $email = $_SESSION['email'];
          $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
          $result = mysqli_query($koneksi, $query);
          while($user = mysqli_fetch_array($result)) {
            ?>
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Profil Anda</h5>
                <?php
                  $showWarning = empty($user['nama_lengkap']) || empty($user['email']) || empty($user['password']) || empty($user['gender']) || empty($user['telephone']);
                  if ($showWarning) {
                    echo '<p id="profile-warning" style="color: red;">Lengkapi Profil Anda!!</p>';
                  }
                ?>
                <div class="text-center mb-4">
                  <div class="profile-pic">
                    <img src="../assets1/upload/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="rounded-circle img-thumbnail">
                    <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#modal-edit-picture">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                  </div>
                </div>
                <!-- Custom Styled Validation with Tooltips -->
                <form class="row g-3 needs-validation" method="post" action="update_profil.php" novalidate>
                  <div class="col-md-4 position-relative">
                    <label for="validationTooltip01" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="validationTooltip01" value="<?php echo $user['nama_lengkap']; ?>" required>
                  </div>
                  <div class="col-md-4 position-relative">
                    <label for="validationTooltip01" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="validationTooltip01" value="<?php echo $user['email']; ?>" required>
                  </div>
                  <div class="col-md-4 position-relative">
                    <label for="Password" class="form-label">Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control form-control-password" name="password" id="Password" value="<?php echo $user['password']; ?>" required>
                      <button class="btn btn-outline-secondary" type="button" onclick="showPassword()">Show</button>
                    </div>
                  </div>
                  <div class="col-md-6 position-relative">
                    <label for="validationTooltip04" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" name="gender" id="validationTooltip04" required>
                      <option selected disabled value="">Pilih...</option>
                      <option value="pria"<?php echo (isset($user['gender']) && $user['gender'] == 'pria') ? ' selected' : ''; ?>>Pria</option>
                      <option value="wanita"<?php echo (isset($user['gender']) && $user['gender'] == 'wanita') ? ' selected' : ''; ?>>Wanita</option>
                    </select>
                    <div class="invalid-tooltip">
                      Pilih salah satu
                    </div>
                  </div>
                  <div class="col-md-6 position-relative">
                    <label for="validationTooltip05" class="form-label">Telepon</label>
                    <input type="number" class="form-control" name="telephone" id="yourPhone" value="<?php echo $user['telephone']; ?>" required>
                    <div class="invalid-tooltip">
                      Nomor Telepon tidak valid
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                  </div>
                </form><!-- End Custom Styled Validation with Tooltips -->

              </div>
            </div>

            <!-- Modal for Editing Profile Picture -->
            <div class="modal fade" id="modal-edit-picture" tabindex="-1" aria-labelledby="modalEditPictureLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPictureLabel">Edit Gambar Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="post" action="update_profile_picture.php" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="profile_picture" class="form-label">Pilih Gambar</label>
                        <input type="file" class="form-control" name="profile_picture" id="profile_picture" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          <?php } ?>
</main><!-- End #main -->

<style>
.profile-pic {
  position: relative;
  display: inline-block;
}

.profile-pic img {
  width: 150px;
  height: 150px;
  object-fit: cover;
}

.edit-icon {
  position: absolute;
  bottom: 0;
  right: 0;
  background: white;
  border-radius: 50%;
  padding: 5px;
  cursor: pointer;
}
</style>


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