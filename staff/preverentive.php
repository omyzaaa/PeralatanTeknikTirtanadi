<?php
include '../shared/koneksi.php';

// Fungsi untuk menghapus Barang
function deleteBarang($BarangID)
{
    global $conn;
    $sql = "DELETE FROM barang WHERE BarangID='$BarangID'";
    return $conn->query($sql);
}

// Query untuk mendapatkan data Barang
$sql = "SELECT * FROM barang";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Barang</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../shared/style.css">

</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include '../asset/sidebar.php' ?>
            <main class="main-content col-md-9 ms-sm-auto col-lg-9 px-md-5">
                <?php
                // Include file koneksi database
                include '../shared/koneksi.php';

                // Query untuk mendapatkan data barang
                $no =   1;
                $sql = "SELECT * FROM barang";
                $result = $conn->query($sql);

                // Cek apakah query berhasil dijalankan
                
                    // Cek apakah terdapat data
                    if ($result && $result->num_rows > 0) {
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th scope="col">BarangID</th>';
                        echo '<th scope="col">Kode Kategori</th>';
                        echo '<th scope="col">Nama Barang</th>';
                        echo '<th scope="col">kondisi</th>';
                        echo '<th scope="col">Tanggal</th>';
                        echo '<th scope="col">Catatan</th>';
                        echo '<th scope="col">Aksi</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        // Output data dari setiap baris
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $no++ . '</td>';
                            echo '<td>' . $row['kode_kategori'] . '</td>';
                            echo '<td>' . $row['nama_barang'] . '</td>';
                            echo '<td>' . $row['kondisi'] . '</td>';
                            echo '<td>' . $row['tanggal'] . '</td>';
                            echo '<td>' . $row['catatan'] . '</td>';
                            echo '<td><a href="?hapus=' . $row['BarangID'] . '" class="btn btn-danger btn-sm">Hapus</a></td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo 'Tidak ada data barang.';
                    }

                    if(isset($_GET['hapus'])) {
                        $BarangID = $_GET['hapus'];
                        if(deleteBarang($BarangID)) {
                            echo "<script>alert('Barang berhasil dihapus');exit():</script>";
                            echo "<script>window.location.href='list_barang.php';</script>";
                        } else {
                            echo "<script>alert('Gagal menghapus Barang');</script>";
                        }
                    }

                // Tutup koneksi
                $conn->close();
                ?>
            </main>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>