<?php

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

$nama_pengguna = $_SESSION['nama'];
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown no-arrow">
            <a class="nav-link">
                <span class="mr-1 d-none d-lg-inline text-gray-600 ">ADMIN PME
                </span> 
            </a>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="mr-3 d-none d-lg-inline text-gray-600 ">
            <?php echo $nama_pengguna; ?>
        </span>
        <img class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="Profile Picture">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="ubah_password.php"><i class="bi bi-key"></i> Ubah Password</a>
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="user.php"><i class="bi bi-person"></i> User</a>
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php"><i class="bi bi-power"></i> Logout</a>
    </div>
</li>

    </ul>
</nav>
<!-- End of Topbar -->
