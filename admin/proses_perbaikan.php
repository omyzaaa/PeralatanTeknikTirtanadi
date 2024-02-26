<?php
session_start();
include "../function/connect.php";
include "crud.php";
include "modal.php";
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
                        <h5> Daftar Proses Perbaikan </h5>
                        <div class="card-header py-3">
                        <div class="btn-group">
                            <button class="btn btn-success mr-2" data-toggle="modal"
                                data-target="#tambahBarangModal">Tambah
                                Barang
                            </button>
                            
                            <a href="cetak/realisasi.php" class="btn btn-success mr-2" target="_Blank">Realisasi</a>
                            <a href="cetak/tandaterima.php" class="btn btn-success mr-2" target="_Blank">Tanda Terima</a>

                            
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Cetak
                                </button>
                                <div class="dropdown-menu">
    <a class="dropdown-item" href="cetak/cetakcpu.php?id_proses=<?php echo $id_proses; ?>" target="_blank">CPU</a>
    <a class="dropdown-item" href="cetak/cetakups.php?id_proses=<?php echo $id_proses; ?>" target="_blank">UPS</a>
    <a class="dropdown-item" href="cetak/cetakmonitor.php?id_proses=<?php echo $id_proses; ?>" target="_blank">Monitor</a>
    <a class="dropdown-item" href="cetak/cetakprinter.php?id_proses=<?php echo $id_proses; ?>" target="_blank">Printer</a>
</div>

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%"
                                    cellspacing="0">

                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th width="5%">Nama Barang</th>
                                            <th width="5%">SN</th>
                                            <th width="5%">Jenis</th>
                                            <th width="5%">Cabang</th>
                                            <th width="5%">Tgl surat masuk</th>
                                            <th width="5%">Keterangan</th>
                                            <th width="10%">Pemeriksa</th>
                                            <th width="15%">Catatan</th>
                                            <th width="15%">Pemeriksaan</th>
                                            <th width="20%">Kerusakan</th>
                                            <th width="15">Rekomendasi</th>
                                            <th width="5%">Aksi</th>
                                            <th width="5%">Cetak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $requests = mysqli_query($connection, "SELECT * FROM proses_perbaikan");
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($requests)) {
                                            $no++;
                                            $id_permintaan = $row['id_permintaan'];
                                            $id_proses = $row['id_proses'];
                                            $nama_barang = $row['nama_barang'];
                                            $sn = $row['sn'];
                                            $jenis = $row['jenis'];
                                            $cabang = $row['cabang'];
                                            $tanggal_surat = $row['tanggal_surat'];
                                            $keterangan = $row['keterangan'];
                                            $pemeriksa = $row['pemeriksa'];
                                            $catatan = $row['catatan'];
                                            $pemeriksaan = $row['pemeriksaan'];
                                            $kerusakan = $row['kerusakan'];
                                            $rekomendasi = $row['rekomendasi'];

                                            ?>
                                            <tr>
                                                <td align="center">
                                                    <?php echo $no; ?>
                                                </td>
                                                <td>
                                                    <?php echo $nama_barang; ?>
                                                </td>
                                                <td>
                                                    <?php echo $sn; ?>
                                                </td>
                                                <td>
                                                    <?php echo $jenis; ?>
                                                </td>
                                                <td>
                                                    <?php echo $cabang; ?>
                                                </td>
                                                <td>
                                                    <?php echo $tanggal_surat; ?>
                                                </td>
                                                <td>
                                                    <?php echo $keterangan; ?>
                                                </td>
                                                <td>
                                                    <?php echo $pemeriksa; ?>
                                                </td>
                                                <td>
                                                    <?php echo $catatan; ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $pemeriksaan_values = explode(", ", $pemeriksaan);
                                                    // Menghapus tanda strip (-) dari awal setiap nilai pemeriksaan
                                                    foreach ($pemeriksaan_values as &$item) {
                                                        $item = ltrim($item, '-');
                                                    }
                                                    unset($item); // Hapus referensi terakhir agar tidak mempengaruhi loop berikutnya
                                                
                                                    foreach ($pemeriksaan_values as $item) {
                                                        echo "- " . $item . "<br>";
                                                    }
                                                    ?>

                                                </td>

                                                <td>
                                                    <?php
                                                    $kerusakan_values = explode(", ", $kerusakan);
                                                    // Menghapus tanda strip (-) dari awal setiap nilai pemeriksaan
                                                    foreach ($kerusakan_values as &$item) {
                                                        $item = ltrim($item, '-');
                                                    }
                                                    unset($item); // Hapus referensi terakhir agar tidak mempengaruhi loop berikutnya
                                                
                                                    foreach ($kerusakan_values as $item) {
                                                        echo "- " . $item . "<br>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $rekomendasi; ?>
                                                </td>
                                                <!-- NAVIGASI -->
                                                <td align="center">
                                                    <button class="btn btn-warning w-100 mb-2" data-toggle="modal"
                                                        data-target="#editData<?php echo $id_proses; ?>"><i
                                                            class="bi-solid bi-pen"></i>
                                                    </button>

                                                    <button class="btn btn-info w-100 mb-2" data-toggle="modal"
                                                        data-target="#pemeriksaanKerusakanModal<?php echo $id_proses; ?>"><i
                                                            class="bi-solid bi-wrench"></i>
                                                    </button>

                                                    <a href="proses_perbaikan.php?action=delete&id=<?php echo $id_proses; ?>"
                                                        class="btn btn-danger w-100"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                            class="bi-solid bi-trash"></i></a>
                                                </td>

                                                <td>
                                                    <button class="btn btn-info w-100 mb-2"
                                                        onclick="tampilkanModal(<?php echo $id_proses; ?>, '<?php echo $nama_barang; ?>', '<?php echo $sn; ?>')">Realisasi</button>

                                                    <button class="btn btn-success w-100 mb-2"
                                                        onclick="Tandaterima(<?php echo $id_proses; ?>, '<?php echo $nama_barang; ?>', '<?php echo $sn; ?>')">T.terima</button>


                                                    <?php
                                                    // Tentukan URL berdasarkan nama_barang
                                                    $cetak_url = '';
                                                    switch ($nama_barang) {
                                                        case 'MONITOR':
                                                            $cetak_url = 'cetak/cetakmonitor.php?id_proses=' . $id_proses;
                                                            break;
                                                        case 'CPU':
                                                            $cetak_url = 'cetak/cetakcpu.php?id_proses=' . $id_proses;
                                                            break;
                                                        case 'PRINTER':
                                                            $cetak_url = 'cetak/cetakprinter.php?id_proses=' . $id_proses;
                                                            break;
                                                        case 'UPS':
                                                            $cetak_url = 'cetak/cetakups.php?id_proses=' . $id_proses;
                                                            break;
                                                        default:
                                                            // URL default jika nama_barang tidak sesuai
                                                            $cetak_url = '#'; // atau atur URL lain jika diperlukan
                                                    }
                                                    ?>

                                                    <a href="<?php echo $cetak_url; ?>" class="btn btn-danger w-100 mb-2"
                                                        target="_blank">Cetak</a>


                                                    <button class="btn btn-success w-100 mb-2"
                                                        onclick="selesai(<?php echo $id_proses; ?>)">Selesai</button>
                                                </td>

                                            </tr>
                                            <?php include 'modal.php' ?>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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

    </div>

    <script>
        function Tandaterima(id_proses, nama_barang, sn) {
            $('#nama_barang_terima').val(nama_barang);
            $('#sn_terima').val(sn);
            $('#tandaTerimaModal').modal('show');
        }
    </script>


    <script>
        function tampilkanModal(id_proses, nama_barang, sn) {
            // Set nilai pada elemen-elemen modal dengan data yang sesuai
            document.getElementById('id_proses').value = id_proses;
            document.getElementById('id_proses_modal').value = id_proses;
            document.getElementById('nama_barang').value = nama_barang;
            document.getElementById('sn').value = sn;
            // Tampilkan modal
            $('#realisasiModal' + id_proses).modal('show');
        }
    </script>
    <script>
        function selesai(id_proses) {
            if (confirm('Apakah Anda yakin ingin menyelesaikan proses perbaikan ini?')) {
                window.location.href = 'proses_perbaikan.php?action=selesai&id_proses=' + id_proses;
            }
        }
    </script>

</body>

</html>