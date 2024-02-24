<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Barang</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <!-- Navbar -->
    <?php include '../aset/navbar.php'; ?>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                     Set Data barang
                     <div class="form px-md-4">
                        <div class="form-group ">
                            <label for="nama_barang">Nama Barang:</label>
                            <input type="text" class="form-control" name="nama_barang" required>
                        </div>

                        <div class="form-group">
                            <label for="harga_barang">Kategori Barang:</label>
                            <input type="text" class="form-control" name="harga_barang" required>
                        </div>

                        <div class="form-group">
                            <label for="stok_barang">Lokasi</label>
                            <input type="text" class="form-control" name="stok_barang" required>
                        </div>
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