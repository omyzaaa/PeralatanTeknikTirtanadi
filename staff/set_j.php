<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Lokasi dan Bulan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Tabel Lokasi dan Bulan</h2>
    <form action="set_jadwal.php" method="POST">
    <label for="lokasi_input">Pilih Lokasi:</label><br>
    <select id="lokasi_input" name="lokasi_input">
        <?php
        // Include file koneksi database
        include "../shared/koneksi.php";

        // Query untuk mendapatkan lokasi-lokasi unik dari kolom 'lokasi' dalam tabel 'barang'
        $sql = "SELECT DISTINCT lokasi FROM barang";
        $result = $conn->query($sql);

        // Jika query berhasil dan ada hasil
        if ($result && $result->num_rows > 0) {
            // Output setiap lokasi sebagai opsi dalam dropdown menu
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['lokasi'] . '">' . $row['lokasi'] . '</option>';
            }
        } else {
            echo '<option value="">Tidak ada lokasi tersedia</option>';
        }

        // Tutup koneksi
        $conn->close();
        ?>
    </select><br>
    <input type="submit" value="Cari">
</form>
    <?php
    // Include file koneksi database
    include "../shared/koneksi.php";

    // Tangkap data lokasi dari form
    $lokasi_input = $_POST['lokasi_input'];

    // Query untuk mendapatkan lokasi dan bulan dari tanggal dalam tabel barang berdasarkan lokasi yang diinputkan
    $sql = "SELECT 

                DATE_FORMAT(tanggal, '%M') AS bulan 
            FROM 
                barang
            WHERE 
                lokasi = '$lokasi_input'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output tabel
        echo '<table>';
        echo '<tr><th>Lokasi</th><th>Bulan</th></tr>';
        // Output data dari setiap baris
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['lokasi'] . '</td>';
            echo '<td>' . $row['bulan'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "Tidak ada data untuk lokasi tersebut.";
    }

    // Tutup koneksi
    $conn->close();
    ?>
</body>

</html>