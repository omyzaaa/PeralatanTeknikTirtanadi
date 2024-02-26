<?php
include '../../function/connect.php';

// Function untuk menambah lokasi
function tambahlokasi($namalokasi)
{
    global $connection;
    $sql = "INSERT INTO pme_lokasi (nama_lokasi) VALUES ('$namalokasi')";
    return $connection->query($sql);
}

function editlokasi($id_lokasi, $namalokasi)
{
    global $connection;
    $sql = "UPDATE pme_lokasi SET nama_lokasi='$namalokasi' WHERE id_lokasi='$id_lokasi'";
    return $connection->query($sql);
}



// Handle tambah lokasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nama_lokasi'])) {
        $namalokasi = $_POST['nama_lokasi'];
        if (isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['id_lokasi'])) {
            $id_lokasi = $_POST['id_lokasi'];
            if (editlokasi($id_lokasi, $namalokasi)) {
                echo "<script>alert('lokasi berhasil diubah');window.location.href='../set_lokasi.php';</script>";
            } else {
                echo "<script>alert('Gagal mengubah lokasi');</script>";
            }
        } else {
            if (tambahlokasi($namalokasi)) {
                echo "<script>alert('lokasi berhasil ditambahkan');window.location.href='../set_lokasi.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan lokasi');</script>";
            }
        }
    }
}

