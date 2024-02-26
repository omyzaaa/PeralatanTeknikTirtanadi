<?php

include "../function/connect.php";

//PROSES PERBAIKAN

//delete
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id_proses = $_GET['id'];

    if ($action == 'delete') {
        $deleteSql = "DELETE FROM proses_perbaikan WHERE id_proses = '$id_proses'";
        $deleteResult = mysqli_query($connection, $deleteSql);

        if ($deleteResult) {
            echo '<script>location.replace("proses_perbaikan.php");</script>';
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
            exit();
        }
    }
}

// tambah barang
if (isset($_POST['btnTambahBarang'])) {
    $nama_barang    = mysqli_real_escape_string($connection, $_POST['nama_barang']);
    $cabang         = mysqli_real_escape_string($connection, $_POST['cabang']);
    $tanggal_surat  = mysqli_real_escape_string($connection, $_POST['tanggal_surat']);
    $keterangan     = mysqli_real_escape_string($connection, $_POST['keterangan']);
    $pemeriksa      = mysqli_real_escape_string($connection, $_POST['pemeriksa']);
    $sn             = mysqli_real_escape_string($connection, $_POST['sn']); // Menambah variabel untuk SN
    $jenis          = mysqli_real_escape_string($connection, $_POST['jenis']); // Menambah variabel untuk Jenis
    $catatan        = mysqli_real_escape_string($connection, $_POST['catatan']);

    // Mengubah query untuk memasukkan data ke dalam database
    $insertSql = "INSERT INTO proses_perbaikan (nama_barang, sn, jenis, cabang, tanggal_surat, keterangan, pemeriksa,catatan) 
                  VALUES ('$nama_barang', '$sn', '$jenis', '$cabang', '$tanggal_surat', '$keterangan', '$pemeriksa','$catatan')";

    $insertResult = mysqli_query($connection, $insertSql);

    if ($insertResult) {
        echo '<script>location.replace("proses_perbaikan.php");</script>';
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
        exit();
    }
}

// Edit data
if (isset($_POST['btnEdit'])) {
    $id_proses_edit     = $_POST['id_proses'];
    $sn_edit            = mysqli_real_escape_string($connection, $_POST['sn']);
    $jenis_edit         = mysqli_real_escape_string($connection, $_POST['jenis']);
    $cabang_edit        = mysqli_real_escape_string($connection, $_POST['cabang']);
    $tanggal_surat_edit = mysqli_real_escape_string($connection, $_POST['tanggal_surat']);
    $keterangan_edit    = mysqli_real_escape_string($connection, $_POST['keterangan']);
    $pemeriksa_edit     = mysqli_real_escape_string($connection, $_POST['pemeriksa']);
    $catatan_edit       = mysqli_real_escape_string($connection, $_POST['catatan']);


    $editSql = "UPDATE proses_perbaikan SET 
                sn              = '$sn_edit',
                jenis           = '$jenis_edit',
                cabang          = '$cabang_edit', 
                tanggal_surat   = '$tanggal_surat_edit', 
                keterangan      = '$keterangan_edit', 
                pemeriksa       = '$pemeriksa_edit',
                catatan         = '$catatan_edit'
                WHERE id_proses = '$id_proses_edit'";

    $editResult = mysqli_query($connection, $editSql);

    if ($editResult) {
        echo '<script>location.replace("proses_perbaikan.php");</script>';
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
        exit();
    }
}

//pemeriksaan
if (isset($_POST['btnSimpan'])) {
    $id_proses = $_POST['id_proses'];
    $pemeriksaan_values = isset($_POST['pemeriksaan']) ? $_POST['pemeriksaan'] : array();
    $kerusakan_values = isset($_POST['kerusakan']) ? $_POST['kerusakan'] : array();
    $rekomendasi_values = isset($_POST['rekomendasi']) ? $_POST['rekomendasi'] : array();

    // Query untuk menyimpan pemeriksaan ke database
    $pemeriksaan = implode(", ", $pemeriksaan_values);
    $updatePemeriksaanSql = "UPDATE proses_perbaikan SET pemeriksaan='$pemeriksaan' WHERE id_proses=$id_proses";
    $updatePemeriksaanResult = mysqli_query($connection, $updatePemeriksaanSql);

    // Query untuk menyimpan kerusakan ke database
    $kerusakan = implode(", ", $kerusakan_values);
    $updateKerusakanSql = "UPDATE proses_perbaikan SET kerusakan='$kerusakan' WHERE id_proses=$id_proses";
    $updateKerusakanResult = mysqli_query($connection, $updateKerusakanSql);

    $rekomendasi = implode(", ", $rekomendasi_values);
    $updateRekomendasiSql = "UPDATE proses_perbaikan SET rekomendasi='$rekomendasi' WHERE id_proses=$id_proses";
    $updateRekomendasiResult = mysqli_query($connection, $updateRekomendasiSql);


}

// Fungsi untuk memindahkan data ke tabel riwayat_perbaikan
if (isset($_GET['action']) && $_GET['action'] == 'selesai' && isset($_GET['id_proses'])) {
    $id_proses = $_GET['id_proses'];

    // Ambil data proses_perbaikan berdasarkan id_proses
    $query_proses = "SELECT * FROM proses_perbaikan WHERE id_proses = $id_proses";
    $result_proses = mysqli_query($connection, $query_proses);
    $data_proses = mysqli_fetch_assoc($result_proses);

    // Masukkan data ke tabel riwayat_perbaikan
    $insert_query = "INSERT INTO riwayat_perbaikan (nama_barang,tanggal_surat, sn, cabang, jenis, catatan, pemeriksaan, kerusakan, keterangan, pemeriksa,  rekomendasi) 
                     VALUES ('{$data_proses['nama_barang']}',
                            '{$data_proses['tanggal_surat']}', 
                            '{$data_proses['sn']}',
                            '{$data_proses['cabang']}',
                            '{$data_proses['jenis']}',
                            '{$data_proses['catatan']}', 
                            '{$data_proses['pemeriksaan']}', 
                            '{$data_proses['kerusakan']}',
                            '{$data_proses['keterangan']}', 
                            '{$data_proses['pemeriksa']}', 
                            '{$data_proses['rekomendasi']}')";
    $insert_result = mysqli_query($connection, $insert_query);

    if ($insert_result) {
        // Jika data berhasil dipindahkan, hapus data dari tabel proses_perbaikan
        $delete_query = "DELETE FROM proses_perbaikan WHERE id_proses = $id_proses";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            // Redirect ke halaman proses_perbaikan.php setelah selesai
            header("Location: proses_perbaikan.php");
            exit();
        } else {
            echo "Error deleting data from proses_perbaikan table: " . mysqli_error($connection);
        }
    } else {
        echo "Error inserting data into riwayat_perbaikan table: " . mysqli_error($connection);
    }
}


