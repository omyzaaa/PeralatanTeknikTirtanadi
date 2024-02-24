<!-- Modal Tambah Barang -->
<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="proses_perbaikan.php">
                    <div style="font-weight: bold;">Nama Barang</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <select name="nama_barang" class="form-control" required>
                            <?php
                            $resultJenisBarang = mysqli_query($connection, "SELECT * FROM jenis_barang");
                            while ($rowJenisBarang = mysqli_fetch_assoc($resultJenisBarang)) {
                                echo "<option value='" . $rowJenisBarang['nama_barang'] . "'>" . $rowJenisBarang['nama_barang'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Tambah inputan untuk SN -->
                    <div style="font-weight: bold;">SN</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <input type="text" name="sn" class="form-control" placeholder="SN" required>
                    </div>

                    <!-- Tambah inputan untuk Jenis -->
                    <div style="font-weight: bold;">Jenis</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <input type="text" name="jenis" class="form-control" placeholder="Jenis" required>
                    </div>

                    <div style="font-weight: bold;">Cabang/Unit kerja</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <select name="cabang" class="form-control" required>
                            <?php
                            $resultCabang = mysqli_query($connection, "SELECT * FROM cabang");
                            while ($rowCabang = mysqli_fetch_assoc($resultCabang)) {
                                echo "<option value='" . $rowCabang['cabang'] . "'>" . $rowCabang['cabang'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div style="font-weight: bold;">Tanggal surat</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <input type="date" name="tanggal_surat" class="form-control" required>
                    </div>
                    <div style="font-weight: bold;">Keterangan</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <textarea name="keterangan" class="form-control" placeholder="Keterangan" required></textarea>
                    </div>

                    <div style="font-weight: bold;">Pemeriksa</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <textarea name="pemeriksa" class="form-control" placeholder="Pemeriksa" required></textarea>
                    </div>

                    <div style="font-weight: bold;">Catatan</div>
                    <div class="input-group flex-nowrap mb-3 w-100">
                        <textarea name="catatan" class="form-control" placeholder="Catatan" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="btnTambahBarang" class="btn btn-primary">Tambah Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->

<div class="modal fade" id="editData<?php echo $id_proses; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit
                    Proses Perbaikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_proses" value="<?php echo $id_proses; ?>">
                    <div style="font-weight: bold;">SN</div>
<div class="input-group flex-nowrap mb-3 w-100">
    <input type="text" name="sn" class="form-control" placeholder="SN" value="<?php echo isset($sn) ? $sn : ''; ?>">
</div>

<div style="font-weight: bold;">Jenis</div>
<div class="input-group flex-nowrap mb-3 w-100">
    <input type="text" name="jenis" class="form-control" placeholder="Jenis" value="<?php echo isset($jenis) ? $jenis : ''; ?>">
</div>

<div style="font-weight: bold;">Cabang</div>
<div class="input-group flex-nowrap mb-3 w-100">
    <input type="text" name="cabang" class="form-control" placeholder="Cabang" value="<?php echo isset($cabang) ? $cabang : ''; ?>">
</div>

<div style="font-weight: bold;">Tanggal Surat</div>
<div class="input-group flex-nowrap mb-3 w-100">
    <input type="date" name="tanggal_surat" class="form-control" placeholder="Tanggal Surat" value="<?php echo isset($tanggal_surat) ? $tanggal_surat : ''; ?>">
</div>

<div style="font-weight: bold;">Keterangan</div>
<div class="input-group flex-nowrap mb-3 w-100">
    <textarea name="keterangan" class="form-control" placeholder="Keterangan"><?php echo isset($keterangan) ? $keterangan : ''; ?></textarea>
</div>

<div style="font-weight: bold;">Pemeriksa</div>
<div class="input-group flex-nowrap mb-3 w-100">
    <textarea name="pemeriksa" class="form-control" placeholder="Pemeriksa"><?php echo isset($pemeriksa) ? $pemeriksa : ''; ?></textarea>
</div>

<div style="font-weight: bold;">Catatan</div>
<div class="input-group flex-nowrap mb-3 w-100">
    <textarea name="catatan" class="form-control" placeholder="Catatan"><?php echo isset($catatan) ? $catatan : ''; ?></textarea>
</div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" name="btnEdit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--pemriksaan/kerusakan/rekomendasi -->

<div class="modal fade" id="pemeriksaanKerusakanModal<?php echo $id_proses; ?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content m-5 p-3">

            <form method="POST" action="proses_perbaikan.php">
                <input type="hidden" name="id_proses" value="<?php echo $id_proses; ?>">
                <?php
                // Ambil nama_barang dari data proses_perbaikan
                $nama_barang = $row['nama_barang'];

                // Tentukan nama tabel berdasarkan nama_barang
                switch ($nama_barang) {
                    case 'MONITOR':
                        $table_name_pemeriksaan = "pem_monitor";
                        $table_name_kerusakan = "ker_monitor";
                        break;
                    case 'CPU':
                        $table_name_pemeriksaan = "pem_cpu";
                        $table_name_kerusakan = "ker_cpu";
                        break;
                    case 'PRINTER':
                        $table_name_pemeriksaan = "pem_printer";
                        $table_name_kerusakan = "ker_printer";
                        break;
                    case 'UPS':
                        $table_name_pemeriksaan = "pem_ups";
                        $table_name_kerusakan = "ker_ups";
                        break;
                    default:
                        // Default jika nama_barang tidak sesuai
                        $table_name_pemeriksaan = ""; // Atau sesuaikan dengan tabel default jika ada
                        $table_name_kerusakan = "";
                }

                // Lakukan query hanya jika nama tabel sudah ditentukan
                if (!empty($table_name_pemeriksaan) && !empty($table_name_kerusakan)) {
                    $query_pemeriksaan = "SELECT * FROM $table_name_pemeriksaan";
                    $result_pemeriksaan = mysqli_query($connection, $query_pemeriksaan);

                    $query_kerusakan = "SELECT * FROM $table_name_kerusakan";
                    $result_kerusakan = mysqli_query($connection, $query_kerusakan);

                    // Tampilkan opsi pemeriksaan dalam bentuk checkbox
                    echo "<br><div class='text-center'><p>PEMERIKSAAN AWAL(Trouble Shooting)</p></div>";

                    // Inisialisasi variabel untuk menyimpan rentang pemeriksaan
                    $range_1_3 = "";
                    $range_4_11 = "";
                    $range_12_15 = "";
                    
                    while ($rowPemeriksaan = mysqli_fetch_assoc($result_pemeriksaan)) {
                        $id_pem_printer = $rowPemeriksaan['id_pem_printer'];
                        $pemeriksaan_option = $rowPemeriksaan['pemeriksaan'];
                    
                        // Mengelompokkan pemeriksaan berdasarkan rentang ID
                        if ($id_pem_printer >= 1 && $id_pem_printer <= 3) {
                            $range_1_3 .= "<div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='pemeriksaan[]' value='$pemeriksaan_option' " . (in_array($pemeriksaan_option, $pemeriksaan_values) ? 'checked' : '') . ">
                                                <label class='form-check-label'>$pemeriksaan_option</label>
                                            </div>";
                        } elseif ($id_pem_printer >= 4 && $id_pem_printer <= 11) {
                            $range_4_11 .= "<div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='pemeriksaan[]' value='$pemeriksaan_option' " . (in_array($pemeriksaan_option, $pemeriksaan_values) ? 'checked' : '') . ">
                                                <label class='form-check-label'>$pemeriksaan_option</label>
                                            </div>";
                        } elseif ($id_pem_printer >= 12 && $id_pem_printer <= 15) {
                            $range_12_15 .= "<div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='pemeriksaan[]' value='$pemeriksaan_option' " . (in_array($pemeriksaan_option, $pemeriksaan_values) ? 'checked' : '') . ">
                                                <label class='form-check-label'>$pemeriksaan_option</label>
                                            </div>";
                        }
                    }
                    
                    // Menampilkan hasil pengelompokkan
                    echo "<div><h4>Power Supply</h4>$range_1_3</div>";
                    echo "<div><h4>4-11</h4>$range_4_11</div>";
                    echo "<div><h4>12-15</h4>$range_12_15</div>";
                    
                    // Tampilkan opsi kerusakan dalam bentuk checkbox
                    echo "<div class='text-center'><br><p>IDENTIFIKASI KERUSAKAN HARDWARE</p></div>";
                    while ($rowKerusakan = mysqli_fetch_assoc($result_kerusakan)) {
                        $kerusakan_option = $rowKerusakan['kerusakan'];
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='kerusakan[]' value='$kerusakan_option' " . (in_array($kerusakan_option, $kerusakan_values) ? 'checked' : '') . ">
                                <label class='form-check-label'>$kerusakan_option</label>
                            </div>";
                    }

                }
                // Ambil rekomendasi dari data proses_perbaikan
                $query_proses_perbaikan = "SELECT rekomendasi FROM proses_perbaikan WHERE id_proses = $id_proses";
                $result_proses_perbaikan = mysqli_query($connection, $query_proses_perbaikan);
                $row_proses_perbaikan = mysqli_fetch_assoc($result_proses_perbaikan);
                $rekomendasi_values = explode(", ", $row_proses_perbaikan['rekomendasi']);

                // Lakukan query untuk mengambil opsi rekomendasi kerusakan dari tabel rekomendasi_ker
                $query_rekomendasi = "SELECT * FROM rekomendasi_ker";
                $result_rekomendasi = mysqli_query($connection, $query_rekomendasi);

                // Tampilkan opsi rekomendasi kerusakan dalam bentuk checkbox
                echo "<div class='text-center'><br><p>REKOMENDASI KERUSAKAN</p></div>";
                while ($rowRekomendasi = mysqli_fetch_assoc($result_rekomendasi)) {
                    $rekomendasi_option = $rowRekomendasi['rekomendasi'];
                    echo "<div class='form-check'>
            <input class='form-check-input' type='checkbox' name='rekomendasi[]' value='$rekomendasi_option'";
                    // Periksa apakah rekomendasi dipilih sebelumnya
                    if (in_array($rekomendasi_option, $rekomendasi_values)) {
                        echo " checked";
                    }
                    echo ">
            <label class='form-check-label'>$rekomendasi_option</label>
        </div>";
                }



                ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="btnSimpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Modal Realisasi Perbaikan -->
<div class="modal fade" id="realisasiModal<?php echo $id_proses; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Realisasi
                    Perbaikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRealisasi" method="POST" action="cetak/realisasi.php" target="_blank">
                    <input type="hidden" id="id_proses_modal">
                    <input type="hidden" name="id_proses" id="id_proses" value="">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly
                            value="<?php echo $nama_barang; ?>">
                    </div>
                    <div class="form-group">
                        <label for="sn">SN</label>
                        <input type="text" class="form-control" id="sn" name="sn" readonly value="<?php echo $sn; ?>">
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                            placeholder="Masukkan pekerjaan yang telah dilakukan">
                    </div>
                    <div class="form-group">
                        <label for="hasil">Hasil</label>
                        <input type="text" class="form-control" id="hasil" name="hasil"
                            placeholder="Masukkan hasil dari perbaikan">
                    </div>
                    <div class="form-group">
                        <label for="usul">Usul</label>
                        <input type="text" class="form-control" id="usul" name="usul"
                            placeholder="Masukkan usul perbaikan lanjutan">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="pkak" name="pkak" value="Y">
                            <label class="form-check-label" for="pkak">PKAK</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="pme" name="pme" value="Y">
                            <label class="form-check-label" for="pme">PME</label>
                        </div>
                    </div>

                    <!-- Tombol Simpan (untuk menyimpan data) -->

                    <button type="submit" class="btn btn-primary" id="btnSimpan" target="_blank">Simpan dan
                        Cetak</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tanda Terima -->
<div class="modal fade" id="tandaTerimaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tanda Terima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menampilkan informasi -->
                <form id="formTandaTerima" method="POST" action="cetak/tandaterima.php" target="_blank">

                    <div class="form-group">
                        <label for="nama_barang_terima">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang_terima" readonly>
                    </div>
                    <div class="form-group">
                        <label for="sn_terima">SN</label>
                        <input type="text" class="form-control" id="sn_terima" readonly>
                    </div>
                    <!-- Tambahan form input untuk informasi tanda terima lainnya -->
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" placeholder="Masukkan keterangan">
                    </div>
                    <!-- Tombol Simpan (untuk menyimpan data) -->
                    <button type="submit" class="btn btn-primary" id="btnSimpanTandaTerima">Simpan dan Cetak</button>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function Tandaterima(id_proses, nama_barang, sn) {
    $('#nama_barang_terima').val(nama_barang);
    $('#sn_terima').val(sn);
    $('#tandaTerimaModal').modal('show');
}

    </script>

<script>
    
    $(document).ready(function () {
        $('#pkak').change(function () {
            if ($(this).prop('checked')) {
                $(this).val('Y');
            } else {
                $(this).val('');
            }
        });

        $('#pme').change(function () {
            if ($(this).prop('checked')) {
                $(this).val('Y');
            } else {
                $(this).val('');
            }
        });
    });
</script>