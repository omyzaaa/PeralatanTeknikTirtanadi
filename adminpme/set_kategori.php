<?php
session_start();
include '../function/connect.php';

function deleteKategori($id_kategori)
{
    global $connection;
    $sql = "DELETE FROM pme_kategori WHERE id_kategori='$id_kategori'";
    return $connection->query($sql);
}
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
                        <div class="card-header">
                            <h5 class="float-left">Tambah Kategori</h5>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <!-- Form to add category -->
                            <form action="shared/crud_kategori.php" method="POST" class="form-inline">
                                <div class="form-group mr-2">
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"  required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="action" value="add">Tambah Kategori</button>
                                <input type="hidden" name="id_kategori" id="edit_id_kategori">
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <h5 class="card-header">List Data Kategori</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="30%">Nama Kategori</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mendapatkan data Barang
                                        $sql = "SELECT * FROM pme_kategori";
                                        $result = $connection->query($sql);
                                        // Cek apakah query berhasil dijalankan
                                        if ($result && $result->num_rows > 0) {
                                            $no = 1;
                                            // Output data dari setiap baris
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $no++ . '</td>';
                                                echo '<td>' . $row['nama_kategori'] . '</td>';
                                                echo '<td>
                                                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="' . $row['id_kategori'] . '" data-nama="' . $row['nama_kategori'] . '">Edit</button>
                                                        <a href="?hapus=' . $row['id_kategori'] . '" class="btn btn-danger btn-sm">Hapus</a>
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

    <script>
        // Mengatur nilai input dan aksi form saat tombol Edit diklik
        $(document).ready(function() {
            $('.btn-edit').click(function() {
                var id_kategori = $(this).data('id');
                var nama_kategori = $(this).data('nama');
                $('#nama_kategori').val(nama_kategori);
                $('#edit_id_kategori').val(id_kategori);
                $('button[type="submit"]').text('Edit Kategori');
                $('button[type="submit"]').attr('name', 'action');
                $('button[type="submit"]').attr('value', 'edit');
            });
        });
    </script>
</body>

</html>