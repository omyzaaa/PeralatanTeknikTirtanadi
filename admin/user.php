<?php
include "../function/connect.php";

session_start();
if (isset($_POST['btnEdit'])) {
    $id_user = $_POST['id_user'];
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $cabang = $_POST['cabang'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $sql = "UPDATE user SET nip = '$nip', nama = '$nama', cabang = '$cabang', password = '$password', level = '$level' WHERE id_user = '$id_user'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        echo '<script>location.replace("user.php");</script>';
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
        exit();
    }
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id_user = $_GET['id'];

    if ($action == 'delete') {
        // Proses hapus
        $deleteSql = "DELETE FROM user WHERE id_user = '$id_user'";
        $deleteResult = mysqli_query($connection, $deleteSql);

        if ($deleteResult) {
            echo '<script>location.replace("user.php");</script>';
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
            exit();
        }
    }
}


if (isset($_POST['btnResetPassword'])) {
    $id_user = $_POST['id_user'];
    $new_password = $_POST['new_password'];

    // Lakukan proses reset password, misalnya dengan mengupdate password baru ke database
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $updatePasswordSql = "UPDATE user SET password = '$hashed_password' WHERE id_user = '$id_user'";
    $updateResult = mysqli_query($connection, $updatePasswordSql);

    if ($updateResult) {
        echo '<script>alert("Password berhasil direset.");</script>';
    } else {
        echo '<script>alert("Gagal mereset password.");</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include "mockup/head.php"; ?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include "mockup/sidebar.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include "mockup/navbar.php"; ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <h5> Daftar User - Level User </h5>
                        <div class="card-header py-3"></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">NIP</th>
                                            <th width="15%">Nama</th>
                                            <th width="15%">Cabang</th>
                                            <th width="8px">Password</th>
                                            <th width="15%">Level</th>
                                            <th width="5%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $level = 'user'; // Change this to the specific level you want to display
                                        $users = mysqli_query($connection, "SELECT id_user, nip, nama, cabang, password, level FROM user WHERE level = '$level'");
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($users)) {
                                            $no++;
                                            $id_user = $row['id_user'];
                                            $nip = $row['nip'];
                                            $nama = $row['nama'];
                                            $cabang = $row['cabang'];
                                            $password = $row['password'];
                                            $level = $row['level'];
                                            ?>
                                            <tr>
                                                <td align="center">
                                                    <?php echo $no; ?>
                                                </td>
                                                <td>
                                                    <?php echo $nip; ?>
                                                </td>
                                                <td>
                                                    <?php echo $nama; ?>
                                                </td>
                                                <td>
                                                    <?php echo $cabang; ?>
                                                </td>
                                                <td>
                                                    <?php echo $password; ?>
                                                </td>
                                                <td>
                                                    <?php echo $level; ?>
                                                </td>

                                                <td align="center">
                                                    <button class="btn btn-warning w-100 mb-2" data-toggle="modal"
                                                        data-target="#editData<?php echo $id_user; ?>">Edit</button>

                                                        <button class="btn btn-primary w-100 mb-2" data-toggle="modal"
                                                        data-target="#resetPassword<?php echo $id_user; ?>">Reset
                                                        Password</button>
                                                    <a href="user.php?action=delete&id=<?php echo $id_user; ?>"
                                                        class="btn btn-danger w-100"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>

                                                    
                                                </td>
                                            </tr>
                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editData<?php echo $id_user; ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_user"
                                                                    value="<?php echo $id_user; ?>">

                                                                <div style="font-weight: bold;">NIP</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="nip" class="form-control"
                                                                        placeholder="NIP" value="<?php echo $nip; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Nama</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="nama" class="form-control"
                                                                        placeholder="Nama" value="<?php echo $nama; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Cabang</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="cabang" class="form-control"
                                                                        placeholder="Cabang" value="<?php echo $cabang; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Password</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="password" name="password"
                                                                        class="form-control" placeholder="Password"
                                                                        value="<?php echo $password; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Level</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="level" class="form-control"
                                                                        placeholder="Level" value="<?php echo $level; ?>">
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Kembali</button>
                                                                    <button type="submit" name="btnEdit"
                                                                        class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Modal Reset Password -->
                                            <div class="modal fade" id="resetPassword<?php echo $id_user; ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Reset Password
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_user"
                                                                    value="<?php echo $id_user; ?>">

                                                                <div style="font-weight: bold;">Password Baru</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="password" name="new_password"
                                                                        class="form-control" placeholder="Password Baru"
                                                                        required>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit" name="btnResetPassword"
                                                                        class="btn btn-primary">Reset Password</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Add your modals here if needed -->
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
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
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>
</body>

</html>