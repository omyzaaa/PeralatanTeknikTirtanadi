<?php
include "../function/connect.php";

session_start();

//edit
if (isset($_POST['btnEdit'])) {
    $id_permintaan = $_POST['id_permintaan'];
    $nama_barang = $_POST['nama_barang'];
    $cabang = $_POST['cabang'];
    $tanggal_permintaan = $_POST['tanggal_permintaan'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];

    $sql = "UPDATE permintaan_perbaikan SET nama_barang = '$nama_barang', cabang = '$cabang', tanggal_permintaan = '$tanggal_permintaan', keterangan = '$keterangan', status = '$status' WHERE id_permintaan = '$id_permintaan'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        echo '<script>location.replace("permintaan_perbaikan.php");</script>';
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
        exit();
    }
}
//hapus
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id_permintaan = $_GET['id'];

    if ($action == 'delete') {
        // Proses hapus
        $deleteSql = "DELETE FROM permintaan_perbaikan WHERE id_permintaan = '$id_permintaan'";
        $deleteResult = mysqli_query($connection, $deleteSql);

        if ($deleteResult) {
            echo '<script>location.replace("permintaan_perbaikan.php");</script>';
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
            exit();
        }
    }
}

//proses

// Tangkap parameter id dari URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id_permintaan = $_GET['id'];

    // Query untuk mengambil data barang yang selesai
    $sql = "SELECT * FROM permintaan_perbaikan WHERE id_permintaan = $id_permintaan";
    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        // Ambil data dari hasil query
        $row = $result->fetch_assoc();

        // Pindahkan data ke tabel riwayat_barang
        $sqlInsert = "INSERT INTO proses_perbaikan (id_permintaan, nama_barang, cabang, keterangan)
                      VALUES ('" . $row["id_permintaan"] . "', '" . $row["nama_barang"] . "', '" . $row["cabang"] . "', '" . $row["keterangan"] . "')";

        if ($connection->query($sqlInsert) === TRUE) {
            // Hapus data dari tabel barang
            $sqlDelete = "DELETE FROM permintaan_perbaikan WHERE id_permintaan = $id_permintaan";

            if ($connection->query($sqlDelete) === TRUE) {
                echo "Barang berhasil di acc.";
            } else {
                echo "Error deleting record: " . mysqli_error($connection);
            }
        } else {
            echo "Error inserting record into proses_barang: " . mysqli_error($connection);
        }
    } else {
        echo "Barang tidak ditemukan.";
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
                        <h5> Daftar Permintaan </h5>
                        <div class="card-header py-3">
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">Nama Barang</th>
                                            <th width="15%">Cabang</th>
                                            <th width="15%">Tanggal Permintaan</th>
                                            <th width="15%">Keterangan</th>
                                            <th width="15%">Status</th>
                                            <th width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $requests = mysqli_query($connection, "SELECT * FROM permintaan_perbaikan");
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($requests)) {
                                            $no++;
                                            $id_permintaan = $row['id_permintaan'];
                                            $nama_barang = $row['nama_barang'];
                                            $cabang = $row['cabang'];
                                            $tanggal_permintaan = $row['tanggal_permintaan'];
                                            $keterangan = $row['keterangan'];
                                            $status = $row['status'];
                                            ?>
                                            <tr>
                                                <td align="center">
                                                    <?php echo $no; ?>
                                                </td>
                                                <td>
                                                    <?php echo $nama_barang; ?>
                                                </td>
                                                <td>
                                                    <?php echo $cabang; ?>
                                                </td>
                                                <td>
                                                    <?php echo $tanggal_permintaan; ?>
                                                </td>
                                                <td>
                                                    <?php echo $keterangan; ?>
                                                </td>
                                                <td>
                                                    <?php echo $status; ?>
                                                </td>

                                                <td align="center">
                                                    <button class="btn btn-warning w-100 mb-2" data-toggle="modal"
                                                        data-target="#editData<?php echo $id_permintaan; ?>">Edit</button>


                                                    <a href="permintaan_perbaikan.php?action=proses&id=<?php echo $id_permintaan; ?>"
                                                        class="btn btn-info w-100 mb-2">proses</a>

                                                    <a href="permintaan_perbaikan.php?action=delete&id=<?php echo $id_permintaan; ?>"
                                                        class="btn btn-danger w-100"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editData<?php echo $id_permintaan; ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                Permintaan Perbaikan</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_permintaan"
                                                                    value="<?php echo $id_permintaan; ?>">

                                                                <div style="font-weight: bold;">Nama Barang</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="nama_barang"
                                                                        class="form-control" placeholder="Nama Barang"
                                                                        value="<?php echo $nama_barang; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Cabang</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="cabang" class="form-control"
                                                                        placeholder="Cabang" value="<?php echo $cabang; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Tanggal
                                                                    Permintaan</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="tanggal_permintaan"
                                                                        class="form-control"
                                                                        placeholder="Tanggal Permintaan"
                                                                        value="<?php echo $tanggal_permintaan; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Keterangan</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <textarea name="keterangan" class="form-control"
                                                                        placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                                                                </div>
                                                                <div style="font-weight: bold;">Status</div>
                                                                <div class="input-group flex-nowrap mb-3 w-50">
                                                                    <input type="text" name="status" class="form-control"
                                                                        placeholder="Status" value="<?php echo $status; ?>">
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

                                            <!-- Modal Proses -->

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

    </div>
</body>

</html>