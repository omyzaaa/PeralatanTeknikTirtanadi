<!DOCTYPE html>
<?php
session_start();
include "../function/connect.php";

?>
<html lang="en">

<?php
include "mockup/head.php";
?>
<style>
    .card:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include "mockup/sidebar.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include "mockup/navbar.php";
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                  

                    <!-- Content Row -->
                    <div class="row">
                        <?php
                        $permintaan = mysqli_query($connection, "SELECT COUNT(id_permintaan) AS permintaan FROM permintaan_perbaikan");
                        while ($row = mysqli_fetch_array($permintaan)) {
                            $jumlah_permintaan = $row['permintaan'];
                        }

                        $proses = mysqli_query($connection, "SELECT COUNT(id_proses) AS proses FROM proses_perbaikan");
                        while ($row = mysqli_fetch_array($proses)) {
                            $jumlah_proses = $row['proses'];
                        }

                        $user = mysqli_query($connection, "SELECT COUNT(id_user) AS user FROM user");
                        while ($row = mysqli_fetch_array($user)){
                            $jumlah_user = $row['user'];
                        }
                        $riwayat = mysqli_query($connection, "SELECT COUNT(id_riwayat) AS riwayat FROM riwayat_perbaikan");
                        while ($row = mysqli_fetch_array($riwayat)){
                            $jumlah_riwayat = $row['riwayat'];
                        }
                        ?>
                        


                        <!-- Jumlah -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="permintaan_perbaikan.php" style="text-decoration: none; ">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Permintaan Perbaikan
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $jumlah_permintaan; ?> Permintaan
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-bell fa-3x text-blue-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                        <a href="proses_perbaikan.php" style="text-decoration: none; ">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Barang Sedang Proses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $jumlah_proses ?> Proses
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-collection-fill fa-3x text-blue-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                        <a href="user.php" style="text-decoration: none; ">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah User</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $jumlah_user ?> User
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-person-fill fa-3x text-blue-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-xl-3 col-md-6 mb-4">
                        <a href="proses_perbaikan.php" style="text-decoration: none; ">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Riwayat</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $jumlah_riwayat ?> Riwayat
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-collection-fill fa-3x text-blue-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Riwayat</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Buat admin bisa menambah tabel jenis_Br dan pem/ker 
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-cart-check-fill fa-3x text-blue-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->

                        <!-- Pending Requests Card Example -->

                    </div>

                    <!-- Content Row -->

                    <div class="row">



                        <!-- Pie Chart -->

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->


                            <!-- Color System -->


                        </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->

                            <!-- Approach -->

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <!-- <span>Copyright &copy; Your Website 2021</span> -->
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>