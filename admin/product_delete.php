<?php

    $servername = "localhost";
    $database   = "db_vapestore";
    $username   = "root";
    $password   = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    $id = $_GET['id'];
    $hapus = mysqli_query($conn,"DELETE FROM produk WHERE p_id = '$id'");
    echo '<script> location.replace("produk.php"); </script>';
?>