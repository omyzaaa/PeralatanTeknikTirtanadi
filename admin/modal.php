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

                    <div style="font-weight: bold;">Cabang</div>
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