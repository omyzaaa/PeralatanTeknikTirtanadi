<?php
// Include file koneksi database
include "koneksi.php";

// Tangkap data dari form
$bulan = $_POST['bulan'];
$nama_lokasi = $_POST['nama_lokasi'];

// Query untuk memasukkan data jadwal ke dalam tabel jadwal
$sql_insert_jadwal = "INSERT INTO jadwal (bulan, nama_lokasi) VALUES ('$bulan', '$nama_lokasi')";

// Eksekusi query dan periksa apakah data berhasil dimasukkan
if ($conn->query($sql_insert_jadwal) === TRUE) {
    echo "<script>alert('Jadwal berhasil ditambahkan');</script>";
    echo "<script>window.location.href='nama_halaman.php';</script>"; // Ganti 'nama_halaman.php' dengan halaman yang ingin Anda arahkan setelah proses berhasil
} else {
    echo "<script>alert('Error: " . $sql_insert_jadwal . "\\n" . $conn->error . "');</script>";
    echo "<script>window.history.back();</script>"; // Kembali ke halaman sebelumnya jika terjadi kesalahan
}

// Tutup koneksi
$conn->close();
?>
