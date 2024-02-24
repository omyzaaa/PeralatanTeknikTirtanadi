<?php
    $servername = "localhost";
    $database   = "dbtirtanadi";
    $username   = "root";
    $password   = "";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    $id = $_GET['id'];
    $hapus = mysqli_query($conn,"DELETE FROM user WHERE id_user = '$id'");
    echo '<script> location.replace("user.php"); </script>';
?>