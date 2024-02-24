<?php
// barang_functions.php

include 'koneksi.php';

function getBarangData() {
    global $conn;
    $sql = "SELECT * FROM barang";
    $result = $conn->query($sql);
    return $result;
}

function addBarang($kode_barang, $nama_barang, $kode_kategori) {
    global $conn;
    $sql = "INSERT INTO barang (kode_barang, nama_barang, kode_kategori) VALUES ('$kode_barang', '$nama_barang', '$kode_kategori')";
    return $conn->query($sql);
}

function getBarangDataById($BarangID) {
    global $conn;
    $sql = "SELECT * FROM barang WHERE BarangID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $barangID);

$barangID = 1; // Gantilah dengan nilai yang sesuai
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Proses data hasil query
    // ...
} else {
    echo "Tidak ada data barang.";
}

$stmt->close(); 
}

function editBarang($BarangID, $kode_barang, $nama_barang, $kode_kategori) {
    global $conn;
    $sql = "UPDATE barang SET kode_barang='$kode_barang', nama_barang='$nama_barang', kode_kategori='$kode_kategori' WHERE   BarangID=$BarangID";
    return $conn->query($sql);
}

function deleteBarang($BarangID) {
    global $conn;
    $sql = "DELETE FROM barang WHERE BarangID=$BarangID";
    return $conn->query($sql);
}
?>
