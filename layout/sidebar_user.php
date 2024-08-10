<?php
// Check if a session is already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $user_id = $_SESSION['user_id'];
}

if ($_SESSION['status'] == "") {
    header("location:../index.php?info=login");
    exit();
}
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-heading">Menu</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="profil.php">
      <i class="bi bi-person"></i>
      <span>Profile</span>
    </a>
  </li><!-- End Profile Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="penawaran.php">
      <i class="bi bi-question-circle"></i>
      <span>Paket Wisata</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pesanan.php">
      <i class="bi bi-question-circle"></i>
      <span>Pesanan Saya</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-toggle="modal" data-bs-target="#logout">
    <i class="bi-box-arrow-right"></i>
      <span>Logout</span>
    </a>
  </li>

</ul>

</aside><!-- End Sidebar-->
<div class="modal fade" id="logout" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda Yakin Ingin Mengakhiri Sesi Ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->