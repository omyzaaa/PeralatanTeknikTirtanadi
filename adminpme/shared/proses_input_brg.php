<?php
// Include file koneksi database
include '../../function/connect.php';

// Tangkap data dari form
$nama_barang = $_POST['nama_barang'];
$nama_kategori = $_POST['nama_kategori'];
$nama_lokasi = $_POST['nama_lokasi'];
$lokasi_cabang = $_POST['lokasi_cabang'];

// Query untuk memasukkan data barang ke dalam tabel barang
$sql_insert_barang = "INSERT INTO pme_barang (nama_barang, nama_kategori, nama_lokasi, lokasi_cabang) 
                              VALUES ('$nama_barang', '$nama_kategori', '$nama_lokasi', '$lokasi_cabang')";

// Eksekusi query dan periksa apakah data barang berhasil dimasukkan
if ($connection->query($sql_insert_barang) === TRUE) {
    // Jika data barang berhasil dimasukkan, ambil ID barang terbaru
    $last_insert_id = $connection->insert_id;

    // Tangkap data komponen dari form
    $nama_komponen = $_POST['nama_komponen'];
    $keterangan_komponen = $_POST['keterangan_komponen'];


// Loop through each komponen and insert into database
for ($i = 0; $i < $jumlah_komponen; $i++) {
    $nama_komponen_value = $nama_komponen[$i];
    $keterangan_komponen_value = $keterangan_komponen[$i];

    // Query untuk memasukkan data komponen ke dalam tabel komponen
    $sql_insert_komponen = "INSERT INTO pme_komponen (nama_komponen, keterangan, BarangID) 
                                    VALUES ('$nama_komponen_value', '$keterangan_komponen_value', '$last_insert_id')";
    
    // Eksekusi query untuk memasukkan data komponen
    $connection->query($sql_insert_komponen);
    }

    // Redirect to success page or display success message
    echo "<script>alert('Data barang dan komponen berhasil diinput'); window.location.href='../input_barang.php';</script>";
} else {
    // Jika ada kesalahan saat memasukkan data barang, tampilkan pesan error
    echo "<script>alert('Error: " . $sql_insert_barang . "<br>" . $connection->error . "');</script>";
}

// Tutup koneksi
$connection->close();
?>
