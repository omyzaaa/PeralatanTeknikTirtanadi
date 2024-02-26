<?php
// Menyertakan file fpdf, file fpdf.php di dalam folder FPDF yang diekstrak
include "../fpdf/fpdf.php";
include "koneksi.php";

// Kelas turunan dari FPDF untuk membuat halaman PDF
class PDF extends FPDF
{
    // Fungsi untuk mengatur header
    function Header()
    {
        // Logo
        $this->Image('../image/pdam.png', 10, 8, 33);

        $this->SetLineWidth(0.3); // Ketebalan garis
        $this->Line(43, 8, 43, 41); // Garis vertikal dari (53,8) ke (53,41)

        // Judul di samping logo
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(120); // Spasi horizontal
        $this->Cell(70, 10, 'Judul Di Samping Logo', 0, 1, 'C');

        // Kotak di atas tabel
        $this->SetDrawColor(0); // Warna garis tepi
        $this->Rect(10, 8, 190, 33); // Kotak tanpa warna latar
        $this->Ln(45); // Spasi vertikal

    }

    // Fungsi untuk mengatur footer
    function Footer()
    {
        // Teks di bagian bawah halaman
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'db_gudang');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel jadwal
$sql = "SELECT bulan, nama_lokasi, aktif FROM jadwal";
$result = $conn->query($sql);
$no = 1;

// Instansiasi objek PDF
$pdf = new PDF();
$pdf->AliasNbPages(); // Mengatur jumlah halaman
$pdf->AddPage(); // Menambahkan halaman baru

// Menampilkan header tabel jadwal
$pdf->SetFont('Arial', '', 6); // Mengatur font menjadi lebih kecil
$pdf->Cell(10, 10, 'No', 1, 0, 'C'); // Bagian No
$pdf->Cell(40, 10, 'Lokasi', 1, 0, 'L'); // Bagian Lokasi
for ($i = 1; $i <= 12; $i++) {
   // Mengonversi nomor bulan menjadi nama bulan
   $nama_bulan = date("M", mktime(0, 0, 0, $i, 1));
   $pdf->Cell(10, 10, $nama_bulan, 1, 0, 'C'); // Bagian Bulan
}
$pdf->Cell(40, 10, 'Keterangan', 1, 1, 'C'); // Bagian Keterangan

// Menampilkan data dari hasil query
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(40, 10, $row['nama_lokasi'], 1, 0, 'L');
        
        // Tentukan apakah bulan ini "checked" berdasarkan nilai 'aktif'
        $bulan_checked = [];
        if ($row['aktif'] == 1) {
            $bulan_checked[$row['bulan']] = '\xE2\x9C\x93';
        }
        
        // Gambar sel dengan simbol centang atau kosong
        for ($i = 1; $i <= 12; $i++) {
            $pdf->Cell(10, 10, isset($bulan_checked[$i]) ? $bulan_checked[$i] : "", 1, 0, 'C'); // Ini hanya contoh, Anda perlu menyesuaikan sesuai dengan data yang sebenarnya
        }
        
        // Selanjutnya untuk kolom keterangan
        $pdf->Cell(40, 10, '', 1, 1, 'C'); // Ini juga hanya contoh, Anda perlu menyesuaikan sesuai dengan data yang sebenarnya
    }
} else {
    $pdf->Cell(190, 10, 'Tidak ada data', 1, 1, 'C');
}

// Tutup koneksi
$conn->close();

$pdf->Output(); // Menampilkan output PDF
?>
