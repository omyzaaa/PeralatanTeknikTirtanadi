<?php
session_start();
include '../function/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php include "mockup/head.php"; ?>

<body id="page-top">
    <div id="wrapper">
        <?php include "mockup/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "mockup/navbar.php"; ?>
                <!-- Main Content -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header">Tambah Kategori</div>
                        <div class="card-body">
                            <!-- Form to add category -->
                            <form action="process_tambah_kategori.php" method="POST">
                                <div class="form-group">
                                    <label for="kode_kategori">Kode Kategori:</label>
                                    <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_kategori">Nama Kategori:</label>
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <h5 class="card-header">Daftar Barang</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Kode Kategori</th>
                                            <th width="30%">Nama Kategori</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Cek apakah query berhasil dijalankan
                                        if ($result && $result->num_rows > 0) {
                                            $no = 1;
                                            // Output data dari setiap baris
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $no++ . '</td>';
                                                echo '<td>' . $row['kode_kategori'] . '</td>';
                                                echo '<td>' . $row['nama_kategori'] . '</td>';
                                                echo '<td>
                                                        <a href="?edit=' . $row['kode_kategori'] . '" class="btn btn-primary btn-sm">Edit</a>
                                                        <a href="?hapus=' . $row['kode_kategori'] . '" class="btn btn-danger btn-sm">Hapus</a>
                                                    </td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="5">Tidak ada data Barang.</td></tr>';
                                        }

                                        if (isset($_GET['hapus'])) {
                                            $kodeKategori = $_GET['hapus'];
                                            if (deleteKategori($kodeKategori)) {
                                                echo "<script>alert('Barang berhasil dihapus');window.location.href='set_kategori.php';</script>";
                                            } else {
                                                echo "<script>alert('Gagal menghapus Barang');</script>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
        </div>
    </div>

    <?php include "mockup/scripts.php"; ?>

</body>

</html>

