<?php

include "../fpdf/fpdf.php";
include "../function/connect.php";

$id_proses = isset($_GET['id_proses']) ? $_GET['id_proses'] : '';

class pdf extends FPDF
{

    function logo($gambar)
    {
        $this->Image($gambar, 15, 8, 38, 30);
    }

    function judul($teks1, $teks2)
    {
        // Membuat border untuk judul
        $this->Rect(10, 10, 190, 25);
        // Menempatkan teks judul di dalam border
        $this->SetFont('Times', 'B', '12');
        $this->SetXY(15, 8);
        $this->Cell(220, 15, $teks1, 0, 1, 'C');

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(15, 18);
        $this->Cell(220, 5, $teks2, 0, 1, 'C');
    }

    function customSection()
    {
        $this->Rect(10, 10, 50, 25);
    }
    function customSection2()
    {
        $this->Rect(10, 60, 190, 67);
    }
    function customSection3()
    {
        $this->Rect(10, 130, 190, 112);

    }
    function customSection4()
    {
        $this->Rect(10, 245, 190, 30);

    }
    function info($info1, $info2, $info3, $info4, $data)
    {

        $this->Rect(10, 38, 190, 19);

        $no_agenda = isset($data['no_agenda']) ? $data['no_agenda'] : 'Data tidak tersedia';
        $sn = isset($data['sn']) ? $data['sn'] : 'Data tidak tersedia';
        $cabang = isset($data['cabang']) ? $data['cabang'] : 'Data tidak tersedia';
        $jenis = isset($data['jenis']) ? $data['jenis'] : 'Data tidak tersedia';

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 36);
        $this->Cell(12, 10, $info1 . $no_agenda, 0, 1);

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 40);
        $this->Cell(12, 10, $info2 . $sn, 0, 1);

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 44);
        $this->Cell(12, 10, $info3 . $cabang, 0, 1);

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 48);
        $this->Cell(12, 10, $info4 . $jenis, 0, 1);
    }
}
$pdf = new pdf();
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 5); 
$pdf->AddPage('P', 'A4'); 

$pdf->logo('../image/logo.png');
$pdf->judul('IDENTIFIKASI KERUSAKAN', 'PRINTER');
$pdf->customSection();
$pdf->customSection2();
$pdf->customSection3();
$pdf->customSection4();
// Tangkap data dari database berdasarkan id_proses
$query = "SELECT * FROM proses_perbaikan WHERE id_proses = '$id_proses'";
$result = mysqli_query($connection, $query);

// Periksa apakah kueri berhasil dieksekusi
if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    $pdf->info(
        'No agenda                    : ',
        'SN                                 : ',
        'Unit kerja/Cabang      : ',
        'jenis                              : ',
        $data
    );

    // Gunakan data pemeriksaan dari database
    $pemeriksaan_values = explode(", ", $data['pemeriksaan']);
    $kerusakan_values = explode(", ", $data['kerusakan']);

    // Lakukan query untuk mengambil data pemeriksaan dari tabel pem_perinter
  // Lakukan query untuk mengambil data pemeriksaan dari tabel pem_perinter
$query_pemeriksaan = "SELECT pemeriksaan FROM pem_printer";
$result_pemeriksaan = mysqli_query($connection, $query_pemeriksaan);

// Periksa apakah kueri berhasil dieksekusi
if ($result_pemeriksaan && mysqli_num_rows($result_pemeriksaan) > 0) {
    // Tentukan posisi awal untuk kolom kanan dan kiri
    $posX_left = 16;
    $posY_left = 67;
    $posX_right = 110;
    $posY_right = 67;

    // Tampilkan opsi pemeriksaan dalam bentuk dua kolom
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY(65, 60);;
    $pdf->MultiCell(0, 6, 'PEMERIKSAAN AWAL(Trouble shooting)', 0, 'L');

    $counter = 0; // Inisialisasi hitungan baris
    while ($rowPemeriksaan = mysqli_fetch_assoc($result_pemeriksaan)) {
        $pemeriksaan_option = $rowPemeriksaan['pemeriksaan'];
        // Periksa apakah harus pindah ke kolom kanan
        if ($counter >= 10) {
            $posX = $posX_right;
            $posY = $posY_right;
            $posY_right += 6; // Geser ke bawah untuk baris berikutnya di kolom kanan
        } else {
            $posX = $posX_left;
            $posY = $posY_left;
            $posY_left += 6; // Geser ke bawah untuk baris berikutnya di kolom kiri
        }

        // Set posisi untuk teks label cekbox
        $pdf->SetXY($posX, $posY);
        // Periksa apakah pemeriksaan_option ada di dalam array pemeriksaan_values
        if (in_array($pemeriksaan_option, $pemeriksaan_values)) {
            // Jika ya, tandai cekbox dengan karakter X
            $pdf->Cell(4, 4, 'X', 1, 0, 'C');
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

// Lakukan query untuk mengambil data kerusakan dari tabel k// Lakukan query untuk mengambil data kerusakan dari tabel ker_printer
$query_kerusakan = "SELECT kerusakan FROM ker_printer";
$result_kerusakan = mysqli_query($connection, $query_kerusakan);

// Periksa apakah kueri berhasil dieksekusi
if ($result_kerusakan && mysqli_num_rows($result_kerusakan) > 0) {
    // Tentukan posisi awal untuk kolom kanan dan kiri
    $posX_left = 16;
    $posY_left = 135;
    $posX_right = 110;
    $posY_right = 135;

    // Tampilkan opsi kerusakan dalam bentuk dua kolom
    $pdf->SetFont('Times', '', 12); // Atur font
    $pdf->SetXY(75, 130);;
    $pdf->MultiCell(0, 6, 'IDENTIFIKASI KERUSAKAN', 0, 'L');

    $counter = 0; // Inisialisasi hitungan baris
    while ($rowKerusakan = mysqli_fetch_assoc($result_kerusakan)) {
        $kerusakan_option = $rowKerusakan['kerusakan'];

        // Periksa apakah harus pindah ke kolom kanan
        if ($counter >= 18) {
            $posX = $posX_right;
            $posY = $posY_right;
            $posY_right += 6; // Geser ke bawah untuk baris berikutnya di kolom kanan
        } else {
            $posX = $posX_left;
            $posY = $posY_left;
            $posY_left += 6; // Geser ke bawah untuk baris berikutnya di kolom kiri
        }

        // Set posisi untuk teks label cekbox
        $pdf->SetXY($posX, $posY);

        // Buat kotak cekbox
        if (in_array($kerusakan_option, $kerusakan_values)) {
            // Jika ya, tandai cekbox dengan karakter Y
            $pdf->Cell(4, 4, 'X', 1, 0, 'C');
        } else {
            // Jika tidak, biarkan cekbox kosong
            $pdf->Cell(4, 4, '', 1, 0, 'C');
        }

        // Tambahkan teks label
        $pdf->SetXY($posX + 7, $posY + -1);
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
    $pdf->SetXY(70, 246); // Geser ke bawah sejauh 10 unit dari posisi terakhir
    $pdf->MultiCell(0, 6, 'REKOMENDASI KERUSAKAN', 0, 'L'); // Tambahkan teks

    while ($rowRekomendasi = mysqli_fetch_assoc($result_rekomendasi)) {
        $rekomendasi_option = $rowRekomendasi['rekomendasi'];
        $pdf->SetX(85);
        
        // Buat kotak cekbox
        if (in_array($rekomendasi_option, $rekomendasi_values)) {
            // Jika ya, tandai cekbox dengan karakter Y
            $pdf->Cell(4, 4, 'X', 1, 0, 'C');
        } else {
            // Jika tidak, biarkan cekbox kosong
            $pdf->Cell(4, 4, '', 1, 0, 'C');
        }

        // Tentukan posisi untuk teks label cekbox
        $pdf->SetXY($pdf->GetX() + 1, $pdf->GetY()+ -1);
        $pdf->Cell(0, 7, $rekomendasi_option, 0, 1);

    }
    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(15, 245);
    $pdf->Cell(0, 7, 'Petugas Pemeriksa', 0, 1);

    // Teks "Disposisi KABID PKAK"
    $pdf->SetFont('Times', '', '12');
    $pdf->SetXY(147, 245);
    $pdf->Cell(0, 7, 'Disposisi KABID PKAK', 0, 1);
} else {
    die("Error fetching rekomendasi: " . mysqli_error($connection));
}




$pdf->output();

?>