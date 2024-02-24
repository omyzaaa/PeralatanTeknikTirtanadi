<?php
session_start();
include '../function/connect.php';

// Fungsi untuk menghapus Barang
function deleteBarang($BarangID)
{
    global $connection;
    $sql = "DELETE FROM barang WHERE BarangID='$BarangID'";
    return $connection->query($sql);
}

// Query untuk mendapatkan data Barang
$sql = "SELECT * FROM pme_barang";
$result = $connection->query($sql);

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
                        <h5 class="card-header">Daftar Barang</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="30%">Nama Barang</th>
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
                                                echo '<td>' . $row['nama_barang'] . '</td>';
                                                echo '<td>' . $row['nama_kategori'] . '</td>';
                                                echo '<td><a href="?hapus=' . $row['BarangID'] . '" class="btn btn-danger btn-sm">Hapus</a></td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="5">Tidak ada data Barang.</td></tr>';
                                        }

                                        if (isset($_GET['hapus'])) {
                                            $BarangID = $_GET['hapus'];
                                            if (deleteBarang($BarangID)) {
                                                echo "<script>alert('Barang berhasil dihapus');window.location.href='list_barang.php';</script>";
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
