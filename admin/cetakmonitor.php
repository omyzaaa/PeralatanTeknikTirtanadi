<?php

include "../fpdf/fpdf.php";
include "../function/connect.php";

$id_proses = isset($_GET['id_proses']) ? $_GET['id_proses'] : '';

class pdf extends FPDF
{

    function logo($gambar)
    {
        $this->Image($gambar, 15, 17, 38, 30);
    }

    function judul($teks1, $teks2)
    {
        // Membuat border untuk judul
        $this->Rect(10, 20, 190, 25);
        // Menempatkan teks judul di dalam border
        $this->SetFont('Times', 'B', '12');
        $this->SetXY(15, 17);
        $this->Cell(220, 15, $teks1, 0, 1, 'C');

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(15, 27);
        $this->Cell(220, 5, $teks2, 0, 1, 'C');
    }

    function customSection()
    {
        $this->Rect(10, 20, 50, 25);
    }
    function customSection2()
    {
        $this->Rect(10, 70, 190, 75);
    }
    function customSection3()
    {
        $this->Rect(10, 148, 190, 50);

    }
    function customSection4()
    {
        $this->Rect(10, 201, 190, 70);

    }
    function info($info1, $info2, $info3, $info4, $data)
    {

        $this->Rect(10, 48, 190, 19);

        $no_agenda = isset($data['no_agenda']) ? $data['no_agenda'] : 'Data tidak tersedia';
        $sn = isset($data['sn']) ? $data['sn'] : 'Data tidak tersedia';
        $cabang = isset($data['cabang']) ? $data['cabang'] : 'Data tidak tersedia';
        $jenis = isset($data['jenis']) ? $data['jenis'] : 'Data tidak tersedia';

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 46);
        $this->Cell(12, 10, $info1 . $no_agenda, 0, 1);

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 50);
        $this->Cell(12, 10, $info2 . $sn, 0, 1);

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 54);
        $this->Cell(12, 10, $info3 . $cabang, 0, 1);

        $this->SetFont('Times', 'B', '12');
        $this->SetXY(11, 58);
        $this->Cell(12, 10, $info4 . $jenis, 0, 1);
    }
}

$pdf = new pdf(); // Membuat objek PDF
$pdf->SetMargins(10, 10, 10); // Mengatur margin
$pdf->SetAutoPageBreak(true, 5); // Mengatur page break
$pdf->AddPage('P', 'A4'); // Format ukuran kertas

// Memanggil fungsi logo, judul, dan customSection
$pdf->logo('../image/logo.png');
$pdf->judul('IDENTIFIKASI KERUSAKAN', 'MONITOR');
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

    // Lakukan query untuk mengambil data pemeriksaan dari tabel pem_monitor
    $query_pemeriksaan = "SELECT pemeriksaan FROM pem_monitor";
    $result_pemeriksaan = mysqli_query($connection, $query_pemeriksaan);

    // Periksa apakah kueri berhasil dieksekusi
    if ($result_pemeriksaan && mysqli_num_rows($result_pemeriksaan) > 0) {
        // Tampilkan opsi pemeriksaan dalam bentuk checkbox
        $pdf->SetFont('Times', '', 12); // Atur font
        $pdf->SetXY(70, 75); // Tentukan posisi X dan Y untuk menampilkan teks
        $pdf->MultiCell(0, 6, 'PEMERIKSAAN AWAL(Trouble Shooting)', 0, 'L'); // Tambahkan teks

        $counter = 0;
        $column = 0;
        while ($rowPemeriksaan = mysqli_fetch_assoc($result_pemeriksaan)) {
            $pemeriksaan_option = $rowPemeriksaan['pemeriksaan'];
            $pdf->SetX(11);

            // Tentukan posisi untuk teks label cekbox
            $pdf->SetXY($pdf->GetX() + 7, $pdf->GetY());

            // Periksa apakah pemeriksaan_option ada di dalam array pemeriksaan_values
            if (in_array($pemeriksaan_option, $pemeriksaan_values)) {
                // Jika ya, tandai cekbox dengan karakter X
                $pdf->Cell(4, 4, 'V', 1, 0, 'C');
            } else {
                // Jika tidak, biarkan cekbox kosong
                $pdf->Cell(4, 4, '', 1, 0, 'C');
            }
            // Tentukan posisi untuk teks label cekbox
            $pdf->SetXY($pdf->GetX() + 7, $pdf->GetY());
            $pdf->Cell(0, 6, $pemeriksaan_option, 0, 1);

        }
    } else {
        die("Error fetching pemeriksaan: " . mysqli_error($connection));
    }
} else {
    die("Error fetching data: " . mysqli_error($connection));
}

// Lakukan query untuk mengambil data kerusakan dari tabel ker_monitor
$query_kerusakan = "SELECT kerusakan FROM ker_monitor";
$result_kerusakan = mysqli_query($connection, $query_kerusakan);

// Periksa apakah kueri berhasil dieksekusi
if ($result_kerusakan && mysqli_num_rows($result_kerusakan) > 0) {
    // Tampilkan opsi kerusakan dalam bentuk checkbox
    $pdf->SetFont('Times', '', 12); // Atur font
    $pdf->SetXY(70, 152);; // Geser ke bawah sejauh 10 unit dari posisi terakhir
    $pdf->MultiCell(0, 6, 'IDENTIFIKASI KERUSAKAN', 0, 'L'); // Tambahkan teks

    while ($rowKerusakan = mysqli_fetch_assoc($result_kerusakan)) {
        $kerusakan_option = $rowKerusakan['kerusakan'];
        $pdf->SetX(18);

        // Buat kotak cekbox
        if (in_array($kerusakan_option, $kerusakan_values)) {
            // Jika ya, tandai cekbox dengan karakter X
            $pdf->Cell(4, 4, 'Y', 1, 0, 'C');
        } else {
            // Jika tidak, biarkan cekbox kosong
            $pdf->Cell(4, 4, '', 1, 0, 'C');
        }

        // Tentukan posisi untuk teks label cekbox
        $pdf->SetXY($pdf->GetX() + 7, $pdf->GetY());
        $pdf->Cell(0, 6, $kerusakan_option, 0, 1);

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
    $pdf->SetXY(70, 200); // Geser ke bawah sejauh 10 unit dari posisi terakhir
    $pdf->MultiCell(0, 6, 'REKOMENDASI KERUSAKAN', 0, 'L'); // Tambahkan teks

    while ($rowRekomendasi = mysqli_fetch_assoc($result_rekomendasi)) {
        $rekomendasi_option = $rowRekomendasi['rekomendasi'];
        $pdf->SetX(18);

        // Buat kotak cekbox
        if (in_array($rekomendasi_option, $rekomendasi_values)) {
            // Jika ya, tandai cekbox dengan karakter Y
            $pdf->Cell(4, 4, 'Y', 1, 0, 'C');
        } else {
            // Jika tidak, biarkan cekbox kosong
            $pdf->Cell(4, 4, '', 1, 0, 'C');
        }

        // Tentukan posisi untuk teks label cekbox
        $pdf->SetXY($pdf->GetX() + 7, $pdf->GetY());
        $pdf->Cell(0, 6, $rekomendasi_option, 0, 1);

    }
} else {
    die("Error fetching rekomendasi: " . mysqli_error($connection));
}


// Tentukan posisi horizontal untuk teks
$pdf->SetX(18);

$pdf->output();

?>
