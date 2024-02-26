<?php
include "../function/connect.php";
session_start();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id_riwayat = $_GET['id'];

    if ($action == 'delete') {
        $deleteSql = "DELETE FROM riwayat_perbaikan WHERE id_riwayat = '$id_riwayat'";
        $deleteResult = mysqli_query($connection, $deleteSql);

        if ($deleteResult) {
            echo '<script>location.replace("riwayat.php");</script>';
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
            exit();
        }
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
                    <div class="card shadow mb-4 ">
                        <h5> Daftar Riwayat Barang yang telah selesai </h5>
                        <div class="card-header py-3">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="15%">Tanggal surat masuk</th>
                                            <th width="10%">Unit Kerja</th>
                                            <th width="10%">Jenis</th>
                                            <th width="10%">Kerusakan</th>
                                            <th width="20%">Waktu Identifikasi</th>
                                            <th width="25%">Waktu Penyelesaian</th>
                                            <th width="20%">Lokasi Dokumen</th>
                                            <th width="10%">Keterangan</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $requests = mysqli_query($connection, "SELECT * FROM riwayat_perbaikan");
                                        while ($row = mysqli_fetch_array($requests)) {
                                            $id_riwayat         = $row['id_riwayat'];
                                            $tanggal_surat      = $row['tanggal_surat'];
                                            $cabang             = $row['cabang'];
                                            $jenis              = $row['jenis'];
                                            $kerusakan          = $row['kerusakan'];
                                            $waktu_identifikasi = $row['waktu_identifikasi'];
                                            $waktu_penyelesaian = $row['waktu_penyelesaian'];
                                            $lokasi_dokumen     = $row['lokasi_dokumen'];
                                            $keterangan         = $row['keterangan'];

                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $tanggal_surat; ?></td>
                                                <td><?php echo $cabang; ?></td>
                                                <td><?php echo $jenis; ?></td>
                                                <td><?php echo $kerusakan; ?></td>
                                                <td><?php echo $waktu_identifikasi; ?></td>
                                                <td><?php echo $waktu_penyelesaian; ?></td>
                                                <td><?php echo $lokasi_dokumen; ?></td>
                                                <td><?php echo $keterangan; ?></td>
                                                <td align="center">
                                                    <button class="btn btn-warning w-100 mb-2" data-toggle="modal"
                                                        data-target="#editData<?php echo $id_riwayat; ?>">edit
                                                    </button>
                                                    <button class="btn btn-info w-100 mb-2" data-toggle="modal"
                                                        data-target="#detailData<?php echo $id_riwayat; ?>">detail
                                                    </button>

                                                    <a href="riwayat.php?action=delete&id=<?php echo $id_riwayat; ?>"
                                                        class="btn btn-danger w-100"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                            class="bi-solid bi-trash"></i></a>
                                                </td>
                                            </tr>
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

        <!-- Modal Detail Data -->
        <?php
        $requests = mysqli_query($connection, "SELECT * FROM riwayat_perbaikan");
        while ($row = mysqli_fetch_array($requests)) {
            $nama_barang        = $row['nama_barang'];
            $tanggal_surat      = $row['tanggal_surat'];
            $sn                 = $row['sn'];
            $cabang             = $row['cabang'];
            $jenis              = $row['jenis'];
            $kerusakan          = $row['kerusakan'];
            $waktu_identifikasi = $row['waktu_identifikasi'];
            $waktu_penyelesaian = $row['waktu_penyelesaian'];
            $lokasi_dokumen     = $row['lokasi_dokumen'];
            $keterangan         = $row['keterangan'];
            $pemeriksa          = $row['pemeriksa'];
            $catatan            = $row['catatan'];
            $rekomendasi        = $row['rekomendasi'];
            $pemeriksaan        = $row['pemeriksaan'];
            ?>
            <div class="modal fade" id="detailData<?php echo $id_riwayat; ?>" tabindex="-1" role="dialog" aria-labelledby="detailDataTitle<?php echo $id_riwayat; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailDataTitle<?php echo $id_riwayat; ?>">Detail Data Riwayat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tr>
                                    <th>Nama Barang</th>
                                    <td><?php echo $nama_barang; ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Surat</th>
                                    <td><?php echo $tanggal_surat; ?></td>
                                </tr>
                                <tr>
                                    <th>SN</th>
                                    <td><?php echo $sn; ?></td>
                                </tr>
                                <tr>
                                    <th>Cabang</th>
                                    <td><?php echo $cabang; ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <td><?php echo $jenis; ?></td>
                                </tr>
                                <tr>
                                    <th>Kerusakan</th>
                                    <td><?php echo $kerusakan; ?></td>
                                </tr>
                                <tr>
                                    <th>Waktu Identifikasi</th>
                                    <td><?php echo $waktu_identifikasi; ?></td>
                                </tr>
                                <tr>
                                    <th>Waktu Penyelesaian</th>
                                    <td><?php echo $waktu_penyelesaian; ?></td>
                                </tr>
                                <tr>
                                    <th>Lokasi Dokumen</th>
                                    <td><?php echo $lokasi_dokumen; ?></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td><?php echo $keterangan; ?></td>
                                </tr>
                                <tr>
                                    <th>Pemeriksa</th>
                                    <td><?php echo $pemeriksa; ?></td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td><?php echo $catatan; ?></td>
                                </tr>
                                <tr>
                                    <th>Rekomendasi</th>
                                    <td><?php echo $rekomendasi; ?></td>
                                </tr>
                                <tr>
                                    <th>Pemeriksaan</th>
                                    <td><?php echo $pemeriksaan; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
</body>
</html>
