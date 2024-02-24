
<?php
session_start();
    include "../function/connect.php";

    if(isset($_POST["btnSimpan"])){
        $pBaru = $_POST['companyPassword'];
        $pKonfirmasi = $_POST['companyKonfirmasi'];
        $pLama = $_POST['companyLama'];
        $pLama2 = md5($pLama);
    
        $id_user = $_SESSION['id_user'];
    
        $cek = mysqli_query($connection, "SELECT * FROM user WHERE id_user = $id_user");
        $row = mysqli_fetch_array($cek);
        $passLama = $row['password'];
        
        if ($pBaru == $pKonfirmasi) {
            if ($passLama == $pLama2) {    
                // Perbarui kata sandi
                $edit_profile = mysqli_query($connection, "UPDATE user SET password = '".md5($pBaru)."' WHERE id_user = $id_user");
                echo '<script> alert("Password berhasil diubah...."); </script>';
                echo '<script> location.replace("index.php"); </script>';
            } else {
                echo '<script> alert("Password lama tidak sesuai"); </script>';
            }
        } else {
            echo '<script> alert("Konfirmasi password tidak sama"); </script>';
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">

<?php
    include "mockup/head.php";
?>

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

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Jumlah Produk-->

                        <div class="card shadow mb-4 w-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                            </div>
                            <div class="card-body align-self-center">
                                <form method="POST" enctype="multipart/form-data">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="align-self-center w-100">
                                                    <div style="font-weight: bold;">Password Baru</div>
                                                    <div class="input-group flex-nowrap mb-3">
                                                        <input type="password" name="companyPassword" class="form-control" aria-describedby="addon-wrapping" placeholder="Masukkan Password Baru">
                                                    </div>
                                                    <div style="font-weight: bold;">Ulangi Password Baru</div>
                                                    <div class="input-group flex-nowrap mb-3">
                                                        <input type="password" name="companyKonfirmasi" class="form-control" aria-describedby="addon-wrapping" placeholder="Ulangi Password Baru">
                                                    </div>
                                                    <div style="font-weight: bold;">Password Lama</div>
                                                    <div class="input-group flex-nowrap mb-3">
                                                        <input type="password" name="companyLama" class="form-control" aria-describedby="addon-wrapping" placeholder="Masukkan Password Saat Ini">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="submit" name="btnSimpan" class="btn btn-primary w-100" value="Simpan Perubahan">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <!-- Pie Chart -->
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
                        <!-- <span>&copy; Your Website 2021</span> -->
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

<?php
if(isset($_POST["btnSimpan"])){
    $pBaru = $_POST['companyPassword'];
    $pKonfirmasi = $_POST['companyKonfirmasi'];
    $pLama = $_POST['companyLama'];
    $pLama2 = md5($pLama);

    $cek = mysqli_query($connection, "SELECT * FROM user WHERE id_user = 8");
    while ($row = mysqli_fetch_array($cek)){
        $passLama = $row['password'];
        
        echo $passLama;
        echo '<br>';
        echo $pLama2;
        echo $pBaru;
        echo '<br>';
        echo $pKonfirmasi;
        echo '<br>';
    }
    
    if ($pBaru == $pKonfirmasi) {
        if ($passLama == $pLama2) {    
            // Perbarui kata sandi
            $edit_profile = mysqli_query($connection, "UPDATE user SET password = '".md5($pBaru)."' WHERE id_user = 8");
            echo '<script> alert("Password berhasil diubah...."); </script>';
            echo '<script> location.replace("index.php"); </script>';
        } else {
            echo '<script> alert("Password lama tidak sesuai"); </script>';
        }
    } else {
        echo '<script> alert("Konfirmasi password tidak sama"); </script>';
    }
    
}

?>
