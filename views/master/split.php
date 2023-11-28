<?php hakAkses(['admin', 'user']);

include('./config/conn.php');

?>

<script>
    $(document).ready(function() {
        // Menangani perubahan pada pilihan barang
        $('#deskripsi_budget').change(function() {
            var merekId = $(this).val(); // Mengambil nilai merek_id yang dipilih

            // Mengambil base URL secara dinamis
            var baseUrl = window.location.origin;

            // Mengirim permintaan AJAX
            $.ajax({
                type: 'POST',
                url: baseUrl + '/get_budget.php', // Menggunakan base URL
                data: {
                    merek_id: merekId
                },
                success: function(response) {
                    // Menetapkan nilai harga ke input dengan id 'price'
                    $('#price_budget').val(response);
                }
            });
        });
    });
</script>


<div class="container-fluid">


    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-center mb-4 text-center">

            <h1 class="h3 mb-0 text-gray-800 text-center">REQUEST SPLIT BUDGET <?= strtoupper($_SESSION['fullname']); ?></h1>

        </div>
        <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="form-group">


                        <div class="row">

                            <!-- form split budget -->

                            <!-- Kode budget -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="merek_id">Pilih barang :</label>
                                    <select class="form-control select2" type="text" name="atasan" id="deskripsi_budget" required>
                                        <?php

                                        // Menghubungkan ke database
                                        $koneksi = mysqli_connect("localhost", "root", "password", "inventaris");

                                        // Periksa koneksi
                                        if (!$koneksi) {
                                            die("Koneksi ke database gagal: " . mysqli_connect_error());
                                        }

                                        $sau = "SELECT * FROM prodev ORDER BY deskripsi ASC";
                                        $query2 = mysqli_query($con, "$sau") or die('mysql_error');

                                        // Loop melalui hasil query dan membuat pilihan dropdown
                                        echo '<option value="">-- Pilih Atasan --</option>';
                                        while ($user_data = mysqli_fetch_array($query2)) {
                                            echo '<option value="' . $user_data['deskripsi'] . '">' . $user_data['deskripsi'] . '</option>';
                                        }
                                        //
                                        echo 'error';

                                        // Tutup koneksi ke database
                                        mysqli_close($koneksi);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="merek_id">Split dengan :</label>
                                    <select name="kategori_id" id="barang2" class="form-select select2" style="width:100%;" hidden>
                                        <option value="">-- PILIH --</option>
                                        <?= aset_prodev(); ?>
                                    </select>
                                </div>
                            </div>

                            <!-- jumlah budget dan stok 1 -->
                            <div class="col-md-2">
                                <label for="deskripsi">BGT 1:</label>
                                <input width="20" type="text" class="form-control" name="price" id="price_budget" readonly>
                            </div>

                            <div class="col-md-2">
                                <label for="deskripsi">QTY 1:</label>
                                <input width="20" type="text" class="form-control" name="deskripsi" id="jab_atasan" readonly>
                            </div>

                            <!-- jumlah budget dan stok 2 -->
                            <div class="col-md-2" style="margin-left: 17%;">
                                <label for="deskripsi">BGT 2:</label>
                                <input width="20" type="number" class="form-control" name="deskripsi" id="deskripsi">
                            </div>

                            <div class="col-md-2">
                                <label for="deskripsi">QTY 2:</label>
                                <input width="20" type="number" class="form-control" name="deskripsi" id="deskripsi" readonly>
                            </div>


                            <!-- end form -->

                        </div>

                    </div>
                </div>

                <!-- ini nanti akan di ganti dengan get data dari excel -->

                <!-- // -->



                <!-- keterangan untuk split budget -->
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="keterangan">Keterangan (Wajib di isi) <span class="text-danger">*</span></label>
                        <textarea name="ket" id="ket" cols="30" rows="5" class="form-control" require></textarea>
                    </div>
                </div>

            </div>
            <hr class="sidebar-divider">

            <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                Split</button>

        </form>

    </div>
</div>