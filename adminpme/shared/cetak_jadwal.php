<?php
//menyertakan file fpdf, file fpdf.php di dalam folder FPDF yang diekstrak
include "../fpdf/fpdf.php";
include "koneksi.php";

// Kelas turunan dari FPDF untuk membuat halaman PDF
class PDF extends FPDF
{
    // Fungsi untuk mengatur header
    function Header()
    {
        // Logo
        $this->Image('../image/avatar01.png', 10, 6, 30);
        // Teks judul
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Tabel Jadwal', 0, 1, 'C');
        // Garis bawah
        $this->Line(10, 30, 200, 30);
        // Spasi vertikal
        $this->Ln(10);
    }

    // Fungsi untuk mengatur footer
    function Footer()
    {
        // Teks di tengah footer
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Instansiasi objek PDF
$pdf = new PDF();
$pdf->AliasNbPages(); // Mengatur jumlah halaman
$pdf->AddPage(); // Menambahkan halaman baru

// Menampilkan tabel jadwal
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'ID', 1, 0, 'C');
$pdf->Cell(80, 10, 'Bulan', 1, 0, 'C');
$pdf->Cell(70, 10, 'Nama Lokasi', 1, 1, 'C');

// Menampilkan data tabel jadwal (contoh data)
$data = array(
    array(1, 'Januari', 'Lokasi A'),
    array(2, 'Februari', 'Lokasi B'),
    array(3, 'Maret', 'Lokasi C')
);

foreach ($data as $row) {
    $pdf->Cell(40, 10, $row[0], 1, 0, 'C');
    $pdf->Cell(80, 10, $row[1], 1, 0, 'C');
    $pdf->Cell(70, 10, $row[2], 1, 1, 'C');
}

$pdf->Output(); // Menampilkan output PDF

?>