


<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider"/>

    <!-- Heading -->
    <div class="sidebar-heading">
        Website
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="../user/halaman_user.php">
            <i class="bi bi-globe"></i>
            <span>Lihat Website</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider"/>

    <!-- Heading -->
    <div class="sidebar-heading">
        Peminjaman
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="landing_page.php">
            <i class="bi bi-list"></i>
            <span>Daftar</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="barang.php">
            <i class="bi bi-box"></i>
            <span>Barang</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Perbaikan
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="permintaan_perbaikan.php">
            <i class="bi bi-bell"></i>
            <span>Daftar Permintaan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="proses_perbaikan.php">
            <i class="bi bi-circle"></i>
            <span>Proses perbaikan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="riwayat.php">
            <i class="bi bi-book"></i>
            <span>Riwayat</span>
        </a>
    </li>
  

    <hr class="sidebar-divider d-none d-md-block"/>
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle">
        </button>
    </div>

</ul>


<!-- End of Sidebar -->
<script>
    // Mendapatkan URL halaman saat ini
    var currentLocation = window.location.href;
    // Mendapatkan semua elemen navigasi
    var navItems = document.querySelectorAll('.nav-item');
    // Loop melalui setiap elemen navigasi
    navItems.forEach(function(navItem) {
        // Mendapatkan URL dari setiap tautan dalam elemen navigasi
        var link = navItem.querySelector('.nav-link');
        var linkHref = link.getAttribute('href');
        // Memeriksa apakah URL halaman saat ini cocok dengan URL tautan
        if (currentLocation.includes(linkHref)) {
            // Menandai elemen navigasi sebagai aktif
            navItem.classList.add('active');
        }
    });
</script>
