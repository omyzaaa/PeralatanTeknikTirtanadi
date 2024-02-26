<?php
session_start();
include '../function/connect.php';

// Fungsi untuk menghapus jadwal
function deleteJadwal($jadwalID)
{
    global $connection;
    $sql = "DELETE FROM pme_jadwal WHERE id_jadwal='$jadwalID'";
    return $connection->query($sql);
}

// Tangkap data dari form jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari form tambah jadwal
    $bulan = $_POST['bulan'];
    $nama_lokasi = $_POST['nama_lokasi'];

    // Query untuk memasukkan data jadwal ke dalam tabel jadwal
    $sql_insert_jadwal = "INSERT INTO pme_jadwal (bulan, nama_lokasi) VALUES ('$bulan', '$nama_lokasi')";

    // Eksekusi query dan periksa apakah data berhasil dimasukkan
    if ($connection->query($sql_insert_jadwal) === TRUE) {
        echo "<script>alert('Jadwal berhasil ditambahkan');</script>";
        echo "<script>window.location.href='set_jadwal.php';</script>"; // Redirect ke halaman set_jadwal.php setelah proses berhasil
    } else {
        echo "<script>alert('Error: " . $sql_insert_jadwal . "\\n" . $connection->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "mockup/head.php" ?>

<body id="page-top">
    <div id="wrapper">
        <?php include "mockup/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "mockup/navbar.php"; ?>
                <!-- Main Content -->
                <div class="container-fluid">
                    <div class="col-md-6">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <h2>Tambah Jadwal</h2>
                            <div class="form px-md-4">
                                <div class="form-group">
                                    <label for="bulan">Bulan:</label>
                                    <select class="form-control" id="bulan" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        <?php
                                        $bulan_sekarang = date('F');
                                        $daftar_bulan = [
                                            'Januari' => 'Januari',
                                            'Februari' => 'Februari',
                                            'Maret' => 'Maret',
                                            'April' => 'April',
                                            'Mei' => 'Mei',
                                            'Juni' => 'Juni',
                                            'Juli' => 'Juli',
                                            'Agustus' => 'Agustus',
                                            'September' => 'September',
                                            'Oktober' => 'Oktober',
                                            'November' => 'November',
                                            'Desember' => 'Desember'
                                        ];

                                        foreach ($daftar_bulan as $kode_bulan => $nama_bulan) {
                                            $selected = ($kode_bulan == $bulan_sekarang) ? 'selected' : '';
                                            echo "<option value=\"$kode_bulan\" $selected>$nama_bulan</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nama_lokasi">Lokasi</label>
                                    <select class="form-control" id="nama_lokasi" name="nama_lokasi">
                                        <option selected="" hidden="">Pilih Lokasi</option>
                                        <?php
                                        include '../function/connect.php';

                                        $sql = "SELECT * FROM pme_lokasi";
                                        $result = $connection->query($sql);

                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $row['nama_lokasi']; ?>"> <?= $row['nama_lokasi']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                        </form>
                    </div>

                    <!-- Tabel Jadwal -->

                    <?php
                    // Query untuk mendapatkan data jadwal
                    $sql = "SELECT * FROM pme_jadwal";
                    $result = $connection->query($sql);

                    // Cek apakah query berhasil dijalankan
                    if ($result && $result->num_rows > 0) {
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th scope="col">No</th>';
                        echo '<th scope="col">Bulan</th>';
                        echo '<th scope="col">Lokasi</th>';
                        echo '<th scope="col">Aksi</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        // Output data dari setiap baris
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $no++ . '</td>';
                            echo '<td>' . $row['bulan'] . '</td>'; // Menampilkan nama bulan
                            echo '<td>' . $row['nama_lokasi'] . '</td>';
                            echo '<td><a href="?hapus=' . $row['id_jadwal'] . '" class="btn btn-danger btn-sm">Hapus</a></td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo 'Tidak ada data jadwal.';
                    }

                    // Handle penghapusan jadwal
                    if (isset($_GET['hapus'])) {
                        $jadwalID = $_GET['hapus'];
                        if (deleteJadwal($jadwalID)) {
                            echo "<script>alert('Jadwal berhasil dihapus');</script>";
                            echo "<script>window.location.href='set_jadwal.php';</script>"; // Redirect ke halaman set_jadwal.php setelah proses berhasil
                        } else {
                            echo "<script>alert('Gagal menghapus jadwal');</script>";
                        }
                    }

                    // Tutup koneksi
                    $connection->close();
                    ?>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
