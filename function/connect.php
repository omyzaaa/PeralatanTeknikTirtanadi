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


?>
