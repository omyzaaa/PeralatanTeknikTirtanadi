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

                            <button class="btn btn-success mb-2" data-toggle="modal"
                                data-target="#tambahBarangModal">Tambah
                                Barang
                            </button>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

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
                                                    <button class="btn btn-info w-100 mb-2" data-toggle="modal"
                                                        data-target="#realisasiModal<?php echo $id_proses; ?>">Realisasi
                                                    </button>

                                                    <?php
                                                    // Tentukan URL berdasarkan nama_barang
                                                    $cetak_url = '';
                                                    switch ($nama_barang) {
                                                        case 'MONITOR':
                                                            $cetak_url = 'cetakmonitor.php?id_proses=' . $id_proses;
                                                            break;
                                                        case 'CPU':
                                                            $cetak_url = 'cetakcpu.php?id_proses=' . $id_proses;
                                                            break;
                                                        case 'PRINTER':
                                                            $cetak_url = 'cetakprinter.php?id_proses=' . $id_proses;
                                                            break;
                                                        default:
                                                            // URL default jika nama_barang tidak sesuai
                                                            $cetak_url = '#'; // atau atur URL lain jika diperlukan
                                                    }
                                                    ?>

                                                    <a href="<?php echo $cetak_url; ?>"
                                                        class="btn btn-danger w-100 mb-2">Cetak</a>

                                                    <button class="btn btn-success w-100 mb-2"
                                                        onclick="Tandaterima(<?php echo $id_proses; ?>)">
                                                        Terima</button>

                                                        <button class="btn btn-success w-100 mb-2" onclick="selesai(<?php echo $id_proses; ?>)">Selesai</button>
                                                </td>

                                            </tr>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editData<?php echo $id_proses; ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                Proses Perbaikan</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_proses"
                                                                    value="<?php echo $id_proses; ?>">

                                                                <div style="font-weight: bold;">SN</div>
                                                                <div class="input-group flex-nowrap mb-3 w-100">
                                                                    <input type="text" name="sn" class="form-control"
                                                                        placeholder="SN" value="<?php echo $sn; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Jenis</div>
                                                                <div class="input-group flex-nowrap mb-3 w-100">
                                                                    <input type="text" name="jenis" class="form-control"
                                                                        placeholder="Jenis" value="<?php echo $jenis; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Cabang</div>
                                                                <div class="input-group flex-nowrap mb-3 w-100">
                                                                    <input type="text" name="cabang" class="form-control"
                                                                        placeholder="Cabang" value="<?php echo $cabang; ?>">
                                                                </div>
                                                                <div style="font-weight: bold;">Tanggal
                                                                    Surat</div>
                                                                <div class="input-group flex-nowrap mb-3 w-100">
                                                                    <input type="date" name="tanggal_surat"
                                                                        class="form-control" placeholder="Tanggal Surat"
                                                                        value="<?php echo $tanggal_surat; ?>">
                                                                </div>

                                                                <div style="font-weight: bold;">Keterangan</div>
                                                                <div class="input-group flex-nowrap mb-3 w-100">
                                                                    <textarea name="keterangan" class="form-control"
                                                                        placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                                                                </div>
                                                                <div style="font-weight: bold;">Pemeriksa</div>
                                                                <div class="input-group flex-nowrap mb-3 w-100">
                                                                    <textarea name="pemeriksa" class="form-control"
                                                                        placeholder="Pemeriksa"><?php echo $pemeriksa; ?></textarea>
                                                                </div>
                                                                <div style="font-weight: bold;">Catatan</div>
                                                                <div class="input-group flex-nowrap mb-3 w-100">
                                                                    <textarea name="catatan" class="form-control"
                                                                        placeholder="Catatan"><?php echo $catatan; ?></textarea>
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
                                            <!--pemriksaan/kerusakan/rekomendasi -->

                                            <div class="modal fade" id="pemeriksaanKerusakanModal<?php echo $id_proses; ?>"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content m-5 p-3">

                                                        <form method="POST" action="proses_perbaikan.php">
                                                            <input type="hidden" name="id_proses"
                                                                value="<?php echo $id_proses; ?>">
                                                            <?php
                                                            // Ambil nama_barang dari data proses_perbaikan
                                                            $nama_barang = $row['nama_barang'];

                                                            // Tentukan nama tabel berdasarkan nama_barang
                                                            switch ($nama_barang) {
                                                                case 'MONITOR':
                                                                    $table_name_pemeriksaan = "pem_monitor";
                                                                    $table_name_kerusakan = "ker_monitor";
                                                                    break;
                                                                case 'CPU':
                                                                    $table_name_pemeriksaan = "pem_cpu";
                                                                    $table_name_kerusakan = "ker_cpu";
                                                                    break;
                                                                case 'PRINTER':
                                                                    $table_name_pemeriksaan = "pem_printer";
                                                                    $table_name_kerusakan = "ker_printer";
                                                                    break;
                                                                case 'UPS':
                                                                    $table_name_pemeriksaan = "pem_ups";
                                                                    $table_name_kerusakan = "ker_ups";
                                                                default:
                                                                    // Default jika nama_barang tidak sesuai
                                                                    $table_name_pemeriksaan = ""; // Atau sesuaikan dengan tabel default jika ada
                                                                    $table_name_kerusakan = "";
                                                            }

                                                            // Lakukan query hanya jika nama tabel sudah ditentukan
                                                            if (!empty($table_name_pemeriksaan) && !empty($table_name_kerusakan)) {
                                                                $query_pemeriksaan = "SELECT * FROM $table_name_pemeriksaan";
                                                                $result_pemeriksaan = mysqli_query($connection, $query_pemeriksaan);

                                                                $query_kerusakan = "SELECT * FROM $table_name_kerusakan";
                                                                $result_kerusakan = mysqli_query($connection, $query_kerusakan);

                                                                // Tampilkan opsi pemeriksaan dalam bentuk checkbox
                                                                echo "<br><div class='text-center'><p>PEMERIKSAAN AWAL(Trouble Shooting)</p></div>";
                                                                while ($rowPemeriksaan = mysqli_fetch_assoc($result_pemeriksaan)) {
                                                                    $pemeriksaan_option = $rowPemeriksaan['pemeriksaan'];
                                                                    echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='pemeriksaan[]' value='$pemeriksaan_option' " . (in_array($pemeriksaan_option, $pemeriksaan_values) ? 'checked' : '') . ">
                                <label class='form-check-label'>$pemeriksaan_option</label>
                            </div>";
                                                                }

                                                                // Tampilkan opsi kerusakan dalam bentuk checkbox
                                                                echo "<div class='text-center'><br><p>IDENTIFIKASI KERUSAKAN HARDWARE</p></div>";
                                                                while ($rowKerusakan = mysqli_fetch_assoc($result_kerusakan)) {
                                                                    $kerusakan_option = $rowKerusakan['kerusakan'];
                                                                    echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='kerusakan[]' value='$kerusakan_option' " . (in_array($kerusakan_option, $kerusakan_values) ? 'checked' : '') . ">
                                <label class='form-check-label'>$kerusakan_option</label>
                            </div>";
                                                                }

                                                            }
                                                            // Ambil rekomendasi dari data proses_perbaikan
                                                            $query_proses_perbaikan = "SELECT rekomendasi FROM proses_perbaikan WHERE id_proses = $id_proses";
                                                            $result_proses_perbaikan = mysqli_query($connection, $query_proses_perbaikan);
                                                            $row_proses_perbaikan = mysqli_fetch_assoc($result_proses_perbaikan);
                                                            $rekomendasi_values = explode(", ", $row_proses_perbaikan['rekomendasi']);

                                                            // Lakukan query untuk mengambil opsi rekomendasi kerusakan dari tabel rekomendasi_ker
                                                            $query_rekomendasi = "SELECT * FROM rekomendasi_ker";
                                                            $result_rekomendasi = mysqli_query($connection, $query_rekomendasi);

                                                            // Tampilkan opsi rekomendasi kerusakan dalam bentuk checkbox
                                                            echo "<div class='text-center'><br><p>REKOMENDASI KERUSAKAN</p></div>";
                                                            while ($rowRekomendasi = mysqli_fetch_assoc($result_rekomendasi)) {
                                                                $rekomendasi_option = $rowRekomendasi['rekomendasi'];
                                                                echo "<div class='form-check'>
            <input class='form-check-input' type='checkbox' name='rekomendasi[]' value='$rekomendasi_option'";
                                                                // Periksa apakah rekomendasi dipilih sebelumnya
                                                                if (in_array($rekomendasi_option, $rekomendasi_values)) {
                                                                    echo " checked";
                                                                }
                                                                echo ">
            <label class='form-check-label'>$rekomendasi_option</label>
        </div>";
                                                            }



                                                            ?>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tutup</button>
                                                                <button type="submit" name="btnSimpan"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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

    </div>
    <script>
    function selesai(id_proses) {
        if (confirm('Apakah Anda yakin ingin menyelesaikan proses perbaikan ini?')) {
            window.location.href = 'proses_perbaikan.php?action=selesai&id_proses=' + id_proses;
        }
    }
</script>


</body>

</html>