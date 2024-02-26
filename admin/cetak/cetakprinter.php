<?php
include "../../fpdf/fpdf.php";
include "../../function/connect.php";

$id_proses = isset($_GET['id_proses']) ? $_GET['id_proses'] : '';

//Bagian header Fungsi untuk menampilkan logo, judul,
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
judul('IDENTIFIKASI KERUSAKAN PRINTER', $pdf);
function teksCustom($teks, $pdf, $x, $y)
{
    $pdf->SetXY($x, $y); // Atur posisi X dan Y
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $teks, 0, 1);
}

teksCustom('No Dokumen    : FM-PLT-01-02', $pdf, 37, 20);
teksCustom('Revisi       00', $pdf, 137, 20);
teksCustom('Tanggal Efektif : 26 September', $pdf, 37, 27);

$pdf->Rect(0, 0, 36, 35);   // X, Y, Width, Height
$pdf->Line(36, 21, 220, 21); // X1, Y1, X2, Y2
$pdf->Line(36, 28, 220, 28); // X1, Y1, X2, Y2

// Fungsi untuk menampilkan informasi 
function info($pdf, $info1, $info2, $info3, $info4, $info5, $data)
{
    $pdf->Rect(0, 38, 210, 25);

    $no_agenda  = isset($data['no_agenda']) ? $data['no_agenda'] : 'Data tidak tersedia';
    $sn         = isset($data['sn'])        ? $data['sn'] : 'Data tidak tersedia';
    $cabang     = isset($data['cabang'])    ? $data['cabang'] : 'Data tidak tersedia';
    $jenis      = isset($data['jenis'])     ? $data['jenis'] : 'Data tidak tersedia';
    $catatan    = isset($data['catatan'])   ? $data['catatan'] : '-';

    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(2, 37);
    $pdf->Cell(12, 10, $info1 . $no_agenda, 0, 1);

    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(2, 42);
    $pdf->Cell(12, 10, $info2 . $sn, 0, 1);

    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(2, 47);
    $pdf->Cell(12, 10, $info3 . $cabang, 0, 1);

    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(2, 52);
    $pdf->Cell(12, 10, $info4 . $jenis, 0, 1);

    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(2, 208);
    $pdf->Cell(12, 10, $info5 . $catatan, 0, 1);
}

$pdf->Rect(0, 66, 210, 210);
$pdf->Line(0, 73, 220, 73); // X1, Y1, X2, Y2
$pdf->Line(0, 120, 220, 120); // X1, Y1, X2, Y2
$pdf->Line(0, 128, 220, 128); // X1, Y1, X2, Y2
$pdf->Line(0, 210, 220, 210); // X1, Y1, X2, Y2
$pdf->Line(0, 235, 220, 235); // X1, Y1, X2, Y2
$pdf->Line(60, 235, 60, 276);
$pdf->Line(150, 235, 150, 276);
// Tangkap data dari database berdasarkan id_proses
$query = "SELECT * FROM proses_perbaikan WHERE id_proses = '$id_proses'";
$result = mysqli_query($connection, $query);

// Periksa apakah kueri berhasil dieksekusi
if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    info(
        $pdf,
        'No agenda                    : ',
        'SN                                : ',
        'Unit kerja / Cabang      : ',
        'Jenis                             : ',
        'Catatan : ',
        $data
    );

    // Gunakan data pemeriksaan dari database
    $pemeriksaan_values = explode(", ", $data['pemeriksaan']);
    $kerusakan_values = explode(", ", $data['kerusakan']);

    // Lakukan query untuk mengambil data pemeriksaan dari tabel pem_cpu    
    $query_pemeriksaan = "SELECT pemeriksaan FROM pem_printer";
    $result_pemeriksaan = mysqli_query($connection, $query_pemeriksaan);

    // Periksa apakah kueri berhasil dieksekusi
    if ($result_pemeriksaan && mysqli_num_rows($result_pemeriksaan) > 0) {
      // Jumlah cekbox di setiap kolom
    $jumlah_kolom_1 = 7;
    $jumlah_kolom_2 = 7;
    $jumlah_kolom_3 = 7; // Sisa cekbox akan ditempatkan di kolom ketiga

    // Inisialisasi posisi X dan Y untuk setiap kolom
    $posX_kolom_1 = 5;
    $posY_kolom_1 = 75;
    $posX_kolom_2 = 70; // Posisi X untuk kolom kedua
    $posY_kolom_2 = 75;
    $posX_kolom_3 = 142; // Posisi X untuk kolom ketiga
    $posY_kolom_3 = 75;

        // Tampilkan opsi pemeriksaan dalam bentuk checkbox
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(0, 65); 
        $pdf->MultiCell(0, 10, 'PEMERIKSAAN AWAL(Trouble Shooting)', 0, 'C'); 

        $counter = 0;
        while ($rowPemeriksaan = mysqli_fetch_assoc($result_pemeriksaan)) {
            $pemeriksaan_option = $rowPemeriksaan['pemeriksaan'];
    
            // Tentukan posisi X dan Y berdasarkan counter
            if ($counter < $jumlah_kolom_1) {
                $posX = $posX_kolom_1;
                $posY = $posY_kolom_1;
                $posY_kolom_1 += 6; // Geser ke bawah untuk baris berikutnya di kolom pertama
            } elseif ($counter < ($jumlah_kolom_1 + $jumlah_kolom_2)) {
                $posX = $posX_kolom_2;
                $posY = $posY_kolom_2;
                $posY_kolom_2 += 6; // Geser ke bawah untuk baris berikutnya di kolom kedua
            } else {
                $posX = $posX_kolom_3;
                $posY = $posY_kolom_3;
                $posY_kolom_3 += 6; // Geser ke bawah untuk baris berikutnya di kolom ketiga
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



// Lakukan query untuk mengambil data kerusakan dari tabel ker_printer
$query_kerusakan    = "SELECT kerusakan FROM ker_printer";
$result_kerusakan   = mysqli_query($connection, $query_kerusakan);

// Periksa apakah kueri berhasil dieksekusi
if ($result_kerusakan && mysqli_num_rows($result_kerusakan) > 0) {
    $pdf->SetFont('Times', '', 12); // Atur font
    $pdf->SetXY(0, 117);; // Geser ke bawah sejauh 10 unit dari posisi terakhir
    $pdf->MultiCell(0, 15, 'IDENTIFIKASI KERUSAKAN', 0, 'C'); // Tambahkan teks

    // Jumlah cekbox di setiap kolom
    $jumlah_kolom_1 = 12;
    $jumlah_kolom_2 = 12;
    $jumlah_kolom_3 = 10; // Sisa cekbox akan ditempatkan di kolom ketiga

    // Inisialisasi posisi X dan Y untuk setiap kolom
    $posX_kolom_1 = 5;
    $posY_kolom_1 = 132;
    $posX_kolom_2 = 70; // Posisi X untuk kolom kedua
    $posY_kolom_2 = 132;
    $posX_kolom_3 = 142; // Posisi X untuk kolom ketiga
    $posY_kolom_3 = 132;

    $counter = 0;
    while ($rowKerusakan = mysqli_fetch_assoc($result_kerusakan)) {
        $kerusakan_option = $rowKerusakan['kerusakan'];

        // Tentukan posisi X dan Y berdasarkan counter
        if ($counter < $jumlah_kolom_1) {
            $posX = $posX_kolom_1;
            $posY = $posY_kolom_1;
            $posY_kolom_1 += 6; // Geser ke bawah untuk baris berikutnya di kolom pertama
        } elseif ($counter < ($jumlah_kolom_1 + $jumlah_kolom_2)) {
            $posX = $posX_kolom_2;
            $posY = $posY_kolom_2;
            $posY_kolom_2 += 6; // Geser ke bawah untuk baris berikutnya di kolom kedua
        } else {
            $posX = $posX_kolom_3;
            $posY = $posY_kolom_3;
            $posY_kolom_3 += 6; // Geser ke bawah untuk baris berikutnya di kolom ketiga
        }

        // Set posisi untuk menggambar cekbox dan teks label
        $pdf->SetXY($posX, $posY);

        // Buat kotak cekbox
        if (in_array($kerusakan_option, $kerusakan_values)) {
            // Jika ya, tandai cekbox dengan karakter Y
            $pdf->Cell(4, 4, 'Y', 1, 0, 'C');
        } else {
            // Jika tidak, biarkan cekbox kosong
            $pdf->Cell(4, 4, '', 1, 0, 'C');
        }

        // Tentukan posisi untuk teks label cekbox
        $pdf->SetXY($posX + 5, $posY - 1);
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
    $pdf->SetFont('Times', '', 12); // Atur font
    $pdf->SetXY(70, 236); // Geser ke bawah sejauh 10 unit dari posisi terakhir
    $pdf->MultiCell(0, 6, 'REKOMENDASI KERUSAKAN', 0, 'L'); // Tambahkan teks

    while ($rowRekomendasi = mysqli_fetch_assoc($result_rekomendasi)) {
        $rekomendasi_option = $rowRekomendasi['rekomendasi'];
        $pdf->SetX(73);
        
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

    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(12, 236);
    $pdf->Cell(0, 7, 'Petugas Pemeriksa', 0, 1);

    // Teks "Disposisi KABID PKAK"
    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(155, 236);
    $pdf->Cell(0, 7, 'Disposisi KABID PK&AK', 0, 1);
} else {
    die("Error fetching rekomendasi: " . mysqli_error($connection));
}

$pdf->Output();

?>
