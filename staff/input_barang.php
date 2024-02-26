
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

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Include Sidebar -->
            <?php include '../asset/sidebar.php' ?>
            <div class="col-md-6">
                <form method="POST" action="../shared/proses_input_brg.php">
                    Set Data barang
                    <div class="form px-md-4">
                        <div class="form-group ">
                            <label for="nama_barang">Nama Barang:</label>
                            <input type="text" class="form-control" name="nama_barang" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_kategori">Kategori Barang</label>
                            <select class="form-control" id="nama_kategori" name="nama_kategori">
                                <option selected="" hidden="">Pilih Kategori</option>
                                <?php
                                include "../shared/koneksi.php";

                                $sql = "SELECT * FROM kategori_barang";
                                $result = $conn->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <option value="<?= $row['nama_kategori']; ?>"> <?= $row['nama_kategori']; ?></option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nama_lokasi">Lokasi</label>
                            <select class="form-control" id="nama_lokasi" name="nama_lokasi">
                                <option selected="" hidden="">Pilih Lokasi</option>
                                <?php
                                include "../shared/koneksi.php";

                                $sql = "SELECT * FROM lokasi";
                                $result = $conn->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <option value="<?= $row['nama_lokasi']; ?>"> <?= $row['nama_lokasi']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="lokasi_cabang">Lokasi Cabang</label>
                            <select class="form-control" id="lokasi_cabang" name="lokasi_cabang">
                                <option selected="" hidden="">Pilih Lokasi Cabang</option>
                                <?php
                                include "../shared/koneksi.php";

                                $sql = "SELECT * FROM lokasi_cabang";
                                $result = $conn->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <option value="<?= $row['nama_cabang']; ?>"> <?= $row['nama_cabang']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <label for="kondisi">Kondisi:</label><br>
                        <select class="form-control" id="kondisi" name="kondisi">
                            <option selected disabled>-- kondisi barang --</option>
                            <!-- -->
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>

                        <label for="tanggal">Tanggal:</label><br>
                        <input type="date" id="tanggal" name="tanggal"><br>

                        <label for="catatan">Catatan:</label><br>
                        <textarea id="catatan" name="catatan"></textarea><br>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Data Barang</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>