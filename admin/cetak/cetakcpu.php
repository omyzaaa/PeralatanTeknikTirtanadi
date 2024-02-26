<?php
include "../../fpdf/fpdf.php";
include "../../function/connect.php";

$id_proses = isset($_GET['id_proses']) ? $_GET['id_proses'] : '';

//Bagian header Fungsi untuk menampilkan logo, judul,
function judul($teks1,$teks2, $pdf)
{
    $pdf->Rect(10, 15, 190, 29);

    $pdf->SetFont('Arial', 'B', '12');
    $pdf->SetXY(15, 8);
    $pdf->Cell(213, 25, $teks1, 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', '12');
    $pdf->SetXY(15, 8);
    $pdf->Cell(213, 37, $teks2, 0, 1, 'C');
}

// Fungsi untuk menampilkan logo di dokumen PDF
function logo($gambar, $pdf)
{
    $pdf->Image($gambar, 15, 17, 25, 25);
}

$pdf = new FPDF();
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 5); 
$pdf->AddPage('P', 'A4'); 

logo('../image/logotirtanadi.png', $pdf);
judul('IDENTIFIKASI KERUSAKAN','C P U ( Central Processing Unit )', $pdf);
function teksCustom($teks, $pdf, $x, $y)
{
    $pdf->SetXY($x, $y); // Atur posisi X dan Y
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $teks, 0, 1);
}

teksCustom('No Dokumen    : FM-PLT-01-02',  $pdf, 46, 30);
teksCustom('Revisi       00',               $pdf, 145, 30);
teksCustom('Tanggal Efektif : 26 September',$pdf, 46, 36);

$pdf->Line(45, 32, 200, 32); // X1, Y1, X2, Y2
$pdf->Line(45, 38, 200, 38); // X1, Y1, X2, Y2
$pdf->Line(45, 15, 45, 44);

// Fungsi untuk menampilkan informasi 
function info($pdf, $info1, $info2, $info3, $info4, $info5, $data)
{
    $pdf->Rect(10, 48, 190, 23);

    $no_agenda  = isset($data['no_agenda']) ? $data['no_agenda'] : '-';
    $sn         = isset($data['sn'])        ? $data['sn'] : 'Data tidak tersedia';
    $cabang     = isset($data['cabang'])    ? $data['cabang'] : 'Data tidak tersedia';
    $jenis      = isset($data['jenis'])     ? $data['jenis'] : 'Data tidak tersedia';
    $catatan    = isset($data['catatan'])   ? $data['catatan'] : '-';

    $pdf->SetFont('Arial', 'B', '12');
    $pdf->SetXY(12, 52);
    $pdf->Cell(0, 0, $info1 . $no_agenda, 0, 1);

    $pdf->SetFont('Arial', 'B', '12');
    $pdf->SetXY(12, 57);
    $pdf->Cell(0, 0, $info2 . $sn, 0, 1);

    $pdf->SetFont('Arial', 'B', '12');
    $pdf->SetXY(12, 62);
    $pdf->Cell(0, 0, $info3 . $cabang, 0, 1);

    $pdf->SetFont('Arial', 'B', '12');
    $pdf->SetXY(12, 67);
    $pdf->Cell(0, 0, $info4 . $jenis, 0, 1);

    $pdf->SetFont('Arial', '', '12');
    $pdf->SetXY(12, 188);
    $pdf->Cell(0, 0, $info5 . $catatan, 0, 1);
}

$pdf->Rect(10, 75, 190, 190);
$pdf->Line(10, 81, 200, 81); // X1, Y1, X2, Y2
$pdf->Line(10, 135, 200, 135); // X1, Y1, X2, Y2
$pdf->Line(10, 141, 200, 141); // X1, Y1, X2, Y2
$pdf->Line(10, 184, 200, 184); // X1, Y1, X2, Y2
$pdf->Line(10, 218, 200, 218); // X1, Y1, X2, Y2
$pdf->Line(60, 218, 60, 265);
$pdf->Line(150, 218, 150, 265);
// Tangkap data dari database berdasarkan id_proses
$query = "SELECT * FROM proses_perbaikan WHERE id_proses = '$id_proses'";
$result = mysqli_query($connection, $query);

// Periksa apakah kueri berhasil dieksekusi
if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    info(
        $pdf,
        'No agenda                    : ',
        'SN                                 : ',
        'Unit kerja/Cabang        : ',
        'Jenis                             : ',
        'Catatan : ',
        $data
    );

    // Gunakan data pemeriksaan dari database
    $pemeriksaan_values = explode(", ", $data['pemeriksaan']);
    $kerusakan_values = explode(", ", $data['kerusakan']);

    // Lakukan query untuk mengambil data pemeriksaan dari tabel pem_cpu    
    $query_pemeriksaan = "SELECT pemeriksaan FROM pem_cpu";
    $result_pemeriksaan = mysqli_query($connection, $query_pemeriksaan);

    // Periksa apakah kueri berhasil dieksekusi
    if ($result_pemeriksaan && mysqli_num_rows($result_pemeriksaan) > 0) {
        // Tentukan posisi awal untuk kolom kanan dan kiri
    $posX_left = 15;
    $posY_left = 86;
    $posX_right = 110;
    $posY_right = 86;

        // Tampilkan opsi pemeriksaan dalam bentuk checkbox
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(0, 73); 
        $pdf->MultiCell(0, 10, 'PEMERIKSAAN AWAL(Trouble Shooting)', 0, 'C'); 

        $counter = 0;
        while ($rowPemeriksaan = mysqli_fetch_assoc($result_pemeriksaan)) {
            $pemeriksaan_option = $rowPemeriksaan['pemeriksaan'];
            // Periksa apakah harus pindah ke kolom kanan
        if ($counter >= 8) {
            $posX = $posX_right;
            $posY = $posY_right;
            $posY_right += 6; // Geser ke bawah untuk baris berikutnya di kolom kanan
        } else {
            $posX = $posX_left;
            $posY = $posY_left;
            $posY_left += 6; // Geser ke bawah untuk baris berikutnya di kolom kiri
        }
            $pdf->SetXY($posX,$posY);
            // Periksa apakah pemeriksaan_option ada di dalam array pemeriksaan_values
            if (in_array($pemeriksaan_option, $pemeriksaan_values)) {
                // Jika ya, tandai cekbox dengan karakter X
                $pdf->Cell(4, 4, 'V', 1, 0, 'C');
            } else {
                // Jika tidak, biarkan cekbox kosong
                $pdf->Cell(4, 4, '', 1, 0, 'C');
            }

            // Tambahkan teks label
        $pdf->SetXY($posX + 5, $posY + -1);
        $pdf->Cell(0, 6, $pemeriksaan_option, 0, 1);
        $counter++; // Tambahkan hitungan baris

        }
    } else {
        die("Error fetching pemeriksaan: " . mysqli_error($connection));
    }
} else {
    die("Error fetching data: " . mysqli_error($connection));
}



// Lakukan query untuk mengambil data kerusakan dari tabel ker_monitor
$query_kerusakan = "SELECT kerusakan FROM ker_cpu";
$result_kerusakan = mysqli_query($connection, $query_kerusakan);

// Periksa apakah kueri berhasil dieksekusi
if ($result_kerusakan && mysqli_num_rows($result_kerusakan) > 0) {

    $posX_left = 15;
    $posY_left = 146;
    $posX_right = 110;
    $posY_right = 146;

    $pdf->SetFont('Arial', '', 12); // Atur font
    $pdf->SetXY(0, 131);; // Geser ke bawah sejauh 10 unit dari posisi terakhir
    $pdf->MultiCell(0, 15, 'IDENTIFIKASI KERUSAKAN', 0, 'C'); // Tambahkan teks

    $counter= 0;
    while ($rowKerusakan = mysqli_fetch_assoc($result_kerusakan)) {
        $kerusakan_option = $rowKerusakan['kerusakan'];
        $pdf->SetX(18);
        if ($counter >= 6) {
            $posX = $posX_right;
            $posY = $posY_right;
            $posY_right += 6; // Geser ke bawah untuk baris berikutnya di kolom kanan
        } else {
            $posX = $posX_left;
            $posY = $posY_left;
            $posY_left += 6; // Geser ke bawah untuk baris berikutnya di kolom kiri
        }
            $pdf->SetXY($posX,$posY);
            // Periksa apakah pemeriksaan_option ada di dalam array pemeriksaan_values
           
        // Buat kotak cekbox
        if (in_array($kerusakan_option, $kerusakan_values)) {
            // Jika ya, tandai cekbox dengan karakter X
            $pdf->Cell(4, 4, 'Y', 1, 0, 'C');
        } else {
            // Jika tidak, biarkan cekbox kosong
            $pdf->Cell(4, 4, '', 1, 0, 'C');
        }

        // Tentukan posisi untuk teks label cekbox
        $pdf->SetXY($posX + 5, $posY + -1);
        $pdf->Cell(0, 6, $kerusakan_option, 0, 1);
        $counter++; // Tambahkan hitungan baris

    }
} else {
    die("Error fetching kerusakan: " . mysqli_error($connection));
}




// Tangkap data rekomendasi dari database berdasarkan id_proses
$query_proses_perbaikan = "SELECT rekomendasi FROM proses_perbaikan WHERE id_proses = $id_proses";
$result_proses_perbaikan = mysqli_query($connection, $query_proses_perbaikan);
$row_proses_perbaikan = mysqli_fetch_assoc($result_proses_perbaikan);

// Pisahkan nilai rekomendasi menjadi array
$rekomendasi_values = explode(", ", $row_proses_perbaikan['rekomendasi']);

// Lakukan query untuk mengambil data rekomendasi dari tabel rekomendasi_ker
$query_rekomendasi = "SELECT rekomendasi FROM rekomendasi_ker";
$result_rekomendasi = mysqli_query($connection, $query_rekomendasi);

// Periksa apakah kueri berhasil dieksekusi
if ($result_rekomendasi && mysqli_num_rows($result_rekomendasi) > 0) {
    // Tampilkan opsi rekomendasi dalam bentuk checkbox
    $pdf->SetFont('Arial', '', 12); // Atur font
    $pdf->SetXY(72, 220); // Geser ke bawah sejauh 10 unit dari posisi terakhir
    $pdf->MultiCell(0, 6, 'Rekomendasi terhadap kerusakan', 0, 'L'); // Tambahkan teks

    while ($rowRekomendasi = mysqli_fetch_assoc($result_rekomendasi)) {
        $rekomendasi_option = $rowRekomendasi['rekomendasi'];
        $pdf->SetX(75);
        
        // Buat kotak cekbox
        if (in_array($rekomendasi_option, $rekomendasi_values)) {
            // Jika ya, tandai cekbox dengan karakter Y
            $pdf->Cell(4, 4, 'X', 1, 0, 'C');
        } else {
            // Jika tidak, biarkan cekbox kosong
            $pdf->Cell(4, 4, '', 1, 0, 'C');
        }

        // Tentukan posisi untuk teks label cekbox
        $pdf->SetXY($pdf->GetX() + 2, $pdf->GetY()+ -1);
        $pdf->Cell(0, 7, $rekomendasi_option, 0, 1);

    }

    $pdf->SetFont('Arial', '', '12');
    $pdf->SetXY(18, 220);
    $pdf->Cell(0, 7, 'Petugas Pemeriksa', 0, 1);

    // Teks "Disposisi KABID PKAK"
    $pdf->SetFont('Arial', '', '12');
    $pdf->SetXY(151, 220);
    $pdf->Cell(0, 7, 'Disposisi KABID PK&AK', 0, 1);
} else {
    die("Error fetching rekomendasi: " . mysqli_error($connection));
}

$pdf->Output();

?>
