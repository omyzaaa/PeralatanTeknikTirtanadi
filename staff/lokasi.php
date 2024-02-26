<?php
    include '../shared/koneksi.php';

    // Fungsi untuk menghapus lokasi
    function deleteLokasi($lokasiID) {
        global $conn;
        $sql = "DELETE FROM lokasi WHERE id_lokasi='$lokasiID'";
        return $conn->query($sql);
    }

    // Query untuk mendapatkan data lokasi
    $sql = "SELECT * FROM lokasi";
    $result = $conn->query($sql);

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../shared/style.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include '../asset/sidebar.php' ?>
        <main class="main-content col-md-9 ms-sm-auto col-lg-9 px-md-5">
            <?php
                if ($result && $result->num_rows > 0) {
                    echo '<table class="table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th scope="col">No</th>';
                    echo '<th scope="col">Nama Lokasi</th>';
                    echo '<th scope="col">Aksi</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    // Output data dari setiap baris
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['id_lokasi'] . '</td>';
                        echo '<td>' . $row['nama_lokasi'] . '</td>';
                        echo '<td><a href="?hapus=' . $row['id_lokasi'] . '" class="btn btn-danger btn-sm">Hapus</a></td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo 'Tidak ada data Lokasi.';
                }

                if(isset($_GET['hapus'])) {
                    $lokasiID = $_GET['hapus'];
                    if(deleteLokasi($lokasiID)) {
                        echo "<script>alert('Lokasi berhasil dihapus');exit():</script>";
                        echo "<script>window.location.href='lokasi.php';</script>";
                    } else {
                        echo "<script>alert('Gagal menghapus lokasi');</script>";
                    }
                }

                // Tutup koneksi
                $conn->close();
                ?>
        </main>
    </div>
</div>

</body>
</html>
