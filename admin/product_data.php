<?php
    $servername = "localhost";
    $database   = "db_vapestore";
    $username   = "root";
    $password   = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    $produk = mysqli_query($conn, "SELECT * FROM produk WHERE p_id = '$id'");
        while ($row2 = mysqli_fetch_array($produk)){
            $edit_id = $row2['p_id'];
            $edit_nama = $row2['nama'];
        }
?>