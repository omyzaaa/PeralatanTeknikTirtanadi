<?php
session_start();
// Include file koneksi database
include '../../function/connect.php';

// Tangkap data dari form untuk barang
$nama_barang = $_POST['nama_barang'];
$nama_kategori = $_POST['nama_kategori'];
$nama_lokasi = $_POST['nama_lokasi'];
$lokasi_cabang = $_POST['lokasi_cabang'];

// Query untuk memasukkan data barang ke dalam tabel barang
$sql_insert_barang = "INSERT INTO pme_barang (nama_barang, nama_kategori, nama_lokasi, lokasi_cabang) 
                      VALUES ('$nama_barang', '$nama_kategori', '$nama_lokasi', '$lokasi_cabang')";

// Eksekusi query untuk memasukkan data barang
if ($connection->query($sql_insert_barang) === TRUE) {
    // Jika data barang berhasil dimasukkan, ambil ID barang terbaru
    $last_insert_id = $connection->insert_id;

    // Tangkap data JSON dari form untuk komponen
    $json_data = $_POST['jsonDataInput'];

    // Decode JSON data menjadi array PHP
    $data_komponen = json_decode($json_data, true);

    // Loop through each komponen and insert into database
    foreach ($data_komponen as $komponen) {
        $nama_komponen = $komponen['nama_komponen'];
        $keterangan = $komponen['keterangan'];

        // Query untuk memasukkan data komponen ke dalam tabel komponen
        $sql_insert_komponen = "INSERT INTO pme_komponen (BarangID, nama_komponen, keterangan) 
                                VALUES ('$last_insert_id', '$nama_komponen', '$keterangan')";

        // Eksekusi query untuk memasukkan data komponen
        if ($connection->query($sql_insert_komponen) !== TRUE) {
            echo "<script>alert('Error: " . $sql_insert_komponen . "<br>" . $connection->error . "');</script>";
            exit; // Keluar dari skrip jika terjadi kesalahan
        }
    }

    // Jika berhasil, redirect ke halaman input_barang.php
    echo "<script>alert('Data barang dan komponen berhasil diinput'); window.location.href='../input_barang.php';</script>";
} else {
    // Jika ada kesalahan saat memasukkan data barang, tampilkan pesan error
    echo "<script>alert('Error: " . $sql_insert_barang . "<br>" . $connection->error . "');</script>";
}

// Tutup koneksi
$connection->close();
?>
