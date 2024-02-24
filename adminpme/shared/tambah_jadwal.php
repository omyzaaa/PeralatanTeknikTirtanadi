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