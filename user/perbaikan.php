<?php
session_start();
include "../function/connect.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

$nama_pengguna = $_SESSION['nama'];

// Fungsi untuk menghandle input data
if (isset($_POST['submit_request'])) {
    $nama_barang = $_POST['nama_barang'];
    $cabang = $_POST['cabang'];
    $keterangan = $_POST['keterangan'];

    // Mendapatkan ID User dari sesi (sesuaikan dengan kebutuhan)
    $id_user = $_SESSION['id_user'];

    // Query untuk memasukkan data ke dalam database
    $query_insert = "INSERT INTO permintaan_perbaikan (id_user, nama_barang, cabang, tanggal_permintaan, keterangan, status) VALUES ('$id_user', '$nama_barang', '$cabang', NOW(), '$keterangan', 'Menunggu')";

    $result_insert = mysqli_query($connection, $query_insert);

    if ($result_insert) {
        // Jika berhasil, lakukan sesuatu, misalnya redirect atau memberikan pesan sukses
        echo '<script>alert("Permintaan berhasil dikirim!");</script>';
        echo '<script>location.replace("perbaikan.php");</script>';
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($connection);
        exit();
    }
}

// Query untuk mengambil data permintaan_perbaikan dan mengurutkannya berdasarkan tanggal_permintaan
$query = "SELECT id_permintaan, id_user, nama_barang, cabang, tanggal_permintaan, keterangan, status FROM permintaan_perbaikan WHERE id_user = {$_SESSION['id_user']} ORDER BY tanggal_permintaan DESC";
$result = mysqli_query($connection, $query);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Nomor urut awal
$no_urut = 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="perbaikan.php">Perbaikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Perminjaman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Person</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <?php echo $nama_pengguna; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Halaman User Dashboard</h1>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#requestModal">
            Request Barang
        </button>

        <!-- Modal -->
        <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Request Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form untuk request barang -->
                        <form method="post" action="">
                            <div style="font-weight: bold;">Nama Barang</div>
                            <div class="input-group flex-nowrap mb-3 w-100">
                                <select name="nama_barang" class="form-control" required>
                                    <?php
                                    $resultJenisBarang = mysqli_query($connection, "SELECT * FROM jenis_barang");
                                    while ($rowJenisBarang = mysqli_fetch_assoc($resultJenisBarang)) {
                                        echo "<option value='" . $rowJenisBarang['nama_barang'] . "'>" . $rowJenisBarang['nama_barang'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div st yle="font-weight: bold;">Cabang</div>
                            <div class="input-group flex-nowrap mb-3 w-100">
                                <select name="cabang" class="form-control" required>
                                    <?php
                                    $resultCabang = mysqli_query($connection, "SELECT * FROM cabang");
                                    while ($rowCabang = mysqli_fetch_assoc($resultCabang)) {
                                        echo "<option value='" . $rowCabang['cabang'] . "'>" . $rowCabang['cabang'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan:</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit_request">Kirim
                                Permintaan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilkan data permintaan perbaikan dalam tabel -->
        <table class="table mt-3">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Cabang</th>
            <th>Tanggal Permintaan</th>
            <th>Keterangan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no_urut = 1; // Inisialisasi nomor urut di luar loop
        // Loop untuk menampilkan data dalam tabel
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$no_urut}</td>";
            echo "<td>{$row['nama_barang']}</td>";
            echo "<td>{$row['cabang']}</td>";
            echo "<td>{$row['tanggal_permintaan']}</td>";
            echo "<td>{$row['keterangan']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "</tr>";
            $no_urut++;
        }
        ?>
    </tbody>
</table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>