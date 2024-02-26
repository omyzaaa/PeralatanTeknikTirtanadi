<?php
// Ambil data komponen dari database (contoh)
include '../../function/connect.php';

// Query untuk mengambil data komponen berdasarkan ID barang tertentu
$barang_id = 34; // Ganti dengan ID barang yang ingin Anda lihat komponennya
$sql = "SELECT * FROM pme_komponen WHERE BarangID = $barang_id";
$result = $connection->query($sql);

// Buat array untuk menampung data komponen
$komponen_data = array();

// Loop melalui setiap baris hasil query
while ($row = $result->fetch_assoc()) {
    // Tambahkan data komponen ke dalam array
    $komponen_data[] = array(
        'nama_komponen' => $row['nama_komponen'],
        'keterangan' => $row['keterangan']
    );
}

// Konversi data komponen menjadi format JSON
$json_data = json_encode($komponen_data, JSON_PRETTY_PRINT);

// Tampilkan isi JSON
echo $json_data;
?>
