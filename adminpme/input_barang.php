<?php
session_start();
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
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="shared/proses_input_brg.php">
                                <div class="form px-md-4">
                                    <h5 class="card-header">Set Data Barang</h5>
                                    <div class="form-group ">
                                        <label for="nama_barang">Nama Barang:</label>
                                        <input type="text" class="form-control" name="nama_barang" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_kategori">Kategori Barang</label>
                                        <select class="form-control" id="nama_kategori" name="nama_kategori">
                                            <option selected="" hidden="">Pilih Kategori</option>
                                            <!-- Isi pilihan kategori barang dari database atau sumber data lainnya -->
                                            <?php
                                            include '../function/connect.php';

                                            $sql = "SELECT * FROM pme_kategori";
                                            $result = $connection->query($sql);

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
                                            <!-- Isi pilihan lokasi dari database atau sumber data lainnya -->
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

                                    <div class="form-group">
                                        <label for="lokasi_cabang">Lokasi Cabang</label>
                                        <select class="form-control" id="lokasi_cabang" name="lokasi_cabang">
                                            <option selected="" hidden="">Pilih Lokasi Cabang</option>
                                            <!-- Isi pilihan lokasi cabang dari database atau sumber data lainnya -->

                                            <?php
                                            include '../function/connect.php';

                                            $sql = "SELECT * FROM pme_lokasi_cabang";
                                            $result = $connection->query($sql);

                                            while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <option value="<?= $row['nama_cabang']; ?>"> <?= $row['nama_cabang']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form px-md-4">
                                    <h5 class="card-header">Set Data Komponen Barang</h5>
                                    <div id="komponenForm">
                                        <div class="form-group">
                                            <label for="nama_komponen">Nama Komponen:</label>
                                            <input type="text" class="form-control" name="nama_komponen[]" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="keterangan ">Keterangan:</label>
                                            <input type="text" class="form-control" name="keterangan[]">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="addKomponen()">Tambah Komponen</button>
                                </div>
                                <input type="hidden" id="jsonDataInput" name="jsonDataInput" value="">

                                <button type="submit" class="btn btn-primary mt-3" name="submit_barang">Simpan Data Barang</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h5>Data Komponen Barang</h5>
                            <table id="komponenTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Komponen</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="komponenTableBody">
                                    <!-- Table body will be dynamically populated with JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
        </div>
    </div>
    <script>
        function addKomponen() {
    var namaKomponenInputs = document.getElementsByName('nama_komponen[]');
    var keteranganInputs = document.getElementsByName('keterangan[]');
    var komponenArray = [];

    // Loop melalui setiap input komponen
    for (var i = 0; i < namaKomponenInputs.length; i++) {
        var namaKomponen = namaKomponenInputs[i].value;
        var keterangan = keteranganInputs[i].value;
        var komponen = { 'nama_komponen': namaKomponen, 'keterangan': keterangan };
        komponenArray.push(komponen);

        // Buat baris baru untuk setiap komponen
        var newRow = "<tr><td>" + namaKomponen + "</td><td>" + keterangan + "</td><td><button class='btn btn-danger btn-sm' onclick='deleteRow(this)'>Hapus</button></td></tr>";

        // Tambahkan baris baru ke dalam tabel
        document.getElementById('komponenTableBody').innerHTML += newRow;
    }

    // Simpan data komponen dalam format JSON ke input hidden
    document.getElementById('jsonDataInput').value = JSON.stringify(komponenArray);
}


        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>

</body>

</html>