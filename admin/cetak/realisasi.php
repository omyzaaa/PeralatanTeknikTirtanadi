<?php
session_start();

include "../../fpdf/fpdf.php";
include "../../function/connect.php";

// Mengambil nilai dari form input
$nama_barang = isset($_POST['nama_barang']) ? $_POST['nama_barang'] : '';
$sn = isset($_POST['sn']) ? $_POST['sn'] : '';
$pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';
$hasil = isset($_POST['hasil']) ? $_POST['hasil'] : '';
$usul = isset($_POST['usul']) ? $_POST['usul'] : '';
$pkak = isset($_POST['pkak']) ? $_POST['pkak'] : ''; // Jika checkbox pkak dicentang, nilai akan menjadi 'Y', jika tidak, akan kosong
$pme = isset($_POST['pme']) ? $_POST['pme'] : ''; // Jika checkbox pme dicentang, nilai akan menjadi 'Y', jika tidak, akan kosong

// Menyimpan nilai ke dalam session jika diperlukan
$_SESSION['nama_barang'] = $nama_barang;
$_SESSION['sn'] = $sn;

// Fungsi untuk membuat judul dokumen PDF
function judul($teks1, $pdf)
{
    $pdf->Rect(0, 0, 210, 35);
    $pdf->SetFont('Times', 'B', '20');
    $pdf->SetXY(15, 8);
    $pdf->Cell(213, 8, $teks1, 0, 1, 'C');
}

// Fungsi untuk menampilkan logo di dokumen PDF
function logo($gambar, $pdf)
{
    $pdf->Image($gambar, 3, 3, 30, 30);
}

$pdf = new FPDF();
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 5); 
$pdf->AddPage('P', 'A4'); 

logo('../image/logotirtanadi.png', $pdf);
judul('REALISASI PEKERJAAN', $pdf);

// Fungsi untuk menampilkan teks dengan posisi bebas
function teksCustom($teks, $pdf, $x, $y)
{
    $pdf->SetXY($x, $y); // Atur posisi X dan Y
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $teks, 0, 1);
}

// Fungsi untuk menampilkan checkbox dengan posisi bebas
function checkboxCustom($pdf, $x, $y, $isChecked)
{
    $pdf->SetXY($x, $y); // Atur posisi X dan Y
    if ($isChecked == 'Y') {
        $pdf->Cell(5, 5, 'V', 'LTRB', 0, 'C'); // Checkbox tercentang
    } else {
        $pdf->Cell(5, 5, '', 'LTRB', 0, 'C'); // Checkbox tidak tercentang
    }
}

// Pemanggilan fungsi untuk menampilkan teks dan checkbox pada dokumen PDF
teksCustom('No Dokumen    : FM-PLT-01-02', $pdf, 37, 20);
teksCustom('Revisi       00', $pdf, 137, 20);
teksCustom('Tanggal Efektif : 26 September', $pdf, 37, 27);

teksCustom('DASAR DIKERJAKAN', $pdf, 7, 52);
teksCustom('No. Agenda:', $pdf, 152, 52);

teksCustom('URAIAN PEKERJAAN', $pdf, 85, 70);

teksCustom('KERUSAKAN', $pdf, 15, 87);
teksCustom('Nama Barang: ' . $nama_barang, $pdf, 65, 79);
teksCustom('Serial Number: ' . $sn, $pdf, 65, 87);
teksCustom('PKAK: ', $pdf, 65, 95);
checkboxCustom($pdf, 80, 97, $pkak); // Checkbox untuk PKAK
teksCustom('PME: ', $pdf, 115, 95);
checkboxCustom($pdf, 130, 97, $pme); // Checkbox untuk PME

teksCustom('PEKERJAAN                  ' . $pekerjaan, $pdf, 19, 112);
teksCustom('HASIL                         ' . $hasil, $pdf, 24, 147);
teksCustom('USUL                          ' . $usul, $pdf, 24, 190);
teksCustom('Pelaksana Pekerjaan:', $pdf, 15, 220);
teksCustom('Diperiksa Oleh:', $pdf, 87, 220);
teksCustom('Unit Kerja:', $pdf, 160, 220);
teksCustom('Kabid:', $pdf, 80, 270);

// Membuat area dengan batas (border)
$pdf->Rect(0, 0, 36, 35);   // X, Y, Width, Height
$pdf->Line(36, 21, 220, 21); // X1, Y1, X2, Y2
$pdf->Line(36, 28, 220, 28); // X1, Y1, X2, Y2

$pdf->Rect(0, 44, 210, 240);
$pdf->Line(60, 44, 60, 70); 
$pdf->Line(60, 215, 60, 79); 

$pdf->Line(0, 105, 210, 105); // X1, Y1, X2, Y2
$pdf->Line(0, 130, 210, 130); //-----
$pdf->Line(0, 175, 210, 175);
$pdf->Line(0, 215, 210, 215);
$pdf->Line(8, 270, 60, 270);
$pdf->Line(135, 270, 75, 270);
$pdf->Line(200, 270, 150, 270);

$pdf->Line(150, 44, 150, 70); // X1, Y1, X2, Y2
$pdf->Line(0, 70, 210, 70); // X1, Y1, X2, Y2
$pdf->Line(0, 79, 210, 79); // X1, Y1, X2, Y2
$pdf->Output();
?>
