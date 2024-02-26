<?php
include '../../function/connect.php';

// Function untuk menambah kategori
function tambahKategori($namaKategori)
{
    global $connection;
    $sql = "INSERT INTO pme_kategori (nama_kategori) VALUES ('$namaKategori')";
    return $connection->query($sql);
}

function editKategori($id_kategori, $namaKategori)
{
    global $connection;
    $sql = "UPDATE pme_kategori SET nama_kategori='$namaKategori' WHERE id_kategori='$id_kategori'";
    return $connection->query($sql);
}

// Function untuk menghapus Barang

// Handle tambah kategori
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nama_kategori'])) {
        $namaKategori = $_POST['nama_kategori'];
        if (isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['id_kategori'])) {
            $id_kategori = $_POST['id_kategori'];
            if (editKategori($id_kategori, $namaKategori)) {
                echo "<script>alert('Kategori berhasil diubah');window.location.href='../set_kategori.php';</script>";
            } else {
                echo "<script>alert('Gagal mengubah kategori');</script>";
            }
        } else {
            if (tambahKategori($namaKategori)) {
                echo "<script>alert('Kategori berhasil ditambahkan');window.location.href='../set_kategori.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan kategori');</script>";
            }
        }
    }
}

