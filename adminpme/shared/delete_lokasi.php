<?php
// Include file koneksi database
include 'koneksi.php';

// Fungsi untuk menghapus lokasi berdasarkan nomor
function deleteLokasi($lokasiID)
{
    global $conn;

    $sql = "DELETE FROM lokasi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lokasiID);

    return $stmt->execute();
}

// Periksa apakah parameter no telah diterima
if (isset($_GET['id'])) {
    $lokasiIDToDelete = $_GET['id'];

    // Hapus lokasi
    if (deleteLokasi($lokasiIDToDelete)) {
        echo "Data lokasi berhasil dihapus.";
    } else {
        echo "Gagal menghapus data lokasi.";
    }
} else {
    echo "Nomor lokasi tidak valid.";
}

// Tutup koneksi
//$conn->close();
?>
