<?php
// Include file koneksi database
include "../shared/koneksi.php";

// Tangkap data dari form
$nama_barang = $_POST['nama_barang'];
$nama_kategori = $_POST['nama_kategori'];
$nama_lokasi = $_POST['nama_lokasi'];
$lokasi_cabang = $_POST['lokasi_cabang'];
$kondisi = $_POST['kondisi'];
$tanggal = $_POST['tanggal'];
$catatan = $_POST['catatan'];

// Query untuk mendapatkan kode_kategori berdasarkan nama_kategori dari tabel kategori_barang
$sql_get_kategori = "SELECT kode_kategori FROM kategori_barang WHERE nama_kategori = '$nama_kategori'";
$result_get_kategori = $conn->query($sql_get_kategori);

// Cek apakah kategori barang tersedia
if ($result_get_kategori->num_rows > 0) {
    // Ambil kode_kategori dari hasil query
    $row = $result_get_kategori->fetch_assoc();
    $kode_kategori = $row['kode_kategori'];

    // Query untuk memasukkan data barang ke dalam tabel barang
    $sql_insert_barang = "INSERT INTO barang (kode_kategori, nama_barang, nama_kategori, nama_lokasi, lokasi_cabang, kondisi, tanggal, catatan) 
                              VALUES ('$kode_kategori', '$nama_barang', '$nama_kategori', '$nama_lokasi', '$lokasi_cabang', '$kondisi', '$tanggal', '$catatan')";

    // Eksekusi query dan periksa apakah data berhasil dimasukkan
    if ($conn->query($sql_insert_barang) === TRUE) {
        //echo "Data barang berhasil dimasukkan.";
        echo "<script>alert('Barang berhasil di input');exit();</script>";
        echo "<script>window.location.href='../staff/input_barang.php';</script>";
    } else {
        //echo "Error: " . $sql_insert_barang . "<br>" . $conn->error;
        echo "<script>alert('Error:" . $sql_insert_barang . "<br>" . $conn->error . "');</script>";
    }
} else {
    echo "Kategori barang tidak tersedia.";
}

// Tutup koneksi
$conn->close();
