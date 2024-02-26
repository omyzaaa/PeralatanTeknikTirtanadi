<?php
session_start();
include "../function/connect.php";

// Fungsi untuk menghapus lokasi
function deleteLokasi($lokasiID)
{
    global $connection;
    $sql = "DELETE FROM pme_lokasi WHERE id_lokasi='$lokasiID'";
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
                <div class="container-fluid">
                <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="float-left">Nama lokasi</h5>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <!-- Form to add category -->
                            <form action="shared/crud_kategori.php" method="POST" class="form-inline">
                                <div class="form-group mr-3">
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Input nama lokasi" size="50" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="action" value="add" >Tambah Data Lokasi</button>
                                <input type="hidden" name="id_kategori" id="edit_id_kategori">
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <h5 class="card-header">List Data Lokasi</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="75%">Nama Lokasi</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        // Query untuk mendapatkan data lokasi
                                        $sql = "SELECT * FROM pme_lokasi";
                                        $result = $connection->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $row['id_lokasi'] . '</td>';
                                                echo '<td>' . $row['nama_lokasi'] . '</td>';
                                                echo '<td>
                                                <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="' . $row['id_lokasi'] . '" data-nama="' . $row['nama_lokasi'] . '">Edit</button>
                                                <a href="?hapus=' . $row['id_lokasi'] . '" class="btn btn-danger btn-sm">Hapus</a></td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="3">Tidak ada data Lokasi.</td></tr>';
                                        }

                                        if (isset($_GET['hapus'])) {
                                            $lokasiID = $_GET['hapus'];
                                            if (deleteLokasi($lokasiID)) {
                                                echo "<script>alert('Lokasi berhasil dihapus');window.location.href='lokasi.php';</script>";
                                            } else {
                                                echo "<script>alert('Gagal menghapus lokasi');</script>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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