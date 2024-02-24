<?php
// Koneksi ke database dbtirtanadi
$host = "localhost";
$username = "root";
$password = "";
$database = "dbtirtanadi";

$connection = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi ke database dbtirtanadi
if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Koneksi ke database db_gudang
$host2 = "localhost";
$username2 = "root";
$password2 = "";
$database2 = "db_gudang";

$connection2 = mysqli_connect($host2, $username2, $password2, $database2);

// Periksa koneksi ke database db_gudang
if (!$connection2) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Sekarang, Anda memiliki dua koneksi aktif: $connection1 untuk dbtirtanadi dan $connection2 untuk db_gudang
?>
